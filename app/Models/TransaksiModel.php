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
        'id_transaksi', 'id_pelanggan', 'id_barang', 'no_hp',
        'alamat', 'jumlah', 'metode_pengiriman', 'ongkir', 'total_harga', 'bukti_bayar', 'nama_bank', 'atas_nama', 'kode_resi',
        'status', 'created_at', 'updated_at'
    ];

    public function getTransactionByUserId($id_pelanggan)
    {
        // if ($id_pelanggan == false) {
        //     return $this->findAll();
        // }

        return $this->where(['$id_pelanggan' => $id_pelanggan])->first();
    }

    public function getTransaction($id_transaksi = false)
    {
        if ($id_transaksi == false) {
            return $this->findAll();
        }

        return $this->where(['id_transaksi' => $id_transaksi])->first();
    }

    public function search($dari, $ke)
    {
        $builder = $this->table('transaksi');
        $builder->where('created_at >=', $dari);
        $builder->where('updated_at <=', $ke);

        return $builder;
    }

    public function joinData()
    {
        return $this->db->table('transaksi')
            ->join('products', 'products.id_barang = transaksi.id_barang')
            ->join('user', 'user.id = transaksi.id_barang')
            // ->join('kelas', 'kelas.IDKelas=siswa.IDKelas')
            // ->join('jurusan', 'jurusan.IDJurusan=siswa.IDJurusan')
            ->get()->getResultArray();
    }

    // public function getPaginated($num, $dari, $ke)
    // public function getPaginated($num)
    // {
    //     $builder = $this->builder();
    //     $builder->join('products', 'products.id_barang = transaksi.id_barang');
    //     $builder->join('user', 'user.id = transaksi.id_pelanggan');
    //     // $this->builder->where('transaksi.created_at', $id);
    //     return [
    //         'transaksi' => $this->paginate($num),
    //         'pager' => $this->pager,
    //     ];
    // }
    protected $returnType = 'App\Entities\Transaksi';
}
