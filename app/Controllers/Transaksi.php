<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use TCPDF;

class Transaksi extends BaseController
{
    public function __construct()
    {
        helper('form');
        // $this->validation = \Config\Services::validation();
        $this->session = session();

        //EMAIL INVOICE
        $this->email = \Config\Services::email();

        $this->transaksiModel = new TransaksiModel();
    }

    //Tampilan pemesanan berhasil dilakukan
    public function view($id)
    {
        // $id = $this->request->uri->getSegment(3);

        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $transaksiModel->join('products', 'products.id_barang=transaksi.id_barang')
            ->join('user', 'user.id=transaksi.id_pelanggan')
            // ->join('users', 'users.username=transaksi.pembeli')
            ->where('transaksi.id_transaksi', $id)
            ->first();

        return view('transaksi/view', [
            'transaksi' => $transaksi,
            'title' => 'Invoice'
        ]);
    }

    //Tampilan list transaksi untuk ADMIN
    public function index()
    {
        //cek apakah ada session bernama isLogin
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        //cek role dari session
        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }

        $transaksiModel = new \App\Models\TransaksiModel();
        // $model = $transaksiModel->findAll();

        $model = $transaksiModel->join('user', 'user.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            // ->where('transaksi.status', 'Berhasil Dibayar')
            ->get();

        return view('transaksi/index', [
            'model' => $model,
            'title' => 'List Transaksi',
        ]);
    }

    //Tampilan list transaksi untuk USER
    public function user()
    {
        //cek apakah ada session bernama isLogin
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        $id = $this->session->get('id');
        $transaksiModel = new \App\Models\TransaksiModel();
        // $model = $transaksiModel->where('id_transaksi', 2);
        // $model = $transaksiModel->findAll();

        $model = $transaksiModel->join('user', 'user.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.id_pelanggan', $id)
            // ->where('transaksi.status', 'Belum dibayar')
            ->findAll();

        // var_dump($model);
        $productsModel = new \App\Models\ProductsModel();
        $products = $productsModel->getProducts();
        return view('transaksi/user', [
            'model' => $model,
            'products' => $products,
            'title' => 'List Transaksi',
        ]);
    }

    //USER CANCEL PESANAN
    public function delete($id_transaksi)
    {
        //cek apakah ada session bernama isLogin
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        $this->transaksiModel->delete($id_transaksi);
        session()->setFlashdata('gagal', 'Anda Berhasil mengcancel pesanan');
        return redirect()->to('/transaksi/user');
    }

    //START FITUR BAYAR
    public function bayar($id_transaksi)
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        $transaksiModel = new \App\Models\TransaksiModel();
        // $model = $transaksiModel->findAll();

        $model = $transaksiModel->join('users', 'users.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id_transaksi)
            ->first();

        $productsModel = new \App\Models\ProductsModel();
        $products = $productsModel->getProducts();

        $transaksi = $this->transaksiModel->getTransaction($id_transaksi);
        // dd($transaksi);
        // dd($model);
        $data = [
            'title' => 'Bayar Pesanan | Bunch of Gifts',
            'validation' => \Config\Services::validation(),
            'model' => $model,
            'products' => $products,
            'transaksi' => $this->transaksiModel->getTransaction($id_transaksi)
        ];
        return view('transaksi/bayar', $data);
    }

    public function submitBayar($id_transaksi)
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        $transaksiModel = new \App\Models\TransaksiModel();

