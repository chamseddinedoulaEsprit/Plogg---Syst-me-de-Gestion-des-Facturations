<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'excel1';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}

$nom = $_POST['id'];


$deleteEntries = [$nom];
$sql="DELETE FROM projet WHERE nom='".$nom."'";
$result = $conn->query($sql);


?>
