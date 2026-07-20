<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table = 'operations';
    protected $primaryKey = 'id_operation';
    protected $allowedFields = ['id_operateur', 'id_type_operation', 'id_client', 'montant'];
}
