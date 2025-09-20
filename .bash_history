# Aller dans le répertoire du projet
cd /var/www/csar-platform
# Vérifier le statut Git
git status
# Voir les fichiers avec des conflits
git diff --name-only --diff-filter=U
# Résoudre les conflits dans les fichiers affectés
# Commençons par vérifier quels fichiers ont des conflits
grep -r "<<<<<<< HEAD" resources/views/ || echo "Aucun conflit trouvé dans resources/views/"
grep -r "<<<<<<< HEAD" public/ || echo "Aucun conflit trouvé dans public/"
# D'abord, configurer Git pour ce répertoire
git config --global --add safe.directory /var/www/csar-platform
# Vérifier le statut
git status
# Voir les fichiers avec des conflits
grep -r "<<<<<<< HEAD" resources/views/ | head -10
# Supprimer automatiquement tous les marqueurs de conflit
find resources/views/ -name "*.blade.php" -exec sed -i '/<<<<<<< HEAD/,/>>>>>>> origin\/main/d' {} \;
# Vérifier qu'il n'y a plus de conflits
grep -r "<<<<<<< HEAD" resources/views/ || echo "Aucun conflit trouvé"
# Nettoyer les caches Laravel
php artisan config:clear
php artisan view:clear
php artisan cache:clear
# Tester l'application
curl http://153.92.211.42
./deploy-responsive.sh
cd /var/www/csar-platform
cat > public/css/responsive-complete.css << 'EOF'
/* ========================================
   CSAR PLATFORM - RESPONSIVE COMPLETE
   Mobile-First Design
   ======================================== */

/* ========================================
   BASE STYLES & RESET
   ======================================== */
* {
    box-sizing: border-box;
}

html {
    font-size: 16px;
    scroll-behavior: smooth;
}

body {
    margin: 0;
    padding: 0;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    line-height: 1.6;
    color: #333;
    overflow-x: hidden;
}

/* ========================================
   CONTAINER & LAYOUT
   ======================================== */
.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

@media (min-width: 768px) {
    .container {
        padding: 0 1.5rem;
    }
}

@media (min-width: 1024px) {
    .container {
        padding: 0 2rem;
    }
}

/* ========================================
   HEADER & NAVIGATION
   ======================================== */
.header-container {
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    max-width: 1200px;
    margin: 0 auto;
}

/* Logo responsive */
.logo-container img {
    max-width: 80px;
    height: auto;
    transition: all 0.3s ease;
}

@media (min-width: 768px) {
    .logo-container img {
        max-width: 120px;
    }
}

@media (min-width: 1024px) {
    .logo-container img {
        max-width: 150px;
    }
}

/* Desktop Navigation */
.nav-desktop {
    display: none;
    gap: 2rem;
    align-items: center;
}

.nav-desktop a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.nav-desktop a:hover {
    background: #f0f9ff;
    color: #0ea5e9;
}

@media (min-width: 1024px) {
    .nav-desktop {
        display: flex;
    }
}

/* Mobile Menu Button */
.mobile-menu-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.5rem;
    color: #333;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.mobile-menu-btn:hover {
    background: #f0f9ff;
    color: #0ea5e9;
}

@media (min-width: 1024px) {
    .mobile-menu-btn {
        display: none;
    }
}

/* Mobile Menu */
.mobile-menu {
    position: fixed;
    top: 0;
    right: -100%;
    width: 100%;
    max-width: 320px;
    height: 100vh;
    background: #fff;
    box-shadow: -5px 0 15px rgba(0,0,0,0.1);
    z-index: 1001;
    transition: right 0.3s ease;
    overflow-y: auto;
}

.mobile-menu.active {
    right: 0;
}

.mobile-menu-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
}

.mobile-menu-header .logo-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.mobile-menu-header .logo-container img {
    max-width: 40px;
    height: auto;
}

.logo-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
    color: #333;
}

.logo-subtitle {
    font-size: 0.75rem;
    color: #6b7280;
    margin: 0;
}

.mobile-menu-close {
    width: 44px;
    height: 44px;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.25rem;
    color: #6b7280;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.mobile-menu-close:hover {
    background: #f3f4f6;
    color: #333;
}

.mobile-nav {
    padding: 1rem 0;
}

.mobile-nav-item {
    display: block;
    padding: 1rem 1.5rem;
    text-decoration: none;
    color: #333;
    font-weight: 500;
    border-bottom: 1px solid #f3f4f6;
    transition: all 0.3s ease;
}

