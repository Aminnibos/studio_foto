<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - Graphic Photostudio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans flex flex-col min-h-screen">

    <nav class="w-full bg-[#C1BA8A] text-white shadow-md px-6 py-4 flex flex-wrap justify-between items-center relative z-50">
        <div class="flex items-center space-x-2 font-bold tracking-wide text-lg">
            <i class="fa-solid fa-camera-retro"></i>
            <span>graphic.photostudio</span>
        </div>
        <div class="flex items-center space-x-6 text-xs font-semibold mt-2 md:mt-0">
            <a href="/dashboard-studio" class="hover:text-gray-200 transition">Dasboard</a>
            <a href="/paket-foto" class="hover:text-gray-200 transition">Paket foto</a>
            <a href="/galeri" class="hover:text-gray-200 transition">Galeri</a>
            <a href="/riwayat-pemesanan" class="border-b-2 border-white pb-1 font-bold">Riwayat Pemesanan</a>
            
            <div class="relative inline-block text-left">
                <button onclick="toggleProfileMenu()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white text-white hover:text-[#C1BA8A] flex items-center justify-center transition-all duration-300 shadow-sm cursor-pointer focus:outline-none ring-2 ring-transparent hover:ring-white/50">
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
    <div class="flex-1 max-w-7xl w-full mx-auto p-4 md:p-8 space-y-6 relative z-10">

        @if(session('success'))
            <div class="w-full bg-[#D1F7E2] border border-[#A2E9C1] text-[#1E5631] font-bold text-center py-3 px-4 rounded-xl text-xs shadow-xs">
                {{ session('success') }}
            </div>
        @else
            <div class="w-full bg-[#D1F7E2] border border-[#A2E9C1] text-[#1E5631] font-bold text-center py-3 px-4 rounded-xl text-xs shadow-xs">
                Order Berhasil Di Buat. Admin Akan Menghubungi Anda Melalui Nomor Yang Telah Di Cantum
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-x-auto p-4 md:p-6">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="border-b border-gray-100 text-[11px] font-black text-gray-700 uppercase tracking-wider text-center">
                        <th class="py-4 px-3 text-left">Tanggal Pemesanan</th>
                        <th class="py-4 px-3 text-left">Tanggal Pemotretan</th>
                        <th class="py-4 px-3 text-left">Order Produk</th>
                        <th class="py-4 px-3 text-left">Nama Pelanggan</th>
                        <th class="py-4 px-3 text-left">Harga</th>
                        <th class="py-4 px-3">Metode Bayar</th>
                        <th class="py-4 px-3">Status Sesi</th>
                        <th class="py-4 px-3">Bukti / Instruksi Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="text-xs text-gray-600 divide-y divide-gray-50 text-center">
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="py-4 px-3 text-gray-400 text-left">
                                {{ \Carbon\Carbon::parse($booking->created_at)->format('Y-m-d') }}
                            </td>
                            <td class="py-4 px-3 font-semibold text-gray-800 text-left">
                                {{ $booking->tanggal_pemotretan }} {{ $booking->jam_pemotretan }}
                            </td>
                            <td class="py-4 px-3 font-bold text-gray-900 text-left">
                                {{ $booking->paket->nama_paket ?? $booking->nama_paket }}
                            </td>
                            <td class="py-4 px-3 text-gray-500 text-left">
                                {{ $booking->user->name ?? $booking->nama_pelanggan }}
                            </td>
                            <td class="py-4 px-3 font-bold text-gray-800 text-left">
                                Rp {{ number_format($booking->harga ?? $booking->paket->harga ?? $booking->total_pembayaran, 0, ',', '.') }}
                            </td>
                            
                            <td class="py-4 px-3 font-bold text-gray-700">
                                <span class="bg-gray-100 px-2 py-1 rounded text-[10px]">{{ $booking->metode_pembayaran ?? 'Transfer' }}</span>
                            </td>

                            <td class="py-4 px-3">
                                @if(strtolower($booking->status) === 'pending' || strtolower($booking->status) === 'menunggu')
                                    <span class="bg-[#FF9800] text-white text-[10px] font-bold px-2.5 py-1 rounded-md shadow-3xs uppercase">
                                        Pending
                                    </span>
                                @elseif(strtolower($booking->status) === 'success' || strtolower($booking->status) === 'disetujui')
                                    <span class="bg-[#4CAF50] text-white text-[10px] font-bold px-2.5 py-1 rounded-md shadow-3xs uppercase">
                                        Success
                                    </span>
                                @else
                                    <span class="bg-red-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-md shadow-3xs uppercase">
                                        {{ $booking->status }}
                                    </span>
                                @endif
                            </td>
                            
                            <td class="py-4 px-3 text-center w-64 align-top">
                                
                                @if(str_contains(strtolower($booking->metode_pembayaran), 'cash') || str_contains(strtolower($booking->metode_pembayaran), 'tempat'))
                                    
                                    <div class="border border-emerald-200 bg-emerald-50 text-emerald-700 p-3 rounded-lg flex flex-col justify-center items-center shadow-xs">
                                        <i class="fa-solid fa-money-bill-wave text-xl mb-1 text-emerald-500"></i>
                                        <p class="text-[10px] font-black uppercase tracking-wider">Bayar Tunai</p>
                                        <p class="text-[9px] mt-1 font-medium">Lakukan pembayaran di kasir studio.</p>
                                    </div>
                                    
                                @else
                                    
                                    @if($booking->bukti_pembayaran)
                                        <div class="flex flex-col items-center space-y-1">
                                            <span class="text-[10px] text-green-600 font-medium"><i class="fa-solid fa-circle-check"></i> Sudah Upload</span>
                                            <a href="{{ asset('storage/' . $booking->bukti_pembayaran) }}" target="_blank" class="text-[10px] text-[#B5A46D] hover:underline">Lihat Gambar</a>
                                        </div>
                                    @else
                                        <div class="border border-amber-200 bg-[#FFFDF6] p-2 rounded text-center mb-2 shadow-xs">
                                            <p class="text-[10px] text-amber-700 font-bold mb-1">Transfer DANA:</p>
                                            <p class="font-black text-gray-800 text-sm tracking-wider">0812-3456-7890</p>
                                            <p class="text-[9px] text-gray-500">(a.n Graphic Studio)</p>
                                        </div>

                                        <form action="/riwayat-pemesanan/upload/{{ $booking->id }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center space-y-2">
                                            @csrf
                                            <input type="file" name="bukti_pembayaran" accept="image/*" class="text-[10px] text-gray-400 w-full file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-gray-100 file:text-gray-600 hover:file:bg-gray-200 cursor-pointer" required>
                                            <button type="submit" class="w-full bg-[#FFB300] hover:bg-[#FFA000] text-white text-[10px] font-black py-1.5 px-3 rounded-md shadow-3xs transition cursor-pointer uppercase tracking-wider">
                                                Upload Pembayaran
                                            </button>
                                        </form>
                                    @endif

                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-gray-400 font-medium">
                                Belum ada riwayat pemesanan foto.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <script>
        function toggleProfileMenu() {
            const dropdown = document.getElementById('dropdownProfil');
            dropdown.classList.toggle('hidden');
        }

        // Menutup dropdown jika user mengklik sembarang tempat di luar menu
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