<?php

namespace App\Controllers;

use App\Models\PrefixeModel;
use App\Models\OperateurModel;

class PrefixeController extends BaseController
{
    public function index()
    {
        $operateur = session()->get('operateur');
        if (!$operateur) {
            return redirect()->to('/operateur/login');
        }

        $prefixeModel = new PrefixeModel();
        $operateurModel = new OperateurModel();

        $currentPrefixe = $prefixeModel->find($operateur['id_prefixe']);
        $allPrefixes = $prefixeModel->findAll();

        return view('prefixe/index', [
            'operateur'      => $operateur,
            'currentPrefixe' => $currentPrefixe,
            'allPrefixes'    => $allPrefixes,
        ]);
    }

    public function update()
    {
        $operateur = session()->get('operateur');
        if (!$operateur) {
            return redirect()->to('/operateur/login');
        }

        $idPrefixe = $this->request->getPost('id_prefixe');

        if (!$idPrefixe) {
            return redirect()->back()->with('error', 'Veuillez sélectionner un préfixe.');
        }

        $operateurModel = new OperateurModel();
        $operateurModel->update($operateur['id_operateur'], ['id_prefixe' => $idPrefixe]);

        $prefixeModel = new PrefixeModel();
        $newPrefixe = $prefixeModel->find($idPrefixe);

        $updatedOperateur = array_merge($operateur, [
            'id_prefixe'    => $idPrefixe,
            'prefixe'       => $newPrefixe['prefixe'],
        ]);
        session()->set('operateur', $updatedOperateur);

        return redirect()->to('/prefixes')->with('success', 'Préfixe mis à jour : ' . $newPrefixe['prefixe']);
    }
}
