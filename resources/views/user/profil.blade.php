@extends('layouts.user')

@section('title', 'Profil Saya - Graphic Photostudio')

@section('content')
    <div class="p-4 max-w-[700px] mx-auto space-y-6 mt-8 relative z-10">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-black text-gray-800 flex items-center justify-center gap-2">
                <i class="fa-regular fa-id-badge text-[#C1BA8A]"></i> Profil Saya
            </h1>
            <p class="text-xs text-gray-400 mt-1">Kelola informasi akun Anda</p>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl text-xs flex items-center space-x-2 mb-6">
                <i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-xs mb-6">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kolom Kiri: Foto Profil -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center relative overflow-hidden h-fit md:col-span-1">
                <div class="absolute top-0 left-0 w-full h-24 bg-[#C1BA8A]/20"></div>
                
                <div class="w-32 h-32 bg-white border-4 border-white rounded-full mx-auto flex items-center justify-center text-5xl text-gray-300 shadow-md relative z-10 mb-4 overflow-hidden group">
                    @if(auth()->user()->foto_profil)
                        <img id="previewImage" src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                    @else
                        <img id="previewImage" src="" class="w-full h-full object-cover hidden">
                        <i id="defaultIcon" class="fa-solid fa-circle-user w-full h-full text-gray-300"></i>
                    @endif
                </div>
                
                <h2 class="text-xl font-black text-gray-800 text-center">{{ auth()->user()->name ?? 'Nama Pengguna' }}</h2>
                <p class="text-gray-500 font-medium text-xs mt-1 text-center">{{ auth()->user()->email ?? 'email@contoh.com' }}</p>
                
                <span class="inline-block mt-4 px-4 py-1.5 bg-amber-50 text-[#C1BA8A] rounded-full text-[10px] font-black tracking-wider uppercase border border-amber-100 text-center">
                    <i class="fa-solid fa-crown mr-1"></i> Pelanggan Studio
                </span>

                @if(auth()->user()->foto_profil)
                <form action="/profil/hapus-foto" method="POST" class="mt-6 w-full" id="hapusFotoForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmHapusFoto()" class="w-full text-center px-4 py-2 text-xs font-bold text-rose-500 border border-rose-200 rounded-xl hover:bg-rose-50 hover:text-rose-600 transition flex justify-center items-center gap-2 cursor-pointer">
                        <i class="fa-regular fa-trash-can"></i> Hapus Foto
                    </button>
                </form>
                @endif
            </div>

            <!-- Kolom Kanan: Form Edit Profil -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 md:col-span-2">
                <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-3 mb-6 text-sm uppercase tracking-wide">
                    <i class="fa-solid fa-user-pen text-[#C1BA8A] mr-2"></i> Edit Data Profil
                </h3>
                
                <form action="/profil/update" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Ubah Foto Profil (Opsional)</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="foto_profil" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-400 mb-2 group-hover:text-[#C1BA8A] transition"></i>
                                    <p class="text-xs text-gray-500"><span class="font-bold">Klik untuk unggah</span> atau seret file</p>
                                    <p class="text-[10px] text-gray-400 mt-1">PNG, JPG, JPEG (Maks. 2MB)</p>
                                </div>
                                <input id="foto_profil" name="foto_profil" type="file" class="hidden" accept="image/png, image/jpeg, image/jpg" onchange="previewFile(this)" />
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C1BA8A]/20 focus:border-[#C1BA8A] transition font-medium text-gray-800" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-2">No. Handphone</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C1BA8A]/20 focus:border-[#C1BA8A] transition font-medium text-gray-800" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-2">Alamat Email (Tidak dapat diubah)</label>
                        <input type="email" value="{{ auth()->user()->email }}" class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-sm text-gray-500 cursor-not-allowed font-medium" disabled>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="bg-[#C1BA8A] hover:bg-[#A69E65] text-white px-6 py-3 rounded-xl shadow-md font-bold text-sm transition flex items-center space-x-2 cursor-pointer">
                            <i class="fa-solid fa-floppy-disk"></i> <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        // Script untuk Live Preview Foto Profil
        function previewFile(input) {
            var file = input.files[0];
            if(file){
                var reader = new FileReader();
                reader.onload = function(){
                    document.getElementById('previewImage').src = reader.result;
                    document.getElementById('previewImage').classList.remove('hidden');
                    if(document.getElementById('defaultIcon')) {
                        document.getElementById('defaultIcon').classList.add('hidden');
                    }
                }
                reader.readAsDataURL(file);
            }
        }

        // Script untuk konfirmasi hapus foto
        function confirmHapusFoto() {
            if(confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
                document.getElementById('hapusFotoForm').submit();
            }
        }
    </script>
@endpush