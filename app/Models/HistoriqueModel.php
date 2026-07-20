<?php
namespace App\Models;

use CodeIgniter\Model;

class HistoriqueModel extends Model
{
    protected $table = 'historique_operations';
    protected $primaryKey = 'id_historique';
    protected $allowedFields = ['id_operation', 'date_historique'];
}
