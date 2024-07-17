<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use League\Csv\Reader;

class UploadController extends Controller
{
    public function show()
    {
        return Inertia::render('BookUpload', [
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
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

        $csv = Reader::createFromPath($file->getRealPath(), 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();
        $importedCount = 0;

        foreach ($records as $record) {
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
                if ($bookData['isbn'] && !Book::where('isbn', $bookData['isbn'])->exists()) {
                    Book::create($bookData);
                    $importedCount++;
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Failed to upload file: ' . $e->getMessage());
            }
        }

        try {
            Storage::disk('minio')->put('csv_imports', $file, $fileName);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to upload file to MinIO: ' . $e->getMessage());
        }
        return back()->with('success', "Imported $importedCount books successfully. File uploaded to MinIO.");
    }

}
