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
	<!--<link href="{{ asset('css/animations.css') }}" rel="stylesheet"> -->
    
    <!-- Accessibility Helper -->
    <!-- Navbar scroll functionality -->
	
	<style>
        /* Override postojećih Tailwind klasa za šire kontejnere */
        .max-w-7xl {
            max-width: 88rem !important; /* 25% manji margine - povećano sa 80rem na 88rem */
        }
        
        /* Smanjeni padding za responzivnost */
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
        
        /* Alternative - kreiranje potpuno custom kontejnera */
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
    const logo = document.querySelector('.logo-text'); // Dodajte ovu klasu logo tekstu
    const ctaButton = document.querySelector('.cta-button');
    const isHomePage = window.location.pathname === '/' || window.location.pathname === '';
    
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
            
            // Logo boja kada se skrola - CRNA
            if (logo) {
                logo.style.color = '#2265CD';
            }
            
            // CTA button ostaje bijel tekst
            if (ctaButton) {
                ctaButton.style.color = '#fff';
            }
        } else {
            // Vrh stranice - transparentan
            navbar.classList.add('bg-transparent', 'border-transparent');
            navbar.classList.remove('bg-white', 'shadow-sm', 'border-gray-200');
            
            // Bijeli tekst za linkove
            navLinks.forEach(link => {
                link.classList.add('text-white', 'hover:text-blue-200');
                link.classList.remove('text-gray-700', 'hover:text-primary');
            });
            
            // Logo boja na vrhu - PLAVA
            if (logo) {
                logo.style.color = '#2265CD';
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
                logo.style.color = '#2265CD';
            }
            
            // CTA button ostaje bijel tekst
            if (ctaButton) {
                ctaButton.style.color = '#fff';
            }
        } else {
            // Vrh stranice - transparentan
            navbar.classList.remove('bg-transparent', 'border-transparent');
            navbar.classList.add('bg-white', 'shadow-sm', 'border-gray-200');
            
            // Tamni tekst za linkove
            navLinks.forEach(link => {
                link.classList.remove('text-white', 'hover:text-blue-200');
                link.classList.add('text-gray-700', 'hover:text-primary');
            });
            
            // Logo boja ovisno o stranici
            if (logo) {
                if (isHomePage) {
                    logo.style.color = '#2265CD'; // Plavo na početnoj
                } else {
                    logo.style.color = '#2265CD'; // Bijelo na ostalim
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
        
        /* Gradient border effect */
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
        
        /* Hover lift effect */
        .card:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: 0 20px 40px rgba(34, 101, 205, 0.2);
        }
        
        /* Icon container with animation */
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
        
        /* Number badge */
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
        
        /* Title styling */
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
        
        /* Description styling */
        .card p {
            color: #6b7280;
            line-height: 1.6;
            transition: color 0.3s ease;
        }
        
        .card:hover p {
            color: #4b5563;
        }
        
        /* Progress indicator */
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
        
        /* Mobile responsiveness */
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

/* Animirano stanje - vidljivo i na mestu */
.fade-in-left.animated {
    opacity: 1;
    transform: translateX(0);
}

.fade-in-bottom.animated {
    opacity: 1;
    transform: translateY(0);
}

/* Delay klase */
.delay-100 { transition-delay: 0.1s; }
.delay-200 { transition-delay: 0.2s; }
.delay-300 { transition-delay: 0.3s; }
.delay-400 { transition-delay: 0.4s; }
.delay-500 { transition-delay: 0.5s; }

/* Responsive - manji pomak na mobilnim */
@media (max-width: 768px) {
    .fade-in-left {
        transform: translateX(-30px);
    }
    
    .fade-in-bottom {
        transform: translateY(30px);
    }
}

/* Hover efekti za animirane elemente */
.fade-in-left.animated:hover,
.fade-in-bottom.animated:hover {
    transform: scale(1.02);
}

/* Smooth scroll */
html {
    scroll-behavior: smooth;
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
    <a href="{{ route('home') }}" class="flex items-center logo-link">
        <!-- Prvi logo - Fond INVRS -->
        <img src="{{ asset('storage/images/fond-logo.png') }}" 
             style="width: 60px; height: 50px;" 
             alt="Fond INVRS Logo" 
             class="h-8 w-auto mr-3" /> 
			 
		<!-- Drugi logo - Ministarstvo RS -->
        <img src="{{ asset('storage/images/rs-logo.png') }}" 
             style="width: 60px; height: 50px;" 
             alt="Ministarstvo Republike Srpske Logo" 
             class="h-8 w-auto mr-3" />
        
        <!-- Tekst logotipa -->
        <span class="logo-text text-xl font-bold transition-colors duration-300 mr-4" style="font-size: 1.375rem;">
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
	<!--<script src="{{ asset('js/animations.js') }}"></script> -->

    <!-- Additional Scripts -->
    @stack('scripts')
	
	
<script>
class BusinessImageUploader {
    constructor() {
        this.maxFiles = 10; // Maksimalno slika
        this.maxFileSize = 10 * 1024 * 1024; // 10MB
        this.allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        this.uploadedImages = [];
        this.isUploading = false;
        
        this.init();
    }

    init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setupEventListeners());
        } else {
            this.setupEventListeners();
        }
    }

    setupEventListeners() {
        const fileInput = document.getElementById('image-input');
        const uploadZone = document.getElementById('upload-zone');
        const clearAllBtn = document.getElementById('clear-all-images');
        const form = document.getElementById('business-form');

        if (!fileInput || !uploadZone) return;

        // File input change
        fileInput.addEventListener('change', (e) => this.handleFileSelection(e));

        // Drag & Drop
        this.setupDragAndDrop(uploadZone);

        // Clear all images
        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', () => this.clearAllImages());
        }

        // Form submit
        if (form) {
            form.addEventListener('submit', (e) => this.handleFormSubmit(e));
        }

        // Load existing images from session
        this.loadExistingImages();
    }

    setupDragAndDrop(uploadZone) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, this.preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadZone.addEventListener(eventName, () => {
                uploadZone.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, () => {
                uploadZone.classList.remove('dragover');
            });
        });

        uploadZone.addEventListener('drop', (e) => {
            const files = Array.from(e.dataTransfer.files);
            this.processFiles(files);
        });

        // Click to upload
        uploadZone.addEventListener('click', (e) => {
            if (e.target.closest('button') || e.target.closest('input')) return;
            document.getElementById('image-input').click();
        });
    }

    preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    handleFileSelection(e) {
        const files = Array.from(e.target.files);
        this.processFiles(files);
        e.target.value = ''; // Reset input
    }

    processFiles(files) {
        if (this.isUploading) {
            this.showError('Upload je već u toku. Molimo sačekajte.');
            return;
        }

        // Provjeri limit
        if (this.uploadedImages.length + files.length > this.maxFiles) {
            this.showError(`Možete uploadovati maksimalno ${this.maxFiles} slika. Trenutno imate ${this.uploadedImages.length}.`);
            return;
        }

        // Validiraj fajlove
        const validFiles = files.filter(file => this.validateFile(file));
        
        if (validFiles.length === 0) return;

        // Upload fajlove jedan po jedan
        this.uploadFiles(validFiles);
    }

    validateFile(file) {
        // Tip fajla
        if (!this.allowedTypes.includes(file.type)) {
            this.showError(`${file.name}: Nepodržan format. Koristite JPG, PNG ili WebP.`);
            return false;
        }

        // Veličina
        if (file.size > this.maxFileSize) {
            this.showError(`${file.name}: Fajl je prevelik. Maksimalno 10MB.`);
            return false;
        }

        return true;
    }

    async uploadFiles(files) {
        this.isUploading = true;
        this.showLoading(true);
        
        for (let file of files) {
            try {
                await this.uploadSingleFile(file);
            } catch (error) {
                console.error('Upload error:', error);
                this.showError(`Greška pri upload-u ${file.name}: ${error.message}`);
            }
        }
        
        this.isUploading = false;
        this.showLoading(false);
    }

    uploadSingleFile(file) {
        return new Promise((resolve, reject) => {
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            // VAŽNO: Koristi /biznisi/ URL umesto /business/
            fetch('/biznisi/upload-sliku', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.uploadedImages.push(data.image);
                    this.addImageToPreview(data.image);
                    this.updateImageCount();
                    resolve(data);
                } else {
                    reject(new Error(data.message || 'Upload failed'));
                }
            })
            .catch(error => {
                reject(error);
            });
        });
    }

    addImageToPreview(imageData) {
        const container = document.getElementById('uploaded-images-container');
        const grid = document.getElementById('uploaded-images-grid');
        
        if (!container || !grid) return;

        // Kreiraj image card
        const imageCard = this.createImageCard(imageData);
        grid.appendChild(imageCard);

        // Pokaži container
        container.classList.remove('hidden');
    }

    createImageCard(imageData) {
        const div = document.createElement('div');
        div.className = 'image-preview-card fade-in-left';
        div.dataset.imagePath = imageData.path;

        div.innerHTML = `
            <img src="${imageData.url}" alt="${imageData.original_name}" loading="lazy">
            
            <div class="image-actions">
                <button type="button" 
                        class="delete-image-btn" 
                        onclick="window.imageUploader.deleteImage('${imageData.path}')"
                        title="Obriši sliku">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-3">
                <p class="text-xs text-gray-600 truncate mb-1" title="${imageData.original_name}">
                    ${imageData.original_name}
                </p>
                <div class="flex justify-between text-xs text-gray-500">
                    <span>${imageData.info.width} × ${imageData.info.height}</span>
                    <span>${imageData.info.size_formatted}</span>
                </div>
                ${this.uploadedImages.length === 1 ? '<div class="text-xs text-blue-600 font-medium mt-1">Glavna slika</div>' : ''}
            </div>
        `;

        // Dodaj fade-in animaciju
        setTimeout(() => {
            div.classList.add('animated');
        }, 50);

        return div;
    }

    async deleteImage(imagePath) {
        if (!confirm('Da li ste sigurni da želite da obrišete ovu sliku?')) {
            return;
        }

        try {
            // VAŽNO: Koristi /biznisi/ URL umesto /business/
            const response = await fetch('/biznisi/obrisi-sliku', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ image_path: imagePath })
            });

            const data = await response.json();

            if (data.success) {
                // Ukloni iz array-a
                this.uploadedImages = this.uploadedImages.filter(img => img.path !== imagePath);
                
                // Ukloni iz DOM-a
                const imageCard = document.querySelector(`[data-image-path="${imagePath}"]`);
                if (imageCard) {
                    imageCard.style.opacity = '0';
                    imageCard.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        imageCard.remove();
                        this.updateImageCount();
                        this.updateMainImageLabels();
                    }, 200);
                }

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
            // VAŽNO: Koristi /biznisi/ URL umesto /business/
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

    async loadExistingImages() {
        try {
            // VAŽNO: Koristi /biznisi/ URL umesto /business/
            const response = await fetch('/biznisi/uploadovane-slike', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success && data.images.length > 0) {
                this.uploadedImages = data.images;
                
                data.images.forEach(imageData => {
                    this.addImageToPreview(imageData);
                });
                
                this.updateImageCount();
            }
        } catch (error) {
            console.error('Load existing images error:', error);
        }
    }

    updateImageCount() {
        const countEl = document.getElementById('images-count');
        if (countEl) {
            countEl.textContent = this.uploadedImages.length;
        }

        // Sakrij container ako nema slika
        if (this.uploadedImages.length === 0) {
            const container = document.getElementById('uploaded-images-container');
            if (container) {
                container.classList.add('hidden');
            }
        }
    }

    updateMainImageLabels() {
        const cards = document.querySelectorAll('.image-preview-card');
        cards.forEach((card, index) => {
            const mainLabel = card.querySelector('.text-blue-600');
            if (mainLabel) {
                mainLabel.remove();
            }

            if (index === 0) {
                const infoDiv = card.querySelector('.p-3');
                if (infoDiv) {
                    const label = document.createElement('div');
                    label.className = 'text-xs text-blue-600 font-medium mt-1';
                    label.textContent = 'Glavna slika';
                    infoDiv.appendChild(label);
                }
            }
        });
    }

    showLoading(show) {
        const loadingEl = document.getElementById('upload-loading');
        if (loadingEl) {
            if (show) {
                loadingEl.classList.remove('hidden');
            } else {
                loadingEl.classList.add('hidden');
            }
        }
    }

    showError(message) {
        this.clearMessages();
        
        const errorContainer = document.getElementById('image-errors');
        if (errorContainer) {
            errorContainer.innerHTML = `
                <div class="image-error fade-in-left">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span>${message}</span>
                    </div>
                </div>
            `;
            errorContainer.classList.remove('hidden');

            // Auto hide nakon 5 sekundi
            setTimeout(() => {
                this.clearMessages();
            }, 5000);
        }
    }

    showSuccess(message) {
        this.clearMessages();
        
        const errorContainer = document.getElementById('image-errors');
        if (errorContainer) {
            errorContainer.innerHTML = `
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg fade-in-left">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>${message}</span>
                    </div>
                </div>
            `;
            errorContainer.classList.remove('hidden');

            // Auto hide nakon 3 sekundi
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

        // Form će se submit-ovati normalno
        // Slike su već uploadovane i čuvaju se u session-u
    }
}

// Inicijalizuj uploader samo na create stranici
document.addEventListener('DOMContentLoaded', function() {
    // Provjeri da li smo na create stranici
    if (document.getElementById('business-form')) {
        // Kreiraj CSRF meta tag ako ne postoji
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.name = 'csrf-token';
            meta.content = document.querySelector('input[name="_token"]')?.value || '';
            document.head.appendChild(meta);
        }

        // Kreiraj global instancu
        window.imageUploader = new BusinessImageUploader();
    }
});

// Helper funkcije za global pristup
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

</body>
</html>