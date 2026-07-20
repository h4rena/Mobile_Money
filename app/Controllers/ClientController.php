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
        $session = session()->get('client');
        $numero = $session['numero'];
        $client = new ClientModel();
        $solde = $client->getSolde($numero);

        return view('client/solde', ['solde' => $solde]);
    }
}

?>