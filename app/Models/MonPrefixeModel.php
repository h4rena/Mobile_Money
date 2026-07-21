<?php

namespace App\Models;

use CodeIgniter\Model;

class MonPrefixeModel extends Model
{
    protected $table = 'mon_prefixe';
    protected $primaryKey = 'id_mon_prefixe';
    protected $allowedFields = ['prefixe'];
}
