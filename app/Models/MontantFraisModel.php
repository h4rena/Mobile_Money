<?php

namespace App\Models;

use CodeIgniter\Model;

class MontantFraisModel extends Model
{
    protected $table = 'montant_frais';
    protected $primaryKey = 'id_montant_frais';
    protected $allowedFields = ['montant1', 'montant2', 'frais'];

    public function getFraisByMontant(float $montant)
    {
        return $this->where('montant1 <=', $montant)
                    ->where('montant2 >=', $montant)
                    ->first();
    }
}
