<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OpenDBService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.google_books.api_key');
    }


    public function getCoverImage($isbn)
    {
        Log::info("Attempting to fetch cover image for ISBN: $isbn");
        
        $url = "https://www.googleapis.com/books/v1/volumes?q=isbn:{$isbn}&key={$this->apiKey}";
        
        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();

                Log::info("Full API response for ISBN $isbn: " . json_encode($data));
                
            
                // if (!empty($data['items'][0]['volumeInfo']['imageLinks']['thumbnail'])) {
                //     $coverUrl = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
                //     Log::info("Cover image URL found for ISBN $isbn: $coverUrl");

                //     $imageLinks = $data['items'][0]['volumeInfo']['imageLinks'];
                //     Log::info("Image links found for ISBN $isbn: " . json_encode($imageLinks));
                //     return $coverUrl;

                if(!empty($data['items'][0]['volumeInfo']['imageLinks'])) {
                    $imageLinks = $data['items'][0]['volumeInfo']['imageLinks'];
                    Log::info("Image links found for ISBN $isbn: " . json_encode($imageLinks));

                    $imageSizes = ['thumnail', 'smallThumbnail', 'small', 'medium', 'large', 'extraLarge'];

                    foreach ($imageSizes as $size) {
                        if (!empty($imageLinks[$size])) {
                            $coverUrl = $imageLinks[$size];
                            Log::info("Cover image URL found for ISBN $isbn: $coverUrl");
                            return $coverUrl;
                        }
                    }

                } else {
                    Log::warning("No cover image found in the response for ISBN: $isbn");
                }
            } else {
                Log::error("Failed to fetch data for ISBN $isbn. Status: " . $response->status());
            }
        } catch (\Exception $e) {
            Log::error("Exception occurred while fetching cover image for ISBN $isbn: " . $e->getMessage());
        }
        
        return null;
    }


    public function downloadAndStoreImage($url, $isbn)
    {
        Log::info("Attempting to download and store image for ISBN: $isbn, URL: $url");
        
        try {
            $content = file_get_contents($url);
            
            if ($content === false) {
                Log::error("Failed to download image from URL: $url");
                return null;
            }
            
            $filename = 'book_' . $isbn . '_cover.jpg';
            $result = Storage::disk('minio')->put($filename, $content);
            
            if ($result) {
                Log::info("Successfully stored image for ISBN $isbn: $filename");
                return $filename;
            } else {
                Log::error("Failed to store image in MinIO for ISBN $isbn");
            }
        } catch (\Exception $e) {
            Log::error("Exception occurred while downloading and storing image for ISBN $isbn: " . $e->getMessage());
        }
        
        return null;
    }
}