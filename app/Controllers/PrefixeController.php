<?php

namespace App\Controllers;

use App\Models\MonPrefixeModel;

class PrefixeController extends BaseController
{
    public function index()
    {
        $operateur = session()->get('operateur');
        if (!$operateur) {
            return redirect()->to('/operateur/login');
        }

        $monPrefixeModel = new MonPrefixeModel();
        $mesPrefixes = $monPrefixeModel->findAll();

        return view('prefixe/index', [
            'operateur'   => $operateur,
            'mesPrefixes' => $mesPrefixes,
        ]);
    }

    public function store()
    {
        $operateur = session()->get('operateur');
        if (!$operateur) {
            return redirect()->to('/operateur/login');
        }

        $prefixe = trim($this->request->getPost('prefixe') ?? '');

        if (empty($prefixe)) {
            return redirect()->back()->with('error', 'Le préfixe est obligatoire.');
        }

        $monPrefixeModel = new MonPrefixeModel();
        $count = $monPrefixeModel->countAllResults();

        if ($count >= 2) {
            return redirect()->back()->with('error', 'Vous ne pouvez avoir que 2 préfixes maximum.');
        }

        $exists = $monPrefixeModel->where('prefixe', $prefixe)->first();
        if ($exists) {
            return redirect()->back()->with('error', 'Ce préfixe existe déjà.');
        }

        $monPrefixeModel->insert(['prefixe' => $prefixe]);

        return redirect()->to('/prefixes')->with('success', 'Préfixe ajouté : ' . $prefixe);
    }

    public function edit($id)
    {
        $operateur = session()->get('operateur');
        if (!$operateur) {
            return redirect()->to('/operateur/login');
        }

        $monPrefixeModel = new MonPrefixeModel();
        $monPrefixe = $monPrefixeModel->find($id);
        if (!$monPrefixe) {
            return redirect()->to('/prefixes')->with('error', 'Préfixe non trouvé.');
        }

        return view('prefixe/edit', [
            'operateur'  => $operateur,
            'monPrefixe' => $monPrefixe,
        ]);
    }

    public function update($id)
    {
        $operateur = session()->get('operateur');
        if (!$operateur) {
            return redirect()->to('/operateur/login');
        }

        $prefixe = trim($this->request->getPost('prefixe') ?? '');

        if (empty($prefixe)) {
            return redirect()->back()->with('error', 'Le préfixe est obligatoire.');
        }

        $monPrefixeModel = new MonPrefixeModel();
        $exists = $monPrefixeModel->where('prefixe', $prefixe)->where('id_mon_prefixe !=', $id)->first();
        if ($exists) {
            return redirect()->back()->with('error', 'Ce préfixe existe déjà.');
        }

        $monPrefixeModel->update($id, ['prefixe' => $prefixe]);

        return redirect()->to('/prefixes')->with('success', 'Préfixe mis à jour.');
    }

    public function delete($id)
    {
        $operateur = session()->get('operateur');
        if (!$operateur) {
            return redirect()->to('/operateur/login');
        }

        $monPrefixeModel = new MonPrefixeModel();
        $monPrefixeModel->delete($id);

        return redirect()->to('/prefixes')->with('success', 'Préfixe supprimé.');
    }
}
