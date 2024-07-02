<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Minio\Client as MinioClient;

class ImportBooks extends Command
{
    
    protected $signature = 'books:import';
    protected $description = 'Import books from a CSV file stored in Minio';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        $minioClient = new MinioClient([]);
    }
}
