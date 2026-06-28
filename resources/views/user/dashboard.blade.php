@extends('layouts.user')

@section('title', 'Beranda - Graphic Photostudio')

@section('content')
<!-- Hero Section (Full Width) -->
<div class="relative w-full h-[80vh] min-h-[500px] flex items-center justify-center overflow-hidden bg-dark">
    <!-- Background Image -->
    <div class="absolute inset-0 w-full h-full">
        <img src="{{ asset('asset/images/gambar 1.jpg') }}" alt="Studio Background" class="w-full h-full object-cover opacity-60 scale-105 transform animate-[slowZoom_20s_ease-in-out_infinite_alternate]">
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-dark/40 via-dark/20 to-dark/80"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto fade-in">
        <span class="inline-block py-1 px-3 rounded-full bg-studio-400/20 text-studio-300 backdrop-blur-sm border border-studio-400/30 text-xs md:text-sm font-bold uppercase tracking-[0.2em] mb-4 md:mb-6">
            Selamat Datang di
        </span>
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-heading font-black text-white leading-tight mb-4 md:mb-6 drop-shadow-lg">
            Graphic <span class="text-studio-400">Photostudio</span>
        </h1>
        <p class="text-sm md:text-lg text-gray-300 font-medium mb-8 md:mb-10 max-w-2xl mx-auto leading-relaxed">
            Menangkap setiap momen berharga Anda dengan sentuhan seni dan profesionalisme tinggi. Temukan gaya fotografi terbaik untuk kenangan abadi Anda.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="/paket-foto" class="w-full sm:w-auto px-8 py-3.5 bg-studio-400 hover:bg-studio-500 text-dark font-bold rounded-full transition-all duration-300 transform hover:-translate-y-1 hover:shadow-[0_10px_20px_-10px_rgba(193,186,138,0.5)] flex items-center justify-center gap-2">
                Eksplorasi Paket <i class="fa-solid fa-arrow-right text-sm"></i>
            </a>
            <a href="/galeri" class="w-full sm:w-auto px-8 py-3.5 bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-md font-bold rounded-full transition-all duration-300 flex items-center justify-center gap-2">
                Lihat Galeri
            </a>
        </div>
    </div>
</div>

<!-- About Section -->
<div class="py-16 md:py-24 px-6 max-w-[1200px] mx-auto">
    <div class="flex flex-col md:flex-row items-center gap-12 md:gap-20">
        
        <!-- Image Side -->
        <div class="w-full md:w-1/2 relative group">
            <div class="absolute inset-0 bg-studio-400 rounded-2xl transform rotate-3 scale-105 opacity-20 group-hover:rotate-6 transition-transform duration-500"></div>
            <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                <img src="{{ asset('asset/images/gambar 1.jpg') }}" alt="Tentang Studio" class="w-full h-auto object-cover hover:scale-105 transition-transform duration-700">
            </div>
            
            <!-- Floating Badge -->
            <div class="absolute -bottom-6 -right-6 bg-white p-4 rounded-xl shadow-xl border border-gray-100 flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                <div class="w-12 h-12 bg-studio-50 text-studio-500 rounded-full flex items-center justify-center text-xl">
                    <i class="fa-solid fa-star"></i>
                </div>
                <div>
                    <p class="text-sm font-black text-dark font-heading">Kualitas</p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Premium</p>
                </div>
            </div>
        </div>

        <!-- Text Side -->
        <div class="w-full md:w-1/2 space-y-6">
            <div class="inline-flex items-center gap-2 text-studio-500 font-bold text-xs uppercase tracking-[0.2em]">
                <span class="w-8 h-0.5 bg-studio-500"></span> Tentang Kami
            </div>
            <h2 class="text-3xl md:text-4xl font-heading font-black text-dark leading-tight">
                Mengabadikan Momen, <br> <span class="text-studio-500 italic font-medium">Menciptakan Kenangan.</span>
            </h2>
            
            <div class="text-gray-500 text-sm leading-relaxed space-y-4">
                <p>
                    Studio fotografi dan desain grafis yang berfokus pada penghasilan karya visual yang menarik dan berkualitas. Setiap hasil foto mengutamakan pencahayaan, komposisi, dan detail untuk menciptakan tampilan yang profesional dan estetis.
                </p>
                <p>
                    Studio ini menjadi pilihan tepat untuk berbagai kebutuhan fotografi, seperti sesi prewedding, foto pernikahan, hingga foto keluarga. Didukung dengan konsep kreatif serta peralatan yang memadai, setiap momen dapat diabadikan dengan hasil yang indah.
                </p>
            </div>
            
            <div class="pt-4 grid grid-cols-2 gap-6 border-t border-gray-100">
                <div>
                    <h4 class="text-3xl font-black font-heading text-dark mb-1">50+</h4>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Sesi Foto Sukses</p>
                </div>
                <div>
                    <h4 class="text-3xl font-black font-heading text-dark mb-1">100%</h4>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Kepuasan Klien</p>
                </div>
            </div>
        </div>
        
    </div>
</div>

<style>
    @keyframes slowZoom {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }
</style>
@endsection