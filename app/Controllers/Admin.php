<?php

namespace App\Controllers;

use App\Models\ProductsModel;

class Admin extends BaseController
{
    protected $db, $builder;
    protected $productsModel;

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->productsmodel = new ProductsModel();
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
}
