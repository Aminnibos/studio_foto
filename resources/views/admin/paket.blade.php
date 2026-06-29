@extends('layouts.admin')
@section('title', 'Mengelola Paket - Admin')
@section('content')
    <div class="p-4 md:p-8 max-w-[1400px] mx-auto space-y-6 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center space-x-2">
                    <span class="w-7 h-7 bg-amber-100 rounded-lg text-[#A69E65] flex items-center justify-center text-sm"><i class="fa-solid fa-box"></i></span>
                    <span>Mengelola Paket</span>
                </h1>
                <p class="text-xs text-gray-400 mt-1">Atur katalog visual penawaran dan paket studio foto Anda</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-2 md:gap-3">
                <button onclick="openGaleriModal()" class="bg-white text-blue-500 border border-blue-200 px-4 py-2 rounded-lg shadow-sm hover:bg-blue-50 transition flex items-center space-x-2 font-medium text-sm cursor-pointer w-full md:w-auto justify-center md:justify-start">
                    <i class="fa-regular fa-images"></i> <span>Tambah Foto Galeri</span>
                </button>

                <button onclick="openLatarModal()" class="bg-white text-[#C1BA8A] border border-[#C1BA8A] px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 transition flex items-center space-x-2 font-medium text-sm cursor-pointer w-full md:w-auto justify-center md:justify-start">
                    <i class="fa-solid fa-images"></i> <span>Tambah Latar Belakang</span>
                </button>
                <button onclick="openAddModal()" class="bg-[#C1BA8A] text-white px-4 py-2 rounded-lg shadow hover:bg-[#A69E65] transition flex items-center space-x-2 font-medium text-sm cursor-pointer w-full md:w-auto justify-center md:justify-start">
                    <i class="fa-solid fa-plus"></i> <span>Tambah Paket</span>
                </button>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl text-xs flex items-center space-x-2">
            <i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-xs mb-6">
            <div class="flex items-center space-x-2 font-bold mb-2">
                <i class="fa-solid fa-triangle-exclamation"></i><span>Proses Gagal. Terdapat kesalahan:</span>
            </div>
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <h2 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-100 pb-2">
                <i class="fa-solid fa-layer-group text-[#C1BA8A]"></i> Wadah Latar Belakang (Tema Tersedia)
            </h2>
            
            @if($daftarLatar->isEmpty())
                <p class="text-xs text-gray-400 italic">Belum ada latar belakang. Silakan tambah latar belakang terlebih dahulu agar bisa memasukkan paket.</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($daftarLatar as $latar)
                        <div class="rounded-lg overflow-hidden border border-gray-200 relative group h-24 shadow-sm hover:shadow transition">
                            <img src="{{ asset('storage/' . $latar->gambar) }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center p-2">
                                <span class="text-white font-bold text-[10px] text-center uppercase tracking-wider drop-shadow-md">
                                    {{ $latar->nama_latar }}
                                </span>
                            </div>
                            
                            <div class="absolute top-2 right-2 flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <button onclick="openEditLatarModal({{ json_encode($latar) }})" class="bg-blue-500 text-white w-6 h-6 rounded flex items-center justify-center hover:bg-blue-600 transition cursor-pointer shadow" title="Edit Tema">
                                    <i class="fa-solid fa-pen text-[10px]"></i>
                                </button>
                                <form action="/admin/latar-belakang/{{ $latar->id }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus Tema {{ $latar->nama_latar }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white w-6 h-6 rounded flex items-center justify-center hover:bg-red-600 transition cursor-pointer shadow" title="Hapus Tema">
                                        <i class="fa-solid fa-trash text-[10px]"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="space-y-6 pt-4">
            @if($daftarPaket->isEmpty())
                <div class="bg-white rounded-xl border border-gray-200 p-12 text-center text-gray-400 text-xs">
                    Tidak ada katalog paket ditemukan.
                </div>
            @else
                
                @foreach($daftarLatar as $latar)
                    @php
                        $paketDiLatarIni = $daftarPaket->where('kategori', $latar->nama_latar);
                    @endphp

                    @if($paketDiLatarIni->isNotEmpty())
                        <div class="bg-gray-100/50 p-6 rounded-xl border border-gray-200">
                            <h3 class="font-black text-[#A69E65] uppercase tracking-widest text-sm mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-folder-open"></i> PAKET TEMA: {{ $latar->nama_latar }}
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                @foreach($paketDiLatarIni as $paket)
                                <div class="bg-white rounded-xl shadow-xs border border-gray-200 overflow-hidden flex flex-col group relative transition hover:shadow-md">
                                    <div class="bg-[#C1BA8A] text-white font-bold text-center py-2 text-xs uppercase tracking-wider">
                                        {{ $paket->nama_paket }}
                                    </div>

                                    <div class="h-80 bg-gray-50 overflow-hidden relative border-b border-gray-100">
                                        @if($paket->gambar)
                                            <img src="{{ asset('storage/' . $paket->gambar) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="fa-solid fa-image text-2xl"></i></div>
                                        @endif
                                        <span class="absolute bottom-2 left-2 bg-black/60 backdrop-blur-xs text-white text-[9px] font-bold px-2 py-0.5 rounded">
                                            {{ $paket->kategori }}
                                        </span>
                                    </div>

                                    <div class="p-4 space-y-2 flex-1 flex flex-col justify-between bg-[#FFFDF6]">
                                        <div class="space-y-1.5 border-b border-gray-100 pb-3">
                                            <div class="flex items-center space-x-2 text-gray-500 text-[11px]">
                                                <span class="w-4 text-center text-[#A69E65]"><i class="fa-solid fa-camera-retro"></i></span>
                                                <span>50x Shoot</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-gray-500 text-[11px]">
                                                <span class="w-4 text-center text-[#A69E65]"><i class="fa-regular fa-clock"></i></span>
                                                <span>Durasi: {{ $paket->durasi }}</span>
                                            </div>
                                            <div class="flex items-center space-x-2 text-gray-500 text-[11px]">
                                                <span class="w-4 text-center text-[#A69E65]"><i class="fa-solid fa-users"></i></span>
                                                <span>Hasil: {{ $paket->foto ?? '15 Lembar' }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="pt-2 flex justify-between items-center">
                                            <span class="text-[#A69E65] font-black text-sm">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                                            <div class="flex space-x-1">
                                                <button onclick="openEditModal({{ json_encode($paket) }})" class="text-blue-500 hover:text-blue-700 transition cursor-pointer p-1.5 bg-blue-50 hover:bg-blue-100 rounded">
                                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                </button>
                                                <form action="/admin/paket/{{ $paket->id }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus paket {{ $paket->nama_paket }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 transition cursor-pointer p-1.5 bg-red-50 hover:bg-red-100 rounded">
                                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                @php
                    $kategoriValid = $daftarLatar->pluck('nama_latar')->toArray();
                    $paketTanpaLatar = $daftarPaket->whereNotIn('kategori', $kategoriValid);
                @endphp

                @if($paketTanpaLatar->isNotEmpty())
                    <div class="bg-red-50 p-6 rounded-xl border border-red-200 mt-6">
                        <h3 class="font-black text-red-500 uppercase tracking-widest text-sm mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation"></i> PAKET TANPA TEMA (Tema Terhapus / Belum Diatur)
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($paketTanpaLatar as $paket)
                                <div class="bg-white rounded-xl shadow-xs border border-gray-200 overflow-hidden flex flex-col group relative transition hover:shadow-md">
                                    <div class="bg-gray-400 text-white font-bold text-center py-2 text-xs uppercase tracking-wider">{{ $paket->nama_paket }}</div>
                                    <div class="h-80 bg-gray-50 overflow-hidden relative border-b border-gray-100">
                                        @if($paket->gambar)
                                            <img src="{{ asset('storage/' . $paket->gambar) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300"><i class="fa-solid fa-image text-2xl"></i></div>
                                        @endif
                                        <span class="absolute bottom-2 left-2 bg-red-500/80 backdrop-blur-xs text-white text-[9px] font-bold px-2 py-0.5 rounded">{{ $paket->kategori }}</span>
                                    </div>
                                    <div class="p-4 space-y-2 flex-1 flex flex-col justify-between bg-white">
                                        <div class="pt-2 flex justify-between items-center">
                                            <span class="text-gray-500 font-black text-sm">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                                            <div class="flex space-x-1">
                                                <button onclick="openEditModal({{ json_encode($paket) }})" class="text-blue-500 hover:text-blue-700 transition cursor-pointer p-1.5 bg-blue-50 hover:bg-blue-100 rounded">
                                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                </button>
                                                <form action="/admin/paket/{{ $paket->id }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus paket {{ $paket->nama_paket }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 transition cursor-pointer p-1.5 bg-red-50 hover:bg-red-100 rounded">
                                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <div class="mt-12 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2 border-b border-gray-100 pb-3">
                <i class="fa-regular fa-images text-blue-500"></i> Kumpulan Foto Galeri (Tampilan User)
            </h2>
            
            @if(!isset($daftarGaleri) || $daftarGaleri->isEmpty())
                <p class="text-xs text-gray-400 italic text-center py-8">Belum ada foto galeri yang diunggah.</p>
            @else
                @php
                    $galeriGrouped = $daftarGaleri->groupBy('kategori');
                @endphp
                
                @foreach($galeriGrouped as $kategori => $fotos)
                    <div class="mb-8">
                        <h3 class="font-black text-gray-600 uppercase tracking-widest text-xs mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-folder-open text-[#A69E65]"></i> TEMA GALERI: {{ $kategori }}
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach($fotos as $foto)
                                <div class="rounded-lg overflow-hidden border border-gray-200 relative group h-40 shadow-sm hover:shadow transition">
                                    <img src="{{ asset('storage/' . $foto->foto) }}" class="w-full h-full object-cover">
                                    
                                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <form action="/admin/galeri/{{ $foto->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto galeri ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500/90 text-white w-7 h-7 rounded flex items-center justify-center hover:bg-red-600 transition cursor-pointer shadow-lg" title="Hapus Foto Galeri">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>

    <div id="modalPaket" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-md rounded-xl shadow-xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 flex items-center space-x-2">
                    <i class="fa-solid fa-box text-[#C1BA8A]"></i>
                    <span id="modalTitle">Tambah Paket Baru</span>
                </h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form id="formPaket" action="/admin/paket" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div id="methodContainer"></div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Paket</label>
                    <input type="text" name="nama_paket" id="inputNama" placeholder="Misal: Paket A, Paket B" class="w-full p-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#C1BA8A]/20 focus:border-[#C1BA8A]" required>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Pilih Latar Belakang (Kategori)</label>
                    <select name="kategori" id="inputKategori" class="w-full p-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-[#C1BA8A]/20 focus:border-[#C1BA8A]" required>
                        <option value="" disabled selected>-- Pilih Latar Belakang --</option>
                        @if(isset($daftarLatar))
                            @foreach($daftarLatar as $latar)
                                <option value="{{ $latar->nama_latar }}">{{ $latar->nama_latar }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Durasi Sesi</label>
                        <input type="text" name="durasi" id="inputDurasi" placeholder="Misal: 15 Menit" class="w-full p-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#C1BA8A]/20 focus:border-[#C1BA8A]" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jumlah Foto</label>
                        <input type="text" name="foto" id="inputFoto" placeholder="Misal: MAX. 5 person" class="w-full p-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#C1BA8A]/20 focus:border-[#C1BA8A]" required>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Harga (Rupiah)</label>
                    <input type="number" name="harga" id="inputHarga" placeholder="Contoh: 40000" class="w-full p-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#C1BA8A]/20 focus:border-[#C1BA8A]" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Sampul Gambar Paket</label>
                    <p class="text-[10px] text-amber-600 mb-1" id="imageWarning"></p>
                    <input type="file" name="gambar" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 file:cursor-pointer hover:file:bg-gray-200 border border-gray-200 p-1.5 rounded-lg">
                </div>
                <div class="pt-4 border-t border-gray-100 flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 cursor-pointer">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-[#C1BA8A] hover:bg-[#A69E65] text-white rounded-lg text-sm font-medium shadow-sm cursor-pointer">Simpan Katalog</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalLatar" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-sm rounded-xl shadow-xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 flex items-center space-x-2">
                    <i class="fa-solid fa-images text-[#C1BA8A]"></i>
                    <span id="modalLatarTitle">Tambah Latar Belakang</span>
                </h3>
                <button onclick="closeLatarModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form id="formLatar" action="/admin/latar-belakang" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div id="methodLatarContainer"></div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Tema / Latar</label>
                    <input type="text" name="nama_latar" id="inputNamaLatar" placeholder="Misal: PHOOTOBOX, Prewedding" class="w-full p-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-[#C1BA8A]/20 focus:border-[#C1BA8A]" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Foto Sampul Latar</label>
                    <p class="text-[10px] text-amber-600 mb-1" id="imageLatarWarning"></p>
                    <input type="file" name="gambar" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 file:cursor-pointer hover:file:bg-gray-200 border border-gray-200 p-1.5 rounded-lg">
                </div>
                <div class="pt-4 border-t border-gray-100 flex justify-end space-x-2">
                    <button type="button" onclick="closeLatarModal()" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 cursor-pointer">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-[#C1BA8A] hover:bg-[#A69E65] text-white rounded-lg text-sm font-medium shadow-sm cursor-pointer">Simpan Latar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalGaleri" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-sm rounded-xl shadow-xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <div class="p-4 bg-blue-50 border-b border-blue-100 flex justify-between items-center">
                <h3 class="font-bold text-blue-800 flex items-center space-x-2">
                    <i class="fa-regular fa-images text-blue-500"></i>
                    <span>Tambah Foto Galeri User</span>
                </h3>
                <button onclick="closeGaleriModal()" class="text-blue-400 hover:text-blue-600 cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="/admin/galeri" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tema Galeri</label>
                    <input type="text" name="kategori" id="inputKategoriGaleri" list="galeri_list" placeholder="Ketik tema baru atau klik panah v" class="w-full p-2.5 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-blue-400" required>
                    
                    <datalist id="galeri_list">
                        @if(isset($daftarLatar))
                            @foreach($daftarLatar as $latar)
                                <option value="{{ $latar->nama_latar }}">
                            @endforeach
                        @endif
                        @if(isset($daftarGaleri))
                            @foreach($daftarGaleri->unique('kategori') as $gal)
                                <option value="{{ $gal->kategori }}">
                            @endforeach
                        @endif
                    </datalist>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Upload Foto</label>
                    <input type="file" name="foto[]" multiple accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 file:cursor-pointer hover:file:bg-blue-100 border border-gray-200 p-1.5 rounded-lg" required>
                    <p class="text-[10px] text-gray-400 mt-1">*Bisa pilih lebih dari 1 foto sekaligus.</p>
                </div>

                <div class="pt-4 flex justify-end space-x-2 border-t border-gray-100">
                    <button type="button" onclick="closeGaleriModal()" class="px-4 py-2 border rounded-lg text-sm font-medium text-gray-600 cursor-pointer">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium cursor-pointer">Upload ke Galeri</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // JS PAKET
        const modal = document.getElementById('modalPaket');
        const form = document.getElementById('formPaket');
        const modalTitle = document.getElementById('modalTitle');
        const methodContainer = document.getElementById('methodContainer');
        const imageWarning = document.getElementById('imageWarning');

        function openAddModal() {
            modalTitle.innerText = "Tambah Paket Baru";
            form.action = "/admin/paket";
            methodContainer.innerHTML = ""; 
            imageWarning.innerText = "";
            document.getElementById('inputNama').value = "";
            document.getElementById('inputKategori').value = "";
            document.getElementById('inputDurasi').value = "";
            document.getElementById('inputFoto').value = "";
            document.getElementById('inputHarga').value = "";
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function openEditModal(paket) {
            modalTitle.innerText = "Edit Rincian Paket";
            form.action = "/admin/paket/" + paket.id;
            methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            imageWarning.innerText = "*Kosongkan jika tidak ingin mengganti gambar sampul";
            document.getElementById('inputNama').value = paket.nama_paket;
            document.getElementById('inputKategori').value = paket.kategori;
            document.getElementById('inputDurasi').value = paket.durasi;
            document.getElementById('inputFoto').value = paket.foto ?? "";
            document.getElementById('inputHarga').value = paket.harga;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // JS LATAR BELAKANG
        const modalLatar = document.getElementById('modalLatar');
        const formLatar = document.getElementById('formLatar');
        const modalLatarTitle = document.getElementById('modalLatarTitle');
        const methodLatarContainer = document.getElementById('methodLatarContainer');
        const imageLatarWarning = document.getElementById('imageLatarWarning');
        const inputNamaLatar = document.getElementById('inputNamaLatar');
        
        function openLatarModal() {
            modalLatarTitle.innerText = "Tambah Latar Belakang";
            formLatar.action = "/admin/latar-belakang";
            methodLatarContainer.innerHTML = "";
            imageLatarWarning.innerText = "";
            inputNamaLatar.value = "";
            modalLatar.classList.remove('hidden');
            modalLatar.classList.add('flex');
        }

        function openEditLatarModal(latar) {
            modalLatarTitle.innerText = "Edit Latar Belakang";
            formLatar.action = "/admin/latar-belakang/" + latar.id;
            methodLatarContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            imageLatarWarning.innerText = "*Kosongkan jika tidak ingin mengganti foto latar";
            inputNamaLatar.value = latar.nama_latar;
            modalLatar.classList.remove('hidden');
            modalLatar.classList.add('flex');
        }

        function closeLatarModal() {
            modalLatar.classList.remove('flex');
            modalLatar.classList.add('hidden');
        }

        // JS GALERI
        const modalGaleri = document.getElementById('modalGaleri');
        function openGaleriModal() {
            modalGaleri.classList.remove('hidden');
            modalGaleri.classList.add('flex');
        }
        function closeGaleriModal() {
            modalGaleri.classList.remove('flex');
            modalGaleri.classList.add('hidden');
            
            // Mengosongkan input tema saat modal ditutup
            document.getElementById('inputKategoriGaleri').value = "";
        }
    </script>
@endpush