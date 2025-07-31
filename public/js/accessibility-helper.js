// accessibility-helper.js - Ažurirani za public/js/accessibility-helper.js

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
        // Kreiraj wrapper koji će biti izvan body filtera
        const accessibilityWrapper = document.createElement('div');
        accessibilityWrapper.id = 'accessibility-wrapper';
        accessibilityWrapper.style.cssText = `
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            pointer-events: none !important;
            z-index: 999999 !important;
            filter: none !important;
        `;

        // Sticky accessibility button
        const accessButton = document.createElement('button');
        accessButton.id = 'accessibility-button';
        accessButton.className = 'accessibility-button accessibility-no-scale';
        accessButton.style.cssText = `
            position: fixed !important;
            left: 20px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: 55px !important;
            height: 55px !important;
            background: #2265CD !important;
            color: white !important;
            border: none !important;
            border-radius: 50% !important;
            cursor: pointer !important;
            z-index: 10001 !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
            transition: all 0.3s ease !important;
            font-size: 33px !important;
            pointer-events: auto !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        `;
        accessButton.innerHTML = `
            <i class="fas fa-wheelchair" style="font-size: 25px !important;"></i>
            <span class="sr-only">Opcije pristupačnosti</span>
        `;
        
        // Accessibility sidebar
        const sidebar = document.createElement('div');
        sidebar.id = 'accessibility-sidebar';
        sidebar.className = 'accessibility-sidebar accessibility-no-scale closed';
        sidebar.style.cssText = `
            position: fixed !important;
            left: -350px !important;
            top: 0 !important;
            width: 350px !important;
            height: 100vh !important;
            background: white !important;
            border-right: 1px solid #e5e7eb !important;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1) !important;
            z-index: 10000 !important;
            transition: left 0.3s ease !important;
            overflow-y: auto !important;
            pointer-events: auto !important;
        `;
        
        // Overlay
        const overlay = document.createElement('div');
        overlay.className = 'accessibility-overlay';
        overlay.style.cssText = `
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: rgba(0,0,0,0.5) !important;
            z-index: 9999 !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transition: all 0.3s ease !important;
            pointer-events: auto !important;
        `;
        
        const currentScript = document.documentElement.lang === 'sr-Cyrl' ? 'cyrillic' : 'latin';
        
        sidebar.innerHTML = `
            <div class="accessibility-header accessibility-no-scale">
                <h3 class="accessibility-no-scale">${currentScript === 'cyrillic' ? 'Подешавања приступачности' : 'Podešavanja pristupačnosti'}</h3>
                <button id="close-accessibility" class="close-btn accessibility-no-scale">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="accessibility-content accessibility-no-scale">
                <!-- Font Size Controls -->
                <div class="accessibility-group accessibility-no-scale">
                    <h4 class="accessibility-no-scale">${currentScript === 'cyrillic' ? 'Величина текста' : 'Veličina teksta'}</h4>
                    <div class="font-controls accessibility-no-scale">
                        <button class="accessibility-btn accessibility-no-scale" data-action="decrease-font">
                            <i class="fas fa-minus"></i>
                            ${currentScript === 'cyrillic' ? 'Смањи' : 'Smanji'}
                        </button>
                        <span id="font-size-display" class="accessibility-no-scale">100%</span>
                        <button class="accessibility-btn accessibility-no-scale" data-action="increase-font">
                            <i class="fas fa-plus"></i>
                            ${currentScript === 'cyrillic' ? 'Повећај' : 'Povećaj'}
                        </button>
                    </div>
                </div>

                <!-- Contrast Controls -->
                <div class="accessibility-group accessibility-no-scale">
                    <h4 class="accessibility-no-scale">${currentScript === 'cyrillic' ? 'Контраст' : 'Kontrast'}</h4>
                    <div class="contrast-controls accessibility-no-scale">
                        <button class="accessibility-btn accessibility-no-scale" data-action="gray-contrast">
                            ${currentScript === 'cyrillic' ? 'Сива нијанса' : 'Siva nijansa'}
                        </button>
                        <button class="accessibility-btn accessibility-no-scale" data-action="high-contrast">
                            ${currentScript === 'cyrillic' ? 'Велики контраст' : 'Veliki kontrast'}
                        </button>
                        <button class="accessibility-btn accessibility-no-scale" data-action="negative-contrast">
                            ${currentScript === 'cyrillic' ? 'Негативни контраст' : 'Negativni kontrast'}
                        </button>
                    </div>
                </div>

                <!-- Background Controls -->
                <div class="accessibility-group accessibility-no-scale">
                    <h4 class="accessibility-no-scale">${currentScript === 'cyrillic' ? 'Позадина' : 'Pozadina'}</h4>
                    <button class="accessibility-btn accessibility-no-scale" data-action="light-background">
                        ${currentScript === 'cyrillic' ? 'Светла позадина' : 'Svetla pozadina'}
                    </button>
                </div>

                <!-- Font Family Controls -->
                <div class="accessibility-group accessibility-no-scale">
                    <h4 class="accessibility-no-scale">${currentScript === 'cyrillic' ? 'Фонт' : 'Font'}</h4>
                    <button class="accessibility-btn accessibility-no-scale" data-action="readable-font">
                        ${currentScript === 'cyrillic' ? 'Читљив фонт' : 'Čitljiv font'}
                    </button>
                </div>

                <!-- Reset -->
                <div class="accessibility-group accessibility-no-scale">
                    <button class="accessibility-btn reset-btn accessibility-no-scale" data-action="reset">
                        <i class="fas fa-undo"></i>
                        ${currentScript === 'cyrillic' ? 'Ресетуј' : 'Resetuj'}
                    </button>
                </div>
            </div>
        `;

        // Dodaj sve u wrapper, a ne direktno u body
        accessibilityWrapper.appendChild(accessButton);
        accessibilityWrapper.appendChild(sidebar);
        accessibilityWrapper.appendChild(overlay);
        
        // Dodaj wrapper u body
        document.body.appendChild(accessibilityWrapper);
    }

    createStyles() {
        const style = document.createElement('style');
        style.textContent = `
            /* JEDNOSTAVNI CSS - samo osnovni stilovi */
            .accessibility-button:hover {
                background: #0252CC !important;
                transform: translateY(-50%) scale(1.1) !important;
            }

            .accessibility-button.hidden {
                opacity: 0 !important;
                visibility: hidden !important;
            }

            .accessibility-header {
                padding: 20px !important;
                background: #f8fafc !important;
                border-bottom: 1px solid #e5e7eb !important;
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
            }

            .accessibility-header h3 {
                margin: 0 !important;
                font-size: 18px !important;
                font-weight: 600 !important;
                color: #1f2937 !important;
            }

            .close-btn {
                background: none !important;
                border: none !important;
                font-size: 18px !important;
                cursor: pointer !important;
                color: #6b7280 !important;
                padding: 5px !important;
                border-radius: 4px !important;
            }

            .close-btn:hover {
                background: #e5e7eb !important;
                color: #1f2937 !important;
            }

            .accessibility-content {
                padding: 20px !important;
            }

            .accessibility-group {
                margin-bottom: 24px !important;
            }

            .accessibility-group h4 {
                margin: 0 0 12px 0 !important;
                font-size: 16px !important;
                font-weight: 600 !important;
                color: #374151 !important;
            }

            .accessibility-btn {
                display: inline-block !important;
                margin: 4px 8px 4px 0 !important;
                padding: 8px 16px !important;
                background: #f3f4f6 !important;
                border: 1px solid #d1d5db !important;
                border-radius: 6px !important;
                color: #374151 !important;
                cursor: pointer !important;
                font-size: 14px !important;
                transition: all 0.2s ease !important;
            }

            .accessibility-btn:hover {
                background: #e5e7eb !important;
                border-color: #9ca3af !important;
            }

            .accessibility-btn.active {
                background: #2265CD !important;
                color: white !important;
                border-color: #2265CD !important;
            }

            .font-controls {
                display: flex !important;
                align-items: center !important;
                gap: 12px !important;
            }

            .contrast-controls {
                display: flex !important;
                flex-direction: column !important;
                gap: 8px !important;
            }

            .contrast-controls .accessibility-btn {
                margin: 0 !important;
                width: 100% !important;
            }

            #font-size-display {
                font-weight: 600 !important;
                color: #374151 !important;
                min-width: 45px !important;
                text-align: center !important;
            }

            .reset-btn {
                width: 100% !important;
                background: #dc2626 !important;
                color: white !important;
                border-color: #dc2626 !important;
            }

            .reset-btn:hover {
                background: #b91c1c !important;
                border-color: #b91c1c !important;
            }

            /* Accessibility Effects */
            body.accessibility-gray-contrast {
                filter: grayscale(100%);
            }

            body.accessibility-high-contrast {
                filter: contrast(150%) brightness(1.2);
            }

            body.accessibility-negative-contrast {
                filter: invert(1) hue-rotate(180deg);
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

            /* NE SKALIRAJU SE accessibility komponente */
            .accessibility-no-scale,
            .accessibility-no-scale *,
            body[class*="font-size"] .accessibility-no-scale,
            body[class*="font-size"] .accessibility-no-scale * {
                font-size: initial !important;
            }

            .sr-only {
                position: absolute !important;
                width: 1px !important;
                height: 1px !important;
                padding: 0 !important;
                margin: -1px !important;
                overflow: hidden !important;
                clip: rect(0, 0, 0, 0) !important;
                white-space: nowrap !important;
                border: 0 !important;
            }
        `;
        document.head.appendChild(style);
    }

    attachEventListeners() {
        const button = document.getElementById('accessibility-button');
        const sidebar = document.getElementById('accessibility-sidebar');
        const closeBtn = document.getElementById('close-accessibility');
        const overlay = document.querySelector('.accessibility-overlay');

        // Open sidebar
        button.addEventListener('click', () => {
            sidebar.style.left = '0px';
            overlay.style.opacity = '1';
            overlay.style.visibility = 'visible';
            button.style.opacity = '0';
            button.style.visibility = 'hidden';
            document.body.style.overflow = 'hidden';
        });

        // Close sidebar
        const closeSidebar = () => {
            sidebar.style.left = '-350px';
            overlay.style.opacity = '0';
            overlay.style.visibility = 'hidden';
            button.style.opacity = '1';
            button.style.visibility = 'visible';
            document.body.style.overflow = '';
        };

        closeBtn.addEventListener('click', closeSidebar);
        
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                closeSidebar();
            }
        });

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

        // Scale specific elements manually for better control (excluding accessibility elements)
        this.scaleSpecificElements();
    }

    scaleSpecificElements() {
        const scale = this.settings.fontSize / 100;
        
        // Scale hero sections (excluding accessibility elements)
        const heroTitles = document.querySelectorAll('.hero h1:not(.accessibility-no-scale), .hero-section h1:not(.accessibility-no-scale), .text-3xl:not(.accessibility-no-scale), .text-4xl:not(.accessibility-no-scale), .text-5xl:not(.accessibility-no-scale)');
        heroTitles.forEach(title => {
            const baseSize = parseFloat(window.getComputedStyle(title).fontSize);
            title.style.fontSize = `${baseSize * scale}px`;
        });

        // Scale navigation (excluding accessibility elements)
        const navItems = document.querySelectorAll('nav a:not(.accessibility-no-scale), nav button:not(.accessibility-no-scale), nav .text-xl:not(.accessibility-no-scale)');
        navItems.forEach(item => {
            if (!item.closest('.accessibility-sidebar') && !item.classList.contains('accessibility-no-scale')) {
                const baseSize = parseFloat(window.getComputedStyle(item).fontSize);
                item.style.fontSize = `${baseSize * scale}px`;
            }
        });

        // Scale card titles (excluding accessibility elements)
        const cardTitles = document.querySelectorAll('.card h2:not(.accessibility-no-scale), .card h3:not(.accessibility-no-scale), .business-card h2:not(.accessibility-no-scale), .business-card h3:not(.accessibility-no-scale)');
        cardTitles.forEach(title => {
            const baseSize = parseFloat(window.getComputedStyle(title).fontSize);
            title.style.fontSize = `${baseSize * scale}px`;
        });
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

        // Reset manual scaling (excluding accessibility elements)
        const scaledElements = document.querySelectorAll('[style*="font-size"]:not(.accessibility-no-scale)');
        scaledElements.forEach(element => {
            if (!element.closest('.accessibility-sidebar') && !element.classList.contains('accessibility-no-scale')) {
                element.style.fontSize = '';
            }
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
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new AccessibilityHelper();
});