@extends('layouts.app')

@section('title', __sr('businesses', 'Biznisi', 'Бизниси'))

@section('content')
<!-- Hero Section -->
<section class="bg-primary py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            {{ __sr('all_businesses', 'Svi Biznisi', 'Сви Бизниси') }}
        </h1>
        <p class="text-xl text-blue-100 mb-8">
            {{ __sr('discover_businesses', 'Otkrijte biznise u vašoj zajednici', 'Откријте бизнисе у вашој заједници') }}
        </p>
        
        <!-- Search Form -->
        <div class="max-w-2xl mx-auto">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="{{ __sr('search_placeholder', 'Pretražite biznise...', 'Претражите бизнисе...') }}"
                           class="w-full px-4 py-3 rounded-lg border-0 focus:ring-2 focus:ring-white focus:ring-opacity-50">
                </div>
                <button type="submit" class="bg-white text-primary px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    <i class="fas fa-search mr-2"></i>{{ __sr('search', 'Pretraži', 'Претражи') }}
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
        <form method="GET" class="space-y-4">
            <input type="hidden" name="search" value="{{ request('search') }}">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __sr('category', 'Kategorija', 'Категорија') }}
                    </label>
                    <select name="category" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">{{ __sr('all_categories', 'Sve kategorije', 'Све категорије') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                                {{ $category->icon }} {{ $category->getDisplayName(getCurrentScript()) }} ({{ $category->approved_businesses_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- City Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __sr('city', 'Grad', 'Град') }}
                    </label>
                    <select name="city" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">{{ __sr('all_cities', 'Svi gradovi', 'Сви градови') }}</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Filter Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-filter mr-2"></i>{{ __sr('filter', 'Filtriraj', 'Филтрирај') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Results -->
    @if($businesses->count() > 0)
        <div class="mb-6">
            <p class="text-gray-600">
                {{ __sr('results_count', 'Pronađeno', 'Пронађено') }}: <strong>{{ $businesses->total() }}</strong> {{ __sr('businesses_plural', 'biznisa', 'бизниса') }}
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
                        <!-- Categories -->
                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach($business->categories->take(2) as $category)
                                <span class="bg-blue-100 text-primary px-2 py-1 rounded text-xs">
                                    {{ $category->icon }} {{ $category->getDisplayName(getCurrentScript()) }}
                                </span>
                            @endforeach
                        </div>
                        
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
            {{ $businesses->links() }}
        </div>
    @else
        <!-- No Results -->
        <div class="text-center py-16">
            <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">
                {{ __sr('no_businesses_found', 'Nema pronađenih biznisa', 'Нема пронађених бизниса') }}
            </h3>
            <p class="text-gray-600 mb-6">
                {{ __sr('try_different_search', 'Pokušajte sa drugačijim pretragom ili filtrima', 'Покушајте са другачијим претрагом или филтрима') }}
            </p>
            <a href="{{ route('business.index') }}" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                {{ __sr('show_all', 'Prikaži sve', 'Прикажи све') }}
            </a>
        </div>
    @endif
</div>
@endsection