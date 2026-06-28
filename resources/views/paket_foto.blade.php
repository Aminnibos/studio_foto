@extends('layouts.user')

@section('title', 'Paket Foto - Graphic Photostudio')

@section('content')
<div class="pt-10 pb-20 md:pt-16 md:pb-24 px-4 md:px-8 max-w-[1200px] mx-auto min-h-[70vh]">
    @if(isset($katalogKategori))
        <!-- Categories View -->
        <div class="text-center space-y-10 md:space-y-16 fade-in">
            <div class="space-y-3">
                <span class="inline-block py-1 px-3 rounded-full bg-studio-50 text-studio-500 border border-studio-200 text-[10px] md:text-xs font-bold uppercase tracking-[0.2em]">
                    Katalog Latar Belakang
                </span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-heading font-black text-dark tracking-tight">
                    Pilih Tema <span class="text-studio-400 italic">Terbaikmu</span>
                </h2>
                <p class="text-xs md:text-sm text-gray-500 max-w-xl mx-auto">Kami menyediakan berbagai pilihan tema latar belakang yang dapat disesuaikan dengan konsep dan kebutuhan sesi foto Anda.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10">
                @forelse($katalogKategori as $kat)
                    <a href="{{ url('/paket-foto?kategori=' . $kat->kategori) }}" class="group block relative rounded-2xl overflow-hidden bg-dark shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                        <!-- Image Container -->
                        <div class="relative h-[300px] md:h-[400px] w-full overflow-hidden">
                            @if($kat->gambar)
                                <img src="{{ asset('storage/' . $kat->gambar) }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700" alt="{{ $kat->kategori }}">
                            @else
                                <div class="w-full h-full bg-gray-800 flex flex-col items-center justify-center text-gray-500 transition-all duration-500 group-hover:scale-105">
                                    <i class="fa-solid fa-image text-4xl mb-3 opacity-50"></i>
                                    <span class="text-xs font-medium tracking-wider">NO COVER</span>
                                </div>
                            @endif
                            
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-dark via-dark/40 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-300"></div>
                        </div>

                        <!-- Content Overlay -->
                        <div class="absolute bottom-0 left-0 w-full p-6 md:p-8 flex flex-col justify-end">
                            <span class="w-10 h-1 bg-studio-400 mb-4 transform origin-left transition-all duration-300 group-hover:w-16"></span>
                            <h3 class="text-2xl md:text-3xl font-heading font-black text-white uppercase tracking-wide mb-2 group-hover:text-studio-300 transition-colors">
                                {{ $kat->kategori }}
                            </h3>
                            <p class="text-[10px] md:text-xs text-gray-300 font-medium tracking-wider uppercase flex items-center opacity-0 transform translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                                Lihat Paket <i class="fa-solid fa-arrow-right ml-2 text-studio-400"></i>
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-1 sm:col-span-2 lg:col-span-3 flex flex-col items-center justify-center py-16 md:py-24 text-gray-400 bg-white rounded-3xl border border-gray-100 shadow-sm">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300 border border-gray-100">
                            <i class="fa-solid fa-camera-slash text-2xl"></i>
                        </div>
                        <p class="text-sm font-bold text-gray-500">Belum Ada Tema</p>
                        <p class="text-xs mt-1">Admin belum menambahkan tema latar belakang.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @else
        <!-- Package List View -->
        <div class="space-y-8 md:space-y-12 fade-in">
            <!-- Header section -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-gray-200 pb-6">
                <div class="space-y-2">
                    <a href="{{ url('/paket-foto') }}" class="inline-flex items-center text-[10px] md:text-xs font-bold text-gray-400 hover:text-studio-500 uppercase tracking-wider mb-2 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Tema
                    </a>
                    <h2 class="text-3xl md:text-4xl font-heading font-black text-dark flex items-center gap-3">
                        {{ request('kategori') }}
                        <span class="px-3 py-1 bg-studio-50 text-studio-500 text-[10px] md:text-xs font-bold uppercase tracking-widest rounded-full border border-studio-100 align-middle">
                            Kategori
                        </span>
                    </h2>
                </div>
                <div class="text-sm text-gray-500 font-medium">
                    Tersedia <span class="font-bold text-dark">{{ $daftarPaket->count() }}</span> pilihan paket
                </div>
            </div>

            <!-- Packages Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                @forelse($daftarPaket as $paket)
                <div class="group bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden flex flex-col hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:-translate-y-2 transition-all duration-500">
                    
                    <!-- Card Image -->
                    <div class="relative h-64 md:h-72 bg-dark overflow-hidden">
                        @if($paket->gambar)
                            <img src="{{ asset('storage/' . $paket->gambar) }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-500 bg-gray-100 group-hover:scale-105 transition-transform duration-500">
                                <i class="fa-regular fa-image text-4xl mb-3 opacity-30"></i>
                                <span class="text-xs font-bold tracking-widest uppercase">No Image</span>
                            </div>
                        @endif
                        
                        <!-- Badge Top Right -->
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-dark text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm border border-white">
                            Populer
                        </div>
                    </div>
                    
                    <!-- Card Content -->
                    <div class="p-6 md:p-8 flex-1 flex flex-col">
                        <div class="flex-1">
                            <h3 class="text-xl md:text-2xl font-heading font-black text-dark mb-4 group-hover:text-studio-500 transition-colors uppercase">
                                {{ $paket->nama_paket }}
                            </h3>
                            
                            <ul class="space-y-3 md:space-y-4 text-xs md:text-sm text-gray-600 font-medium">
                                <li class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-studio-50 text-studio-500 flex items-center justify-center border border-studio-100">
                                        <i class="fa-solid fa-camera"></i>
                                    </div>
                                    <span>50x Shoot</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-studio-50 text-studio-500 flex items-center justify-center border border-studio-100">
                                        <i class="fa-regular fa-clock"></i>
                                    </div>
                                    <span>Durasi Sesi: {{ $paket->durasi ?? '15 Menit' }}</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-studio-50 text-studio-500 flex items-center justify-center border border-studio-100">
                                        <i class="fa-regular fa-user"></i>
                                    </div>
                                    <span>MAX. {{ $paket->kategori == 'Keluarga' ? '20' : '5' }} person</span>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Pricing & Action -->
                        <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Mulai Dari</p>
                                <p class="text-xl md:text-2xl font-black font-heading text-dark">
                                    Rp {{ number_format($paket->harga, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="/booking/{{ $paket->id }}" class="w-12 h-12 rounded-full bg-dark text-white flex items-center justify-center group-hover:bg-studio-400 group-hover:-rotate-45 transition-all duration-300 shadow-md">
                                <i class="fa-solid fa-arrow-right text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 flex flex-col items-center justify-center py-16 text-gray-400 bg-white rounded-3xl border border-gray-100 shadow-sm">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300 border border-gray-100">
                        <i class="fa-solid fa-box-open text-2xl"></i>
                    </div>
                    <p class="text-sm font-bold text-gray-500">Belum Ada Paket</p>
                    <p class="text-xs mt-1">Paket foto untuk tema ini belum ditambahkan.</p>
                </div>
                @endforelse
            </div>
        </div>
    @endif
</div>
@endsection