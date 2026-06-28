@extends('layouts.user')

@section('title', 'Galeri Portofolio - Graphic Photostudio')

@section('content')
<div class="pt-10 pb-20 md:pt-16 md:pb-24 px-4 md:px-8 max-w-[1400px] mx-auto min-h-[70vh]">
    <!-- Header Section -->
    <div class="text-center space-y-4 mb-12 md:mb-20 fade-in">
        <span class="inline-block py-1 px-3 rounded-full bg-studio-50 text-studio-500 border border-studio-200 text-[10px] md:text-xs font-bold uppercase tracking-[0.2em]">
            Portofolio Studio
        </span>
        <h2 class="text-4xl md:text-5xl lg:text-6xl font-heading font-black text-dark tracking-tight">
            Galeri <span class="text-studio-400 italic">Karya Kami</span>
        </h2>
        <p class="text-xs md:text-sm text-gray-500 max-w-2xl mx-auto leading-relaxed">
            Jelajahi koleksi momen-momen terbaik yang telah kami abadikan. Setiap foto bercerita, dan kami di sini untuk menceritakan kisah Anda.
        </p>
    </div>

    @if(!isset($galeriUser) || $galeriUser->isEmpty())
        <div class="bg-white p-12 md:p-20 rounded-3xl border border-gray-100 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] mt-8 flex flex-col items-center justify-center fade-in">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6 border border-gray-100">
                <i class="fa-regular fa-images text-4xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-heading font-black text-dark mb-2">Koleksi Masih Kosong</h3>
            <p class="text-gray-500 text-sm max-w-md">Belum ada foto portofolio yang diunggah. Silakan nantikan pembaruan karya terbaik kami selanjutnya!</p>
        </div>
    @else
        @php
            // Mengelompokkan semua foto dari database berdasarkan nama temanya
            $galeriGrouped = $galeriUser->groupBy('kategori');
        @endphp

        <div class="space-y-16 md:space-y-24 fade-in">
            @foreach($galeriGrouped as $kategori => $fotos)
                <div class="space-y-8">
                    <!-- Kategori Title -->
                    <div class="flex items-center gap-4">
                        <h3 class="font-heading font-black text-2xl md:text-3xl text-dark uppercase tracking-wide flex items-center gap-3">
                            <span class="w-10 h-10 rounded-full bg-studio-50 text-studio-500 flex items-center justify-center border border-studio-100 text-lg">
                                <i class="fa-solid fa-camera-retro"></i>
                            </span>
                            {{ $kategori }}
                        </h3>
                        <div class="h-px bg-gray-200 flex-1 ml-4 hidden md:block"></div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest hidden md:block">{{ count($fotos) }} Karya</span>
                    </div>
                    
                    <!-- Grid Foto -->
                    <div class="columns-2 md:columns-3 lg:columns-4 gap-4 md:gap-6 space-y-4 md:space-y-6 pb-4">
                        @foreach($fotos as $foto)
                            <div class="group relative rounded-2xl overflow-hidden bg-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 cursor-pointer break-inside-avoid">
                                <img src="{{ asset('storage/' . $foto->foto) }}" class="w-full h-auto object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out" alt="Portofolio {{ $kategori }}" loading="lazy">
                                
                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-dark/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5 md:p-6">
                                    <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                        <div class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white mb-3">
                                            <i class="fa-solid fa-expand text-[10px]"></i>
                                        </div>
                                        <p class="text-white font-heading font-bold text-sm tracking-wider uppercase">{{ $kategori }}</p>
                                        <p class="text-gray-300 text-[10px] uppercase tracking-widest mt-1">Graphic Studio</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection