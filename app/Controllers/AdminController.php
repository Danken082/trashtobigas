<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TrashModel;

class AdminController extends BaseController
{

    private $trsh;

    public function __construct()
    {
        $this->trsh = new TrashModel();
    }
    public function home()
    {
        return view('admin/home');
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
}