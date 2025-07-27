// accessibility-helper.js - Dodati u public/js/accessibility-helper.js

class AccessibilityHelper {
    constructor() {
        this.settings = {
            fontSize: 100,
            contrast: 'normal',
            background: 'normal',
            fontFamily: 'normal'
        };
        
        this.init();
        this.loadSettings();
    }

    init() {
        this.createSidebar();
        this.attachEventListeners();
        this.createStyles();
    }

    createSidebar() {
        // Sticky accessibility button
        const accessButton = document.createElement('button');
        accessButton.id = 'accessibility-button';
        accessButton.innerHTML = `
            <i class="fas fa-wheelchair"></i>
            <span class="sr-only">Opcije pristupačnosti</span>
        `;
        accessButton.className = 'accessibility-button';
        
        // Accessibility sidebar
        const sidebar = document.createElement('div');
        sidebar.id = 'accessibility-sidebar';
        sidebar.className = 'accessibility-sidebar closed';
        
        const currentScript = document.documentElement.lang === 'sr-Cyrl' ? 'cyrillic' : 'latin';
        
        sidebar.innerHTML = `
            <div class="accessibility-header">
                <h3>${currentScript === 'cyrillic' ? 'Подешавања приступачности' : 'Podešavanja pristupačnosti'}</h3>
                <button id="close-accessibility" class="close-btn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="accessibility-content">
                <!-- Font Size Controls -->
                <div class="accessibility-group">
                    <h4>${currentScript === 'cyrillic' ? 'Величина текста' : 'Veličina teksta'}</h4>
                    <div class="font-controls">
                        <button class="accessibility-btn" data-action="decrease-font">
                            <i class="fas fa-minus"></i>
                            ${currentScript === 'cyrillic' ? 'Смањи' : 'Smanji'}
                        </button>
                        <span id="font-size-display">100%</span>
                        <button class="accessibility-btn" data-action="increase-font">
                            <i class="fas fa-plus"></i>
                            ${currentScript === 'cyrillic' ? 'Повећај' : 'Povećaj'}
                        </button>
                    </div>
                </div>

                <!-- Contrast Controls -->
                <div class="accessibility-group">
                    <h4>${currentScript === 'cyrillic' ? 'Контраст' : 'Kontrast'}</h4>
                    <div class="contrast-controls">
                        <button class="accessibility-btn" data-action="gray-contrast">
                            ${currentScript === 'cyrillic' ? 'Сива нијанса' : 'Siva nijansa'}
                        </button>
                        <button class="accessibility-btn" data-action="high-contrast">
                            ${currentScript === 'cyrillic' ? 'Велики контраст' : 'Veliki kontrast'}
                        </button>
                        <button class="accessibility-btn" data-action="negative-contrast">
                            ${currentScript === 'cyrillic' ? 'Негативни контраст' : 'Negativni kontrast'}
                        </button>
                    </div>
                </div>

                <!-- Background Controls -->
                <div class="accessibility-group">
                    <h4>${currentScript === 'cyrillic' ? 'Позадина' : 'Pozadina'}</h4>
                    <button class="accessibility-btn" data-action="light-background">
                        ${currentScript === 'cyrillic' ? 'Светла позадина' : 'Svetla pozadina'}
                    </button>
                </div>

                <!-- Font Family Controls -->
                <div class="accessibility-group">
                    <h4>${currentScript === 'cyrillic' ? 'Фонт' : 'Font'}</h4>
                    <button class="accessibility-btn" data-action="readable-font">
                        ${currentScript === 'cyrillic' ? 'Читљив фонт' : 'Čitljiv font'}
                    </button>
                </div>

                <!-- Reset -->
                <div class="accessibility-group">
                    <button class="accessibility-btn reset-btn" data-action="reset">
                        <i class="fas fa-undo"></i>
                        ${currentScript === 'cyrillic' ? 'Ресетуј' : 'Resetuj'}
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(accessButton);
        document.body.appendChild(sidebar);
    }

    createStyles() {
        const style = document.createElement('style');
        style.textContent = `
            /* Accessibility Button */
            .accessibility-button {
                position: fixed;
                left: 20px;
                top: 50%;
                transform: translateY(-50%);
                width: 50px;
                height: 50px;
                background: #2265CD;
                color: white;
                border: none;
                border-radius: 50%;
                cursor: pointer;
                z-index: 9999;
                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                transition: all 0.3s ease;
                font-size: 18px;
                /* Fix for filter issues */
                will-change: transform;
                backface-visibility: hidden;
                transform-style: preserve-3d;
            }

            /* Fix for contrast filters affecting fixed positioning */
            body.accessibility-gray-contrast .accessibility-button,
            body.accessibility-high-contrast .accessibility-button,
            body.accessibility-negative-contrast .accessibility-button {
                position: fixed !important;
                left: 20px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                z-index: 10000 !important;
            }

            .accessibility-button:hover {
                background: #0252CC;
                transform: translateY(-50%) scale(1.1);
            }

            /* Accessibility Sidebar */
            .accessibility-sidebar {
                position: fixed;
                left: -350px;
                top: 0;
                width: 350px;
                height: 100vh;
                background: white;
                border-right: 1px solid #e5e7eb;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
                z-index: 9998;
                transition: left 0.3s ease;
                overflow-y: auto;
                /* Fix for filter issues */
                will-change: left;
                backface-visibility: hidden;
                transform-style: preserve-3d;
            }

            /* Fix for contrast filters affecting sidebar positioning */
            body.accessibility-gray-contrast .accessibility-sidebar,
            body.accessibility-high-contrast .accessibility-sidebar,
            body.accessibility-negative-contrast .accessibility-sidebar {
                position: fixed !important;
                z-index: 9999 !important;
            }

            body.accessibility-gray-contrast .accessibility-sidebar.open,
            body.accessibility-high-contrast .accessibility-sidebar.open,
            body.accessibility-negative-contrast .accessibility-sidebar.open {
                left: 0 !important;
            }

            .accessibility-sidebar.open {
                left: 0;
            }

            .accessibility-header {
                padding: 20px;
                background: #f8fafc;
                border-bottom: 1px solid #e5e7eb;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .accessibility-header h3 {
                margin: 0;
                font-size: 18px;
                font-weight: 600;
                color: #1f2937;
            }

            .close-btn {
                background: none;
                border: none;
                font-size: 18px;
                cursor: pointer;
                color: #6b7280;
                padding: 5px;
                border-radius: 4px;
            }

            .close-btn:hover {
                background: #e5e7eb;
                color: #1f2937;
            }

            .accessibility-content {
                padding: 20px;
            }

            .accessibility-group {
                margin-bottom: 24px;
            }

            .accessibility-group h4 {
                margin: 0 0 12px 0;
                font-size: 16px;
                font-weight: 600;
                color: #374151;
            }

            .accessibility-btn {
                display: inline-block;
                margin: 4px 8px 4px 0;
                padding: 8px 16px;
                background: #f3f4f6;
                border: 1px solid #d1d5db;
                border-radius: 6px;
                color: #374151;
                cursor: pointer;
                font-size: 14px;
                transition: all 0.2s ease;
            }

            .accessibility-btn:hover {
                background: #e5e7eb;
                border-color: #9ca3af;
            }

            .accessibility-btn.active {
                background: #2265CD;
                color: white;
                border-color: #2265CD;
            }

            .font-controls {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .contrast-controls {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .contrast-controls .accessibility-btn {
                margin: 0;
                width: 100%;
            }

            #font-size-display {
                font-weight: 600;
                color: #374151;
                min-width: 45px;
                text-align: center;
            }

            .reset-btn {
                width: 100%;
                background: #dc2626 !important;
                color: white !important;
                border-color: #dc2626 !important;
            }

            .reset-btn:hover {
                background: #b91c1c !important;
                border-color: #b91c1c !important;
            }

            /* Accessibility Effects */
            body.accessibility-large-font {
                font-size: 120% !important;
            }

            body.accessibility-gray-contrast {
                filter: grayscale(100%);
            }

            body.accessibility-high-contrast {
                filter: contrast(150%) brightness(1.2);
            }

            body.accessibility-negative-contrast {
                filter: invert(1) hue-rotate(180deg);
            }

            /* ВАЖНО: Изузеци за fixed елементе када су активни филтери */
            body.accessibility-gray-contrast .accessibility-button,
            body.accessibility-high-contrast .accessibility-button,
            body.accessibility-negative-contrast .accessibility-button {
                filter: none !important; /* Уклони филтер са иконице */
                position: fixed !important;
                left: 20px !important;
                top: 50vh !important;
                transform: translateY(-50%) !important;
                z-index: 99999 !important;
            }

            body.accessibility-gray-contrast .accessibility-sidebar,
            body.accessibility-high-contrast .accessibility-sidebar,
            body.accessibility-negative-contrast .accessibility-sidebar {
                filter: none !important; /* Уклони филтер са sidebar-а */
                position: fixed !important;
                z-index: 99998 !important;
            }

            body.accessibility-gray-contrast .accessibility-overlay,
            body.accessibility-high-contrast .accessibility-overlay,
            body.accessibility-negative-contrast .accessibility-overlay {
                filter: none !important; /* Уклони филтер са overlay-а */
                position: fixed !important;
                z-index: 99997 !important;
            }

            body.accessibility-light-background {
                background-color: #ffffff !important;
            }

            body.accessibility-light-background * {
                background-color: transparent !important;
            }

            body.accessibility-light-background .bg-primary,
            body.accessibility-light-background .bg-blue-600,
            body.accessibility-light-background .bg-blue-500 {
                background-color: #2265CD !important;
            }

            body.accessibility-readable-font,
            body.accessibility-readable-font * {
                font-family: 'Arial', 'Helvetica', sans-serif !important;
                font-weight: 400 !important;
            }

            body.accessibility-readable-font h1,
            body.accessibility-readable-font h2,
            body.accessibility-readable-font h3,
            body.accessibility-readable-font h4,
            body.accessibility-readable-font h5,
            body.accessibility-readable-font h6 {
                font-weight: 600 !important;
            }

            /* Font size scaling */
            body.font-size-80 { font-size: 80% !important; }
            body.font-size-90 { font-size: 90% !important; }
            body.font-size-100 { font-size: 100% !important; }
            body.font-size-110 { font-size: 110% !important; }
            body.font-size-120 { font-size: 120% !important; }
            body.font-size-130 { font-size: 130% !important; }
            body.font-size-140 { font-size: 140% !important; }
            body.font-size-150 { font-size: 150% !important; }

            /* Screen reader only text */
            .sr-only {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                white-space: nowrap;
                border: 0;
            }

            /* Overlay for sidebar */
            .accessibility-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 9997;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                /* Fix for filter issues */
                will-change: opacity;
                backface-visibility: hidden;
            }

            /* Fix for contrast filters affecting overlay */
            body.accessibility-gray-contrast .accessibility-overlay,
            body.accessibility-high-contrast .accessibility-overlay,
            body.accessibility-negative-contrast .accessibility-overlay {
                position: fixed !important;
                z-index: 9998 !important;
            }

            .accessibility-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            /* Additional fixes for filter-affected elements */
            body.accessibility-gray-contrast,
            body.accessibility-high-contrast,
            body.accessibility-negative-contrast {
                /* Create new stacking context to isolate filters */
                transform: translateZ(0);
            }

            /* Ensure fixed elements stay fixed when filters are applied */
            body.accessibility-gray-contrast .accessibility-button,
            body.accessibility-high-contrast .accessibility-button,
            body.accessibility-negative-contrast .accessibility-button {
                /* Force hardware acceleration */
                transform: translateY(-50%) translateZ(0);
                -webkit-transform: translateY(-50%) translateZ(0);
            }

            body.accessibility-gray-contrast .accessibility-button:hover,
            body.accessibility-high-contrast .accessibility-button:hover,
            body.accessibility-negative-contrast .accessibility-button:hover {
                transform: translateY(-50%) scale(1.1) translateZ(0);
                -webkit-transform: translateY(-50%) scale(1.1) translateZ(0);
            }

            /* Mobile responsive */
            @media (max-width: 768px) {
                .accessibility-sidebar {
                    width: 100%;
                    left: -100%;
                }
                
                .accessibility-button {
                    left: 10px;
                    width: 45px;
                    height: 45px;
                    font-size: 16px;
                }
            }
        `;
        document.head.appendChild(style);
    }

    attachEventListeners() {
        const button = document.getElementById('accessibility-button');
        const sidebar = document.getElementById('accessibility-sidebar');
        const closeBtn = document.getElementById('close-accessibility');

        // Create overlay
        const overlay = document.createElement('div');
        overlay.className = 'accessibility-overlay';
        document.body.appendChild(overlay);

        // Open sidebar
        button.addEventListener('click', () => {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            button.style.display = 'none'; // Hide button when sidebar is open
            document.body.style.overflow = 'hidden';
        });

        // Close sidebar
        const closeSidebar = () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            button.style.display = 'block'; // Show button when sidebar is closed
            document.body.style.overflow = '';
        };

        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        // ESC key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        });

        // Accessibility controls
        sidebar.addEventListener('click', (e) => {
            const action = e.target.closest('[data-action]')?.dataset.action;
            if (action) {
                this.handleAction(action, e.target.closest('[data-action]'));
            }
        });
    }

    handleAction(action, button) {
        switch (action) {
            case 'increase-font':
                this.increaseFontSize();
                break;
            case 'decrease-font':
                this.decreaseFontSize();
                break;
            case 'gray-contrast':
                this.toggleContrast('gray', button);
                break;
            case 'high-contrast':
                this.toggleContrast('high', button);
                break;
            case 'negative-contrast':
                this.toggleContrast('negative', button);
                break;
            case 'light-background':
                this.toggleBackground(button);
                break;
            case 'readable-font':
                this.toggleFont(button);
                break;
            case 'reset':
                this.reset();
                break;
        }
        this.saveSettings();
    }

    increaseFontSize() {
        if (this.settings.fontSize < 150) {
            this.settings.fontSize += 10;
            this.applyFontSize();
        }
    }

    decreaseFontSize() {
        if (this.settings.fontSize > 80) {
            this.settings.fontSize -= 10;
            this.applyFontSize();
        }
    }

    applyFontSize() {
        // Remove existing font size classes
        document.body.className = document.body.className.replace(/font-size-\d+/g, '');
        
        // Add new font size class
        document.body.classList.add(`font-size-${this.settings.fontSize}`);
        
        // Update display
        const display = document.getElementById('font-size-display');
        if (display) {
            display.textContent = `${this.settings.fontSize}%`;
        }
    }

    toggleContrast(type, button) {
        // Remove all contrast classes
        document.body.classList.remove('accessibility-gray-contrast', 'accessibility-high-contrast', 'accessibility-negative-contrast');
        
        // Remove active state from all contrast buttons
        document.querySelectorAll('[data-action*="contrast"]').forEach(btn => {
            btn.classList.remove('active');
        });

        if (this.settings.contrast === type) {
            // Turn off if already active
            this.settings.contrast = 'normal';
        } else {
            // Apply new contrast
            this.settings.contrast = type;
            document.body.classList.add(`accessibility-${type}-contrast`);
            button.classList.add('active');
            
            // Fix positioning after applying filters
            this.fixPositioningAfterFilters();
        }
    }

    toggleBackground(button) {
        if (this.settings.background === 'light') {
            document.body.classList.remove('accessibility-light-background');
            button.classList.remove('active');
            this.settings.background = 'normal';
        } else {
            document.body.classList.add('accessibility-light-background');
            button.classList.add('active');
            this.settings.background = 'light';
        }
    }

    toggleFont(button) {
        if (this.settings.fontFamily === 'readable') {
            document.body.classList.remove('accessibility-readable-font');
            button.classList.remove('active');
            this.settings.fontFamily = 'normal';
        } else {
            document.body.classList.add('accessibility-readable-font');
            button.classList.add('active');
            this.settings.fontFamily = 'readable';
        }
    }

    reset() {
        this.settings = {
            fontSize: 100,
            contrast: 'normal',
            background: 'normal',
            fontFamily: 'normal'
        };

        // Remove all accessibility classes
        document.body.className = document.body.className.replace(/accessibility-\w+/g, '');
        document.body.className = document.body.className.replace(/font-size-\d+/g, '');
        
        // Reset button states
        document.querySelectorAll('.accessibility-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Update font size display
        const display = document.getElementById('font-size-display');
        if (display) {
            display.textContent = '100%';
        }

        this.saveSettings();
    }

    saveSettings() {
        localStorage.setItem('accessibility-settings', JSON.stringify(this.settings));
    }

    loadSettings() {
        const saved = localStorage.getItem('accessibility-settings');
        if (saved) {
            this.settings = { ...this.settings, ...JSON.parse(saved) };
            this.applySettings();
        }
    }

    applySettings() {
        // Apply font size
        if (this.settings.fontSize !== 100) {
            this.applyFontSize();
        }

        // Apply contrast
        if (this.settings.contrast !== 'normal') {
            document.body.classList.add(`accessibility-${this.settings.contrast}-contrast`);
            const button = document.querySelector(`[data-action="${this.settings.contrast}-contrast"]`);
            if (button) button.classList.add('active');
            
            // Force repositioning of fixed elements after applying filters
            this.fixPositioningAfterFilters();
        }

        // Apply background
        if (this.settings.background === 'light') {
            document.body.classList.add('accessibility-light-background');
            const button = document.querySelector('[data-action="light-background"]');
            if (button) button.classList.add('active');
        }

        // Apply font
        if (this.settings.fontFamily === 'readable') {
            document.body.classList.add('accessibility-readable-font');
            const button = document.querySelector('[data-action="readable-font"]');
            if (button) button.classList.add('active');
        }
    }

    /**
     * Fix positioning issues after applying CSS filters
     */
    fixPositioningAfterFilters() {
        // Force reflow to fix positioning issues
        setTimeout(() => {
            const button = document.getElementById('accessibility-button');
            const sidebar = document.getElementById('accessibility-sidebar');
            
            if (button) {
                // Force hardware acceleration and proper positioning
                button.style.transform = 'translateY(-50%) translateZ(0)';
                button.style.webkitTransform = 'translateY(-50%) translateZ(0)';
                
                // Trigger reflow
                button.offsetHeight;
            }
            
            if (sidebar) {
                // Ensure sidebar positioning is correct
                sidebar.style.transform = 'translateZ(0)';
                sidebar.style.webkitTransform = 'translateZ(0)';
                
                // Trigger reflow
                sidebar.offsetHeight;
            }
        }, 50);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new AccessibilityHelper();
});