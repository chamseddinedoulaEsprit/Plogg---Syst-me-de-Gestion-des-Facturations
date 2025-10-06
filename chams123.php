<?php
require 'PHPSpreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'excel1';

$conn = new mysqli($host, $username, $password, $database);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->getColumnDimension('A')->setWidth(50);
$sheet->getColumnDimension('B')->setWidth(50);
$sheet->getColumnDimension('C')->setWidth(20);
$sheet->getColumnDimension('D')->setWidth(20);
$sheet->getColumnDimension('E')->setWidth(20);
$sheet->getColumnDimension('F')->setWidth(20);
$sheet->getColumnDimension('G')->setWidth(12);
$sheet->getColumnDimension('H')->setWidth(12);
$sheet->getColumnDimension('I')->setWidth(12);
$sheet->getColumnDimension('J')->setWidth(12);

use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
$sql = "SELECT numero, dj,fj ,m, adresse, societe FROM facture WHERE id = 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      $num = $row['numero'];
      $dj = $row['dj'];
      $fj = $row['fj'];
      $m = $row['m'];
      $so1 = $row['adresse'];
      $so = $row['societe'];
      $liste1 = explode("-", $m);
      $liste2 = explode("-", $dj);
      $liste3 = explode("-", $fj);
      $mois1 = "";
      switch ($liste1[1]) {
          case "01":
              $mois1 = "Janvier";
              break;
          case "02":
              $mois1 = "Février";
              break;
          case "03":
              $mois1 = "Mars";
              break;
          case "04":
              $mois1 = "Avril";
              break;
          case "05":
              $mois1 = "Mai";
              break;
          case "06":
              $mois1 = "Juin";
              break;
          case "07":
              $mois1 = "Juillet";
              break;
          case "08":
              $mois1 = "Août";
              break;
          case "09":
              $mois1 = "Septembre";
              break;
          case "10":
              $mois1 = "Octobre";
              break;
          case "11":
              $mois1 = "Novembre";
              break;
          case "12":
              $mois1 = "Décembre";
              break;
          default:
              $mois1 = "Mois inconnu";
              break;
      }
  
      $mois2 = "";
      switch ($liste2[1]) {
          case "01":
              $mois2 = "Janvier";
              break;
          case "02":
              $mois2 = "Février";
              break;
          case "03":
              $mois2 = "Mars";
              break;
          case "04":
              $mois2 = "Avril";
              break;
          case "05":
              $mois2 = "Mai";
              break;
          case "06":
              $mois2 = "Juin";
              break;
          case "07":
              $mois2 = "Juillet";
              break;
          case "08":
              $mois2 = "Août";
              break;
          case "09":
              $mois2 = "Septembre";
              break;
          case "10":
              $mois2 = "Octobre";
              break;
          case "11":
              $mois2 = "Novembre";
              break;
          case "12":
              $mois2 = "Décembre";
              break;
          default:
              $mois2 = "Mois inconnu";
              break;
      }
      $mois3 = ""; 

        switch ($liste3[1]) {
            case "01":
                $mois3 = "Janvier";
                break;
            case "02":
                $mois3 = "Février";
                break;
            case "03":
                $mois3 = "Mars";
                break;
            case "04":
                $mois3 = "Avril";
                break;
            case "05":
                $mois3 = "Mai";
                break;
            case "06":
                $mois3 = "Juin";
                break;
            case "07":
                $mois3 = "Juillet";
                break;
            case "08":
                $mois3 = "Août";
                break;
            case "09":
                $mois3 = "Septembre";
                break;
            case "10":
                $mois3 = "Octobre";
                break;
            case "11":
                $mois3 = "Novembre";
                break;
            case "12":
                $mois3 = "Décembre";
                break;
            default:
                $mois3 = "Mois inconnu";
                break;
        }

