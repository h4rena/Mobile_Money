<?php

namespace App\Controllers;

use App\Models\PrefixeModel;

class PrefixeController extends BaseController
{

    private function getPrefixebyIdModel($id)
    {
        $prefixeModel = new PrefixeModel();
        return $prefixeModel->find($id);
    }

    private function getAllPrefixeModel()
    {
        $prefixeModel = new PrefixeModel();
        return $prefixeModel->findAll();
    }

    public function index()
    {
        $prefixes = $this->getAllPrefixeModel();
        return view('test/index', ['prefixes' => $prefixes]);
    }


}