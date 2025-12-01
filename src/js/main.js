// TechPC Store - Main JavaScript File

// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    initMobileMenu();

    // Smooth Scrolling
    initSmoothScroll();

    // Form Validation
    initFormValidation();

    // Product Card Animations
    initProductCardAnimations();

    // Auto-dismiss alerts
    initAlertAutoDismiss();
});

// Mobile Menu Functionality
function initMobileMenu() {
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const navMenu = document.getElementById('navMenu');

    if (mobileMenuToggle && navMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');

            // Animate hamburger icon
            const spans = this.querySelectorAll('span');
            spans[0].style.transform = navMenu.classList.contains('active') ? 'rotate(45deg) translateY(10px)' : 'none';
            spans[1].style.opacity = navMenu.classList.contains('active') ? '0' : '1';
            spans[2].style.transform = navMenu.classList.contains('active') ? 'rotate(-45deg) translateY(-10px)' : 'none';
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mobileMenuToggle.contains(event.target) && !navMenu.contains(event.target)) {
                navMenu.classList.remove('active');
                const spans = mobileMenuToggle.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });
    }
}

// Smooth Scrolling for Anchor Links
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.length > 1) {
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
}

// Form Validation Enhancement
function initFormValidation() {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea');

        inputs.forEach(input => {
            // Real-time validation feedback
            input.addEventListener('blur', function() {
                validateInput(this);
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('error')) {
                    validateInput(this);
                }
            });
        });

        // Form submission validation
        form.addEventListener('submit', function(e) {
            let isValid = true;

            inputs.forEach(input => {
                if (!validateInput(input)) {
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                showNotification('Please fix the errors in the form', 'error');
            }
        });
    });
}

// Validate Individual Input
function validateInput(input) {
    const value = input.value.trim();
    const type = input.type;
    const required = input.hasAttribute('required');

    // Clear previous error
    clearInputError(input);

    if (required && !value) {
        showInputError(input, 'This field is required');
        return false;
    }

    if (value) {
        // Email validation
        if (type === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                showInputError(input, 'Please enter a valid email address');
                return false;
            }
        }

        // Password minimum length
        if (type === 'password' && input.name === 'password') {
            if (value.length < 6) {
                showInputError(input, 'Password must be at least 6 characters');
                return false;
            }
        }

        // Confirm password match
        if (input.name === 'confirm_password') {
            const passwordInput = document.querySelector('input[name="password"]');
            if (passwordInput && value !== passwordInput.value) {
                showInputError(input, 'Passwords do not match');
                return false;
            }
        }
    }

    return true;
}

// Show Input Error
function showInputError(input, message) {
    input.classList.add('error');
    input.style.borderColor = 'var(--accent-color)';

    let errorElement = input.nextElementSibling;
    if (!errorElement || !errorElement.classList.contains('error-message')) {
        errorElement = document.createElement('span');
        errorElement.classList.add('error-message');
        errorElement.style.color = 'var(--accent-color)';
        errorElement.style.fontSize = '0.85rem';
        errorElement.style.marginTop = '0.25rem';
        errorElement.style.display = 'block';
        input.parentNode.insertBefore(errorElement, input.nextSibling);
    }
    errorElement.textContent = message;
}

// Clear Input Error
function clearInputError(input) {
    input.classList.remove('error');
    input.style.borderColor = '';

    const errorElement = input.nextElementSibling;
    if (errorElement && errorElement.classList.contains('error-message')) {
        errorElement.remove();
    }
}

// Product Card Hover Animations
function initProductCardAnimations() {
    const productCards = document.querySelectorAll('.product-card');

    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

// Auto-dismiss Alerts
function initAlertAutoDismiss() {
    const alerts = document.querySelectorAll('.alert-success');

    alerts.forEach(alert => {
        setTimeout(() => {
            fadeOut(alert);
        }, 5000);
    });
}

// Fade Out Element
function fadeOut(element) {
    let opacity = 1;
    const timer = setInterval(function() {
        if (opacity <= 0.1) {
            clearInterval(timer);
            element.style.display = 'none';
        }
        element.style.opacity = opacity;
        opacity -= 0.1;
    }, 50);
}

// Show Notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.textContent = message;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.style.maxWidth = '300px';
    notification.style.animation = 'fadeIn 0.3s ease';

    document.body.appendChild(notification);

    setTimeout(() => {
        fadeOut(notification);
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}

// Add to Cart with Animation (for AJAX implementation)
function addToCartAnimation(button) {
    const originalText = button.textContent;
    button.textContent = 'Added!';
    button.style.background = '#27ae60';

    setTimeout(() => {
        button.textContent = originalText;
        button.style.background = '';
    }, 2000);
}

// Quantity Input Controls
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('input[type="number"]');

    quantityInputs.forEach(input => {
        // Prevent negative values
        input.addEventListener('input', function() {
            if (this.value < 1) {
                this.value = 1;
            }

            const max = parseInt(this.getAttribute('max'));
            if (max && this.value > max) {
                this.value = max;
                showNotification('Maximum quantity reached', 'error');
            }
        });
    });
});

// Lazy Loading for Images (if needed in the future)
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));
}

// Search Functionality (for future enhancement)
function initSearch() {
    const searchInput = document.getElementById('searchInput');

    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            const searchTerm = this.value.toLowerCase();
            // Implement search logic here
            console.log('Searching for:', searchTerm);
        }, 300));
    }
}

// Debounce Function
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

// Scroll to Top Button (optional)
function initScrollToTop() {
    const scrollBtn = document.createElement('button');
    scrollBtn.innerHTML = '↑';
    scrollBtn.className = 'scroll-to-top';
    scrollBtn.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: var(--secondary-color);
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
        cursor: pointer;
        display: none;
        z-index: 1000;
        transition: var(--transition);
    `;

    document.body.appendChild(scrollBtn);

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollBtn.style.display = 'block';
        } else {
            scrollBtn.style.display = 'none';
        }
    });

    scrollBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Initialize scroll to top on load
window.addEventListener('load', initScrollToTop);
