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

class Registrasi extends Controller
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
            'judul'     => "Registrasi",
            'user'      => $this->userModel->getUser(),
            'member'    => $this->memberModel->getMember(),
            'paket'     => $this->paketModel->getPaket(),
            'bahan'     => $this->bahanModel->getBahan(),
        ];

        return view('registrasi', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nama_member' => [
                'label' => 'Nama',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} pelanggan harus diisi.'
                ]
            ],
            'jenis_kelamin' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'tlp' => [
                'label' => 'Telepon',
                'rules' => 'required|numeric|max_length[15]',
                'errors' => [
                    'required' => '{field} pelanggan harus diisi.',
                    'numeric' => '{field} pelanggan hanya berupa angka saja.',
                    'max_length' => '{field} pelanggan tidak boleh lebih dari 15 digit.'
                ]
            ],
            'id_user' => [
                'label' => 'Pengguna',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('gagal_simpan', 'Registrasi');
            return redirect()->to('/registrasi')->withInput()->with('validation_tambah', $validation);
        }

        // tambah pelanggan
        $this->memberModel->save([
            'nama_member' => $this->request->getPost('nama_member'),
            'alamat' => $this->request->getPost('alamat'),
            'tlp' => $this->request->getPost('tlp'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
        ]);
        $id_member = $this->memberModel->insertID();

        // tambah transaksi
        $this->transaksiModel->save([
            'id_user' => $this->request->getPost('id_user'),
            'id_member' => $id_member,
            'kode_invoice' => $this->request->getPost('kode_invoice'),
            'tgl' => $this->request->getPost('tgl'),
            'diskon' => $this->request->getPost('diskon'),
            'status' => $this->request->getPost('status')
        ]);
        $id_transaksi = $this->transaksiModel->insertID();

        // tambah detail transaksi
        $data_detail_transaksi = [];
        $index = 0;
        foreach ($this->request->getPost('id_paket') as $id) {
            array_push($data_detail_transaksi, array(
                'id_paket' => $id,
                'qty' => '1',
                'id_transaksi' => $id_transaksi
            ));

            $index++;
        }
        $this->detailTransaksiModel->insertBatch($data_detail_transaksi);

        // tambah biaya tambahan
        $data_biaya_tambahan = [];
        $index = 0;
        foreach ($this->request->getPost('id_bahan') as $id) {
            array_push($data_biaya_tambahan, array(
                'id_bahan' => $id,
                'qty' => '1',
                'id_transaksi' => $id_transaksi
            ));

            $index++;
        }
        $this->biayaTambahanModel->insertBatch($data_biaya_tambahan);

        session()->setFlashdata('registrasi', 'ditambahkan');
        return redirect()->to('/registrasi');
    }
}
