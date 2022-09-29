<?php

namespace App\Controllers;

use App\Models\OrangModel;

class Orang extends BaseController
{
    protected $orangModel;
    public function __construct()
    {
        $this->orangmodel = new OrangModel();
    }
    public function index()
    {
        // $products = $this->productsmodel->findAll();

        $data = [
            'title' => 'Daftar Orang',
            'orang' => $this->orangmodel->findAll()
            // 'orang' => $this->orangModel->paginate(1),
            // 'pager' => $this->orangModel->pager
        ];

        // connect db pake model
        // $productsmodel = new ProductsModel();

        return view('orang/index', $data);
    }
}
