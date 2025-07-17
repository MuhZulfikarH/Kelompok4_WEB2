<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class LaporanController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['user', 'detailPesanan.obat'])
                    ->where('status', 'selesai')
                    ->orderBy('tanggal', 'desc')
                    ->get();

        return view('admin.laporan', compact('pesanan'));
    }
}
