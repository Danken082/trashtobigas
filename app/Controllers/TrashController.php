<?php

namespace App\Controllers;
use App\Models\TrashModel;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ClientModel;
use App\Models\LogHistoryModel;
use App\Models\PointRangeModel;
use App\Models\HistoryModel;
class TrashController extends ResourceController {

    private $client;
    private $log;
    private $points;
    private $history;

    public function __construct()
    {
        $this->client = new ClientModel();
        $this->log = new LogHistoryModel();
        $this->points  = new PointRangeModel();
        $this->history = new HistoryModel();
    }


    public function points()
    {

    
    $points = new PointRangeModel();
     $range =  $this->points->findAll();
    



     return $this->response->setJSON($range);
    }

    public function viewRange()
    {


        return view('admin/Range/viewPoints');
    }
    public function InsertPoints()
    {
        $data = ['min_weight' => $this->request->getPost('minweight'),
                 'max_weight' => $this->request->getPost('maxweight'),
                 'points'     => $this->request->getPost('points'),
                 'categ'      => $this->request->getPost('categ')
            ];

        $this->points->save($data);
        return $this->response->setJSON(['status' => 'Success']);
    }

    public function updatepoints()
    {
        $id = $this->request->getPost('id');
        $data = [
            'min_weight' => $this->request->getPost('minweight'),
            'max_weight' => $this->request->getPost('maxweight'),
            'points'     => $this->request->getPost('points'),
            'categ'      => $this->request->getPost('categ')
        ];

        $this->points->where('id', $id)->set($data)->update();

        return redirect()->to('ranges');
    }

    public function deleteRanges($id)
    {
        $this->points->delete($id);

        return redirect()->to('ranges'); 
        
        // $this->response->setJSON([
        //     'success' => true,
        //     'message' => 'Data deleted Successfully'
        // ]);
    }
    // public function 
    public function convertTrash($id)
    {
    $client = new ClientModel();
    $applicant = $client->find($id);

    $history = new HistoryModel();





    if (!$applicant) {
        return $this->respond(['status' => 'error', 'message' => 'Client not found'], 404);
    }

    $weight = $this->request->getPost('trashWeight');
    $categ = $this->request->getPost('category');

    if ($weight <= 0) {
        return $this->respond(['status' => 'error', 'message' => 'Invalid weight'], 400);
    }

    $points = 10;
    $pointRange = new PointRangeModel();
    $rangesklg = $pointRange->where('categ', 'klg/s')->findAll();
    $rangesgrams = $pointRange->where('categ', 'gram/s')->findAll();

    switch ($categ) {
        case 'kilogram/s':

            foreach ($rangesklg as $range) {
                if ($weight >= $range['min_weight'] && $weight <= $range['max_weight']) {
                    $points = $range['points'];
                    break;
                }
            }
            $updatePoints = $points + $applicant['totalPoints'];
            $client->update($id, ['totalPoints' => $updatePoints]);

            
            //saving to history
            $history->save(['client_id' => $applicant['id'],
            'user_id' => session()->get('id'),
            'gatherPoints' => $points,
            'weight'=> $weight,
            'categ' => $categ,
            'totalCurrentPoints' => $updatePoints]);


            return $this->response->setJSON([
                'status' => 'success',
                'categ'  => strtoupper($categ),
                'points' => $points,
                'riceKilos' => $weight,
                'totalPoints' => number_format($updatePoints, 2)
            ]);
        case 'gram/s':

            foreach ($rangesgrams as $range) {
                if ($weight >= $range['min_weight'] && $weight <= $range['max_weight']) {
                    $points = $range['points'];
                    break;
                }
            }


            //saving to historyTable
            $history->save(['client_id' => $applicant['id'],
            'user_id' => session()->get('id'),
            'gatherPoints' => $points,
            'weight'=> $weight,
            'categ' => $categ,
            ]);
        
        
            $updatePoints = $points + $applicant['totalPoints'];
            $client->update($id, ['totalPoints' => $updatePoints]);

            return $this->response->setJSON([
                'status' => 'success',
                'categ'  => strtoupper($categ),
                'points' => $point,
                'riceKilos' => $weight,
                'totalPoints' => number_format($updatePoints, 2)
            ]);
        default:
            return $this->response->setJSON(['success' => true, 'category' => 'others']);
    }
    // Calculate points based on weight range

    if ($points === 0) {
        return $this->respond(['status' => 'error', 'message' => 'No point range matched'], 400);
    }


    // Calculate updated points


    // Update client's total points


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
