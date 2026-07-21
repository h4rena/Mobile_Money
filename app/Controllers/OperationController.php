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

        $idOperateurEmetteur = ($operateurEmetteur['type'] === 'operateur')
            ? $operateurEmetteur['id_operateur']
            : null;

        $frais = 0;

        if ($typeOp['libelle'] === 'Depot') {
            $nouveauSolde = $client['solde'] + $montant;

            $db = \Config\Database::connect();
            $db->transStart();

            $clientModel->update($id_client, ['solde' => $nouveauSolde]);

            $operationModel->insert([
                'id_operateur'      => $idOperateurEmetteur,
                'id_type_operation' => $id_type_operation,
                'id_client'         => $id_client,
                'montant'           => $montant,
                'frais'             => 0,
                'date_operation'    => date('Y-m-d H:i:s'),
            ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Erreur lors de l\'opération');
            }

            $client['solde'] = $nouveauSolde;
            session()->set('client', $client);

            return redirect()->to('/dashboard')->with('success', 'Dépôt effectué avec succès');

        } elseif ($typeOp['libelle'] === 'Retrait') {
            $ligne = $montantFraisModel->getFraisByMontant($montant);
            $frais = $ligne ? $ligne['frais'] : 0;

            if ($client['solde'] < $montant + $frais) {
                return redirect()->back()->with('error', 'Solde insuffisant');
            }
            $nouveauSolde = $client['solde'] - $montant - $frais;

            $db = \Config\Database::connect();
            $db->transStart();

            $clientModel->update($id_client, ['solde' => $nouveauSolde]);

            $operationModel->insert([
                'id_operateur'      => $idOperateurEmetteur,
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

            return redirect()->to('/dashboard')->with('success', 'Retrait effectué avec succès');

        } elseif ($typeOp['libelle'] === 'Transfert') {
            $destinataires = $this->request->getPost('numero_destinataire');
            if (empty($destinataires) || !is_array($destinataires)) {
                return redirect()->back()->with('error', 'Numéro du destinataire requis');
            }

            $destinataires = array_filter($destinataires, function($v) {
                return !empty(trim($v));
            });
            $destinataires = array_values($destinataires);

            if (count($destinataires) === 0) {
                return redirect()->back()->with('error', 'Numéro du destinataire requis');
            }

            $destData = [];
            foreach ($destinataires as $num) {
                $dest = $clientModel->getClientByNumero(trim($num));
                if (!$dest) {
                    return redirect()->back()->with('error', 'Destinataire non trouvé : ' . esc($num));
                }
                $opDest = $operateurModel->getOperateurByNumero($dest['numero']);
                if (!$opDest) {
                    return redirect()->back()->with('error', 'Opérateur non trouvé pour : ' . esc($num));
                }
                if ($opDest['type'] !== $operateurEmetteur['type'] || $opDest['id_operateur'] !== $operateurEmetteur['id_operateur']) {
                    return redirect()->back()->with('error', 'Envoi multiple réservé au même opérateur. Numéro incompatible : ' . esc($num));
                }
                $destData[] = $dest;
            }

            $inclusFrais = $this->request->getPost('inclus_frais');
            $nbDest = count($destData);
            $montantParDest = $montant / $nbDest;

            $ligne = $montantFraisModel->getFraisByMontant($montant);
            $frais = ($inclusFrais && $ligne) ? $ligne['frais'] : 0;

            if ($client['solde'] < $montant + $frais) {
                return redirect()->back()->with('error', 'Solde insuffisant');
            }

            $nouveauSolde = $client['solde'] - $montant - $frais;

            $dateOp = date('Y-m-d H:i:s');

            $db = \Config\Database::connect();
            $db->transStart();

            $clientModel->update($id_client, ['solde' => $nouveauSolde]);

            foreach ($destData as $dest) {
                $dest['solde'] += $montantParDest;
                $clientModel->update($dest['id_client'], ['solde' => $dest['solde']]);

                $operationModel->insert([
                    'id_operateur'      => $idOperateurEmetteur,
                    'id_type_operation' => $id_type_operation,
                    'id_client'         => $dest['id_client'],
                    'montant'           => $montantParDest,
                    'frais'             => 0,
                    'date_operation'    => $dateOp,
                ]);
            }

            $operationModel->insert([
                    'id_operateur'      => $idOperateurEmetteur,
                    'id_type_operation' => $id_type_operation,
                    'id_client'         => $id_client,
                    'montant'           => $montant,
                    'frais'             => $frais,
                    'date_operation'    => $dateOp,
                ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Erreur lors de l\'opération');
            }

            $client['solde'] = $nouveauSolde;
            session()->set('client', $client);

            $msg = $nbDest > 1
                ? "Transfert effectué à {$nbDest} destinataires avec succès"
                : "Transfert effectué avec succès";
            return redirect()->to('/dashboard')->with('success', $msg);

        } else {
            $nouveauSolde = $client['solde'];

            $db = \Config\Database::connect();
            $db->transStart();

            $clientModel->update($id_client, ['solde' => $nouveauSolde]);

            $operationModel->insert([
                'id_operateur'      => $idOperateurEmetteur,
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
