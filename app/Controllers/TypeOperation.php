<?php

namespace App\Controllers;

use App\Models\TypeOperationModel;

class TypeOperation extends BaseController
{
    private function getTypeOperationModel()
    {
        return new TypeOperationModel();
    }

    public function index()
    {
        $typeOperations = $this->getTypeOperationModel()->findAll();
        return view('type_operation/index', ['typeOperations' => $typeOperations]);
    }

    public function show($id = null)
    {
        $typeOperation = $this->getTypeOperationModel()->find($id);
        if (!$typeOperation) {
            return redirect()->to('/type-operations')->with('error', 'Type d\'opération non trouvé');
        }
        return view('type_operation/show', ['typeOperation' => $typeOperation]);
    }

    public function create()
    {
        return view('type_operation/create');
    }

    public function store()
    {
        $data = $this->request->getPost();
        $this->getTypeOperationModel()->insert($data);
        return redirect()->to('/type-operations')->with('success', 'Type d\'opération créé avec succès');
    }

    public function edit($id = null)
    {
        $typeOperation = $this->getTypeOperationModel()->find($id);
        if (!$typeOperation) {
            return redirect()->to('/type-operations')->with('error', 'Type d\'opération non trouvé');
        }
        return view('type_operation/edit', ['typeOperation' => $typeOperation]);
    }

    public function update($id = null)
    {
        $data = $this->request->getPost();
        $this->getTypeOperationModel()->update($id, $data);
        return redirect()->to('/type-operations')->with('success', 'Type d\'opération mis à jour');
    }

    public function delete($id = null)
    {
        $this->getTypeOperationModel()->delete($id);
        return redirect()->to('/type-operations')->with('success', 'Type d\'opération supprimé');
    }
}
