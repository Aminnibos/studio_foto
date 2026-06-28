<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Akun - Graphic Photostudio</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans flex flex-col min-h-screen">

    <div class="w-full h-16 bg-[#C1BA8A]"></div>

    <div class="flex-1 flex flex-col items-center justify-center p-4">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Pilih Akun</h1>
            <p class="text-xs text-gray-400 mt-1">Pilih jenis akun untuk melanjutkan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-2xl px-4">
            
            <a href="/login/admin" class="bg-white p-8 rounded-xl border border-gray-200 shadow-2xs flex flex-col items-center text-center group hover:border-[#C1BA8A] transition duration-200">
                <div class="w-20 h-20 bg-[#B5A46D] text-white rounded-full flex items-center justify-center text-3xl group-hover:scale-105 transition duration-200 shadow-sm">
                    <i class="fa-solid fa-user"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mt-4">Admin</h3>
                <p class="text-xs text-gray-400 mt-1 leading-relaxed">Akses untuk admin<br>studio foto</p>
            </a>

            <a href="/login/customer" class="bg-white p-8 rounded-xl border border-gray-200 shadow-2xs flex flex-col items-center text-center group hover:border-[#C1BA8A] transition duration-200">
                <div class="w-20 h-20 bg-[#B5A46D] text-white rounded-full flex items-center justify-center text-3xl group-hover:scale-105 transition duration-200 shadow-sm">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mt-4">Customer</h3>
                <p class="text-xs text-gray-400 mt-1 leading-relaxed">Akses untuk pelanggan<br>studio foto</p>
            </a>

        </div>

        <a href="/dashboard-studio" class="mt-8 px-8 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium text-xs rounded-lg shadow-2xs transition duration-200">
            Kembali
        </a>
    </div>

</body>
</html>