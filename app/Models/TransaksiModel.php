<?php

namespace App\Models;

use CodeIgniter\Model;

class transaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    // protected $useTimestamps = true;
    protected $allowedFields = [ 'id_user', 'id_member', 'kode_invoice', 'tgl', 'tgl_bayar', 'diskon', 'pajak', 'biaya_tambahan', 'status'];

    public function getTransaksi($id_transaksi = false, $status = false)
    {
        if ($status == false && $id_transaksi == false) {
            return $this->orderBy('id_transaksi', 'desc')
                ->join('member', 'member.id_member = transaksi.id_member')
                ->findAll();
        }

        if ($id_transaksi != false) {
            return  $this->where([
                'id_transaksi' => $id_transaksi
            ])->first();
        }

        if ($status != false) {
            return  $this->where(['status' => $status])
                ->orderBy('id_transaksi', 'desc')
                ->join('member', 'member.id_member = transaksi.id_member')
                ->get()
                ->getResultArray();
        }
    }

    public function nota($where)
    {
        return $this->where($where)
            ->join('member', 'member.id_member = transaksi.id_member')
            ->join('user', 'user.id_user = transaksi.id_user')
            ->first();
    }

    public function getFilterTransaksi($dari, $sampai)
    {
        return $this->orderBy('id_transaksi', 'desc')
            ->join('member', 'member.id_member = transaksi.id_member')
            ->where('status', 'diambil')
            ->where('tgl_bayar >=', $dari)
            ->where('tgl_bayar <=', $sampai)
            ->findAll();
    }
}
