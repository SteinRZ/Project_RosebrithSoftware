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

let currentIndex2 = 0;

        function showSlide2(index) {
            const carousel = document.getElementById('carousel2');
            carousel.style.transform = `translateX(${-index * 33.33}%)`;
        }

        function prevSlide2() {
            currentIndex2 = (currentIndex2 - 1 + 4) % 4;//el 4 indica que cuando pasen 4 dara vuelta al carrusel
            showSlide2(currentIndex2);
        }

        function nextSlide2() {
            currentIndex2 = (currentIndex2 + 1) % 4;//el 4 indica que cuando pasen 4 dara vuelta al carrusel
            showSlide2(currentIndex2);
        }

        function mostrarContenido(seccion) {
            // Oculta todos los contenidos
            var contenidos = document.getElementsByClassName('content');
            for (var i = 0; i < contenidos.length; i++) {
                contenidos[i].style.display = 'none';
            }
    
            // Muestra el contenido de la sección seleccionada
            document.getElementById(seccion).style.display = 'block';
            
        }