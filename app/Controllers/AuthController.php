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


        $email = $this->request->getPost('email');
        $verificationToken = substr(md5(rand()), 0, 8);

        $data = [
            'lastName' => $this->request->getPost('lastName'),
            'firstName' => $this->request->getPost('firstName'),
            'auth'      => $verificationToken,
            'contactNo' => $this->request->getPost('contactNo'),
            'email'   => $email,
            'userName' => $this->request->getPost('userName'),
            'role' => $this->request->getPost('role'),
            'status' => 'Inactive',
            'address' => $this->request->getPost('address'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        $model->save($data);
        // return $this->response->setJSON(['success' => true,
        //                                  'message' => 'Resgistration Successful']);

        $this->accActivationsend($email, $verificationToken);
        return redirect()->to('/register'); 
        
    }

    private function accActivationsend($email, $verificationToken)
    {
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setFrom('rontaledankeneth@gmail.com', 'Trashtobigas');
        $emailService->setSubject('Email Verification');
        $emailService->setMessage("Dear user <br> this is your Activation Link <a href=". base_url() . '/active/' . $verificationToken .">Activate</a>" );

        $emailService->send();

    }

    public function activeAccount($verificationToken)
    {
        $activateUser = $this->user->where('auth', $verificationToken)->first();

        $data = ['status' => 'Active'];

        $this->user->where('id', $activateUser['id'])->set($data)->update();

        return redirect()->to('/adminlogin')->with('msg', 'Account is now activated');
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
    // //forgot pasword
    // public function forgot()
    // {
    //     $email = $this->request->getPost('email');
    
    //     $user = $this->user->where('LOWER(email)', strtolower($email))->first();

    //     $verificationToken = substr(md5(rand()), 0, 8);

    //     if ($user) {
    //         // print($user['id']);

    //         $data = ['auth' => $verificationToken];

    //         $this->user->where('id', $user['id'])->set($data)->update();



    //         $this->sendEmailResetpassword($email, $verificationToken);
    //         return redirect()->to('/')->with('msg', 'Check your Email');

    //     } else {

    //         return redirect()->to('/')->with('error', 'user not found try again');
    //     }
    // }


    public function resetthispassword($id)
    {
             $verificationToken = substr(md5(rand()), 0, 8);
       $user= $this->user->where('id', $id)->first();

       $email = $user['email'];


       $data = ['auth' => $verificationToken];
       $this->user->where('id', $id)->set($data)->update();
       $this->sendEmailResetpassword($email, $verificationToken);

       return redirect()->to('/register')->with('msg', 'The reset link has been send in to the users email');
       
    }
    public function sendEmailResetpassword($email, $verificationToken)
    {
        $activationLink = base_url("resetpassword/" . $verificationToken);

        $message = '<html>
        <head>
            <style>
                .btn {
                    background-color: #28a745;
                    color: white;
                    padding: 10px 20px;
                    text-decoration: none;
                    border-radius: 5px;
                    display: inline-block;
                    margin-top: 15px;
                }
                .container {
                    font-family: Arial, sans-serif;
                    padding: 20px;
                    border: 1px solid #e0e0e0;
                    border-radius: 10px;
                    max-width: 500px;
                    margin: auto;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2>Email Verification</h2>
                <p>Hello! Thank you for registering. Please click the button below to verify your email and activate your account.</p>
                <a href="'.$activationLink.'" class="btn">Activate Account</a>
                <p>If the button above does not work, copy and paste the link below into your browser:</p>
                <p style="margin-top: 20px;">If you did not request this, please ignore this email.</p>
            </div>
        </body>
    </html>
';


        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setMailType('html');
        $emailService->setFrom('rontaledankeneth@gmail.com', 'Trashtobigas');
        $emailService->setSubject('Email Verification');
        $emailService->setMessage($message);

        $emailService->send();

    }


    public function resetPassword($auth)
    {
       $user =  $this->user->where('auth', $auth)->first();
     

      if($user)
      {
    $id= $user['id'];
      $data =  ['user' => $this->user->where('id', $id)->first()];
      return view('admin/changepassword', $data);
      }
      else{
        return redirect()->to('adminlogin')->with('error', 'user not found try again');
      }
    

    }

    public function resetpasswordcon($id)
    {
        helper(['form']);

        $pass = $this->request->getPost('password');
            $rules = [
                'password' => 'required|min_length[6]',
                'confirmpassword' => 'required|matches[password]'
            ];
    
            $messages = [
                'confirmpassword' => [
                    'matches' => 'Confirm password does not match the password.'
                ]
            ];
    
            if (!$this->validate($rules, $messages)) {
                return view('register', [
                    'validation' => $this->validator
                ]);
            }

            
            
            $data =['password' =>password_hash($pass, PASSWORD_DEFAULT), 'auth' => null];


            $this->user->where('id', $id)->set($data)->update();
            


        
        return redirect()->to('adminlogin')->with('msg', 'password reset successfully');


    }
    public function buttonsample()
    {
     echo   '<form action="/send" method="post"><button type="submit">send</button></form>';
    }

    public function sendSample()
{
    $emailService = \Config\Services::email();
    $emailService->setTo('danrontalem@gmail.com');
    $emailService->setFrom('rontaledankeneth@gmail.com', 'Trashtobigas');
    $emailService->setSubject('Email Verification');
    $emailService->setMessage("Hello This is Your Verification Token Dont Share it to any one ");


    if($emailService->send())
    {
        echo"Success";
    }
    else{
        echo"Failed";
    }

    // echo"hello";
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
        return redirect()->to('adminlogin');
    }
}
