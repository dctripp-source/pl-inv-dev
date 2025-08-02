@extends('layouts.app')

@section('title', 'Početna - Platforma')

@section('content')
<!-- Hero Section -->
<!-- Hero Section - bez padding-top da bude uz sam vrh -->
<section class="relative min-h-screen flex items-center">
    <!-- DODAJ SLIKU OVDJE kao pozadinu cijele sekcije za DESKTOP -->

    <div class="absolute inset-0 hidden md:block">
        <img src="storage/images/hro.png" alt="Pozadinska slika" class="w-full h-full object-cover">
    </div>

    
    <!-- DODAJ SLIKU OVDJE kao pozadinu cijele sekcije za MOBILE -->

    <div class="absolute inset-0 block md:hidden">
        <img src="storage/images/hero-pl4.png" alt="Pozadinska slika mobile" class="w-full h-full object-cover">
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Lijeva strana - Tekst content -->
            <div class="text-white">
                <h1 class="text-4xl md:text-5xl lg:text-5xl font-bold mb-6 leading-tight" style="color: #2265CD; line-height: 55px !important;">
                    {!! __sr('hero_title', 'Dobrodošli na <br> Biznis Mrežu INVRS', 'Добродошли на <br> Бизнис Мрежу ИНВРС') !!}
                </h1>
                
                <p class="text-xl md:text-2xl mb-8 leading-relaxed" style="color: #161616; font-size: 22px;">
                    {!! __sr('hero_subtitle', 'Zvanična platforma Fonda za profesionalnu rehabilitaciju i zapošljavanje invalida Republike Srpske, kreirana da <br> osnaži, poveže i promoviše preduzetnike sa invaliditetom.', 'Званична платформа Фонда за професионалну рехабилитацију и запошљавање инвалида Републике Српске, креирана да оснажи, повеже и промовише <br> предузетнике са инвалидитетом.') !!}
                </p>
                
                <!-- CTA Button -->
                <div class="mb-12" style="margin-top: 7%;">
                    <a href="{{ route('business.create') }}" class="inline-block font-semibold px-8 py-4 rounded-full text-lg transition-colors duration-300 shadow-lg hover:shadow-xl text-white" style="background-color: #2265CD;" onmouseover="this.style.backgroundColor='#1c56b3'" onmouseout="this.style.backgroundColor='#2265CD'">
                        {{ __sr('cta_button', 'Predstavi svoj biznis', 'Представи свој бизнис') }}
                    </a>
                </div>
            
            <!-- Desna strana - prazno za prostor -->
            <div class="hidden lg:block">
                <!-- Prazan prostor - slika je sada pozadina cijele sekcije -->
            </div>
        </div>
    </div>
</section>

<!-- Kako Funkcioniše - 3 Koraka -->
<section class="py-20 bg-gray-50 flex items-center justify-center" style="height: 90vh; background-image: url('{{ asset('storage/images/bck2.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4" style="padding: 8px 24px; border-radius: 8px; display: inline-block;">
                {{ __sr('how_it_works', 'Ono što nas pokreće', 'Оно што нас покреће') }}
            </h2>
            <p style="font-size: 20px;">
                {{ __sr('how_it_works_desc', 'Principi koji vode našu zajednicu ka uspešnoj budućnosti', 'Принципи који воде нашу заједницу ка успешнoj будућности') }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
            <!-- Korak 1 -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <!-- Ikona raketa -->
                <div class="mb-6 flex justify-center">
                    <img src="{{ asset('storage/images/misija.png') }}" style="width: 80px; height: 80px;" alt="Registracija" class="object-contain"> 
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __sr('step1_title', 'Misija', 'Мисија') }}
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ __sr('step1_desc', 'Povezujemo preduzetnike sa invaliditetom sa zajednicom kroz našu digitalnu platformu. Omogućavamo im da pokažu svoj potencijal i ostvare poslovne snove.', 'Повезујемо предузетнике са инвалидитетом са заједницом кроз нашу дигиталну платформу. Омогућавамо им да покажу свој потенцијал и остваре пословне снове.') }}
                </p>
            </div>

            <!-- Korak 2 -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <!-- Ikona sijalica -->
                <div class="mb-6 flex justify-center">
                    <img src="{{ asset('storage/images/vizija.png') }}" style="width: 80px; height: 80px;" alt="Registracija" class="object-contain"> 
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __sr('step2_title', 'Vizija', 'Визија') }}
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ __sr('step2_desc', 'Republika Srpska kao primer inkluzivnog preduzetništva u regionu. Društvo gdje se različitost ceni i gdje svaki biznis može da napreduje.', 'Република Srpska као пример инклузивног предузетништва у региону. Друштво где се различитост цени и где сваки бизнис може да напредује.') }}
                </p>
            </div>

            <!-- Korak 3 -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <!-- Ikona kvadrata -->
                <div class="mb-6 flex justify-center">
                    <img src="{{ asset('storage/images/vrijednosti.png') }}" style="width: 80px; height: 80px;" alt="Registracija" class="object-contain"> 
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __sr('step3_title', 'Vrijednosti', 'Вриједности') }}
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ __sr('step3_desc', 'Inkluzivnost, transparentnost i solidarnost su temelji našeg rada. Zajedno smo jači i svaki uspeh pojedinca je uspeh cele zajednice.', 'Инклузивност, транспарентност и солидарност су темељи нашег рада. Заједно смо јачи и сваки успех појединца је успех целе заједнице.') }}
                </p>
            </div>
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
        
        <div class="text-center mt-8" style="margin-top: 5%;">
            <a href="{{ route('business.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors" style="background-color: #2265cd;">
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
        
        <div class="text-center mt-8" style="margin-top: 5%;">
            <a href="{{ route('category.index') }}" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                {{ __sr('view_all_categories', 'Sve kategorije', 'Све категорије') }}
            </a>
        </div>
    </div>
</section>
@endif
@endsection