.mobile-nav-item:hover,
.mobile-nav-item.active {
    background: #f0f9ff;
    color: #0ea5e9;
    padding-left: 2rem;
}

/* Mobile Menu Overlay */
.mobile-menu-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.mobile-menu-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* ========================================
   FOOTER RESPONSIVE
   ======================================== */
.footer-responsive {
    background: linear-gradient(to right, #23ac0eff, #429237);
    color: white;
    margin-top: auto;
    width: 100%;
}

.footer-content {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem 1rem;
}

.footer-grid {
    display: grid;
    gap: 2rem;
    grid-template-columns: 1fr;
}

.footer-section {
    padding: 0;
}

.footer-logo-section {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.footer-logo {
    width: 44px;
    height: 44px;
    object-fit: contain;
    filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.25));
}

.footer-logo-text {
    font-size: 1.25rem;
    font-weight: 700;
    letter-spacing: 0.3px;
}

.footer-description {
    min-height: 46px;
    font-size: 0.875rem;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.95);
    margin-bottom: 1rem;
}

.footer-social {
    display: flex;
    gap: 0.625rem;
}

.social-link {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.18);
    transition: all 0.2s;
    color: white;
    text-decoration: none;
}

.social-link:hover {
    transform: scale(1.08);
    background: rgba(255, 255, 255, 0.25);
}

.footer-section-title {
    font-weight: 700;
    font-size: 0.9375rem;
    margin-bottom: 0.75rem;
    letter-spacing: 0.3px;
    color: white;
}

.footer-links {
    list-style: none;
    margin: 0;
    padding: 0;
    font-size: 0.875rem;
}

.footer-links li {
    margin-bottom: 0.5rem;
}

.footer-link {
    color: white;
    text-decoration: none;
    transition: all 0.2s;
    display: inline-block;
    padding: 0.25rem 0;
}

.footer-link:hover {
    text-decoration: underline;
}

.footer-link-with-icon {
    display: flex;
    align-items: center;
    gap: 0.625rem;
}

.footer-link-icon {
    width: 20px;
    height: 20px;
    object-fit: contain;
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.25));
    flex-shrink: 0;
}

.footer-link-external {
    font-size: 0.75rem;
    opacity: 0.85;
    margin-left: auto;
}

.footer-link-separator {
    margin-top: 0.5rem;
    padding-top: 0.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.15);
}

.footer-contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8125rem;
    color: rgba(255, 255, 255, 0.9);
    padding: 0.25rem 0;
}

.footer-contact-item i {
    width: 16px;
    text-align: center;
    flex-shrink: 0;
}

.footer-bottom {
    text-align: center;
    font-size: 0.75rem;
    padding: 0.875rem 1rem;
    background: rgba(0, 0, 0, 0.08);
    margin-top: 2rem;
}

.footer-bottom p {
    margin: 0;
    color: rgba(255, 255, 255, 0.8);
}

/* Footer responsive breakpoints */
@media (min-width: 768px) {
    .footer-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }
    
    .footer-content {
        padding: 2rem 1.5rem 1rem;
    }
}

@media (min-width: 1024px) {
    .footer-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
    }
    
    .footer-content {
        padding: 2rem 2rem 1rem;
    }
    
    .footer-section {
        padding-left: 0.75rem;
        border-left: 1px solid rgba(255, 255, 255, 0.15);
    }
    
    .footer-section:first-child {
        border-left: none;
        padding-left: 0;
    }
}
EOF

cat > public/css/mobile-tables.css << 'EOF'
/* ========================================
   MOBILE TABLES OPTIMIZATION
   ======================================== */

