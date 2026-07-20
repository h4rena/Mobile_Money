<?php
namespace App\Controllers;

use App\Models\ClientModel;

class ClientController extends BaseController
{
    public function dashboard()
    {
        $client = session()->get('client');
        return view('client/dashboard', ['client' => $client]);
    }
    public function solde()
    {
        $client = new ClientModel();
        $numero = session()->get('numero');
        $solde = $client->getSolde($numero);

        return view('client/solde', ['solde' => $solde]);
    }
}

?>