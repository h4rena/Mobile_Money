<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersOperateurModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['email', 'mot_de_passe', 'id_operateur'];

    public function getUserByOperateurByEmail($email)
    {
        return $this->select('users.*, operateurs.nom_operateur, operateurs.id_prefixe, prefixes.prefixe')
            ->join('operateurs', 'operateurs.id_operateur = users.id_operateur')
            ->join('prefixes', 'prefixes.id_prefixe = operateurs.id_prefixe')
            ->where('users.email', $email)
            ->first();
    }
}
