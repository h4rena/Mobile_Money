<?php
namespace App\Controllers;

use App\Models\ClientModel;

class ClientController extends BaseController
{
    public function solde()
    {
        $client = new ClientModel();
        $numero = session()->get('numero');
        $solde = $client->getSolde($numero);

        return view('client/solde', ['solde' => $solde]);
    }
}

?>