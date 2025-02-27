<?php
namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Controllers\BaseController;

class ProductController extends BaseController {
    public function index() {
        $productModel = new ProductModel();
        // $userModel = new UserModel();
        
        // Fetch products and user points (assuming user ID 1 for demo)
        $data['products'] = $productModel->findAll();
        // $data['totalPoints'] = $userModel->getUserPoints(1);
        
        return view('admin/applicant/ecommerce', $data);
    }
}