/* Table responsive par défaut */
.responsive-table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.responsive-table th,
.responsive-table td {
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

.responsive-table th {
    background: #f8fafc;
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.responsive-table tbody tr:hover {
    background: #f9fafb;
}

/* Mobile transformation */
@media (max-width: 768px) {
    .responsive-table {
        border: 0;
        box-shadow: none;
        background: transparent;
    }

    .responsive-table thead {
        display: none;
    }

    .responsive-table tbody tr {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        display: block;
        margin-bottom: 1rem;
        padding: 1rem;
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .responsive-table td {
        border: none;
        display: block;
        text-align: left !important;
        padding: 0.5rem 0;
        font-size: 0.875rem;
        position: relative;
        padding-left: 50%;
    }

    .responsive-table td::before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        font-weight: 600;
        color: #374151;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }

    .responsive-table td:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .responsive-table td:first-child {
        padding-top: 0;
    }
}

/* Tableaux avec actions */
.table-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .table-actions {
        justify-content: flex-start;
        margin-top: 0.5rem;
    }
    
    .table-actions .btn {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
}

/* Tableaux de données complexes */
.data-table {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

@media (max-width: 768px) {
    .data-table {
        overflow-x: visible;
    }
}
EOF

cat > public/css/mobile-forms.css << 'EOF'
/* ========================================
   MOBILE FORMS OPTIMIZATION
   ======================================== */

/* Base form styles */
.form-group,
.form-field {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #374151;
    font-size: 0.875rem;
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 1rem;
    transition: all 0.2s ease;
    background: white;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Mobile optimizations */
@media (max-width: 768px) {
    .form-group,
    .form-field {
        width: 100%;
        margin-bottom: 1rem;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 12px;
        font-size: 16px; /* Prevent zoom on iOS */
        box-sizing: border-box;
        border-radius: 8px;
    }

    /* Input types optimization */
    input[type="email"] {
        -webkit-appearance: none;
        appearance: none;
    }

    input[type="number"] {
        -moz-appearance: textfield; /* Firefox */
    }

    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="tel"] {
        -webkit-appearance: none;
        appearance: none;
    }

    /* Button optimizations */
    .btn,
    button[type="submit"],
    input[type="submit"] {
        width: 100%;
        min-height: 44px; /* Accessible touch target */
        padding: 12px 16px;
        font-size: 1rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    /* Form layout adjustments */
    .form-row {
        display: block;
    }

    .form-col {
        width: 100%;
        margin-bottom: 1rem;
    }

    /* Checkbox and radio buttons */
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .form-check-input {
        width: 20px;
        height: 20px;
        min-width: 20px;
    }

    .form-check-label {
        font-size: 0.875rem;
        line-height: 1.4;
    }

    /* File upload */
    .form-file {
        width: 100%;
    }

    .form-file-input {
        width: 100%;
        padding: 12px;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        background: #f9fafb;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .form-file-input:hover {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    /* Form validation */
    .form-input.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .form-input.is-valid {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: block;
    }

    .valid-feedback {
        color: #10b981;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: block;
    }
}

/* Tablet adjustments */
@media (min-width: 769px) and (max-width: 1024px) {
    .form-row {
        display: flex;
        gap: 1rem;
    }

    .form-col {
        flex: 1;
        margin-bottom: 0;
    }

    .btn,
    button[type="submit"],
    input[type="submit"] {
        width: auto;
        min-width: 120px;
    }
}

/* Desktop adjustments */
@media (min-width: 1025px) {
    .form-row {
        display: flex;
        gap: 1rem;
    }

    .form-col {
        flex: 1;
        margin-bottom: 0;
    }

    .btn,
    button[type="submit"],
    input[type="submit"] {
        width: auto;
        min-width: 120px;
    }
}
EOF

cat > public/js/mobile-responsive.js << 'EOF'
/**
 * CSAR Platform - Mobile Responsive JavaScript
 * Gestion du menu mobile et interactions responsive
 */

document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // MOBILE MENU FUNCTIONALITY
    // ========================================
    
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileMenuClose = document.getElementById('mobileMenuClose');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

    if (mobileMenuBtn && mobileMenu && mobileMenuClose && mobileMenuOverlay) {
        // Ouvrir le menu mobile
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.add('active');
            mobileMenuOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        // Fermer le menu mobile
        function closeMenu() {
            mobileMenu.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Fermer avec le bouton X
        mobileMenuClose.addEventListener('click', closeMenu);

        // Fermer en cliquant sur l'overlay
        mobileMenuOverlay.addEventListener('click', closeMenu);

        // Fermer en cliquant sur un lien
        mobileMenu.querySelectorAll('.mobile-nav-item').forEach(link => {
            link.addEventListener('click', closeMenu);
        });

        // Fermer avec la touche Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                closeMenu();
            }
        });
    }

    // ========================================
    // SMOOTH SCROLLING
    // ========================================
    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // ========================================
    // INTERSECTION OBSERVER FOR ANIMATIONS
    // ========================================
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);

    // Observer les éléments pour les animations
    document.querySelectorAll('.feature-card, .news-card, .stat-item, .service-card').forEach(el => {
        observer.observe(el);
    });

    // ========================================
    // FORM VALIDATION ENHANCEMENTS
    // ========================================
    
    // Validation en temps réel pour les formulaires
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateField(this);
                }
            });
        });
    });

    function validateField(field) {
        const value = field.value.trim();
        const type = field.type;
        const required = field.hasAttribute('required');
        
        // Reset classes
        field.classList.remove('is-valid', 'is-invalid');
        
        // Remove existing feedback
        const existingFeedback = field.parentNode.querySelector('.invalid-feedback, .valid-feedback');
        if (existingFeedback) {
            existingFeedback.remove();
        }
        
        // Validation rules
        let isValid = true;
        let message = '';
        
        if (required && !value) {
            isValid = false;
            message = 'Ce champ est obligatoire';
        } else if (value) {
            switch (type) {
                case 'email':
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        isValid = false;
                        message = 'Veuillez entrer une adresse email valide';
                    }
                    break;
                case 'tel':
                    const phoneRegex = /^[\+]?[0-9\s\-\(\)]{8,}$/;
                    if (!phoneRegex.test(value)) {
                        isValid = false;
                        message = 'Veuillez entrer un numéro de téléphone valide';
                    }
                    break;
                case 'number':
                    if (isNaN(value) || value < 0) {
                        isValid = false;
                        message = 'Veuillez entrer un nombre valide';
                    }
                    break;
            }
        }
        
        // Apply validation result
        if (isValid) {
            field.classList.add('is-valid');
            if (value) {
                const feedback = document.createElement('div');
                feedback.className = 'valid-feedback';
                feedback.textContent = '✓ Valide';
                field.parentNode.appendChild(feedback);
            }
        } else {
            field.classList.add('is-invalid');
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.textContent = message;
            field.parentNode.appendChild(feedback);
        }
    }

    // ========================================
    // TOUCH GESTURES
    // ========================================
    
    // Swipe to close mobile menu
    let startX = 0;
    let startY = 0;
    
    if (mobileMenu) {
        mobileMenu.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        });
        
        mobileMenu.addEventListener('touchend', function(e) {
            const endX = e.changedTouches[0].clientX;
            const endY = e.changedTouches[0].clientY;
            const diffX = startX - endX;
            const diffY = startY - endY;
            
            // Swipe right to close
            if (diffX < -100 && Math.abs(diffY) < 100) {
                closeMenu();
            }
        });
    }

    // ========================================
    // PERFORMANCE OPTIMIZATIONS
    // ========================================
    
    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // ========================================
    // ACCESSIBILITY ENHANCEMENTS
    // ========================================
    
    // Focus management for mobile menu
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            setTimeout(() => {
                const firstLink = mobileMenu.querySelector('.mobile-nav-item');
                if (firstLink) {
                    firstLink.focus();
                }
            }, 300);
        });
    }

    // Keyboard navigation for mobile menu
    if (mobileMenu) {
        mobileMenu.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                const focusableElements = mobileMenu.querySelectorAll('a, button, input, select, textarea');
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];
                
                if (e.shiftKey) {
                    if (document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement.focus();
                    }
                } else {
                    if (document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement.focus();
                    }
                }
            }
        });
    }

    console.log('🚀 CSAR Mobile Responsive JavaScript loaded successfully!');
});
EOF

