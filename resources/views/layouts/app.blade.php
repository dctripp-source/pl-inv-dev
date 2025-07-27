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
    <script src="{{ asset('js/accessibility-helper.js') }}" defer></script>
    
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
        <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40" role="navigation" aria-label="{{ __sr('main_navigation', 'Glavna navigacija', 'Главна навигација') }}">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <i class="fas fa-wheelchair text-primary text-2xl mr-3"></i>
                            <span class="text-xl font-bold text-gray-900">
                                {{ __sr('site_name_short', 'Platforma', 'Платформа') }}
                            </span>
                        </a>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary transition-colors {{ request()->routeIs('home') ? 'text-primary font-semibold' : '' }}">
                            <i class="fas fa-home mr-2"></i> {{ __sr('nav_home', 'Početna', 'Почетна') }}
                        </a>
                        <a href="{{ route('business.index') }}" class="text-gray-700 hover:text-primary transition-colors {{ request()->routeIs('business.*') ? 'text-primary font-semibold' : '' }}">
                            <i class="fas fa-store mr-2"></i> {{ __sr('nav_businesses', 'Biznisi', 'Бизниси') }}
                        </a>
                        <a href="{{ route('category.index') }}" class="text-gray-700 hover:text-primary transition-colors {{ request()->routeIs('category.*') ? 'text-primary font-semibold' : '' }}">
                            <i class="fas fa-tags mr-2"></i> {{ __sr('nav_categories', 'Kategorije', 'Категорије') }}
                        </a>
                        <a href="{{ route('business.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-hover transition-colors">
                            <i class="fas fa-plus mr-2"></i> {{ __sr('nav_add_business', 'Prijavite Biznis', 'Пријавите Бизнис') }}
                        </a>
                        
                        <!-- Language Switcher -->
                        <div class="language-switcher" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    @click.away="open = false"
                                    class="flex items-center text-gray-700 hover:text-primary transition-colors"
                                    aria-haspopup="true"
                                    :aria-expanded="open">
                                <i class="fas fa-globe mr-2"></i>
                                <span>{{ app()->getLocale() === 'cir' ? 'Ћир' : 'Lat' }}</span>
                                <i class="fas fa-chevron-down ml-1 text-xs" :class="open ? 'rotate-180' : ''"></i>
                            </button>
                            
                            <div x-show="open" 
                                 x-cloak 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="language-dropdown"
                                 role="menu">
                                <a href="{{ request()->fullUrlWithQuery(['lang' => 'lat']) }}" 
                                   class="language-option {{ app()->getLocale() === 'lat' ? 'active' : '' }}"
                                   role="menuitem">
                                    <i class="fas fa-font mr-2"></i> {{ __sr('latin_script', 'Latinica', 'Latinica') }}
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['lang' => 'cir']) }}" 
                                   class="language-option {{ app()->getLocale() === 'cir' ? 'active' : '' }}"
                                   role="menuitem">
                                    <i class="fas fa-font mr-2"></i> {{ __sr('cyrillic_script', 'Ћирилица', 'Ћирилица') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" 
                                class="text-gray-700 hover:text-primary transition-colors flex items-center justify-center"
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
                     class="md:hidden border-t border-gray-200 bg-white">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 hover:text-primary rounded transition-colors">
                            <i class="fas fa-home mr-2"></i> {{ __sr('nav_home', 'Početna', 'Почетна') }}
                        </a>
                        <a href="{{ route('business.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 hover:text-primary rounded transition-colors">
                            <i class="fas fa-store mr-2"></i> {{ __sr('nav_businesses', 'Biznisi', 'Бизниси') }}
                        </a>
                        <a href="{{ route('category.index') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 hover:text-primary rounded transition-colors">
                            <i class="fas fa-tags mr-2"></i> {{ __sr('nav_categories', 'Kategorije', 'Категорије') }}
                        </a>
                        <a href="{{ route('business.create') }}" class="block px-3 py-2 bg-primary text-white rounded">
                            <i class="fas fa-plus mr-2"></i> {{ __sr('nav_add_business', 'Prijavite Biznis', 'Пријавите Бизнис') }}
                        </a>
                        
                        <!-- Mobile Language Switcher -->
                        <div class="border-t border-gray-200 pt-2 mt-2">
                            <div class="px-3 py-2 text-sm text-gray-500">{{ __sr('language', 'Jezik', 'Језик') }}:</div>
                            <a href="{{ request()->fullUrlWithQuery(['lang' => 'lat']) }}" 
                               class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded {{ app()->getLocale() === 'lat' ? 'bg-blue-50 text-primary' : '' }}">
                                <i class="fas fa-font mr-2"></i> {{ __sr('latin_script', 'Latinica', 'Latinica') }}
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['lang' => 'cir']) }}" 
                               class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded {{ app()->getLocale() === 'cir' ? 'bg-blue-50 text-primary' : '' }}">
                                <i class="fas fa-font mr-2"></i> {{ __sr('cyrillic_script', 'Ћирилица', 'Ћирилица') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
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
                            <i class="fas fa-wheelchair text-2xl mr-3"></i>
                            <span class="text-xl font-bold">{{ __sr('site_name', 'Platforma za Invalide', 'Платформа за Инвалиде') }}</span>
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
                            <li><i class="fas fa-envelope mr-2"></i> info@platforma.rs</li>
                            <li><i class="fas fa-phone mr-2"></i> +381 11 123 4567</li>
                            <li><i class="fas fa-map-marker-alt mr-2"></i> {{ __sr('location', 'Beograd, Srbija', 'Београд, Србија') }}</li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-blue-300 mt-8 pt-8 text-center text-blue-100">
                    <p>&copy; {{ date('Y') }} {{ __sr('site_name', 'Platforma za Invalide', 'Платформа за Инвалиде') }}. {{ __sr('all_rights_reserved', 'Sva prava zadržana.', 'Сва права задржана.') }}</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>