@extends('layouts.admin')
@section('title', 'Verifikasi Pembayaran - Admin')
@section('content')
    <div class="p-4 md:p-8 max-w-[1400px] mx-auto grid grid-cols-1 lg:grid-cols-4 gap-8 relative z-10">
        <div class="lg:col-span-3 space-y-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center space-x-2">
                    <span class="w-7 h-7 bg-amber-100 rounded-lg text-[#A69E65] flex items-center justify-center text-sm"><i class="fa-solid fa-shield-check"></i></span>
                    <span>Verifikasi Pembayaran</span>
                </h1>
                <p class="text-xs text-gray-400 mt-1">Kelola dan Verifikasi pembayarn yang di lakukan oleh pelanggan</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="/admin/verifikasi-pembayaran" class="px-4 py-2 rounded-lg border {{ !request('status') ? 'bg-[#C1BA8A] text-white font-bold border-[#C1BA8A]' : 'bg-white text-gray-600 border-gray-200' }} text-sm transition shadow-2xs flex items-center space-x-2">
                    <i class="fa-solid fa-layer-group"></i> <span>Semua</span>
                </a>
                <a href="/admin/verifikasi-pembayaran?status=Menunggu" class="px-4 py-2 rounded-lg border {{ request('status') == 'Menunggu' ? 'bg-amber-500 text-white font-bold border-amber-500' : 'bg-white text-gray-600 border-gray-200' }} text-sm transition shadow-2xs flex items-center space-x-2">
                    <i class="fa-regular fa-clock"></i> <span>Menunggu</span>
                </a>
                <a href="/admin/verifikasi-pembayaran?status=Disetujui" class="px-4 py-2 rounded-lg border {{ request('status') == 'Disetujui' ? 'bg-emerald-500 text-white font-bold border-emerald-500' : 'bg-white text-gray-600 border-gray-200' }} text-sm transition shadow-2xs flex items-center space-x-2">
                    <i class="fa-regular fa-circle-check"></i> <span>Disetujui</span>
                </a>
                <a href="/admin/verifikasi-pembayaran?status=Ditolak" class="px-4 py-2 rounded-lg border {{ request('status') == 'Ditolak' ? 'bg-rose-500 text-white font-bold border-rose-500' : 'bg-white text-gray-600 border-gray-200' }} text-sm transition shadow-2xs flex items-center space-x-2">
                    <i class="fa-regular fa-circle-xmark"></i> <span>Ditolak</span>
                </a>
            </div>

            <form action="/admin/verifikasi-pembayaran" method="GET" class="relative">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari latar belakang kode booking atau nama pelanggan..." class="w-full pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C1BA8A]/20 focus:border-[#C1BA8A]">
            </form>

            @if(session('success'))
            <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-xs flex items-center space-x-2">
                <i class="fa-solid fa-circle-check"></i> <span>{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-xs overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs min-w-[900px]">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 font-bold uppercase tracking-wider">
                            <th class="p-4 w-12 text-center">No</th>
                            <th class="p-4">Kode Booking</th>
                            <th class="p-4">Pelanggan</th>
                            <th class="p-4">Paket</th>
                            <th class="p-4">Tanggal Booking</th>
                            <th class="p-4">Total Pembayaran</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-center">Bukti Pembayaran</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($daftarPembayaran as $index => $item)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="p-4 text-center text-gray-400">{{ $daftarPembayaran->firstItem() + $index }}</td>
                            <td class="p-4 font-semibold text-gray-800">
                                <div>{{ $item->kode_booking }}</div>
                                <span class="text-[10px] font-normal text-gray-400 block mt-0.5">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</span>
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-gray-900">{{ $item->nama_pelanggan }}</div>
                                <div class="text-gray-400 text-[10px] mt-0.5">{{ $item->email_pelanggan }}</div>
                                <div class="text-gray-400 text-[10px]">{{ $item->no_hp }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-semibold">{{ $item->paket }}</div>
                                <span class="inline-block mt-1 bg-indigo-50 text-indigo-600 font-bold text-[9px] px-1.5 py-0.5 rounded-sm">{{ $item->durasi ?? '3 Jam' }}</span>
                            </td>
                            <td class="p-4">
                                <div class="font-medium">{{ \Carbon\Carbon::parse($item->tanggal_booking)->translatedFormat('d M Y') }}</div>
                                <div class="text-[10px] text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($item->tanggal_booking)->format('H:i') }} WIB</div>
                            </td>
                            <td class="p-4 font-bold text-gray-900 text-sm">Rp {{ number_format($item->total_pembayaran, 0, ',', '.') }}</td>
                            <td class="p-4 text-center">
                                @if($item->status == 'Menunggu')
                                    <span class="inline-flex items-center space-x-1 bg-amber-50 text-amber-600 px-2 py-1 rounded-full font-bold text-[10px] border border-amber-200/50"><i class="fa-regular fa-clock"></i> <span>Menunggu</span></span>
                                @elseif($item->status == 'Disetujui')
                                    <span class="inline-flex items-center space-x-1 bg-emerald-50 text-emerald-600 px-2 py-1 rounded-full font-bold text-[10px] border border-emerald-200/50"><i class="fa-regular fa-circle-check"></i> <span>Disetujui</span></span>
                                @else
                                    <span class="inline-flex items-center space-x-1 bg-rose-50 text-rose-600 px-2 py-1 rounded-full font-bold text-[10px] border border-rose-200/50"><i class="fa-regular fa-circle-xmark"></i> <span>Ditolak</span></span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                @if($item->bukti_pembayaran)
                                    <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank" class="inline-block border border-gray-200 rounded p-0.5 hover:shadow-xs transition bg-white w-14 h-10 overflow-hidden">
                                        <img src="{{ asset('storage/' . $item->bukti_pembayaran) }}" class="w-full h-full object-cover">
                                    </a>
                                @else
                                    <span class="text-gray-300 italic text-[10px]">Belum Unggah</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex flex-col space-y-1 items-center justify-center">
                                    @if($item->status == 'Menunggu')
                                        <form action="{{ route('admin.pembayaran.update', [$item->id, 'Disetujui']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-20 py-1 bg-emerald-50 border border-emerald-300 text-emerald-600 rounded font-bold hover:bg-emerald-500 hover:text-white transition cursor-pointer text-[10px] text-center"><i class="fa-solid fa-check mr-1"></i>Setujui</button>
                                        </form>
                                        <form action="{{ route('admin.pembayaran.update', [$item->id, 'Ditolak']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-20 py-1 bg-rose-50 border border-rose-300 text-rose-600 rounded font-bold hover:bg-rose-500 hover:text-white transition cursor-pointer text-[10px] text-center"><i class="fa-solid fa-xmark mr-1"></i>Tolak</button>
                                        </form>
                                    @else
                                        <button disabled class="w-20 py-1 bg-gray-100 border border-gray-200 text-gray-400 rounded font-medium text-[10px] cursor-not-allowed">
                                            {{ $item->status }}
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="p-12 text-center text-gray-400">Tidak ada riwayat verifikasi pembayaran ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4 bg-gray-50 border-t border-gray-100 flex justify-center">
                    {{ $daftarPembayaran->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-2xs space-y-3">
                <h3 class="font-bold text-gray-700 text-xs uppercase tracking-wider flex items-center space-x-1.5"><i class="fa-solid fa-receipt text-gray-400"></i> <span>Ringkasan Pembayaran</span></h3>
                <div class="grid grid-cols-2 gap-2 text-center">
                    <div class="p-2 border border-gray-100 rounded-lg bg-gray-50/50">
                        <div class="text-amber-500 font-bold text-base"><i class="fa-regular fa-clock text-xs mr-1"></i>{{ $ringkasan['menunggu'] }}</div>
                        <span class="text-[9px] text-gray-400 font-medium block mt-0.5">Menunggu</span>
                    </div>
                    <div class="p-2 border border-gray-100 rounded-lg bg-gray-50/50">
                        <div class="text-emerald-500 font-bold text-base"><i class="fa-regular fa-circle-check text-xs mr-1"></i>{{ $ringkasan['disetujui'] }}</div>
                        <span class="text-[9px] text-gray-400 font-medium block mt-0.5">Disetujui</span>
                    </div>
                    <div class="p-2 border border-gray-100 rounded-lg bg-gray-50/50">
                        <div class="text-rose-500 font-bold text-base"><i class="fa-regular fa-circle-xmark text-xs mr-1"></i>{{ $ringkasan['ditolak'] }}</div>
                        <span class="text-[9px] text-gray-400 font-medium block mt-0.5">Ditolak</span>
                    </div>
                    <div class="p-2 border border-gray-100 rounded-lg bg-indigo-50/50 border-indigo-100">
                        <div class="text-indigo-600 font-bold text-base"><i class="fa-solid fa-folder text-xs mr-1"></i>{{ $ringkasan['total'] }}</div>
                        <span class="text-[9px] text-indigo-400 font-bold block mt-0.5">Total</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-2xs space-y-4">
                <h3 class="font-bold text-gray-700 text-xs uppercase tracking-wider flex items-center space-x-1.5"><i class="fa-solid fa-bolt text-gray-400"></i> <span>Aktivitas Terbaru</span></h3>
                <div class="space-y-3 max-h-[350px] overflow-y-auto pr-1">
                    @foreach($aktivitasTerbaru as $act)
                    <div class="flex items-start space-x-2 text-[10px] border-b border-gray-50 pb-2 last:border-0 last:pb-0">
                        @if($act->status == 'Menunggu')
                            <div class="w-5 h-5 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center shrink-0 mt-0.5"><i class="fa-regular fa-clock"></i></div>
                            <div>
                                <p class="text-gray-700">Pembayaran dari <span class="font-bold">{{ $act->nama_pelanggan }}</span> sebesar <span class="font-bold text-gray-900">Rp {{ number_format($act->total_pembayaran, 0, ',', '.') }}</span> - <span class="text-amber-500 font-semibold">Menunggu</span></p>
                                <span class="text-[9px] text-gray-400 block mt-0.5">{{ \Carbon\Carbon::parse($act->created_at)->format('d M Y, H:i') }}</span>
                            </div>
                        @elseif($act->status == 'Disetujui')
                            <div class="w-5 h-5 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center shrink-0 mt-0.5"><i class="fa-regular fa-circle-check"></i></div>
                            <div>
                                <p class="text-gray-700">Pembayaran disetujui untuk <span class="font-bold">{{ $act->nama_pelanggan }}</span> - <span class="font-bold text-gray-900">Rp {{ number_format($act->total_pembayaran, 0, ',', '.') }}</span></p>
                                <span class="text-[9px] text-gray-400 block mt-0.5">{{ \Carbon\Carbon::parse($act->updated_at)->format('d M Y, H:i') }}</span>
                            </div>
                        @else
                            <div class="w-5 h-5 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center shrink-0 mt-0.5"><i class="fa-regular fa-circle-xmark"></i></div>
                            <div>
                                <p class="text-gray-700">Pembayaran ditolak untuk <span class="font-bold">{{ $act->nama_pelanggan }}</span> - <span class="font-bold text-gray-900">Rp {{ number_format($act->total_pembayaran, 0, ',', '.') }}</span></p>
                                <span class="text-[9px] text-gray-400 block mt-0.5">{{ \Carbon\Carbon::parse($act->updated_at)->format('d M Y, H:i') }}</span>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>   
@endsection