php artisan config:clear
php artisan view:clear
php artisan cache:clear
chown -R www-data:www-data storage bootstrap/cache public
chmod -R 775 storage bootstrap/cache
rm -rf storage/framework/cache/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*
npm run build
curl -s http://153.92.211.42 | grep -A 5 -B 5 "Effectuer une demande"
find resources/views -name "*.blade.php" -exec grep -l "Effectuer une demande" {} \;
grep -A 10 -B 10 "Effectuer une demande" resources/views/home.blade.php
sed -i 's/<a href="#" class="hero-btn hero-btn-primary zoom-hover"/<a href="\/demande" class="hero-btn hero-btn-primary zoom-hover demande-btn"/g' resources/views/home.blade.php
grep -A 5 -B 5 "Effectuer une demande" resources/views/home.blade.php
mkdir -p resources/views/public
grep -A 10 -B 10 "Effectuer une de

grep -A 10 -B 10 "Effectuer une demande" resources/views/public/home.blade.php
sed -i 's/<a href="#" class="hero-btn hero-btn-primary zoom-hover"/<a href="\/demande" class="hero-btn hero-btn-primary zoom-hover demande-btn"/g' resources/views/public/home.blade.php
grep -A 5 -B 5 "Effectuer une demande" resources/views/public/home.blade.php
cat > resources/views/public/demande.blade.php << 'EOF'
@extends('layouts.public')

@section('title', 'Effectuer une demande - CSAR')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Effectuer une demande</h1>
        <p>Remplissez le formulaire ci-dessous pour soumettre votre demande au CSAR</p>
    </div>

    <div class="demande-form-container">
        <form action="{{ route('demande.submit') }}" method="POST" class="demande-form">
            @csrf
            
            <div class="form-section">
                <h3>Informations personnelles</h3>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="nom" class="form-label">Nom complet *</label>
                            <input type="text" id="nom" name="nom" class="form-input" required>
                        </div>
                    </div>
                    
                    <div class="form-col">
                        <div class="form-group">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" id="email" name="email" class="form-input" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="telephone" class="form-label">Téléphone *</label>
                            <input type="tel" id="telephone" name="telephone" class="form-input" required>
                        </div>
                    </div>
                    
                    <div class="form-col">
                        <div class="form-group">
                            <label for="region" class="form-label">Région *</label>
                            <select id="region" name="region" class="form-select" required>
                                <option value="">Sélectionner une région</option>
                                <option value="dakar">Dakar</option>
                                <option value="thies">Thiès</option>
                                <option value="diourbel">Diourbel</option>
                                <option value="fatick">Fatick</option>
                                <option value="kaffrine">Kaffrine</option>
                                <option value="kaolack">Kaolack</option>
                                <option value="kedougou">Kédougou</option>
                                <option value="kolda">Kolda</option>
                                <option value="louga">Louga</option>
                                <option value="matam">Matam</option>
                                <option value="saint-louis">Saint-Louis</option>
                                <option value="sedhiou">Sédhiou</option>
                                <option value="tambacounda">Tambacounda</option>
                                <option value="ziguinchor">Ziguinchor</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Détails de la demande</h3>
                
                <div class="form-group">
                    <label for="type_demande" class="form-label">Type de demande *</label>
                    <select id="type_demande" name="type_demande" class="form-select" required>
                        <option value="">Sélectionner un type</option>
                        <option value="aide-alimentaire">Aide alimentaire</option>
                        <option value="formation">Formation</option>
                        <option value="equipement">Équipement</option>
                        <option value="information">Information</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description de la demande *</label>
                    <textarea id="description" name="description" class="form-textarea" rows="5" required placeholder="Décrivez votre demande en détail..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="urgence" class="form-label">Niveau d'urgence</label>
                    <select id="urgence" name="urgence" class="form-select">
                        <option value="faible">Faible</option>
                        <option value="moyen" selected>Moyen</option>
                        <option value="eleve">Élevé</option>
                        <option value="critique">Critique</option>
                    </select>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Documents joints (optionnel)</h3>
                
                <div class="form-group">
                    <label for="documents" class="form-label">Fichiers</label>
                    <input type="file" id="documents" name="documents[]" class="form-file-input" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    <small class="form-help">Formats acceptés : PDF, DOC, DOCX, JPG, PNG (max 5MB par fichier)</small>
                </div>
            </div>
            
            <div class="form-section">
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" id="consentement" name="consentement" class="form-check-input" required>
                        <label for="consentement" class="form-check-label">
                            J'accepte que mes données soient traitées conformément à la politique de confidentialité du CSAR *
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-paper-plane"></i>
                    Soumettre la demande
                </button>
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Retour à l'accueil
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.page-header {
    text-align: center;
    margin: 2rem 0 3rem;
    padding: 2rem 0;
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    border-radius: 12px;
}

