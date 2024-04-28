<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail_transaksi';
    // protected $useTimestamps = true;
    protected $allowedFields = ['id_transaksi', 'id_paket', 'qty'];

    public function getDetailTransaksi($id_transaksi = false)
    {
        if ($id_transaksi == false) {
            return $this->orderBy('id_transaksi', 'desc')->findAll();
        }

        return  $this->where([
            'id_transaksi' => $id_transaksi
        ])->findAll();
    }
}
