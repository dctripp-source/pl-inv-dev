@extends('layouts.app')

@section('title', $business->getDisplayName(getCurrentScript()) . ' - ' . __sr('site_name', 'Platforma za Invalide', 'Платформа за Инвалиде'))

@section('content')
<div class="bg-white">
    <!-- Business Hero Section -->
    <div class="relative">
        <div class="w-full h-64 md:h-96 bg-primary flex items-center justify-center text-center relative">
            <div class="text-white z-10">
                <h1 class="text-3xl md:text-5xl font-bold mb-4">
                    {{ $business->getDisplayName(getCurrentScript()) }}
                </h1>
                @if($business->categories->count() > 0)
                    <p class="text-lg md:text-xl text-blue-100">
                        {{ $business->categories->first()->getDisplayName(getCurrentScript()) }}
                    </p>
                @endif
            </div>
        </div>
        
        <div class="absolute top-4 left-4">
            <a href="{{ route('business.index') }}" class="bg-black bg-opacity-50 text-white px-4 py-2 rounded-lg hover:bg-opacity-75 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> {{ __sr('back', 'Nazad', 'Назад') }}
            </a>
        </div>
    </div>
    
    <!-- Business Info -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Categories Tags -->
                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach($business->categories as $category)
                        <a href="{{ route('category.show', $category->slug) }}" class="bg-blue-100 text-primary px-3 py-1 rounded-full text-sm hover:bg-blue-200 transition-colors">
                            {{ $category->icon }} {{ $category->getDisplayName(getCurrentScript()) }}
                        </a>
                    @endforeach
                </div>
                
                <!-- Business Description -->
                @if($business->getDisplayDescription(getCurrentScript()))
                    <div class="prose max-w-none mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">
                            {{ __sr('about_business', 'O biznisu', 'О бизнису') }}
                        </h2>
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($business->getDisplayDescription(getCurrentScript()))) !!}
                        </div>
                    </div>
                @endif
                
                <!-- Services -->
                @if($business->getDisplayServices(getCurrentScript()))
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">
                            {{ __sr('services', 'Usluge', 'Услуге') }}
                        </h2>
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($business->getDisplayServices(getCurrentScript()))) !!}
                        </div>
                    </div>
                @endif
                
                <!-- Business Images Gallery са Lightbox -->
                @if($business->images->count() > 0)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">
                            {{ __sr('gallery', 'Galerija', 'Галерија') }}
                        </h2>
                        
                        <!-- Main Image Display -->
                        @php
                            $mainImage = $business->primaryImage ?: $business->images->first();
                            $mainImageUrl = $mainImage ? Storage::disk('public')->url($mainImage->image_path) : null;
                        @endphp
                        
                        @if($mainImageUrl)
                            <div class="mb-4">
                                <img id="main-gallery-image" 
                                     src="{{ $mainImageUrl }}" 
                                     alt="{{ $mainImage->alt_text ?: $business->getDisplayName(getCurrentScript()) }}" 
                                     class="w-full h-64 md:h-96 object-cover rounded-lg shadow-lg cursor-pointer"
                                     onclick="openLightbox(0)">
                            </div>
                        @endif
                        
                        <!-- Image Thumbnails -->
                        @if($business->images->count() > 1)
                            <div class="grid grid-cols-4 md:grid-cols-6 gap-2">
                                @foreach($business->images as $index => $image)
                                    @php
                                        $imageUrl = Storage::disk('public')->url($image->image_path);
                                    @endphp
                                    <img src="{{ $imageUrl }}" 
                                         alt="{{ $image->alt_text ?: $business->getDisplayName(getCurrentScript()) }}" 
                                         class="business-gallery-thumb cursor-pointer"
                                         onclick="changeMainImage('{{ $imageUrl }}', {{ $index }})">
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <!-- No Images Message -->
                    <div class="mb-8 text-center py-8 bg-gray-50 rounded-lg">
                        <i class="fas fa-images text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">{{ __sr('no_images', 'Nema dostupnih slika', 'Нема доступних слика') }}</p>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar - Contact Info -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 rounded-lg p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        {{ __sr('contact_info', 'Kontakt informacije', 'Контакт информације') }}
                    </h2>
                    
                    <div class="space-y-4">
                        <!-- Owner Name -->
                        @if($business->owner_first_name && $business->owner_last_name)
                            <div class="flex items-start">
                                <i class="fas fa-user text-primary mt-1 mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ __sr('owner', 'Vlasnik', 'Власник') }}
                                    </div>
                                    <div class="text-gray-600">
                                        {{ $business->getDisplayOwnerName(getCurrentScript()) }}
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Phone -->
                        @if($business->phone)
                            <div class="flex items-start">
                                <i class="fas fa-phone text-primary mt-1 mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ __sr('phone', 'Telefon', 'Телефон') }}
                                    </div>
                                    <a href="tel:{{ $business->phone }}" class="text-primary hover:underline">
                                        {{ $business->phone }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Email -->
                        @if($business->email)
                            <div class="flex items-start">
                                <i class="fas fa-envelope text-primary mt-1 mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ __sr('email', 'Email', 'Имејл') }}
                                    </div>
                                    <a href="mailto:{{ $business->email }}" class="text-primary hover:underline break-all">
                                        {{ $business->email }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Website -->
                        @if($business->website)
                            <div class="flex items-start">
                                <i class="fas fa-globe text-primary mt-1 mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ __sr('website', 'Web sajt', 'Веб сајт') }}
                                    </div>
                                    <a href="{{ $business->website }}" target="_blank" rel="noopener" class="text-primary hover:underline break-all">
                                        {{ $business->website }}
                                        <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Address -->
                        @if($business->getDisplayAddress(getCurrentScript()))
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-primary mt-1 mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ __sr('address', 'Adresa', 'Адреса') }}
                                    </div>
                                    <div class="text-gray-600">
                                        @php
                                            $fullAddress = $business->getDisplayAddress(getCurrentScript());
                                            if ($business->getDisplayCity(getCurrentScript())) {
                                                $fullAddress .= ', ' . $business->getDisplayCity(getCurrentScript());
                                            }
                                            $fullAddress .= ', Srbija';
                                            $mapsUrl = 'https://maps.google.com/maps?q=' . urlencode($fullAddress);
                                        @endphp
                                        
                                        <a href="{{ $mapsUrl }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="text-primary hover:underline hover:text-blue-700 transition-colors"
                                           title="{{ __sr('open_in_maps', 'Otvori u Google Maps', 'Отвори у Google Maps') }}">
                                            {{ $business->getDisplayAddress(getCurrentScript()) }}
                                            @if($business->getDisplayCity(getCurrentScript()))
                                                <br>{{ $business->getDisplayCity(getCurrentScript()) }}
                                            @endif
                                            <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Working Hours -->
                        @if($business->working_hours)
                            <div class="flex items-start">
                                <i class="fas fa-clock text-primary mt-1 mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ __sr('working_hours', 'Radno vrijeme', 'Радно вријеме') }}
                                    </div>
                                    <div class="text-gray-600">
                                        {!! nl2br(e($business->working_hours)) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Businesses -->
    @if($relatedBusinesses && $relatedBusinesses->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">
                    {{ __sr('related_businesses', 'Slični biznisi', 'Слични бизниси') }}
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedBusinesses as $relatedBusiness)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                            @php
                                $relatedImageUrl = null;
                                if ($relatedBusiness->primaryImage) {
                                    $relatedImageUrl = Storage::disk('public')->url($relatedBusiness->primaryImage->image_path);
                                }
                            @endphp
                            
                            @if($relatedImageUrl)
                                <img src="{{ $relatedImageUrl }}" 
                                     alt="{{ $relatedBusiness->getDisplayName(getCurrentScript()) }}" 
                                     class="business-card-image w-full">
                            @else
                                <div class="business-card-image w-full bg-gradient-to-br from-primary to-purple-500 flex items-center justify-center">
                                    <i class="fas fa-store text-white text-4xl"></i>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @foreach($relatedBusiness->categories->take(2) as $category)
                                        <span class="bg-blue-100 text-primary px-2 py-1 rounded text-xs">
                                            {{ $category->icon }} {{ $category->getDisplayName(getCurrentScript()) }}
                                        </span>
                                    @endforeach
                                </div>
                                
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                    {{ $relatedBusiness->getDisplayName(getCurrentScript()) }}
                                </h3>
                                
                                @if($relatedBusiness->getDisplayDescription(getCurrentScript()))
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        {{ Str::limit($relatedBusiness->getDisplayDescription(getCurrentScript()), 120) }}
                                    </p>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-500">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $relatedBusiness->getDisplayCity(getCurrentScript()) }}
                                    </div>
                                    <a href="{{ route('business.show', $relatedBusiness->slug) }}" 
                                       class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors text-sm">
                                        {{ __sr('view_details', 'Detalji', 'Детаљи') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center hidden">
    <div class="relative max-w-4xl max-h-full p-4">
        <!-- Close Button -->
        <button onclick="closeLightbox()" class="absolute top-2 right-2 text-white text-4xl hover:text-gray-300 z-10">
            <i class="fas fa-times"></i>
        </button>
        
        <!-- Navigation Arrows -->
        <button onclick="previousImage()" class="absolute left-2 top-1/2 transform -translate-y-1/2 text-white text-3xl hover:text-gray-300 z-10">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button onclick="nextImage()" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-white text-3xl hover:text-gray-300 z-10">
            <i class="fas fa-chevron-right"></i>
        </button>
        
        <!-- Image -->
        <img id="lightbox-image" src="" alt="" class="max-w-full max-h-full object-contain">
        
        <!-- Image Counter -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white bg-black bg-opacity-50 px-3 py-1 rounded">
            <span id="image-counter">1 / 1</span>
        </div>
    </div>
</div>

<!-- JavaScript за галерију и lightbox -->
<script>
let currentImageIndex = 0;
const images = [
    @foreach($business->images as $index => $image)
        {
            url: '{{ Storage::disk('public')->url($image->image_path) }}',
            alt: '{{ $image->alt_text ?: $business->getDisplayName(getCurrentScript()) }}'
        }{{ $loop->last ? '' : ',' }}
    @endforeach
];

function changeMainImage(imageUrl, index) {
    const mainImage = document.getElementById('main-gallery-image');
    if (mainImage) {
        mainImage.src = imageUrl;
        currentImageIndex = index;
        
        // Add fade effect
        mainImage.style.opacity = '0.5';
        setTimeout(() => {
            mainImage.style.opacity = '1';
        }, 150);
    }
}

function openLightbox(index) {
    if (images.length === 0) return;
    
    currentImageIndex = index;
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightbox-image');
    const counter = document.getElementById('image-counter');
    
    lightboxImage.src = images[currentImageIndex].url;
    lightboxImage.alt = images[currentImageIndex].alt;
    counter.textContent = `${currentImageIndex + 1} / ${images.length}`;
    
    lightbox.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.add('hidden');
    document.body.style.overflow = '';
}

function nextImage() {
    if (images.length === 0) return;
    currentImageIndex = (currentImageIndex + 1) % images.length;
    updateLightboxImage();
}

function previousImage() {
    if (images.length === 0) return;
    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
    updateLightboxImage();
}

function updateLightboxImage() {
    const lightboxImage = document.getElementById('lightbox-image');
    const counter = document.getElementById('image-counter');
    
    lightboxImage.src = images[currentImageIndex].url;
    lightboxImage.alt = images[currentImageIndex].alt;
    counter.textContent = `${currentImageIndex + 1} / ${images.length}`;
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const lightbox = document.getElementById('lightbox');
    if (!lightbox.classList.contains('hidden')) {
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowLeft') {
            previousImage();
        } else if (e.key === 'ArrowRight') {
            nextImage();
        }
    }
    
    // Gallery navigation when lightbox is closed
    if (lightbox.classList.contains('hidden')) {
        const thumbnails = document.querySelectorAll('.business-gallery-thumb');
        if (thumbnails.length === 0) return;
        
        const mainImage = document.getElementById('main-gallery-image');
        if (!mainImage) return;
        
        if (e.key === 'ArrowLeft' && currentImageIndex > 0) {
            changeMainImage(images[currentImageIndex - 1].url, currentImageIndex - 1);
        } else if (e.key === 'ArrowRight' && currentImageIndex < images.length - 1) {
            changeMainImage(images[currentImageIndex + 1].url, currentImageIndex + 1);
        }
    }
});

// Click outside to close lightbox
document.getElementById('lightbox').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});
</script>
@endsection