.page-header h1 {
    color: #1e293b;
    font-size: 2.5rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.page-header p {
    color: #64748b;
    font-size: 1.125rem;
    max-width: 600px;
    margin: 0 auto;
}

.demande-form-container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #e2e8f0;
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.form-section h3 {
    color: #1e293b;
    font-size: 1.25rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-section h3::before {
    content: '';
    width: 4px;
    height: 20px;
    background: linear-gradient(135deg, #23ac0eff, #429237);
    border-radius: 2px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
    margin-bottom: 1rem;
}

@media (min-width: 768px) {
    .form-row {
        grid-template-columns: repeat(2, 1fr);
    }
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.form-help {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
}

@media (max-width: 768px) {
    .page-header h1 {
        font-size: 2rem;
    }
    
    .demande-form-container {
        padding: 1.5rem;
        margin: 0 1rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
    }
}
</style>
@endsection
EOF

cat >> routes/web.php << 'EOF'

// Routes pour les demandes
Route::get('/demande', function () {
    return view('public.demande');
})->name('demande');

Route::post('/demande', function (Request $request) {
    // Validation des données
    $request->validate([
        'nom' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'telephone' => 'required|string|max:20',
        'region' => 'required|string',
        'type_demande' => 'required|string',
        'description' => 'required|string|min:10',
        'consentement' => 'required|accepted'
    ]);
    
    // Ici vous pouvez ajouter la logique pour sauvegarder la demande
    // Par exemple, envoyer un email, sauvegarder en base de données, etc.
    
    return redirect()->back()->with('success', 'Votre demande a été soumise avec succès ! Nous vous contacterons dans les plus brefs délais.');
})->name('demande.submit');
EOF

php artisan config:clear
php artisan view:clear
php artisan route:clear
npm run build
systemctl restart apache2
curl -I http://153.92.211.42/demande
curl -s http://153.92.211.42 | grep -A 3 -B 3 "Effectuer une demande"
tail -20 storage/logs/laravel.log
rm -f resources/views/public/demande.blade.php
cat > resources/views/public/demande.blade.php << 'EOF'
@extends('layouts.public')

@section('title', 'Effectuer une demande - CSAR')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Effectuer une demande</h1>
        <p>Remplissez le formulaire ci-dessous pour soumettre votre demande au CSAR</p>
    </div>

    <div class="demande-form-container">
        <form action="{{ route('demande.submit') }}" method="POST" class="demande-form">
            @csrf
            
            <div class="form-section">
                <h3>Informations personnelles</h3>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="nom" class="form-label">Nom complet *</label>
                            <input type="text" id="nom" name="nom" class="form-input" required>
                        </div>
                    </div>
                    
                    <div class="form-col">
                        <div class="form-group">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" id="email" name="email" class="form-input" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="telephone" class="form-label">Téléphone *</label>
                            <input type="tel" id="telephone" name="telephone" class="form-input" required>
                        </div>
                    </div>
                    
                    <div class="form-col">
                        <div class="form-group">
                            <label for="region" class="form-label">Région *</label>
                            <select id="region" name="region" class="form-select" required>
                                <option value="">Sélectionner une région</option>
                                <option value="dakar">Dakar</option>
                                <option value="thies">Thiès</option>
                                <option value="diourbel">Diourbel</option>
                                <option value="fatick">Fatick</option>
                                <option value="kaffrine">Kaffrine</option>
                                <option value="kaolack">Kaolack</option>
                                <option value="kedougou">Kédougou</option>
                                <option value="kolda">Kolda</option>
                                <option value="louga">Louga</option>
                                <option value="matam">Matam</option>
                                <option value="saint-louis">Saint-Louis</option>
                                <option value="sedhiou">Sédhiou</option>
                                <option value="tambacounda">Tambacounda</option>
                                <option value="ziguinchor">Ziguinchor</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Détails de la demande</h3>
                
                <div class="form-group">
                    <label for="type_demande" class="form-label">Type de demande *</label>
                    <select id="type_demande" name="type_demande" class="form-select" required>
                        <option value="">Sélectionner un type</option>
                        <option value="aide-alimentaire">Aide alimentaire</option>
                        <option value="formation">Formation</option>
                        <option value="equipement">Équipement</option>
                        <option value="information">Information</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description de la demande *</label>
                    <textarea id="description" name="description" class="form-textarea" rows="5" required placeholder="Décrivez votre demande en détail..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="urgence" class="form-label">Niveau d'urgence</label>
                    <select id="urgence" name="urgence" class="form-select">
                        <option value="faible">Faible</option>
                        <option value="moyen" selected>Moyen</option>
                        <option value="eleve">Élevé</option>
                        <option value="critique">Critique</option>
                    </select>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Documents joints (optionnel)</h3>
                
                <div class="form-group">
                    <label for="documents" class="form-label">Fichiers</label>
                    <input type="file" id="documents" name="documents[]" class="form-file-input" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    <small class="form-help">Formats acceptés : PDF, DOC, DOCX, JPG, PNG (max 5MB par fichier)</small>
                </div>
            </div>
            
            <div class="form-section">
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" id="consentement" name="consentement" class="form-check-input" required>
                        <label for="consentement" class="form-check-label">
                            J'accepte que mes données soient traitées conformément à la politique de confidentialité du CSAR *
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-paper-plane"></i>
                    Soumettre la demande
                </button>
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Retour à l'accueil
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.page-header {
    text-align: center;
    margin: 2rem 0 3rem;
    padding: 2rem 0;
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    border-radius: 12px;
}

.page-header h1 {
    color: #1e293b;
    font-size: 2.5rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.page-header p {
    color: #64748b;
    font-size: 1.125rem;
    max-width: 600px;
    margin: 0 auto;
}

.demande-form-container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #e2e8f0;
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.form-section h3 {
    color: #1e293b;
    font-size: 1.25rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-section h3::before {
    content: '';
    width: 4px;
    height: 20px;
    background: linear-gradient(135deg, #23ac0eff, #429237);
    border-radius: 2px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
    margin-bottom: 1rem;
}

@media (min-width: 768px) {
    .form-row {
        grid-template-columns: repeat(2, 1fr);
    }
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.form-help {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
}

@media (max-width: 768px) {
    .page-header h1 {
        font-size: 2rem;
    }
    
    .demande-form-container {
        padding: 1.5rem;
        margin: 0 1rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
    }
}
</style>
@endsection
EOF

ls -la resources/views/public/demande.blade.php
wc -l resources/views/public/demande.blade.php
php artisan config:clear
php artisan view:clear
php artisan route:clear
npm run build
systemctl restart apache
curl -I h
curl -s http://153.92.211.42 | grep -A 3 -B 3 "Effectuer une demande"
rm -f resources/views/public/demande.blade.php
nano resources/views/public/demande.blade.php
ls -la resources/views/public/demande.blade.php
wc -l resources/views/public/demande.blade.php
systemctl restart
php artisan config:clear
php artisan view:clear
php artisan route:clear
curl -I http://153.92.211.42/demande
curl -s http://153.92.211.42 | grep -A 3 -B 3 "Effectuer une demande"
rm -f resources/views/public/demande.blade.php
cat > resources/views/public/demande.blade.php << 'EOF'
@extends('layouts.public')

@section('title', 'Effectuer une demande - CSAR')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Effectuer une demande</h1>
        <p>Remplissez le formulaire ci-dessous pour soumettre votre demande au CSAR</p>
    </div>

    <div class="demande-form-container">
        <form action="{{ route('demande.submit') }}" method="POST" class="demande-form">
            @csrf
            
            <div class="form-section">
                <h3>Informations personnelles</h3>
                
                <div class="form-group">
                    <label for="nom" class="form-label">Nom complet *</label>
                    <input type="text" id="nom" name="nom" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" id="email" name="email" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="telephone" class="form-label">Téléphone *</label>
                    <input type="tel" id="telephone" name="telephone" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="region" class="form-label">Région *</label>
                    <select id="region" name="region" class="form-select" required>
                        <option value="">Sélectionner une région</option>
                        <option value="dakar">Dakar</option>
                        <option value="thies">Thiès</option>
                        <option value="diourbel">Diourbel</option>
                        <option value="fatick">Fatick</option>
                        <option value="kaffrine">Kaffrine</option>
                        <option value="kaolack">Kaolack</option>
                        <option value="kedougou">Kédougou</option>
                        <option value="kolda">Kolda</option>
                        <option value="louga">Louga</option>
                        <option value="matam">Matam</option>
                        <option value="saint-louis">Saint-Louis</option>
                        <option value="sedhiou">Sédhiou</option>
                        <option value="tambacounda">Tambacounda</option>
                        <option value="ziguinchor">Ziguinchor</option>
                    </select>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Détails de la demande</h3>
                
                <div class="form-group">
                    <label for="type_demande" class="form-label">Type de demande *</label>
                    <select id="type_demande" name="type_demande" class="form-select" required>
                        <option value="">Sélectionner un type</option>
                        <option value="aide-alimentaire">Aide alimentaire</option>
                        <option value="formation">Formation</option>
                        <option value="equipement">Équipement</option>
                        <option value="information">Information</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description de la demande *</label>
                    <textarea id="description" name="description" class="form-textarea" rows="5" required placeholder="Décrivez votre demande en détail..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="urgence" class="form-label">Niveau d'urgence</label>
                    <select id="urgence" name="urgence" class="form-select">
                        <option value="faible">Faible</option>
                        <option value="moyen" selected>Moyen</option>
                        <option value="eleve">Élevé</option>
                        <option value="critique">Critique</option>
                    </select>
                </div>
            </div>
            
            <div class="form-section">
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" id="consentement" name="consentement" class="form-check-input" required>
                        <label for="consentement" class="form-check-label">
                            J'accepte que mes données soient traitées conformément à la politique de confidentialité du CSAR *
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-paper-plane"></i>
                    Soumettre la demande
                </button>
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Retour à l'accueil
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.page-header {
    text-align: center;
    margin: 2rem 0 3rem;
    padding: 2rem 0;
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    border-radius: 12px;
}

.page-header h1 {
    color: #1e293b;
    font-size: 2.5rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.page-header p {
    color: #64748b;
    font-size: 1.125rem;
    max-width: 600px;
    margin: 0 auto;
}

.demande-form-container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #e2e8f0;
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.form-section h3 {
    color: #1e293b;
    font-size: 1.25rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #374151;
    font-size: 0.875rem;
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 1rem;
    transition: all 0.2s ease;
    background: white;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

.form-check {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
}

.form-check-input {
    width: 20px;
    height: 20px;
    min-width: 20px;
}

.form-check-label {
    font-size: 0.875rem;
    line-height: 1.4;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.btn {
    display: inline-block;
    padding: 12px 24px;
    background: #3b82f6;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 500;
    font-size: 1rem;
    text-align: center;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    min-height: 44px;
    box-sizing: border-box;
}

.btn:hover {
    background: #2563eb;
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

.btn-primary {
    background: linear-gradient(135deg, #23ac0eff, #429237);
    box-shadow: 0 2px 8px rgba(35, 172, 14, 0.2);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #1e9a0e, #3a7d2f);
    box-shadow: 0 4px 12px rgba(35, 172, 14, 0.3);
}

.btn-secondary {
    background: #6b7280;
}

.btn-secondary:hover {
    background: #4b5563;
}

.btn-lg {
    padding: 14px 28px;
    font-size: 1.125rem;
    min-height: 52px;
}

@media (max-width: 768px) {
    .page-header h1 {
        font-size: 2rem;
    }
    
    .demande-form-container {
        padding: 1.5rem;
        margin: 0 1rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
    }
}
</style>
@endsection
EOF

ls -la resources/views/public/demande.blade.php
wc -l resources/views/public/demande.blade.php
php artisan config:clear
php artisan view:clear
php a
systemctl restart apache2
curl -I http://153.92.211.42/demande
curl -s http://153.92.211.42 | grep -A 3 -B 3 "Effectuer une demande"
# Supprimer Nginx/Apache existant
apt remove --purge nginx* apache2* -y
apt autoremove -y
apt clean
# Supprimer Node.js ou autre restes
apt remove --purge nodejs npm git -y
apt autoremove -y
apt clean
# Supprimer anciens fichiers web
rm -rf /var/www/*
rm -rf /etc/nginx/sites-available/*
rm -rf /etc/nginx/sites-enabled/*
apt remove --purge nginx* apache2* -y
apt autoremove -y
apt clean
apt remove --purge nodejs npm git -y
apt autoremove -y
apt clean
rm -rf /var/www/*
rm -rf /etc/nginx/sites-available/*
rm -rf /etc/nginx/sites-enabled/*
rm -rf /var/www/*
rm -rf /etc/nginx/sites-available/*
rm -rf /etc/nginx/sites-enabled/*
rm -rf /var/www/*
rm -rf /etc/nginx/sites-available/*
rm -rf /etc/nginx/sites-enabled/*
rm -rf /var/www/*
sudo rm -rf /var/www/*
sudo rm -rf /etc/nginx/sites-available/*
sudo rm -rf /etc/nginx/sites-enabled/*
sudo rm -rf /var/www
sudo rm -rf /etc/nginx/sites-available
sudo rm -rf /etc/nginx/sites-enabled
sudo rm -rf /var/www
sudo rm -rf /etc/nginx/sites-available
sudo rm -rf /etc/nginx/sites-enabled
printf '%s' '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' > /root/.github_token && chmod 600 /root/.github_token
