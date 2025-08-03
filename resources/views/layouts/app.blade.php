<!DOCTYPE html>
<html lang="{{ app()->getLocale() === 'cir' ? 'sr-Cyrl' : 'sr-Latn' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __sr('title', 'Platforma za Invalide', 'Платформа за Инвалиде'))</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	
	<style>
        .max-w-7xl {
            max-width: 88rem !important;
        }
        
        @media (min-width: 640px) {
            .sm\:px-6 {
                padding-left: 1.25rem !important;
                padding-right: 1.25rem !important;
            }
        }
        
        @media (min-width: 1024px) {
            .lg\:px-8 {
                padding-left: 1.75rem !important;
                padding-right: 1.75rem !important;
            }
        }
        
        .container-platform {
            max-width: 88rem;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        @media (min-width: 640px) {
            .container-platform {
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }
        }
        
        @media (min-width: 1024px) {
            .container-platform {
                padding-left: 1.75rem;
                padding-right: 1.75rem;
            }
        }
        
        @media (min-width: 1280px) {
            .container-platform {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }
    </style>
	
<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('nav');
    const navLinks = document.querySelectorAll('nav a:not(.logo-link)');
    const logo = document.querySelector('.logo-text'); 
    const ctaButton = document.querySelector('.cta-button');
    const isHomePage = window.location.pathname === '/' || window.location.pathname === '';
    
    function updateNavbar() {
        if (window.scrollY > 50) {
            navbar.classList.remove('bg-transparent', 'border-transparent');
            navbar.classList.add('bg-white', 'shadow-sm', 'border-gray-200');
            
            navLinks.forEach(link => {
                link.classList.remove('text-white', 'hover:text-blue-200');
                link.classList.add('text-gray-700', 'hover:text-primary');
            });
            
            if (logo) {
                logo.style.color = '#2265CD';
            }
            
            if (ctaButton) {
                ctaButton.style.color = '#fff';
            }
        } else {
            navbar.classList.add('bg-transparent', 'border-transparent');
            navbar.classList.remove('bg-white', 'shadow-sm', 'border-gray-200');
            
            navLinks.forEach(link => {
                link.classList.add('text-white', 'hover:text-blue-200');
                link.classList.remove('text-gray-700', 'hover:text-primary');
            });
            
            if (logo) {
                logo.style.color = '#2265CD';
            }
            
            if (ctaButton) {
                ctaButton.style.color = '#fff';
            }
        }
    }
    
    window.addEventListener('scroll', updateNavbar);
    
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
            navbar.classList.remove('bg-transparent', 'border-transparent');
            navbar.classList.add('bg-white', 'shadow-sm', 'border-gray-200');
            
            navLinks.forEach(link => {
                link.classList.remove('text-white', 'hover:text-blue-200');
                link.classList.add('text-gray-700', 'hover:text-primary');
            });
            
            if (logo) {
                logo.style.color = '#2265CD';
            }
            
            if (ctaButton) {
                ctaButton.style.color = '#fff';
            }
        } else {
            navbar.classList.remove('bg-transparent', 'border-transparent');
            navbar.classList.add('bg-white', 'shadow-sm', 'border-gray-200');
            
            navLinks.forEach(link => {
                link.classList.remove('text-white', 'hover:text-blue-200');
                link.classList.add('text-gray-700', 'hover:text-primary');
            });
            
            if (logo) {
                if (isHomePage) {
                    logo.style.color = '#2265CD'; 
                } else {
                    logo.style.color = '#2265CD'; 
                }
            }
            
            if (ctaButton) {
                ctaButton.style.color = '#fff';
            }
        }
    }
    
    window.addEventListener('scroll', updateNavbar);
    
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
        
        .search-form {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        
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

        body.font-size-110 nav .text-xl { font-size: calc(1.375rem * 1.1) !important; }
        body.font-size-120 nav .text-xl { font-size: calc(1.375rem * 1.2) !important; }
        body.font-size-130 nav .text-xl { font-size: calc(1.375rem * 1.3) !important; }
        body.font-size-140 nav .text-xl { font-size: calc(1.375rem * 1.4) !important; }
        body.font-size-150 nav .text-xl { font-size: calc(1.375rem * 1.5) !important; }

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
        
        @media (prefers-contrast: high) {
            .bg-primary { background-color: #000080; }
            .text-primary { color: #000080; }
            .border-primary { border-color: #000080; }
        }
        
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
        
        @media print {
            .accessibility-button,
            .accessibility-sidebar,
            .language-switcher,
            nav,
            footer {
                display: none !important;
            }
        }
		
		.card-container {
            perspective: 1000px;
        }
        
        .card {
            position: relative;
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        }
        
        .card::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 20px;
            padding: 2px;
            background: linear-gradient(135deg, #2265CD, #667eea, #f687b3);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }
        
        .card:hover::before {
            opacity: 1;
        }
        
        .card:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: 0 20px 40px rgba(34, 101, 205, 0.2);
        }
        
        .icon-wrapper {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .card:hover .icon-wrapper {
            transform: scale(1.1) rotate(5deg);
            background: linear-gradient(135deg, #2265CD, #667eea);
            box-shadow: 0 10px 30px rgba(34, 101, 205, 0.3);
        }
        
        .icon-wrapper img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            transition: all 0.3s ease;
            filter: brightness(0) saturate(100%) invert(26%) sepia(70%) saturate(1846%) hue-rotate(204deg) brightness(94%) contrast(93%);
        }
        
        .card:hover .icon-wrapper img {
            filter: brightness(0) saturate(100%) invert(100%);
            transform: scale(1.1);
        }
        
        .number-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #2265CD, #667eea);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(34, 101, 205, 0.3);
            transition: all 0.3s ease;
        }
        
        .card:hover .number-badge {
            transform: scale(1.2) rotate(-10deg);
            box-shadow: 0 6px 20px rgba(34, 101, 205, 0.4);
        }
        
        .card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            transition: color 0.3s ease;
        }
        
        .card:hover h3 {
            color: #2265CD;
        }
        
        .card p {
            color: #6b7280;
            line-height: 1.6;
            transition: color 0.3s ease;
        }
        
        .card:hover p {
            color: #4b5563;
        }
        
        .progress-line {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: #e5e7eb;
            border-radius: 0 0 20px 20px;
            overflow: hidden;
        }
        
        .progress-line::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, #2265CD, #667eea);
            transition: width 0.3s ease;
        }
        
        .card:hover .progress-line::after {
            width: 100%;
        }
        
        @media (max-width: 1024px) {
            .card:hover {
                transform: translateY(-5px);
            }
        }
    </style>
	
	<style>
.fade-in-left {
    opacity: 0;
    transform: translateX(-50px);
    transition: all 0.8s ease-out;
}

.fade-in-bottom {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s ease-out;
}

.fade-in-left.animated {
    opacity: 1;
    transform: translateX(0);
}

.fade-in-bottom.animated {
    opacity: 1;
    transform: translateY(0);
}

.delay-100 { transition-delay: 0.1s; }
.delay-200 { transition-delay: 0.2s; }
.delay-300 { transition-delay: 0.3s; }
.delay-400 { transition-delay: 0.4s; }
.delay-500 { transition-delay: 0.5s; }

@media (max-width: 768px) {
    .fade-in-left {
        transform: translateX(-30px);
    }
    
    .fade-in-bottom {
        transform: translateY(30px);
    }
}

.fade-in-left.animated:hover,
.fade-in-bottom.animated:hover {
    transform: scale(1.02);
}

html {
    scroll-behavior: smooth;
}
</style>
</head>
<body>
    <a href="#main-content" class="skip-link">
        {{ __sr('skip_to_content', 'Preskoči na glavni sadržaj', 'Прескочи на главни садржај') }}
    </a>

   <div x-data="{ mobileMenuOpen: false }" class="min-h-screen bg-gray-50">
    <nav class="bg-transparent border-transparent backdrop-blur-sm fixed top-0 w-full z-50 transition-all duration-300" role="navigation" aria-label="{{ __sr('main_navigation', 'Glavna navigacija', 'Главна навигација') }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
    <a href="{{ route('home') }}" class="flex items-center logo-link">
        <img src="{{ asset('storage/images/fond-logo.png') }}" 
             style="width: 60px; height: 50px;" 
             alt="Fond INVRS Logo" 
             class="h-8 w-auto mr-3" /> 
			 
		<img src="{{ asset('storage/images/rs-logo.png') }}" 
             style="width: 60px; height: 50px;" 
             alt="Ministarstvo Republike Srpske Logo" 
             class="h-8 w-auto mr-3" />
        
        <span class="logo-text text-xl font-bold transition-colors duration-300 mr-4" style="font-size: 1.375rem;">
            {{ __sr('site_name_short', 'Biznis mreža INVRS', 'Бизнис мрежа ИНВРС') }}
        </span>
    </a>
</div>
                
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
                    
                    <a href="{{ route('business.create') }}" class="font-semibold px-6 py-2 rounded-full transition-colors duration-300 hover:bg-blue-700" style="background-color: #2265CD; color: #fff; font-size: 1.125rem;">
                        {{ __sr('nav_add_business', 'Prijavi svoj biznis', 'Пријави свој бизнис') }}
                    </a>
                    
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
                
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="text-white hover:text-blue-200 transition-colors duration-300 flex items-center justify-center"
                            aria-label="{{ __sr('toggle_menu', 'Otvori/zatvori meni', 'Отвори/затвори мени') }}">
                        <i class="fas fa-bars text-xl" x-show="!mobileMenuOpen"></i>
                        <i class="fas fa-times text-xl" x-show="mobileMenuOpen" x-cloak></i>
                    </button>
                </div>
            </div>
            
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

    <main id="main-content" role="main">
        @yield('content')
    </main>

        <footer class="bg-footer text-white mt-16" role="contentinfo">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="md:col-span-2">
                        <div class="flex items-center mb-4">
    <img src="{{ asset('storage/images/fond-logo.png') }}" style="width: 50px; height: 40px;" alt="Logo" class="object-contain mr-3"> 
    <span class="text-xl font-bold">{{ __sr('site_name', 'Fond INVRS Biznis Mreža', 'Фонд ИНВРС Бизнис Мрежа') }}</span>
</div>
                        <p class="text-blue-100 mb-4">
                            {{ __sr('footer_description', 'Platforma koja povezuje invalide i njihove biznise sa zajednicom, omogućavajući im lakše pronalaženje podrške i resursa.', 'Платформа која повезује инвалиде и њихове бизнисе са заједницом, омогућавајући им лакше проналажење подршке и ресурса.') }}
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">{{ __sr('quick_links', 'Korisni linkovi', 'Корисни линкови') }}</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-blue-100 hover:text-white transition-colors">{{ __sr('nav_home', 'Početna', 'Почетна') }}</a></li>
                            <li><a href="{{ route('business.index') }}" class="text-blue-100 hover:text-white transition-colors">{{ __sr('nav_businesses', 'Biznisi', 'Бизниси') }}</a></li>
                            <li><a href="{{ route('category.index') }}" class="text-blue-100 hover:text-white transition-colors">{{ __sr('nav_categories', 'Kategorije', 'Категорије') }}</a></li>
                            <li><a href="{{ route('business.create') }}" class="text-blue-100 hover:text-white transition-colors">{{ __sr('nav_add_business', 'Prijavite Biznis', 'Пријавите Бизнис') }}</a></li>
                        </ul>
                    </div>
                    
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
					<span> {{ __sr('madeby', 'Kreirao', 'Креирао') }} </span><a href="https://qodevision.com" target="_blank" rel="noopener noreferrer" style="color: #FFF;">QODE VISION</a>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('js/accessibility-helper.js') }}" defer></script>

    @stack('scripts')
	
