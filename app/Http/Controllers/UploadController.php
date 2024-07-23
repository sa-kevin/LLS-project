<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\OpenDBService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use League\Csv\Reader;

class UploadController extends Controller
{
    protected $openDBService;

    public function __construct(OpenDBService $openDBService)
    {
        $this->openDBService = $openDBService;
    }

    public function show()
    {
        return Inertia::render('BookUpload', [
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],
            'translations' => [
                'csv_title' => __('upload.csv_title'),
                'choose' => __('upload.choose'),
                'no_select' => __('upload.no_select'),
                'uploading' => __('upload.uploading'),
                'upload' => __('upload.upload'),
            ],
        ]);
    }
    public function uploadProcess(Request $request)
{
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt',
    ]);

    $file = $request->file('csv_file');
    $fileName = time() . '_' . $file->getClientOriginalName();

    try {
        $csv = Reader::createFromPath($file->getRealPath(), 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        $importedCount = 0;

        foreach ($records as $index => $record) {

            try {
                $bookData = [
                    'title' => $record['title'] ?? null,
                    'author' => $record['author'] ?? null,
                    'description' => $record['description'] ?? null,
                    'isbn' => $record['isbn'] ?? null,
                    'published_at' => null,
                ];

                if (!empty($record['published_at'])) {
                    $bookData['published_at'] = Carbon::parse($record['published_at'])->toDateString();
                }

                // Try to fetch cover image, but continue if it fails
                if (!empty($bookData['isbn'])) {
                    try {
                        $coverUrl = $this->openDBService->getCoverImage($bookData['isbn']);
                        if ($coverUrl) {
                            $coverPath = $this->openDBService->downloadAndStoreImage($coverUrl, $bookData['isbn']);
                            if ($coverPath) {
                                $bookData['cover_image'] = $coverPath;
                            }
                        }
                    } catch (\Exception $e) {
                        Log::warning("Failed to fetch or store cover image", ['isbn' => $bookData['isbn'], 'error' => $e->getMessage()]);
                        // Continue with book creation even if cover fetching fails
                    }
                }

                if ($bookData['isbn'] && !Book::where('isbn', $bookData['isbn'])->exists()) {
                    Book::create($bookData);
                    $importedCount++;
                    Log::info("Book created", ['isbn' => $bookData['isbn']]);
                } else {
                    Log::info("Book skipped (already exists or no ISBN)", ['isbn' => $bookData['isbn']]);
                }
            } catch (\Exception $e) {
                Log::error("Error processing record " . ($index + 1), ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                // Continue with next record even if this one fails
            }
        }

        try {
            Storage::disk('minio')->put('csv_imports/' . $fileName, file_get_contents($file));
        } catch (\Exception $e) {
            Log::error("Failed to upload file to MinIO", ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to upload file to MinIO: ' . $e->getMessage());
        }

        return back()->with('success', "Imported $importedCount books successfully. File uploaded to MinIO.");
    } catch (\Exception $e) {
        Log::error("Fatal error during upload process", ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return back()->with('error', 'Failed to process upload: ' . $e->getMessage());
    }
}

}
