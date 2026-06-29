<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Graphic Photostudio')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-serif { font-family: 'Outfit', sans-serif; }
        .glass-nav { background: rgba(193, 186, 138, 0.95); backdrop-filter: blur(10px); }
        /* Scrollbar custom for tables */
        .table-container::-webkit-scrollbar { height: 8px; }
        .table-container::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .table-container::-webkit-scrollbar-thumb { background: #C1BA8A; border-radius: 4px; }
        .table-container::-webkit-scrollbar-thumb:hover { background: #A69E65; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 antialiased pb-16">

    <!-- Navbar -->
    <nav class="w-full glass-nav p-4 flex justify-between items-center lg:px-8 shadow-xs sticky top-0 z-50">
        <div class="flex items-center space-x-2 text-white font-bold text-xl">
            <!-- Mobile Menu Toggle -->
            <button id="mobileMenuBtn" class="lg:hidden mr-3 text-white focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
            <i class="fa-solid fa-camera-retro hidden sm:inline-block"></i>
            <span class="font-serif tracking-wide">graphic.photostudio</span>
        </div>
        
        <!-- Desktop Nav Links -->
        <div class="hidden lg:flex items-center space-x-8 text-white/90 font-medium text-sm">
            <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'text-white border-b-2 border-white pb-1 font-bold' : 'hover:text-white transition' }}">Dashboard</a>
            <a href="/admin/paket" class="{{ request()->is('admin/paket') ? 'text-white border-b-2 border-white pb-1 font-bold' : 'hover:text-white transition' }}">Mengelola paket</a>
            <a href="/admin/verifikasi-pembayaran" class="{{ request()->is('admin/verifikasi-pembayaran') ? 'text-white border-b-2 border-white pb-1 font-bold' : 'hover:text-white transition' }}">Verifikasi pembayaran</a>
            <a href="/admin/laporan" class="{{ request()->is('admin/laporan') ? 'text-white border-b-2 border-white pb-1 font-bold' : 'hover:text-white transition' }}">Laporan</a>
            
            <div class="relative inline-block text-left ml-2">
                <button onclick="toggleProfileMenu()" class="w-9 h-9 rounded-full bg-white hover:bg-gray-100 text-[#C1BA8A] flex items-center justify-center transition-all duration-300 shadow-sm cursor-pointer focus:outline-none ring-2 ring-white/50">
                    <i class="fa-solid fa-user-tie text-sm"></i>
                </button>

                <div id="dropdownProfil" class="hidden absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transform origin-top-right transition-all text-gray-800 z-50">
                    <div class="p-5 bg-gray-50/50 border-b border-gray-100">
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-xl shadow-inner">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-sm font-black text-gray-800 truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                                <p class="text-[10px] font-medium text-gray-400 truncate">{{ auth()->user()->email ?? 'admin@studio.com' }}</p>
                            </div>
                        </div>
                        <span class="inline-block mt-1 px-2.5 py-1 bg-purple-50 text-purple-600 border border-purple-200 rounded text-[9px] font-bold uppercase tracking-wider">
                            <i class="fa-solid fa-crown mr-1"></i> Admin Studio
                        </span>
                    </div>
                    <div class="p-2">
                        <form action="{{ url('/logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" onclick="return confirm('Apakah Admin yakin ingin keluar dari sistem?')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition flex items-center gap-3 cursor-pointer group">
                                <i class="fa-solid fa-right-from-bracket group-hover:-translate-x-1 transition-transform"></i> 
                                Keluar (Logout)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Profile Button -->
        <div class="lg:hidden relative">
            <button onclick="toggleMobileProfileMenu()" class="w-8 h-8 rounded-full bg-white text-[#C1BA8A] flex items-center justify-center shadow-sm focus:outline-none">
                <i class="fa-solid fa-user-tie text-xs"></i>
            </button>
            <div id="dropdownMobileProfil" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-50">
                <div class="p-4 bg-gray-50/50 border-b border-gray-100">
                    <p class="text-sm font-bold text-gray-800 truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[10px] text-gray-400 truncate">{{ auth()->user()->email ?? 'admin@studio.com' }}</p>
                </div>
                <div class="p-2">
                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-lg flex items-center gap-2">
                            <i class="fa-solid fa-right-from-bracket"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar Menu -->
    <div id="mobileMenu" class="fixed inset-0 bg-black/60 z-[60] hidden transition-opacity duration-300">
        <div class="w-64 h-full bg-white shadow-2xl transform -translate-x-full transition-transform duration-300 flex flex-col" id="mobileMenuContent">
            <div class="p-5 bg-[#C1BA8A] text-white flex justify-between items-center">
                <span class="font-serif font-bold text-lg">Menu Admin</span>
                <button id="closeMobileMenu" class="text-white focus:outline-none">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="p-4 flex flex-col space-y-2 flex-grow overflow-y-auto">
                <a href="/admin/dashboard" class="px-4 py-3 rounded-lg font-medium text-sm flex items-center gap-3 {{ request()->is('admin/dashboard') ? 'bg-amber-50 text-[#A69E65]' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i> Dashboard
                </a>
                <a href="/admin/paket" class="px-4 py-3 rounded-lg font-medium text-sm flex items-center gap-3 {{ request()->is('admin/paket') ? 'bg-amber-50 text-[#A69E65]' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-box w-5 text-center"></i> Mengelola Paket
                </a>
                <a href="/admin/verifikasi-pembayaran" class="px-4 py-3 rounded-lg font-medium text-sm flex items-center gap-3 {{ request()->is('admin/verifikasi-pembayaran') ? 'bg-amber-50 text-[#A69E65]' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i> Verifikasi Pembayaran
                </a>
                <a href="/admin/laporan" class="px-4 py-3 rounded-lg font-medium text-sm flex items-center gap-3 {{ request()->is('admin/laporan') ? 'bg-amber-50 text-[#A69E65]' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-file-lines w-5 text-center"></i> Laporan
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <script>
        // Desktop Profile Dropdown
        function toggleProfileMenu() {
            const menu = document.getElementById('dropdownProfil');
            menu.classList.toggle('hidden');
        }

        // Mobile Profile Dropdown
        function toggleMobileProfileMenu() {
            const menu = document.getElementById('dropdownMobileProfil');
            menu.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        window.addEventListener('click', function(e) {
            const desktopMenu = document.getElementById('dropdownProfil');
            const desktopBtn = document.querySelector('[onclick="toggleProfileMenu()"]');
            if (desktopMenu && !desktopMenu.contains(e.target) && !desktopBtn.contains(e.target)) {
                desktopMenu.classList.add('hidden');
            }

            const mobileMenu = document.getElementById('dropdownMobileProfil');
            const mobileBtn = document.querySelector('[onclick="toggleMobileProfileMenu()"]');
            if (mobileMenu && !mobileMenu.contains(e.target) && !mobileBtn.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });

        // Mobile Sidebar Logic
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeMobileMenu = document.getElementById('closeMobileMenu');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuContent = document.getElementById('mobileMenuContent');

        function openMobileSidebar() {
            mobileMenu.classList.remove('hidden');
            // small delay for transition
            setTimeout(() => {
                mobileMenuContent.classList.remove('-translate-x-full');
            }, 10);
        }

        function closeMobileSidebar() {
            mobileMenuContent.classList.add('-translate-x-full');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
            }, 300);
        }

        if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openMobileSidebar);
        if (closeMobileMenu) closeMobileMenu.addEventListener('click', closeMobileSidebar);
        if (mobileMenu) {
            mobileMenu.addEventListener('click', function(e) {
                if (e.target === mobileMenu) {
                    closeMobileSidebar();
                }
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>
