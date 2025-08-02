/**
 * PRILAGOĐENE ANIMACIJE ZA VAŠ DIZAJN
 * Dodajte ovaj kod u vašu glavnu JavaScript datoteku
 */

class PageAnimations {
    constructor() {
        this.init();
    }

    init() {
        // Čekamo da se DOM učita
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setupAnimations());
        } else {
            this.setupAnimations();
        }
    }

    setupAnimations() {
        // Osnovne animacije na učitavanje stranice
        this.setupPageLoadAnimations();
        
        // Scroll-triggered animacije
        this.setupScrollAnimations();
        
        // Hover efekti
        this.setupHoverEffects();
        
        // Staggered animacije za kartice
        this.setupStaggeredAnimations();
    }

    setupPageLoadAnimations() {
        // Hero sekcija animacije
        const heroTitle = document.querySelector('h1');
        const heroSubtitle = document.querySelector('.hero p, .hero-section p');
        const heroButton = document.querySelector('.hero .btn, .hero-section .btn, .hero .button, .hero-section .button');

        if (heroTitle) {
            heroTitle.classList.add('hero-title');
        }
        if (heroSubtitle) {
            heroSubtitle.classList.add('hero-subtitle');
        }
        if (heroButton) {
            heroButton.classList.add('hero-cta');
        }

        // Navigacija animacije
        const navLinks = document.querySelectorAll('nav a, .nav-link');
        navLinks.forEach((link, index) => {
            link.style.opacity = '0';
            link.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                link.style.transition = 'all 0.5s ease-out';
                link.style.opacity = '1';
                link.style.transform = 'translateY(0)';
            }, 100 + (index * 100));
        });
    }

    setupStaggeredAnimations() {
        // Kartice ispod hero sekcije
        const cards = document.querySelectorAll('.grid > div, .feature-card, .card');
        
        cards.forEach((card, index) => {
            // Dodaj klasu za animaciju
            card.classList.add('feature-card');
            
            // Animiraj svaku karticu s kašnjenjem
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateX(0) rotateY(0deg)';
            }, 200 + (index * 200));
        });

        // Kategorije grid - wave efekat
        const categoryCards = document.querySelectorAll('.categories-grid .card, .grid .category-card');
        categoryCards.forEach((card, index) => {
            card.classList.add('category-card');
            
            // Wave pattern animacija
            const delay = Math.floor(index / 4) * 100 + (index % 4) * 100;
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0) scale(1)';
            }, delay);
        });
    }

    setupScrollAnimations() {
        // Intersection Observer za scroll animacije
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    
                    // Različite animacije za različite elemente
                    if (target.classList.contains('scroll-fade-up')) {
                        target.classList.add('visible');
                    }
                    if (target.classList.contains('scroll-fade-left')) {
                        target.classList.add('visible');
                    }
                    if (target.classList.contains('scroll-fade-right')) {
                        target.classList.add('visible');
                    }
                    if (target.classList.contains('scroll-scale-in')) {
                        target.classList.add('visible');
                    }
                    
                    // Staggered animacija za child elemente
                    if (target.classList.contains('stagger-container')) {
                        const children = target.children;
                        Array.from(children).forEach((child, index) => {
                            setTimeout(() => {
                                child.style.opacity = '1';
                                child.style.transform = 'translateY(0)';
                            }, index * 100);
                        });
                    }
                }
            });
        }, observerOptions);

        // Automatski dodaj scroll animacije na sekcije
        const sections = document.querySelectorAll('section, .section');
        sections.forEach((section, index) => {
            if (index === 0) return; // Preskačemo hero sekciju
            
            section.classList.add('scroll-fade-up');
            observer.observe(section);
        });

        // Dodaj scroll animacije na kartice
        const scrollCards = document.querySelectorAll('.card:not(.feature-card):not(.category-card)');
        scrollCards.forEach((card, index) => {
            const animationType = index % 3 === 0 ? 'scroll-fade-up' : 
                                index % 3 === 1 ? 'scroll-fade-left' : 'scroll-fade-right';
            card.classList.add(animationType);
            observer.observe(card);
        });
    }

    setupHoverEffects() {
        // Magnetic efekat za dugmad
        const buttons = document.querySelectorAll('.btn, .button, button');
        buttons.forEach(button => {
            button.classList.add('magnetic-btn');
            
            button.addEventListener('mouseenter', (e) => {
                e.target.style.transform = 'translateY(-3px) scale(1.02)';
            });
            
            button.addEventListener('mouseleave', (e) => {
                e.target.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Glow efekat za važne elemente
        const importantElements = document.querySelectorAll('.primary, .featured, .highlight');
        importantElements.forEach(element => {
            element.classList.add('glow-element');
        });

        // Hover animacije za kartice
        const hoverCards = document.querySelectorAll('.card, .feature-card, .category-card');
        hoverCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-8px) scale(1.02)';
                card.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.15)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
                card.style.boxShadow = '';
            });
        });
    }

    // Dodaj animaciju za novi sadržaj (AJAX učitavanje)
    animateNewContent(container) {
        const elements = container.querySelectorAll('*');
        elements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                element.style.transition = 'all 0.5s ease-out';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 50);
        });
    }

    // Reset animacija za reload stranice
    resetAnimations() {
        const animatedElements = document.querySelectorAll('.animated, .visible');
        animatedElements.forEach(element => {
            element.classList.remove('animated', 'visible');
        });
    }
}

// Inicijaliziraj animacije
const pageAnimations = new PageAnimations();

// Export za mogućnost korišćenja u drugim fajlovima
if (typeof module !== 'undefined' && module.exports) {
    module.exports = PageAnimations;
}

/**
 * DODATNE FUNKCIJE ZA SPECIJALNE SLUČAJEVE
 */

// Animacija za loading spinner
function showLoading(element) {
    element.innerHTML = `
        <div class="loading-spinner">
            <div class="spinner"></div>
        </div>
    `;
}

// Animacija za notifikacije
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Dodaj u DOM
    document.body.appendChild(notification);
    
    // Animiraj ulazak
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateY(0)';
    }, 10);
    
    // Ukloni nakon 3 sekunde
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Smooth scroll sa animacijom
function smoothScrollTo(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
        
        // Dodaj highlight animaciju
        element.style.background = 'rgba(34, 101, 205, 0.1)';
        setTimeout(() => {
            element.style.background = '';
        }, 2000);
    }
}

// Animacija za form submission
function animateFormSubmission(form) {
    const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
    if (submitButton) {
        submitButton.style.transform = 'scale(0.95)';
        submitButton.style.opacity = '0.7';
        
        setTimeout(() => {
            submitButton.style.transform = 'scale(1)';
            submitButton.style.opacity = '1';
        }, 200);
    }
}