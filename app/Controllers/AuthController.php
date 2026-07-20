<?php
namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\UsersOperateurModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('client/login');
    }

    public function operateur()
    {
        return view('operateur/login');
    }

    public function log()
    {
        $numero = $this->request->getPost('numero');
        $clientModel = new ClientModel();
        $client = $clientModel->getClientByNumero($numero);

        if ($client) {
            session()->set('client', $client);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Numéro de téléphone incorrect.');
        }
    }

    public function log_operateur(){
        $email = $this->request->getPost('operateur');
        $mot_de_passe = $this->request->getPost('mdp');
        $usersOperateurModel = new UsersOperateurModel();
        $user = $usersOperateurModel->getUserByOperateurByEmail($email);
        if($mot_de_passe == $user['mot_de_passe']){
            session()->set('operateur', $user);
            return redirect()->to('/operateur/situation');
        }else{
            return redirect()->back()->with('error', 'Nom d\'operateur incorrect.');
        }
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
?>