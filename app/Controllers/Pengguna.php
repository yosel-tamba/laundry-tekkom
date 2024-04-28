<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use Dompdf\Dompdf;

class Pengguna extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'judul' => "Pengguna",
            'user' => $this->userModel->getUser()
        ];

        return view('pengguna', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nama_user' => [
                'label' => 'Nama',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} pengguna harus diisi.'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'min_length' => '{field} minimal berisi 5 karekter.'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'min_length' => '{field} minimal berisi 5 karekter.'
                ]
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('gagal_simpan', 'Pengguna');
            return redirect()->to('/pengguna')->withInput()->with('validation_tambah', $validation);
        }

        if ($this->request->getFile('foto') && $this->request->getFile('foto')->isValid()) {
            $nama = rand() . '-' . str_replace(' ', '_', $this->request->getPost('nama_user')) . '.jpg';
            $foto = $this->request->getFile('foto');
            $fotoName = $nama;
            $uploadPath = './img/foto_profil/';

            $foto->move($uploadPath, $fotoName);

            if (!$foto->hasMoved()) {
                session()->setFlashdata('gagal_simpan', 'Pengguna');
                return redirect()->to('/pengguna');
            }
        } else {
            $fotoName = 'user.png';
        }

        $this->userModel->save([
            'nama_user' => $this->request->getPost('nama_user'),
            'password'  => $this->request->getPost('password'),
            'passconf'  => $this->request->getPost('password'),
            'username'  => $this->request->getPost('username'),
            'role'      => $this->request->getPost('role'),
            'foto'      => $fotoName
        ]);
        session()->setFlashdata('pengguna', 'ditambahkan');
        return redirect()->to('/pengguna');
    }

    public function update()
    {
        if (!$this->validate([
            'nama_user' => [
                'label' => 'Nama',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} pengguna harus diisi.'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'min_length' => '{field} minimal berisi 5 karekter.'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'min_length' => '{field} minimal berisi 5 karekter.'
                ]
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('gagal_simpan', 'Pengguna');
            return redirect()->to('/pengguna')->withInput()->with('validation_ubah' . $this->request->getPost('id_user'), $validation);
        }

        $this->userModel->save([
            'id_user'   => $this->request->getPost('id_user'),
            'nama_user' => $this->request->getPost('nama_user'),
            'password'  => $this->request->getPost('password'),
            'passconf'  => $this->request->getPost('password'),
            'username'  => $this->request->getPost('username'),
            'role'      => $this->request->getPost('role'),
        ]);
        session()->setFlashdata('pengguna', 'diubah');
        return redirect()->to('/pengguna');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata('pengguna', 'dihapus');
        return redirect()->to('/pengguna');
    }

    public function filter()
    {
        $role = $this->request->getGet('role');
        $data = [
            'judul'     => "Pengguna",
            'role'      => $role
        ];

        if ($role == "Semua") {
            $data['user'] = $this->userModel->getUser();
        } else {
            $data['user'] = $this->userModel->getFilterUser($role);
        }

        return view('filter/pengguna', $data);
    }

    public function pdf()
    {
        $role = $this->request->getGet('role');
        $data = [
            'judul'     => "Pengguna"
        ];

        if ($role == "Semua") {
            $data['user'] = $this->userModel->getUser();
        } else {
            $data['user'] = $this->userModel->getFilterUser($role);
        }

        $filename = date('y-m-d-H-i-s') . '-laporan-pengguna-' . $role;
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('laporan/pengguna', $data));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename);
    }
}
