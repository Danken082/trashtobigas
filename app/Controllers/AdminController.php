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

        $data = [
            'Inv' => $this->trsh->findAll()
        ];
        return view('admin/trashInventory', $data);

        // $trash = new trsh();
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




    public function index()
    {
        // Get all trash items from the database
        $data['recyclableTrash'] = $this->trsh->where('trashType', 'Recyclable')->findAll();
        $data['biodegradableTrash'] = $this->trsh->where('trashType', 'Biodegradable')->findAll();
        
        return view('admin/dashboard', $data);
    }

    public function create()
    {
            // Get form data
            $trashData = [
                'trashName' => $this->request->getPost('trashName'),
                'trashType' => $this->request->getPost('trashType'),
                'points' => $this->request->getPost('points'),
                'trashPicture' => $this->request->getPost('trashPicture')
            ];

            // // Handle image upload
            // if ($file = $this->request->getFile('trashPicture')) {
            //     $trashData['trashPicture'] = $file->store();
            // }

            // Insert trash data into database
            $this->trsh->insert($trashData);
            // return $this->response->setJSON([
            //     'status' => 'sucess'
            // ]);
            return redirect()->to('/inventory')->with('success', 'Trash item added successfully.');
     
     
    }

    public function edit($id)
    {
     
            $data = [
                'trashName' => $this->request->getPost('trashName'),
                'trashType' => $this->request->getPost('trashType'),
                'trashPicture' => $this->request->getPost('trashPicture'),
                'points' => $this->request->getPost('points'),
            ];
            $this->trsh->where('id', $id)->set($data)->update();

            return redirect()->to('/inventory');

        

    }

    public function update($id)
    {
    
    }

    public function viewEdit($id)
    {

        $data = [
           'Inv' => $this->trsh->findAll(),
           'edittrsh' => $this->trsh->find($id)
        ];
        return view('admin/editGarbage', $data);

    }
    public function delete($id)
    {
        $this->trsh->delete($id);
        return redirect()->to('/admin')->with('success', 'Trash item deleted successfully.');
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

