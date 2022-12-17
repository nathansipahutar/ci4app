<?php

namespace App\Controllers;

use App\Models\TransaksiModel;

class LacakResi extends BaseController
{

    public function __construct()
    {
        // helper('form');
        // $this->validation = \Config\Services::validation();
        $this->transaksiModel = new TransaksiModel();
        $this->session = session();
        //HAPUS AJA KALAU BIKIN FITUR CRUD ERROR
    }
    public function index()
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }
        $data = [
            'title' => 'Lacak Resi',
            'transaksi' => $this->transaksiModel->findAll()
        ];
        return view('transaksi/lacakResi', $data);
    }
}
