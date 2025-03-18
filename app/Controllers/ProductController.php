<?php
namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Models\ClientModel;

use App\Controllers\BaseController;

class ProductController extends BaseController {
    public function __construct()
    {
        
    }
    public function index($id) {
        $productModel = new ProductModel();
        $clientModel = new ClientModel();

        // Fetch client points, ensuring it's set to 0 if the client is not found
        $client = $clientModel->where('idNumber', $id)->first();
        $name = $client['lastName']. ' ' . $client['firstName']; 
        $totalPoints = $client ? $client['totalPoints'] : 0;
        $user_id = $client ? $client['id'] : 0;

        $data = [
            'products' => $productModel->findAll(),
            'totalPoints' => $totalPoints,
            'name' => $name,
            'user_id'     => $user_id
        ];

        return view('admin/ecommerce', $data);
    }


    public function redeem()
    {
        $request = $this->request->getJSON();
        foreach ($request->cart as $item) {
            $productId = $item->productId;
            $userid = $item->user_id;
            $price = $item->totalCost;
        
            // Now you can process each item
            log_message('info', "Product ID: $productId, User ID: $userid, Price: $price");
        }
        
    
        $userModel = new ClientModel();
        
        // $newPoints = 1;
        // // // Fetch the user
        $user = $userModel->find($userid);

        $userId = $user ? $user['id'] : 0;
        // // // Debugging: Log retrieved user data
        log_message('debug', 'User Data: ' . json_encode($user));
        
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found']);
        }
    
        if ($user['totalPoints'] < $price) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not enough points']);
        }
    
        // // // Deduct points
        $newPoints = $user['totalPoints'] - $price;
        $userModel->where('id', $userid)->set(['totalPoints' => $newPoints])->update();
    
        // // Save redemption record
        // $this->db->table('redemptions')->insert([
        //     'id' => $userId,
        //     'product_id' => $productId,
        //     'points_spent' => $price,
        //     'created_at' => date('Y-m-d H:i:s')
        // ]);
    
        return $this->response->setJSON(['success' => true, 'new_points' => $newPoints ]);
    }
    



}
