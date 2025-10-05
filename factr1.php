<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'excel1';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}
if ((isset($_POST['fac'])))  {
    $num = $_POST['num'];
    $dj = $_POST['dj'];
    $fj = $_POST['fj'];
    $m = $_POST['m'];
    $so = $_POST['so'];
    $so1 = $_POST['so1'];
    $sql = "UPDATE facture SET numero = '".$num."', dj = '".$dj."', fj = '".$fj."', m = '".$m."', societe = '".$so."', adresse = '".$so1."' WHERE id = 1";
    $result = $conn->query($sql);
  
    header("Location: dashboard.php");
exit;

    
  }
?>