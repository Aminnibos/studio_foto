<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Aktivitas - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">

    <div class="w-full bg-[#C1BA8A] p-4 flex justify-between items-center px-8 shadow-xs relative z-50">
        <div class="flex items-center space-x-2 text-white font-bold text-xl">
            <i class="fa-solid fa-camera-retro"></i>
            <span>graphic.photostudio</span>
        </div>
        <div class="flex items-center space-x-8 text-white/90 font-medium text-sm">
            <a href="/admin/dashboard" class="hover:text-white transition">Dasboard</a>
            <a href="/admin/paket" class="hover:text-white transition">Mengelola paket</a>
            <a href="/admin/verifikasi-pembayaran" class="hover:text-white transition">Verifikasi pembayaran</a>
            <a href="/admin/laporan" class="text-white border-b-2 border-white pb-1 font-bold">Laporan</a>
            
            <div class="relative inline-block text-left ml-2">
                <button onclick="toggleProfileMenu()" class="w-8 h-8 rounded-full bg-white hover:bg-gray-100 text-[#C1BA8A] flex items-center justify-center transition-all duration-300 shadow-sm cursor-pointer focus:outline-none ring-2 ring-white/50">
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
    </div>
    <div class="p-8 max-w-[1400px] mx-auto space-y-6 relative z-10">
        
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center space-x-2">
                <span class="w-7 h-7 bg-amber-100 rounded-lg text-[#A69E65] flex items-center justify-center text-sm"><i class="fa-regular fa-folder-open"></i></span>
                <span>Laporan</span>
            </h1>
            <p class="text-xs text-gray-400 mt-1">Ringkasan data dan Laporan Aktifitas studio foto</p>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-2xs flex flex-wrap items-center justify-between gap-4 text-xs">
            <div>
                <label class="block font-bold text-gray-700 mb-1">Filter Paket</label>
                <div class="flex border border-gray-200 rounded-lg overflow-hidden bg-gray-50 font-medium text-center">
                    <a href="/admin/laporan?paket=Semua Paket" class="block px-4 py-2 {{ $filterPaket == 'Semua Paket' ? 'bg-[#C1BA8A] text-white font-bold' : 'text-gray-500 hover:bg-gray-100' }} transition">
                        Semua Paket
                    </a>
                    @foreach($listPaket as $nama)
                    <a href="/admin/laporan?paket={{ urlencode($nama) }}" class="block px-4 py-2 {{ $filterPaket == $nama ? 'bg-[#C1BA8A] text-white font-bold' : 'text-gray-500 hover:bg-gray-100' }} transition">
                        {{ $nama }}
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="space-y-1">
                <span class="block font-bold text-gray-700">Ekspor Data Laporan</span>
                <div class="flex space-x-2">
                    <a href="/admin/laporan/excel?paket={{ urlencode($filterPaket) }}" class="px-4 py-2 bg-[#C1BA8A] hover:bg-[#A69E65] text-white font-bold rounded-lg shadow-2xs transition flex items-center space-x-1.5 cursor-pointer text-center no-underline">
                        <i class="fa-regular fa-file-excel"></i> <span>Ekspor Excel</span>
                    </a>
                    <a href="/admin/laporan/pdf?paket={{ urlencode($filterPaket) }}" class="px-4 py-2 bg-[#C1BA8A] hover:bg-[#A69E65] text-white font-bold rounded-lg shadow-2xs transition flex items-center space-x-1.5 cursor-pointer text-center no-underline">
                        <i class="fa-regular fa-file-pdf"></i> <span>Ekspor PDF</span>
                    </a>
                </div>
            </div>
        </div>

        <hr class="border-gray-200">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border-2 border-amber-100 shadow-sm text-center md:text-left">
                <span class="text-sm font-bold text-gray-500 block">Total Pendapatan</span>
                <h2 class="text-3xl font-black text-gray-800 mt-2">RP {{ number_format($laporanStatistik['total_pendapatan'], 0, ',', '.') }}</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl border-2 border-amber-100 shadow-sm text-center md:text-left">
                <span class="text-sm font-bold text-gray-500 block">Total Pemesan Selesai</span>
                <h2 class="text-3xl font-black text-gray-800 mt-2">{{ $laporanStatistik['total_sesi_selesai'] }} Sesi</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl border-2 border-amber-100 shadow-sm text-center md:text-left">
                <span class="text-sm font-bold text-gray-500 block">Paket Terlaris</span>
                <h2 class="text-3xl font-black text-gray-800 mt-2">{{ $laporanStatistik['paket_terlaris'] }}</h2>
            </div>
        </div>

        <div class="space-y-3">
            <h3 class="font-extrabold text-gray-800 text-sm border-b-2 border-gray-800 pb-2">Tabel Detail Laporan Transaksi</h3>
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-2xs text-xs">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 font-bold uppercase tracking-wider">
                            <th class="p-4 w-12 text-center">No</th>
                            <th class="p-4">Kode Nota</th>
                            <th class="p-4">Nama Pelanggan</th>
                            <th class="p-4">Paket Pilihan</th>
                            <th class="p-4 text-center">Tanggal Selesai</th>
                            <th class="p-4 text-center">Metode Bayar</th>
                            <th class="p-4 text-right">Jumlah Uang</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-600 font-medium">
                        @forelse($detailTransaksi as $dt)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 text-center text-gray-400 font-normal">{{ $dt['no'] }}</td>
                            <td class="p-4 font-bold text-gray-800">{{ $dt['nota'] }}</td>
                            <td class="p-4 font-bold text-gray-900">{{ $dt['pelanggan'] }}</td>
                            <td class="p-4"><span class="bg-indigo-50 text-indigo-600 font-bold px-2 py-0.5 rounded text-[10px]">{{ $dt['paket'] }}</span></td>
                            <td class="p-4 text-center">{{ $dt['tanggal'] }}</td>
                            <td class="p-4 text-center"><span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-[10px]">{{ $dt['metode'] }}</span></td>
                            <td class="p-4 text-right font-bold text-gray-900">Rp {{ number_format($dt['jumlah'], 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400 italic">Tidak ada transaksi lunas ditemukan untuk filter ini. Pastikan Anda sudah 'Menyetujui' pesanan di tab Verifikasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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