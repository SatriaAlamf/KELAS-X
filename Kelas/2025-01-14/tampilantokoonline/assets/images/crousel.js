let currentIndex = 0;
        const items = document.querySelectorAll('.carousel-item');
        const totalItems = items.length;

        document.getElementById('next').addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % totalItems;
            updateCarousel();
        });

        document.getElementById('prev').addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            updateCarousel();
        });

        function updateCarousel() {
            const carousel = document.getElementById('carousel');
            carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
        }