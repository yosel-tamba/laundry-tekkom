<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PaketModel;
use Dompdf\Dompdf;

class Paket extends Controller
{
    protected $paketModel;

    public function __construct()
    {
        $this->paketModel = new PaketModel();
    }

    public function index()
    {
        $data = [
            'judul'     => "Paket Cucian",
            'paket'     => $this->paketModel->getPaket(),
        ];

        return view('paket', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nama_paket' => [
                'label' => 'Nama Paket ',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} paket harus diisi.'
                ]
            ],
            'harga' => [
                'label' => 'Harga Paket ',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} paket harus diisi.',
                    'numeric' => '{field} paket hanya berupa angka saja.',
                ]
            ],
            'jenis' => [
                'label' => 'Jenis Paket',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('gagal_simpan', 'Paket');
            return redirect()->to('/paket')->withInput()->with('validation_tambah', $validation);
        }

        $this->paketModel->save([
            'nama_paket'    => $this->request->getPost('nama_paket'),
            'harga'         => $this->request->getPost('harga'),
            'jenis'         => $this->request->getPost('jenis')
        ]);

        session()->setFlashdata('paket', 'ditambahkan');
        return redirect()->to('/paket');
    }

    public function update()
    {
        if (!$this->validate([
            'nama_paket' => [
                'label' => 'Nama Paket ',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} paket harus diisi.'
                ]
            ],
            'harga' => [
                'label' => 'Harga Paket ',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} paket harus diisi.',
                    'numeric' => '{field} paket hanya berupa angka saja.',
                ]
            ],
            'jenis' => [
                'label' => 'Jenis Paket',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('gagal_simpan', 'Paket');
            return redirect()->to('/paket')->withInput()->with('validation_ubah' . $this->request->getPost('id_paket'), $validation);
        }

        $this->paketModel->save([
            'id_paket'      => $this->request->getPost('id_paket'),
            'nama_paket'    => $this->request->getPost('nama_paket'),
            'harga'         => $this->request->getPost('harga'),
            'jenis'         => $this->request->getPost('jenis')
        ]);

        session()->setFlashdata('paket', 'diubah');
        return redirect()->to('/paket');
    }

    public function delete($id)
    {
        $this->paketModel->delete($id);
        session()->setFlashdata('paket', 'dihapus');
        return redirect()->to('/paket');
    }

    public function filter()
    {
        $jenis = $this->request->getGet('jenis');
        $data = [
            'judul'     => "Paket Cucian",
            'jenis'      => $jenis
        ];

        if ($jenis == "Semua") {
            $data['paket'] = $this->paketModel->getPaket();
        } else {
            $data['paket'] = $this->paketModel->getFilterPaket($jenis);
        }

        return view('filter/paket', $data);
    }

    public function pdf()
    {
        $jenis = $this->request->getGet('jenis');
        $data = [
            'judul'     => "Paket Cucian",
        ];

        if ($jenis == "Semua") {
            $data['paket'] = $this->paketModel->getPaket();
        } else {
            $data['paket'] = $this->paketModel->getFilterPaket($jenis);
        }

        $filename = date('y-m-d-H-i-s') . '-laporan-paket-' . $jenis;
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('laporan/paket', $data));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename);
    }
}
