<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'excel1';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

// Récupérer les valeurs envoyées via AJAX
$id = $_POST['id'];
$nom = $_POST['nom'];
$profession = $_POST['profession'];

$taux = $_POST['taux'];
$taux5 = $_POST['taux5'];
$taux10 = $_POST['taux10'];
$taux15 = $_POST['taux15'];
$taux20 = $_POST['taux20'];
$taux25 = $_POST['taux25'];
$tauxn = $_POST['tauxn'];



// Votre logique de modification ici
$sql = "UPDATE personnels SET nom='".$nom."', profession='".$profession."', taux='".$taux."', taux5='".$taux5."', taux10='".$taux10."', taux15='".$taux15."', taux20='".$taux20."', taux25='".$taux25."', tauxn='".$tauxn."' WHERE id='".$id."'";
$result = $conn->query($sql);

$javascriptCode = "<script>document.addEventListener('DOMContentLoaded', function() {window.location.href = 'projects.php'; });</script>";
echo $javascriptCode;


?>
