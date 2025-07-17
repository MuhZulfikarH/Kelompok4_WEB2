<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Obat;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    public function formPesan($id)
    {
        $obat = Obat::findOrFail($id);
        $user = Auth::user();

        return view('user.pesan_obat', compact('obat', 'user'));
    }

    public function simpanPesanan(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);

        Log::info('Request simpanPesanan:', $request->all());

        $request->validate([
            'jumlah'             => 'required|integer|min:1|max:' . $obat->stok,
            'alamat_pengiriman'  => 'required|string|max:255',
            'catatan'            => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $totalHarga = $obat->harga * $request->jumlah;

            $pesanan = Pesanan::create([
                'user_id'            => Auth::id(),
                'tanggal'            => Carbon::now(),
                'status'             => 'pending',
                'total_harga'        => $totalHarga,
                'alamat_pengiriman'  => $request->alamat_pengiriman,
            ]);

            Log::info('Pesanan berhasil dibuat:', $pesanan->toArray());

            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'obat_id'    => $obat->id,
                'jumlah'     => $request->jumlah,
                'harga'      => $obat->harga,
                'catatan'    => $request->catatan,
            ]);

            $obat->stok -= $request->jumlah;
            $obat->save();

            DB::commit();

            return redirect()->route('user.pesanan_saya')->with('success', 'Pesanan berhasil dikirim!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Gagal simpanPesanan:', ['error' => $e->getMessage()]);
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function pesananMasuk()
    {
        $pesanan = Pesanan::with(['user', 'detailPesanan.obat'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pesanan_masuk', compact('pesanan'));
    }

    public function ubahStatus($id, $status)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => $status]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function batalkanPesanan($id)
    {
        $pesanan = Pesanan::with('detailPesanan.obat')->where('user_id', Auth::id())->findOrFail($id);

        if ($pesanan->status !== 'pending') {
            return redirect()->route('user.pesanan_saya')->with('error', 'Pesanan tidak bisa dibatalkan.');
        }

        DB::beginTransaction();

        try {
            foreach ($pesanan->detailPesanan as $detail) {
                $obat = $detail->obat;
                $obat->stok += $detail->jumlah;
                $obat->save();
            }

            $pesanan->status = 'dibatalkan';
            $pesanan->save();

            DB::commit();

            return redirect()->route('user.pesanan_saya')->with('success', 'Pesanan berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal batalkanPesanan:', ['error' => $e->getMessage()]);
            return redirect()->route('user.pesanan_saya')->with('error', 'Terjadi kesalahan saat membatalkan pesanan.');
        }
    }
}
