@extends('layouts.app')

@section('title', __sr('categories', 'Kategorije', 'Категорије'))

@section('content')
<!-- Hero Section Kategorije sa slikom -->
<section class="bg-primary relative flex items-center mt-20 h-[40vh]">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('storage/images/hero-kategorije.png') }}" alt="Pozadinska slika" class="w-full h-full object-cover">
    </div>
    
    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-2 relative z-10 w-full">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">
            {{ __sr('all_categories', 'Sve Kategorije', 'Све Категорије') }}
        </h1>
        <p class="text-xl text-blue-100 mb-10">
            {{ __sr('browse_by_category', 'Pregledajte biznise po kategorijama', 'Прегледајте бизнисе по категоријама') }}
        </p>
    </div>
</section>

<!-- Categories Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    @if($categories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}" 
                   class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105 overflow-hidden group">
                    <div class="p-6 text-center">
                        <!-- Icon -->
                        <div class="text-4xl mb-4 group-hover:text-primary transition-colors">
                            {{ $category->icon }}
                        </div>
                        
                        <!-- Category Name -->
                        <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-primary transition-colors">
                            {{ $category->getDisplayName(getCurrentScript()) }}
                        </h3>
                        
                        <!-- Description -->
                        @if($category->getDisplayDescription(getCurrentScript()))
                            <p class="text-gray-600 text-sm mb-4">
                                {{ Str::limit($category->getDisplayDescription(getCurrentScript()), 80) }}
                            </p>
                        @endif
                        
                        <!-- Business Count -->
                        <div class="bg-primary text-white px-3 py-1 rounded-full text-sm font-medium" style="color: #FFF;">
                            {{ $category->approved_businesses_count }} {{ __sr('businesses_count', 'biznisa', 'бизниса') }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <!-- No Categories -->
        <div class="text-center py-16">
            <i class="fas fa-tags text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">
                {{ __sr('no_categories', 'Nema dostupnih kategorija', 'Нема доступних категорија') }}
            </h3>
            <p class="text-gray-600">
                {{ __sr('categories_coming_soon', 'Kategorije će uskoro biti dodane', 'Категорије ће ускоро бити додане') }}
            </p>
        </div>
    @endif
</div>
@endsection