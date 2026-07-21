<?php

namespace App\Controllers;

use App\Models\CommissionModel;
use App\Models\OperateurModel;

class CommissionController extends BaseController
{
    private function getCommissionModel()
    {
        return new CommissionModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $commissions = $db->table('v_commission_noms')->get()->getResultArray();

        return view('operateur/commission/index', [
            'commissions' => $commissions,
        ]);
    }

    public function create()
    {
        $operateurModel = new OperateurModel();
        $operateurs = $operateurModel->findAll();

        return view('operateur/commission/create', [
            'operateurs' => $operateurs,
        ]);
    }

    public function store()
    {
        $data = [
            'id_operateur_source' => $this->request->getPost('id_operateur_source'),
            'id_operateur_dest'   => $this->request->getPost('id_operateur_dest'),
            'taux'                => (float) $this->request->getPost('taux'),
        ];

        if ($data['id_operateur_source'] === $data['id_operateur_dest']) {
            return redirect()->back()->with('error', 'L\'opérateur source et destination doivent être différents');
        }

        if ($data['taux'] <= 0 || $data['taux'] > 100) {
            return redirect()->back()->with('error', 'Le taux doit être entre 0 et 100');
        }

        $commissionModel = $this->getCommissionModel();
        $existing = $commissionModel
            ->where('id_operateur_source', $data['id_operateur_source'])
            ->where('id_operateur_dest', $data['id_operateur_dest'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Une commission existe déjà pour cette paire d\'opérateurs');
        }

        $commissionModel->insert($data);
        return redirect()->to('/commission')->with('success', 'Commission ajoutée avec succès');
    }

    public function edit($id = null)
    {
        $commissionModel = $this->getCommissionModel();
        $operateurModel = new OperateurModel();

        $commission = $commissionModel->find($id);
        if (!$commission) {
            return redirect()->to('/commission')->with('error', 'Commission non trouvée');
        }

        $operateurs = $operateurModel->findAll();

        return view('operateur/commission/edit', [
            'commission' => $commission,
            'operateurs' => $operateurs,
        ]);
    }

    public function update($id = null)
    {
        $data = [
            'id_operateur_source' => $this->request->getPost('id_operateur_source'),
            'id_operateur_dest'   => $this->request->getPost('id_operateur_dest'),
            'taux'                => (float) $this->request->getPost('taux'),
        ];

        if ($data['id_operateur_source'] === $data['id_operateur_dest']) {
            return redirect()->back()->with('error', 'L\'opérateur source et destination doivent être différents');
        }

        if ($data['taux'] <= 0 || $data['taux'] > 100) {
            return redirect()->back()->with('error', 'Le taux doit être entre 0 et 100');
        }

        $commissionModel = $this->getCommissionModel();
        $commissionModel->update($id, $data);
        return redirect()->to('/commission')->with('success', 'Commission mise à jour');
    }

    public function delete($id = null)
    {
        $this->getCommissionModel()->delete($id);
        return redirect()->to('/commission')->with('success', 'Commission supprimée');
    }
}
