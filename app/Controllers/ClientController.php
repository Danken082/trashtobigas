<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ClientController extends BaseController
{
    public function index()
    {
        //
    }

    public function home()
    {
        return view('user/home');
    }

    public function profile()
    {
        return view('user/profile');
    }

    public function history()
    {
        return view('user/history');
    }

    public function login()
    {
        return view('user/login');
    }

}