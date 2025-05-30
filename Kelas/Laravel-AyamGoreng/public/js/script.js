// Main JavaScript file for Crispy Chicken Website

// Wait for the document to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Scroll to top button
    const scrollToTopBtn = document.createElement('div');
    scrollToTopBtn.className = 'scroll-to-top';
    scrollToTopBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    document.body.appendChild(scrollToTopBtn);
    
    scrollToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.add('show');
        } else {
            scrollToTopBtn.classList.remove('show');
        }
    });
    
    // Animate fade-in elements on scroll
    const fadeElems = document.querySelectorAll('.fade-in');
    
    const fadeInObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                fadeInObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });
    
    fadeElems.forEach(elem => {
        fadeInObserver.observe(elem);
    });
    
    // Add smooth scrolling to all links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Mobile nav menu toggle animation
    const navbarToggler = document.querySelector('.navbar-toggler');
    if (navbarToggler) {
        navbarToggler.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    }
    
    // Product image zoom effect
    const productImages = document.querySelectorAll('.product-img');
    productImages.forEach(img => {
        img.addEventListener('mousemove', function(e) {
            const x = e.clientX - this.offsetLeft;
            const y = e.clientY - this.offsetTop;
            
            this.style.transformOrigin = `${x}px ${y}px`;
            this.style.transform = 'scale(1.5)';
        });
        
        img.addEventListener('mouseleave', function() {
            this.style.transformOrigin = 'center center';
            this.style.transform = 'scale(1)';
        });
    });
    
    // Quantity increment/decrement controls
    const quantityControls = document.querySelectorAll('.quantity-control');
    quantityControls.forEach(control => {
        const input = control.querySelector('input');
        const decrementBtn = control.querySelector('.decrement');
        const incrementBtn = control.querySelector('.increment');
        
        decrementBtn.addEventListener('click', function() {
            const currentValue = parseInt(input.value);
            if (currentValue > parseInt(input.min || 1)) {
                input.value = currentValue - 1;
                // Trigger change event
                input.dispatchEvent(new Event('change'));
            }
        });
        
        incrementBtn.addEventListener('click', function() {
            const currentValue = parseInt(input.value);
            const max = parseInt(input.max || 100);
            if (currentValue < max) {
                input.value = currentValue + 1;
                // Trigger change event
                input.dispatchEvent(new Event('change'));
            }
        });
    });
    
    // Product category filter
    const categoryFilters = document.querySelectorAll('.category-filter');
    if (categoryFilters.length > 0) {
        categoryFilters.forEach(filter => {
            filter.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all filters
                categoryFilters.forEach(f => f.classList.remove('active'));
                
                // Add active class to current filter
                this.classList.add('active');
                
                const category = this.getAttribute('data-category');
                const productItems = document.querySelectorAll('.product-item');
                
                productItems.forEach(item => {
                    if (category === 'all') {
                        item.style.display = 'block';
                    } else if (item.getAttribute('data-category') === category) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }
    
    // Check if an element exists in the DOM
    function elementExists(selector) {
        return document.querySelector(selector) !== null;
    }
    
    // Cart functionality
    if (elementExists('#cartTable')) {
        const cartItems = document.querySelectorAll('.cart-item');
        
        cartItems.forEach(item => {
            const quantityInput = item.querySelector('.quantity-input');
            const priceElement = item.querySelector('.item-price');
            const subtotalElement = item.querySelector('.item-subtotal');
            const unitPrice = parseFloat(priceElement.getAttribute('data-price'));
            
            quantityInput.addEventListener('change', function() {
                const quantity = parseInt(this.value);
                const subtotal = unitPrice * quantity;
                subtotalElement.textContent = 'Rp ' + formatNumber(subtotal);
                updateCartTotal();
            });
        });
        
        function updateCartTotal() {
            let total = 0;
            document.querySelectorAll('.item-subtotal').forEach(item => {
                total += parseFloat(item.textContent.replace('Rp ', '').replace(/\./g, ''));
            });
            document.querySelector('#cartTotal').textContent = 'Rp ' + formatNumber(total);
        }
        
        function formatNumber(number) {
            return number.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&.');
        }
    }
    
    // Order details toggle
    const orderDetailsToggle = document.querySelectorAll('.order-details-toggle');
    if (orderDetailsToggle.length > 0) {
        orderDetailsToggle.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                const detailsElement = document.querySelector(`.order-details[data-order-id="${orderId}"]`);
                
                // Toggle details visibility
                if (detailsElement.style.display === 'none') {
                    detailsElement.style.display = 'block';
                    this.innerHTML = '<i class="fas fa-chevron-up me-1"></i> Hide Details';
                } else {
                    detailsElement.style.display = 'none';
                    this.innerHTML = '<i class="fas fa-chevron-down me-1"></i> View Details';
                }
            });
        });
    }
});

// Add custom animations
const animateCSS = (element, animation, prefix = 'animate__') =>
  new Promise((resolve, reject) => {
    const animationName = `${prefix}${animation}`;
    const node = document.querySelector(element);

    if (!node) {
        reject('Element not found');
        return;
    }

    node.classList.add(`${prefix}animated`, animationName);

    function handleAnimationEnd(event) {
      event.stopPropagation();
      node.classList.remove(`${prefix}animated`, animationName);
      resolve('Animation ended');
    }

    node.addEventListener('animationend', handleAnimationEnd, {once: true});
  });