<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    // protected $useTimestamps = true;
    protected $allowedFields = ['nama_user', 'username', 'password', 'passconf', 'role', 'foto'];

    public function getUser($id_user = false)
    {
        if ($id_user == false) {
            return $this->orderBy('id_user', 'desc')->findAll();
        }

        return  $this->where([
            'id_user' => $id_user
        ])->first();
    }

    public function getAuthLogin($username = false, $password = false)
    {
        return  $this->where([
            'username' => $username,
            'password' => md5($password),
        ])->first();
    }

    public function getFilterUser($role)
    {
        return  $this->where([
            'role' => $role
        ])->orderBy('id_user', 'desc')->findAll();
    }
}
