<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class ImportBooks extends Command
{
    
    protected $signature = 'books:import {files}';
    protected $description = 'Import books from a CSV file and upload to Minio';
    
    public function handle()
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)){
            $this->error('File not found: {$filePath}');
            return 1;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        foreach ($records as $record) {
            try {
                $bookData = [
                    'title' => $record['title'] ?? null,
                    'author' => $record['author'] ?? null,
                    'description' => $record['description'] ?? null,
                    'isbn' => $record['isbn'] ?? null,
                    'published_at' => null,
                ];

                // handle published_date
                if (!empty($record['published_at'])) {
                    try {
                        $bookData['published_at'] = Carbon::parse($record['published_at'])->toDateString();
                    } catch (\Exception $e) {
                        $this->warn("Invalid date format for book '{$bookData['title']}': {$record['published_at']}");
                    }
                }

                // ISBN uniqueness
                if ($bookData['isbn'] && Book::where('isbn', $bookData['isbn'])->exist()) {
                    $this->warn("Book with ISBN {$bookData['isbn']} already exists. Skipping. ");
                    continue;
                }

                // create record
                $book = Book::create($bookData);

                $this->info("Processed book: 1book->title");
            } catch (\Exception $e) {
                $this->error("Error processing record: " . $e->getMessage());
            }
        }

        // upload to Minio
        $fileName = basename($filePath);
        $uploaded = Storage::disk('s3')->putFileAs('cvs_imports', $filePath, $fileName);

        if ($uploaded) {
            $this->info("file uploaded to Mimio: {$fileName}");
        } else {
            $this->error("Failed to upload file to minio");
        }

        return 0;
    }
}
