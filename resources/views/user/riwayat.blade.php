@extends('layouts.user')

@section('title', 'Riwayat Pemesanan - Graphic Photostudio')

@push('styles')
<style>
    /* Efek hover tabel */
    tbody tr { transition: all 0.2s ease-in-out; }
    @media (min-width: 768px) {
        tbody tr:hover { background-color: #fbfaf8; transform: scale-[1.002]; box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05); position: relative; z-index: 10; border-radius: 0.5rem; }
    }
</style>
@endpush

@section('content')
<div class="pt-10 pb-20 md:pt-16 md:pb-24 max-w-[1300px] w-full mx-auto px-4 md:px-8 space-y-8 fade-in">
    
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl md:text-4xl font-heading font-black text-dark tracking-tight">Riwayat <span class="text-studio-400 italic">Pesanan</span></h2>
            <p class="text-xs md:text-sm text-gray-500 mt-2">Pantau status pesanan dan unggah bukti pembayaran Anda di sini.</p>
        </div>
        <span class="inline-block px-4 py-2 bg-studio-50 text-studio-500 rounded-xl border border-studio-100 text-xs font-bold uppercase tracking-wider shadow-sm">
            Total Pesanan: {{ $riwayat->count() }}
        </span>
    </div>

    @if(session('success'))
        <div class="w-full bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 md:p-5 rounded-2xl text-xs md:text-sm shadow-sm flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-check text-lg"></i>
            </div>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @else
        <div class="w-full bg-blue-50/80 border border-blue-200 text-blue-700 p-4 md:p-5 rounded-2xl text-xs md:text-sm shadow-sm flex items-start md:items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0 mt-0.5 md:mt-0">
                <i class="fa-solid fa-circle-info text-lg"></i>
            </div>
            <span class="font-medium">Pesanan Anda tercatat dengan aman. Silakan selesaikan pembayaran atau tunjukkan kode ke kasir.</span>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden w-full">
        <div class="overflow-x-auto w-full no-scrollbar md:scrollbar-default">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="py-5 px-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] whitespace-nowrap">Tanggal Order</th>
                        <th class="py-5 px-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] whitespace-nowrap">Jadwal Foto</th>
                        <th class="py-5 px-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] whitespace-nowrap">Paket</th>
                        <th class="py-5 px-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] whitespace-nowrap">Pemesan</th>
                        <th class="py-5 px-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] whitespace-nowrap">Harga</th>
                        <th class="py-5 px-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] whitespace-nowrap text-center">Status</th>
                        <th class="py-5 px-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] text-center w-64">Pembayaran</th>
                        <th class="py-5 px-6 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em] text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    
                    @forelse($riwayat as $rw)
                        <tr class="text-sm">
                            <!-- Tgl Pemesanan -->
                            <td class="py-4 px-6 align-middle whitespace-nowrap">
                                <span class="text-xs text-gray-500 font-medium bg-gray-50 px-3 py-1 rounded-full border border-gray-100">
                                    {{ $rw->created_at->format('d M Y') }}
                                </span>
                            </td>
                            
                            <!-- Jadwal Foto -->
                            <td class="py-4 px-6 align-middle whitespace-nowrap">
                                <div class="font-bold text-dark text-sm">{{ \Carbon\Carbon::parse($rw->tanggal_booking)->format('d M Y') }}</div>
                                <div class="text-[10px] text-gray-500 mt-1 font-medium bg-gray-50 px-2 py-0.5 rounded inline-flex items-center gap-1 border border-gray-100">
                                    <i class="fa-regular fa-clock text-studio-400"></i>{{ \Carbon\Carbon::parse($rw->tanggal_booking)->format('H:i') }} WIB
                                </div>
                            </td>
                            
                            <!-- Paket -->
                            <td class="py-4 px-6 align-middle whitespace-nowrap">
                                <span class="font-heading font-black text-dark text-sm uppercase">
                                    {{ $rw->paket }}
                                </span>
                            </td>
                            
                            <!-- Nama Pelanggan -->
                            <td class="py-4 px-6 text-gray-600 font-medium align-middle whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-studio-50 text-studio-500 flex items-center justify-center text-[10px]">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    {{ $rw->nama_pelanggan }}
                                </div>
                            </td>
                            
                            <!-- Harga -->
                            <td class="py-4 px-6 align-middle whitespace-nowrap">
                                <span class="font-black font-heading text-studio-500 text-base">
                                    Rp {{ number_format($rw->total_pembayaran, 0, ',', '.') }}
                                </span>
                            </td>
                            
                            <!-- Status -->
                            <td class="py-4 px-6 align-middle text-center whitespace-nowrap">
                                @if($rw->status == 'Menunggu' || $rw->status == 'Pending' || $rw->status == 'pending')
                                    <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 text-[10px] font-bold px-3 py-1.5 rounded-full border border-amber-200/50 uppercase tracking-wider shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Pending
                                    </span>
                                @elseif($rw->status == 'Disetujui' || $rw->status == 'Success')
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold px-3 py-1.5 rounded-full border border-emerald-200/50 uppercase tracking-wider shadow-sm">
                                        <i class="fa-solid fa-check"></i> Lunas
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-600 text-[10px] font-bold px-3 py-1.5 rounded-full border border-rose-200/50 uppercase tracking-wider shadow-sm">
                                        <i class="fa-solid fa-xmark"></i> Ditolak
                                    </span>
                                @endif
                            </td>

                            <!-- Pembayaran -->
                            <td class="py-4 px-6 align-middle">
                                @php
                                    $metode = strtolower($rw->metode_pembayaran ?? 'transfer');
                                @endphp

                                @if(str_contains($metode, 'transfer') || str_contains($metode, 'dana'))
                                    <div class="space-y-3 w-full max-w-[200px] mx-auto">
                                        <!-- Info Dana -->
                                        <div class="bg-blue-50/50 border border-blue-100 p-2.5 rounded-xl text-center">
                                            <p class="text-[9px] text-blue-600 font-bold uppercase tracking-wider mb-1">Transfer DANA</p>
                                            <p class="font-heading font-black text-dark text-sm tracking-widest bg-white rounded-md py-1 border border-blue-50 shadow-sm">0812-3456-7890</p>
                                        </div>

                                        <!-- Upload Bukti -->
                                        @if($rw->bukti_pembayaran)
                                            <div class="flex items-center justify-between bg-gray-50 p-2 rounded-xl border border-gray-100">
                                                <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                                                    <i class="fa-solid fa-circle-check"></i> Terupload
                                                </span>
                                                <a href="{{ asset('storage/' . $rw->bukti_pembayaran) }}" target="_blank" class="block overflow-hidden rounded-lg border border-gray-200 hover:shadow-md hover:border-studio-400 transition w-10 h-10 group bg-white">
                                                    <img src="{{ asset('storage/' . $rw->bukti_pembayaran) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                                </a>
                                            </div>
                                        @else
                                            <form action="/riwayat-pemesanan/upload/{{ $rw->id }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2">
                                                @csrf
                                                <div class="relative overflow-hidden inline-block w-full">
                                                    <button type="button" class="w-full bg-gray-50 border border-gray-200 text-gray-600 hover:bg-gray-100 hover:border-gray-300 text-[10px] font-bold py-2 px-3 rounded-xl transition flex items-center justify-center gap-2">
                                                        <i class="fa-solid fa-image"></i> Pilih Gambar
                                                    </button>
                                                    <input type="file" name="bukti_pembayaran" accept="image/*" class="absolute left-0 top-0 opacity-0 w-full h-full cursor-pointer" required onchange="this.nextElementSibling.classList.remove('hidden')">
                                                    <button type="submit" class="hidden mt-2 w-full bg-dark hover:bg-studio-400 text-white text-[10px] font-bold py-2 px-3 rounded-xl transition flex items-center justify-center gap-2 uppercase tracking-wider">
                                                        <i class="fa-solid fa-cloud-arrow-up"></i> Upload
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                @else
                                    <div class="bg-emerald-50/50 border border-emerald-100 p-3 rounded-xl flex flex-col items-center justify-center w-full max-w-[200px] mx-auto text-center h-full min-h-[80px]">
                                        <div class="w-8 h-8 rounded-full bg-white text-emerald-500 shadow-sm flex items-center justify-center mb-2 border border-emerald-50">
                                            <i class="fa-solid fa-money-bill-wave text-xs"></i>
                                        </div>
                                        <p class="text-[10px] font-black text-emerald-700 uppercase tracking-wider mb-1">Bayar Tunai</p>
                                        <p class="text-[9px] text-emerald-600/70 font-medium">Bayar di kasir studio</p>
                                    </div>
                                @endif
                            </td>

                            <!-- Aksi Batal -->
                            <td class="py-4 px-6 align-middle text-center">
                                <form action="/riwayat-pemesanan/hapus/{{ $rw->id }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 rounded-full bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white border border-rose-100 transition-all shadow-sm flex items-center justify-center mx-auto" title="Batalkan Pesanan">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-20 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100 shadow-sm">
                                        <i class="fa-regular fa-folder-open text-3xl text-gray-300"></i>
                                    </div>
                                    <h3 class="text-lg font-heading font-black text-dark mb-1">Belum Ada Pesanan</h3>
                                    <p class="text-xs text-gray-500 max-w-xs mx-auto">Anda belum membuat pesanan apapun. Mulai jelajahi paket foto kami sekarang.</p>
                                    <a href="/paket-foto" class="mt-4 px-6 py-2 bg-studio-400 hover:bg-studio-500 text-dark font-bold text-xs uppercase tracking-wider rounded-full transition-colors">
                                        Lihat Paket
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection