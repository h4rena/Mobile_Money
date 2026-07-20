<?php
namespace App\Controllers;

use App\Models\ClientModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('client/login');
    }

    public function log()
    {
        $numero = $this->request->getPost('numero');
        $clientModel = new ClientModel();
        $client = $clientModel->getClientByNumero($numero);

        if ($client) {
            $session = session();
            $session->set('numero', $client['numero']);
            $session->set('client', $client);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Numéro de téléphone incorrect.');
        }
    }
}
?>