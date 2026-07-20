<?php
namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\OperationModel;

class ClientController extends BaseController
{
    public function dashboard()
    {
        $session = session()->get('client');

        $operationModel = new OperationModel();
        $idClient = $session['id_client'];

        $operations = $operationModel->getOperationsByClient($idClient);

        return view('client/dashboard', [
            'client' => $session,
            'operations' => $operations,
        ]);
    }

    public function solde()
    {
        $session = session()->get('client');
        if (!$session) {
            return redirect()->to('/');
        }
        $numero = $session['numero'];
        $client = new ClientModel();
        $solde = $client->getSolde($numero);

        return view('client/solde', ['solde' => $solde]);
    }
}
