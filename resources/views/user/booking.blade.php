@extends('layouts.user')

@section('title', 'Reservasi Jadwal - Graphic Photostudio')

@section('content')
<div class="pt-10 pb-20 md:pt-16 md:pb-24 px-4 md:px-8 max-w-[1200px] mx-auto min-h-[70vh] fade-in">
    <div class="mb-8">
        <a href="javascript:history.back()" class="inline-flex items-center text-xs md:text-sm font-bold text-gray-400 hover:text-studio-500 uppercase tracking-wider transition-colors group">
            <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center mr-3 group-hover:border-studio-200 group-hover:bg-studio-50 transition-all">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 flex flex-col md:flex-row overflow-hidden">
        
        <!-- Summary Section (Left) -->
        <div class="w-full md:w-[40%] bg-dark text-white p-8 md:p-12 relative overflow-hidden flex flex-col">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-studio-400/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            
            <div class="relative z-10 flex-1">
                <span class="inline-block py-1 px-3 rounded-full bg-white/10 text-studio-300 backdrop-blur-sm border border-white/10 text-[10px] md:text-xs font-bold uppercase tracking-[0.2em] mb-6">
                    Ringkasan Pesanan
                </span>
                
                <h2 class="text-3xl md:text-4xl font-heading font-black text-white uppercase tracking-wide mb-8">
                    {{ $paket->nama_paket }}
                </h2>

                <div class="w-full h-48 md:h-56 bg-gray-800 rounded-2xl mb-8 overflow-hidden border border-white/10 shadow-lg relative group">
                    @if($paket->gambar)
                        <img src="{{ asset('storage/' . $paket->gambar) }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-500">
                            <i class="fa-solid fa-image text-4xl mb-2 opacity-50"></i>
                            <span class="text-xs tracking-widest uppercase">No Image</span>
                        </div>
                    @endif
                    <div class="absolute bottom-4 left-4">
                        <span class="bg-studio-400 text-dark text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                            Tema: {{ $paket->kategori }}
                        </span>
                    </div>
                </div>

                <ul class="space-y-4 text-sm text-gray-300 font-medium mb-12">
                    <li class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center border border-white/10 text-studio-400">
                            <i class="fa-solid fa-camera-retro"></i>
                        </div>
                        <span>50x Shoot</span>
                    </li>
                    <li class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center border border-white/10 text-studio-400">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <span>Durasi: {{ $paket->durasi }}</span>
                    </li>
                    <li class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center border border-white/10 text-studio-400">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <span>{{ $paket->foto ?? 'MAX 5 ORG' }}</span>
                    </li>
                </ul>
            </div>

            <div class="relative z-10 pt-8 border-t border-white/10">
                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-[0.2em] mb-2">Total Harga</p>
                <p class="text-3xl md:text-4xl font-black font-heading text-studio-400">
                    Rp {{ number_format($paket->harga, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Form Section (Right) -->
        <div class="w-full md:w-[60%] p-8 md:p-12">
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-heading font-black text-dark mb-2">Formulir Reservasi</h2>
                <p class="text-xs md:text-sm text-gray-500">Lengkapi data di bawah ini untuk mengonfirmasi jadwal pemotretan Anda.</p>
            </div>

            @if($errors->any())
                <div class="bg-rose-50 border border-rose-100 text-rose-600 p-4 rounded-2xl mb-8 text-xs font-medium flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation mt-0.5 text-lg"></i>
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/booking/simpan" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="paket" value="{{ $paket->nama_paket }}">
                <input type="hidden" name="total_pembayaran" value="{{ $paket->harga }}">

                <div class="space-y-5">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xs font-bold text-dark uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <input type="text" name="nama_pelanggan" class="w-full pl-11 p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-dark font-medium focus:bg-white focus:ring-2 focus:ring-studio-200 focus:border-studio-400 transition-all outline-none" placeholder="Masukkan nama lengkap Anda..." value="{{ old('nama_pelanggan') }}" required>
                        </div>
                    </div>
                    
                    <!-- WhatsApp -->
                    <div>
                        <label class="block text-xs font-bold text-dark uppercase tracking-wider mb-2">Nomor WhatsApp Aktif</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <input type="number" name="no_hp" class="w-full pl-11 p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-dark font-medium focus:bg-white focus:ring-2 focus:ring-studio-200 focus:border-studio-400 transition-all outline-none" placeholder="Contoh: 08123456789" value="{{ old('no_hp') }}" required>
                        </div>
                    </div>

                    <!-- Waktu -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-dark uppercase tracking-wider mb-2">Tanggal Booking</label>
                            <input type="date" name="tanggal_booking" class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-dark font-medium focus:bg-white focus:ring-2 focus:ring-studio-200 focus:border-studio-400 transition-all outline-none" value="{{ old('tanggal_booking') }}" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-dark uppercase tracking-wider mb-2">Pilih Jam</label>
                            <input type="time" name="jam" class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-dark font-medium focus:bg-white focus:ring-2 focus:ring-studio-200 focus:border-studio-400 transition-all outline-none" value="{{ old('jam') }}" required>
                        </div>
                    </div>

                    <!-- Pembayaran -->
                    <div>
                        <label class="block text-xs font-bold text-dark uppercase tracking-wider mb-2">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="pilihMetode" class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-dark font-medium focus:bg-white focus:ring-2 focus:ring-studio-200 focus:border-studio-400 transition-all outline-none cursor-pointer appearance-none" required onchange="ubahInstruksiPembayaran()">
                            <option value="" disabled selected>-- Pilih Metode --</option>
                            <option value="Transfer E-Wallet (DANA)">Transfer E-Wallet (DANA)</option>
                            <option value="Bayar di Tempat (CASH / COD)">Bayar di Tempat (CASH / COD)</option>
                        </select>
                    </div>

                    <!-- Instruksi Dana -->
                    <div id="instruksiDana" class="hidden bg-dark text-white rounded-2xl p-5 md:p-6 mt-4 relative overflow-hidden transform transition-all duration-300">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
                        <div class="relative z-10">
                            <h4 class="font-heading font-bold text-sm mb-2 flex items-center gap-2"><i class="fa-solid fa-wallet text-blue-400"></i> Transfer DANA</h4>
                            <p class="text-xs text-gray-400 mb-4">Silakan transfer sebesar <b class="text-white">Rp Rp {{ number_format($paket->harga, 0, ',', '.') }}</b> ke nomor berikut:</p>
                            
                            <div class="bg-white/10 backdrop-blur-md p-4 rounded-xl border border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                                <span class="font-heading font-black text-white tracking-[0.2em] text-lg md:text-xl">0812-3456-7890</span>
                                <span class="text-[10px] bg-blue-500/20 text-blue-300 border border-blue-500/30 px-3 py-1.5 rounded-full font-bold uppercase tracking-wider text-center">A.N. Graphic Studio</span>
                            </div>
                            
                            <p class="text-[10px] text-gray-400 leading-relaxed border-t border-white/10 pt-3"><i class="fa-solid fa-circle-info mr-1"></i> Setelah menekan tombol ajukan, unggah bukti transfer di halaman Riwayat Pesanan agar pesanan dikonfirmasi.</p>
                        </div>
                    </div>

                    <!-- Instruksi Cash -->
                    <div id="instruksiCash" class="hidden bg-studio-50 border border-studio-200 rounded-2xl p-5 md:p-6 mt-4 transition-all duration-300">
                        <h4 class="font-heading font-bold text-studio-900 text-sm mb-2 flex items-center gap-2"><i class="fa-solid fa-money-bill-wave text-studio-500"></i> Pembayaran Tunai (CASH)</h4>
                        <p class="text-xs text-studio-800 leading-relaxed">Anda memilih pembayaran di tempat. Silakan bayar sebesar <b class="text-dark">Rp Rp {{ number_format($paket->harga, 0, ',', '.') }}</b> langsung kepada kasir di studio kami saat hari pemotretan.</p>
                    </div>
                </div>

                <div class="pt-8 mt-8 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="w-full md:w-auto px-8 py-4 bg-dark hover:bg-studio-400 text-white hover:text-dark font-bold rounded-xl transition-colors shadow-lg flex items-center justify-center gap-3 text-sm uppercase tracking-wider group">
                        Konfirmasi Pesanan <i class="fa-solid fa-check text-lg group-hover:scale-125 transition-transform"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function ubahInstruksiPembayaran() {
        const pilihan = document.getElementById('pilihMetode').value;
        const wadahDana = document.getElementById('instruksiDana');
        const wadahCash = document.getElementById('instruksiCash');

        wadahDana.classList.add('hidden');
        wadahDana.classList.remove('animate-[fadeIn_0.3s_ease-out]');
        wadahCash.classList.add('hidden');
        wadahCash.classList.remove('animate-[fadeIn_0.3s_ease-out]');

        if (pilihan === 'Transfer E-Wallet (DANA)') {
            wadahDana.classList.remove('hidden');
            wadahDana.classList.add('animate-[fadeIn_0.3s_ease-out]');
        } else if (pilihan === 'Bayar di Tempat (CASH / COD)') {
            wadahCash.classList.remove('hidden');
            wadahCash.classList.add('animate-[fadeIn_0.3s_ease-out]');
        }
    }
</script>
@endpush