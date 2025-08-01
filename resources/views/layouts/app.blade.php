<!DOCTYPE html>
<html lang="{{ app()->getLocale() === 'cir' ? 'sr-Cyrl' : 'sr-Latn' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __sr('title', 'Platforma za Invalide', 'Платформа за Инвалиде'))</title>
    
    <!-- CSS libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Accessibility Helper -->
    <!-- Navbar scroll functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('nav');
    const navLinks = document.querySelectorAll('nav a, nav button');
    const logo = document.querySelector('nav .text-xl');
    
    function updateNavbar() {
        if (window.scrollY > 50) {
            // Skrolovan - bijela pozadina
            navbar.classList.remove('bg-transparent', 'border-transparent');
            navbar.classList.add('bg-white', 'shadow-sm', 'border-gray-200');
            
            // Tamni tekst
            navLinks.forEach(link => {
                link.classList.remove('text-white', 'hover:text-blue-200');
                link.classList.add('text-gray-700', 'hover:text-primary');
            });
            
            if (logo) {
                logo.classList.remove('text-white');
                logo.classList.add('text-gray-900');
            }
        } else {
            // Vrh stranice - transparentan
            navbar.classList.remove('bg-white', 'shadow-sm', 'border-gray-200');
            navbar.classList.add('bg-transparent', 'border-transparent');
            
            // Bijeli tekst
            navLinks.forEach(link => {
                link.classList.remove('text-gray-700', 'hover:text-primary');
                link.classList.add('text-white', 'hover:text-blue-200');
            });
            
            if (logo) {
                logo.classList.remove('text-gray-900');
                logo.classList.add('text-white');
            }
        }
    }
    
    // Pozovi funkciju na scroll
    window.addEventListener('scroll', updateNavbar);
    
    // Pozovi funkciju odmah da postaviš početno stanje
    updateNavbar();
});

