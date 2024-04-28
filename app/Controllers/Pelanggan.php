<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MemberModel;
use Dompdf\Dompdf;

class Pelanggan extends Controller
{
    protected $memberModel;

    public function __construct()
    {
        $this->memberModel = new MemberModel();
    }

    public function index()
    {
        $data = [
            'judul'     => "Pelanggan",
            'member'    => $this->memberModel->getMember()
        ];

        return view('pelanggan', $data);
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
            ]
        ])) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('gagal_simpan', 'Pelanggan');
            return redirect()->to('/pelanggan')->withInput()->with('validation_tambah', $validation);
        }
        $this->memberModel->save([
            'nama_member'   => $this->request->getPost('nama_member'),
            'alamat'        => $this->request->getPost('alamat'),
            'tlp'           => $this->request->getPost('tlp'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
        ]);
        session()->setFlashdata('pelanggan', 'ditambahkan');
        return redirect()->to('/pelanggan');
    }

    public function update()
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
            ]
        ])) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('gagal_simpan', 'Pelanggan');
            return redirect()->to('/pelanggan')->withInput()->with('validation_ubah' . $this->request->getPost('id_member'), $validation);
        }
        $this->memberModel->save([
            'id_member'     => $this->request->getPost('id_member'),
            'nama_member'   => $this->request->getPost('nama_member'),
            'alamat'        => $this->request->getPost('alamat'),
            'tlp'           => $this->request->getPost('tlp'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin')
        ]);
        session()->setFlashdata('pelanggan', 'diubah');
        return redirect()->to('/pelanggan');
    }

    public function delete($id)
    {
        $this->memberModel->delete($id);
        session()->setFlashdata('pelanggan', 'dihapus');
        return redirect()->to('/pelanggan');
    }


    public function filter()
    {
        $jenis_kelamin = $this->request->getGet('jk');
        $data = [
            'judul'         => "Pelanggan",
            'jenis_kelamin' => $jenis_kelamin
        ];

        if ($jenis_kelamin == "Semua") {
            $data['member'] = $this->memberModel->getMember();
        } else {
            $data['member'] = $this->memberModel->getFilterMember($jenis_kelamin);
        }

        return view('filter/pelanggan', $data);
    }

    public function pdf()
    {
        $jk = $this->request->getGet('jk');
        $data = [
            'judul'     => "Pelanggan",
        ];

        if ($jk == "Semua") {
            $data['member'] = $this->memberModel->getMember();
        } else {
            $data['member'] = $this->memberModel->getFilterMember($jk);
        }

        $filename = date('y-m-d-H-i-s') . '-laporan-pelanggan-' . $jk;
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('laporan/pelanggan', $data));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename);
    }
}
