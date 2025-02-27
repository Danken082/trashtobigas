<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{


    private $user;
    public function __construct()
    {
        $this->user = new UserModel;
    }
    public function login()
    {
        return view('admin/login'); // Points to the login view
    }

    public function attemptLogin()
    {
        $session = session();
    
        $username = $this->request->getVar('username'); // Get input from form field
        $password = $this->request->getVar('password');
    
        $user = $this->user->where('userName', $username)->first();
    
        if ($user) {
    
            $pass = $user['password'];
            $authenticate = password_verify($password, $pass);
    
            if ($authenticate) {
                $ses_data = [
                    'id' => $user['id'],
                    'firstName' => $user['firstName'],
                    'lastName' => $user['lastName'],
                    'contactNo' => $user['contactNo'],
                    'userName' => $user['userName'],
                    'isLoggedIn' => TRUE
                ];
    
                $session->set($ses_data);
    
                return redirect()->to('/home');
            } else {
                $session->setFlashdata('msg', 'Incorrect Username or Password');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Invalid Username or Password');
            return redirect()->to('/login');
        }
    }
    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
