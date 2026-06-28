<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login - Graphic Photostudio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#FFFCF5] font-sans flex h-screen overflow-hidden">
    
    <div class="relative hidden md:flex w-1/2 bg-black items-center justify-center">
        <img src="{{ asset('asset/images/kamera.jpg') }}" alt="Camera Aesthetic" class="absolute inset-0 w-full h-full object-cover opacity-60">
        
        <div class="relative z-10 p-12 w-full text-left">
            <div class="w-12 h-1 bg-[#C1BA8A] mb-4"></div>
            <h1 class="text-white text-5xl font-serif font-bold italic mb-4 drop-shadow-md">graphic.photostudio</h1>
            <p class="text-gray-200 text-sm max-w-sm leading-relaxed drop-shadow-md">Abadikan momen terbaikmu dengan kualitas studio profesional dan pelayanan yang memuaskan.</p>
        </div>
    </div>

    <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-8 bg-[#FFFCF5] relative">
        
        <a href="/pilih-akun" class="absolute top-8 left-8 md:left-12 text-gray-400 hover:text-[#C1BA8A] transition flex items-center gap-2 text-xs font-bold uppercase tracking-wider">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <div class="w-full max-w-md space-y-8 mt-6 md:mt-0">
            
            <div class="text-center md:text-left flex flex-col items-center md:items-start">
                <div class="text-4xl text-[#C1BA8A] mb-4 md:hidden"><i class="fa-solid fa-camera-retro"></i></div>
                <h2 class="text-3xl font-black text-[#1F2937] tracking-tight">Customer Login</h2>
                <p class="text-[11px] text-gray-500 mt-2">Masuk ke akun pelanggan</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-3 rounded-lg text-xs font-medium flex items-center space-x-2">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-600 p-3 rounded-lg text-xs font-medium flex items-center space-x-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-5">
                @csrf
                
                <input type="hidden" name="role" value="customer">
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Email / No. Handphone</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-regular fa-user text-gray-400 text-sm"></i>
                        </div>
                        <input type="text" name="email" class="w-full pl-9 pr-4 py-3 bg-blue-50/40 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#C1BA8A]/50 focus:border-[#C1BA8A] transition-colors" placeholder="Email / No. Handphone" required>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400 text-sm"></i>
                        </div>
                        <input type="password" name="password" id="password" class="w-full pl-9 pr-10 py-3 bg-blue-50/40 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#C1BA8A]/50 focus:border-[#C1BA8A] transition-colors" placeholder="••••••••" required>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 cursor-pointer hover:text-[#C1BA8A] transition">
                            <i class="fa-regular fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-2">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-[#C1BA8A] focus:ring-[#C1BA8A] w-3.5 h-3.5 border-gray-300">
                        <span class="text-[10px] text-gray-500 font-medium">Ingat Saya</span>
                    </label>
                    <a href="#" class="text-[10px] text-[#A69E65] font-bold hover:underline">Lupa password?</a>
                </div>

                <button type="submit" class="w-full bg-[#C1BA8A] hover:bg-[#A69E65] text-white py-3 rounded-lg transition-colors duration-300 font-bold text-sm shadow-md shadow-[#C1BA8A]/20 flex justify-center items-center gap-2 cursor-pointer mt-2">
                    <span>Login</span>
                    <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                </button>
            </form>

            <div class="text-center mt-8">
                <p class="text-[10px] text-gray-500 font-medium">Belum punya akun? <a href="/register" class="text-[#A69E65] font-bold hover:underline">Buat akun sekarang</a></p>
            </div>

        </div>
    </div>
</body>
</html>