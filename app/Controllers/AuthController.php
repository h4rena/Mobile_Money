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
<<<<<<< HEAD
            session()->set('client', $client);
=======
            $session = session();
            $session->set('numero', $client['numero']);
            $session->set('client', $client);
>>>>>>> dev
            return view('client/dashboard', ['client' => $client]);
        } else {
            return redirect()->back()->with('error', 'Numéro de téléphone incorrect.');
        }
    }

    public function dashboard()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter');
        }
        return view('client/dashboard', ['client' => $client]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}

?>