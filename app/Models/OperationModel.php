<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table = 'operations';
    protected $primaryKey = 'id_operation';
    protected $allowedFields = ['id_operateur', 'id_type_operation', 'id_client', 'montant', 'date_operation'];

    public function getOperationsByClient(int $idClient, int $limit = 10)
    {
        return $this->select('operations.*, type_operation.libelle as type_libelle, historique_operations.date_historique')
            ->join('type_operation', 'type_operation.id_type_operation = operations.id_type_operation')
            ->join('historique_operations', 'historique_operations.id_operation = operations.id_operation', 'left')
            ->where('operations.id_client', $idClient)
            ->orderBy('operations.date_operation', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
