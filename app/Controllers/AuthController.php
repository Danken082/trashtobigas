<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    private $maxLoginAttempts = 5;
    private $lockoutTime = 300;

    private $user;
    public function __construct()
    {
        $this->user = new UserModel;
    }
    public function login()
    {
        return view('admin/login'); // Points to the login view
    }


    public function viewRegister()
    {
        return view('register');
    }
    public function register()
    {

        $model = new UserModel();


        $data = [
            'lastName' => $this->request->getPost('lastName'),
            'firstName' => $this->request->getPost('firstName'),
            'contactNo' => $this->request->getPost('contactNo'),
            'userName' => $this->request->getPost('userName'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        $model->save($data);
        session()->setFlashdata('success', 'Registration successful. Please login.');
        return redirect()->to('/login');
        
    }

    public function attemptLogin()
    {
        $session = session();
        $model = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('userName', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            $sessionData = [
                'id' => $user['id'],
                'userName' => $user['userName'],
                'lastName' => $user['lastName'],
                'firstName' => $user['firstName'],
                'contactNo' => $user['contactNo'],
                'isLoggedIn' => true
            ];
            $session->set($sessionData);
            return redirect()->to('/home');


        } else {
            $session->setFlashdata('error', 'Invalid username or password');


            return redirect()->back();   

            // echo 2;
        }


    }
    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