$sheet->setCellValue('A1', $so);
    $sheet->mergeCells('A1:F1');
    $sheet->getStyle('A1:F1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
    $sheet->getStyle('A1:F1')->getFont()->setBold(true);

    $sheet->setCellValue('A2', $so1);
    $sheet->mergeCells('A2:E2');
    $sheet->setCellValue('F2', $liste1[2] . '/' . $liste1[1] . '/' . $liste1[0]);
    $sheet->setCellValue('A3', 'Facture #' . $num . ' (Du ' . $liste2[2] . '/' . $liste2[1] . '/' . $liste2[0] . ' au ' . $liste3[2] . '/' . $liste3[1] . '/' . $liste3[0] . ')');
    $sheet->mergeCells('A3:F3');
$sheet->getStyle('A3:F3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->getStyle('A2:E2')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->getStyle('A3:F3')->getFont()->setBold(true);
$sheet->getStyle('A2:E2')->getFont()->setBold(true);
$sheet->getStyle('F2')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->getStyle('F2')->getFont()->setBold(true);



$sheet->setCellValue('B5', 'Objet : Facturation Plogg Tunisie ('.$mois2.'  '.$liste2[0].' )');
$sheet->mergeCells('B5:E6');
$sheet->getStyle('B5:E6')->getFont()->setBold(true);
$sheet->getStyle('B5:E6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('B5:E6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
}
$a1 = 0;
$s=0;
$sql = "SELECT id, nom, profession, heurs, taux, total,projet,category FROM personnels WHERE type = 'file'";
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
        $projet = $row['projet'];
        $category = $row['category'];
        $sql1 = "SELECT  nom FROM projet ";
        $result1 = $conn->query($sql1);
        $projetExists = false;
        
        

        while ($row1 = $result1->fetch_assoc()) {
            if ($row1['nom'] === $projet) {
                $projetExists = true;
                break;
            }
        }

        if (!$projetExists) {

$sheet->setCellValue('A' . $rowNumber,  $projet.' - '.$category);
$sheet->getStyle('A' . $rowNumber . ':B'. $rowNumber)->getFont()->setBold(true);
$sheet->getStyle('A' . $rowNumber . ':B'. $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);

$sheet->mergeCells('A' . $rowNumber . ':B'. $rowNumber);
$sheet->setCellValue('C' . $rowNumber, 'Heures');
$sheet->getStyle('C' . $rowNumber)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('C' . $rowNumber)->getFont()->setBold(true);
$sheet->getStyle('C' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->setCellValue('D' . $rowNumber, 'Taux');
$sheet->getStyle('D' . $rowNumber)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('D' . $rowNumber)->getFont()->setBold(true);
$sheet->getStyle('D' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THICK);
$sheet->setCellValue('E' . $rowNumber, 'Total');
$sheet->getStyle('E' . $rowNumber)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
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
}}

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



$sql = "SELECT id, nom, profession, taux, taux5 , taux10, taux15, taux20, taux25, tauxn FROM personnels WHERE type = 'manuel1'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $nom = $row['nom'];
        $profession = $row['profession'];
        $taux = $row['taux'];
        $taux5 = $row['taux5'];
        $taux10 = $row['taux10'];
        $taux15 = $row['taux15'];
        $taux20 = $row['taux20'];
        $taux25 = $row['taux25'];
        $tauxn = $row['tauxn'];
        $sql = "SELECT sum(heurs)as heur FROM personnels WHERE type = 'file' and nom = '".$nom."' and projet NOT IN (SELECT nom FROM projet)";
        $r = $conn->query($sql);
        
        
        if ($r->num_rows > 0) {
            while ($r1 = $r->fetch_assoc()) {
                $heurs = $r1['heur'];
                
                $rowNumber++;
                $sheet->setCellValue('A' . $rowNumber, $nom);
                $sheet->setCellValue('B' . $rowNumber, $profession);
                $sheet->setCellValue('C' . $rowNumber, $heurs);
                $sheet->setCellValue('D' . $rowNumber, $taux);
                $sheet->setCellValue('E' . $rowNumber, $taux5);
                $sheet->setCellValue('F' . $rowNumber, $taux10);
                $sheet->setCellValue('G' . $rowNumber, $taux15);
                $sheet->setCellValue('H' . $rowNumber, $taux20);
                $sheet->setCellValue('I' . $rowNumber, $taux25);
                $sheet->setCellValue('J' . $rowNumber, $tauxn);
            }
        }
    }
}

    
$sheet->getStyle('A' . $d+1 . ':J' . $rowNumber)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
$writer = new Xlsx($spreadsheet);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Facturation.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>
