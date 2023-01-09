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
        $this->builder = $this->db->table('user');
        $this->productsmodel = new ProductsModel();
        $this->transaksiModel = new TransaksiModel();

        //new
        helper('form');
        $this->validation = \Config\Services::validation();
        $this->session = session();
        $this->email = \Config\Services::email();
    }

    public function index()
    {
        $data['title'] = 'Admin | Bunch of Gifts';
        //cek apakah ada session bernama isLogin
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        //cek role dari session
        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }

        $this->builder->select('user.id as userid, username, role, email, no_hp');
        $query = $this->builder->get();

        //CHART
        $db = \Config\Database::connect();
        $builder = $db->table('transaksi');
        $queryYear = $builder->select("COUNT(id_transaksi) as transaksi, YEAR(created_at) as year");
        $queryYear = $builder->groupBy("YEAR(created_at)");
        $queryYear = $builder->orderBy("YEAR(created_at)", "ASC")->get();
        $record = $queryYear->getResult();
        $years = [];
        foreach ($record as $row) {
            $years[] = array(
                'year'   => $row->year,
                'id_transaksi'   => $row->transaksi,
            );
        }

        $queryMonth = $builder->select("COUNT(id_transaksi) as count, MONTHNAME(created_at) as month");
        $queryMonth = $builder->where("YEAR(created_at)=YEAR(NOW()) AND MONTH(created_at) GROUP BY MONTHNAME(created_at) ORDER BY STR_TO_DATE(CONCAT( month), '%M')")->get();
        $recordMonth = $queryMonth->getResult();
        $months = [];
        foreach ($recordMonth as $row) {
            $months[] = array(
                'month'   => $row->month,
                'id_transaksi'   => $row->count,
            );
        }

        $transaksiModel = new \App\Models\TransaksiModel();

        $pie_snack = $transaksiModel->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('products.kategori', 'bouquet')
            ->countAllResults();
        $pie_rajutan = $transaksiModel->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('products.kategori', 'rajutan')
            ->countAllResults();

        $data = [
            'users' => $query->getResult(),
            'title' => 'Dashboard | Admin',
            'statusSide' => 'dashboard',
            'years' => $years,
            'months' => $months,
            'pie_snack' => $pie_snack,
            'pie_rajutan' => $pie_rajutan
        ];
        return view('admin/index', $data);
    }

    public function detail($id = 0)
    {

        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        //cek role dari session
        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }
        $data['title'] = 'Detail User | Admin';

        $this->builder->select('users.id as userid, username, email, fullname, user_image, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.id', $id);
        $query = $this->builder->get();

        $data['user'] = $query->getRow();
        $data['statusSide'] = 'product';

        if (empty($data['user'])) {
            return redirect()->to('/admin');
        }

        return view('admin/detail', $data);
    }

    //EDIT PRODUCT
    public function products()
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        //cek role dari session
        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }
        $data = [
            'title' => 'Daftar Produk | Admin',
            'products' => $this->productsmodel->getProducts(),
            'statusSide' => 'product',
        ];

        return view('admin/products', $data);
    }

    //DELETE PRODUK
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
        return redirect()->to('/admin/products');
    }
    //TRANSAKSI ada di controller Transaksi


    //EDIT & UPDATE DATA PESANAN
    public function inputResi($id_transaksi)
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        //cek role dari session
        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }
        // session();
        $transaksiModel = new \App\Models\TransaksiModel();

        $model = $transaksiModel->join('users', 'users.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id_transaksi)
            ->first();


        $data = [
            'title' => 'Form Edit Data Pesanan | Admin',
            'statusSide' => 'pesanan',
            'validation' => \Config\Services::validation(),
            'model' => $model,
            'transaksi' => $this->transaksiModel->getTransaction($id_transaksi)
        ];
        return view('transaksi/inputResi', $data);
    }

    public function produkSelesai($id_transaksi)
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        //cek role dari session
        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }

        $transaksiModel = new \App\Models\TransaksiModel();

        $model = $transaksiModel->join('users', 'users.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id_transaksi)
            ->first();

        $status = 'Produk siap dijemput di toko';


        $this->email->setFrom('bunchofgift.id@gmail.com', 'Bunch of Gifts');

        //EMAIL INVOICE manual
        $this->email->setTo($model->email);

        // $this->email->attach($attachment);
        $this->email->SetSubject('Produk anda siap dijemput');

        $this->email->setMessage('Produk anda sudah siap untuk dijemput. Silahkan datang ke toko kami untuk menjemput produk yang Anda pesan'); // Our message above including the link


        if (!$this->email->send()) {
            session()->setFlashdata('gagal', 'Email gagal dikirim, silahkan ulangi aktivitas anda');
            return redirect()->to('/transaksi/index');
        } else {
            $transaksiModel->save([
                'id_transaksi' => $id_transaksi,
                'status' => $status,
                'kode_resi' => '-',
            ]);
            session()->setFlashdata('pesan', 'Pesan berhasil dikirim ke pelanggan');
            return redirect()->to('/transaksi/index');
        }
    }

    public function simpanResi($id_transaksi)
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        //cek role dari session
        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }

        $transaksiModel = new \App\Models\TransaksiModel();

        if (!$this->validate([
            'kode_resi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} product harus diisi,',
                ]
            ]
        ])) {
            return redirect()->to('/admin/transaksi/inputResi/' . $this->request->getVar('id_transaksi'))->withInput();
        }


        $model = $transaksiModel->join('users', 'users.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id_transaksi)
            ->first();

        $status = 'Produk sedang diantar';

        $this->email->setFrom('bunchofgift.id@gmail.com', 'Bunch of Gifts');

        //EMAIL INVOICE manual
        $this->email->setTo($model->email);

        // $this->email->attach($attachment);
        $this->email->SetSubject('Produk anda sedang dikirim!');

        $this->email->setMessage('Produk anda sedang dikirim menggunakan kurir yang anda pesan. Anda dapat melacak pesanan dengan klik link berikut ini http://localhost:8080/transaksi/user dan klik tombol lacak pesanan');

        if (!$this->email->send()) {
            session()->setFlashdata('gagal', 'Email gagal dikirim, silahkan ulangi aktivitas anda');
            return redirect()->to('/transaksi/index');
        } else {
            $transaksiModel->save([
                'id_transaksi' => $id_transaksi,
                'status' => $status,
                'kode_resi' => $this->request->getVar('kode_resi'),
            ]);
            session()->setFlashdata('pesan', 'Anda berhasil menginput resi');
            return redirect()->to('/transaksi/index');
        }
    }

    public function cekPembayaran($id_transaksi)
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        //cek role dari session
        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }
        $transaksiModel = new \App\Models\TransaksiModel();

        $model = $transaksiModel->join('users', 'users.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id_transaksi)
            ->first();

        $data = [
            'title' => 'Konfirmasi Pembayaran | Admin',
            'statusSide' => 'pesanan',
            'validation' => \Config\Services::validation(),
            'model' => $model,
            'transaksi' => $this->transaksiModel->getTransaction($id_transaksi)
        ];

        return view('admin/cekPembayaran', $data);
    }

    public function prosesProduk($id_transaksi)
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        //cek role dari session
        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }
        $transaksiModel = new \App\Models\TransaksiModel();
        $model = $transaksiModel->join('users', 'users.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id_transaksi)
            ->first();
        if ($_POST['submit'] == 'bukti salah') {
            $this->email->setFrom('bunchofgift.id@gmail.com', 'Bunch of Gifts');

            //EMAIL INVOICE manual
            $this->email->setTo($model->email);

            // $this->email->attach($attachment);
            $this->email->SetSubject('Bukti Pembayaran gagal di verifikasi');

            $this->email->setMessage('Kami mendapati bahwa bukti Pembayaran gagal di verifikasi. silahkan upload bukti pembayaran yang benar'); // Our message above including the link

            if (!$this->email->send()) {
                session()->setFlashdata('gagal', 'Email gagal dikirim, silahkan ulangi aktivitas anda');
                return redirect()->to('/transaksi/index');
            } else {
                $transaksiModel->save([
                    'id_transaksi' => $id_transaksi,
                    'bukti_bayar' => '',
                    'nama_bank' => '',
                    'atas_nama' => '',
                    'status' => 'Bukti pembayaran salah'
                ]);
                session()->setFlashdata('pesan', 'Anda berhasil membatalkan konfirmasi bukti pembayaran');
                return redirect()->to('/transaksi/index');
            }
        } else if ($_POST['submit'] == 'bukti benar') {
            $this->email->setFrom('bunchofgift.id@gmail.com', 'Bunch of Gifts');

            //EMAIL INVOICE manual
            $this->email->setTo($model->email);

            // $this->email->attach($attachment);
            $this->email->SetSubject('Bukti Pembayaran berhasil di verifikasi');

            $this->email->setMessage('Yeay! bukti pembayaran anda sudah berhasil di verifikasi, produk anda sedang diproses. Harap menunggu ya!'); // Our message above including the link

            if (!$this->email->send()) {
                session()->setFlashdata('gagal', 'Email gagal dikirim, silahkan ulangi aktivitas anda');
                return redirect()->to('/transaksi/index');
            } else {
                $transaksiModel->save([
                    'id_transaksi' => $id_transaksi,
                    'status' => 'Produk sedang diproses',
                ]);
                session()->setFlashdata('pesan', 'Pembayaran berhasil di verifikasi!');
                return redirect()->to('/transaksi/index');
            }
        }
    }

    public function laporan()
    {
        $request = service('request');
        $searchData = $request->getGet();
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        $dari = "";
        $ke = "";
        if (isset($searchData) && isset($searchData['dari'])) {
            $dari = $searchData['dari'];
        }
        if (isset($searchData) && isset($searchData['ke'])) {
            $ke = $searchData['ke'];
        }

        // Get data 
        $transaksi = new TransaksiModel();

        if ($dari == '' || $ke == '') {
            $paginateData = $transaksi->join('products', 'products.id_barang = transaksi.id_barang')
                ->join('user', 'user.id = transaksi.id_pelanggan')
                ->paginate(10);
        } else {
            $paginateData = $transaksi->select('*')
                ->join('products', 'products.id_barang = transaksi.id_barang')
                ->join('user', 'user.id = transaksi.id_pelanggan')
                ->where('transaksi.created_at >=', $dari)
                ->where('transaksi.created_at <=', $ke)
                ->paginate(10);
        }

        $data = [
            'title' => 'Laporan Penjualan | Admin',
            'statusSide' => 'laporan',
            'transaksi' => $paginateData,
            'pager' => $transaksi->pager,
            'dari' => $dari,
            'ke' => $ke,
            'currentPage' => $currentPage
        ];

        return view('admin/laporan', $data);
    }
}
