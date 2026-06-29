<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\Pembayaran;
use App\Models\Galeri; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; 

class StudioController extends Controller
{
    public function landing()
    {
        return view('user.dashboard');
    }

    public function index()
    {
        return view('user.dashboard');
    }

    public function paketFoto(Request $request)
    {
        $kategoriSelected = $request->get('kategori');

        if ($kategoriSelected) {
            $daftarPaket = Paket::where('kategori', $kategoriSelected)->get();
            return view('paket_foto', compact('daftarPaket'));
        } else {
            $katalogKategori = Paket::select('kategori', 'gambar')
                                ->get()
                                ->unique('kategori');

            return view('paket_foto', compact('katalogKategori'));
        }
    }

    public function galeri()
    {
        $galeriUser = Galeri::latest()->get();
        return view('user.galeri', compact('galeriUser'));
    }

    public function formBooking($id)
    {
        $paket = Paket::findOrFail($id);
        return view('user.booking', compact('paket'));
    }

    public function simpanBooking(Request $request)
    {
        $request->validate([
            'nama_pelanggan'   => 'required|string',
            'tanggal_booking'  => 'required|date', 
            'jam'              => 'required', 
            'no_hp'            => 'required',
            'paket'            => 'required',
            'total_pembayaran' => 'required|numeric',
            'metode_pembayaran'=> 'required|string'
        ]);

        $waktuMulaiRencana = Carbon::parse($request->tanggal_booking . ' ' . $request->jam . ':00');

        $paketData = Paket::where('nama_paket', $request->paket)->first();
        
        $angkaDurasi = 1; 
        $isMenit = false;

        if ($paketData) {
            $angkaDurasi = (int) filter_var($paketData->durasi, FILTER_SANITIZE_NUMBER_INT);
            if (str_contains(strtolower($paketData->durasi), 'menit')) {
                $isMenit = true;
            }
            if ($angkaDurasi <= 0) { $angkaDurasi = 1; }
        }

        $waktuSelesaiRencana = clone $waktuMulaiRencana;

        if ($isMenit) {
            $waktuSelesaiRencana->addMinutes($angkaDurasi);
        } else {
            $waktuSelesaiRencana->addHours($angkaDurasi);
        }

        $jadwalBentrok = Pembayaran::whereIn('status', ['Disetujui', 'Menunggu'])
            ->where(function ($query) use ($waktuMulaiRencana, $waktuSelesaiRencana) {
                $query->where('tanggal_booking', '<', $waktuSelesaiRencana->toDateTimeString())
                      ->whereRaw('DATE_ADD(tanggal_booking, INTERVAL 1 HOUR) > ?', [$waktuMulaiRencana->toDateTimeString()]);
            })
            ->exists();

        if ($jadwalBentrok) {
            return back()->withInput()->withErrors([
                'jam' => 'Maaf, studio sudah penuh atau telah dibooking oleh pelanggan lain pada jam tersebut. Silakan pilih alternatif jam/tanggal lain.'
            ]);
        }

        $kodeBooking = 'BK-' . date('ymd') . '-' . rand(100, 999);

        Pembayaran::create([
            'kode_booking'    => $kodeBooking,
            'nama_pelanggan'  => $request->nama_pelanggan,
            'email_pelanggan' => 'pelanggan@gmail.com', 
            'no_hp'           => $request->no_hp,
            'paket'           => $request->paket,
            'tanggal_booking' => $waktuMulaiRencana->toDateTimeString(),
            'total_pembayaran'=> $request->total_pembayaran,
            'metode_pembayaran'=> $request->metode_pembayaran,
            'status'          => 'Menunggu'
        ]);

        return redirect('/riwayat-pemesanan')->with('success', 'Order Berhasil Di Buat! Silakan cek instruksi pembayaran di halaman riwayat.');
    }

    public function riwayatPemesanan()
    {
        // PERBAIKAN: Mengembalikan nama variabel menjadi $riwayat agar sesuai dengan kodingan Blade Anda
        $riwayat = Pembayaran::latest()->get();
        return view('user.riwayat', compact('riwayat'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $transaksi = Pembayaran::findOrFail($id);

        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti_transfer', 'public');
            $transaksi->update([
                'bukti_pembayaran' => $path
            ]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diunggah! Menunggu verifikasi admin.');
    }

    public function hapusPemesanan($id)
    {
        $booking = Pembayaran::findOrFail($id);

        if ($booking->bukti_pembayaran && Storage::disk('public')->exists($booking->bukti_pembayaran)) {
            Storage::disk('public')->delete($booking->bukti_pembayaran);
        }

        $booking->delete();

        return back()->with('success', 'Pesanan Anda berhasil dibatalkan dan dihapus secara permanen.');
    }

    public function profil()
    {
        return view('user.profil');
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'name' => $request->name,
            'no_hp' => $request->no_hp,
        ];

        if ($request->hasFile('foto_profil')) {
            // Delete old photo if exists
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $path = $request->file('foto_profil')->store('profil', 'public');
            $data['foto_profil'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function hapusFotoProfil()
    {
        $user = auth()->user();

        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
            $user->update(['foto_profil' => null]);
            return back()->with('success', 'Foto profil berhasil dihapus.');
        }

        return back()->withErrors(['error' => 'Foto profil tidak ditemukan.']);
    }
}