<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TrashModel;
use App\Models\ClientModel;
use App\Models\LogHistoryModel;

use App\Models\ProductModel;
use App\Models\InventoryModel;
use App\Models\RedeemHistoryModel;
use App\Models\HistoryModel;


//library for qr code
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;


class AdminController extends BaseController
{


    private $log;
    private $trsh;
    private $redeem;
    private $client;
    private $inv;
    private $history;
    public function __construct()
    {
        $this->log = new LogHistoryModel();  
        $this->trsh = new TrashModel();
        $this->client = new ClientModel();
        $this->inv = new InventoryModel();
        $this->redeem = new RedeemHistoryModel();
        $this->history = new HistoryModel();
    }
    public function home()
    {
        return view('admin/home');
    }

    public function ecommerce()
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'image' => $this->request->getPost('image'),
            'points' => $this->request->getPost('points'),
        ];

        return view('/ecommerce');
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

    public function list()
    {
        $userID = session()->get('id');

        if(session()->get('role') === 'Staff')
        {
            $client = $this->client->where('user_ID', $userID)->findAll();
        }

        elseif(session()->get('role') === 'Admin')
        {
            $client = $this->client->findAll();
        }
        return $this->response->setJSON($client);
    }
    



    //registration of users
    public function registerUser()
    {
        // ID generator
        $newId = $this->generateIdNumber();
        $verificationToken = substr(md5(rand()), 0, 8);

        $email = $this->request->getVar('email');

        $this->clientEmail($email, $verificationToken);
    
        // Validation rules
        $rules = [
            'firstName' => 'required|min_length[3]',
            'lastName' => 'required|min_length[3]',
            'email' => 'required|min_length[5]|valid_email|is_unique[registrationdb.email]',
            'contactNo' => 'required',
            'birthdate' => 'required|valid_date'
        ];
    
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }
    
        // Data to save
        $data = [
            'idNumber'  => $newId,
            'user_ID'   => session()->get('id'),
            'firstName' => $this->request->getVar('firstName'),
            'lastName'  => $this->request->getVar('lastName'),
            'address'   => session()->get('address'),
            'email'     => $this->request->getVar('email'),
            'qrcode'    => $newId . '.png',
            'gender'    => $this->request->getVar('gender'),
            'contactNo' => $this->request->getVar('contactNo'),
            'birthdate' => $this->request->getVar('birthdate'),
            'address'   => $this->request->getVar('address'),
            'password'  => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'auth'      => $verificationToken,  
            'status'    => 'Inactive',
            'img'       => 'profile-logo.png'
        ];
    
        $this->client->save($data);
    
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Registration Successful'
        ]);
    }
    

    private function clientEmail($email)
    {
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setFrom('rontaledankeneth@gmail.com', 'Trashtobigas');
        $emailService->setSubject('Email Verification');
        $emailService->setMessage("Hello This is Your Verification Token Dont Share it to any one ");
    }


    //qr generator
    public function Generate()
    {
        $data = $this->generateIdNumber();

        if (!$data) {
            return $this->response->setJSON(['error' => 'No data provided']);
        }

        $qrCode = QrCode::create($data)->setSize(300)->setMargin(10);
        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode)->getString();

        return $this->response->setJSON([
            'qr_code' => 'data:image/png;base64,' . base64_encode($qrCodeImage)
        ]);
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

    public function deletetrsh($id)
    {
        $this->trsh->delete($id);
        return redirect()->to('/inventory')->with('success', 'Trash item deleted successfully.');
    }



    //searchApplicant

