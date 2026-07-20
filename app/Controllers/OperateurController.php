<?php
namespace App\Controllers;

use App\Models\OperateurModel;
use App\Models\MontantFraisModel;
use App\Models\ClientModel;

class OperateurController extends BaseController
{
    public function situation()
    {
        if (!session()->get('operateur')) {
            return redirect()->to('/operateur/login')->with('error', 'Veuillez vous connecter.');
        }

        $operateurModel = new OperateurModel();
        $montantFraisModel = new MontantFraisModel();

        $gains = $operateurModel->getGainsParOperateur();
        $totalGains = $operateurModel->getGainsTotaux();
        $baremes = $montantFraisModel->orderBy('montant1', 'ASC')->findAll();

        return view('operateur/situation', [
            'gains'      => $gains,
            'totalGains' => $totalGains,
            'baremes'    => $baremes,
        ]);
    }

    public function clients()
    {
        if (!session()->get('operateur')) {
            return redirect()->to('/operateur/login')->with('error', 'Veuillez vous connecter.');
        }

        $clientModel = new ClientModel();
        $clients = $clientModel->getAllClients();

        return view('operateur/clients', [
            'clients' => $clients,
        ]);
    }
}
