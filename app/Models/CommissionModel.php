<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionModel extends Model
{
    protected $table = 'commission';
    protected $primaryKey = 'id_commission';
    protected $allowedFields = ['id_operateur_source', 'id_operateur_dest', 'taux'];

    public function getTaux(int $idSource, int $idDest)
    {
        return $this->where('id_operateur_source', $idSource)
                    ->where('id_operateur_dest', $idDest)
                    ->first();
    }
}
