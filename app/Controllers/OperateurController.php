<?php
namespace App\Controllers;

use App\Models\OperateurModel;
use App\Models\MontantFraisModel;

class OperateurController extends BaseController
{
    public function situation()
    {
        $operateurModel = new OperateurModel();
        $montantFraisModel = new MontantFraisModel();

        $gains = $operateurModel->getGainsParOperateur();
        $totalGains = $operateurModel->getGainsTotaux();
        $baremes = $montantFraisModel->orderBy('montant1', 'ASC')->findAll();

        $operateur = session()->get('operateur');

        return view('operateur/situation', [
            'gains'      => $gains,
            'totalGains' => $totalGains,
            'baremes'    => $baremes,
            'operateur'  => $operateur,
        ]);
    }
}
