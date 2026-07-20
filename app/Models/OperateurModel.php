<?php

namespace App\Models;

use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table = 'operateurs';
    protected $primaryKey = 'id_operateur';
    protected $allowedFields = ['id_prefixe', 'nom_operateur'];

    public function getOperateurByNumero(string $numero)
    {
        $prefixe = substr($numero, 0, 3);

        $prefixeModel = new \App\Models\PrefixeModel();
        $pref = $prefixeModel->where('prefixe', $prefixe)->first();

        if (!$pref) {
            return null;
        }

        return $this->where('id_prefixe', $pref['id_prefixe'])->first();
    }
}
