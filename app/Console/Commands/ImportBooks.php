<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class ImportBooks extends Command
{
    
    protected $signature = 'books:import {file}';
    protected $description = 'Import books from a CSV file and upload to Minio';
    
    public function handle()
    {
        $fileName = $this->argument('file');
        $filePath = base_path($fileName);
        // $filePath = storage_path('app/' . $this->argument('file')); if the file is not in root.

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
                if ($bookData['isbn'] && Book::where('isbn', $bookData['isbn'])->exists()) {
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
        try {
            
            $this->info("Checking MinIO connection...");
            $files = Storage::disk('minio')->files('/');
            $this->info("Connection successful. Root directory contents: " . implode(', ', $files));
            
    

            $this->info("attempting to upload file to minio...");

            if (!file_exists($filePath)) {
                $this->error("File does not exist: {$filePath} ");
                return 1;
            }

            $fileContent = file_get_contents($filePath);

            if ($fileContent === false) {
                $this->error("Failed to read file contents");
                return 1;
            }

            $uploaded = Storage::disk('minio')->put('cvs_imports/' . $fileName, $fileContent);
    
            if ($uploaded) {
                $this->info("file uploaded to Mimio: csv_imports/{$fileName}");
            } else {
                $this->error("Failed to upload file to minio");
            }
        } catch (\Exception $e) {
            $this->error("error uploading file to minio:" . $e->getMessage());
            $this->error("Strack trace: " . $e->getTraceAsString());
        }

        return 0;
    }
}
