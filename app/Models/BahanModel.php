<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanModel extends Model
{
    protected $table = 'bahan';
    protected $primaryKey = 'id_bahan';
    // protected $useTimestamps = true;
    protected $allowedFields = ['nama_bahan', 'harga', 'stok'];

    public function getBahan($id_bahan = false)
    {
        if ($id_bahan == false) {
            return $this->orderBy('id_bahan', 'desc')->findAll();
        }

        return  $this->where([
            'id_bahan' => $id_bahan
        ])->first();
    }

    public function getFilterBahan($jenis)
    {
        return  $this->where([
            'jenis' => $jenis
        ])->orderBy('id_bahan', 'desc')->findAll();
    }
}
