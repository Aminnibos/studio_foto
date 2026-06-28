<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Graphic Photostudio')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        studio: {
                            50: '#fbfaf8',
                            100: '#f5f3ec',
                            200: '#eae5c9',
                            300: '#dcd39e',
                            400: '#c1ba8a', // Primary Gold
                            500: '#a69e65', // Hover Gold
                            600: '#8c824c',
                            700: '#71673b',
                            800: '#5c5434',
                            900: '#4e482f',
                        },
                        dark: '#18181b' // Zinc 900
                    }
                }
            }
        }
    </script>

    <style>
        /* Smooth Scroll & Scrollbar Hiding */
        html { scroll-behavior: smooth; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        /* Animasi standar untuk memunculkan halaman */
        .fade-in { animation: fadeIn 0.8s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    @stack('styles')
</head>
<body class="bg-[#FCFCFC] font-sans flex flex-col min-h-screen text-gray-800 antialiased selection:bg-studio-200 selection:text-studio-900">

    <!-- Navbar: Sticky, Glassmorphism, Premium Light Theme -->
    <nav class="sticky top-0 w-full bg-white/80 backdrop-blur-lg border-b border-gray-100 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.02)] px-4 md:px-8 py-3 flex flex-col md:flex-row md:justify-between md:items-center z-50 transition-all duration-300">
        <div class="flex justify-between items-center w-full md:w-auto">
            <!-- Logo -->
            <div class="flex items-center space-x-2.5 group cursor-pointer">
                <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-dark text-studio-400 flex items-center justify-center group-hover:scale-105 transition-transform duration-300 shadow-sm">
                    <i class="fa-solid fa-camera-retro text-sm md:text-base"></i>
                </div>
                <span class="font-heading font-extrabold tracking-wide text-lg md:text-xl text-dark group-hover:text-studio-500 transition-colors">graphic.studio</span>
            </div>
            
            <!-- Profil Mobile -->
            <div class="relative inline-block text-left md:hidden">
                @auth
                <button onclick="toggleProfileMenuMobile(event)" class="w-9 h-9 rounded-full bg-gray-50 border border-gray-200 text-gray-600 hover:text-studio-500 hover:border-studio-200 flex items-center justify-center transition-all duration-300 shadow-sm focus:outline-none">
                    <i class="fa-solid fa-user text-sm"></i>
                </button>
                <div id="dropdownProfilMobile" class="hidden absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transform origin-top-right transition-all z-50">
                    <div class="p-4 bg-gray-50/50 border-b border-gray-100">
                        <p class="text-sm font-black font-heading text-gray-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] font-medium text-gray-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="p-2">
                        <form action="{{ url('/logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar dari akun?')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition flex items-center gap-3">
                                <i class="fa-solid fa-right-from-bracket"></i> Keluar (Logout)
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="px-4 py-1.5 bg-studio-400 text-dark font-bold text-xs rounded-full flex items-center">
                    Masuk
                </a>
                @endauth
            </div>
        </div>

        <!-- Menu Desktop & Mobile Scrollable -->
        <div class="flex items-center space-x-6 md:space-x-8 text-xs md:text-sm font-semibold mt-4 md:mt-0 overflow-x-auto md:overflow-visible no-scrollbar pb-1 md:pb-0 w-full md:w-auto text-gray-500">
            <a href="/" class="{{ request()->is('/') || request()->is('dashboard-studio') ? 'text-studio-500 border-b-2 border-studio-500' : 'hover:text-dark transition-colors' }} whitespace-nowrap pb-1">Beranda</a>
            <a href="/paket-foto" class="{{ request()->is('paket-foto') ? 'text-studio-500 border-b-2 border-studio-500' : 'hover:text-dark transition-colors' }} whitespace-nowrap pb-1">Paket Foto</a>
            <a href="/galeri" class="{{ request()->is('galeri') ? 'text-studio-500 border-b-2 border-studio-500' : 'hover:text-dark transition-colors' }} whitespace-nowrap pb-1">Galeri</a>
            <a href="/riwayat-pemesanan" class="{{ request()->is('riwayat-pemesanan') ? 'text-studio-500 border-b-2 border-studio-500' : 'hover:text-dark transition-colors' }} whitespace-nowrap pb-1">Riwayat Pesanan</a>
            
            <!-- Profil Desktop -->
            <div class="relative hidden md:inline-block text-left pl-4 border-l border-gray-200">
                @auth
                <button onclick="toggleProfileMenuDesktop(event)" class="flex items-center space-x-2 text-gray-700 hover:text-studio-500 transition-colors focus:outline-none group">
                    <div class="w-9 h-9 rounded-full bg-gray-50 border border-gray-200 flex items-center justify-center group-hover:border-studio-300 transition-colors shadow-sm">
                        <i class="fa-solid fa-user text-sm"></i>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 group-hover:text-studio-500 transition-colors"></i>
                </button>
                <div id="dropdownProfilDesktop" class="hidden absolute right-0 mt-4 w-64 bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] border border-gray-100 overflow-hidden transform origin-top-right transition-all z-50">
                    <div class="p-5 bg-gradient-to-b from-gray-50 to-white border-b border-gray-100">
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="w-10 h-10 rounded-full bg-studio-50 text-studio-500 flex items-center justify-center text-xl shadow-inner border border-studio-100">
                                <i class="fa-solid fa-circle-user"></i>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-sm font-black font-heading text-gray-800 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] font-medium text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <span class="inline-block mt-1 px-2.5 py-1 bg-dark text-studio-300 rounded text-[9px] font-bold uppercase tracking-widest shadow-sm">
                            Pelanggan Studio
                        </span>
                    </div>
                    <div class="p-2">
                        <form action="{{ url('/logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar dari akun?')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 hover:text-rose-700 rounded-xl transition flex items-center gap-3">
                                <i class="fa-solid fa-right-from-bracket"></i> Keluar (Logout)
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="bg-studio-400 hover:bg-studio-500 text-dark font-bold px-5 py-2 rounded-full transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i> Login / Masuk
                </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex-1 w-full relative z-10">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-gray-300 border-t-4 border-studio-400 mt-16">
        <div class="max-w-[1200px] mx-auto px-6 py-12 md:py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-8">
                <!-- Branding -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2.5 text-white">
                        <div class="w-8 h-8 rounded-full bg-studio-400 text-dark flex items-center justify-center">
                            <i class="fa-solid fa-camera-retro text-sm"></i>
                        </div>
                        <span class="font-heading font-extrabold tracking-wide text-xl">graphic.studio</span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-xs">Mengabadikan setiap momen berharga Anda dengan sentuhan estetika dan profesionalisme yang tinggi.</p>
                </div>
                
                <!-- Tautan Cepat -->
                <div>
                    <h4 class="text-white font-heading font-bold text-lg mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="/dashboard-studio" class="hover:text-studio-400 transition-colors flex items-center"><i class="fa-solid fa-angle-right mr-2 text-[10px] text-studio-400"></i> Beranda</a></li>
                        <li><a href="/paket-foto" class="hover:text-studio-400 transition-colors flex items-center"><i class="fa-solid fa-angle-right mr-2 text-[10px] text-studio-400"></i> Paket Foto</a></li>
                        <li><a href="/galeri" class="hover:text-studio-400 transition-colors flex items-center"><i class="fa-solid fa-angle-right mr-2 text-[10px] text-studio-400"></i> Galeri Kami</a></li>
                        <li><a href="/riwayat-pemesanan" class="hover:text-studio-400 transition-colors flex items-center"><i class="fa-solid fa-angle-right mr-2 text-[10px] text-studio-400"></i> Cek Pesanan</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-white font-heading font-bold text-lg mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start space-x-3">
                            <i class="fa-solid fa-location-dot mt-1 text-studio-400"></i>
                            <span class="leading-relaxed">Jl. Fotografi No. 123, Kota Kreatif, Indonesia 40123</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fa-brands fa-whatsapp text-studio-400"></i>
                            <span>+62 812 3456 7890</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fa-solid fa-envelope text-studio-400"></i>
                            <span>halo@graphicstudio.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-10 pt-6 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} Graphic Photostudio. All rights reserved.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center hover:bg-studio-400 hover:text-dark transition-colors"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center hover:bg-studio-400 hover:text-dark transition-colors"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center hover:bg-studio-400 hover:text-dark transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleProfileMenuMobile(e) {
            e.stopPropagation();
            const dropdownMobile = document.getElementById('dropdownProfilMobile');
            if(dropdownMobile) dropdownMobile.classList.toggle('hidden');
        }

        function toggleProfileMenuDesktop(e) {
            e.stopPropagation(); 
            const dropdownDesktop = document.getElementById('dropdownProfilDesktop');
            if(dropdownDesktop) dropdownDesktop.classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            const dropMobile = document.getElementById('dropdownProfilMobile');
            if (dropMobile && !dropMobile.contains(e.target)) {
                dropMobile.classList.add('hidden');
            }

            const dropDesktop = document.getElementById('dropdownProfilDesktop');
            if (dropDesktop && !dropDesktop.contains(e.target)) {
                dropDesktop.classList.add('hidden');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
