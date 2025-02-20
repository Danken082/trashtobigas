<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QrController extends BaseController
{
    public function index()
    {
        return view('qr-scanner');
    }

    public function generate()
    {
        $data = $this->request->getPost('data');

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
}
