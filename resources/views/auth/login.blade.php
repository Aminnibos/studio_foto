<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Graphic Photostudio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#FFFDF6] font-sans text-gray-800 antialiased">

    <div class="min-h-screen flex">
        
        <div class="hidden lg:block lg:w-1/2 bg-cover bg-center relative" 
             style="background-image: url('{{ asset('asset/images/kamera.jpg') }}');">
            <div class="absolute inset-0 bg-black/50 flex flex-col justify-center px-16">
                <div class="text-white space-y-4">
                    <div class="w-16 h-1 bg-[#C1BA8A] rounded-full mb-6"></div>
                    <h1 class="text-5xl font-serif italic font-bold tracking-wide">graphic.photostudio</h1>
                    <p class="text-lg text-gray-200 max-w-md">Abadikan momen terbaikmu dengan kualitas studio profesional dan pelayanan yang memuaskan.</p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-[#FFFDF6]">
            <div class="w-full max-w-md space-y-8">
                
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 text-[#A69E65] mb-4 lg:hidden">
                        <i class="fa-solid fa-camera-retro text-xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-gray-800">Selamat Datang!</h2>
                    <p class="text-sm text-gray-500 mt-2">Silakan masuk ke akun Anda untuk melanjutkan</p>
                </div>

                @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-600 p-3 rounded-xl text-xs font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i> Email atau password salah!
                </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa-regular fa-envelope"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: pelanggan@gmail.com" class="w-full pl-10 pr-4 py-3 bg-white border border-[#C1BA8A] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C1BA8A]/50 transition" required autofocus>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider">Kata Sandi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" name="password" placeholder="Masukkan kata sandi" class="w-full pl-10 pr-4 py-3 bg-white border border-[#C1BA8A] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C1BA8A]/50 transition" required>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#C1BA8A] focus:ring-[#C1BA8A]">
                            <span class="font-medium text-gray-600">Ingat Saya</span>
                        </label>
                        <a href="#" class="font-bold text-[#A69E65] hover:text-amber-700 transition">Lupa Sandi?</a>
                    </div>

                    <button type="submit" class="w-full py-3 bg-[#C1BA8A] hover:bg-[#A69E65] text-white font-bold rounded-xl transition shadow-md hover:shadow-lg flex items-center justify-center gap-2 cursor-pointer">
                        <span>Masuk Sekarang</span> <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    </button>
                </form>

                <div class="relative flex py-4 items-center">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="flex-shrink-0 mx-4 text-gray-400 text-xs font-medium">ATAU</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <a href="{{ route('google.login') }}" class="w-full py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl transition shadow-sm hover:shadow-md hover:bg-gray-50 flex items-center justify-center gap-3 cursor-pointer">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
                    <span>Masuk dengan Google</span>
                </a>

                <p class="text-center text-xs text-gray-500 font-medium pt-4">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-[#A69E65] hover:underline ml-1">Daftar di sini</a>
                </p>

            </div>
        </div>
        
    </div>

</body>
</html>