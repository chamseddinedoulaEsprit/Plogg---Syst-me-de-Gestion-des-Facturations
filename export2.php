<?php
require 'PHPSpreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$host = 'localhost1';
$username = 'root';
$password = '';
$database = 'excel1';

$conn = new mysqli($host, $username, $password, $database);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(20);
$sheet->getColumnDimension('C')->setWidth(20);
$sheet->getColumnDimension('D')->setWidth(20);
$sheet->getColumnDimension('E')->setWidth(20);
$sheet->getColumnDimension('F')->setWidth(12);
$sheet->getColumnDimension('G')->setWidth(12);
$sheet->getColumnDimension('H')->setWidth(12);
$sheet->getColumnDimension('I')->setWidth(12);
$sheet->getColumnDimension('J')->setWidth(12);

use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
$sql = "SELECT numero, dj, da, dm, fj, fa, fm, j, m, a, societe FROM facture WHERE id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();

  $num = $row['numero'];
  $dj = $row['dj'];
  $da = $row['da'];
  $dm = $row['dm'];
  $fj = $row['fj'];
  $fa = $row['fa'];
  $fm = $row['fm'];
  $j = $row['j'];
  $m = $row['m'];
  $a = $row['a'];
  $so = $row['societe'];

$sheet->setCellValue('A1', $so);
$sheet->mergeCells('A1:F1');
$sheet->getStyle('A1:F1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->getStyle('A1:F1')->getFont()->setBold(true);

$sheet->setCellValue('A2', 'Adresse : B208,Immeuble Rayhane,Lotissement Centre Urbain,4000,Sousse,Tunisie');
$sheet->mergeCells('A2:E2');
$sheet->setCellValue('F2', $j . '/' . $m . '/' . $a);
$sheet->setCellValue('A3', 'Facture #'.$num.' (Du'. $dj . '/' . $dm . '/' . $da.'au'.$fj . '/' . $fm . '/' . $fa.')');
$sheet->mergeCells('A3:F3');
$sheet->getStyle('A3:F3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->getStyle('A2:E2')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->getStyle('A3:F3')->getFont()->setBold(true);
$sheet->getStyle('A2:E2')->getFont()->setBold(true);
$sheet->getStyle('F2')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->getStyle('F2')->getFont()->setBold(true);



$sheet->setCellValue('B5', 'Objet : Facturation Plogg Tunisie ('.$m.'  '.$a.' )');
$sheet->mergeCells('B5:E6');
$sheet->getStyle('B5:E6')->getFont()->setBold(true);
$sheet->getStyle('B5:E6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('B5:E6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
}
$a1 = 0;
$s=0;
$sql = "SELECT id, nom, profession, heurs, taux, total FROM personnels WHERE type = 'final'";
$result = $conn->query($sql);


$rowNumber = 9;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $nom = $row['nom'];
        $profession = $row['profession'];
        $heurs = $row['heurs'];
        $taux = $row['taux'];
        $total = $row['total'];
$sheet->setCellValue('A' . $rowNumber, 'Production Hub - synode');
$sheet->getStyle('A' . $rowNumber . ':B'. $rowNumber)->getFont()->setBold(true);
$sheet->getStyle('A' . $rowNumber . ':B'. $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);

$sheet->mergeCells('A' . $rowNumber . ':B'. $rowNumber);
$sheet->setCellValue('C' . $rowNumber, 'Heures');
$sheet->getStyle('C' . $rowNumber)->getFont()->setBold(true);
$sheet->getStyle('C' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->setCellValue('D' . $rowNumber, 'Taux');
$sheet->getStyle('D' . $rowNumber)->getFont()->setBold(true);
$sheet->getStyle('D' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->setCellValue('E' . $rowNumber, 'Total');
$sheet->getStyle('E' . $rowNumber)->getFont()->setBold(true);
$sheet->getStyle('E' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->setCellValue('F' . $rowNumber, ' '); 
 $sheet->mergeCells('F' . $rowNumber . ':F' . $rowNumber+1); 
$rowNumber++;


       
       
        $sheet->setCellValue('A' . $rowNumber, $nom);
        $sheet->getStyle('A' . $rowNumber, $nom)->getFont()->setBold(true);
        $sheet->getStyle('A' . $rowNumber)->applyFromArray([
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
                ],
                'left' => [
                    'borderStyle' =>Border::BORDER_THICK,
                    'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
                ],
                'right' => [
                    'borderStyle' =>Border::BORDER_HAIR,
                    'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
                ],
                'bottom' => [
                    'borderStyle' => Border::BORDER_HAIR,
                    'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
                ],
            ],
        ]);






        $sheet->setCellValue('B' . $rowNumber, $profession);
        $sheet->getStyle('B' . $rowNumber)->applyFromArray([
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_HAIR,
                    'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
                ],
                'bottom' => [
                    'borderStyle' => Border::BORDER_HAIR,
                    'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
                ],
            ],
        ]);
        $sheet->setCellValue('C' . $rowNumber, $heurs);
        $sheet->getStyle('C' . $rowNumber)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_DASHED);
        $sheet->setCellValue('D' . $rowNumber, $taux);
        $sheet->getStyle('D' . $rowNumber)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
        $sheet->getStyle('D' . $rowNumber)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_DASHED);
        
        
        
        
        
        
        $sheet->setCellValue('E' . $rowNumber, $total);
