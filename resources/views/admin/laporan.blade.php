@extends('layouts.admin')
@section('title', 'Laporan Aktivitas - Admin')
@section('content')
    <div class="p-4 md:p-8 max-w-[1400px] mx-auto space-y-6 relative z-10">
        
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center space-x-2">
                <span class="w-7 h-7 bg-amber-100 rounded-lg text-[#A69E65] flex items-center justify-center text-sm"><i class="fa-regular fa-folder-open"></i></span>
                <span>Laporan</span>
            </h1>
            <p class="text-xs text-gray-400 mt-1">Ringkasan data dan Laporan Aktifitas studio foto</p>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-2xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4 text-xs">
            <div class="w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                <label class="block font-bold text-gray-700 mb-1">Filter Paket</label>
                <div class="inline-flex border border-gray-200 rounded-lg overflow-hidden bg-gray-50 font-medium text-center whitespace-nowrap">
                    <a href="/admin/laporan?paket=Semua Paket" class="block px-4 py-2 {{ $filterPaket == 'Semua Paket' ? 'bg-[#C1BA8A] text-white font-bold' : 'text-gray-500 hover:bg-gray-100' }} transition">
                        Semua Paket
                    </a>
                    @foreach($listPaket as $nama)
                    <a href="/admin/laporan?paket={{ urlencode($nama) }}" class="block px-4 py-2 {{ $filterPaket == $nama ? 'bg-[#C1BA8A] text-white font-bold' : 'text-gray-500 hover:bg-gray-100' }} transition">
                        {{ $nama }}
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="space-y-1 w-full md:w-auto">
                <span class="block font-bold text-gray-700">Ekspor Data Laporan</span>
                <div class="flex flex-wrap gap-2">
                    <a href="/admin/laporan/excel?paket={{ urlencode($filterPaket) }}" class="px-4 py-2 bg-[#C1BA8A] hover:bg-[#A69E65] text-white font-bold rounded-lg shadow-2xs transition flex items-center justify-center space-x-1.5 cursor-pointer text-center no-underline flex-1 md:flex-none">
                        <i class="fa-regular fa-file-excel"></i> <span>Ekspor Excel</span>
                    </a>
                    <a href="/admin/laporan/pdf?paket={{ urlencode($filterPaket) }}" class="px-4 py-2 bg-[#C1BA8A] hover:bg-[#A69E65] text-white font-bold rounded-lg shadow-2xs transition flex items-center justify-center space-x-1.5 cursor-pointer text-center no-underline flex-1 md:flex-none">
                        <i class="fa-regular fa-file-pdf"></i> <span>Ekspor PDF</span>
                    </a>
                </div>
            </div>
        </div>

        <hr class="border-gray-200">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border-2 border-amber-100 shadow-sm text-center md:text-left">
                <span class="text-sm font-bold text-gray-500 block">Total Pendapatan</span>
                <h2 class="text-3xl font-black text-gray-800 mt-2">RP {{ number_format($laporanStatistik['total_pendapatan'], 0, ',', '.') }}</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl border-2 border-amber-100 shadow-sm text-center md:text-left">
                <span class="text-sm font-bold text-gray-500 block">Total Pemesan Selesai</span>
                <h2 class="text-3xl font-black text-gray-800 mt-2">{{ $laporanStatistik['total_sesi_selesai'] }} Sesi</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl border-2 border-amber-100 shadow-sm text-center md:text-left">
                <span class="text-sm font-bold text-gray-500 block">Paket Terlaris</span>
                <h2 class="text-3xl font-black text-gray-800 mt-2">{{ $laporanStatistik['paket_terlaris'] }}</h2>
            </div>
        </div>

        <div class="space-y-3">
            <h3 class="font-extrabold text-gray-800 text-sm border-b-2 border-gray-800 pb-2">Tabel Detail Laporan Transaksi</h3>
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-2xs text-xs">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 font-bold uppercase tracking-wider">
                            <th class="p-4 w-12 text-center">No</th>
                            <th class="p-4">Kode Nota</th>
                            <th class="p-4">Nama Pelanggan</th>
                            <th class="p-4">Paket Pilihan</th>
                            <th class="p-4 text-center">Tanggal Selesai</th>
                            <th class="p-4 text-center">Metode Bayar</th>
                            <th class="p-4 text-right">Jumlah Uang</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-600 font-medium">
                        @forelse($detailTransaksi as $dt)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 text-center text-gray-400 font-normal">{{ $dt['no'] }}</td>
                            <td class="p-4 font-bold text-gray-800">{{ $dt['nota'] }}</td>
                            <td class="p-4 font-bold text-gray-900">{{ $dt['pelanggan'] }}</td>
                            <td class="p-4"><span class="bg-indigo-50 text-indigo-600 font-bold px-2 py-0.5 rounded text-[10px]">{{ $dt['paket'] }}</span></td>
                            <td class="p-4 text-center">{{ $dt['tanggal'] }}</td>
                            <td class="p-4 text-center"><span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-[10px]">{{ $dt['metode'] }}</span></td>
                            <td class="p-4 text-right font-bold text-gray-900">Rp {{ number_format($dt['jumlah'], 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400 italic">Tidak ada transaksi lunas ditemukan untuk filter ini. Pastikan Anda sudah 'Menyetujui' pesanan di tab Verifikasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection