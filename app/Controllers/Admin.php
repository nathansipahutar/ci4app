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
        // Gabisa pake model, karena model hanya untuk satu tabel
        // $users = new \Myth\Auth\Models\UserModel();
        // $data['users'] = $users->findAll();

        // Pakai Query Builder untuk join dan ambil data dari beberapa table. 
        // initiate DB ada di construct
        $this->builder->select('user.id as userid, username, email, no_hp');
        $query = $this->builder->get();

        //CHART
        $db = \Config\Database::connect();
        $builder = $db->table('transaksi');
        $queryYear = $builder->select("COUNT(id_transaksi) as transaksi, YEAR(created_at) as year");
        $queryYear = $builder->where("YEAR(created_at) GROUP BY YEAR(created_at) ORDER BY str_to_date(concat(year), '%Y')")->get();
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
            'title' => 'Chart',
            'years' => $years,
            'months' => $months,
            'pie_snack' => $pie_snack,
            'pie_rajutan' => $pie_rajutan
        ];
        return view('admin/index', $data);
    }

    //Chart
    // public function chart()
    // {
    //     $db = \Config\Database::connect();
    //     $builder = $db->table('transaksi');
    //     $query = $builder->select("COUNT(id_transaksi) as transaksi, YEAR(created_at) as year");
    //     $query = $builder->where("YEAR(created_at) GROUP BY YEAR(created_at) ORDER BY str_to_date(concat(year), '%Y')")->get();
    //     $record = $query->getResult();
    //     $years = [];
    //     foreach ($record as $row) {
    //         $years[] = array(
    //             'year'   => $row->year,
    //             'id_transaksi'   => $row->transaksi,
    //         );
    //     }

    //     $queryMonth = $builder->select("COUNT(id_transaksi) as count, MONTHNAME(created_at) as month");
    //     $queryMonth = $builder->where("YEAR(created_at)=YEAR(NOW()) AND MONTH(created_at) GROUP BY MONTHNAME(created_at) ORDER BY STR_TO_DATE(CONCAT( month), '%M')")->get();
    //     $recordMonth = $queryMonth->getResult();
    //     $months = [];
    //     foreach ($recordMonth as $row) {
    //         $months[] = array(
    //             'month'   => $row->month,
    //             'id_transaksi'   => $row->count,
    //         );
    //     }

    //     $transaksiModel = new \App\Models\TransaksiModel();

    //     $pie_snack = $transaksiModel->join('products', 'products.id_barang=transaksi.id_barang')
    //         ->where('products.kategori', 'bouquet')
    //         ->countAllResults();
    //     $pie_rajutan = $transaksiModel->join('products', 'products.id_barang=transaksi.id_barang')
    //         ->where('products.kategori', 'rajutan')
    //         ->countAllResults();

    //     $data = [
    //         'title' => 'Chart',
    //         'years' => $years,
    //         'months' => $months,
    //         'pie_snack' => $pie_snack,
    //         'pie_rajutan' => $pie_rajutan
    //     ];
    //     return view('admin/chartYt', $data);
    // }

    public function detail($id = 0)
    {

        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        //cek role dari session
        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }
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
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        //cek role dari session
        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }
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
        // $model = $transaksiModel->findAll();

        $model = $transaksiModel->join('users', 'users.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id_transaksi)
            ->first();


        $data = [
            'title' => 'Form Edit Data Pesanan',
            'validation' => \Config\Services::validation(),
            'model' => $model,
            'transaksi' => $this->transaksiModel->getTransaction($id_transaksi)
        ];
        return view('transaksi/inputResi', $data);
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
            //GUA HAPUS YA
            // $validation = \Config\Services::validation();
            //Dia mengirim data ke session dengan withInput dan membawa nilai validasi dari controler ke products/create.php
            // return redirect()->to('/product/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
            return redirect()->to('/admin/transaksi/inputResi/' . $this->request->getVar('id_transaksi'))->withInput();
        }


        $model = $transaksiModel->join('users', 'users.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id_transaksi)
            ->first();

        if ($model->metode_pengiriman == 'Diantar Kurir') {
            $status = 'Produk sedang diantar';
        } else {
            $status = 'Produk siap dijemput di toko';
        }


        //BENERIN EMAIL
        $this->email->setFrom('bunchofgift.id@gmail.com', 'Bunch of Gifts');
        //EMAIL INVOICE manual
        // $this->email->setTo('captaintsubasa1611@gmail.com');
        $this->email->setTo($model->email);

        // $this->email->attach($attachment);
        $this->email->SetSubject('Produk anda sedang dikirim!');

        if ($model->metode_pengiriman == 'Diantar Kurir') {
            $this->email->setMessage('Produk anda sedang dikirim menggunakan kurir yang anda pesan. Anda dapat melacak pesanan dengan klik link berikut ini http://localhost:8080/transaksi/user dan klik tombol lacak pesanan'); // Our message above including the link
        } else {
            $this->email->setMessage('Produk anda sudah siap untuk dijemput. Silahkan datang ke toko kami untuk menjemput produk yang Anda pesan'); // Our message above including the link
        }

        if (!$this->email->send()) {
            session()->setFlashdata('gagal', 'Email gagal dikirim, silahkan ulangi aktivitas anda');
            return redirect()->to('/transaksi/index');
        } else {
            $transaksiModel->save([
                // nama, pembeli, alamat, jumlah, harga, kode_resi
                'id_transaksi' => $id_transaksi,
                'status' => $status,
                'kode_resi' => $this->request->getVar('kode_resi'),
            ]);
            session()->setFlashdata('pesan', 'Kamu berhasil menginput resi');
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
            'validation' => \Config\Services::validation(),
            'model' => $model,
            // 'products' => $products,
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
        if ($_POST['submit'] == 'bukti_salah') {
            //BENERIN EMAIL
            $this->email->setFrom('bunchofgift.id@gmail.com', 'Bunch of Gifts');
            //EMAIL INVOICE manual
            // $this->email->setTo('captaintsubasa1611@gmail.com');
            $this->email->setTo($model->email);

            // $this->email->attach($attachment);
            $this->email->SetSubject('Bukti Pembayaran gagal di verifikasi');

            $this->email->setMessage('Kami mendapati bahwa bukti Pembayaran gagal di verifikasi. silahkan upload bukti pembayaran yang benar'); // Our message above including the link

            if (!$this->email->send()) {
                session()->setFlashdata('gagal', 'Email gagal dikirim, silahkan ulangi aktivitas anda');
                return redirect()->to('/transaksi/index');
            } else {
                $transaksiModel->save([
                    // nama, pembeli, alamat, jumlah, harga, kode_resi
                    'id_transaksi' => $id_transaksi,
                    'bukti_bayar' => '',
                    'nama_bank' => '',
                    'atas_nama' => '',
                    'status' => 'Bukti pembayaran salah'
                ]);
                session()->setFlashdata('pesan', 'Kamu berhasil membatalkan konfirmasi bukti pembayaran');
                return redirect()->to('/transaksi/index');
            }
        } else if ($_POST['submit'] == 'bukti_benar') {
            //BENERIN EMAIL
            $this->email->setFrom('bunchofgift.id@gmail.com', 'Bunch of Gifts');
            //EMAIL INVOICE manual
            // $this->email->setTo('captaintsubasa1611@gmail.com');
            $this->email->setTo($model->email);

            // $this->email->attach($attachment);
            $this->email->SetSubject('Bukti Pembayaran berhasil di verifikasi');

            $this->email->setMessage('Yeay! bukti pembayaran anda sudah berhasil di verifikasi, produk anda sedang diproses. Harap menunggu ya!'); // Our message above including the link

            if (!$this->email->send()) {
                session()->setFlashdata('gagal', 'Email gagal dikirim, silahkan ulangi aktivitas anda');
                return redirect()->to('/transaksi/index');
            } else {
                $transaksiModel->save([
                    // nama, pembeli, alamat, jumlah, harga, kode_resi
                    'id_transaksi' => $id_transaksi,
                    'status' => 'Produk sedang diproses',
                ]);
                session()->setFlashdata('pesan', 'Pembayaran berhasil di verifikasi!');
                return redirect()->to('/transaksi/index');
            }
        }
    }

    //Laporan yang berhasil tapi pagination untuk search belom berhasil
    // public function laporan()
    // {
    //     $servername     = "localhost";
    //     $database       = "bunch_of_gifts";
    //     $username       = "root";
    //     $password       = "";
    //     $conn = mysqli_connect($servername, $username, $password, $database);

    //     //pagination
    //     $batas = 10;
    //     $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
    //     $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

    //     $previous = $halaman - 1;
    //     $next = $halaman + 1;


    //     // $data = mysqli_query($koneksi, "select * from pegawai");

    //     //jika tanggal dari dan tanggal ke ada maka
    //     if (isset($_GET['dari']) && isset($_GET['ke'])) {
    //         // tampilkan data yang sesuai dengan range tanggal yang dicari 

    //         $dari = $_GET['dari'];
    //         $ke = $_GET['ke'];
    //         // d($_GET['dari']);
    //         // d($_GET['ke']);
    //         d('2022-11-01');
    //         d($dari);
    //         d($ke);
    //         // $data = mysqli_query($conn, "SELECT A.*, B.nama, B.kategori, C.username FROM transaksi A LEFT JOIN products B ON A.id_barang=B.id_barang LEFT JOIN user C ON A.id_pelanggan=C.id WHERE A.created_at <= $dari AND A.created_at >= $ke");
    //         $data = mysqli_query($conn, "SELECT A.*, B.nama, B.kategori, C.username FROM transaksi A LEFT JOIN products B ON A.id_barang=B.id_barang LEFT JOIN user C ON A.id_pelanggan=C.id WHERE A.created_at BETWEEN $dari AND $ke LIMIT $halaman_awal, $batas");
    //         // $data = mysqli_query($conn, "SELECT A.*, B.nama, B.kategori, C.username FROM transaksi A LEFT JOIN products B ON A.id_barang=B.id_barang LEFT JOIN user C ON A.id_pelanggan=C.id WHERE A.created_at BETWEEN '2022-11-01' AND '2022-12-01' LIMIT $halaman_awal, $batas");
    //         // $data = mysqli_query($conn, "SELECT A.*, B.nama, B.kategori, C.username FROM transaksi A LEFT JOIN products B ON A.id_barang=B.id_barang LEFT JOIN user C ON A.id_pelanggan=C.id WHERE A.created_at BETWEEN '" . $_GET['dari'] . "' and '" . $_GET['ke'] . "' LIMIT $halaman_awal, $batas");
    //         $dataCount = mysqli_query($conn, "SELECT A.*, B.nama, B.kategori, C.username FROM transaksi A LEFT JOIN products B ON A.id_barang=B.id_barang LEFT JOIN user C ON A.id_pelanggan=C.id WHERE A.created_at BETWEEN '" . $_GET['dari'] . "' and '" . $_GET['ke'] . "'");
    //         $jumlah_data = mysqli_num_rows($dataCount);
    //         $numbering = 'periode';
    //         // print_r($jumlah_data);
    //         // $data = mysqli_query($conn, "SELECT * FROM transaksi WHERE created_at BETWEEN '" . $_GET['dari'] . "' and '" . $_GET['ke'] . "'");
    //     } else {
    //         //jika tidak ada tanggal dari dan tanggal ke maka tampilkan seluruh data
    //         $data = mysqli_query($conn, "SELECT A.*, B.nama, B.kategori, C.username FROM transaksi A LEFT JOIN products B ON A.id_barang=B.id_barang LEFT JOIN user C ON A.id_pelanggan=C.id LIMIT $halaman_awal, $batas");
    //         // print_r($data);
    //         $dataCount = mysqli_query($conn, "SELECT A.*, B.nama, B.kategori, C.username FROM transaksi A LEFT JOIN products B ON A.id_barang=B.id_barang LEFT JOIN user C ON A.id_pelanggan=C.id");
    //         $jumlah_data = mysqli_num_rows($dataCount);
    //         $numbering = 'full';
    //         // print_r($numbering);
    //     }

    //     // dd($jumlah_data);
    //     $total_halaman = ceil($jumlah_data / $batas);
    //     d('halaman = ' . $halaman . '');
    //     d('halaman = ' . $total_halaman . '');
    //     // d($total_halaman);
    //     $nomor = $halaman_awal + 1;
    //     d($this->request->getVar('dari'));
    //     d($this->request->getVar('ke'));

    //     return view('admin/laporan', [
    //         'title' => 'Laporan Penjualan',
    //         'data' => $data,
    //         'halaman' => $halaman,
    //         'total_halaman' => $total_halaman,
    //         'previous' => $previous,
    //         'next' => $next,
    //         'numbering' => $numbering
    //         // 'laporan_pager' => $transaksiModel->paginate(5),
    //         // 'pager' => $transaksiModel->pager
    //     ]);
    // }

    //pagination coba2
    public function cobaLaporan()
    {

        $dari = $this->request->getVar('dari');
        $ke = $this->request->getVar('ke');
        d($this->request->getVar('dari'));
        d($this->request->getVar('ke'));

        if ($dari && $ke) {
            $transaksi = $this->transaksiModel->search($dari, $ke);
        } else {
            $transaksi = $this->transaksiModel;
        }

        $currentPage = $this->request->getVar('page_transaksi') ? $this->request->getVar('page_transaksi') : 1;
        $data = [
            'title' => 'Coba Laporan',
            // 'transaksi' => $this->transaksiModel->findAll()
            'transaksi' => $transaksi->paginate(10, 'transaksi'),
            'pager' => $this->transaksiModel->pager,
            'currentPage' => $currentPage
        ];

        // $data['title'] = 'Laporan Penjualan';
        // $data['transaksi'] = $this->transaksiModel->getPaginated(10);
        // $transaksi = $this->transaksiModel->getPaginated(30);
        // dd($transaksi['transaksi']);
        return view('admin/cobaLaporan', $data);
    }

    public function laporan()
    {
        $request = service('request');
        $searchData = $request->getGet();
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        // d($currentPage);

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
            'title' => 'Laporan Penjualan',
            'transaksi' => $paginateData,
            'pager' => $transaksi->pager,
            'dari' => $dari,
            'ke' => $ke,
            'currentPage' => $currentPage
        ];

        return view('admin/laporan', $data);
    }
}
