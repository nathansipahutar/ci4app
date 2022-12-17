<?php

namespace App\Controllers;

use App\Models\ProductsModel;

class Products extends BaseController
{
    private $url = 'https://api.rajaongkir.com/starter/';
    private $apiKey = '2a9dfab14e094497fa344f8cf2a754f3';
    protected $productsModel;

    public function __construct()
    {
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->productsmodel = new ProductsModel();
        $this->session = session();
        //HAPUS AJA KALAU BIKIN FITUR CRUD ERROR
    }

    //Tampilan list produk
    public function snack()
    {
        //cek apakah ada session bernama isLogin
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        // $products = $this->productsmodel->findAll();
        $products_snack = $this->productsmodel->getProductsSnack();
        $products_snack = $this->productsmodel->getProductsSnack();
        $data = [
            'title' => 'Daftar Product',
            'products' => $this->productsmodel->getProducts(),
            'products_snack' => $this->productsmodel->getProductsSnack(),
        ];

        // connect db pake model
        // $productsmodel = new ProductsModel();

        return view('products/snack', $data);
    }
    public function rajutan()
    {
        //cek apakah ada session bernama isLogin
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        // $products = $this->productsmodel->findAll();
        $products_snack = $this->productsmodel->getProductsSnack();
        $products_snack = $this->productsmodel->getProductsSnack();
        $data = [
            'title' => 'Daftar Product',
            'products' => $this->productsmodel->getProducts(),
            'products_rajutan' => $this->productsmodel->getProductsRajutan()
        ];

        // connect db pake model
        // $productsmodel = new ProductsModel();

        return view('products/rajutan', $data);
    }

    //kyknya gaperlu
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

    //Tampilan form tambah produk
    public function create()
    {
        //cek apakah ada session bernama isLogin
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        //cek role dari session
        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }

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
            'deskripsi' => [
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
            'kategori' => $this->request->getVar('kategori'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'harga' => $this->request->getVar('harga'),
            'gambar' => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan!');

        return redirect()->to('/products');
    }

    public function delete($id)
    {
        //cek apakah ada session bernama isLogin
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        //cek role dari session
        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }
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
        //cek apakah ada session bernama isLogin
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        //cek role dari session
        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }
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
            'deskripsi' => [
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
            'id_barang' => $id,
            'nama' => $this->request->getVar('nama'),
            'slug' => $slug,
            'kategori' => $this->request->getVar('kategori'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'harga' => $this->request->getVar('harga'),
            'gambar' => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah!');

        return redirect()->to('/products');
    }

    //Tampilan beli produk (Perlu dihapus kah?)
    public function beli($slug)
    {
        //cek apakah ada session bernama isLogin
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        $products = $this->productsmodel->getProducts($slug);
        $provinsi = $this->rajaongkir('province');
        $data = [
            'title' => 'Beli Barang',
            'products' => $this->productsmodel->getProducts($slug),
            'provinsi' => json_decode($provinsi)->rajaongkir->results,
        ];

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $this->validation->run($data, 'transaksi');
            $errors = $this->validation->getErrors();

            if (!$errors) {
                $transaksiModel = new \App\Models\TransaksiModel();
                $transaksi = new \App\Entities\Transaksi();

                $transaksi->fill($data);
                $transaksi->status = 'Belum dibayar';
                $transaksi->metode_pengiriman = 'Diantar Kurir';
                $transaksi->id_pelanggan = $this->session->get('id');
                $transaksi->no_hp = $this->session->get('no_hp');
                // $transaksi->created_at = $this->session->get('logged_in');
                $transaksi->created_date = date("Y-m-d H:i:s");

                $transaksiModel->save($transaksi);

                //ambil id transaksi model, yg diinsert berapa
                $id = $transaksiModel->insertID();
                //buka view dari controller transaksi
                $segment = ['transaksi', 'view', $id];

                return redirect()->to(site_url($segment));
            }
        }
        // $provinsi = $this->rajaongkir('province');
        return view('products/beli', $data);
    }
    public function beli2($slug)
    {
        //cek apakah ada session bernama isLogin
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        // dd($this->session->get('no_hp'));
        // $idBarang = $this->productsmodel->getProducts($slug);
        // $idBarang['id_barang'];
        // dd($test['id_barang']);

        $data = [
            'title' => 'Beli Produk Jemput | Bunch of Gifts',
            'products' => $this->productsmodel->getProducts($slug),
        ];

        // $provinsi = $this->rajaongkir('province');
        return view('products/beli2', $data);
    }

    public function saveJemput()
    {
        $data = $this->request->getPost();
        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = new \App\Entities\Transaksi();

        $transaksi->fill($data);
        $transaksi->id_pelanggan = $this->session->get('id');
        $transaksi->no_hp = $this->session->get('no_hp');
        $transaksi->alamat = '-';
        $transaksi->metode_pengiriman = 'Dijemput ke toko';
        $transaksi->ongkir = 0;
        $transaksi->status = 'Belum dibayar';
        // $transaksi->created_at = $this->session->get('logged_in');
        $transaksi->created_date = date("Y-m-d H:i:s");

        $transaksiModel->save($transaksi);

        //ambil id transaksi model, yg diinsert berapa
        $id = $transaksiModel->insertID();
        //buka view dari controller transaksi
        $segment = ['transaksi', 'view', $id];

        return redirect()->to(site_url($segment));

        // dd($data);
        // $this->$transaksiModel::save([
        //     'id_pelanggan' => $this->session->get('id'),
        //     'id_barang' => $this->request->getVar('id_barang'),
        //     'no_hp' => $this->session->get('no_hp'),
        //     'alamat' => '-',
        //     'jumlah' => $this->request->getVar('jumlah'),
        //     'metode_pengiriman' => 'Dijemput ke toko',
        //     'ongkir' => 0,
        //     'total_harga' => $this->request->getVar('total_harga'),
        //     'status' => 'Belum dibayar'
        // ]);

        // $id = $this->request->getVar('id_barang');
        // //buka view dari controller transaksi
        // $segment = ['transaksi', 'view', $id];

        // return redirect()->to(site_url($segment));

        // return redirect()->to('/products');
    }

    public function getCity()
    {
        $id_province = $this->request->getGET('id_province');
        $data = $this->rajaongkir('city', $id_province);
        return $this->response->setJSON($data);
        // if ($this->request->isAJAX()) {
        //     $id_province = $this->request->getGET('id_province');
        //     $data = $this->rajaongkir('city', $id_province);
        //     return $this->response->setJSON($data);
        // }
    }

    public function getCost()
    {
        if ($this->request->isAJAX()) {
            $origin = $this->request->getGET('origin');
            $destination = $this->request->getGET('destination');
            $weight = $this->request->getGET('weight');
            $courier = $this->request->getGET('courier');
            $data = $this->rajaongkircost($origin, $destination, $weight, $courier);
            return $this->response->setJSON($data);
        }
    }

    private function rajaongkircost($origin, $destination, $weight, $courier)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=" . $origin . "&destination=" . $destination . "&weight=" . $weight . "&courier=" . $courier . "",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: " . $this->apiKey,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     echo $response;
        // }

        return $response;
    }

    private function rajaongkir($method, $id_province = null)
    {
        $endPoint = $this->url . $method;

        if ($id_province != null) {
            $endPoint = $endPoint . "?province=" . $id_province;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $endPoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: " . $this->apiKey,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return $response;
    }
}
