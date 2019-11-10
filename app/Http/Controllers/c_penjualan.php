<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\m_penjualan;
use App\models\m_produk;
use PDF;

class c_penjualan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = m_penjualan::get();
        return view('penjualan', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function PDF(){
       
        // $pdf = PDF::loadview('penjualan-pdf',compact('data'));
    	// return $pdf->download('laporan-penjualan-pdf');
    }
    public function create()
    {
        $data = m_penjualan::get();    
        $pdf = PDF::loadview('penjualanpdf',compact('data'));
    	return $pdf->download('laporan-penjualan-pdf.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new m_penjualan;
        $x = 0;
        $y = '';
        foreach($request['barang'] as $a){
            $x += $a;
        }
        foreach($request['item_name'] as $b){
            $y .= $b;
        }
        for($i=0,$count=count($request['nama_produk']);$i<$count; $i++){
            $produk = m_produk::where('nama' , $request['nama_produk'][$i])->first();
            $stok = ($produk->stok - $request['barang'][$i]);
            $produk->stok = $stok;
            $produk->save();
        }
        $data->nama_produk = $y;
        $data->jumlah_barang = $x;
        $data->total_harga = $request['total'];
        $data->save();
        $data = m_produk::get();
        return view('pembayaran', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
