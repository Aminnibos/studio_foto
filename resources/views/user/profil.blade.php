<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Graphic Photostudio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans pb-12">

    <nav class="w-full bg-[#C1BA8A] text-white shadow-md px-6 py-4 flex flex-wrap justify-between items-center relative z-50">
        <div class="flex items-center space-x-2 font-bold tracking-wide text-lg">
            <i class="fa-solid fa-camera-retro"></i>
            <span>graphic.photostudio</span>
        </div>
        <div class="flex items-center space-x-6 text-xs font-semibold mt-2 md:mt-0">
            <a href="/dashboard-studio" class="hover:text-gray-200 transition">Dasboard</a>
            <a href="/paket-foto" class="hover:text-gray-200 transition">Paket foto</a>
            <a href="/galeri" class="hover:text-gray-200 transition">Galeri</a>
            <a href="/riwayat-pemesanan" class="hover:text-gray-200 transition">Riwayat Pemesanan</a>
            
            <div class="relative inline-block text-left">
                <button onclick="toggleProfileMenu()" class="w-8 h-8 rounded-full bg-white hover:bg-gray-100 text-[#C1BA8A] flex items-center justify-center transition-all duration-300 shadow-sm cursor-pointer focus:outline-none ring-2 ring-white/50">
                    <i class="fa-solid fa-user text-sm"></i>
                </button>

                <div id="dropdownProfil" class="hidden absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transform origin-top-right transition-all text-gray-800">
                    
                    <div class="p-5 bg-gray-50/50 border-b border-gray-100">
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="w-10 h-10 rounded-full bg-[#C1BA8A]/20 text-[#C1BA8A] flex items-center justify-center text-xl shadow-inner">
                                <i class="fa-solid fa-circle-user"></i>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-sm font-black text-gray-800 truncate">{{ auth()->user()->name ?? 'Nama Pelanggan' }}</p>
                                <p class="text-[10px] font-medium text-gray-400 truncate">{{ auth()->user()->email ?? 'email@contoh.com' }}</p>
                            </div>
                        </div>
                        <span class="inline-block mt-1 px-2.5 py-1 bg-amber-50 text-[#A69E65] border border-amber-100 rounded text-[9px] font-bold uppercase tracking-wider">
                            Pelanggan Studio
                        </span>
                    </div>

                    <div class="p-2">
                        <form action="{{ url('/logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar dari akun?')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition flex items-center gap-3 cursor-pointer group">
                                <i class="fa-solid fa-right-from-bracket group-hover:-translate-x-1 transition-transform"></i> 
                                Keluar (Logout)
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            </div>
    </nav>
    <div class="p-4 max-w-[700px] mx-auto space-y-6 mt-8 relative z-10">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-black text-gray-800 flex items-center justify-center gap-2">
                <i class="fa-regular fa-id-badge text-[#C1BA8A]"></i> Profil Saya
            </h1>
            <p class="text-xs text-gray-400 mt-1">Kelola informasi akun Anda</p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-24 bg-[#C1BA8A]/20"></div>
            
            <div class="w-24 h-24 bg-white border-4 border-white rounded-full mx-auto flex items-center justify-center text-4xl text-gray-300 shadow-md relative z-10 mb-4">
                <i class="fa-solid fa-circle-user"></i>
            </div>
            
            <h2 class="text-2xl font-black text-gray-800">{{ auth()->user()->name ?? 'Nama Pengguna' }}</h2>
            <p class="text-gray-500 font-medium text-sm mt-1">{{ auth()->user()->email ?? 'email@contoh.com' }}</p>
            
            <span class="inline-block mt-4 px-4 py-1.5 bg-amber-50 text-[#C1BA8A] rounded-full text-[10px] font-black tracking-wider uppercase border border-amber-100">
                <i class="fa-solid fa-crown mr-1"></i> Pelanggan Studio
            </span>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-3 mb-5 text-sm uppercase tracking-wide">
                <i class="fa-solid fa-list-check text-[#C1BA8A] mr-2"></i> Data Akun
            </h3>
            
            <div class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-3 border-b border-gray-50 pb-4">
                    <span class="text-xs text-gray-400 font-bold uppercase block sm:col-span-1">Nama Lengkap</span>
                    <span class="font-bold text-gray-800 text-sm sm:col-span-2">{{ auth()->user()->name ?? '-' }}</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 border-b border-gray-50 pb-4">
                    <span class="text-xs text-gray-400 font-bold uppercase block sm:col-span-1">Alamat Email</span>
                    <span class="font-bold text-gray-800 text-sm sm:col-span-2">{{ auth()->user()->email ?? '-' }}</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 pb-2">
                    <span class="text-xs text-gray-400 font-bold uppercase block sm:col-span-1">Bergabung Sejak</span>
                    <span class="font-bold text-gray-800 text-sm sm:col-span-2">
                        {{ auth()->user()->created_at ? auth()->user()->created_at->format('d F Y') : '-' }}
                    </span>
                </div>
            </div>
        </div>

    </div>

    <script>
        function toggleProfileMenu() {
            const dropdown = document.getElementById('dropdownProfil');
            dropdown.classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            const button = document.querySelector('button[onclick="toggleProfileMenu()"]');
            const dropdown = document.getElementById('dropdownProfil');
            
            if (button && dropdown && !button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

</body>
</html>