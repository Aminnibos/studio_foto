<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Statistik - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 font-sans pb-10">

    <div class="w-full bg-[#C1BA8A] p-4 flex justify-between items-center px-8 shadow-xs relative z-50">
        <div class="flex items-center space-x-2 text-white font-bold text-xl">
            <i class="fa-solid fa-camera-retro"></i>
            <span>graphic.photostudio</span>
        </div>
        <div class="flex items-center space-x-8 text-white/90 font-medium text-sm">
            <a href="/admin/dashboard" class="text-white border-b-2 border-white pb-1 font-bold">Dasboard</a>
            <a href="/admin/paket" class="hover:text-white transition">Mengelola paket</a>
            <a href="/admin/verifikasi-pembayaran" class="hover:text-white transition">Verifikasi pembayaran</a>
            <a href="/admin/laporan" class="hover:text-white transition">Laporan</a>
            
            <div class="relative inline-block text-left ml-2">
                <button onclick="toggleProfileMenu()" class="w-8 h-8 rounded-full bg-white hover:bg-gray-100 text-[#C1BA8A] flex items-center justify-center transition-all duration-300 shadow-sm cursor-pointer focus:outline-none ring-2 ring-white/50">
                    <i class="fa-solid fa-user-tie text-sm"></i>
                </button>

                <div id="dropdownProfil" class="hidden absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transform origin-top-right transition-all text-gray-800 z-50">
                    
                    <div class="p-5 bg-gray-50/50 border-b border-gray-100">
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-xl shadow-inner">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-sm font-black text-gray-800 truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                                <p class="text-[10px] font-medium text-gray-400 truncate">{{ auth()->user()->email ?? 'admin@studio.com' }}</p>
                            </div>
                        </div>
                        <span class="inline-block mt-1 px-2.5 py-1 bg-purple-50 text-purple-600 border border-purple-200 rounded text-[9px] font-bold uppercase tracking-wider">
                            <i class="fa-solid fa-crown mr-1"></i> Admin Studio
                        </span>
                    </div>

                    <div class="p-2">
                        <form action="{{ url('/logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" onclick="return confirm('Apakah Admin yakin ingin keluar dari sistem?')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition flex items-center gap-3 cursor-pointer group">
                                <i class="fa-solid fa-right-from-bracket group-hover:-translate-x-1 transition-transform"></i> 
                                Keluar (Logout)
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            </div>
    </div>

    <div class="p-8 max-w-[1400px] mx-auto space-y-8 relative z-10">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center space-x-2">
                <span class="w-7 h-7 bg-amber-100 rounded-lg text-[#A69E65] flex items-center justify-center text-sm"><i class="fa-solid fa-chart-pie"></i></span>
                <span>Dashboard Statistik</span>
            </h1>
            <p class="text-xs text-gray-400 mt-1">Ringkasan data dan perkembangan aktivitas studio foto</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-xl shadow-xs border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase">Total Booking</p>
                    <h3 class="text-xl font-bold text-gray-800 mt-0.5">{{ $statistik['total_booking'] }}</h3>
                    <span class="text-[10px] text-purple-500 font-medium"><i class="fa-solid fa-arrow-up"></i> +12% dari minggu lalu</span>
                </div>
                <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-purple-500 text-lg"><i class="fa-solid fa-calendar-days"></i></div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-xs border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase">Total Pendapatan</p>
                    <h3 class="text-xl font-bold text-gray-800 mt-0.5">Rp {{ number_format($statistik['pendapatan'], 0, ',', '.') }}</h3>
                    <span class="text-[10px] text-green-500 font-medium"><i class="fa-solid fa-arrow-up"></i> +18% dari minggu lalu</span>
                </div>
                <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-green-500 text-lg"><i class="fa-solid fa-wallet"></i></div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-xs border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase">Pembayaran Disetujui</p>
                    <h3 class="text-xl font-bold text-gray-800 mt-0.5">{{ $statistik['total_booking'] - $statistik['pembatalan'] - $statistik['pembayaran_menunggu'] }}</h3>
                    <span class="text-[10px] text-blue-500 font-medium"><i class="fa-solid fa-arrow-up"></i> +10% dari minggu lalu</span>
                </div>
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500 text-lg"><i class="fa-solid fa-circle-check"></i></div>
            </div>

            <a href="/admin/verifikasi-pembayaran" class="bg-white p-5 rounded-xl shadow-xs border border-gray-100 flex items-center justify-between hover:border-amber-200 transition">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase">Pembayaran Ditolak</p>
                    <h3 class="text-xl font-bold text-gray-800 mt-0.5">{{ $statistik['pembatalan'] }}</h3>
                    <span class="text-[10px] text-red-400 font-medium"><i class="fa-solid fa-arrow-down"></i> -25% dari minggu lalu</span>
                </div>
                <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-red-500 text-lg"><i class="fa-solid fa-circle-xmark"></i></div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-xs border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h4 class="text-sm font-bold text-gray-800">Graphic Pendapatan</h4>
                        <p id="teksPeriodeGrafik" class="text-[10px] text-gray-400">7 Hari Terakhir</p>
                    </div>
                    <div class="flex space-x-1 text-[10px]">
                        <button onclick="ubahGrafik('harian')" id="btn-harian" class="btn-filter px-3 py-1.5 bg-[#C1BA8A] text-white font-bold rounded shadow-xs cursor-pointer transition">Harian</button>
                        <button onclick="ubahGrafik('mingguan')" id="btn-mingguan" class="btn-filter px-3 py-1.5 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded cursor-pointer transition">Mingguan</button>
                        <button onclick="ubahGrafik('bulanan')" id="btn-bulanan" class="btn-filter px-3 py-1.5 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded cursor-pointer transition">Bulanan</button>
                    </div>
                </div>
                <div class="relative h-64 w-full"><canvas id="chartPendapatanHari"></canvas></div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-xs border border-gray-100 flex flex-col justify-between h-full">
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-clock-rotate-left text-amber-500"></i>
                            Belum Terverifikasi
                        </h4>
                        <span class="px-2 py-0.5 text-[10px] bg-amber-50 text-amber-600 rounded-full font-bold">
                            {{ $statistik['pembayaran_menunggu'] }} Antrean
                        </span>
                    </div>
                    
                    <div class="space-y-3">
                        @forelse($belumVerifikasi as $item)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl border border-gray-100 hover:border-amber-200 transition">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-xs font-bold text-gray-900">{{ $item->nama_pelanggan }}</span>
                                    <span class="text-[10px] text-gray-500 font-medium">{{ $item->paket }} • {{ $item->created_at ? $item->created_at->format('d M') : 'Sesi' }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-black text-gray-900 block">Rp {{ number_format($item->total_pembayaran, 0, ',', '.') }}</span>
                                    <span class="text-[9px] text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded-md font-bold mt-0.5 inline-block">Pending</span>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-12 text-center text-gray-400">
                                <i class="fa-solid fa-circle-check text-2xl text-green-400 mb-2"></i>
                                <p class="text-xs font-bold">Semua pembayaran aman!</p>
                                <p class="text-[10px] text-gray-400">Tidak ada data yang perlu diverifikasi.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-gray-100">
                    <a href="/admin/verifikasi-pembayaran" class="w-full text-center block py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-xs transition shadow-xs cursor-pointer">
                        Proses Verifikasi <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 text-xs">
            <div class="bg-white p-5 rounded-xl shadow-xs border border-gray-100 flex flex-col justify-between">
                <div class="space-y-4">
                    <h4 class="font-bold text-gray-800 mb-2">Ringkasan Laporan</h4>
                    
                    <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                        <div class="flex items-center space-x-2">
                            <div class="w-7 h-7 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-xs"><i class="fa-solid fa-calendar-days"></i></div>
                            <div>
                                <p class="font-bold text-gray-800">Total Booking</p>
                                <p class="text-[10px] text-gray-400">Jumlah seluruh booking</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">{{ $statistik['total_booking'] }}</p>
                            <span class="text-[10px] text-green-500 font-medium">+12%</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                        <div class="flex items-center space-x-2">
                            <div class="w-7 h-7 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xs"><i class="fa-solid fa-circle-check"></i></div>
                            <div>
                                <p class="font-bold text-gray-800">Pembayaran Disetujui</p>
                                <p class="text-[10px] text-gray-400">Jumlah pembayaran yang disetujui</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">{{ $statistik['total_booking'] - $statistik['pembatalan'] - $statistik['pembayaran_menunggu'] }}</p>
                            <span class="text-[10px] text-green-500 font-medium">+10%</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                        <div class="flex items-center space-x-2">
                            <div class="w-7 h-7 bg-red-50 text-red-600 rounded-full flex items-center justify-center text-xs"><i class="fa-solid fa-circle-xmark"></i></div>
                            <div>
                                <p class="font-bold text-gray-800">Pembayaran Ditolak</p>
                                <p class="text-[10px] text-gray-400">Jumlah pembayaran yang ditolak</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">{{ $statistik['pembatalan'] }}</p>
                            <span class="text-[10px] text-red-500 font-medium">-25%</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pb-2">
                        <div class="flex items-center space-x-2">
                            <div class="w-7 h-7 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center text-xs"><i class="fa-solid fa-wallet"></i></div>
                            <div>
                                <p class="font-bold text-gray-800">Total Pendapatan</p>
                                <p class="text-[10px] text-gray-400">Total pendapatan bersih</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">Rp {{ number_format($statistik['pendapatan'], 0, ',', '.') }}</p>
                            <span class="text-[10px] text-green-500 font-medium">+18%</span>
                        </div>
                    </div>
                </div>

                <a href="/admin/laporan" class="w-full text-center py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold rounded-lg border border-gray-200 block mt-4 transition">
                    Lihat Detail Laporan <i class="fa-solid fa-angle-right ml-1"></i>
                </a>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-xs border border-gray-100">
                <h4 class="font-bold text-gray-800 mb-3">Pendapatan per Hari (Disetujui)</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-[11px]">
                        <thead>
                            <tr class="text-gray-400 border-b border-gray-100 font-bold bg-gray-50/50">
                                <th class="p-2">Tanggal</th>
                                <th class="p-2 text-center">Sesi</th>
                                <th class="p-2 text-right">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-gray-600 font-medium">
                            @forelse($pendapatanPerHari as $hari)
                                <tr>
                                    <td class="p-2">{{ \Carbon\Carbon::parse($hari->tanggal)->format('d M Y') }}</td>
                                    <td class="p-2 text-center">{{ $hari->total_booking }}</td>
                                    <td class="p-2 text-right">Rp {{ number_format($hari->total_pendapatan, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-2 text-center py-4 text-gray-400">Belum ada transaksi sukses minggu ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="bg-[#C1BA8A]/10 font-bold text-gray-800 border-t border-gray-200">
                                <td class="p-2">Total</td>
                                <td class="p-2 text-center">{{ $pendapatanPerHari->sum('total_booking') }}</td>
                                <td class="p-2 text-right">Rp {{ number_format($pendapatanPerHari->sum('total_pendapatan'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-xs border border-gray-100">
                <h4 class="font-bold text-gray-800 mb-3">Pendapatan per Metode Pembayaran</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-[11px]">
                        <thead>
                            <tr class="text-gray-400 border-b border-gray-100 font-bold bg-gray-50/50">
                                <th class="p-2">Metode</th>
                                <th class="p-2 text-center">Sesi</th>
                                <th class="p-2 text-right">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-gray-600 font-medium">
                            @forelse($pendapatanPerMetode as $metode)
                                <tr>
                                    <td class="p-2">{{ $metode->metode_pembayaran ?? 'Lainnya' }}</td>
                                    <td class="p-2 text-center">{{ $metode->jumlah_transaksi }}</td>
                                    <td class="p-2 text-right">Rp {{ number_format($metode->total_pendapatan, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-2 text-center py-4 text-gray-400">Belum ada data metode pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="bg-[#C1BA8A]/10 font-bold text-gray-800 border-t border-gray-200">
                                <td class="p-2">Total</td>
                                <td class="p-2 text-center">{{ $pendapatanPerMetode->sum('jumlah_transaksi') }}</td>
                                <td class="p-2 text-right">Rp {{ number_format($pendapatanPerMetode->sum('total_pendapatan'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // FUNGSI DROPDOWN PROFIL ADMIN
        function toggleProfileMenu() {
            const dropdown = document.getElementById('dropdownProfil');
            dropdown.classList.toggle('hidden');
        }

        window.addEventListener('click', function(e) {
            const button = document.querySelector('button[onclick="toggleProfileMenu()"]');
            const dropdown = document.getElementById('dropdownProfil');
            
            if (button && dropdown && !button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // FUNGSI CHART.JS (TIDAK ADA YANG DIUBAH)
        const dataHarian = {
            labels: [
                @foreach($pendapatanPerHari as $hari)
                    "{{ \Carbon\Carbon::parse($hari->tanggal)->format('d M') }}",
                @endforeach
            ],
            data: [
                @foreach($pendapatanPerHari as $hari)
                    {{ $hari->total_pendapatan }},
                @endforeach
            ]
        };

        const dataMingguan = {
            labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
            data: {!! json_encode($chartWeeklyData) !!}
        };

        const dataBulanan = {
            labels: {!! json_encode($chartMonthlyLabels) !!},
            data: {!! json_encode($chartMonthlyData) !!}
        };

        let myChart; 

        document.addEventListener("DOMContentLoaded", function() {
            const ctxHari = document.getElementById('chartPendapatanHari').getContext('2d');
            myChart = new Chart(ctxHari, {
                type: 'line',
                data: {
                    labels: dataHarian.labels,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: dataHarian.data,
                        borderColor: '#C1BA8A',
                        backgroundColor: 'rgba(193, 186, 138, 0.2)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#C1BA8A',
                        pointRadius: 4
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            min: 0, 
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        });

        function ubahGrafik(jenis) {
            document.querySelectorAll('.btn-filter').forEach(btn => {
                btn.classList.remove('bg-[#C1BA8A]', 'text-white', 'shadow-xs');
                btn.classList.add('bg-gray-100', 'text-gray-600');
            });

            const tombolAktif = document.getElementById('btn-' + jenis);
            tombolAktif.classList.remove('bg-gray-100', 'text-gray-600');
            tombolAktif.classList.add('bg-[#C1BA8A]', 'text-white', 'shadow-xs');

            let newData = {};
            let teksSubtitle = '';

            if (jenis === 'harian') {
                newData = dataHarian;
                teksSubtitle = '7 Hari Terakhir';
            } else if (jenis === 'mingguan') {
                newData = dataMingguan;
                teksSubtitle = 'Bulan Ini (Data Mingguan Real)';
            } else if (jenis === 'bulanan') {
                newData = dataBulanan;
                teksSubtitle = 'Tren 6 Bulan Terakhir (Data Bulanan Real)';
            }

            document.getElementById('teksPeriodeGrafik').innerText = teksSubtitle;
            
            if(myChart) {
                myChart.data.labels = newData.labels;
                myChart.data.datasets[0].data = newData.data;
                myChart.update();
            }
        }
    </script>
</body>
</html>