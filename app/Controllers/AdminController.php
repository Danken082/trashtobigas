<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TrashModel;
use App\Models\ClientModel;

class AdminController extends BaseController
{

    private $trsh;
    private $client;
  
    public function __construct()
    {
        $this->trsh = new TrashModel();
        $this->client = new ClientModel();
    }
    public function home()
    {
        return view('admin/home');
    }

    public function registerUser()
    {


        $newId = $this->client->generateId();


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
        $results = $this->client->like('firstName', $search)->findAll();
        return $this->response->setJSON($results);
    }

    public function getUserDetails($id)
    {
        // $userModel = new UserModel();
        $user = $this->client->find($id);
        // $user = 1;
        return $this->response->setJSON($user);
    }


}
