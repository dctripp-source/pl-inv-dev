<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageOptimizationService
{
    protected $maxWidth = 1920;
    protected $maxHeight = 1080;
    protected $minFileSize = 200 * 1024; // 200KB
    protected $maxFileSize = 700 * 1024; // 700KB
    protected $quality = 85;

    /**
     * Optimize business image and save to storage
     */
    public function optimizeBusinessImage(UploadedFile $file): string
    {
        // Generate unique filename
        $filename = $this->generateFilename($file);
        
        // ПРОМЕЊЕНО: Користи businesses/ као постојеће слике
        $path = 'businesses/' . $filename;
        
        // Create optimized image
        $image = Image::make($file);
        
        // Resize if too large
        if ($image->width() > $this->maxWidth || $image->height() > $this->maxHeight) {
            $image->resize($this->maxWidth, $this->maxHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }
        
        // Start with initial quality
        $quality = $this->quality;
        $optimizedImage = null;
        
        // Optimize until file size is within range
        do {
            $optimizedImage = clone $image;
            
            // Apply quality setting
            $imageData = $optimizedImage->encode('jpg', $quality)->getEncoded();
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
        
        // ПРОМЕЊЕНО: Креирај businesses директоријум ако не постоји
        $directory = dirname($path);
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
        
        // Save optimized image
        Storage::disk('public')->put($path, $imageData);
        
        // ДОДАТО: Log за debug
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
        
        // ПРОМЕЊЕНО: Користи .jpg увек за консистентност
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
                
                // Maximum dimensions before optimization
                if ($width > 5000 || $height > 5000) {
                    $errors[] = 'Slika je prevelika. Maksimalne dimenzije su 5000x5000 piksela.';
                }
            }
        } catch (\Exception $e) {
            $errors[] = 'Greška pri obradi slike.';
        }
        
        return $errors;
    }
    
    /**
     * Batch validate images
     */
    public function validateImages(array $files): array
    {
        $allErrors = [];
        
        if (count($files) > 5) {
            $allErrors[] = 'Možete otpremiti maksimalno 5 slika.';
        }
        
        foreach ($files as $index => $file) {
            if ($file instanceof UploadedFile) {
                $errors = $this->validateImage($file);
                if (!empty($errors)) {
                    $fileName = $file->getClientOriginalName();
                    $allErrors[] = "Slika '{$fileName}': " . implode(', ', $errors);
                }
            }
        }
        
        return $allErrors;
    }
}