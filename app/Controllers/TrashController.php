<?php

namespace App\Controllers;
use App\Models\TrashModel;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ClientModel;
use App\Models\LogHistoryModel;
use App\Models\PointRangeModel;

class TrashController extends ResourceController {

    private $client;
    private $log;
    private $points;

    public function _construct()
    {
        $this->client = new ClientModel();
        $this->log = new LogHistoryModel();
        $this->point  = new PointRangeModel();
    }

    public function convertTrash($id)
    {
        $client = new ClientModel();
        $applicant = $client->find($id);
    
        if (!$applicant) {
            return $this->respond(['status' => 'error', 'message' => 'Client not found'], 404);
        }
    
        $weight = $this->request->getPost('trashWeight');
    
        if ($weight <= 0) {
            return $this->respond(['status' => 'error', 'message' => 'Invalid weight'], 400);
        }
    
        $points = 10;

        $pointRange = new PointRangeModel();
        $ranges = $pointRange->findAll();
    
        foreach ($ranges as $range) {
            if ($weight >= $range['min_weight'] && $weight <= $range['max_weight']) {
                $points = $range['points'];
                break;
            }
        }
    
        if ($points === 0) {
            return $this->respond(['status' => 'error', 'message' => 'No point range matched'], 400);
        }
    
        $updatePoints = $points + $applicant['totalPoints'];
    
        $client->update($id, ['totalPoints' => $updatePoints]);
    
        // $riceKilos = $points * 0.5; // Assuming the conversion rate is fixed here
    
        // $trashModel = new TrashModel();
        // $trashModel->insert([
        //     'client_id' => $id,
        //     'trash_weight' => $weight,
        //     'points' => $points,
        //     'rice_kilos' => $riceKilos,
        // ]);
    
        return $this->respond([
            'status' => 'success',
            'points' => number_format($points, 2),
            'riceKilos' => number_format($weight, 2),
            'totalPoints' => number_format($updatePoints, 2)
        ]);
    } 
    
    private function updateUserPointsLog($id)
    {
        // $this->client->find($id);
        $userID = 1;#session()->get('id');

        $client = new ClientModel();
        // $user
         $client = $this->client->where('id', $id)->first();
            // print($client);
         $data = ['userID' => $userID,
                  'accID' => $client['idNumber'],
                  'actionType' => 'Update'    
        ];

        $this->log->save($data);



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
