<?php

namespace App\Models;

use CodeIgniter\Model;

class BiayaTambahanModel extends Model
{
    protected $table = 'biaya_tambahan';
    protected $primaryKey = 'id_biaya';
    // protected $useTimestamps = true;
    protected $allowedFields = ['id_bahan', 'id_transaksi', 'qty'];

    public function getBiayaTambahan($id_transaksi = false)
    {
        if ($id_transaksi == false) {
            return $this->orderBy('id_transaksi', 'desc')->findAll();
        }

        return  $this->where([
            'id_transaksi' => $id_transaksi
        ])->findAll();
    }
}
