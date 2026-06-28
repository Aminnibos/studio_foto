<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Foto - Graphic Photostudio</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">

    <div class="w-full bg-[#C1BA8A] p-4 flex justify-between items-center px-8 shadow-xs">
        <div class="flex items-center space-x-2 text-white font-bold text-xl">
            <i class="fa-solid fa-camera-retro"></i>
            <span>graphic.photostudio</span>
        </div>
        <div class="flex items-center space-x-8 text-white/90 font-medium text-sm">
            <a href="/" class="hover:text-white transition">Dasboard</a>
            <a href="/paket-foto" class="text-white border-b-2 border-white pb-1 font-bold">Paket foto</a>
            <a href="/galeri" class="hover:text-white transition">Galeri</a>
            <a href="/riwayat-pemesanan" class="hover:text-white transition">Riwayat Pemesan</a>
            <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center text-white text-xs"><i class="fa-regular fa-user"></i></div>
        </div>
    </div>

    <div class="p-8 max-w-[1200px] mx-auto space-y-6">
        <div class="text-center">
            <h2 class="text-xl font-serif italic text-[#A69E65] tracking-wide">Kategori & List Harga</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-4">
            @forelse($daftarPaket as $paket)
            <div class="bg-white rounded-xl shadow-xs border border-gray-200 overflow-hidden flex flex-col justify-between group">
                <div class="bg-[#C1BA8A] p-2 text-center text-white font-bold text-xs tracking-wider uppercase">
                    {{ $paket->nama_paket }}
                </div>
                <div class="h-80 bg-gray-50 overflow-hidden">
                    @if($paket->gambar)
                        <img src="{{ asset('storage/' . $paket->gambar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 text-xs"><i class="fa-regular fa-image text-4xl mb-2"></i> No Cover</div>
                    @endif
                </div>
                <div class="p-4 bg-white space-y-2 text-xs text-gray-500 border-t border-gray-100 font-medium">
                    <div class="flex items-center space-x-2"><i class="fa-solid fa-camera text-[#A69E65]"></i> <span>{{ $paket->foto ?? '50x' }} Shoot</span></div>
                    <div class="flex items-center space-x-2"><i class="fa-regular fa-clock text-[#A69E65]"></i> <span>{{ $paket->durasi ?? '15 Menit' }}</span></div>
                    <div class="flex items-center space-x-2"><i class="fa-regular fa-user text-[#A69E65]"></i> <span>MAX. {{ $paket->kategori == 'Keluarga' ? '20' : '5' }} person</span></div>
                </div>
                <a href="/booking/{{ $paket->id }}" class="block text-center bg-[#C1BA8A] hover:bg-[#A69E65] text-white p-3 font-bold text-sm tracking-wide transition border-t border-white/20">
                    Rp {{ number_format($paket->harga, 0, ',', '.') }}
                </a>
            </div>
            @empty
            <div class="col-span-3 text-center text-gray-400 text-xs italic py-12">Belum ada paket foto yang ditawarkan admin.</div>
            @endforelse
        </div>
    </div>

</body>
</html>