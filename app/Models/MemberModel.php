<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table = 'member';
    protected $primaryKey = 'id_member';
    // protected $useTimestamps = true;
    protected $allowedFields = ['nama_member', 'alamat', 'jenis_kelamin', 'tlp'];

    public function getMember($id_member = false)
    {
        if ($id_member == false) {
            return $this->orderBy('id_member', 'desc')->findAll();
        }

        return  $this->where([
            'id_member' => $id_member
        ])->first();
    }

    public function getFilterMember($jenis_kelamin)
    {
        return  $this->where([
            'jenis_kelamin' => $jenis_kelamin
        ])->orderBy('id_member', 'desc')->findAll();
    }
}
