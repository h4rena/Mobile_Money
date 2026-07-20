<?php

namespace App\Controllers;

use App\Models\MontantFraisModel;

class MontantFraisController extends BaseController
{
    private function getMontantFraisModel()
    {
        return new MontantFraisModel();
    }

    public function index()
    {
        $montantFrais = $this->getMontantFraisModel()->findAll();
        return view('montant_frais/index', ['montantFrais' => $montantFrais]);
    }

    public function show($id = null)
    {
        $montantFrais = $this->getMontantFraisModel()->find($id);
        if (!$montantFrais) {
            return redirect()->to('/montant-frais')->with('error', 'Montant/Frais non trouvé');
        }
        return view('montant_frais/show', ['montantFrais' => $montantFrais]);
    }

    public function create()
    {
        return view('montant_frais/create');
    }

    public function store()
    {
        $data = $this->request->getPost();
        $this->getMontantFraisModel()->insert($data);
        return redirect()->to('/montant-frais')->with('success', 'Montant/Frais créé avec succès');
    }

    public function edit($id = null)
    {
        $montantFrais = $this->getMontantFraisModel()->find($id);
        if (!$montantFrais) {
            return redirect()->to('/montant-frais')->with('error', 'Montant/Frais non trouvé');
        }
        return view('montant_frais/edit', ['montantFrais' => $montantFrais]);
    }

    public function update($id = null)
    {
        $data = $this->request->getPost();
        $this->getMontantFraisModel()->update($id, $data);
        return redirect()->to('/montant-frais')->with('success', 'Montant/Frais mis à jour');
    }

    public function delete($id = null)
    {
        $this->getMontantFraisModel()->delete($id);
        return redirect()->to('/montant-frais')->with('success', 'Montant/Frais supprimé');
    }
}
