<?php
require 'PHPSpreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

// Connexion à la base de données avec gestion d'erreur
$host = 'localhost';  // Correction de localhost1 à localhost
$username = 'root';
$password = '';
$database = 'excel1';

try {
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        throw new Exception("Échec de la connexion à la base de données : " . $conn->connect_error);
    }
} catch (Exception $e) {
    die($e->getMessage());
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->getColumnDimension('A')->setWidth(50);
$sheet->getColumnDimension('B')->setWidth(50);
$sheet->getColumnDimension('C')->setWidth(50);

    $sheet->setCellValue('B1', "Projet facturable");
    $sheet->getStyle('B1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
    $sheet->getStyle('B1')->getFont()->setBold(true);
    $sheet->setCellValue('C1',  "Projet non facturable");
    $sheet->getStyle('C1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
    $sheet->getStyle('C1')->getFont()->setBold(true);
    $sql = "SELECT id, nom, profession, taux, taux5 , taux10, taux15, taux20, taux25, tauxn FROM personnels WHERE type = 'final'";
    $rowNumber = 1;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        $nom = $row['nom'];
       
        $sql = "SELECT sum(heurs)as heur FROM personnels WHERE type = 'file' and nom = '".$nom."' and projet NOT IN (SELECT nom FROM projet)";
        $r = $conn->query($sql);
        
        
        
        if ($r->num_rows > 0) {
            while ($r1 = $r->fetch_assoc()) {
                $heurs = $r1['heur'];
                
                $rowNumber++;
                $sheet->setCellValue('A' . $rowNumber, $nom);
                
                $sheet->setCellValue('B' . $rowNumber, $heurs);
                
            }
            $sql = "SELECT sum(heurs)as heur FROM personnels WHERE type = 'file' and nom = '".$nom."' and projet  IN (SELECT nom FROM projet)";
        $r = $conn->query($sql);
        if ($r->num_rows > 0) {
            while ($r1 = $r->fetch_assoc()) {
                $heurs = $r1['heur'];
                
               
               
                $sheet->setCellValue('C' . $rowNumber, $heurs);
                
            }
        }
    }
}
}
$sheet->getStyle('A2:C' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);  

// Ajouter des styles pour l'export Excel
$sheet->getStyle('A1')->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 14,
        'color' => ['rgb' => '007bff']
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'f8f9fa']
    ]
]);

$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="KPI.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>