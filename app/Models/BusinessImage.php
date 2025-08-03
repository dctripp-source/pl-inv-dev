<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BusinessImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'image_path',
        'alt_text',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    protected $appends = [
        'url',
        'full_url'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function getUrlAttribute()
    {
        if (!$this->image_path) {
            return $this->getPlaceholderUrl();
        }

        if (!Storage::disk('public')->exists($this->image_path)) {
            \Log::warning("Business image not found: " . $this->image_path);
            return $this->getPlaceholderUrl();
        }

        return Storage::disk('public')->url($this->image_path);
    }

    public function getFullUrlAttribute()
    {
        return $this->url;
    }

    protected function getPlaceholderUrl()
    {
        return asset('images/placeholder-business.jpg');
    }

    public function getImageInfo()
    {
        if (!$this->image_path || !Storage::disk('public')->exists($this->image_path)) {
            return null;
        }

        $fullPath = storage_path('app/public/' . $this->image_path);
        
        try {
            $imageInfo = getimagesize($fullPath);
            $fileSize = filesize($fullPath);

            return [
                'width' => $imageInfo[0] ?? null,
                'height' => $imageInfo[1] ?? null,
                'size' => $fileSize,
                'size_formatted' => $this->formatBytes($fileSize),
                'mime_type' => $imageInfo['mime'] ?? null
            ];
        } catch (\Exception $e) {
            \Log::error("Error getting image info for {$this->image_path}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Format file size
     */
    protected function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }

    /**
     * Scope za glavne slike
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope za sortiranje
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    /**
     * Scope za određeni biznis
     */
    public function scopeForBusiness($query, $businessId)
    {
        return $query->where('business_id', $businessId);
    }


    public function setAsPrimary()
    {

        static::where('business_id', $this->business_id)
              ->where('id', '!=', $this->id)
              ->update(['is_primary' => false]);


        $this->update(['is_primary' => true]);

        return $this;
    }

    /**
     * Boot model events
     */
    protected static function boot()
    {
        parent::boot();


        static::creating(function ($image) {

            if (is_null($image->sort_order)) {
                $maxOrder = static::forBusiness($image->business_id)->max('sort_order') ?? -1;
                $image->sort_order = $maxOrder + 1;
            }

            if (!static::forBusiness($image->business_id)->exists()) {
                $image->is_primary = true;
            }
        });


        static::deleting(function ($image) {

            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }

            if ($image->is_primary) {
                $nextImage = static::forBusiness($image->business_id)
                                   ->where('id', '!=', $image->id)
                                   ->ordered()
                                   ->first();
                                   
                if ($nextImage) {
                    $nextImage->update(['is_primary' => true]);
                }
            }
        });

        static::saving(function ($image) {
            if ($image->is_primary && $image->isDirty('is_primary')) {
                static::where('business_id', $image->business_id)
                      ->where('id', '!=', $image->id)
                      ->update(['is_primary' => false]);
            }
        });
    }
}