$sheet->getStyle('E' . $rowNumber)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
$sheet->getStyle('E' . $rowNumber)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('E' . $rowNumber)->applyFromArray([
    'borders' => [
        'top' => [
            'borderStyle' => Border::BORDER_THICK,
            'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
        ],
        'left' => [
            'borderStyle' =>Border::BORDER_HAIR,
            'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
        ],
        'right' => [
            'borderStyle' =>Border::BORDER_THICK,
            'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
        ],
        'bottom' => [
            'borderStyle' => Border::BORDER_HAIR,
            'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
        ],
    ],
]);
  

        $rowNumber++;
        $sheet->setCellValue('A' . $rowNumber, ' '); 
        $sheet->mergeCells('A' . $rowNumber . ':E' . $rowNumber); 
        $sheet->getStyle('A' . $rowNumber . ':E' . $rowNumber)->applyFromArray([
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_HAIR,
                    'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
                ],
                'bottom' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => ['argb' => 'FF000000'], // Couleur de la bordure (noir dans cet exemple)
                ],
            ],
        ]);
        
        $sheet->getStyle('F' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
        $sheet->setCellValue('F' . $rowNumber, $total);
        $sheet->getStyle('F' . $rowNumber)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
        $sheet->getStyle('F' . $rowNumber)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $s +=$heurs;
        $a1 += $total;
        $rowNumber++;
        $rowNumber++;
    }
}

$rowNumber++;
$sheet->setCellValue('D' . $rowNumber, 'HEURES ');
$sheet->mergeCells('D' . $rowNumber . ':E' . $rowNumber);
$sheet->getStyle('D' . $rowNumber . ':E' . $rowNumber)->getFont()->setBold(true);
$sheet->getStyle('D' . $rowNumber . ':E' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->setCellValue('F' . $rowNumber, $s);
$sheet->getStyle('F' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->getStyle('F' . $rowNumber)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);






$rowNumber++;
$sheet->setCellValue('D' . $rowNumber, 'TOTAL' );
$sheet->mergeCells('D' . $rowNumber . ':E' . $rowNumber);
$sheet->getStyle('D' . $rowNumber . ':E' . $rowNumber)->getFont()->setBold(true);
$sheet->getStyle('D' . $rowNumber . ':E' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->setCellValue('F' . $rowNumber, $a1);
$sheet->getStyle('F' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->getStyle('F' . $rowNumber)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('F' . $rowNumber)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
$rowNumber+=2;
$d=$rowNumber;
$sheet->setCellValue('A' . $rowNumber, 'Nom et Prénom' );
$sheet->setCellValue('B' . $rowNumber, 'Profession' );
$sheet->setCellValue('C' . $rowNumber, 'Heures' );
$sheet->setCellValue('D' . $rowNumber, 'Taux' );
$sheet->setCellValue('E' . $rowNumber, 'Taux 5%' );
$sheet->setCellValue('F' . $rowNumber, 'Taux 10%' );
$sheet->setCellValue('G' . $rowNumber, 'Taux 15%' );
$sheet->setCellValue('H' . $rowNumber, 'Taux 20%' );
$sheet->setCellValue('I' . $rowNumber, 'Taux 25%' );
$sheet->setCellValue('J' . $rowNumber, 'Taux normal' );



$sheet->getStyle('A' . $d . ':J' . $d)->getFont()->setBold(true);
$sheet->getStyle('A' . $d . ':J' . $d)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);



$sql = "SELECT id, nom, profession, heurs, taux, taux5 , taux10, taux15, taux20, taux25, tauxn FROM personnels WHERE type = 'manuel1'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $nom = $row['nom'];
        $profession = $row['profession'];
        $heurs = $row['heurs'];
        $taux = $row['taux'];
        $taux5 = $row['taux5'];
        $taux10 = $row['taux10'];
        $taux15 = $row['taux15'];
        $taux20 = $row['taux20'];
        $taux25 = $row['taux25'];
        $tauxn = $row['tauxn'];
       
        $rowNumber++;
        $sheet->setCellValue('A' . $rowNumber, $nom );
        $sheet->setCellValue('B' . $rowNumber, $profession );
        $sheet->setCellValue('C' . $rowNumber, $heurs );
        $sheet->setCellValue('D' . $rowNumber, $taux );
        $sheet->setCellValue('E' . $rowNumber, $taux5 );
        $sheet->setCellValue('F' . $rowNumber, $taux10);
        $sheet->setCellValue('G' . $rowNumber,  $taux15 );
        $sheet->setCellValue('H' . $rowNumber, $taux20 );
        $sheet->setCellValue('I' . $rowNumber,  $taux25 );
        $sheet->setCellValue('J' . $rowNumber,  $tauxn );




    }}
    
$sheet->getStyle('A' . $d+1 . ':J' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="download.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>
