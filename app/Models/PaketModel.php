<?php

namespace App\Models;

use CodeIgniter\Model;

class PaketModel extends Model
{
    protected $table = 'paket';
    protected $primaryKey = 'id_paket';
    // protected $useTimestamps = true;
    protected $allowedFields = ['jenis', 'nama_paket', 'harga'];

    public function getPaket($id_paket = false)
    {
        if ($id_paket == false) {
            return $this->orderBy('id_paket', 'desc')->findAll();
        }

        return  $this->where([
            'id_paket' => $id_paket
        ])->first();
    }

    public function getFilterPaket($jenis)
    {
        return  $this->where([
            'jenis' => $jenis
        ])->orderBy('id_paket', 'desc')->findAll();
    }
}
