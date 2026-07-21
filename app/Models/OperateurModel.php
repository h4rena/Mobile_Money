<?php

namespace App\Models;

use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table = 'operateurs';
    protected $primaryKey = 'id_operateur';
    protected $allowedFields = ['id_prefixe', 'nom_operateur'];

    public function getOperateurByNumero(string $numero)
    {
        $prefixe = substr($numero, 0, 3);

        $monPrefixeModel = new MonPrefixeModel();
        $isMonPrefixe = $monPrefixeModel->where('prefixe', $prefixe)->first();

        if ($isMonPrefixe) {
            $monOpModel = new MonOperateurModel();
            $monOp = $monOpModel->getMonOperateurAvecPrefixes();
            if ($monOp) {
                return [
                    'type'        => 'mon_operateur',
                    'id_operateur'=> $monOp['id_mon_operateur'],
                    'nom_operateur'=> 'Mon opérateur',
                    'prefixe'     => $monOp['prefixe'],
                ];
            }
        }

        $prefixeModel = new PrefixeModel();
        $pref = $prefixeModel->where('prefixe', $prefixe)->first();

        if (!$pref) {
            return null;
        }

        $op = $this->where('id_prefixe', $pref['id_prefixe'])->first();
        if ($op) {
            return [
                'type'         => 'operateur',
                'id_operateur' => $op['id_operateur'],
                'nom_operateur'=> $op['nom_operateur'],
                'prefixe'      => $pref['prefixe'],
            ];
        }

        return null;
    }

    public function getGainsParOperateur(?string $filtreType = null)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('v_gains v');

        $builder->select("
            v.nom_operateur,
            v.type_operation,
            SUM(v.frais_calcule) AS total_frais,
            COUNT(v.id_operation) AS nombre_operations,
            SUM(v.montant) AS total_montant
        ");

        if ($filtreType === 'retrait') {
            $builder->where('v.type_operation', 'Retrait');
        } elseif ($filtreType === 'transfert') {
            $builder->where('v.type_operation', 'Transfert');
        }

        $builder->groupBy('v.nom_operateur, v.type_operation');
        $builder->orderBy('v.nom_operateur, v.type_operation');

        return $builder->get()->getResultArray();
    }

    public function getGainsTotaux(?string $filtreType = null)
    {
        $gains = $this->getGainsParOperateur($filtreType);
        $total = 0;
        foreach ($gains as $g) {
            $total += $g['total_frais'];
        }
        return $total;
    }
}
