<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Kasir;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\DetailPenjualan;

class AdminController extends Controller
{
    public function dashboard() {
        $today = Carbon::today();
        
        // Hitung Pendapatan Harian, Bulanan, Tahunan 
        $incomeToday = Penjualan::whereDate('tanggal_penjualan', $today)->sum('total_harga');
        $incomeMonth = Penjualan::whereMonth('tanggal_penjualan', $today->month)
                                ->whereYear('tanggal_penjualan', $today->year)->sum('total_harga');
        $incomeYear = Penjualan::whereYear('tanggal_penjualan', $today->year)->sum('total_harga');
        
        $totalTransaksi = Penjualan::count();

        return view('admin.dashboard', compact('incomeToday', 'incomeMonth', 'incomeYear', 'totalTransaksi'));
    }

    // Menampilkan halaman manajemen kasir
public function indexKasir(Request $request) {
    // Mulai Query
    $query = Kasir::query();

    // Jika ada input 'search' dari form
    if ($request->has('search')) {
        $query->where('username', 'LIKE', '%' . $request->search . '%');
    }

    $kasirs = $query->get();
    return view('admin.kasir.index', compact('kasirs'));
}

// Menyimpan kasir baru
public function storeKasir(Request $request) {
    $request->validate([
        'nama_kasir' => 'required',
        'username' => 'required|unique:kasirs',
        'password' => 'required|min:6'
    ]);

    Kasir::create([
        'nama_kasir' => $request->nama_kasir,
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'id_admin' => auth()->guard('admin')->user()->id_admin // Admin yang sedang login
    ]);

    return redirect()->back()->with('success', 'Data Kasir berhasil ditambahkan!');
}

// Update data kasir
public function updateKasir(Request $request, $id) {
    $kasir = Kasir::findOrFail($id);
    
    $data = [
        'nama_kasir' => $request->nama_kasir,
        'username' => $request->username,
    ];

    // Jika password diisi, maka update password. Jika kosong, biarkan.
    if($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $kasir->update($data);
    return redirect()->back()->with('success', 'Data Kasir berhasil diperbarui!');
}

// Hapus kasir
public function destroyKasir($id) {
    Kasir::destroy($id);
    return redirect()->back()->with('success', 'Kasir berhasil dihapus!');
}

// Method Menampilkan Daftar Penjualan
public function laporanPenjualan(Request $request)
{
    $query = Penjualan::with('kasir');

    if ($request->filled('search')) {
        $query->where('no_invoice', 'LIKE', '%' . $request->search . '%');
    }

    $penjualans = $query->orderBy('created_at', 'desc')->get();

    return view('admin.penjualan.index', compact('penjualans'));
}


// Method Edit Penjualan (Menampilkan Form)
public function editPenjualan($id)
{
    $penjualan = Penjualan::with(['details.produk', 'kasir'])->findOrFail($id);
    return view('admin.penjualan.edit', compact('penjualan'));
}

// Method Update Penjualan (Menyimpan Perubahan)
public function updatePenjualan(Request $request, $id)
{
    $penjualan = Penjualan::findOrFail($id);
    // Mengubah tanggal (sesuai kebutuhan admin)
    $penjualan->update([
        'tanggal_penjualan' => $request->tanggal_penjualan,
    ]);
    return redirect()->route('admin.penjualan')->with('success', 'Data penjualan diperbarui');
}

// // Method Hapus Penjualan
// public function destroyPenjualan($id)
// {
//     // Hapus penjualan akan otomatis menghapus detail
//     $penjualan = Penjualan::with('details')->findOrFail($id);
//     foreach($penjualan->details as $detail) {
//         $produk = \App\Models\Produk::find($detail->id_produk);
//         if($produk) {
//             $produk->increment('stok', $detail->jumlah); // Kembalikan stok
//         }
//     }
//     $penjualan->delete();
    
//     return redirect()->back()->with('success', 'Transaksi dihapus dan stok dikembalikan.');
// }
}

