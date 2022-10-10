<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $table = 'products';
    protected $useTimestamps = true;
    //Allowed Fields adalah kolom di tabel yang bisa di ubah2
    protected $allowedFields = ['nama', 'slug', 'harga', 'stok', 'gambar', 'deskripsi'];

    public function getProducts($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}
