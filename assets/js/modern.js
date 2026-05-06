// assets/js/modern.js - Modern UI Enhancements

document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const menuToggle = document.getElementById('menuToggle');
    const navMenu = document.getElementById('navMenu');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            
            // Animate hamburger
            const spans = menuToggle.querySelectorAll('span');
            if (navMenu.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translateY(11px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translateY(-11px)';
            } else {
                spans[0].style.transform = '';
                spans[1].style.opacity = '1';
                spans[2].style.transform = '';
            }
        });

        // Close menu when clicking on a link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                navMenu.classList.remove('active');
                menuToggle.querySelectorAll('span').forEach(span => {
                    span.style.transform = '';
                    span.style.opacity = '1';
                });
            });
        });
    }

    // Form Validation & Enhancement
    const forms = document.querySelectorAll('.modern-form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const inputs = form.querySelectorAll('input[required], textarea[required]');
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    highlightError(input);
                } else {
                    clearError(input);
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    });

    // Real-time validation
    document.querySelectorAll('.input-wrapper input, .input-wrapper textarea').forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value.trim()) {
                highlightError(this);
            } else {
                clearError(this);
            }
        });

        input.addEventListener('focus', function() {
            clearError(this);
        });
    });

    // Email validation
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value);
            if (!isValid && this.value.trim()) {
                this.parentElement.style.borderColor = '#ef4444';
            } else {
                clearError(this);
            }
        });
    }

    // Phone validation (Vietnam)
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('blur', function() {
            const isValid = /^(\+84|0)[0-9]{9,10}$/.test(this.value);
            if (!isValid && this.value.trim()) {
                this.parentElement.style.borderColor = '#ef4444';
            } else {
                clearError(this);
            }
        });
    }

    // Smooth scroll for anchor links
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

    // Add animation to alert boxes
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '1';
        }, 100);
    });
});

function highlightError(element) {
    if (element.parentElement.classList.contains('input-wrapper')) {
        element.parentElement.style.borderColor = '#ef4444';
        element.parentElement.style.backgroundColor = 'rgba(239, 68, 68, 0.02)';
    }
}

function clearError(element) {
    if (element.parentElement.classList.contains('input-wrapper')) {
        element.parentElement.style.borderColor = '';
        element.parentElement.style.backgroundColor = '';
    }
}

// Contact form submission handler
document.addEventListener('submit', function(e) {
    const form = e.target;
    if (form.classList.contains('modern-form')) {
        const submitBtn = form.querySelector('.btn-submit');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';
            
            // Re-enable after submission
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }, 2000);
        }
    }
});

// Add lazy loading to images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => imageObserver.observe(img));
}