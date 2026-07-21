<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table = 'operations';
    protected $primaryKey = 'id_operation';
    protected $allowedFields = ['id_operateur', 'id_operateur_dest', 'id_type_operation', 'id_client', 'montant', 'frais', 'date_operation'];

    public function getOperationsByClient(int $idClient, int $limit = 10)
    {
        $db = \Config\Database::connect();
        return $db->table('v_operations_detail')
            ->where('id_client', $idClient)
            ->orderBy('date_operation', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }
}
