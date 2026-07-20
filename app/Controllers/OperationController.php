<?php

namespace App\Controllers;

use App\Models\OperationModel;

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

    public function create()
    {
        return view('operation/create');
    }

    public function store()
    {
        $data = $this->request->getPost();
        $this->getOperationModel()->insert($data);
        return redirect()->to('/operations')->with('success', 'Opération créée avec succès');
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