document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('nav');
    const navLinks = document.querySelectorAll('nav a:not([href*="business.create"]), nav button');
    const logo = document.querySelector('nav .text-xl');
    const ctaButton = document.querySelector('nav a[href*="business.create"]');
    const isHomePage = {{ request()->routeIs('home') ? 'true' : 'false' }};
    
    function updateNavbar() {
        if (window.scrollY > 50) {
            // Skrolovan - bijela pozadina
            navbar.classList.remove('bg-transparent', 'border-transparent');
            navbar.classList.add('bg-white', 'shadow-sm', 'border-gray-200');
            
            // Tamni tekst za linkove
            navLinks.forEach(link => {
                link.classList.remove('text-white', 'hover:text-blue-200');
                link.classList.add('text-gray-700', 'hover:text-primary');
            });
            
            // Logo boja kada se skrola
            if (logo) {
                logo.style.color = '#262626';
            }
            
            // CTA button ostaje bijel tekst
            if (ctaButton) {
                ctaButton.style.color = '#fff';
            }
        } else {
            // Vrh stranice - transparentan
            navbar.classList.remove('bg-white', 'shadow-sm', 'border-gray-200');
            navbar.classList.add('bg-transparent', 'border-transparent');
            
            // Bijeli tekst
            navLinks.forEach(link => {
                link.classList.remove('text-gray-700', 'hover:text-primary');
                link.classList.add('text-white', 'hover:text-blue-200');
            });
            
            // Logo boja ovisno o stranici
            if (logo) {
                if (isHomePage) {
                    logo.style.color = '#2265CD'; // Plavo na početnoj
                } else {
                    logo.style.color = '#fff'; // Bijelo na ostalim
                }
            }
            
            // CTA button ostaje bijel tekst
            if (ctaButton) {
                ctaButton.style.color = '#fff';
            }
        }
    }
    
    // Pozovi funkciju na scroll
    window.addEventListener('scroll', updateNavbar);
    
    // Pozovi funkciju odmah da postaviš početno stanje
    updateNavbar();
});
</script>
	
    <style>
        [x-cloak] { display: none !important; }
        
        :root {
            --primary-blue: #2265CD;
            --primary-white: #FFFFFF;
            --footer-blue: #4A80D4;
            --hover-blue: #0252CC;
        }
        
        .bg-primary { background-color: var(--primary-blue); }
        .text-primary { color: var(--primary-blue); }
        .border-primary { border-color: var(--primary-blue); }
        .hover\:bg-primary:hover { background-color: var(--primary-blue); }
        .hover\:text-primary:hover { color: var(--primary-blue); }
        
        .bg-footer { background-color: var(--footer-blue); }
        .hover\:bg-hover:hover { background-color: var(--hover-blue); }
        
        .business-card-image {
            aspect-ratio: 4/3;
            object-fit: cover;
            object-position: center;
        }
        
        .business-gallery-thumb {
            aspect-ratio: 1;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        
        .business-gallery-thumb:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        /* Language Switcher Styles */
        .language-switcher {
            position: relative;
        }
        
        .language-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            min-width: 160px;
            z-index: 50;
            overflow: hidden;
        }
        
        .language-option {
            display: block;
            padding: 12px 16px;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .language-option:last-child {
            border-bottom: none;
        }
        
        .language-option:hover {
            background-color: #f8fafc;
            color: var(--primary-blue);
        }
        
        .language-option.active {
            background-color: var(--primary-blue);
            color: white;
        }
        
        .language-option.active:hover {
            background-color: var(--hover-blue);
        }
        
        /* Search Form Styles */
        .search-form {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        
        /* Accessibility Enhancements */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: var(--primary-blue);
            color: white;
            padding: 8px;
            z-index: 1000;
            text-decoration: none;
            border-radius: 4px;
        }
        
        .skip-link:focus {
            top: 6px;
        }
        
        /* Focus styles for better accessibility */
        *:focus {
            outline: 2px solid var(--primary-blue);
            outline-offset: 2px;
        }
        
        button:focus,
        a:focus,
        input:focus,
        select:focus,
        textarea:focus {
            outline: 2px solid var(--primary-blue);
            outline-offset: 2px;
        }

        /* NOVO: Font size scaling - uključuje i naslove */
        body.font-size-80 { font-size: 80% !important; }
        body.font-size-80 h1 { font-size: calc(2.25rem * 0.8) !important; }
        body.font-size-80 h2 { font-size: calc(1.875rem * 0.8) !important; }
        body.font-size-80 h3 { font-size: calc(1.5rem * 0.8) !important; }
        body.font-size-80 h4 { font-size: calc(1.25rem * 0.8) !important; }
        body.font-size-80 h5 { font-size: calc(1.125rem * 0.8) !important; }
        body.font-size-80 h6 { font-size: calc(1rem * 0.8) !important; }

        body.font-size-90 { font-size: 90% !important; }
        body.font-size-90 h1 { font-size: calc(2.25rem * 0.9) !important; }
        body.font-size-90 h2 { font-size: calc(1.875rem * 0.9) !important; }
        body.font-size-90 h3 { font-size: calc(1.5rem * 0.9) !important; }
        body.font-size-90 h4 { font-size: calc(1.25rem * 0.9) !important; }
        body.font-size-90 h5 { font-size: calc(1.125rem * 0.9) !important; }
        body.font-size-90 h6 { font-size: calc(1rem * 0.9) !important; }

        body.font-size-100 { font-size: 100% !important; }
        body.font-size-100 h1 { font-size: 2.25rem !important; }
        body.font-size-100 h2 { font-size: 1.875rem !important; }
        body.font-size-100 h3 { font-size: 1.5rem !important; }
        body.font-size-100 h4 { font-size: 1.25rem !important; }
        body.font-size-100 h5 { font-size: 1.125rem !important; }
        body.font-size-100 h6 { font-size: 1rem !important; }

        body.font-size-110 { font-size: 110% !important; }
        body.font-size-110 h1 { font-size: calc(2.25rem * 1.1) !important; }
        body.font-size-110 h2 { font-size: calc(1.875rem * 1.1) !important; }
        body.font-size-110 h3 { font-size: calc(1.5rem * 1.1) !important; }
        body.font-size-110 h4 { font-size: calc(1.25rem * 1.1) !important; }
        body.font-size-110 h5 { font-size: calc(1.125rem * 1.1) !important; }
        body.font-size-110 h6 { font-size: calc(1rem * 1.1) !important; }

        body.font-size-120 { font-size: 120% !important; }
        body.font-size-120 h1 { font-size: calc(2.25rem * 1.2) !important; }
        body.font-size-120 h2 { font-size: calc(1.875rem * 1.2) !important; }
        body.font-size-120 h3 { font-size: calc(1.5rem * 1.2) !important; }
        body.font-size-120 h4 { font-size: calc(1.25rem * 1.2) !important; }
        body.font-size-120 h5 { font-size: calc(1.125rem * 1.2) !important; }
        body.font-size-120 h6 { font-size: calc(1rem * 1.2) !important; }

        body.font-size-130 { font-size: 130% !important; }
        body.font-size-130 h1 { font-size: calc(2.25rem * 1.3) !important; }
        body.font-size-130 h2 { font-size: calc(1.875rem * 1.3) !important; }
        body.font-size-130 h3 { font-size: calc(1.5rem * 1.3) !important; }
        body.font-size-130 h4 { font-size: calc(1.25rem * 1.3) !important; }
        body.font-size-130 h5 { font-size: calc(1.125rem * 1.3) !important; }
        body.font-size-130 h6 { font-size: calc(1rem * 1.3) !important; }

        body.font-size-140 { font-size: 140% !important; }
        body.font-size-140 h1 { font-size: calc(2.25rem * 1.4) !important; }
        body.font-size-140 h2 { font-size: calc(1.875rem * 1.4) !important; }
        body.font-size-140 h3 { font-size: calc(1.5rem * 1.4) !important; }
        body.font-size-140 h4 { font-size: calc(1.25rem * 1.4) !important; }
        body.font-size-140 h5 { font-size: calc(1.125rem * 1.4) !important; }
        body.font-size-140 h6 { font-size: calc(1rem * 1.4) !important; }

        body.font-size-150 { font-size: 150% !important; }
        body.font-size-150 h1 { font-size: calc(2.25rem * 1.5) !important; }
        body.font-size-150 h2 { font-size: calc(1.875rem * 1.5) !important; }
        body.font-size-150 h3 { font-size: calc(1.5rem * 1.5) !important; }
        body.font-size-150 h4 { font-size: calc(1.25rem * 1.5) !important; }
        body.font-size-150 h5 { font-size: calc(1.125rem * 1.5) !important; }
        body.font-size-150 h6 { font-size: calc(1rem * 1.5) !important; }

        /* Skaliraj navigaciju i logo */
        body.font-size-110 nav .text-xl { font-size: calc(1.375rem * 1.1) !important; }
        body.font-size-120 nav .text-xl { font-size: calc(1.375rem * 1.2) !important; }
        body.font-size-130 nav .text-xl { font-size: calc(1.375rem * 1.3) !important; }
        body.font-size-140 nav .text-xl { font-size: calc(1.375rem * 1.4) !important; }
        body.font-size-150 nav .text-xl { font-size: calc(1.375rem * 1.5) !important; }

        /* Skaliraj linkove u navigaciji (ne accessibility komponente) */
        body.font-size-110 nav a:not(.accessibility-btn):not([class*="accessibility"]),
        body.font-size-110 nav button:not(.accessibility-btn):not([class*="accessibility"]) { 
            font-size: calc(1.125rem * 1.1) !important; 
        }
        
        body.font-size-120 nav a:not(.accessibility-btn):not([class*="accessibility"]),
        body.font-size-120 nav button:not(.accessibility-btn):not([class*="accessibility"]) { 
            font-size: calc(1.125rem * 1.2) !important; 
        }
        
        body.font-size-130 nav a:not(.accessibility-btn):not([class*="accessibility"]),
        body.font-size-130 nav button:not(.accessibility-btn):not([class*="accessibility"]) { 
            font-size: calc(1.125rem * 1.3) !important; 
        }
        
        body.font-size-140 nav a:not(.accessibility-btn):not([class*="accessibility"]),
        body.font-size-140 nav button:not(.accessibility-btn):not([class*="accessibility"]) { 
            font-size: calc(1.125rem * 1.4) !important; 
        }
        
        body.font-size-150 nav a:not(.accessibility-btn):not([class*="accessibility"]),
        body.font-size-150 nav button:not(.accessibility-btn):not([class*="accessibility"]) { 
            font-size: calc(1.125rem * 1.5) !important; 
        }

        /* Skaliraj hero naslove specifično */
        body.font-size-110 .text-3xl { font-size: calc(1.875rem * 1.1) !important; }
        body.font-size-110 .text-4xl { font-size: calc(2.25rem * 1.1) !important; }
        body.font-size-110 .text-5xl { font-size: calc(3rem * 1.1) !important; }

        body.font-size-120 .text-3xl { font-size: calc(1.875rem * 1.2) !important; }
        body.font-size-120 .text-4xl { font-size: calc(2.25rem * 1.2) !important; }
        body.font-size-120 .text-5xl { font-size: calc(3rem * 1.2) !important; }

        body.font-size-130 .text-3xl { font-size: calc(1.875rem * 1.3) !important; }
        body.font-size-130 .text-4xl { font-size: calc(2.25rem * 1.3) !important; }
        body.font-size-130 .text-5xl { font-size: calc(3rem * 1.3) !important; }

        body.font-size-140 .text-3xl { font-size: calc(1.875rem * 1.4) !important; }
        body.font-size-140 .text-4xl { font-size: calc(2.25rem * 1.4) !important; }
        body.font-size-140 .text-5xl { font-size: calc(3rem * 1.4) !important; }

        body.font-size-150 .text-3xl { font-size: calc(1.875rem * 1.5) !important; }
        body.font-size-150 .text-4xl { font-size: calc(2.25rem * 1.5) !important; }
        body.font-size-150 .text-5xl { font-size: calc(3rem * 1.5) !important; }

        /* VAŽNO: Osiguraj da se accessibility komponente NE skaliraju */
        .accessibility-no-scale,
        .accessibility-no-scale *,
        .accessibility-button,
        .accessibility-sidebar,
        .accessibility-sidebar *,
        .accessibility-btn,
        .accessibility-header,
        .accessibility-content,
        .accessibility-group,
        .accessibility-header h3,
        .accessibility-group h4 {
            font-size: initial !important;
            transform: none !important;
        }

        /* Specifične veličine za accessibility komponente */
        .accessibility-button {
            font-size: 24px !important;
            width: 60px !important;
            height: 60px !important;
        }

        .accessibility-header h3 {
            font-size: 18px !important;
        }

        .accessibility-group h4 {
            font-size: 16px !important;
        }

        .accessibility-btn {
            font-size: 14px !important;
            padding: 8px 16px !important;
        }

        /* Dodatno osiguravanje da se accessibility elementi ne mijenjaju */
        body[class*="font-size"] .accessibility-no-scale,
        body[class*="font-size"] .accessibility-no-scale *,
        body[class*="font-size"] .accessibility-button,
        body[class*="font-size"] .accessibility-sidebar,
        body[class*="font-size"] .accessibility-sidebar *,
        body[class*="font-size"] .accessibility-btn,
        body[class*="font-size"] .accessibility-header,
        body[class*="font-size"] .accessibility-content,
        body[class*="font-size"] .accessibility-group {
            font-size: initial !important;
            transform: none !important;
        }

        body[class*="font-size"] .accessibility-button {
            font-size: 24px !important;
            width: 60px !important;
            height: 60px !important;
        }

        body[class*="font-size"] .accessibility-header h3 {
            font-size: 18px !important;
        }

        body[class*="font-size"] .accessibility-group h4 {
            font-size: 16px !important;
        }

        body[class*="font-size"] .accessibility-btn {
            font-size: 14px !important;
        }
        
        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .bg-primary { background-color: #000080; }
            .text-primary { color: #000080; }
            .border-primary { border-color: #000080; }
        }
        
        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
        
        /* Print styles */
        @media print {
            .accessibility-button,
            .accessibility-sidebar,
            .language-switcher,
            nav,
            footer {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <!-- Skip to main content link for screen readers -->
    <a href="#main-content" class="skip-link">
        {{ __sr('skip_to_content', 'Preskoči na glavni sadržaj', 'Прескочи на главни садржај') }}
    </a>

   <div x-data="{ mobileMenuOpen: false }" class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-transparent border-transparent backdrop-blur-sm fixed top-0 w-full z-50 transition-all duration-300" role="navigation" aria-label="{{ __sr('main_navigation', 'Glavna navigacija', 'Главна навигација') }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <!-- DODAJ LOGO OVDJE umjesto ikone -->
                         <img src="{{ asset('storage/images/fond-logo.png') }}" style="width: 60px; height: 50px;" alt="Logo" class="h-8 w-auto mr-3"> 
                        <span class="text-xl font-bold transition-colors duration-300" style="color: {{ request()->routeIs('home') ? '#2265CD' : '#FFFFFF' }}; font-size: 1.375rem;">
                            {{ __sr('site_name_short', 'Biznis mreža INVRS', 'Бизнис мрежа ИНВРС') }}
                        </span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-white hover:text-blue-200 transition-colors duration-300 {{ request()->routeIs('home') ? 'font-semibold' : '' }}" style="font-size: 1.125rem;">
                        {{ __sr('nav_home', 'Početna', 'Почетна') }}
                    </a>
                    <a href="{{ route('business.index') }}" class="text-white hover:text-blue-200 transition-colors duration-300 {{ request()->routeIs('business.*') ? 'font-semibold' : '' }}" style="font-size: 1.125rem;">
                        {{ __sr('nav_businesses', 'Biznisi', 'Бизниси') }}
                    </a>
                    <a href="{{ route('category.index') }}" class="text-white hover:text-blue-200 transition-colors duration-300 {{ request()->routeIs('category.*') ? 'font-semibold' : '' }}" style="font-size: 1.125rem;">
                        {{ __sr('nav_categories', 'Kategorije', 'Категорије') }}
                    </a>
                    
                    <!-- CTA Button -->
                    <a href="{{ route('business.create') }}" class="font-semibold px-6 py-2 rounded-full transition-colors duration-300 hover:bg-blue-700" style="background-color: #2265CD; color: #fff; font-size: 1.125rem;">
                        {{ __sr('nav_add_business', 'Prijavi svoj biznis', 'Пријави свој бизнис') }}
                    </a>
                    
                    <!-- Language Switcher -->
                    <div class="language-switcher" x-data="{ open: false }">
                        <button @click="open = !open" 
                                @click.away="open = false"
                                class="flex items-center text-white hover:text-blue-200 transition-colors duration-300"
                                aria-haspopup="true"
                                :aria-expanded="open"
                                style="font-size: 1.125rem;">
                            <span>{{ app()->getLocale() === 'cir' ? 'ЋИР' : 'LAT' }}</span>
                            <i class="fas fa-chevron-down ml-1 text-xs transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="open" 
                             x-cloak 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                             role="menu">
                            <a href="{{ request()->fullUrlWithQuery(['lang' => 'lat']) }}" 
                               class="block px-4 py-2 text-sm hover:bg-gray-100 {{ app()->getLocale() === 'lat' ? 'bg-blue-50' : '' }}"
                               role="menuitem"
                               style="color: #252525;">
                                {{ __sr('latin_script', 'Latinica', 'Latinica') }}
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['lang' => 'cir']) }}" 
                               class="block px-4 py-2 text-sm hover:bg-gray-100 {{ app()->getLocale() === 'cir' ? 'bg-blue-50' : '' }}"
                               role="menuitem"
                               style="color: #252525;">
                                {{ __sr('cyrillic_script', 'Ћирилица', 'Ћирилица') }}
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="text-white hover:text-blue-200 transition-colors duration-300 flex items-center justify-center"
                            aria-label="{{ __sr('toggle_menu', 'Otvori/zatvori meni', 'Отвори/затвори мени') }}">
                        <i class="fas fa-bars text-xl" x-show="!mobileMenuOpen"></i>
                        <i class="fas fa-times text-xl" x-show="mobileMenuOpen" x-cloak></i>
                    </button>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen" 
                 x-cloak 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="md:hidden border-t border-white/20 bg-white/95 backdrop-blur-sm">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2 hover:bg-gray-100 rounded transition-colors" style="color: #252525;">
                        {{ __sr('nav_home', 'Početna', 'Почетна') }}
                    </a>
                    <a href="{{ route('business.index') }}" class="block px-3 py-2 hover:bg-gray-100 rounded transition-colors" style="color: #252525;">
                        {{ __sr('nav_businesses', 'Biznisi', 'Бизниси') }}
                    </a>
                    <a href="{{ route('category.index') }}" class="block px-3 py-2 hover:bg-gray-100 rounded transition-colors" style="color: #252525;">
                        {{ __sr('nav_categories', 'Kategorije', 'Категорије') }}
                    </a>
                    
                    <!-- Mobile Language Switcher -->
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <div class="px-3 py-2 text-sm" style="color: #252525;">{{ __sr('language', 'Jezik', 'Језик') }}:</div>
                        <a href="{{ request()->fullUrlWithQuery(['lang' => 'lat']) }}" 
                           class="block px-3 py-2 hover:bg-gray-100 rounded {{ app()->getLocale() === 'lat' ? 'bg-blue-50 text-primary' : '' }}" style="color: #252525;">
                            {{ __sr('latin_script', 'Latinica', 'Latinica') }}
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['lang' => 'cir']) }}" 
                           class="block px-3 py-2 hover:bg-gray-100 rounded {{ app()->getLocale() === 'cir' ? 'bg-blue-50 text-primary' : '' }}" style="color: #252525;">
                            {{ __sr('cyrillic_script', 'Ћирилица', 'Ћирилица') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content - uklonjen padding-top jer hero ide uz vrh -->
    <main id="main-content" role="main">
        @yield('content')
    </main>

        <!-- Footer -->
        <footer class="bg-footer text-white mt-16" role="contentinfo">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- About -->
                    <div class="md:col-span-2">
                        <div class="flex items-center mb-4">
    <img src="{{ asset('storage/images/fond-logo.png') }}" style="width: 50px; height: 40px;" alt="Logo" class="object-contain mr-3"> 
    <span class="text-xl font-bold">{{ __sr('site_name', 'Fond INVRS Biznis Mreža', 'Фонд ИНВРС Бизнис Мрежа') }}</span>
</div>
                        <p class="text-blue-100 mb-4">
                            {{ __sr('footer_description', 'Platforma koja povezuje invalide i njihove biznise sa zajednicom, omogućavajući im lakše pronalaženje podrške i resursa.', 'Платформа која повезује инвалиде и њихове бизнисе са заједницом, омогућавајући им лакше проналажење подршке и ресурса.') }}
                        </p>
                    </div>
                    
                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">{{ __sr('quick_links', 'Brze veze', 'Брзе везе') }}</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-blue-100 hover:text-white transition-colors">{{ __sr('nav_home', 'Početna', 'Почетна') }}</a></li>
                            <li><a href="{{ route('business.index') }}" class="text-blue-100 hover:text-white transition-colors">{{ __sr('nav_businesses', 'Biznisi', 'Бизниси') }}</a></li>
                            <li><a href="{{ route('category.index') }}" class="text-blue-100 hover:text-white transition-colors">{{ __sr('nav_categories', 'Kategorije', 'Категорије') }}</a></li>
                            <li><a href="{{ route('business.create') }}" class="text-blue-100 hover:text-white transition-colors">{{ __sr('nav_add_business', 'Prijavite Biznis', 'Пријавите Бизнис') }}</a></li>
                        </ul>
                    </div>
                    
                    <!-- Contact -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">{{ __sr('contact', 'Kontakt', 'Контакт') }}</h3>
                        <ul class="space-y-2 text-blue-100">
                            <li><i class="fas fa-envelope mr-2"></i> fond@fondinvrs.org</li>
                            <li><i class="fas fa-phone mr-2"></i> 052/240-951</li>
                            <li><i class="fas fa-map-marker-alt mr-2"></i> {{ __sr('location', 'Kralja Aleksandra bb, Prijedor', 'Краља Александра бб, Приједор') }}</li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-blue-300 mt-8 pt-8 text-center text-blue-100">
                    <p>&copy; {{ date('Y') }} {{ __sr('site_name', 'Fond INVRS Biznis Mreža', 'Фонд ИНВРС Бизнис Мрежа') }}. {{ __sr('all_rights_reserved', 'Sva prava zadržana.', 'Сва права задржана.') }}</p>
					<span>Kreirao </span><a href="https://qodevision.com" target="_blank" rel="noopener noreferrer" style="color: #FFF;">QODE VISION</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- NOVO: Accessibility Helper Script -->
    <script src="{{ asset('js/accessibility-helper.js') }}" defer></script>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>