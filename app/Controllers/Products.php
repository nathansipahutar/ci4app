<?php

namespace App\Controllers;

use App\Models\ProductsModel;

class Products extends BaseController
{
    protected $productsModel;
    public function __construct()
    {
        $this->productsmodel = new ProductsModel();
    }
    public function index()
    {
        // $products = $this->productsmodel->findAll();

        $data = [
            'title' => 'Daftar Product',
            'products' => $this->productsmodel->getProducts()
        ];

        // connect db pake model
        // $productsmodel = new ProductsModel();

        return view('products/index', $data);
    }

    public function detail($slug)
    {
        $products = $this->productsmodel->getProducts($slug);
        $data = [
            'title' => 'Detail Product',
            'products' => $this->productsmodel->getProducts($slug)
        ];

        // Jika product tidak ada di table
        // if (empty($data['products'])) {
        //     throw new \Codeigniter\Exceptions\PageNotFoundException('Nama product' . $slug . ' tidak ditemukan');
        //     // throw \Codeigniter\Exceptions\PageNotFoundException::forPageNotFound();
        // }
        return view('products/detail', $data);
    }

    public function create()
    {
        // session();
        $data = [
            'title' => 'Form Tambah Data Product',
            'validation' => \Config\Services::validation()
        ];
        return view('products/create', $data);
    }

    public function save()
    {

        //Validasi input agar input tidak kosong
        if (!$this->validate([
            //kalau mau nambah rules baru, tambah pake |. misal required|numeric
            'nama' => [
                'rules' => 'required|is_unique[products.nama]',
                'errors' => [
                    'required' => '{field} product harus diisi,',
                    'is_unique' => '{field} product sudah terdaftar'
                ]
            ],
            'harga' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} product harus diisi,',
                ]
            ],
            'stok' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} product harus diisi,',
                ]
            ],
            'gambar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} product harus diisi,',
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            //Dia mengirim data ke session dengan withInput dan membawa nilai validasi dari controler ke products/create.php
            return redirect()->to('/products/create')->withInput()->with('validation', $validation);
        }

        // dd($this->request->getVar());
        $slug = url_title($this->request->getVar('nama'), '-', true);
        $this->productsmodel->save([
            'nama' => $this->request->getVar('nama'),
            'slug' => $slug,
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok'),
            'gambar' => $this->request->getVar('gambar'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan!');

        return redirect()->to('/products');
    }

    public function delete($id)
    {
        $this->productsmodel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/products');
    }

    public function edit($slug)
    {
        // session();
        $data = [
            'title' => 'Form Edit Data Product',
            'validation' => \Config\Services::validation(),
            'products' => $this->productsmodel->getProducts($slug)
        ];
        return view('products/edit', $data);
    }
}
