<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Login extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function index()
    {
        return view('login');
    }

    public function ceklogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $data = $this->userModel->getAuthLogin($username, $password);
        if (!empty($data)) {
            $role = $data['role'];

            if ($role == 'Admin' || $role == 'Kasir' || $role == 'Owner') {
                $data_session = [
                    'id'        => $data['id_user'],
                    'nama_user' => $data['nama_user'],
                    'username'  => $data['username'],
                    'password'  => $data['passconf'],
                    'role'      => $data['role'],
                    'foto'      => $data['foto'],
                    'status'    => 'telah_login'
                ];
                session()->set($data_session);
                return redirect()->to(base_url('dashboard'));
            }
        }

        session()->setFlashdata('gagal', 'Gagal');
        return redirect()->to(base_url());
    }

    public function keluar()
    {
        session()->destroy();
        return redirect()->to(base_url('alert'));
    }

    public function alert()
    {
        session()->setFlashdata('berhasil', 'Berhasil');
        return redirect()->to(base_url());
    }
}
