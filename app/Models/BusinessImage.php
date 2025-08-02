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

    /**
     * Relacija sa Business modelom
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * URL slike
     */
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

    /**
     * Full URL slike (za backward compatibility)
     */
    public function getFullUrlAttribute()
    {
        return $this->url;
    }

    /**
     * Placeholder slika
     */
    protected function getPlaceholderUrl()
    {
        return asset('images/placeholder-business.jpg');
    }

    /**
     * Dobij informacije o slici
     */
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

    /**
     * Postavi kao glavnu sliku
     */
    public function setAsPrimary()
    {
        // Ukloni primary sa ostalih slika istog biznisa
        static::where('business_id', $this->business_id)
              ->where('id', '!=', $this->id)
              ->update(['is_primary' => false]);

        // Postavi ovu kao glavnu
        $this->update(['is_primary' => true]);

        return $this;
    }

    /**
     * Boot model events
     */
    protected static function boot()
    {
        parent::boot();

        // Kada se kreira nova slika
        static::creating(function ($image) {
            // Ako nema sort_order, stavi na kraj
            if (is_null($image->sort_order)) {
                $maxOrder = static::forBusiness($image->business_id)->max('sort_order') ?? -1;
                $image->sort_order = $maxOrder + 1;
            }

            // Ako je prva slika za biznis, automatski je glavna
            if (!static::forBusiness($image->business_id)->exists()) {
                $image->is_primary = true;
            }
        });

        // Kada se briše slika
        static::deleting(function ($image) {
            // Obriši fizički fajl
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }

            // Ako je bila glavna slika, postavi drugu kao glavnu
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

        // Kada se postavlja kao glavna slika
        static::saving(function ($image) {
            if ($image->is_primary && $image->isDirty('is_primary')) {
                // Ukloni primary sa ostalih slika
                static::where('business_id', $image->business_id)
                      ->where('id', '!=', $image->id)
                      ->update(['is_primary' => false]);
            }
        });
    }
}