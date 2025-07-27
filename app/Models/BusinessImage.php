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

    // Релација са Business
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // Accessor за full URL
    public function getFullUrlAttribute()
    {
        if (!$this->image_path) {
            return null;
        }

        // Провери да ли фајл постоји
        if (!Storage::disk('public')->exists($this->image_path)) {
            \Log::warning("Image file not found: " . $this->image_path);
            return asset('images/placeholder-business.jpg'); // fallback слика
        }

        return Storage::disk('public')->url($this->image_path);
    }

    // Accessor за thumbnail URL (ако требаш)
    public function getThumbnailUrlAttribute()
    {
        return $this->getFullUrlAttribute(); // За сада исто као full URL
    }

    // Scope за primary слике
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    // Scope за сортирање
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    // Boot метод за аутоматске операције
    protected static function boot()
    {
        parent::boot();

        // Када се обрише слика, обриши и фајл
        static::deleting(function ($image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        });

        // Када се сними као primary, уклони primary са других
        static::saving(function ($image) {
            if ($image->is_primary) {
                static::where('business_id', $image->business_id)
                      ->where('id', '!=', $image->id)
                      ->update(['is_primary' => false]);
            }
        });
    }
}