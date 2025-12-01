<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="emerald">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- CONTAINER UTAMA -->
    <main class="flex grow container mx-auto p-4 flex-col justify-center">

        <!-- 1. AUTO SLIDE BANNER DENGAN TITLE & LOGIN DI TENGAH -->
        <div class="relative w-full h-80 md:h-[500px] rounded-2xl overflow-hidden shadow-xl mb-8 group">

            <!-- A. Overlay Statis (Judul & Tombol Login) -->
            <!-- Z-Index tinggi (z-20) agar berada di atas gambar -->
            <div class="absolute inset-0 flex flex-col items-center justify-center z-20 bg-black/40 text-center px-4">
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-2 drop-shadow-lg">
                    Website Laporan Penghijauan
                </h1>
                <p class="text-gray-200 mb-6 text-sm md:text-lg drop-shadow-md">
                    Mari bersama menjaga lingkungan kita tetap asri.
                </p>
                <form action="{{ route('login') }}" method="GET">
                    <button
                        class="btn btn-primary text-white font-bold shadow-lg border-none hover:scale-105 transition-transform bg-green-600 hover:bg-green-700">
                        Masuk
                    </button>
                </form>
            </div>

            <!-- B. Carousel Images (Background) -->
            <div class="carousel w-full h-full ">
                <!-- Slide 1 -->
                <div class="carousel-item w-full" id="item0">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=1920&auto=format&fit=crop"
                        class="w-full h-full object-cover" />
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item w-full" id="item1">
                    <img src="https://images.unsplash.com/photo-1421789665209-c9b2a435e3dc?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        class="w-full h-full object-cover" />
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item w-full" id="item2">
                    <img src="https://images.unsplash.com/photo-1426604966848-d7adac402bff?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        class="w-full h-full object-cover" />
                </div>
            </div>

            <!-- Indikator Slide (Titik-titik di bawah) -->
            <div class="absolute flex justify-center transform -translate-x-1/2 bottom-4 left-1/2 gap-2 z-30">
                <a href="#item0" class="w-2 h-2 rounded-full bg-white/50 active-slide transition-all"></a>
                <a href="#item1" class="w-2 h-2 rounded-full bg-white/50 transition-all"></a>
                <a href="#item2" class="w-2 h-2 rounded-full bg-white/50 transition-all"></a>
            </div>
        </div>



        <!-- 2. KARTU FITUR (GRID) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Card 1: Membuat Laporan -->
            <div
                class="card bg-base-100 shadow-sm transition-all duration-300 hover:-translate-y-1 border border-green-100">
                <div class="card-body items-center text-center">
                    <div class="p-4 bg-green-100 rounded-full mb-2 text-green-700">
                        <i data-lucide="file-plus" size="32"></i>
                    </div>
                    <h2 class="card-title text-gray-700">Membuat Laporan</h2>
                    <p class="text-sm text-gray-500">Laporkan lokasi gersang atau penebangan liar di sekitarmu.</p>
                </div>
            </div>

            <!-- Card 2: Melihat Peta Laporan -->
            <div
                class="card bg-base-100 shadow-sm transition-all duration-300 hover:-translate-y-1 border border-green-100">
                <div class="card-body items-center text-center">
                    <div class="p-4 bg-blue-100 rounded-full mb-2 text-blue-700">
                        <i data-lucide="map" size="32"></i>
                    </div>
                    <h2 class="card-title text-gray-700">Peta Laporan</h2>
                    <p class="text-sm text-gray-500">Lihat titik lokasi laporan penghijauan secara interaktif.</p>
                </div>
            </div>

            <!-- Card 3: Tindak Lanjut -->
            <div
                class="card bg-base-100 shadow-sm transition-all duration-300 hover:-translate-y-1 border border-green-100">
                <div class="card-body items-center text-center">
                    <div class="p-4 bg-orange-100 rounded-full mb-2 text-orange-700">
                        <i data-lucide="activity" size="32"></i>
                    </div>
                    <h2 class="card-title text-gray-700">Tindak Lanjut</h2>
                    <p class="text-sm text-gray-500">Pantau status laporan yang sedang diproses oleh petugas.</p>
                </div>
            </div>
        </div>
    </main>


    <!-- CAROUSEL AUTO SLIDE SCRIPT -->
    <script>
        const slides = document.querySelectorAll('.carousel-item');
        const indicators = document.querySelectorAll('.absolute a');
        let currentSlide = 0;
        const totalSlides = slides.length;
        const intervalTime = 5000; // 5 detik
        let autoSlideInterval;

        function updateSlide() {
            slides.forEach((slide, index) => {
                if (index === currentSlide) {
                    slide.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                } 
            });

            // Update indicators
            indicators.forEach((indicator, index) => {
                if (index === currentSlide) {
                    indicator.classList.remove('w-2', 'bg-white/50');
                    indicator.classList.add('w-4', 'bg-white');
                } else {
                    indicator.classList.remove('w-4', 'bg-white');
                    indicator.classList.add('w-2', 'bg-white/50');
                }
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlide();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlide();
        }

        function goToSlide(index) {
            currentSlide = index;
            updateSlide();
            resetAutoSlide();
        }

        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, intervalTime);
        }

        function stopAutoSlide() {
            clearInterval(autoSlideInterval);
        }

        function resetAutoSlide() {
            stopAutoSlide();
            startAutoSlide();
        }

        // Setup indicator click listeners
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', (e) => {
                e.preventDefault();
                goToSlide(index);
            });
        });

        // Pause on hover
        const carouselContainer = document.querySelector('.group');
        if (carouselContainer) {
            carouselContainer.addEventListener('mouseenter', stopAutoSlide);
            carouselContainer.addEventListener('mouseleave', startAutoSlide);
        }

        // Init
        updateSlide();
        startAutoSlide();
    </script>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>