<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $useTimestamps = true;
    protected $primaryKey = 'id_transaksi';
    //Allowed Fields adalah kolom di tabel yang bisa di ubah2
    protected $allowedFields = [
        'id_pelanggan', 'id_barang', 'pembeli', 'no_hp',
        'alamat', 'product', 'jumlah', 'ongkir', 'total_harga', 'bukti_bayar', 'nama_bank', 'kode_resi',
        'status', 'created_at', 'updated_at'
    ];

    public function getTransactionByUserId($id_pelanggan)
    {
        // if ($id_pelanggan == false) {
        //     return $this->findAll();
        // }

        return $this->where(['$id_pelanggan' => $id_pelanggan])->first();
    }

    protected $returnType = 'App\Entities\Transaksi';
}
