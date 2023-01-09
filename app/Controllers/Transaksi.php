<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use TCPDF;

class Transaksi extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->session = session();

        //EMAIL INVOICE
        $this->email = \Config\Services::email();
        $this->transaksiModel = new TransaksiModel();
    }

    //Tampilan pemesanan berhasil dilakukan
    public function view($id)
    {
        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $transaksiModel->join('products', 'products.id_barang=transaksi.id_barang')
            ->join('user', 'user.id=transaksi.id_pelanggan')
            ->where('transaksi.id_transaksi', $id)
            ->first();

        return view('transaksi/view', [
            'transaksi' => $transaksi,
            'title' => 'Detail Pesanan | Bunch of Gifts',
            'statusNav' => 'order'
        ]);
    }

    //Tampilan list transaksi untuk ADMIN
    public function index()
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        if ($this->session->get('role') != 1) {
            return redirect()->to('/');
        }

        $transaksiModel = new \App\Models\TransaksiModel();

        $model = $transaksiModel->join('user', 'user.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.status =', 'Menunggu konfirmasi pembayaran')
            ->where('transaksi.status =', 'Produk sedang diproses')
            ->paginate(10);

        return view('transaksi/index', [
            'model' => $model,
            'title' => 'List Transaksi Admin | Bunch of Gifts',
            'pager' => $transaksiModel->pager,
            'statusSide' => 'pesanan',
        ]);
    }

    //Tampilan list transaksi untuk USER
    public function user()
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        $id = $this->session->get('id');
        $transaksiModel = new \App\Models\TransaksiModel();

        $model = $transaksiModel->join('user', 'user.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.id_pelanggan', $id)
            ->where('transaksi.status!=', 'Produk sampai di tujuan')
            ->paginate(10);

        return view('transaksi/user', [
            'model' => $model,
            'pager' => $transaksiModel->pager,
            'username' => $this->session->get('username'),
            'title' => 'List Transaksi | Bunch of Gifts',
            'statusNav' => 'order'
        ]);
    }

    //USER CANCEL PESANAN
    public function delete($id_transaksi)
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        $this->transaksiModel->delete($id_transaksi);
        session()->setFlashdata('gagal', 'Anda Berhasil membatalkan pesanan');
        return redirect()->to('/transaksi/user');
    }

    //START FITUR BAYAR
    public function bayar($id_transaksi)
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to('/login');
        }

        $transaksiModel = new \App\Models\TransaksiModel();

        $model = $transaksiModel->join('user', 'user.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.id_transaksi', $id_transaksi)
            ->first();

        $productsModel = new \App\Models\ProductsModel();
        $products = $productsModel->getProducts();

        $data = [
            'title' => 'Bayar Pesanan | Bunch of Gifts',
            'statusNav' => 'order',
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
        }

        $transaksiModel->save([
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
        }

        $transaksiModel->save([
            'id_transaksi' => $id_transaksi,
            'bukti_bayar' => $namaGambar
        ]);

        session()->setFlashdata('pesan', 'Kamu berhasil membayar, silahkan tunggu verifikasi dari kami');

        return redirect()->to('/transaksi/user');
    }

    //Tampilan PDF Invoice (new tab)
    public function invoice()
    {
        $id = $this->request->uri->getSegment(3);

        $transaksiModel = new \App\Models\TransaksiModel();

        $transaksiJoin = $transaksiModel->join('user', 'user.id=transaksi.id_pelanggan')
            ->where('transaksi.id_transaksi', $id)
            ->first();

        $productsModel = new \App\Models\ProductsModel();
        $products = $productsModel->find($transaksiJoin->id_barang);

        $html = view('transaksi/invoice', [
            'transaksi' => $transaksiJoin,
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

        $this->response->setContentType('application/pdf');
        $pdf->Output('invoice.pdf', 'I');
    }

    //LACAK RESI
    public function lacakResi()
    {
        $id = $this->request->uri->getSegment(3);
        $transaksiModel = new \App\Models\TransaksiModel();

        $transaksi = $this->transaksiModel->getTransaction($id);

        $data = [
            'title' => 'Lacak Resi | Bunch of Gifts',
            'transaksi' => $transaksi,
            'statusNav' => 'order'
        ];
        return view('transaksi/lacakResi', $data);
    }

    //PESANAN SAMPAI
    public function selesai($id_transaksi)
    {
        $transaksiModel = new \App\Models\TransaksiModel();

        $transaksiModel->save([
            'id_transaksi' => $id_transaksi,
            'status' => 'Produk sampai di tujuan'
        ]);

        session()->setFlashdata('pesan', 'Terima kasih sudah bertransaksi di Bunch of Gifts');
        return redirect()->to('/transaksi/user');
    }
}
