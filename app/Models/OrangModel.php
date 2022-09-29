<?php

namespace App\Models;

use CodeIgniter\Model;

class OrangModel extends Model
{
    protected $table = 'orang';
    protected $useTimestamps = true;
    //PENTING UNTUK CRUD Allowed Fields adalah kolom di tabel yang bisa di ubah2. 
    protected $allowedFields = ['nama', 'alamat'];

    public function getProducts($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}
