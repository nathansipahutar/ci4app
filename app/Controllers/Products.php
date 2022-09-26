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
            //gambar disini mengacu kepada name di input (create.php)
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            // gaperlu lagi
            // $validation = \Config\Services::validation();
            // //Dia mengirim data ke session dengan withInput dan membawa nilai validasi dari controler ke products/create.php
            // return redirect()->to('/products/create')->withInput()->with('validation', $validation);

            return redirect()->to('/products/create')->withInput();
        }

        //Ambil Gambar
        $fileGambar = $this->request->getFile('gambar');
        //Cek apakah tidak ada gambar yang diupload
        if ($fileGambar->getError() == 4) {
            $namaGambar = 'default.png';
        } else {
            //Generate nama gambar random
            $namaGambar = $fileGambar->getRandomName();
            //pindahkan file ke folder img
            $fileGambar->move('img', $namaGambar);
            //ambil nama file 
            // $namaGambar = $fileGambar->getName();
        }

        // dd($this->request->getVar());
        $slug = url_title($this->request->getVar('nama'), '-', true);
        $this->productsmodel->save([
            'nama' => $this->request->getVar('nama'),
            'slug' => $slug,
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok'),
            'gambar' => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan!');

        return redirect()->to('/products');
    }

    public function delete($id)
    {
        // Cari gambar berdasarkan id
        $products = $this->productsmodel->find($id);

        //Cek jika file gambar default.png
        if ($products['gambar'] != 'default.png') {
            //Hapus Gambar
            unlink('img/' . $products['gambar']);
        }


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

    public function update($id)
    {
        //CEK JUDUL
        $productsLama = $this->productsmodel->getProducts($this->request->getVar('slug'));
        if ($productsLama['nama'] == $this->request->getVar('nama')) {
            $rule_nama = 'required';
        } else {
            $rule_nama = 'required|is_unique[products.nama]';
        }

        if (!$this->validate([
            //kalau mau nambah rules baru, tambah pake |. misal required|numeric
            'nama' => [
                'rules' => $rule_nama,
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
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            //GUA HAPUS YA
            // $validation = \Config\Services::validation();
            //Dia mengirim data ke session dengan withInput dan membawa nilai validasi dari controler ke products/create.php
            // return redirect()->to('/product/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
            return redirect()->to('/product/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileGambar = $this->request->getFile('gambar');
        //cek Gambar, apakah tetap gambar lama
        if ($fileGambar->getError() == 4) {
            $namaGambar = $this->request->getVar('gambarLama');
        } else {
            //generate nama file random
            $namaGambar = $fileGambar->getRandomName();
            //pindahkan gambar
            $fileGambar->move('img', $namaGambar);
            //hapus file yang lama
            unlink('img/' . $this->request->getVar('gambarLama'));
        }


        $slug = url_title($this->request->getVar('nama'), '-', true);
        $this->productsmodel->save([
            'id' => $id,
            'nama' => $this->request->getVar('nama'),
            'slug' => $slug,
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok'),
            'gambar' => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah!');

        return redirect()->to('/products');
    }
}
