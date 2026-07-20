<?php

namespace App\Controllers;

use App\Models\OperateurModel;

class Operateur extends BaseController
{
    private function getOperateurModel()
    {
        return new OperateurModel();
    }

    public function index()
    {
        $operateurs = $this->getOperateurModel()->findAll();
        return view('operateur/index', ['operateurs' => $operateurs]);
    }

    public function show($id = null)
    {
        $operateur = $this->getOperateurModel()->find($id);
        if (!$operateur) {
            return redirect()->to('/operateurs')->with('error', 'Opérateur non trouvé');
        }
        return view('operateur/show', ['operateur' => $operateur]);
    }

    public function create()
    {
        return view('operateur/create');
    }

    public function store()
    {
        $data = $this->request->getPost();
        $this->getOperateurModel()->insert($data);
        return redirect()->to('/operateurs')->with('success', 'Opérateur créé avec succès');
    }

    public function edit($id = null)
    {
        $operateur = $this->getOperateurModel()->find($id);
        if (!$operateur) {
            return redirect()->to('/operateurs')->with('error', 'Opérateur non trouvé');
        }
        return view('operateur/edit', ['operateur' => $operateur]);
    }

    public function update($id = null)
    {
        $data = $this->request->getPost();
        $this->getOperateurModel()->update($id, $data);
        return redirect()->to('/operateurs')->with('success', 'Opérateur mis à jour');
    }

    public function delete($id = null)
    {
        $this->getOperateurModel()->delete($id);
        return redirect()->to('/operateurs')->with('success', 'Opérateur supprimé');
    }
}