public function search()
{
    $user = session()->get('id'); // Get user ID from session
    $search = $this->request->getGet('query');

    $results = $this->client
        ->like('idNumber', $search)
        ->findAll();

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
       $data =['details' => $this->client->where('idNumber', $id)->first()];

       return view('admin/applicant/details', $data);

    }

    public function editApplicant($id)
    {
        $data = ['Applicant' => $this->client->find($id)];
        

        return view('admin/editApplicant', $data);
    }

    public function updateApplicant()
    {

        $id = $this->request->getPost('id');
        $data = ['firstName' => $this->request->getPost('firstName'),
                 'lastName' => $this->request->getPost('lastName'),
                 'birthdate' => $this->request->getPost('birthdate'),
                 'gender'   => $this->request->getPost('gender'),
                 'address' => $this->request->getPost('address'),
                 'email' => $this->request->getPost('email'),
                 'contactNo' => $this->request->getPost('contactNo'),
                 'totalPoints' => $this->request->getPost('points')                
                ];


        $this->client->where('id', $id)->set($data)->update();

        // return $this->response->setJSON(
        //     ['status' => 'success']
        // );

            return redirect()->to('viewapplicants');
    }

    public function insertIDNumber($id)
    {

    $userID = 1;#session()->get('id');

    $client = new ClientModel();
    // $user
     $client = $client->where('id', $id)->first();
        // print($client);
     $data = ['userID' => $userID,
              'accID' => $client['idNumber'],
              'actionType' => 'Delete'    
    ];


    $this->delete($id);
    $this->log->save($data);

    return redirect()->to('viewapplicants');
    }

    private function delete($id)
    {
        $this->client->delete($id);

        //to find the id of deleted applicant
    //    $applicant = $this->client->find($id);
    // $this->insertIDNumber($id);
    //    echo($applicant['id']);
    $client = new ClientModel();
    $clients = $client->where('id', $id)->first();
    // var_dump($clients);
    }

    


    public function viewAllApplicant()
    {
     $data =  ['applicant' =>$this->client->findAll(),];


     return view('admin/applicant/editApplicant', $data);
    }



    //for inventory
    public function viewInventory()
    {

        // $data['inv'] = $this->inv->find();
       return view('admin/inventory/viewInventory');
    }
    
    

    public function displayInventoryTable()
    {

        $user_id = session()->get('id');
        $client = $this->inv->where('user_ID', $user_id)->findAll();

        return $this->response->setJSON($client);
    }


    public function addToInventory()
    {
        $data = ['item' => $this->request->getVar('item'),
                 'category' => $this->request->getVar('category'),
                 'quantity' => $this->request->getVar('quantity'),
                 'user_ID' => session()->get('id'),
                 'point_price' => $this->request->getVar('pointPrice')
                ];

                $inventoryImg = $this->request->getFile('img');

                if($inventoryImg->isValid() && !$inventoryImg->hasMoved())
                {
                    $newName = $inventoryImg->getRandomName();
                    
                    $inventoryImg->move($_SERVER['DOCUMENT_ROOT'] . '/images/inventory/redeemed', $newName);

                    $data['img'] = $newName;
                }

        $this->inv->save($data);

        return redirect()->to('viewInventory');
    }
    public function updateInventory()
    {

        $id = $this->request->getPost('id');

        // Fetch existing item to get the current image
        $existingItem = $this->inv->where('id', $id)->first();
        
        $data = [
            'item' => $this->request->getVar('item'),
            'category' => $this->request->getVar('category'),
            'quantity' => $this->request->getVar('quantity'),
            'point_price' => $this->request->getVar('pointPrice')
        ];
        
        $inventoryImg = $this->request->getFile('img');
        
        if ($inventoryImg && $inventoryImg->isValid() && !$inventoryImg->hasMoved()) {
            // Generate a random name for the new image
            $newName = $inventoryImg->getRandomName();
        
            // Move the new image
            $inventoryImg->move($_SERVER['DOCUMENT_ROOT'] . '/images/inventory/redeemed', $newName);
        
            // Delete the old image if it exists
            if (!empty($existingItem['img'])) {
                $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . '/images/inventory/redeemed/' . $existingItem['img'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        
            $data['img'] = $newName;
        }
        
        $this->inv->where('id', $id)->set($data)->update();
        
        return redirect()->to('viewInventory');
         
        
    }

    public function deleteInventory($id)
    {
        // Fetch the existing item to get the image filename
        $existingItem = $this->inv->where('id', $id)->first();
    
        if ($existingItem && !empty($existingItem['img'])) {
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/images/inventory/redeemed/' . $existingItem['img'];
    
            // Check if the file exists before attempting to delete it
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
        // Delete the inventory item from the database
        $this->inv->delete($id);
    
        return redirect()->to('viewInventory'); 
    }
    
    public function redeemItemsHistory()
    {

        $user_id = session()->get('id');
        

    if(session()->get('role') === 'Staff')
    {
        $data['redeem'] = $this->redeem->select('
        redeemed_items.id, 
        redeemed_items.user_id, 
        redeemed_items.client_id, 
        redeemed_items.product_id,
        redeemed_items.created_at, 
        redeemed_items.points_used, 
        redeemed_items.redeem_Code, 
        user_tbl.lastName, 
        user_tbl.firstName,
        user_tbl.address,
        user_tbl.userName, 
        user_tbl.contactNo,
        inventory_table.id,
        inventory_table.item,
        registrationdb.id,
        registrationdb.idNumber,
        registrationdb.firstName,
        registrationdb.lastName,
        registrationdb.contactNo
    ')->join('user_tbl', 'user_tbl.id = redeemed_items.user_id')
      ->join('inventory_table', 'inventory_table.id = redeemed_items.product_id')
      ->join('registrationdb', 'registrationdb.id = redeemed_items.client_id')
      ->orderBy('redeemed_items.created_at')
      ->groupBy('redeemed_items.redeem_Code')
      ->where('redeemed_items.user_id', $user_id)
      ->findAll();
    }
    elseif(session()->get('role') === 'Admin')
    {
        
        $data['redeem'] = $this->redeem->select('
        redeemed_items.id, 
        redeemed_items.user_id, 
        redeemed_items.client_id, 
        redeemed_items.product_id,
        redeemed_items.created_at, 
        redeemed_items.points_used, 
        redeemed_items.redeem_Code, 
        user_tbl.lastName, 
        user_tbl.firstName,
        user_tbl.address,
        user_tbl.userName, 
        user_tbl.contactNo,
        inventory_table.id,
        inventory_table.item,
        registrationdb.id,
        registrationdb.idNumber,
        registrationdb.firstName,
        registrationdb.lastName,
        registrationdb.contactNo
    ')->join('user_tbl', 'user_tbl.id = redeemed_items.user_id')
      ->join('inventory_table', 'inventory_table.id = redeemed_items.product_id')
      ->join('registrationdb', 'registrationdb.id = redeemed_items.client_id')
      ->orderBy('redeemed_items.created_at', 'DESC')
      ->groupBy('redeemed_items.redeem_Code')
      ->findAll();
    }
        
        // var_dump($data);
      return view('admin/viewRedeemPoints', $data);
    }


    public function viewHistoryPointsConvertion()
    {

        $userId = session()->get('id');
        
        if(session()->get('role') === 'Staff')
        {
            
      $data['history'] = $this->history->select('history.id, history.user_id, history.client_id, history.gatherPoints,
      registrationdb.address,  history.categ, history.weight, history.created_at,
        registrationdb.lastName, registrationdb.firstName,
        user_tbl.userName')
        ->join('registrationdb', 'registrationdb.id = history.client_id')
        ->join('user_tbl', 'user_tbl.id = history.user_id')
        ->orderBy('history.created_at', 'DESC')
        ->where('history.user_id' ,$userId)
        ->findAll();

        }
        elseif(session()->get('role') === 'Admin')
        {
            $data['history'] = $this->history->select('history.id, history.user_id, history.client_id, history.gatherPoints,
            registrationdb.address,  history.categ, history.weight, history.created_at,
              registrationdb.lastName, registrationdb.firstName,
              user_tbl.userName')
              ->join('registrationdb', 'registrationdb.id = history.client_id')
              ->join('user_tbl', 'user_tbl.id = history.user_id')
              ->orderBy('history.created_at', 'DESC')
              ->findAll();
                  
        }
        return view("admin/historyRedeemtionTable", $data);
    }

}

