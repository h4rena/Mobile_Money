<?php

namespace App\Models;

use CodeIgniter\Model;

class EpargneModel extends Model
{
    protected $table = 'epargne';
    protected $primaryKey = 'id_epargne';
    protected $allowedFields = ['pourcentage_epargne','solde_epargne'];
}
