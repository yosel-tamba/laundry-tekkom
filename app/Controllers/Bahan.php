<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BahanModel;
use Dompdf\Dompdf;

class Bahan extends Controller
{
    protected $bahanModel;

    public function __construct()
    {
        $this->bahanModel = new BahanModel();
    }

    public function index()
    {
        $data = [
            'judul'     => "Bahan Cucian",
            'bahan'     => $this->bahanModel->getBahan()
        ];

        return view('bahan', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nama_bahan' => [
                'label' => 'Nama Bahan ',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} bahan harus diisi.'
                ]
            ],
            'harga' => [
                'label' => 'Harga Bahan ',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} bahan harus diisi.',
                    'numeric' => '{field} bahan hanya berupa angka saja.',
                ]
            ],
            'stok' => [
                'label' => 'Stok Bahan ',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} bahan harus diisi.',
                    'numeric' => '{field} bahan hanya berupa angka saja.',
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('gagal_simpan', 'Bahan');
            return redirect()->to('/bahan')->withInput()->with('validation_tambah', $validation);
        }

        $this->bahanModel->save([
            'nama_bahan'    => $this->request->getPost('nama_bahan'),
            'harga'         => $this->request->getPost('harga'),
            'stok'          => $this->request->getPost('stok')
        ]);

        session()->setFlashdata('bahan', 'ditambahkan');
        return redirect()->to('/bahan');
    }

    public function update()
    {
        if (!$this->validate([
            'nama_bahan' => [
                'label' => 'Nama Bahan ',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} bahan harus diisi.'
                ]
            ],
            'harga' => [
                'label' => 'Harga Bahan ',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} bahan harus diisi.',
                    'numeric' => '{field} bahan hanya berupa angka saja.',
                ]
            ],
            'stok' => [
                'label' => 'Stok Bahan ',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} bahan harus diisi.',
                    'numeric' => '{field} bahan hanya berupa angka saja.',
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('gagal_simpan', 'Bahan');
            return redirect()->to('/bahan')->withInput()->with('validation_ubah' . $this->request->getPost('id_bahan'), $validation);
        }

        $this->bahanModel->save([
            'id_bahan'      => $this->request->getPost('id_bahan'),
            'nama_bahan'    => $this->request->getPost('nama_bahan'),
            'harga'         => $this->request->getPost('harga'),
            'stok'          => $this->request->getPost('stok')
        ]);

        session()->setFlashdata('bahan', 'diubah');
        return redirect()->to('/bahan');
    }

    public function delete($id)
    {
        $this->bahanModel->delete($id);
        session()->setFlashdata('bahan', 'dihapus');
        return redirect()->to('/bahan');
    }

    public function pdf()
    {
        $data = [
            'judul'     => "Bahan Cucian",
            'bahan'     => $this->bahanModel->getBahan()
        ];

        $filename = date('y-m-d-H-i-s') . '-laporan-bahan-cucian';
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('laporan/bahan', $data));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename);
    }
}
