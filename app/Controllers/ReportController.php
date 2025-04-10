<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\HistoryModel;
use App\Models\RedeemHistoryModel;
class ReportController extends BaseController
{
    public function exportExcel()
    {
        $historyModel = new HistoryModel();
     
        // Get filter date from query string
        $filterDate = $this->request->getGet('date');
    
        // Query with date filter if provided
        if ($filterDate) {
            $history = $historyModel->select('history.id, history.user_id, history.client_id, history.gatherPoints,
                registrationdb.address,  history.categ, history.weight, history.created_at,
                registrationdb.lastName, registrationdb.firstName,
                user_tbl.userName')
                ->join('registrationdb', 'registrationdb.id = history.client_id')
                ->join('user_tbl', 'user_tbl.id = history.user_id')
                ->orderBy('history.created_at', 'DESC')
                ->where("DATE(history.created_at)", $filterDate)
                ->findAll();
        } else {
            $history = $historyModel->select('history.id, history.user_id, history.client_id, history.gatherPoints,
                registrationdb.address,  history.categ, history.weight, history.created_at,
                registrationdb.lastName, registrationdb.firstName,
                user_tbl.userName')
                ->join('registrationdb', 'registrationdb.id = history.client_id')
                ->join('user_tbl', 'user_tbl.id = history.user_id')
                ->orderBy('history.created_at', 'DESC')
                ->findAll();
        }
        
        $spreadsheet    = new Spreadsheet();

    $sheet = $spreadsheet->getActiveSheet();

// Merge and set headers
$sheet->mergeCells('A1:B1');
$sheet->setCellValue('A1', 'Client Name');

$sheet->mergeCells('C1:D1');
$sheet->setCellValue('C1', 'Staff Username');

$sheet->mergeCells('E1:F1');
$sheet->setCellValue('E1', 'Address');

$sheet->mergeCells('G1:H1');
$sheet->setCellValue('G1', 'Gather Points');

$sheet->mergeCells('I1:J1');
$sheet->setCellValue('I1', 'Weight');

$sheet->mergeCells('K1:L1');
$sheet->setCellValue('K1', 'Category');

$sheet->mergeCells('M1:N1');
$sheet->setCellValue('M1', 'Date');

    // Populate rows
    // $sheet->setCellValue('A' . 2, 'dalandan');
    $row = 2;
    foreach ($history as $hst) {
        $sheet->mergeCells("A{$row}:B{$row}");
        $sheet->setCellValue("A{$row}", $hst['firstName'] . ' ' . $hst['lastName']);
        
        $sheet->mergeCells("C{$row}:D{$row}");
        $sheet->setCellValue("C{$row}", $hst['userName']);
        
        $sheet->mergeCells("E{$row}:F{$row}");
        $sheet->setCellValue("E{$row}", $hst['address']);
        
        $sheet->mergeCells("G{$row}:H{$row}");
        $sheet->setCellValue("G{$row}", $hst['gatherPoints']);
        
        $sheet->mergeCells("I{$row}:J{$row}");
        $sheet->setCellValue("I{$row}", $hst['weight']);
        
        $sheet->mergeCells("K{$row}:L{$row}");
        $sheet->setCellValue("K{$row}", $hst['categ']);
        
        $sheet->mergeCells("M{$row}:N{$row}");
        $sheet->setCellValue("M{$row}", date('F j, Y g:i A', strtotime($hst['created_at'])));
        
        $row++;
    }

    // Output to browser
    $writer = new Xlsx($spreadsheet);
    $filename = 'inventory_report_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
    
    
    }

    
    public function redemptionHistory()
    {

        $historyModel = new RedeemHistoryModel();
     
        // Get filter date from query string
        $filterDate = $this->request->getGet('date');
        if ($filterDate) {
            $history = $historyModel->select('redeemed_items.id, redeemed_items.user_id, redeemed_items.client_id, redeemed_items.product_id, 
                redeemed_items.points_used, redeemed_items.quantity, redeemed_items.redeem_Code, redeemed_items.created_at, 
                registrationdb.address, registrationdb.lastName, registrationdb.firstName, user_tbl.userName,  
                inventory_table.item, inventory_table.point_price')
                ->join('registrationdb', 'registrationdb.id = redeemed_items.client_id')
                ->join('user_tbl', 'user_tbl.id = redeemed_items.user_id')
                ->join('inventory_table', 'inventory_table.id = redeemed_items.product_id')
                ->orderBy('redeemed_items.created_at', 'DESC')
                ->where("DATE(redeemed_items.created_at)", $filterDate)
                ->findAll();
        } else {
            $history = $historyModel->select('redeemed_items.id, redeemed_items.user_id, redeemed_items.client_id, redeemed_items.product_id,
            redeemed_items.points_used, redeemed_items.quantity, redeemed_items.redeem_Code, redeemed_items.created_at, 
                registrationdb.address, registrationdb.lastName, registrationdb.firstName, user_tbl.userName,
                inventory_table.item, inventory_table.point_price')
                ->join('registrationdb', 'registrationdb.id = redeemed_items.client_id')
                ->join('user_tbl', 'user_tbl.id = redeemed_items.user_id')
                ->join('inventory_table', 'inventory_table.id = redeemed_items.product_id')
                ->orderBy('redeemed_items.created_at')
                ->findAll();
        }
        
        
        $spreadsheet    = new Spreadsheet();

    $sheet = $spreadsheet->getActiveSheet();

    // Header Row
    $sheet->setCellValue('A1', 'Client Name');
    $sheet->setCellValue('B1', 'Staff Username');
    $sheet->setCellValue('C1', 'Address');
    $sheet->setCellValue('D1', 'Product Redeem');
    $sheet->setCellValue('E1', 'Redemption Code');
    $sheet->setCellValue('G1', 'Date');

    // Populate rows
    // $sheet->setCellValue('A' . 2, 'dalandan');
    $row = 2;
    foreach ($history as $hst) {
        $sheet->setCellValue('A' . $row, $hst['firstName'] . ' ' . $hst['lastName']);
        $sheet->setCellValue('B' . $row, $hst['userName']);
        $sheet->setCellValue('C' . $row, $hst['address']);
        $sheet->setCellValue('D' . $row, $hst['item']);
        $sheet->setCellValue('E' . $row, $hst['redeem_Code']);
        $sheet->setCellValue('F' . $row, date('F j, Y g:i A', strtotime($hst['created_at'])));
        $row++;
    }

    // Output to browser
    $writer = new Xlsx($spreadsheet);
    $filename = 'inventory_report_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
    
    }
    
}