<script>
class BusinessImageUploader {
    constructor() {
        this.uploadedImages = [];
        this.init();
        if (this.isOnBusinessCreatePage()) {
            this.loadExistingImages();
        }
    }

    isOnBusinessCreatePage() {
        return window.location.pathname.includes('/prijavi') && 
               document.getElementById('business-form') !== null;
    }

    init() {
        const uploadZone = document.getElementById('upload-zone');
        const fileInput = document.getElementById('image-upload');
        const businessForm = document.getElementById('business-form');

        if (uploadZone && fileInput) {
            uploadZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadZone.classList.add('dragover');
            });

            uploadZone.addEventListener('dragleave', () => {
                uploadZone.classList.remove('dragover');
            });

            uploadZone.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadZone.classList.remove('dragover');
                const files = e.dataTransfer.files;
                this.handleFiles(files);
            });

            uploadZone.addEventListener('click', () => {
                fileInput.click();
            });

            fileInput.addEventListener('change', (e) => {
                this.handleFiles(e.target.files);
            });
        }

        if (businessForm) {
            businessForm.addEventListener('submit', (e) => {
                this.handleFormSubmit(e);
            });
        }
    }

    async loadExistingImages() {
        if (!this.isOnBusinessCreatePage()) {
            return;
        }

        try {
            const response = await fetch('/biznisi/uploadovane-slike', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });

            if (!response.ok) {
                if (response.status === 404) {
                    console.log('No existing images found in session - starting fresh');
                    return;
                }
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success && data.images && Array.isArray(data.images)) {
                this.uploadedImages = data.images;
                this.displayImages();
                this.updateImageCount();
                console.log(`Loaded ${data.images.length} existing images from session`);
            }
        } catch (error) {
            console.error('Error loading existing images:', error);
            this.uploadedImages = [];
        }
    }

    async handleFiles(files) {
        this.clearMessages();

        for (let file of files) {
            if (!this.validateFile(file)) continue;

            const formData = new FormData();
            formData.append('file', file);

            try {
                const response = await fetch('/biznisi/upload-sliku', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    this.uploadedImages.push(data.image);
                    this.displayImages();
                    this.updateImageCount();
                    this.showSuccess(`Slika "${file.name}" je uspešno uploadovana.`);
                } else {
                    this.showError(data.message || 'Greška pri upload-u slike.');
                }
            } catch (error) {
                console.error('Upload error:', error);
                this.showError(`Greška pri upload-u slike "${file.name}".`);
            }
        }
    }

    validateFile(file) {
        const maxSize = 10 * 1024 * 1024;
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

        if (!allowedTypes.includes(file.type)) {
            this.showError(`Fajl "${file.name}" nije podržan tip slike.`);
            return false;
        }

        if (file.size > maxSize) {
            this.showError(`Fajl "${file.name}" je prevelik. Maksimalna veličina je 10MB.`);
            return false;
        }

        if (this.uploadedImages.length >= 10) {
            this.showError('Možete uploadovati maksimalno 10 slika.');
            return false;
        }

        return true;
    }

    displayImages() {
        const container = document.getElementById('uploaded-images-container');
        const grid = document.getElementById('uploaded-images-grid');

        if (!container || !grid) return;

        if (this.uploadedImages.length === 0) {
            container.classList.add('hidden');
            return;
        }

        container.classList.remove('hidden');
        grid.innerHTML = '';

        this.uploadedImages.forEach((image, index) => {
            const div = document.createElement('div');
            div.className = 'image-preview-card';
            div.innerHTML = `
                <img src="${image.url}" alt="${image.name}">
                <div class="image-actions">
                    <button type="button" 
                            class="delete-image-btn"
                            onclick="deleteImage('${image.path}')"
                            title="Obriši sliku">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-2">
                    <p class="text-xs text-gray-600 truncate">${image.name}</p>
                    <p class="text-xs text-gray-500">${this.formatFileSize(image.size)}</p>
                    ${index === 0 ? '<p class="text-xs text-blue-600"><i class="fas fa-star mr-1"></i>Glavna slika</p>' : ''}
                </div>
            `;
            grid.appendChild(div);
        });
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    updateImageCount() {
        const countElements = document.querySelectorAll('.image-count');
        countElements.forEach(el => {
            el.textContent = this.uploadedImages.length;
        });

        const remainingElements = document.querySelectorAll('.remaining-count');
        remainingElements.forEach(el => {
            el.textContent = 10 - this.uploadedImages.length;
        });
    }

    async deleteImage(imagePath) {
        try {
            const response = await fetch('/biznisi/obrisi-sliku', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({path: imagePath})
            });

            const data = await response.json();

            if (data.success) {
                this.uploadedImages = this.uploadedImages.filter(img => img.path !== imagePath);
                this.displayImages();
                this.updateImageCount();
                this.showSuccess('Slika je uspešno obrisana.');
            } else {
                this.showError(data.message || 'Greška pri brisanju slike.');
            }
        } catch (error) {
            console.error('Delete error:', error);
            this.showError('Greška pri brisanju slike.');
        }
    }

    async clearAllImages() {
        if (this.uploadedImages.length === 0) return;

        if (!confirm(`Da li ste sigurni da želite da obrišete sve slike (${this.uploadedImages.length})?`)) {
            return;
        }

        try {
            const response = await fetch('/biznisi/obrisi-sve-slike', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.uploadedImages = [];
                document.getElementById('uploaded-images-grid').innerHTML = '';
                document.getElementById('uploaded-images-container').classList.add('hidden');
                this.updateImageCount();
                this.showSuccess('Sve slike su obrisane.');
            } else {
                this.showError(data.message || 'Greška pri brisanju slika.');
            }
        } catch (error) {
            console.error('Clear all error:', error);
            this.showError('Greška pri brisanju slika.');
        }
    }

    showError(message) {
        const container = document.getElementById('image-errors');
        if (container) {
            container.innerHTML = `
                <div class="image-error">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    ${message}
                </div>
            `;
            container.classList.remove('hidden');
            
            setTimeout(() => {
                this.clearMessages();
            }, 5000);
        }
    }

    showSuccess(message) {
        const container = document.getElementById('image-errors');
        if (container) {
            container.innerHTML = `
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i>
                    ${message}
                </div>
            `;
            container.classList.remove('hidden');
            
            setTimeout(() => {
                this.clearMessages();
            }, 3000);
        }
    }

    clearMessages() {
        const errorContainer = document.getElementById('image-errors');
        if (errorContainer) {
            errorContainer.innerHTML = '';
            errorContainer.classList.add('hidden');
        }
    }

    handleFormSubmit(e) {
        const submitBtn = document.getElementById('submit-button');
        const submitText = document.getElementById('submit-text');
        const submitLoading = document.getElementById('submit-loading');

        if (submitBtn && submitText && submitLoading) {
            submitText.classList.add('hidden');
            submitLoading.classList.remove('hidden');
            submitBtn.disabled = true;
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('business-form')) {
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.name = 'csrf-token';
            meta.content = document.querySelector('input[name="_token"]')?.value || '';
            document.head.appendChild(meta);
        }

        window.imageUploader = new BusinessImageUploader();
    }
});

