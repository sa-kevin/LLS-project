<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class StorageHelper
{
    public static function getMinioUrl($path)
    {
        $minioUrl = Config::get('filesystems.disks.minio.url');
        $minioBucket = Config::get('filesystems.disks.minio.bucket');
        
        return "{$minioUrl}/{$minioBucket}/{$path}";
    }
}