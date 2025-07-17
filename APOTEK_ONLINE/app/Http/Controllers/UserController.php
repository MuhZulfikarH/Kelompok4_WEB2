<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Obat;
use App\Models\Pesanan;
use App\Models\KategoriObat;
use App\Models\Komplain;

class UserController extends Controller
{
    private function hanyaUser()
    {
        if (!Auth::check() || Auth::user()->role !== 'user') {
            abort(403, 'Akses hanya untuk user.');
        }
    }

    public function index(Request $request)
    {
        $this->hanyaUser();

        $kategoriList = KategoriObat::all();

        $obats = Obat::with('kategori')
                    ->when($request->kategori, function ($query) use ($request) {
                        $query->where('kategori_obat_id', $request->kategori);
                    })
                    ->get();

        // Ambil semua komplain user + balasan
        $komplains = Komplain::with('balasan')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('user.dashboard', compact('obats', 'kategoriList', 'komplains'));
    }

    public function daftarObat(Request $request)
    {
        $this->hanyaUser();

        $user = Auth::user();
        $kategoriList = KategoriObat::all();

        $obats = Obat::with('kategori')
                    ->when($request->kategori, function ($query) use ($request) {
                        $query->where('kategori_obat_id', $request->kategori);
                    })
                    ->get();

        return view('user.daftar_obat', compact('user', 'obats', 'kategoriList'));
    }

    public function pesananSaya()
    {
        $this->hanyaUser();

        $pesanan = Pesanan::with('detailPesanan.obat')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('user.pesanan_saya', compact('pesanan'));
    }

    public function detailPesanan($id)
    {
        $this->hanyaUser();

        $pesanan = Pesanan::with('detailPesanan.obat')->findOrFail($id);

        if ($pesanan->user_id !== Auth::id()) {
            abort(403, 'Ini bukan pesanan kamu.');
        }

        return view('user.detail_pesanan', compact('pesanan'));
    }

    public function batalkanPesanan($id)
    {
        $this->hanyaUser();

        $pesanan = Pesanan::with('detailPesanan.obat')->findOrFail($id);

        if ($pesanan->user_id !== Auth::id()) {
            abort(403, 'Ini bukan pesanan kamu.');
        }

        if ($pesanan->status !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan tidak bisa dibatalkan karena sudah diproses.');
        }

        foreach ($pesanan->detailPesanan as $item) {
            $obat = $item->obat;
            if ($obat) {
                $obat->stok += $item->jumlah;
                $obat->save();
            }
        }

        $pesanan->status = 'dibatalkan';
        $pesanan->save();

        return redirect()->route('user.pesanan_saya')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function kirimKomplain(Request $request)
    {
        $this->hanyaUser();

        $request->validate([
            'komplain' => 'required|string|max:1000',
        ]);

        Komplain::create([
            'user_id' => Auth::id(),
            'isi'     => $request->komplain,
        ]);

        return redirect()->back()->with('success', 'Komplain berhasil dikirim.');
    }
}
