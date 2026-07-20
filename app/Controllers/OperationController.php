<?php

namespace App\Controllers;

use App\Models\OperationModel;
use App\Models\ClientModel;
use App\Models\TypeOperationModel;

class OperationController extends BaseController
{
    private function getOperationModel()
    {
        return new OperationModel();
    }

    public function index()
    {
        $operations = $this->getOperationModel()->findAll();
        return view('operation/index', ['operations' => $operations]);
    }

    public function show($id = null)
    {
        $operation = $this->getOperationModel()->find($id);
        if (!$operation) {
            return redirect()->to('/operations')->with('error', 'Opération non trouvée');
        }
        return view('operation/show', ['operation' => $operation]);
    }

    public function depot()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter');
        }
        return view('client/depot', ['client' => $client]);
    }

    public function store()
    {
        $id_client         = $this->request->getPost('id_client');
        $id_type_operation = $this->request->getPost('id_type_operation');
        $montant           = (float) $this->request->getPost('montant');
        $id_operateur      = $this->request->getPost('id_operateur');

        $clientModel    = new ClientModel();
        $typeOpModel    = new TypeOperationModel();
        $operationModel = new OperationModel();

        $typeOp = $typeOpModel->find($id_type_operation);
        $client = $clientModel->find($id_client);

        if (!$client) {
            return redirect()->back()->with('error', 'Client non trouvé');
        }

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Le montant doit être supérieur à 0');
        }

        $nouveauSolde = $client['solde'];

        if ($typeOp['libelle'] === 'Depot') {
            $nouveauSolde += $montant;

        } elseif ($typeOp['libelle'] === 'Retrait') {
            if ($client['solde'] < $montant) {
                return redirect()->back()->with('error', 'Solde insuffisant');
            }
            $nouveauSolde -= $montant;

        } elseif ($typeOp['libelle'] === 'Transfert') {
            if ($client['solde'] < $montant) {
                return redirect()->back()->with('error', 'Solde insuffisant');
            }
            $nouveauSolde -= $montant;
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $clientModel->update($id_client, ['solde' => $nouveauSolde]);

        $operationModel->insert([
            'id_operateur'      => $id_operateur,
            'id_type_operation' => $id_type_operation,
            'id_client'         => $id_client,
            'montant'           => $montant,
            'date_operation'    => date('Y-m-d H:i:s'),
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Erreur lors de l\'opération');
        }

        $client['solde'] = $nouveauSolde;
        session()->set('client', $client);

        return redirect()->to('/dashboard')->with('success', 'Opération effectuée avec succès');
    }

    public function edit($id = null)
    {
        $operation = $this->getOperationModel()->find($id);
        if (!$operation) {
            return redirect()->to('/operations')->with('error', 'Opération non trouvée');
        }
        return view('operation/edit', ['operation' => $operation]);
    }

    public function update($id = null)
    {
        $data = $this->request->getPost();
        $this->getOperationModel()->update($id, $data);
        return redirect()->to('/operations')->with('success', 'Opération mise à jour');
    }

    public function delete($id = null)
    {
        $this->getOperationModel()->delete($id);
        return redirect()->to('/operations')->with('success', 'Opération supprimée');
    }
}
