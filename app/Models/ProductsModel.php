<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $table = 'products';
    protected $useTimestamps = true;
    protected $primaryKey = 'id_barang';
    //Allowed Fields adalah kolom di tabel yang bisa di ubah2
    protected $allowedFields = ['nama', 'slug', 'kategori', 'harga', 'stok', 'gambar', 'deskripsi'];

    public function getProducts($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
    public function getProductsSnack()
    {
        return $this->where('kategori', 'bouque')->findAll();
    }
    public function getProductsRajutan()
    {
        return $this->where('kategori', 'rajutan')->findAll();
    }
}
