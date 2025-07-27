<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Services\SerbianTransliterator;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_latin',
        'name_cyrillic',
        'slug',
        'description',
        'description_latin',
        'description_cyrillic',
        'icon',
		'color',
        'is_active',
		'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relacije
    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_categories');
    }

    public function approvedBusinesses()
    {
        return $this->belongsToMany(Business::class, 'business_categories')
                    ->where('status', 'approved');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Boot metode za auto-generiranje transliteracija
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (!$category->slug) {
                $category->slug = Str::slug($category->name);
            }
            $category->generateTransliterations();
        });
        
        static::updating(function ($category) {
            if ($category->isDirty('name') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->name);
            }
            
            if ($category->isDirty(['name', 'description'])) {
                $category->generateTransliterations();
            }
        });
    }

    // Generiši transliteracije
    public function generateTransliterations()
    {
        if ($this->name) {
            $scripts = SerbianTransliterator::generateBothScripts($this->name);
            $this->name_latin = $scripts['latin'];
            $this->name_cyrillic = $scripts['cyrillic'];
        }

        if ($this->description) {
            $scripts = SerbianTransliterator::generateBothScripts($this->description);
            $this->description_latin = $scripts['latin'];
            $this->description_cyrillic = $scripts['cyrillic'];
        }
    }

    // Display metode za različita pisma
    public function getDisplayName($script = 'latin')
    {
        if ($script === 'cyrillic') {
            return $this->name_cyrillic ?: $this->name;
        }
        return $this->name_latin ?: $this->name;
    }

    public function getDisplayDescription($script = 'latin')
    {
        if ($script === 'cyrillic') {
            return $this->description_cyrillic ?: $this->description;
        }
        return $this->description_latin ?: $this->description;
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
}