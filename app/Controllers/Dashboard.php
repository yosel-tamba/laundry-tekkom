<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\MemberModel;
use App\Models\PaketModel;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use App\Models\BahanModel;
use App\Models\BiayaTambahanModel;

class Dashboard extends Controller
{
    protected $userModel;
    protected $memberModel;
    protected $paketModel;
    protected $transaksiModel;
    protected $detailTransaksiModel;
    protected $bahanModel;
    protected $biayaTambahanModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->memberModel = new MemberModel();
        $this->paketModel = new PaketModel();
        $this->transaksiModel = new transaksiModel();
        $this->detailTransaksiModel = new DetailTransaksiModel();
        $this->bahanModel = new BahanModel();
        $this->biayaTambahanModel = new BiayaTambahanModel();
    }

    public function index()
    {
        $data = [
            'judul'             => "Dashboard",
            'jml_pengguna'      => $this->userModel->countAll(),
            'jml_paket'         => $this->paketModel->countAll(),
            'jml_member'        => $this->memberModel->countAll(),
            'jml_transaksi'     => count($this->transaksiModel->getTransaksi(false, 'Diambil')),
            'paket'             => $this->paketModel->getPaket(),
            'detail'            => $this->detailTransaksiModel->getDetailTransaksi(),
            'transaksi'    => $this->transaksiModel->getTransaksi(false, 'Diambil'),
            'biaya_tambahan'    => $this->biayaTambahanModel->getBiayaTambahan(),
            'bahan'             => $this->bahanModel->getBahan()
        ];

        return view('dashboard', $data);
    }
}
