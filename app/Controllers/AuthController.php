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

        date_default_timezone_set('Asia/Manila');
        $this->user = new UserModel;
    }


    public function login()
    {
        return view('admin/login'); // Points to the login view
    }

    public function showUser()
    {
       $users = $this->user->findAll();

        return $this->response->setJSON($users);
    }

    public function viewRegister()
    {

        $data['user'] = $this->user->findAll();
        return view('register', $data);
    }

    public function disableaccount($id)
    {
        $data =['status' => 'Inactive',
                'updated_at' => date('Y-m-d H:i:s', time())];
        $this->user->where('id', $id)->set($data)->update();
        session()->set($data);
        return redirect()->to('register');
    }

    public function enableaccount($id)
    {

        $data = ['status' => 'Active'];
        session()->set($data);
        $this->user->where('id', $id)->set($data)->update();

        return redirect()->to('register');
    }

    public function deleteUser($id)
    {
        $this->user->delete($id);

        return redirect()->back()->withInput();

    }
    public function register()
    {

        $model = new UserModel();


        $data = [
            'lastName' => $this->request->getPost('lastName'),
            'firstName' => $this->request->getPost('firstName'),
            'contactNo' => $this->request->getPost('contactNo'),
            'userName' => $this->request->getPost('userName'),
            'role' => $this->request->getPost('role'),
            'status' => 'Active',
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        $model->save($data);
        return $this->response->setJSON(['success' => true,
                                         'message' => 'Resgistration Successful']);
        
    }


    public function updateUser()
    {
        $model = new UserModel();

        $id = $this->request->getPost('id');


        $data = [
            'lastName' => $this->request->getPost('lastName'),
            'firstName' => $this->request->getPost('firstName'),
            'contactNo' => $this->request->getPost('contactNo'),
            'role' => $this->request->getPost('role'),
            'status' => 'Active',

        ];

        $model->where('id', $id)->set($data)->update();

        return redirect()->to('register');

        

    }

    public function attemptLogin()
    {
        $session = session();
        $model = new UserModel();
    
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
    
        // Retrieve user record
        $user = $model->where('userName', $username)->first();
    
        if (!$user) {
            $session->setFlashdata('error', 'Invalid username or password.');
            return redirect()->back()->withInput();
        }
    
        // Verify password
        if (!password_verify($password, $user['password'])) {
            $session->setFlashdata('error', 'Invalid username or password.');
            return redirect()->back()->withInput();
        }
    
        if ($user['status'] === 'Inactive') {
            $session->setFlashdata('error', 'Your account is inactive. Please contact admin.');
            // $session->destroy();
            return redirect()->back()->withInput();
        }
    

        $sessionData = [
            'id' => $user['id'],
            'userName' => $user['userName'],
            'lastName' => $user['lastName'],
            'firstName' => $user['firstName'],
            'contactNo' => $user['contactNo'],
            'role' => $user['role'],
            'status' => $user['status'],
            'isLoggedIn' => true
        ];
        $session->set($sessionData);
    
        return redirect()->to('/home');
    }
       
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
