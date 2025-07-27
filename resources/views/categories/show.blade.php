@extends('layouts.app')

@section('title', $category->getDisplayName(getCurrentScript()) . ' - ' . __sr('categories', 'Kategorije', 'Категорије'))

@section('content')
<!-- Hero Section -->
<section class="bg-primary py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="text-6xl text-white mb-4">
            {{ $category->icon }}
        </div>
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            {{ $category->getDisplayName(getCurrentScript()) }}
        </h1>
        @if($category->getDisplayDescription(getCurrentScript()))
            <p class="text-xl text-blue-100 mb-6">
                {{ $category->getDisplayDescription(getCurrentScript()) }}
            </p>
        @endif
        <div class="text-blue-100">
            <i class="fas fa-store mr-2"></i>
            {{ $businesses->total() }} {{ __sr('businesses_in_category', 'biznisa u ovoj kategoriji', 'бизниса у овој категорији') }}
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __sr('search', 'Pretraga', 'Претрага') }}
                    </label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="{{ __sr('search_in_category', 'Pretražite u ovoj kategoriji...', 'Претражите у овој категорији...') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
                
                <!-- City Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __sr('city', 'Grad', 'Град') }}
                    </label>
                    <div class="flex gap-2">
                        <select name="city" class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">{{ __sr('all_cities', 'Svi gradovi', 'Сви градови') }}</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm">
            <li>
                <a href="{{ route('home') }}" class="text-primary hover:underline">
                    {{ __sr('home', 'Početna', 'Почетна') }}
                </a>
            </li>
            <li class="text-gray-500">/</li>
            <li>
                <a href="{{ route('category.index') }}" class="text-primary hover:underline">
                    {{ __sr('categories', 'Kategorije', 'Категорије') }}
                </a>
            </li>
            <li class="text-gray-500">/</li>
            <li class="text-gray-900 font-medium">
                {{ $category->getDisplayName(getCurrentScript()) }}
            </li>
        </ol>
    </nav>

    <!-- Results -->
    @if($businesses->count() > 0)
        <div class="mb-6">
            <p class="text-gray-600">
                {{ __sr('showing_results', 'Prikazuje se', 'Приказује се') }}: <strong>{{ $businesses->count() }}</strong> {{ __sr('of', 'od', 'од') }} <strong>{{ $businesses->total() }}</strong> {{ __sr('businesses_plural', 'biznisa', 'бизниса') }}
            </p>
        </div>
        
        <!-- Business Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($businesses as $business)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                    @if($business->primaryImage)
                        <img src="{{ $business->primaryImage->full_url }}" 
                             alt="{{ $business->getDisplayName(getCurrentScript()) }}" 
                             class="business-card-image w-full">
                    @else
                        <div class="business-card-image w-full bg-gradient-to-br from-primary to-purple-500 flex items-center justify-center">
                            <i class="fas fa-store text-white text-4xl"></i>
                        </div>
                    @endif
                    
                    <div class="p-4">
                        <!-- Business Name -->
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            {{ $business->getDisplayName(getCurrentScript()) }}
                        </h3>
                        
                        <!-- Description -->
                        @if($business->getDisplayDescription(getCurrentScript()))
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                {{ Str::limit($business->getDisplayDescription(getCurrentScript()), 100) }}
                            </p>
                        @endif
                        
                        <!-- Location and View Button -->
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                @php
                                    $cityName = $business->getDisplayCity(getCurrentScript());
                                    $fullAddress = $business->getDisplayAddress(getCurrentScript());
                                    if ($fullAddress) {
                                        $fullAddress .= ', ' . $cityName . ', Srbija';
                                    } else {
                                        $fullAddress = $cityName . ', Srbija';
                                    }
                                    $mapsUrl = 'https://maps.google.com/maps?q=' . urlencode($fullAddress);
                                @endphp
                                
                                <a href="{{ $mapsUrl }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="text-gray-500 hover:text-primary transition-colors"
                                   title="{{ __sr('open_in_maps', 'Otvori u Google Maps', 'Отвори у Google Maps') }}">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    {{ $cityName }}
                                    <i class="fas fa-external-link-alt ml-1 text-xs opacity-50"></i>
                                </a>
                            </div>
                            <a href="{{ route('business.show', $business->slug) }}" 
                               class="bg-primary text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition-colors">
                                {{ __sr('view', 'Pogledaj', 'Погледај') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $businesses->appends(request()->query())->links() }}
        </div>
    @else
        <!-- No Results -->
        <div class="text-center py-16">
            <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">
                {{ __sr('no_businesses_in_category', 'Nema biznisa u ovoj kategoriji', 'Нема бизниса у овој категорији') }}
            </h3>
            <p class="text-gray-600 mb-6">
                {{ __sr('try_different_filters', 'Pokušajte sa drugačijim filtrima ili se vratite na sve kategorije', 'Покушајте са другачијим филтрима или се вратите на све категорије') }}
            </p>
            <div class="space-x-4">
                <a href="{{ route('category.show', $category->slug) }}" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    {{ __sr('show_all_in_category', 'Prikaži sve u kategoriji', 'Прикажи све у категорији') }}
                </a>
                <a href="{{ route('category.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors">
                    {{ __sr('all_categories', 'Sve kategorije', 'Све категорије') }}
                </a>
            </div>
        </div>
    @endif
</div>
@endsection