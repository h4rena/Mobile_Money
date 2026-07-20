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

        $prefixeModel = new \App\Models\PrefixeModel();
        $pref = $prefixeModel->where('prefixe', $prefixe)->first();

        if (!$pref) {
            return null;
        }

        return $this->where('id_prefixe', $pref['id_prefixe'])->first();
    }

    public function getGainsParOperateur()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('operations o');

        $builder->select("
            op.nom_operateur,
            tp.libelle AS type_operation,
            SUM(mf.frais) AS total_frais,
            COUNT(o.id_operation) AS nombre_operations,
            SUM(o.montant) AS total_montant
        ");
        $builder->join('operateurs op', 'op.id_operateur = o.id_operateur');
        $builder->join('type_operation tp', 'tp.id_type_operation = o.id_type_operation');
        $builder->join('montant_frais mf', 'o.montant >= mf.montant1 AND o.montant <= mf.montant2');
        $builder->whereIn('o.id_type_operation', [2, 3]);
        $builder->groupBy('op.nom_operateur, tp.libelle');
        $builder->orderBy('op.nom_operateur, tp.libelle');

        return $builder->get()->getResultArray();
    }

    public function getGainsTotaux()
    {
        $gains = $this->getGainsParOperateur();
        $total = 0;
        foreach ($gains as $g) {
            $total += $g['total_frais'];
        }
        return $total;
    }
}
