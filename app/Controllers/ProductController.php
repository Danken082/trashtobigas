<?php
namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Models\ClientModel;
use App\Models\RedeemHistoryModel;

use App\Controllers\BaseController;

class ProductController extends BaseController {

    private $redeem;
    public function __construct()
    {
        $this->redeem = new RedeemHistoryModel();
    }
    public function index($id) {
        $productModel = new ProductModel();
        $clientModel = new ClientModel();
        $userID = session()->get('id');

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

    //for generating ordercode
    private function generateAlphanumericBarcode($length = 10)
    {
       $characters = 'QWh1g2f3YeOzPwPv4u5t6sArSKwFJx7w8b9rZXCcBdN10aLKJ';
       $barcodeData = '';
   
       for ($i = 0; $i < $length; $i++) {
           $barcodeData .= $characters[rand(0, strlen($characters) - 1)];
       }
   
       return $barcodeData;
   }

    public function redeem()
{

    $code = $this->generateAlphanumericBarcode();
    $request = $this->request->getJSON();
    $userModel = new ClientModel();
    
    $userid = $request->cart[0]->user_id ?? null; // Assuming all items belong to the same user
    if (!$userid) {
        return $this->response->setJSON(['success' => false, 'message' => 'Invalid user ID']);
    }

    // Fetch the user
    $user = $userModel->find($userid);
    if (!$user) {
        return $this->response->setJSON(['success' => false, 'message' => 'User not found']);
    }

    $totalCost = array_sum(array_column($request->cart, 'totalCost')); // Sum all item costs

    if ($user['totalPoints'] < $totalCost) {
        return $this->response->setJSON(['success' => false, 'message' => 'Not enough points']);
    }

    // Deduct points
    $newPoints = $user['totalPoints'] - $totalCost;
    $userModel->update($userid, ['totalPoints' => $newPoints]);

    // Prepare redemption records
    $redemptions = [];
    foreach ($request->cart as $item) {
        $redemptions[] = [
            'client_id' => $userid,
            'user_id' => session()->get('id'), // Who processed the redemption
            'product_id' => $item->productId,
            'points_used' => $item->totalCost,
            // 'quantity' => $item->quantity,
            'redeem_Code' => 'RC_' . $code
        ];
    }

    // Save all redemption records
    $this->redeem->insertBatch($redemptions);

    return $this->response->setJSON(['success' => true, 'new_points' => number_format(esc($newPoints), 2)]);
}

}
