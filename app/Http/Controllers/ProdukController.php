<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
        public function index(Request $request)
    {
        $query = Produk::query();

        // Cek apakah ada input pencarian
        if ($request->filled('search')) {
            $keyword = $request->search;

            // Ambil angka dari ID produk misal BTK001 → 1
            $cleanId = preg_replace('/[^0-9]/', '', $keyword);
            $cleanId = (int) $cleanId;

            // Query search
            $query->where('id_produk', $cleanId);
        }

        // Ambil hasil query
        $produks = $query->get();

        // Return view terakhir
        return view('admin.produk.index', compact('produks'));
    }


        public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'jenis_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        $data = $request->all();

        // Cek siapa yang login
        if (Auth::guard('admin')->check()) {
            $data['id_admin'] = Auth::guard('admin')->user()->id_admin;
        } elseif (Auth::guard('kasir')->check()) {
            $data['id_kasir'] = Auth::guard('kasir')->user()->id_kasir;
        }

        Produk::create($data);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
    }

    public function update(Request $request)
{
    $request->validate([
        'nama_produk' => 'required',
        'jenis_produk' => 'required',
        'harga' => 'required|numeric',
        'stok' => 'required|integer',
    ]);

    $data = $request->all();

    // Cek siapa yang login
    if (Auth::guard('admin')->check()) {
        $data['id_admin'] = Auth::guard('admin')->user()->id_admin;
    } elseif (Auth::guard('kasir')->check()) {
        $data['id_kasir'] = Auth::guard('kasir')->user()->id_kasir;
    }

    Produk::create($data);

    return redirect()->back()->with('success', 'Produk berhasil diperbarui');
}

    public function destroy($id)
    {
        Produk::destroy($id);
        return redirect()->back()->with('success', 'Produk berhasil dihapus');
    }
}