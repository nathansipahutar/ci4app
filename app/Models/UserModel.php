<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = "user";
    protected $primaryKey = "id";
    protected $allowedFields = ["id", "email", "username", "no_hp", "password", "salt", "role", "active"];
    protected $useTimestamps = true;

    public function getUserDetail($id)
    {
        return $this->where('id', $id)->first();
    }
    public function getUsernameDetail($username)
    {
        return $this->where('username', $username)->first();
    }
}
