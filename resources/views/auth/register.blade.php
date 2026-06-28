<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun - Graphic Photostudio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#F8F9FA] font-sans flex flex-col min-h-screen">

    <div class="w-full h-16 bg-[#C1BA8A]"></div>

    <div class="flex-1 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-xl border border-gray-100 shadow-sm p-8 relative">
            
            <a href="/login" class="absolute top-6 left-6 text-gray-700 hover:text-gray-900 transition">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>

            <div class="flex flex-col items-center text-center space-y-3 mb-6">
                <div class="text-4xl text-[#B5A46D]"><i class="fa-solid fa-camera-retro"></i></div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Buat Akun</h2>
                    <p class="text-[11px] text-gray-400 mt-0.5">Lengkapi data untuk membuat akun baru</p>
                </div>
            </div>

            <form action="/register" method="POST" class="space-y-3 text-xs">
                @csrf
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <input type="text" name="name" placeholder="Nama Lengkap" class="w-full pl-9 pr-3 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-[#C1BA8A]" required>
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input type="email" name="email" placeholder="Email" class="w-full pl-9 pr-3 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-[#C1BA8A]" required>
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </span>
                    <input type="text" name="no_hp" placeholder="No. Handphone" class="w-full pl-9 pr-3 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-[#C1BA8A]" required>
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" name="password" placeholder="Password" class="w-full pl-9 pr-10 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-[#C1BA8A]" required>
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="w-full pl-9 pr-10 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-[#C1BA8A]" required>
                </div>

                <div class="pt-1">
                    <label class="flex items-start space-x-2 text-[10px] text-gray-500 leading-normal">
                        <input type="checkbox" class="accent-[#B5A46D] mt-0.5" required>
                        <span>Saya setuju dengan <span class="text-[#B5A46D] font-medium hover:underline cursor-pointer">Syarat & Ketentuan</span> dan <span class="text-[#B5A46D] font-medium hover:underline cursor-pointer">Kebijakan Privasi</span></span>
                    </label>
                </div>

                <button type="submit" class="w-full py-2.5 bg-[#B5A46D] hover:bg-[#A3925B] text-white font-bold rounded-lg shadow-2xs transition flex items-center justify-center space-x-2 cursor-pointer mt-2 text-xs">
                    <i class="fa-solid fa-user-plus"></i> <span>Buat Akun</span>
                </button>
            </form>

            <div class="relative flex py-3 items-center">
                <div class="flex-grow border-t border-gray-200"></div>
                <span class="flex-shrink mx-3 text-[10px] text-gray-400 uppercase font-semibold tracking-wider">atau</span>
                <div class="flex-grow border-t border-gray-200"></div>
            </div>

            <a href="/login" class="w-full py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold rounded-lg shadow-2xs transition flex items-center justify-center space-x-2 cursor-pointer text-xs no-underline">
                <i class="fa-regular fa-user"></i> <span>Sudah punya akun? <span class="text-[#B5A46D]">Login di sini</span></span>
            </a>
        </div>
    </div>

</body>
</html>