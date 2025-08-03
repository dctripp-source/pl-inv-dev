<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageOptimizationService
{
    protected $maxWidth = 1920;
    protected $maxHeight = 1080;
    protected $minFileSize = 200 * 1024; // 200KB
    protected $maxFileSize = 700 * 1024; // 700KB
    protected $quality = 85;
    protected $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Optimize business image and save to storage
     */
    public function optimizeBusinessImage(UploadedFile $file): string
    {
        // Generate unique filename
        $filename = $this->generateFilename($file);
        
        $path = 'businesses/' . $filename;
        
        $image = $this->imageManager->read($file->getRealPath());
        
        // Resize if too large
        if ($image->width() > $this->maxWidth || $image->height() > $this->maxHeight) {
            $image->scale(
                width: $this->maxWidth,
                height: $this->maxHeight
            );
        }
        
        // Start with initial quality
        $quality = $this->quality;
        $imageData = null;
        
        // Optimize until file size is within range
        do {
            // Apply quality setting usando novo API
            $encoded = $image->toJpeg($quality);
            $imageData = (string) $encoded;
            $fileSize = strlen($imageData);
            
            // If file is too large, reduce quality
            if ($fileSize > $this->maxFileSize && $quality > 20) {
                $quality -= 5;
                continue;
            }
            
            // If file is too small and quality can be increased
            if ($fileSize < $this->minFileSize && $quality < 95) {
                $quality += 5;
                continue;
            }
            
            break;
            
        } while ($quality >= 20 && $quality <= 95);
        
        $directory = dirname($path);
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
        
        // Save optimized image
        Storage::disk('public')->put($path, $imageData);
        
        \Log::info("Image saved to: " . $path);
        \Log::info("Full path: " . storage_path('app/public/' . $path));
        \Log::info("File exists after save: " . (Storage::disk('public')->exists($path) ? 'YES' : 'NO'));
        
        return $path;
    }
    
    /**
     * Optimize multiple images
     */
    public function optimizeMultipleImages(array $files): array
    {
        $optimizedPaths = [];
        
        foreach ($files as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                try {
                    $optimizedPaths[] = $this->optimizeBusinessImage($file);
                } catch (\Exception $e) {
                    \Log::error("Failed to optimize image: " . $e->getMessage());
                    continue;
                }
            }
        }
        
        return $optimizedPaths;
    }
    
    /**
     * Generate unique filename
     */
    protected function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $name = Str::slug($name);
        
        return $name . '_' . time() . '_' . Str::random(8) . '.jpg';
    }
    
    /**
     * Delete image from storage
     */
    public function deleteImage(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        
        return false;
    }
    
    /**
     * Get optimized image URL
     */
    public function getImageUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }
    
    /**
     * Validate image file
     */
    public function validateImage(UploadedFile $file): array
    {
        $errors = [];
        
        // Check if it's an image
        if (!$file->isValid()) {
            $errors[] = 'Fajl nije valjan.';
            return $errors;
        }
        
        // Check file type
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            $errors[] = 'Dozvoljena su samo JPG, PNG i WebP slike.';
        }
        
        // Check file size (max 10MB before optimization)
        if ($file->getSize() > 10 * 1024 * 1024) {
            $errors[] = 'Slika je prevelika. Maksimalna veličina je 10MB.';
        }
        
        // Check image dimensions
        try {
            $imageInfo = getimagesize($file->getRealPath());
            if ($imageInfo === false) {
                $errors[] = 'Fajl nije validna slika.';
            } else {
                $width = $imageInfo[0];
                $height = $imageInfo[1];
                
                // Minimum dimensions
                if ($width < 300 || $height < 300) {
                    $errors[] = 'Slika mora biti najmanje 300x300 piksela.';
                }
            }
        } catch (\Exception $e) {
            $errors[] = 'Greška pri čitanju slike.';
        }
        
        return $errors;
    }
    
    /**
     * Create thumbnail
     */
    public function createThumbnail(string $imagePath, int $width = 300, int $height = 300): string
    {
        if (!Storage::disk('public')->exists($imagePath)) {
            throw new \Exception('Original image not found');
        }

        $fullPath = storage_path('app/public/' . $imagePath);
        $image = $this->imageManager->read($fullPath);
        
        // Create thumbnail
        $thumbnail = $image->cover($width, $height);
        
        // Generate thumbnail path
        $pathInfo = pathinfo($imagePath);
        $thumbnailPath = $pathInfo['dirname'] . '/thumb_' . $pathInfo['basename'];
        
        // Save thumbnail
        $thumbnailData = (string) $thumbnail->toJpeg(80);
        Storage::disk('public')->put($thumbnailPath, $thumbnailData);
        
        return $thumbnailPath;
    }
}