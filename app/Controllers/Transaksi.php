<?php

namespace App\Controllers;

class Transaksi extends BaseController
{
    public function __construct()
    {
        helper('form');
        // $this->validation = \Config\Services::validation();
        $this->session = session();
        //HAPUS AJA KALAU BIKIN FITUR CRUD ERROR
    }

    public function view($id)
    {
        // $id = $this->request->uri->getSegment(3);

        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $transaksiModel->join('products', 'products.id_barang=transaksi.id_barang')
            ->join('users', 'users.id=transaksi.id_pelanggan')
            // ->join('users', 'users.username=transaksi.pembeli')
            ->where('transaksi.id_transaksi', $id)
            ->first();

        return view('transaksi/view', [
            'transaksi' => $transaksi,
            'title' => 'Invoice'
        ]);
    }
}
