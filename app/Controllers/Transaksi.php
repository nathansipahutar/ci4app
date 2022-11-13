<?php

namespace App\Controllers;

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

    public function index()
    {
        $transaksiModel = new \App\Models\TransaksiModel();
        $model = $transaksiModel->findAll();

        $model = $transaksiModel->join('users', 'users.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            // ->where('transaksi.id_pelanggan', $id)
            ->findAll();

        $productsModel = new \App\Models\ProductsModel();
        $products = $productsModel->getProducts();
        return view('transaksi/index', [
            'model' => $model,
            'products' => $products,
            'title' => 'List Transaksi',
        ]);
    }
    public function user()
    {
        $id = $this->session->get('logged_in');
        $transaksiModel = new \App\Models\TransaksiModel();
        // $model = $transaksiModel->where('id_transaksi', 2);
        // $model = $transaksiModel->findAll();

        $model = $transaksiModel->join('users', 'users.id=transaksi.id_pelanggan')
            ->join('products', 'products.id_barang=transaksi.id_barang')
            ->where('transaksi.id_pelanggan', $id)
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

    public function invoice()
    {
        $id = $this->request->uri->getSegment(3);

        $transaksiModel = new \App\Models\TransaksiModel();
        // $transaksi = $transaksiModel->find($id);
        // $transaksi->id_pelanggan = $this->session->get('logged_in');

        $transaksiJoin = $transaksiModel->join('users', 'users.id=transaksi.id_pelanggan')
            // ->join('users', 'users.username=transaksi.pembeli')
            ->where('transaksi.id_transaksi', $id)
            ->first();
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

    //EMAIL INVOICE
    // private function sendEmail($attachment, $to, $title, $message)
    // {
    //     $this->email->setFrom('chocohunter1610@gmail.com', 'Choco hunter');
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
