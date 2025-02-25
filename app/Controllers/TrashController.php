<?php

namespace App\Controllers;
use App\Models\TrashModel;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ClientModel;

class TrashController extends ResourceController {

    private $client;

    public function _construct()
    {
        $this->client = new ClientModel();
    }
    public function convertTrash($id) {

        $client = new ClientModel();

    
       $applicant = $client->find($id);
        // print($id);
        $trashToPoints = .2; // Example: 1kg trash = 10 points
        $pointsToRice = 0.5; // Example: 1 point = 0.5 kg rice

        // Get input data (AJAX request)
        $weight = $this->request->getPost('trashWeight');

        if ($weight <= 0) {
            return $this->respond(['status' => 'error', 'message' => 'Invalid weight'], 400);
        }


        $points = $weight * $trashToPoints;
        $riceKilos = $points * $pointsToRice;


        //formula to update points
       $updatePoints = $points + $applicant['totalPoints'];

    //    print($updatePoints);

       $data = ['totalPoints' => $updatePoints];

       $client->where('id', $id)->set($data)->update();


       

    //    // Save conversion to database

        

            $trashModel = new TrashModel();
            $trashModel->insert([
                'trash_weight' => $weight,
                'points' => $points,
                'rice_kilos' => $riceKilos,
            ]);

            return $this->respond([
                'status' => 'success',
                'points' => number_format($points, 2),
                'riceKilos' => number_format($riceKilos, 2),
            ]);

        // $this->addHistory($updatePoints, $id, $weight);

    }


    private function addHistory($points, $id, $weight)
    {
        $data = ['clientID'     => $id,
                 'pointsGather' => $points,
                 'grams'        => $weight
           ];


        $this->client->save($data);
    }



    public function index()
    {
        $userModel = new ClientModel();
        $data['users'] = $userModel->findAll();

        return view('trial', $data);


    }

    public function getUser($id)
    {
        $userModel = new ClientModel();
        $user = $userModel->find($id);

        if ($user) {
            return $this->response->setJSON($user);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'User not found']);
        }
    }

}
