<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ClientModel;
use App\Models\RedeemHistoryModel;
use App\Models\HistoryModel;

class ClientController extends BaseController
{

    private $client;
    private $history;
    private $historyCon;

    public function __construct()
    {
        //helper or libraries here
        helper(['form']);

        $this->client = new ClientModel();
        $this->history = new RedeemHistoryModel();
        $this->historyCon = new HistoryModel();
    }
    public function index()
    {
        //
    }

    public function home()
    {

        if (!session()->get('id') || session()->get('role') === 'Admin' || session()->get('role') === 'Staff') {
            return redirect()->back();
        }
        else
        {
            return view('user/home');
        }
            
    }

    public function profile()
    {
        
        if (!session()->get('id') || session()->get('role') === 'Admin' || session()->get('role') === 'Staff') {
            return redirect()->back();
        }
        else
        {
        return view('user/profile');
    }
    }

    public function history()
    {

        

        if (!session()->get('id') || session()->get('role') === 'Admin' || session()->get('role') === 'Staff') {
            return redirect()->back();
        }
        else{
        $perPage = 5;
        $page = 5;
        $data = ['clienthistory' => $this->history->select('redeemed_items.user_id, redeemed_items.client_id, redeemed_items.product_id, redeemed_items.totalCurrentPoints,
                 redeemed_items.points_used, redeemed_items.redeem_Code, redeemed_items.created_at, user_tbl.address, user_tbl.userName, inventory_table.item')
                 ->join('user_tbl', 'user_tbl.id = redeemed_items.user_id')
                 ->join('inventory_table', 'inventory_table.id = redeemed_items.product_id')
                 ->where('client_id', session()->get('id'))
                 ->orderBy('created_at', 'DESC')->paginate($perPage),
                'pager' => $this->history->pager,
                'code' => $this->history->where('client_id', session()->get('id'))->groupBy('redeem_Code')->findAll(),
                'clienthistoryCon' => $this->historyCon->select('history.client_id, history.user_id, history.gatherPoints, history.weight, history.categ, history.created_at, history.totalCurrentPoints,
                user_tbl.address, user_tbl.userName')->join('user_tbl', 'user_tbl.id = history.user_id')->where('client_id', session()->get('id'))->findAll(),
                ];
        return view('user/history', $data);
    }

        // var_dump($data);
    }

    public function login()
    {
        if (session()->get('id')) {
            return redirect()->back();
        }
        else{
            return view('user/login');
        }
        
    }

    public function loginAuth()
    {
        $session = session();

        $username = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->client->where('email', $username)->first();

        if(!$user)
        {
            $session->setFlashdata('error', 'Invalid Username or Password');
            return redirect()->back()->withInput();
        }

        if(!password_verify($password, $user['password']))
        {
            $session->setFlashdata('error', 'Invalid Username or Password');
            return redirect()->back()->withInput();
        }

        if ($user['status'] === 'Inactive') {
            $session->setFlashdata('error', 'Your account is inactive. Please contact admin.');
            // $session->destroy();
            return redirect()->back()->withInput();
        }
    
        $sessionData = ['id' => $user['id'],
                        'lastName' => $user['lastName'],
                        'firstName' => $user['firstName'],
                        'user_ID'    => $user['user_ID'],
                        'idNumber'  => $user['idNumber'],
                        'birthdate' => $user['birthdate'],
                        'gender'    => $user['gender'],
                        'address'   => $user['address'],
                        'contactNo' => $user['contactNo'],
                        'qrcode'    => $user['qrcode'],
                        'email'      => $user['email'],
                        'uuid'      => $user['uuid'],
                        'password'  => $user['password'],
                        'img'       => $user['img'],
                        'auth'      => $user['auth'],
                        'status'    => $user['status'],
                        'totalPoints'=> $user['totalPoints'],
                        'isLoggedIn' => true

                    ];

        $session->set($sessionData);

        return redirect()->to('clienthome');
    }


    
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }
    public function resetPassword() 
    {

        $verificationToken = substr(md5(rand()), 0, 8);

        $email = $this->request->getGet('email');
        $userEmail = $this->client->where('email', $email)->first();
        // var_dump($email);
        $userid = $userEmail['id'];

        // var_dump($userid);

       $data = ['auth' => $verificationToken];

        
      
       if($userEmail)
       {
          $this->client->where('id', $userid)->set($data)->update();

        //   $this->sendEmail();
         return $this->sendEmail($email, $verificationToken);

       }

       else{
        sesion()->setFlasdata('error', 'Can`t Find Email');

        return redirect()->back()->withInput();
       }
    
    }

    public function uploadProfileImage()
{
    $img = $this->request->getFile('profile_img');
    $user = $this->request->getFile('samplefile');

    if ($img && $img->isValid() && !$img->hasMoved()) {
        $newName = $img->getRandomName();
        $imageService = \Config\Services::image();
        $img->move($_SERVER['DOCUMENT_ROOT'] . '/images/client/', $newName);


        // Update DB & session
        $id = session()->get('id');
        $this->client->update($id, ['img' => $newName]);
        session()->set('img', $newName);
    }

    $oldImage = session()->get('img');
    if ($oldImage !== 'profile.png' && file_exists($_SERVER['DOCUMENT_ROOT'] . 'images/client/' . $oldImage)) {
        unlink($_SERVER['DOCUMENT_ROOT'] . 'images/client/' . $oldImage);
    }

    return redirect()->to(base_url('clientprofile'))->with('msg', 'Profile image updated.');

    // echo($img);
    // echo(session()->get('img'));
    }

    public function changePassinProf()
    {

       $client = $this->client->where('id', session()->get('id'))->first();
       $current = $this->request->getPost('currentpassword');


    //    var_dump($client);

        if(password_verify($current, $client['password']))
        {
            $rule = ['newpassword' => 'required|min_length[6]',
                     'confirmpassword' => 'required|matches[newpassword]'];

            if(!$this->validate($rule))
            {
                return redirect()->back()->with('error', 'Password is not match or too short');
            }
            else{
                $data =['password' => password_hash($this->request->getPost('newpassword'), PASSWORD_DEFAULT)];
                $this->client->where('id', session()->get('id'))->set($data)->update();

                return redirect()->back()->with('msg', 'Password has been Change');

                session()->set($data);
            }
        }

        else{
            return redirect()->back()->with('error', 'Current password is incorrect');
        }
    }




    //client reset account email
    private function sendEmail($email, $verificationToken)
    {


        // $userver = $this->client->where('uuid')

        $activationLink = base_url("client/resetlink/" . $verificationToken);

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
                <p>Hello! User This is your Pasword reset link. Please click the button below to Reset your account</p>
                <a href="'.$activationLink.'" class="btn">Reset Password</a>
                <p>If the button above does not work, copy and paste the link below into your browser:</p>
                '.$activationLink.'
                <p style="margin-top: 20px;">If you did not request this, please ignore this email.</p>
            </div>
        </body>
    </html>
';
        
       $emailService = \Config\Services::email();
       $emailService->setMailType('html');
       $emailService->setTo($email);
       $emailService->setFrom('rontaledankeneth@gmail.com', 'Trashtobigas');
       $emailService->setSubject('Client reset account');
       $emailService->setMessage($message);

       if(!$emailService->send())
       {
           session()->setFlashdata('error', 'Can`t send email');
           return redirect()->back()->withInput();
       }
       else
       {
       return redirect()->to('/')->with('msg', 'Reset Code has been send check your email');
       }
       
    }

    public function clientResetView($verificationToken)
    {
       $client = $this->client->where('auth', $verificationToken)->first();
    //    $userID = $userver['id'];

    if($client)
    {

        $data = ['userdets' => $this->client->where('id', $client['id'])->first()];
        return view('user/changePassword', $data);
    }
    else{
        return redirect()->to('/')->with('error', 'Invalid Token');
    }

       
    }

    public function confirmtoreset($uuid)
    {


        $valid = [
            'password'        => 'required|min_length[6]',   
            'confirmpassword' => 'matches[password]'];

        if($this->validate($valid))
        {

            $user = $this->client->where('uuid', $uuid)->first();
            $userID = $user['id'];
            $password = $this->request->getPost('password');
            $this->client->where('id', $userID)->set(['password' => password_hash($password , PASSWORD_DEFAULT), 'auth' => null])->update();

            return redirect()->to('/')->with('msg', 'password change successfully');

            // print($uuid);

        }

        else
        {
         return redirect()->back()->with('error', 'Password Does not match or password to short password must be minimum of 6');
        }

    }

}