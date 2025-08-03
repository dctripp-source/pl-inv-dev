<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Exception;

class ImageUploadService
{
    protected $maxWidth = 1920;
    protected $maxHeight = 1080;
    protected $minFileSize = 200 * 1024; 
    protected $maxFileSize = 800 * 1024; 
    protected $quality = 85;
    protected $uploadPath = 'businesses'; 
    protected $imageManager;

    public function __construct()
    {

        $this->imageManager = new ImageManager(new Driver());
    }


    public function uploadBusinessImage(UploadedFile $file): string
    {
        $this->validateImage($file);
        
        $filename = $this->generateFilename($file);
        $fullPath = $this->uploadPath . '/' . $filename;
        
        $this->ensureDirectoryExists($this->uploadPath);
        
        $optimizedImageData = $this->optimizeImage($file);
        
        Storage::disk('public')->put($fullPath, $optimizedImageData);
        
        \Log::info("Business image uploaded: " . $fullPath);
        \Log::info("Storage path: " . storage_path('app/public/' . $fullPath));
        
        return $fullPath;
    }

    protected function optimizeImage(UploadedFile $file): string
    {

        $image = $this->imageManager->read($file->getRealPath());
        

        if ($image->width() > $this->maxWidth || $image->height() > $this->maxHeight) {
            $image->scale(
                width: $this->maxWidth,
                height: $this->maxHeight
            );
        }

        $quality = $this->quality;
        $imageData = null;
        
        do {

            $encoded = $image->toJpeg($quality);
            $imageData = (string) $encoded;
            $fileSize = strlen($imageData);
            
            if ($fileSize > $this->maxFileSize && $quality > 30) {
                $quality -= 5;
                continue;
            }
            
            if ($fileSize < $this->minFileSize && $quality < 95) {
                $quality += 5;
                continue;
            }
            
            break;
            
        } while ($quality >= 30 && $quality <= 95);
        
        return $imageData;
    }

    protected function generateFilename(UploadedFile $file): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $slug = Str::slug($originalName);
        $timestamp = time();
        $random = Str::random(8);
        
        return $slug . '_' . $timestamp . '_' . $random . '.jpg';
    }


    protected function validateImage(UploadedFile $file): void
    {
        if (!$file->isValid()) {
            throw new Exception('Uploadovan fajl nije valjan.');
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new Exception('Dozvoljeni su samo JPG, PNG i WebP fajlovi.');
        }

        if ($file->getSize() > 10 * 1024 * 1024) {
            throw new Exception('Fajl je prevelik. Maksimalno 10MB.');
        }

        $imageInfo = getimagesize($file->getRealPath());
        if ($imageInfo === false) {
            throw new Exception('Fajl nije validna slika.');
        }

        $width = $imageInfo[0];
        $height = $imageInfo[1];

        if ($width < 300 || $height < 300) {
            throw new Exception('Slika mora biti najmanje 300x300 piksela.');
        }
    }


    protected function ensureDirectoryExists(string $path): void
    {
        if (!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
            \Log::info("Created directory: " . $path);
        }
    }


    public function deleteImage(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            $deleted = Storage::disk('public')->delete($path);
            \Log::info("Deleted image: " . $path . " - Success: " . ($deleted ? 'YES' : 'NO'));
            return $deleted;
        }
        
        \Log::warning("Tried to delete non-existent image: " . $path);
        return false;
    }


    public function getImageUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }

    public function getImageInfo(string $path): array
    {
        if (!Storage::disk('public')->exists($path)) {
            return [];
        }

        $fullPath = storage_path('app/public/' . $path);
        
        try {
            $imageInfo = getimagesize($fullPath);
            $fileSize = filesize($fullPath);

            return [
                'width' => $imageInfo[0] ?? null,
                'height' => $imageInfo[1] ?? null,
                'size' => $fileSize,
                'size_formatted' => $this->formatBytes($fileSize),
                'url' => $this->getImageUrl($path)
            ];
        } catch (\Exception $e) {
            \Log::error("Error getting image info for {$path}: " . $e->getMessage());
            return [];
        }
    }


    protected function formatBytes(int $size, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }


    public function createThumbnail(string $imagePath, int $width = 300, int $height = 300): string
    {
        if (!Storage::disk('public')->exists($imagePath)) {
            throw new Exception('Original image not found');
        }

        $fullPath = storage_path('app/public/' . $imagePath);
        $image = $this->imageManager->read($fullPath);
        
        $thumbnail = $image->cover($width, $height);
        
        $pathInfo = pathinfo($imagePath);
        $thumbnailPath = $pathInfo['dirname'] . '/thumb_' . $pathInfo['basename'];
        
        $thumbnailData = (string) $thumbnail->toJpeg(80);
        Storage::disk('public')->put($thumbnailPath, $thumbnailData);
        
        return $thumbnailPath;
    }
}