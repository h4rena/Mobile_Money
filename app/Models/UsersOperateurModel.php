<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersOperateurModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['email', 'mot_de_passe'];

    public function getUserByOperateurByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}