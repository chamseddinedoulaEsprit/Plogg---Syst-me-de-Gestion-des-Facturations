<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'excel1';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}
// Récupérer la valeur de 'id' envoyée via AJAX
$id = $_POST['id'];

// Votre logique de suppression ici
$deleteEntries = [$id];
$sql="DELETE FROM personnels WHERE id='".$id."'";
$result = $conn->query($sql);


?>
