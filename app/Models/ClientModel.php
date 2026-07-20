<?php
namespace App\Models;
use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $allowedFields = ['nom_client','numero'];

    public function getClientByNumero(string $numero)
    {
        return $this->where('numero', $numero)->first();
    }
}
?>