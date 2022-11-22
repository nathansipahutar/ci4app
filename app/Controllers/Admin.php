<?php

namespace App\Controllers;

use App\Models\ProductsModel;
use App\Models\TransaksiModel;

class Admin extends BaseController
{
    protected $db, $builder;
    protected $productsModel;

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->productsmodel = new ProductsModel();

        //new
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->transaksiModel = new TransaksiModel();
        $this->session = session();
    }
    public function index()
    {
        $data['title'] = 'User List';
        // Gabisa pake model, karena model hanya untuk satu tabel
        // $users = new \Myth\Auth\Models\UserModel();
        // $data['users'] = $users->findAll();

        // Pakai Query Builder untuk join dan ambil data dari beberapa table. 
        // initiate DB ada di construct
        $this->builder->select('users.id as userid, username, email, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $this->builder->get();

        $data['users'] = $query->getResult();
        return view('admin/index', $data);
    }

    public function detail($id = 0)
    {
        $data['title'] = 'User Detail';

        $this->builder->select('users.id as userid, username, email, fullname, user_image, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.id', $id);
        $query = $this->builder->get();

        $data['user'] = $query->getRow();

        if (empty($data['user'])) {
            return redirect()->to('/admin');
        }

        return view('admin/detail', $data);
    }

    //EDIT PRODUCT
    public function products()
    {
        // $products = $this->productsmodel->findAll();

        $data = [
            'title' => 'Daftar Product',
            'products' => $this->productsmodel->getProducts()
        ];

        // connect db pake model
        // $productsmodel = new ProductsModel();

        return view('admin/products', $data);
    }

    //TRANSAKSI ada di controller Transaksi


    //EDIT & UPDATE DATA PESANAN
    public function edit($id_transaksi)
    {
        // session();
        $transaksiModel = new \App\Models\TransaksiModel();
        // $model = $transaksiModel->findAll();

        $model = $transaksiModel->join('users', 'users.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id_transaksi)
            ->first();

        $productsModel = new \App\Models\ProductsModel();
        $products = $productsModel->getProducts();

        $transaksi = $this->transaksiModel->getTransaction($id_transaksi);
        // dd($model);
        $data = [
            'title' => 'Form Edit Data Pesanan',
            'validation' => \Config\Services::validation(),
            'model' => $model,
            'products' => $products,
            'transaksi' => $this->transaksiModel->getTransaction($id_transaksi)
        ];
        return view('transaksi/edit', $data);
    }

    public function update($id_transaksi)
    {
        $transaksiModel = new \App\Models\TransaksiModel();
        //CEK JUDUL
        // $productsLama = $this->productsmodel->getProducts($this->request->getVar('slug'));
        // if ($productsLama['nama'] == $this->request->getVar('nama')) {
        //     $rule_nama = 'required';
        // } else {
        //     $rule_nama = 'required|is_unique[products.nama]';
        // }

        if (!$this->validate([
            //kalau mau nambah rules baru, tambah pake |. misal required|numeric
            // 'nama' => [
            //     'rules' => $rule_nama,
            //     'errors' => [
            //         'required' => '{field} product harus diisi,',
            //         'is_unique' => '{field} product sudah terdaftar'
            //     ]
            // ],
            // 'nama' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => '{field} product harus diisi,',
            //     ]
            // ],
            // 'pembeli' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => '{field} product harus diisi,',
            //     ]
            // ],
            // 'alamat' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => '{field} product harus diisi,',
            //     ]
            // ],
            // 'jumlah' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => '{field} product harus diisi,',
            //     ]
            // ],
            // 'harga' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => '{field} product harus diisi,',
            //     ]
            // ],
            'kode_resi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} product harus diisi,',
                ]
            ]
        ])) {
            //GUA HAPUS YA
            // $validation = \Config\Services::validation();
            //Dia mengirim data ke session dengan withInput dan membawa nilai validasi dari controler ke products/create.php
            // return redirect()->to('/product/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
            return redirect()->to('/admin/transaksi/edit/' . $this->request->getVar('id_transaksi'))->withInput();
        }

        // $fileGambar = $this->request->getFile('gambar');
        // //cek Gambar, apakah tetap gambar lama
        // if ($fileGambar->getError() == 4) {
        //     $namaGambar = $this->request->getVar('gambarLama');
        // } else {
        //     //generate nama file random
        //     $namaGambar = $fileGambar->getRandomName();
        //     //pindahkan gambar
        //     $fileGambar->move('img', $namaGambar);
        //     //hapus file yang lama
        //     unlink('img/' . $this->request->getVar('gambarLama'));
        // }


        // $slug = url_title($this->request->getVar('nama'), '-', true);
        $transaksiModel->save([
            // nama, pembeli, alamat, jumlah, harga, kode_resi
            'id_transaksi' => $id_transaksi,
            'status' => $this->request->getVar('status'),
            'kode_resi' => $this->request->getVar('kode_resi'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah!');

        return redirect()->to('/transaksi/index');
    }

    public function laporanPenjualan()
    {
        $data['title'] = 'Laporan Penjualan';

        $transaksiModel = new \App\Models\TransaksiModel();
        $id = $this->session->get('logged_in');
        // $model = $transaksiModel->where('id_transaksi', 2);
        // $model = $transaksiModel->findAll();

        $model = $transaksiModel->join('users', 'users.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.created_at' <= 'txtTglAwal')
            ->findAll();

        // var_dump($model);
        $productsModel = new \App\Models\ProductsModel();
        $products = $productsModel->getProducts();

        return view('admin/laporanPenjualan', [
            'model' => $model,
            'products' => $products,
            'title' => 'List Transaksi',
        ]);
    }

    public function filterLaporanPenjualan()
    {
        $transaksiModel = new \App\Models\TransaksiModel();
        $id = $this->session->get('logged_in');
        // $model = $transaksiModel->where('id_transaksi', 2);
        // $model = $transaksiModel->findAll();

        $model = $transaksiModel->join('users', 'users.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.created_at' <= 'txtTglAwal')
            ->findAll();

        // var_dump($model);
        $productsModel = new \App\Models\ProductsModel();
        $products = $productsModel->getProducts();
        return view('admin/cobaLaporan', [
            'model' => $model,
            'products' => $products,
            'title' => 'List Transaksi',
        ]);
    }
}
