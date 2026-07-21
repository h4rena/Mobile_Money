<?php

namespace App\Models;

use CodeIgniter\Model;

class MonOperateurModel extends Model
{
    protected $table = 'mon_operateur';
    protected $primaryKey = 'id_mon_operateur';
    protected $allowedFields = ['id_mon_prefixe'];

    public function getMonOperateurAvecPrefixes()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('mon_operateur mo');
        $builder->select('mo.id_mon_operateur, mp.prefixe');
        $builder->join('mon_prefixe mp', 'mp.id_mon_prefixe = mo.id_mon_prefixe');
        return $builder->get()->getRowArray();
    }

    public function getMonPrefixes()
    {
        $monPrefixeModel = new MonPrefixeModel();
        return $monPrefixeModel->findAll();
    }
}
