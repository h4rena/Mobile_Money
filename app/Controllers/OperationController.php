<?php

namespace App\Controllers;

use App\Models\OperationModel;
use App\Models\ClientModel;
use App\Models\TypeOperationModel;
use App\Models\OperateurModel;
use App\Models\MontantFraisModel;

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

    public function retrait()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter');
        }
        return view('client/retrait', ['client' => $client]);
    }

    public function transfert()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter');
        }
        return view('client/transfert', ['client' => $client]);
    }

    public function store()
    {
        $id_client         = $this->request->getPost('id_client');
        $id_type_operation = $this->request->getPost('id_type_operation');
        $montant           = (float) $this->request->getPost('montant');

        $clientModel    = new ClientModel();
        $typeOpModel    = new TypeOperationModel();
        $operationModel = new OperationModel();
        $operateurModel = new OperateurModel();
        $montantFraisModel = new MontantFraisModel();

        $typeOp = $typeOpModel->find($id_type_operation);
        $client = $clientModel->find($id_client);
        $frais = 0;

        if (!$client) {
            return redirect()->back()->with('error', 'Client non trouvé');
        }

        $operateur = $operateurModel->getOperateurByNumero($client['numero']);
        if (!$operateur) {
            return redirect()->back()->with('error', 'Opérateur non trouvé pour ce numéro');
        }

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Le montant doit être supérieur à 0');
        }

        if ($typeOp['libelle'] === 'Retrait' || $typeOp['libelle'] === 'Transfert') {
        $ligne = $montantFraisModel->getFraisByMontant($montant);
        $frais = $ligne ? $ligne['frais'] : 0;
        }

        $nouveauSolde = $client['solde'];

        if ($typeOp['libelle'] === 'Depot') {
            $nouveauSolde += $montant;

        } elseif ($typeOp['libelle'] === 'Retrait') {
            if ($client['solde'] < $montant + $frais) {
                return redirect()->back()->with('error', 'Solde insuffisant');
            }
            $nouveauSolde -= $montant + $frais;

        } elseif ($typeOp['libelle'] === 'Transfert') {
            if ($client['solde'] < $montant + $frais) {
                return redirect()->back()->with('error', 'Solde insuffisant');
            }
            $nouveauSolde -= $montant + $frais;

            $numero_dest = $this->request->getPost('numero_destinataire');
            $destinataire = $clientModel->getClientByNumero($numero_dest);
            if (!$destinataire) {
                return redirect()->back()->with('error', 'Destinataire non trouvé');
            }
            $destinataire['solde'] += $montant;
            $clientModel->update($destinataire['id_client'], ['solde' => $destinataire['solde']]);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $clientModel->update($id_client, ['solde' => $nouveauSolde]);

        $operationModel->insert([
            'id_operateur'      => $operateur['id_operateur'],
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
