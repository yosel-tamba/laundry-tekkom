<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Profil extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
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
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'min_length' => '{field} minimal berisi 5 karekter.'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('gagal_simpan', 'Pengguna');
            return redirect()->to('/dashboard')->withInput()->with('validation_profil', $validation);
        }
        if ($this->request->getFile('foto') && $this->request->getFile('foto')->isValid()) {
            $nama = rand() . '-' . str_replace(' ', '_', $this->request->getPost('nama_user')) . '.jpg';
            $foto = $this->request->getFile('foto');
            $fotoName = $nama;
            $uploadPath = './img/foto_profil/';

            $foto->move($uploadPath, $fotoName);

            if (!$foto->hasMoved()) {
                session()->setFlashdata('gagal_simpan', 'Profil');
                return redirect()->to('/dashboard');
            } else {
                $user = $this->userModel->getUser($this->request->getPost('id_user'));
                $path_file = 'img/foto_profil/'; // path file
                $nama_file = $user['foto']; // nama file
                if ($nama_file != 'user.png') {
                    unlink($path_file . $nama_file); // hapus file
                }
            }
        } else {
            $fotoName = $this->request->getPost('foto_default');
        }

        $this->userModel->save([
            'id_user'   => $this->request->getPost('id_user'),
            'id_outlet' => $this->request->getPost('id_outlet'),
            'nama_user' => $this->request->getPost('nama_user'),
            'password'  => md5(strval($this->request->getPost('password'))),
            'passconf'  => $this->request->getPost('password'),
            'username'  => $this->request->getPost('username'),
            'role'      => session()->get('role'),
            'foto'      => $fotoName
        ]);

        $data_session = [
            'id'        => $this->request->getPost('id_user'),
            'nama_user' => $this->request->getPost('nama_user'),
            'username'  => $this->request->getPost('username'),
            'password'  => $this->request->getPost('password'),
            'outlet'    => $this->request->getPost('id_outlet'),
            'role'      => session()->get('role'),
            'foto'      => $fotoName,
            'status'    => 'telah_login'
        ];
        session()->set($data_session);

        session()->setFlashdata('dashboard', 'ditambahkan');
        return redirect()->to('/dashboard');
    }
}
