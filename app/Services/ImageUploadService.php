<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Exception;

class ImageUploadService
{
    protected $maxWidth = 1920;
    protected $maxHeight = 1080;
    protected $minFileSize = 200 * 1024; // 200KB
    protected $maxFileSize = 800 * 1024; // 800KB
    protected $quality = 85;
    protected $uploadPath = 'businesses'; // /storage/public/businesses/

    /**
     * Upload i optimizuj sliku biznisa
     */
    public function uploadBusinessImage(UploadedFile $file): string
    {
        $this->validateImage($file);
        
        $filename = $this->generateFilename($file);
        $fullPath = $this->uploadPath . '/' . $filename;
        
        $this->ensureDirectoryExists($this->uploadPath);
        
        $optimizedImageData = $this->optimizeImage($file);
        
        Storage::disk('public')->put($fullPath, $optimizedImageData);
        
        \Log::info("Business image uploaded: " . $fullPath);
        
        return $fullPath;
    }

    /**
     * Optimizuj sliku
     */
    protected function optimizeImage(UploadedFile $file): string
    {
        $image = Image::make($file->getRealPath());
        
        // Resize ako je prevelika
        if ($image->width() > $this->maxWidth || $image->height() > $this->maxHeight) {
            $image->resize($this->maxWidth, $this->maxHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }
        
        // Optimizuj kvalitet
        $quality = $this->quality;
        $imageData = null;
        
        do {
            $imageData = $image->encode('jpg', $quality)->getEncoded();
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

    /**
     * Generiši unique filename
     */
    protected function generateFilename(UploadedFile $file): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $slug = Str::slug($originalName);
        $timestamp = time();
        $random = Str::random(8);
        
        return $slug . '_' . $timestamp . '_' . $random . '.jpg';
    }

    /**
     * Validuj upload fajl
     */
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

    /**
     * Kreiraj direktorijum ako ne postoji
     */
    protected function ensureDirectoryExists(string $path): void
    {
        if (!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }
    }

    /**
     * Obriši sliku
     */
    public function deleteImage(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        
        return false;
    }

    /**
     * Dobij URL slike
     */
    public function getImageUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }

    /**
     * Dobij informacije o slici
     */
    public function getImageInfo(string $path): array
    {
        if (!Storage::disk('public')->exists($path)) {
            return [];
        }

        $fullPath = storage_path('app/public/' . $path);
        $imageInfo = getimagesize($fullPath);
        $fileSize = filesize($fullPath);

        return [
            'width' => $imageInfo[0] ?? null,
            'height' => $imageInfo[1] ?? null,
            'size' => $fileSize,
            'size_formatted' => $this->formatBytes($fileSize),
            'url' => $this->getImageUrl($path)
        ];
    }

    /**
     * Format file size
     */
    protected function formatBytes(int $size, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }
}