@extends('layouts.app')

@section('title', 'Početna - Platforma')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-primary via-blue-700" style="background: linear-gradient(135deg, #2265CD 0%, #4A80D4 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 text-white">
                {{ __sr('platform_title', 'Platforma za Invalide', 'Платформа за Инвалиде') }}
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">
                {{ __sr('platform_subtitle', 'Platforma koja povezuje invalide i njihove biznise sa zajednicom', 'Платформа која повезује инвалиде и њихове бизнисе са заједницом') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('business.index') }}" class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    <i class="fas fa-search mr-2"></i> {{ __sr('browse_businesses', 'Pregledaj Biznise', 'Прегледај Бизнисе') }}
                </a>
                <a href="{{ route('business.create') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary transition-colors">
                    <i class="fas fa-plus mr-2"></i> {{ __sr('add_business', 'Prijavite Svoj Biznis', 'Пријавите Свој Бизнис') }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Kako Funkcioniše - 3 Koraka -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                {{ __sr('how_it_works', 'Kako funkcioniše?', 'Како функционише?') }}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ __sr('platform_description', 'Jednostavno povezivanje sa zajednicom u tri koraka', 'Једноставно повезивање са заједницом у три корака') }}
            </p>
        </div>

        <div class="relative">
            <!-- Desktop Connection Lines -->
            <div class="hidden lg:block absolute top-1/2 left-0 w-full h-1 transform -translate-y-1/2">
                <svg class="w-full h-full" viewBox="0 0 800 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Animated flowing line -->
                    <path d="M50 10 Q 250 -5 400 10 T 750 10" stroke="#2265CD" stroke-width="3" fill="none" stroke-dasharray="10,10" opacity="0.3">
                        <animate attributeName="stroke-dashoffset" values="0;20" dur="2s" repeatCount="indefinite"/>
                    </path>
                </svg>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 relative z-10">
                <!-- Korak 1 -->
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-700 transition-colors duration-300 transform group-hover:scale-110">
                            <span class="text-2xl font-bold text-white">1</span>
                        </div>
                        <!-- Floating Icon -->
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-plus text-primary text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        {{ __sr('step1_title', 'Prijavite Svoj Biznis', 'Пријавите Свој Бизнис') }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __sr('step1_desc', 'Jednostavno ispunite formular sa osnovnim informacijama o vašem biznisu. Proces traje samo nekoliko minuta.', 'Једноставно испуните формулар са основним информацијама о вашем бизнису. Процес траје само неколико минута.') }}
                    </p>
                    <!-- Arrow for mobile -->
                    <div class="lg:hidden mt-6 flex justify-center">
                        <i class="fas fa-arrow-down text-primary text-2xl animate-bounce"></i>
                    </div>
                </div>

                <!-- Korak 2 -->
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-700 transition-colors duration-300 transform group-hover:scale-110">
                            <span class="text-2xl font-bold text-white">2</span>
                        </div>
                        <!-- Floating Icon -->
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600 text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        {{ __sr('step2_title', 'Brza Verifikacija', 'Брза Верификација') }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __sr('step2_desc', 'Naš tim će pregledati vašu prijavu u roku od 1-2 radna dana i kontaktirati vas putem email-a sa rezultatom.', 'Наш тим ће прегледати вашу пријаву у року од 1-2 радна дана и контактирати вас путем емаил-а са резултатом.') }}
                    </p>
                    <!-- Arrow for mobile -->
                    <div class="lg:hidden mt-6 flex justify-center">
                        <i class="fas fa-arrow-down text-primary text-2xl animate-bounce"></i>
                    </div>
                </div>

                <!-- Korak 3 -->
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-700 transition-colors duration-300 transform group-hover:scale-110">
                            <span class="text-2xl font-bold text-white">3</span>
                        </div>
                        <!-- Floating Icon -->
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-rocket text-purple-600 text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        {{ __sr('step3_title', 'Povežite se sa Zajednicom', 'Повежите се са Заједницом') }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __sr('step3_desc', 'Nakon odobrenja, vaš biznis će biti vidljiv svima koji traže usluge. Počnite da gradite veze i širite svoju mrežu.', 'Након одобрења, ваш бизнис ће бити видљив свима који траже услуге. Почните да градите везе и ширите своју мрежу.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- CTA After Steps -->
        <div class="text-center mt-16">
            <a href="{{ route('business.create') }}" class="inline-block bg-primary text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-blue-700 transition-colors transform hover:scale-105">
                <i class="fas fa-rocket mr-2"></i>
                {{ __sr('get_started', 'Počnite Danas', 'Почните Данас') }}
            </a>
            <p class="text-gray-500 mt-3 text-sm">
                {{ __sr('free_registration', 'Registracija je potpuno besplatna', 'Регистрација је потпуно бесплатна') }}
            </p>
        </div>
    </div>
</section>

<!-- Featured Businesses -->
@if($featuredBusinesses->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ __sr('latest_businesses', 'Najnoviji Biznisi', 'Најновији Бизниси') }}</h2>
            <p class="text-xl text-gray-600">{{ __sr('meet_newest_members', 'Upoznajte najnovije članove naše zajednice', 'Упознајте најновије чланове наше заједнице') }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredBusinesses as $business)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden">
                @if($business->primaryImage)
                    <img src="{{ $business->primaryImage->full_url }}" alt="{{ $business->getDisplayName(getCurrentScript()) }}" class="business-card-image w-full">
                @else
                    <div class="business-card-image w-full bg-gradient-to-br from-primary to-purple-500 flex items-center justify-center">
                        <i class="fas fa-store text-white text-4xl"></i>
                    </div>
                @endif
                
                <div class="p-6">
                    <div class="flex flex-wrap gap-1 mb-3">
                        @foreach($business->categories->take(2) as $category)
                            <span class="bg-blue-100 text-primary px-2 py-1 rounded text-xs">
                                {{ $category->icon }} {{ $category->getDisplayName(getCurrentScript()) }}
                            </span>
                        @endforeach
                    </div>
                    
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        {{ $business->getDisplayName(getCurrentScript()) }}
                    </h3>
                    
                    @if($business->getDisplayDescription(getCurrentScript()))
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ Str::limit($business->getDisplayDescription(getCurrentScript()), 120) }}
                        </p>
                    @endif
                    
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            {{ $business->getDisplayCity(getCurrentScript()) }}
                        </div>
                        <a href="{{ route('business.show', $business->slug) }}" 
                           class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors text-sm">
                            {{ __sr('view_details', 'Detalji', 'Детаљи') }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('business.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors">
                {{ __sr('view_all_businesses', 'Pogledaj sve biznise', 'Погледај све бизнисе') }}
            </a>
        </div>
    </div>
</section>
@endif

<!-- Popular Categories -->
@if($popularCategories->count() > 0)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ __sr('popular_categories', 'Popularne Kategorije', 'Популарне Категорије') }}</h2>
            <p class="text-xl text-gray-600">{{ __sr('explore_categories', 'Istražite različite vrste biznisa', 'Истражите различите врсте бизниса') }}</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($popularCategories as $category)
                <a href="{{ route('category.show', $category->slug) }}" 
                   class="bg-gray-50 p-6 rounded-lg text-center hover:bg-primary hover:text-white transition-all duration-300 group">
                    <div class="text-3xl mb-3 group-hover:text-white transition-colors">
                        {{ $category->icon }}
                    </div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-white mb-1">
                        {{ $category->getDisplayName(getCurrentScript()) }}
                    </h3>
                    <p class="text-sm text-gray-600 group-hover:text-blue-100">
                        {{ $category->approved_businesses_count }} {{ __sr('businesses_count', 'biznisa', 'бизниса') }}
                    </p>
                </a>
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('category.index') }}" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                {{ __sr('view_all_categories', 'Sve kategorije', 'Све категорије') }}
            </a>
        </div>
    </div>
</section>
@endif
@endsection