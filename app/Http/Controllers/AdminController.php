<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\Pembayaran; 
use App\Models\Booking; 
use App\Models\LatarBelakang; 
use App\Models\Galeri; 
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; 

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Ambil data statistik ringkasan utama
        $statistik = [
            'pendapatan' => Pembayaran::where('status', 'Disetujui')->sum('total_pembayaran') ?? 0,
            'total_booking' => Pembayaran::count(),
            'pembatalan' => Pembayaran::where('status', 'Ditolak')->count(),
            'pembayaran_menunggu' => Pembayaran::whereIn('status', ['Menunggu', 'Pending', 'menunggu', 'pending'])->count()
        ];

        // 2. Statistik Per Waktu (Hari, Minggu, Bulan)
        $waktuStats = [
            'hari_ini'   => Pembayaran::where('status', 'Disetujui')->whereDate('created_at', Carbon::today())->sum('total_pembayaran'),
            'minggu_ini' => Pembayaran::where('status', 'Disetujui')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total_pembayaran'),
            'bulan_ini'  => Pembayaran::where('status', 'Disetujui')->whereMonth('created_at', Carbon::now()->month)->sum('total_pembayaran')
        ];

        // 3. Query untuk Tabel Pendapatan Per Hari
        $pendapatanPerHari = Pembayaran::where('status', 'Disetujui')
            ->selectRaw('DATE(created_at) as tanggal, COUNT(*) as total_booking, SUM(total_pembayaran) as total_pendapatan')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->take(7)
            ->get();

        // ==========================================================
        // FITUR DINAMIS GRAFIK HARIAN (7 Hari Terakhir)
        // ==========================================================
        $chartLabels = [];
        $chartData = [];
        $dataGrafikDb = $pendapatanPerHari->keyBy('tanggal');

        for ($i = 6; $i >= 0; $i--) {
            $tglFull = Carbon::today()->subDays($i)->format('Y-m-d'); 
            $tglLabel = Carbon::today()->subDays($i)->format('d M');  

            $chartLabels[] = $tglLabel;

            if ($dataGrafikDb->has($tglFull)) {
                $chartData[] = $dataGrafikDb[$tglFull]->total_pendapatan;
            } else {
                $chartData[] = 0; 
            }
        }

        // ==========================================================
        // FITUR DINAMIS GRAFIK MINGGUAN (4 Minggu di Bulan Ini)
        // ==========================================================
        $chartWeeklyData = [0, 0, 0, 0]; // Index 0=Mgu1, 1=Mgu2, 2=Mgu3, 3=Mgu4
        $pembayaranBulanIni = Pembayaran::where('status', 'Disetujui')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->get();

        foreach ($pembayaranBulanIni as $p) {
            $day = Carbon::parse($p->created_at)->day;
            if ($day <= 7) {
                $chartWeeklyData[0] += $p->total_pembayaran;
            } elseif ($day <= 14) {
                $chartWeeklyData[1] += $p->total_pembayaran;
            } elseif ($day <= 21) {
                $chartWeeklyData[2] += $p->total_pembayaran;
            } else {
                $chartWeeklyData[3] += $p->total_pembayaran;
            }
        }

        // ==========================================================
        // FITUR DINAMIS GRAFIK BULANAN (6 Bulan Terakhir)
        // ==========================================================
        $bulanIndo = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        $chartMonthlyLabels = [];
        $chartMonthlyData = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthObj = Carbon::now()->subMonths($i);
            $chartMonthlyLabels[] = $bulanIndo[$monthObj->month];
            
            $chartMonthlyData[] = Pembayaran::where('status', 'Disetujui')
                ->whereMonth('created_at', $monthObj->month)
                ->whereYear('created_at', $monthObj->year)
                ->sum('total_pembayaran') ?? 0;
        }

        // 4. Query Dinamis: Pendapatan per Metode Pembayaran
        $pendapatanPerMetode = Pembayaran::where('status', 'Disetujui')
            ->selectRaw('metode_pembayaran, COUNT(*) as jumlah_transaksi, SUM(total_pembayaran) as total_pendapatan')
            ->groupBy('metode_pembayaran')
            ->get();

        // 5. Mengambil antrean belum terverifikasi
        $belumVerifikasi = Pembayaran::whereIn('status', ['Menunggu', 'Pending', 'menunggu', 'pending'])
                                      ->latest()
                                      ->take(4)
                                      ->get();

        return view('admin.dashboard', compact(
            'statistik', 'belumVerifikasi', 'pendapatanPerHari', 'pendapatanPerMetode', 'waktuStats', 
            'chartLabels', 'chartData', 'chartWeeklyData', 'chartMonthlyLabels', 'chartMonthlyData'
        ));
    }

    public function latarBelakang()
    {
        $daftarLatar = LatarBelakang::latest()->get();
        return view('admin.latar_belakang', compact('daftarLatar'));
    }

    public function storeLatarBelakang(Request $request)
    {
        $request->validate([
            'nama_latar' => 'required|string|max:255',
            'gambar'     => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('gambar')->store('latar_belakang', 'public');

        LatarBelakang::create([
            'nama_latar' => $request->nama_latar,
            'gambar'     => $path,
        ]);

        return back()->with('success', 'Wadah Latar Belakang baru berhasil ditambahkan!');
    }

    public function updateLatarBelakang(Request $request, $id)
    {
        $request->validate([
            'nama_latar' => 'required|string|max:255',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $latar = LatarBelakang::findOrFail($id);
        $namaLama = $latar->nama_latar;
        $latar->nama_latar = $request->nama_latar;

        if ($request->hasFile('gambar')) {
            if ($latar->gambar && Storage::disk('public')->exists($latar->gambar)) {
                Storage::disk('public')->delete($latar->gambar);
            }
            $latar->gambar = $request->file('gambar')->store('latar_belakang', 'public');
        }
        $latar->save();

        if ($namaLama !== $request->nama_latar) {
            Paket::where('kategori', $namaLama)->update(['kategori' => $request->nama_latar]);
        }

        return back()->with('success', 'Tema Latar Belakang berhasil diperbarui!');
    }

    public function destroyLatarBelakang($id)
    {
        $latar = LatarBelakang::findOrFail($id);
        if ($latar->gambar && Storage::disk('public')->exists($latar->gambar)) {
            Storage::disk('public')->delete($latar->gambar);
        }
        $latar->delete();
        return back()->with('success', 'Tema Latar Belakang dihapus. Paket di dalamnya sekarang berstatus Tanpa Tema.');
    }

    public function paket()
    {
        $daftarPaket = Paket::all();
        $daftarLatar = LatarBelakang::all(); 
        $daftarGaleri = Galeri::latest()->get(); 
        return view('admin.paket', compact('daftarPaket', 'daftarLatar', 'daftarGaleri'));
    }

    public function destroyJadwal($id)
    {
        $booking = Pembayaran::findOrFail($id);
        $booking->delete();
        return back()->with('success', 'Data agenda jadwal berhasil dihapus!');
    }

    public function storePaket(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'kategori'   => 'required|string',
            'durasi'     => 'required|string',
            'foto'       => 'required|string', 
            'harga'      => 'required|numeric',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('pakets', 'public');
        }

        Paket::create([
            'nama_paket' => $request->nama_paket,
            'kategori'   => $request->kategori,
            'durasi'     => $request->durasi,
            'foto'       => $request->foto,
            'harga'      => $request->harga,
            'gambar'     => $path,
        ]);

        return redirect('/admin/paket')->with('success', 'Paket baru berhasil ditambahkan ke katalog!');
    }

    public function updatePaket(Request $request, $id)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'kategori'   => 'required|string',
            'durasi'     => 'required|string',
            'foto'       => 'required|string', 
            'harga'      => 'required|numeric',
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $paket = Paket::findOrFail($id);
        $paket->nama_paket = $request->nama_paket;
        $paket->kategori = $request->kategori;
        $paket->durasi = $request->durasi;
        $paket->foto = $request->foto;
        $paket->harga = $request->harga;

        if ($request->hasFile('gambar')) {
            if ($paket->gambar && Storage::disk('public')->exists($paket->gambar)) {
                Storage::disk('public')->delete($paket->gambar);
            }
            $paket->gambar = $request->file('gambar')->store('pakets', 'public');
        }
        $paket->save();

        return redirect('/admin/paket')->with('success', 'Data katalog paket berhasil diperbarui!');
    }

    public function destroyPaket($id)
    {
        $paket = Paket::findOrFail($id);
        if ($paket->gambar && Storage::disk('public')->exists($paket->gambar)) {
            Storage::disk('public')->delete($paket->gambar);
        }
        $paket->delete();
        return back()->with('success', 'Paket berhasil dihapus dari katalog!');
    }

    public function storeGaleri(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
            'foto'     => 'required|array', 
            'foto.*'   => 'image|mimes:jpeg,png,jpg|max:5000',
        ]);

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('galeri_user', 'public');
                Galeri::create([
                    'kategori' => $request->kategori,
                    'foto'     => $path,
                ]);
            }
        }
        return back()->with('success', 'Foto berhasil ditambahkan ke Galeri User!');
    }

    public function destroyGaleri($id)
    {
        $galeri = Galeri::findOrFail($id);
        if (Storage::disk('public')->exists($galeri->foto)) {
            Storage::disk('public')->delete($galeri->foto);
        }
        $galeri->delete();
        return back()->with('success', 'Foto berhasil dihapus dari Galeri!');
    }

    public function verifikasiPembayaran(Request $request)
    {
        $statusFilter = $request->get('status');
        $search = $request->get('search');
        $query = Pembayaran::query();

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('kode_booking', 'like', "%{$search}%");
            });
        }

        $daftarPembayaran = $query->latest()->paginate(5);
        $ringkasan = [
            'menunggu' => Pembayaran::whereIn('status', ['Menunggu', 'Pending', 'menunggu', 'pending'])->count(),
            'disetujui' => Pembayaran::where('status', 'Disetujui')->count(),
            'ditolak' => Pembayaran::where('status', 'Ditolak')->count(),
            'total' => Pembayaran::count(),
        ];
        $aktivitasTerbaru = Pembayaran::latest()->take(5)->get();

        return view('admin.verifikasi', compact('daftarPembayaran', 'ringkasan', 'aktivitasTerbaru'));
    }

    public function updateStatusPembayaran($id, $status)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->status = $status; 
        $pembayaran->save();
        return back()->with('success', 'Status jadwal berhasil diperbarui menjadi ' . $status);
    }

    public function laporan(Request $request)
    {
        $filterPaket = $request->get('paket', 'Semua Paket');
        $query = Pembayaran::where('status', 'Disetujui');

        if ($filterPaket !== 'Semua Paket') {
            $query->where('paket', $filterPaket);
        }

        $rawTransaksi = $query->latest()->get();
        $detailTransaksi = [];
        foreach ($rawTransaksi as $index => $item) {
            $detailTransaksi[] = [
                'no' => $index + 1,
                'nota' => $item->kode_booking ?? 'INV-'.$item->id,
                'pelanggan' => $item->nama_pelanggan,
                'paket' => $item->paket,
                'tanggal' => \Carbon\Carbon::parse($item->tanggal_booking)->format('d M Y'),
                'metode' => $item->metode_pembayaran ?? 'Transfer',
                'jumlah' => $item->total_pembayaran
            ];
        }

        $totalPendapatan = $rawTransaksi->sum('total_pembayaran');
        $totalSesi = $rawTransaksi->count();
        $paketTerlaris = '-';
        if ($rawTransaksi->isNotEmpty()) {
            $grupPaket = $rawTransaksi->groupBy('paket')->map->count();
            $namaPaketTerbanyak = $grupPaket->keys()->first(); 
            $jumlahDipesan = $grupPaket->first();       
            if ($namaPaketTerbanyak) {
                $paketTerlaris = $namaPaketTerbanyak . ' (' . $jumlahDipesan . 'x)';
            }
        }

        $laporanStatistik = [
            'total_pendapatan' => $totalPendapatan, 
            'total_sesi_selesai' => $totalSesi,    
            'paket_terlaris' => $paketTerlaris
        ];
        $listPaket = Paket::select('nama_paket')->distinct()->pluck('nama_paket');

        return view('admin.laporan', compact('laporanStatistik', 'detailTransaksi', 'filterPaket', 'listPaket'));
    }

    public function eksporExcel(Request $request)
    {
        $filterPaket = $request->get('paket', 'Semua Paket');
        $query = Pembayaran::where('status', 'Disetujui');
        if ($filterPaket !== 'Semua Paket') {
            $query->where('paket', $filterPaket);
        }
        $rawTransaksi = $query->latest()->get();

        $dataExcel = [];
        foreach ($rawTransaksi as $index => $item) {
            $dataExcel[] = [
                'no' => $index + 1,
                'nota' => $item->kode_booking,
                'pelanggan' => $item->nama_pelanggan,
                'paket' => $item->paket,
                'tanggal' => \Carbon\Carbon::parse($item->tanggal_booking)->format('d M Y'),
                'metode' => $item->metode_pembayaran ?? 'Transfer',
                'jumlah' => $item->total_pembayaran
            ];
        }
        return Excel::download(new LaporanExport($dataExcel), 'Laporan_Studio_Terbaru.xlsx');
    }

    public function eksporPdf(Request $request)
    {
        $filterPaket = $request->get('paket', 'Semua Paket');
        $query = Pembayaran::where('status', 'Disetujui');
        if ($filterPaket !== 'Semua Paket') {
            $query->where('paket', $filterPaket);
        }
        $rawTransaksi = $query->latest()->get();
        $totalPendapatan = $rawTransaksi->sum('total_pembayaran');

        $pdfHtml = '<h2 style="text-align: center; font-family: sans-serif;">LAPORAN PENDAPATAN SNAPSPACE PHOTOSTUDIO</h2><p style="font-family: sans-serif;">Filter Paket: '.$filterPaket.'</p><p style="font-family: sans-serif;">Total Transaksi Selesai: <b>'.$rawTransaksi->count().' Sesi</b></p><p style="font-family: sans-serif;">Total Pendapatan Bersih: <b>Rp '.number_format($totalPendapatan, 0, ',', '.').'</b></p><hr><table border="1" cellspacing="0" cellpadding="6" width="100%" style="font-family: sans-serif; font-size: 12px;"><thead><tr style="background-color: #f2f2f2;"><th>No</th><th>Kode Nota</th><th>Nama Pelanggan</th><th>Paket Pilihan</th><th>Tanggal Sesi</th><th>Metode</th><th>Jumlah Uang</th></tr></thead><tbody>'; 
        foreach($rawTransaksi as $index => $item){ 
            $pdfHtml .= '<tr><td align="center">'.($index + 1).'</td><td>'.($item->kode_booking).'</td><td>'.$item->nama_pelanggan.'</td><td>'.$item->paket.'</td><td align="center">'.\Carbon\Carbon::parse($item->tanggal_booking)->format('d-m-Y').'</td><td align="center">'.($item->metode_pembayaran ?? 'Transfer').'</td><td align="right">Rp '.number_format($item->total_pembayaran, 0, ',', '.').'</td></tr>'; 
        } 
        $pdfHtml .= '</tbody></table>'; 
        
        $pdf = DomPDF::loadHTML($pdfHtml);
        return $pdf->download('Laporan_SnapSpace_Terbaru.pdf');
    }
}