window.deleteImage = function(imagePath) {
    if (window.imageUploader) {
        window.imageUploader.deleteImage(imagePath);
    }
};

window.clearAllImages = function() {
    if (window.imageUploader) {
        window.imageUploader.clearAllImages();
    }
};
</script>

<button id="back-to-top" 
        class="back-to-top-btn"
        title="{{ __sr('back_to_top', 'Vrati se na vrh', 'Врати се на врх') }}"
        aria-label="{{ __sr('back_to_top', 'Vrati se na vrh', 'Врати се на врх') }}">
    <i class="fas fa-chevron-up"></i>
</button>

<style>
.back-to-top-btn {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 3.5rem;
    height: 3.5rem;
    background: #2265CD;
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    z-index: 1000;
    box-shadow: 0 4px 15px rgba(34, 101, 205, 0.3);
    opacity: 0;
    visibility: hidden;
    transform: translateY(20px) scale(0.8);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.back-to-top-btn:hover {
    background: linear-gradient(135deg, #1a52b8, #2265CD);
    box-shadow: 0 6px 20px rgba(34, 101, 205, 0.4);
    transform: translateY(-2px) scale(1.05);
}

.back-to-top-btn:active {
    transform: translateY(0) scale(0.95);
}

.back-to-top-btn.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
	background: #2265CD !important;
}

.back-to-top-btn i {
    transition: transform 0.2s ease;
}

.back-to-top-btn:hover i {
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .back-to-top-btn {
        bottom: 1.5rem;
        right: 1.5rem;
        width: 3rem;
        height: 3rem;
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .back-to-top-btn {
        bottom: 1rem;
        right: 1rem;
        width: 2.5rem;
        height: 2.5rem;
        font-size: 0.9rem;
    }
}

@media (prefers-color-scheme: dark) {
    .back-to-top-btn {
        background: linear-gradient(135deg, #374151, #1f2937);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }
    
    .back-to-top-btn:hover {
        background: linear-gradient(135deg, #4b5563, #374151);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
    }
}

.back-to-top-btn:focus {
    outline: 2px solid #2265CD;
    outline-offset: 2px;
}

html {
    scroll-behavior: smooth;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const backToTopBtn = document.getElementById('back-to-top');
    
    if (!backToTopBtn) return;
    
    const scrollThreshold = 300;
    
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    function toggleBackToTop() {
        const scrolled = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrolled > scrollThreshold) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    }
    
    window.addEventListener('scroll', debounce(toggleBackToTop, 10));
    
    backToTopBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
        
        backToTopBtn.style.transform = 'scale(0.9)';
        setTimeout(() => {
            backToTopBtn.style.transform = '';
        }, 150);
    });
    
    backToTopBtn.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            backToTopBtn.click();
        }
    });
    
    toggleBackToTop();
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    backToTopBtn.classList.remove('show');
                }
            });
        }, {
            rootMargin: '0px 0px -100px 0px'
        });
        
        const header = document.querySelector('header, nav, .hero');
        if (header) {
            observer.observe(header);
        }
    }
});

window.scrollToTop = function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
};
</script>

</body>
</html>