<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Komplain;
use App\Models\BalasanKomplain;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        return view('admin.dashboard');
    }

    public function kotakKomplain()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        $komplains = Komplain::with(['user', 'balasan'])->latest()->get();

        return view('admin.komplain', compact('komplains'));
    }

    public function balasKomplain(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        $request->validate([
            'isi' => 'required|string|max:1000',
        ]);

        $komplain = Komplain::findOrFail($id);

        if ($komplain->balasan) {
            return redirect()->back()->with('error', 'Komplain ini sudah dibalas.');
        }

        BalasanKomplain::create([
            'komplain_id' => $komplain->id,
            'isi' => $request->isi,
        ]);

        return redirect()->back()->with('success', 'Balasan berhasil dikirim.');
    }
}
