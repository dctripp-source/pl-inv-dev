<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Services\SerbianTransliterator;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_first_name',
        'owner_first_name_latin',
        'owner_first_name_cyrillic',
        'owner_last_name',
        'owner_last_name_latin',
        'owner_last_name_cyrillic',
        'business_name',
        'business_name_latin',
        'business_name_cyrillic',
        'slug',
        'description',
        'description_latin',
        'description_cyrillic',
        'services',
        'services_latin',
        'services_cyrillic',
        'phone',
        'email',
        'address',
        'address_latin',
        'address_cyrillic',
        'city',
        'city_latin',
        'city_cyrillic',
        'website',
        'social_media',
        'status',
        'admin_notes',
        'working_hours'
    ];

    protected $casts = [
        'social_media' => 'array',
        'approved_at' => 'datetime',
    ];

    // Boot metode za auto-generiranje transliteracija
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($business) {
            if (!$business->slug) {
                $business->slug = Str::slug($business->business_name);
            }
            $business->generateTransliterations();
        });
        
        static::updating(function ($business) {
            if ($business->isDirty('business_name') && !$business->isDirty('slug')) {
                $business->slug = Str::slug($business->business_name);
            }
            
            if ($business->isDirty([
                'owner_first_name', 'owner_last_name', 'business_name', 
                'description', 'services', 'address', 'city'
            ])) {
                $business->generateTransliterations();
            }
        });
    }

    // Generiši transliteracije
    public function generateTransliterations()
    {
        // Owner names
        if ($this->owner_first_name) {
            $scripts = SerbianTransliterator::generateBothScripts($this->owner_first_name);
            $this->owner_first_name_latin = $scripts['latin'];
            $this->owner_first_name_cyrillic = $scripts['cyrillic'];
        }

        if ($this->owner_last_name) {
            $scripts = SerbianTransliterator::generateBothScripts($this->owner_last_name);
            $this->owner_last_name_latin = $scripts['latin'];
            $this->owner_last_name_cyrillic = $scripts['cyrillic'];
        }

        // Business fields
        if ($this->business_name) {
            $scripts = SerbianTransliterator::generateBothScripts($this->business_name);
            $this->business_name_latin = $scripts['latin'];
            $this->business_name_cyrillic = $scripts['cyrillic'];
        }

        if ($this->description) {
            $scripts = SerbianTransliterator::generateBothScripts($this->description);
            $this->description_latin = $scripts['latin'];
            $this->description_cyrillic = $scripts['cyrillic'];
        }

        if ($this->services) {
            $scripts = SerbianTransliterator::generateBothScripts($this->services);
            $this->services_latin = $scripts['latin'];
            $this->services_cyrillic = $scripts['cyrillic'];
        }

        if ($this->address) {
            $scripts = SerbianTransliterator::generateBothScripts($this->address);
            $this->address_latin = $scripts['latin'];
            $this->address_cyrillic = $scripts['cyrillic'];
        }

        if ($this->city) {
            $scripts = SerbianTransliterator::generateBothScripts($this->city);
            $this->city_latin = $scripts['latin'];
            $this->city_cyrillic = $scripts['cyrillic'];
        }
    }

    // RELACIJE
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'business_categories');
    }

    public function images()
    {
        return $this->hasMany(BusinessImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(BusinessImage::class)->where('is_primary', true);
    }

    public function secondaryImages()
    {
        return $this->hasMany(BusinessImage::class)
                    ->where('is_primary', false)
                    ->orderBy('sort_order');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // SCOPES
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // ACCESSORS
    public function getFullOwnerNameAttribute()
    {
        return $this->owner_first_name . ' ' . $this->owner_last_name;
    }

    /**
     * Accessor za URL glavne slike
     */
    public function getPrimaryImageUrlAttribute()
    {
        $primaryImage = $this->primaryImage;
        
        if ($primaryImage && $primaryImage->image_path) {
            return $primaryImage->url;
        }
        
        // Fallback - prva slika ako nema primary
        $firstImage = $this->images()->first();
        if ($firstImage) {
            return $firstImage->url;
        }
        
        // Placeholder slika
        return asset('images/placeholder-business.jpg');
    }

    /**
     * Accessor za sve URLs slika
     */
    public function getImageUrlsAttribute()
    {
        return $this->images->map(function ($image) {
            return $image->url;
        })->toArray();
    }

    /**
     * Broj slika
     */
    public function getImagesCountAttribute()
    {
        return $this->images()->count();
    }

    // TRANSLITERATIONS
    public function getDisplayName($script = 'latin')
    {
        if ($script === 'cyrillic') {
            return $this->business_name_cyrillic ?: $this->business_name;
        }
        return $this->business_name_latin ?: $this->business_name;
    }

    public function getDisplayDescription($script = 'latin')
    {
        if ($script === 'cyrillic') {
            return $this->description_cyrillic ?: $this->description;
        }
        return $this->description_latin ?: $this->description;
    }

    public function getDisplayServices($script = 'latin')
    {
        if ($script === 'cyrillic') {
            return $this->services_cyrillic ?: $this->services;
        }
        return $this->services_latin ?: $this->services;
    }

    public function getDisplayAddress($script = 'latin')
    {
        if ($script === 'cyrillic') {
            return $this->address_cyrillic ?: $this->address;
        }
        return $this->address_latin ?: $this->address;
    }

    public function getDisplayCity($script = 'latin')
    {
        if ($script === 'cyrillic') {
            return $this->city_cyrillic ?: $this->city;
        }
        return $this->city_latin ?: $this->city;
    }

    public function getDisplayOwnerName($script = 'latin')
    {
        $firstName = $script === 'cyrillic' 
            ? ($this->owner_first_name_cyrillic ?: $this->owner_first_name)
            : ($this->owner_first_name_latin ?: $this->owner_first_name);
            
        $lastName = $script === 'cyrillic'
            ? ($this->owner_last_name_cyrillic ?: $this->owner_last_name) 
            : ($this->owner_last_name_latin ?: $this->owner_last_name);
            
        return trim($firstName . ' ' . $lastName);
    }

    // Helper metode za trenutni script
    public function getDisplayNameCurrent()
    {
        return $this->getDisplayName(getCurrentScript());
    }

    public function getDisplayDescriptionCurrent()
    {
        return $this->getDisplayDescription(getCurrentScript());
    }

    public function getDisplayServicesCurrent()
    {
        return $this->getDisplayServices(getCurrentScript());
    }

    public function getDisplayAddressCurrent()
    {
        return $this->getDisplayAddress(getCurrentScript());
    }

    public function getDisplayCityCurrent()
    {
        return $this->getDisplayCity(getCurrentScript());
    }

    public function getDisplayOwnerNameCurrent()
    {
        return $this->getDisplayOwnerName(getCurrentScript());
    }

    // IMAGE HELPER METHODS
    /**
     * Da li biznis ima slike
     */
    public function hasImages()
    {
        return $this->images()->exists();
    }

    /**
     * Dodaj sliku
     */
    public function addImage($imagePath, $altText = null, $isPrimary = false)
    {
        $sortOrder = $this->images()->max('sort_order') ?? -1;
        
        return $this->images()->create([
            'image_path' => $imagePath,
            'alt_text' => $altText ?: $this->business_name,
            'is_primary' => $isPrimary,
            'sort_order' => $sortOrder + 1
        ]);
    }

    /**
     * Dodeli glavnu sliku
     */
    public function setPrimaryImage($imageId)
    {
        // Ukloni primary status sa svih slika
        $this->images()->update(['is_primary' => false]);
        
        // Dodeli primary status određenoj slici
        $this->images()->where('id', $imageId)->update(['is_primary' => true]);
        
        return $this;
    }
}