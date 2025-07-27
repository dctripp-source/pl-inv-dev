<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function optimizeBusinessImage($imagePath)
    {
        if (!Storage::disk('public')->exists($imagePath)) {
            return null;
        }
        
        $fullPath = storage_path('app/public/' . $imagePath);
        
        // Create optimized version if it doesn't exist
        $optimizedPath = str_replace('.', '_optimized.', $imagePath);
        $optimizedFullPath = storage_path('app/public/' . $optimizedPath);
        
        if (!file_exists($optimizedFullPath)) {
            $image = Image::make($fullPath)
                          ->resize(800, 600, function ($constraint) {
                              $constraint->aspectRatio();
                              $constraint->upsize();
                          })
                          ->encode('jpg', 85);
                          
            $image->save($optimizedFullPath);
        }
        
        return Storage::url($optimizedPath);
    }
}