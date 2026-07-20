<?php
namespace App\Models;
use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id_client';
    protected $allowedFields = ['nom_client','numero','solde'];

    public function getClientByNumero(string $numero)
    {
        return $this->where('numero', $numero)->first();
    }

    public function getSolde(string $numero)
    {
        $client = new ClientModel();
        $clientData = $client->getClientByNumero($numero);
        return $clientData['solde'];
    }

    public function getAllClients()
    {
        return $this->orderBy('nom_client', 'ASC')->findAll();
    }
}
?>