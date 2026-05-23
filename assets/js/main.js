document.addEventListener('DOMContentLoaded', () => {
    
    // ========================================
    // PAGE LOADER
    // ========================================
    const loader = document.querySelector('.loader');
    window.addEventListener('load', () => {
        setTimeout(() => {
            loader.classList.add('hidden');
        }, 1000);
    });

    // ========================================
    // CUSTOM CURSOR
    // ========================================
    const cursor = document.querySelector('.cursor');
    const follower = document.querySelector('.cursor-follower');

    document.addEventListener('mousemove', (e) => {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
        
        setTimeout(() => {
            follower.style.left = e.clientX - 20 + 'px';
            follower.style.top = e.clientY - 20 + 'px';
        }, 50);
    });

    // Hover effect for links and buttons
    const hoverElements = document.querySelectorAll('a, button, .gallery-item');
    hoverElements.forEach(el => {
        el.addEventListener('mouseenter', () => {
            cursor.style.transform = 'scale(2)';
            follower.style.transform = 'scale(1.5)';
        });
        el.addEventListener('mouseleave', () => {
            cursor.style.transform = 'scale(1)';
            follower.style.transform = 'scale(1)';
        });
    });

    // ========================================
    // MOBILE MENU
    // ========================================
    const burger = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');
    const links = document.querySelectorAll('.nav-links li');

    burger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
        
        // Burger Animation
        burger.classList.toggle('toggle');
    });

    // Close menu when clicking a link
    links.forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('active');
        });
    });

    // ========================================
    // GALLERY FILTERING
    // ========================================
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            button.classList.add('active');

            const filterValue = button.getAttribute('data-filter');

            galleryItems.forEach(item => {
                if (filterValue === 'all') {
                    item.classList.remove('hide');
                } else {
                    if (item.getAttribute('data-category') === filterValue) {
                        item.classList.remove('hide');
                    } else {
                        item.classList.add('hide');
                    }
                }
            });
        });
    });

    // ========================================
    // VIDEO HOVER PLAYBACK
    // ========================================
    const videoItems = document.querySelectorAll('.video-item');

    videoItems.forEach(item => {
        const video = item.querySelector('video');
        
        item.addEventListener('mouseenter', () => {
            video.play();
        });

        item.addEventListener('mouseleave', () => {
            video.pause();
            video.currentTime = 0;
        });
    });

    // ========================================
    // LIGHTBOX FUNCTIONALITY
    // ========================================
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxVideo = document.getElementById('lightbox-video');
    const closeLightbox = document.querySelector('.close-lightbox');
    const captionText = document.getElementById('caption');

    galleryItems.forEach(item => {
        item.addEventListener('click', () => {
            const img = item.querySelector('img');
            const video = item.querySelector('video');
            const title = item.querySelector('h3').textContent;

            if (video) {
                // It's a video item
                lightboxImg.style.display = 'none';
                lightboxVideo.style.display = 'block';
                lightboxVideo.src = video.src;
                lightboxVideo.play();
            } else {
                // It's an image item
                lightboxVideo.style.display = 'none';
                lightboxVideo.pause();
                lightboxImg.style.display = 'block';
                lightboxImg.src = img.src;
            }

            captionText.textContent = title;
            lightbox.classList.add('active');
        });
    });

    // Close lightbox
    closeLightbox.addEventListener('click', () => {
        lightbox.classList.remove('active');
        lightboxVideo.pause();
        lightboxVideo.src = '';
    });

    // Close on outside click
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) {
            lightbox.classList.remove('active');
            lightboxVideo.pause();
            lightboxVideo.src = '';
        }
    });

    // ========================================
    // CONTACT FORM (Static Demo)
    // ========================================
    const contactForm = document.getElementById('contactForm');
    const formStatus = document.querySelector('.form-status');

    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Since this is static GitHub Pages, we can't send emails directly
        // You would need to integrate a service like Formspree or EmailJS
        formStatus.textContent = "Thanks for your message! (Demo mode - integrate Formspree for real emails)";
        formStatus.style.color = "#d4af37";
        
        contactForm.reset();
        
        setTimeout(() => {
            formStatus.textContent = "";
        }, 5000);
    });

    // ========================================
    // SMOOTH SCROLLING
    // ========================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 70,
                    behavior: 'smooth'
                });
            }
        });
    });

});
