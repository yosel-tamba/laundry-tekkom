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
use Dompdf\Dompdf;

class Transaksi extends Controller
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
            'judul'             => "Transaksi",
            'paket'             => $this->paketModel->getPaket(),
            'pengguna'          => $this->userModel->getUser(),
            'member'            => $this->memberModel->getMember(),
            'detail'            => $this->detailTransaksiModel->getDetailTransaksi(),
            'transaksi'         => $this->transaksiModel->getTransaksi(false, false),
            'biaya_tambahan'    => $this->biayaTambahanModel->getBiayaTambahan(),
            'bahan'             => $this->bahanModel->getBahan()
        ];

        return view('transaksi/index', $data);
    }

    public function detail()
    {
        $id_transaksi = $this->request->getGet('id');
        $data = [
            'judul'             => "Transaksi",
            'paket'             => $this->paketModel->getPaket(),
            'pengguna'          => $this->userModel->getUser(),
            'member'            => $this->memberModel->getMember(),
            'detail'            => $this->detailTransaksiModel->getDetailTransaksi($id_transaksi),
            'transaksi'         => $this->transaksiModel->getTransaksi($id_transaksi, false),
            'biaya_tambahan'    => $this->biayaTambahanModel->getBiayaTambahan(),
            'bahan'             => $this->bahanModel->getBahan()
        ];

        return view('transaksi/detail', $data);
    }

    public function update()
    {
        if (!$this->validate([
            'id_member' => [
                'label' => 'Nama Pelanggan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} pelanggan harus diisi.'
                ]
            ],
            'id_user' => [
                'label' => 'Nama Pengguna',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'tgl' => [
                'label' => 'Tanggal Masuk Cucian',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'tgl_bayar' => [
                'label' => 'Tanggal Bayar',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'diskon' => [
                'label' => 'Diskon',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'pajak' => [
                'label' => 'Pajak',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('gagal_simpan', 'Transaksi');
            return redirect()->to('/detail-transaksi?id=' . $this->request->getPost('id_transaksi'))->withInput()->with('validation_ubah' . $this->request->getPost('id_transaksi'), $validation);
        }

        $this->transaksiModel->save([
            'id_transaksi'      => $this->request->getPost('id_transaksi'),
            'id_user'           => $this->request->getPost('id_user'),
            'id_member'         => $this->request->getPost('id_member'),
            'tgl'               => $this->request->getPost('tgl'),
            'tgl_bayar'         => $this->request->getPost('tgl_bayar'),
            'diskon'            => $this->request->getPost('diskon'),
            'pajak'             => $this->request->getPost('pajak'),
            'status'            => $this->request->getPost('status')
        ]);

        session()->setFlashdata('transaksi', 'diubah');
        return redirect()->to('/transaksi');
    }

    public function delete($id)
    {
        $this->transaksiModel->delete($id);
        session()->setFlashdata('transaksi', 'dihapus');
        return redirect()->to('/transaksi');
    }

    public function add_paket($id_paket, $id_transaksi)
    {
        $cek = $this->detailTransaksiModel
            ->where('id_transaksi', $id_transaksi)
            ->where('id_paket', $id_paket)
            ->first();

        if ($cek) {
            $this->detailTransaksiModel->save([
                'id_detail_transaksi'  => $cek['id_detail_transaksi'],
                'qty'           => $cek['qty'] + 1
            ]);
        } else {
            $this->detailTransaksiModel->save([
                'id_transaksi'  => $id_transaksi,
                'id_paket'      => $id_paket,
                'qty'           => 1
            ]);
        }

        session()->setFlashdata('transaksi', 'diubah');
        return redirect()->to('/detail-transaksi?id=' . $id_transaksi);
    }

    public function delete_paket($id_detail, $id_transaksi, $id_paket)
    {
        $cek = $this->detailTransaksiModel
            ->where('id_transaksi', $id_transaksi)
            ->where('id_paket', $id_paket)
            ->first();

        $qty = $cek['qty'];
        if ($qty > 1) {
            $this->detailTransaksiModel->save([
                'id_detail_transaksi'  => $cek['id_detail_transaksi'],
                'qty'       => $cek['qty'] - 1
            ]);
        } else {
            $this->detailTransaksiModel->where('id_detail_transaksi', $id_detail)->delete();
        }

        session()->setFlashdata('transaksi', 'dihapus');
        return redirect()->to('/detail-transaksi?id=' . $id_transaksi);
    }

    public function add_bahan($id_bahan, $id_transaksi)
    {
        $cek_biaya = $this->biayaTambahanModel
            ->where('id_transaksi', $id_transaksi)
            ->where('id_bahan', $id_bahan)
            ->first();

        $cek_bahan = $this->bahanModel
            ->where('id_bahan', $id_bahan)
            ->first();

        // tambah bahan pesanan
        if ($cek_biaya) {
            $this->biayaTambahanModel->save([
                'id_biaya'  => $cek_biaya['id_biaya'],
                'qty'           => $cek_biaya['qty'] + 1
            ]);
        } else {
            $this->biayaTambahanModel->save([
                'id_transaksi'  => $id_transaksi,
                'id_bahan'      => $id_bahan,
                'qty'           => 1
            ]);
        }

        // kurangi stok bahan
        $stok = $cek_bahan['stok'];
        $this->bahanModel->save([
            'id_bahan'  => $id_bahan,
            'stok'           => $stok - 1
        ]);

        session()->setFlashdata('transaksi', 'diubah');
        return redirect()->to('/detail-transaksi?id=' . $id_transaksi);
    }

    public function delete_bahan($id_biaya, $id_transaksi, $id_bahan)
    {
        $cek = $this->biayaTambahanModel
            ->where('id_transaksi', $id_transaksi)
            ->where('id_bahan', $id_bahan)
            ->first();

        // kurangi bahan pesanan
        $qty = $cek['qty'];
        if ($qty > 1) {
            $this->biayaTambahanModel->save([
                'id_biaya'  => $cek['id_biaya'],
                'qty'       => $cek['qty'] - 1
            ]);
        } else {
            $this->biayaTambahanModel->where('id_biaya', $id_biaya)->delete();
        }

        $cek_bahan = $this->bahanModel
            ->where('id_bahan', $id_bahan)
            ->first();

        // kurangi stok bahan
        $stok = $cek_bahan['stok'];
        $this->bahanModel->save([
            'id_bahan'  => $id_bahan,
            'stok'           => $stok + 1
        ]);

        session()->setFlashdata('transaksi', 'dihapus');
        return redirect()->to('/detail-transaksi?id=' . $id_transaksi);
    }

    public function nota()
    {
        $where = [
            'id_transaksi' => $this->request->getGet('id')
        ];

        $data = [
            'paket'     => $this->paketModel->getPaket(),
            'pengguna'  => $this->userModel->getUser(),
            'member'    => $this->memberModel->getMember(),
            'transaksi' => $this->transaksiModel->nota($where),
            'detail'    => $this->detailTransaksiModel->getDetailTransaksi($this->request->getGet('id')),
            'biaya_tambahan'    => $this->biayaTambahanModel->getBiayaTambahan(),
            'bahan'             => $this->bahanModel->getBahan()
        ];

        return view('transaksi/nota', $data);
    }

    public function getDataFilter()
    {
        $dari = $this->request->getPost('dari');
        $sampai = $this->request->getPost('sampai');
        return redirect()->to('/filter-transaksi?dari=' . $dari . '&sampai=' . $sampai);
    }


    public function filter()
    {
        $dari = $this->request->getGet('dari');
        $sampai = $this->request->getGet('sampai');
        $data = [
            'judul'     => "Transaksi",
            'paket'     => $this->paketModel->getPaket(),
            'pengguna'  => $this->userModel->getUser(),
            'member'    => $this->memberModel->getMember(),
            'detail'    => $this->detailTransaksiModel->getDetailTransaksi(),
            'transaksi' => $this->transaksiModel->getFilterTransaksi($dari, $sampai),
            'biaya_tambahan'    => $this->biayaTambahanModel->getBiayaTambahan(),
            'bahan'             => $this->bahanModel->getBahan(),
            'dari'      => $dari,
            'sampai'    => $sampai
        ];

        return view('filter/transaksi', $data);
    }

    public function pdf()
    {
        $dari = $this->request->getGet('dari');
        $sampai = $this->request->getGet('sampai');
        $data = [
            'judul'     => "Laporan Transaksi",
            'paket'     => $this->paketModel->getPaket(),
            'pengguna'  => $this->userModel->getUser(),
            'member'    => $this->memberModel->getMember(),
            'detail'    => $this->detailTransaksiModel->getDetailTransaksi(),
            'transaksi' => $this->transaksiModel->getFilterTransaksi($dari, $sampai),
            'biaya_tambahan'    => $this->biayaTambahanModel->getBiayaTambahan(),
            'bahan'             => $this->bahanModel->getBahan()
        ];

        $filename = date('y-m-d-H-i-s') . '-laporan-transaksi-' . $dari . '-' . $sampai;
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('laporan/transaksi', $data));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename);
    }
}
