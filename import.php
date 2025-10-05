<?php
require_once "PHPSpreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
session_start();

if (isset($_FILES['files'])) {
    $errors = [];
    $uploadedFiles = [];
    $extension = ['xls', 'xlsx'];

    $path = 'C:\Users\chams\OneDrive\Bureau\Nouveau dossier\\';

    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['files']['name'][$key];
        $file_tmp = $_FILES['files']['tmp_name'][$key];
        $file_type = $_FILES['files']['type'][$key];
        $file_size = $_FILES['files']['size'][$key];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($file_ext, $extension)) {
            $new_file_name = uniqid() . '.' . $file_ext;
            $dest = $path . $new_file_name;

            if (move_uploaded_file($file_tmp, $dest)) {
                $uploadedFiles[] = $dest;
            } else {
                $errors[] = 'Erreur lors du téléchargement du fichier ' . $file_name;
            }
        } else {
            $errors[] = 'Extension de fichier non autorisée : ' . $file_name;
        }
    }

    if ($errors) {
        print_r($errors);
    } else {
        echo "<table border='2'><tr><td colspan='6'>SOCIETE PLOGG MEDIA SARL</td></tr>";
        echo "<tr><td colspan='5'>Adresse : B208,Immeuble Rayhane,Lotissement Centre Urbain,4000,Sousse,Tunisie</td><td>31-01-2023</td></tr>";
        echo "<tr><td colspan='6'>Facture #numero (Du date au date mois 2023)</td></tr></table><br><table border='1'><tr><td></td><td rowspan='2' colspan='4'>Objet:Facturation Plogg Tunisie (Mois2023)</td></tr></table><br><br>";

        foreach ($uploadedFiles as $file) {
            $uploadedFile = IOFactory::load($file);
            $uploadedSheet = $uploadedFile->getActiveSheet();
            $cellValue = $uploadedSheet->getCellByColumnAndRow(10, 16)->getValue();
            $b = $cellValue * 2;

            echo "<table border ='2'><tr><td colspan='2'>Production Hub - synode</td><td>Heures</td><td>Taux</td><td>Total</td></tr>";

            $start = strpos($uploadedSheet->getCellByColumnAndRow(1, 1)->getValue(), '-') + 1;
            $end = strpos($uploadedSheet->getCellByColumnAndRow(1, 1)->getValue(), '(') - 1;
            $a = substr($uploadedSheet->getCellByColumnAndRow(1, 1)->getValue(), $start, $end - $start + 1);

            echo "<tr><td>" . $a . "</td><td>Team Lead/ Artist 3D </td><td>" . $cellValue . "</td><td>$2.00</td><td>" . $b . "</td></table>";
            echo "<table border ='2'><tr><td colspan='5'></td><td>" . $b . "</td></table><br>";
        }

        $cookie_name = 'uploaded_files';
        $cookie_value = implode('|', $uploadedFiles);
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), '/'); // 30 days expiration

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=download.xls');
        exit();
    }
} elseif (isset($_COOKIE['uploaded_files'])) {
    $uploadedFiles = explode('|', $_COOKIE['uploaded_files']);

    echo "<table border='2'><tr><td colspan='6'>SOCIETE PLOGG MEDIA SARL</td></tr>";
    echo "<tr><td colspan='5'>Adresse : B208,Immeuble Rayhane,Lotissement Centre Urbain,4000,Sousse,Tunisie</td><td>31-01-2023</td></tr>";
    echo "<tr><td colspan='6'>Facture #numero (Du date au date mois 2023)</td></tr></table><br><table border='1'><tr><td></td><td rowspan='2' colspan='4'>Objet:Facturation Plogg Tunisie (Mois2023)</td></tr></table><br><br>";

    foreach ($uploadedFiles as $file) {
        $uploadedFile = IOFactory::load($file);
        $uploadedSheet = $uploadedFile->getActiveSheet();
        $cellValue = $uploadedSheet->getCellByColumnAndRow(10, 16)->getValue();
        $b = $cellValue * 2;

        echo "<table border ='2'><tr><td colspan='2'>Production Hub - synode</td><td>Heures</td><td>Taux</td><td>Total</td></tr>";

        $start = strpos($uploadedSheet->getCellByColumnAndRow(1, 1)->getValue(), '-') + 1;
        $end = strpos($uploadedSheet->getCellByColumnAndRow(1, 1)->getValue(), '(') - 1;
        $a = substr($uploadedSheet->getCellByColumnAndRow(1, 1)->getValue(), $start, $end - $start + 1);

        echo "<tr><td>" . $a . "</td><td>Team Lead/ Artist 3D </td><td>" . $cellValue . "</td><td>$2.00</td><td>" . $b . "</td></table>";
        echo "<table border ='2'><tr><td colspan='5'></td><td>" . $b . "</td></table><br>";
    }

    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename=download.xls');
    exit();
}
?>
