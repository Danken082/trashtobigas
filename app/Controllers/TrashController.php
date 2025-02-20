<?php

namespace App\Controllers;
use App\Models\TrashModel;
use CodeIgniter\RESTful\ResourceController;

class TrashController extends ResourceController {
    public function convertTrash() {

        // Get conversion rates from database (or set defaults)
        $trashToPoints = 10; // Example: 1kg trash = 10 points
        $pointsToRice = 0.5; // Example: 1 point = 0.5 kg rice

        // Get input data (AJAX request)
        $weight = $this->request->getPost('trashWeight');

        if ($weight <= 0) {
            return $this->respond(['status' => 'error', 'message' => 'Invalid weight'], 400);
        }

        // Calculate points and rice
        $points = $weight * $trashToPoints;
        $riceKilos = $points * $pointsToRice;

        // Save conversion to database
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
    }
}
