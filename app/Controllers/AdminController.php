<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TrashModel;
use App\Models\ClientModel;
use App\Models\LogHistoryModel;

class AdminController extends BaseController
{


    private $log;
    private $trsh;
    private $client;
  
    public function __construct()
    {
        $this->log = new LogHistoryModel();
        $this->trsh = new TrashModel();
        $this->client = new ClientModel();
    }
    public function home()
    {
        return view('admin/home');
    }

    private function generateIdNumber()
    {

        $lastUser = $this->client->orderBy('id', 'DESC')->first();
    

        if ($lastUser && isset($lastUser['idNumber'])) {
            $lastIdNumber = intval($lastUser['idNumber']);
            $newIdNumber = str_pad($lastIdNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newIdNumber = '00001';
        }
    
        return $newIdNumber;
    }
    
    public function registerUser()
    {


        $newId = $this->generateIdNumber();

       $rules = [
            'firstName' => 'required|min_length[3]',
            'lastName' => 'required|min_length[3]',
            'address' => 'required|min_length[5]',
            'email' => 'required|min_length[5]|valid_email',
            'contactNo' => 'required',
            'birthdate' => 'required|valid_date'
       ];

            if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
            ]);
        }          



        $data = [
            'idNumber' => $newId,
            'firstName' => $this->request->getVar('firstName'),
            'lastName' => $this->request->getVar('lastName'),
            'address' => $this->request->getVar('address'),
            'email'  => $this->request->getVar('email'),
            'gender' => $this->request->getVar('gender'),
            'contactNo' => $this->request->getVar('contactNo'),
            'birthdate' => $this->request->getVar('birthdate')

        ];



        $this->client->save($data);

        return $this->response->setJSON(['success' => true,
                                         'message' => 'Resgistration Successful']);
    

    
    }

    public function insertTrash()
    {
        $data = [
            'trashName' => $this->request->getVar('trashName'),
            'trashType' => $this->request->getVar('trashType'),
        ];

        $trashImg = $this->request->getFile('trashPicture');

        if($trashImg->isValid() && !$trashImg->hasMoved())
        {
            $newName = $trashImg->getName();

            $trashImg->move($_SERVER['DOCUMENT_ROOT'] .'/trial/' ,$newName);
            $data['trashPicture'] = $newName;
        }


        $this->trsh->save($data);


        return redirect()->to('/inventory');
    }
 
    

    public function inventory()
    {
        return view('admin/trashInventory');

        // $trash = new TrashModel();
        // $data = $this->trsh->findAll();
        // var_dump($data);
    }

    public function pos()
    {
        $data = [
            'trsh' => $this->trsh->findAll(),

        ];

        return view('admin/pos', $data);
    }

    //searchApplicant

    public function search()
    {

        $search = $this->request->getGet('query');
// $results = 0;
        $results = $this->client->like('idNumber', $search)->findAll();
        return $this->response->setJSON($results);
    }

    public function getUserDetails($id)
    {
        // $userModel = new UserModel();
        $user = $this->client->find($id);
        // $user = 1;
        return $this->response->setJSON($user);
    }



    //pointingsystem
    public function detailsView($id)
    {
       $data =['details' => $this->client->find($id)];

       return view('admin/applicant/details', $data);

    }

    public function editApplicant($id)
    {
        $data = ['Applicant' => $this->client->find($id)];
        

        return view('admin/editApplicant', $data);
    }

    public function updateApplicant($id)
    {
        $data = ['firstName' => $this->request->getPost('firstName'),
                 'lastName' => $this->request->getPost('lastName'),
                 'birthdate' => $this->request->getPost('birthdate'),
                 'gender'   => $this->request->getPost('gender'),
                 'address' => $this->request->getPost('address'),
                 'email' => $this->request->getPost('email'),
                 'contactNo' => $this->request->getPost('contactNo')                 
                ];


        $this->client->where('id', $id)->set($data)->update();

        return $this->response->setJSON(
            ['status' => 'success']
        );


    }

    public function delete($id)
    {
        $this->client->delete($id);

        return $this->response->setJSON(['status'=> 'success']);
    }



    



    public function historyLogs()
    {
        
    }


}
