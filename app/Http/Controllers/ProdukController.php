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

        // LOGIKA PENCARIAN 
        if ($request->filled('search')) {
            $keyword = $request->search;
            
            $cleanId = preg_replace('/[^0-9]/', '', $keyword);
            $cleanId = (int) $cleanId;

            $query->where('id_produk', $cleanId)
                  ->orWhere('id_produk', 'LIKE', '%' . $keyword . '%');
        }

        $produks = $query->get();

        // Jika yang login Kasir, arahkan ke folder kasir
        if (Auth::guard('kasir')->check()) {
            return view('kasir.produk.index', compact('produks'));
        }
        
        // Jika Admin, arahkan ke folder admin
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'jenis_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        // Cari produk berdasarkan ID 
        $produk = Produk::findOrFail($id);

        $data = [
            'nama_produk' => $request->nama_produk,
            'jenis_produk' => $request->jenis_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ];

        // Cek siapa yang login (untuk update history user)
        if (Auth::guard('admin')->check()) {
            $data['id_admin'] = Auth::guard('admin')->user()->id_admin;
            // $data['id_kasir'] = null; // Opsional
        } elseif (Auth::guard('kasir')->check()) {
            $data['id_kasir'] = Auth::guard('kasir')->user()->id_kasir;
            // $data['id_admin'] = null; // Opsional
        }

        $produk->update($data);

        return redirect()->back()->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        Produk::destroy($id);
        return redirect()->back()->with('success', 'Produk berhasil dihapus');
    }
}