        if (!$this->validate([
            'nama_bank' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} product harus diisi,',
                ]
            ],
            'atas_nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} product harus diisi,',
                ]
            ],
            'bukti_bayar' => [
                'rules' => 'max_size[bukti_bayar,1024]|is_image[bukti_bayar]|mime_in[bukti_bayar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            return redirect()->to('/transaksi/bayar/' . $id_transaksi)->withInput();
        }

        $fileBuktiBayar = $this->request->getFile('bukti_bayar');
        //Cek apakah tidak ada gambar yang diupload
        if ($fileBuktiBayar->getError() == 4) {
            $namaGambar = 'default.png';
        } else {
            //Generate nama gambar random
            $namaGambar = $fileBuktiBayar->getRandomName();
            //pindahkan file ke folder img
            $fileBuktiBayar->move('img', $namaGambar);
            //ambil nama file 
            // $namaGambar = $fileBuktiBayar->getName();
        }

        // $slug = url_title($this->request->getVar('nama'), '-', true);
        $transaksiModel->save([
            // nama, pembeli, alamat, jumlah, harga, kode_resi
            'id_transaksi' => $id_transaksi,
            'bukti_bayar' => $namaGambar,
            'nama_bank' => $this->request->getVar('nama_bank'),
            'atas_nama' => $this->request->getVar('atas_nama'),
            'status' => 'Menunggu konfirmasi pembayaran'
        ]);

        session()->setFlashdata('pesan', 'Kamu berhasil membayar, silahkan tunggu konfirmasi dari kami');

        return redirect()->to('/transaksi/user');
    }


    public function update($id_transaksi)
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        $transaksiModel = new \App\Models\TransaksiModel();

        if (!$this->validate([

            'bukti_bayar' => [
                'rules' => 'max_size[bukti_bayar,1024]|is_image[bukti_bayar]|mime_in[bukti_bayar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            return redirect()->to('/transaksi/bayar/' . $id_transaksi)->withInput();
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
        //Ambil Gambar
        $fileBuktiBayar = $this->request->getFile('bukti_bayar');
        //Cek apakah tidak ada gambar yang diupload
        if ($fileBuktiBayar->getError() == 4) {
            $namaGambar = 'default.png';
        } else {
            //Generate nama gambar random
            $namaGambar = $fileBuktiBayar->getRandomName();
            //pindahkan file ke folder img
            $fileBuktiBayar->move('img', $namaGambar);
            //ambil nama file 
            // $namaGambar = $fileBuktiBayar->getName();
        }

        // $slug = url_title($this->request->getVar('nama'), '-', true);
        $transaksiModel->save([
            // nama, pembeli, alamat, jumlah, harga, kode_resi
            'id_transaksi' => $id_transaksi,
            'bukti_bayar' => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Kamu berhasil membayar, silahkan tunggu verifikasi dari kami');

        return redirect()->to('/transaksi/user');
    }
    //END FITUR BAYAR

    //Tampilan PDF Invoice (new tab)
    public function invoice()
    {
        $id = $this->request->uri->getSegment(3);

        $transaksiModel = new \App\Models\TransaksiModel();
        // $transaksi = $transaksiModel->find($id);
        // $transaksi->id_pelanggan = $this->session->get('logged_in');

        $transaksiJoin = $transaksiModel->join('user', 'user.id=transaksi.id_pelanggan')
            // ->join('users', 'users.username=transaksi.pembeli')
            ->where('transaksi.id_transaksi', $id)
            ->first();

        // dd($transaksiJoin);
        // error
        // print_r($transaksiJoin);

        // $userModel = new \App\Models\UserModel();
        // $pelanggan = $userModel->find($transaksi->id_pelanggan);

        $productsModel = new \App\Models\ProductsModel();
        $products = $productsModel->find($transaksiJoin->id_barang);

        $html = view('transaksi/invoice', [
            'transaksi' => $transaksiJoin,
            // 'pelanggan' => $pelanggan,
            'products' => $products,
            'title' => 'Invoice',
        ]);

        $pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Bunch of Gifts');
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('Invoice');

        //kalau gamau pake header dan footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        //DOWNLOAD INVOICE DARI WEBSITE
        //line ini penting kalau mau print invoice dr website. kalau gapake ini, keluarnya html
        $this->response->setContentType('application/pdf');
        $pdf->Output('invoice.pdf', 'I');

        // //EMAIL INVOICE
        // //Close and output PDF document
        // $pdf->Output(__DIR__ . '/../../public/uploads/invoice.pdf', 'F');
        // //F itu melakukan write file di folder uploads/invoice

        // $attachment = base_url('uploads/invoice.pdf');

        // $message = "<h1>Invoice Pembelian</h1><p>Kepada AMBIL USERNAME" . $products['nama'] . " </p>";

        // //AMBIL EMAIL DARI USER. URGENT
        // $this->sendEmail($attachment, 'captaintsubasa1611@gmail.com', 'Invoice', $message);

        // return redirect()->to(site_url('transaksi/index'));
        // //TAMBAHIN FLASH MESSAGE EMAIL BERHASIL DIKIRIM. URGENT
        // //END EMAIL INVOICE
    }

    //LACAK RESI
    public function lacakResi()
    {
        $id = $this->request->uri->getSegment(3);
        $transaksiModel = new \App\Models\TransaksiModel();

        $transaksi = $this->transaksiModel->getTransaction($id);

        // dd($transaksi);
        $data = [
            'title' => 'Lacak Resi',
            'transaksi' => $transaksi
        ];
        return view('transaksi/lacakResi', $data);
    }



    //EMAIL INVOICE
    // private function sendEmail($attachment, $to, $title, $message)
    // {
    //     $this->email->setFrom('bunchofgift.id@gmail.com', 'Bunch of Gifts');
    //     //EMAIL INVOICE manual
    //     // $this->email->setTo('captaintsubasa1611@gmail.com');
    //     $this->email->setTo($to);

    //     $this->email->attach($attachment);
    //     $this->email->SetSubject($title);

    //     $this->email->setMessage($message);

    //     if (!$this->email->send()) {
    //         return false;
    //     } else {
    //         return true;
    //     }
    // }
}
