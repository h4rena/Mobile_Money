<?php

namespace App\Controllers;

use App\Models\OperationModel;
use App\Models\ClientModel;
use App\Models\TypeOperationModel;
use App\Models\OperateurModel;
use App\Models\MontantFraisModel;
use App\Models\CommissionModel;

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

        $clientModel       = new ClientModel();
        $typeOpModel       = new TypeOperationModel();
        $operationModel    = new OperationModel();
        $operateurModel    = new OperateurModel();
        $montantFraisModel = new MontantFraisModel();
        $commissionModel   = new CommissionModel();

        $client = $clientModel->find($id_client);
        if (!$client) {
            return redirect()->back()->with('error', 'Client non trouvé');
        }

        $typeOp = $typeOpModel->find($id_type_operation);
        if (!$typeOp) {
            return redirect()->back()->with('error', 'Type d\'opération non trouvé');
        }

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Le montant doit être supérieur à 0');
        }

        $operateurEmetteur = $operateurModel->getOperateurByNumero($client['numero']);
        if (!$operateurEmetteur) {
            return redirect()->back()->with('error', 'Opérateur non trouvé pour ce numéro');
        }

        $frais = 0;

        if ($typeOp['libelle'] === 'Depot') {
            $nouveauSolde = $client['solde'] + $montant;

        } elseif ($typeOp['libelle'] === 'Retrait') {
            $ligne = $montantFraisModel->getFraisByMontant($montant);
            $frais = $ligne ? $ligne['frais'] : 0;

            if ($client['solde'] < $montant + $frais) {
                return redirect()->back()->with('error', 'Solde insuffisant');
            }
            $nouveauSolde = $client['solde'] - $montant - $frais;

        } elseif ($typeOp['libelle'] === 'Transfert') {
            $numero_dest = $this->request->getPost('numero_destinataire');
            if (!$numero_dest) {
                return redirect()->back()->with('error', 'Numéro du destinataire requis');
            }

            $destinataire = $clientModel->getClientByNumero($numero_dest);
            if (!$destinataire) {
                return redirect()->back()->with('error', 'Destinataire non trouvé');
            }

            $operateurDest = $operateurModel->getOperateurByNumero($destinataire['numero']);
            if (!$operateurDest) {
                return redirect()->back()->with('error', 'Opérateur du destinataire non trouvé');
            }

            $ligne = $montantFraisModel->getFraisByMontant($montant);
            $frais = $ligne ? $ligne['frais'] : 0;

            if ($operateurEmetteur['id_operateur'] !== $operateurDest['id_operateur']) {
                $commission = $commissionModel->getTaux(
                    $operateurEmetteur['id_operateur'],
                    $operateurDest['id_operateur']
                );
                if ($commission) {
                    $frais += $montant * ($commission['taux'] / 100);
                }
            }

            if ($client['solde'] < $montant + $frais) {
                return redirect()->back()->with('error', 'Solde insuffisant');
            }

            $nouveauSolde = $client['solde'] - $montant - $frais;

            $destinataire['solde'] += $montant;
            $clientModel->update($destinataire['id_client'], ['solde' => $destinataire['solde']]);

        } else {
            $nouveauSolde = $client['solde'];
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $clientModel->update($id_client, ['solde' => $nouveauSolde]);

        $operationModel->insert([
            'id_operateur'      => $operateurEmetteur['id_operateur'],
            'id_type_operation' => $id_type_operation,
            'id_client'         => $id_client,
            'montant'           => $montant,
            'frais'             => $frais,
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
