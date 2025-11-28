<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $produks = Produk::all();
        return view('admin.produk.index', compact('produks'));

        $query = Produk::query();

        if ($request->has('search') && $request->search != null) {
            $keyword = $request->search;
        
            // Logika hapus 'BTK' dan '0' di depan jika user mencari format kode lengkap
            // Contoh: User ketik "BTK005" -> Sistem cari ID 5
            $cleanId = preg_replace('/[^0-9]/', '', $keyword); 
            $cleanId = (int)$cleanId; // Ubah '005' jadi 5

            $query->where('id_produk', $cleanId)
                ->orWhere('id_produk', 'LIKE', "%$keyword%") // Cari angka langsung
                ->orWhere('nama_produk', 'LIKE', "%$keyword%"); // Bonus: Cari nama juga
        }

        $produks = $query->get();
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