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

        $filtreType = $this->request->getGet('type') ?: null;

        $gains = $operateurModel->getGainsParOperateur($filtreType);
        $totalGains = $operateurModel->getGainsTotaux($filtreType);
        $baremes = $montantFraisModel->orderBy('montant1', 'ASC')->findAll();

        $gainsParOperateur = [];
        $totalParOperateur = [];
        foreach ($gains as $g) {
            $nom = $g['nom_operateur'];
            if (!isset($gainsParOperateur[$nom])) {
                $gainsParOperateur[$nom] = [];
                $totalParOperateur[$nom] = 0;
            }
            $gainsParOperateur[$nom][] = $g;
            $totalParOperateur[$nom] += $g['total_frais'];
        }

        $operateur = session()->get('operateur');

        return view('operateur/situation', [
            'gains'              => $gains,
            'gainsParOperateur'  => $gainsParOperateur,
            'totalParOperateur'  => $totalParOperateur,
            'totalGains'         => $totalGains,
            'baremes'            => $baremes,
            'operateur'          => $operateur,
            'filtreType'         => $filtreType,
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
