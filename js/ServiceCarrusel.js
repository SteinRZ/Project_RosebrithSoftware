 let currentIndex = 0;

        function showSlide(index) {
            const carousel = document.getElementById('carousel');
            carousel.style.transform = `translateX(${-index * 33.33}%)`;
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + 4) % 4;//el 4 indica que cuando pasen 4 dara vuelta al carrusel
            showSlide(currentIndex);
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % 4;//el 4 indica que cuando pasen 4 dara vuelta al carrusel
            showSlide(currentIndex);
        }