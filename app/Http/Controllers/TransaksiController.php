<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    // Halaman Utama Kasir 
    public function index()
    {
        $produks = Produk::where('stok', '>', 0)->get(); // Hanya tampilkan yg ada stok
        $cart = session()->get('cart', []);
        
        $total = 0;
        foreach($cart as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        return view('kasir.transaksi', compact('produks', 'cart', 'total'));
    }

    // Tambah ke Keranjang
    public function addToCart(Request $request)
    {
        $produk = Produk::find($request->id_produk);
        $cart = session()->get('cart', []);

        // Jika produk sudah ada di keranjang, tambah qty
        if(isset($cart[$request->id_produk])) {
            // Cek stok dulu
            if($cart[$request->id_produk]['qty'] + 1 > $produk->stok) {
                return redirect()->back()->withErrors(['stok' => 'Stok tidak mencukupi!']);
            }
            $cart[$request->id_produk]['qty']++;
        } else {
            // Jika belum ada, masukkan baru
            $cart[$request->id_produk] = [
                "nama_produk" => $produk->nama_produk,
                "qty" => 1,
                "harga" => $produk->harga,
                "id_produk" => $produk->id_produk
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back();
    }

    // Hapus dari Keranjang
    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }

    // Proses Checkout (Simpan ke DB)
    public function checkout()
    {
        $cart = session()->get('cart');
        if(!$cart) {
            return redirect()->back()->withErrors(['error' => 'Keranjang kosong!']);
        }

        DB::transaction(function () use ($cart) {
            $totalHarga = 0;
            foreach($cart as $item) $totalHarga += $item['harga'] * $item['qty'];

            // 1. Buat Data Penjualan
            $penjualan = Penjualan::create([
                'no_invoice' => 'INV-' . time(), // Generate Invoice Unik
                'tanggal_penjualan' => Carbon::now(),
                'total_harga' => $totalHarga,
                'id_kasir' => Auth::guard('kasir')->user()->id_kasir,
            ]);

            // 2. Loop Keranjang untuk Detail Penjualan & Kurangi Stok
            foreach($cart as $id => $details) {
                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id_penjualan,
                    'id_produk' => $id,
                    'jumlah' => $details['qty'],
                    'subtotal' => $details['harga'] * $details['qty']
                ]);

                // Kurangi Stok
                $produk = Produk::find($id);
                $produk->decrement('stok', $details['qty']);
            }
        });

        session()->forget('cart'); // Kosongkan keranjang
        return redirect()->back()->with('success', 'Transaksi Berhasil Disimpan!');
    }

    public function riwayat()
{
    // Ambil data penjualan HANYA milik kasir yang sedang login
    $id_kasir = Auth::guard('kasir')->user()->id_kasir;
    
    $penjualans = Penjualan::where('id_kasir', $id_kasir)
                    ->orderBy('created_at', 'desc')
                    ->get();

    // Hitung total pendapatan kasir
    $totalPendapatan = $penjualans->sum('total_harga');
    $totalTransaksi = $penjualans->count();

    return view('kasir.riwayat', compact('penjualans', 'totalPendapatan', 'totalTransaksi'));
}
}