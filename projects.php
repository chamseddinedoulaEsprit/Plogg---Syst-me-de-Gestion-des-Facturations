<?php
require 'PHPSpreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'excel1';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}
function addUploadedFile($uploadedFile, $nom, $profession, $taux)
{
$host = 'localhost1';
$username = 'root';
$password = '';
$database = 'excel1';

$conn = new mysqli($host, $username, $password, $database);

    $uploadedFile1 = IOFactory::load($uploadedFile);
    $uploadedSheet = $uploadedFile1->getActiveSheet();
    for($i=5;$i<1000;$i++){
    $heures = $uploadedSheet->getCellByColumnAndRow(10, $i)->getValue();
if ($uploadedSheet->getCellByColumnAndRow(10, $i+1)->getValue()==''){ break;}}
    $b = $heures * $taux;

    $fileId = uniqid();

    

    $sql = "INSERT INTO personnels (id,type, nom, profession,heurs, taux,total) VALUES ( '".$fileId."','final','".$nom."', '".$profession."','".$heures."', '".$taux."','". $b."')";
    $result = $conn->query($sql);
}




if ((isset($_POST['valider']))&&!(isset($_FILES['files'])))  {
    $nom = $_POST['nom'];
    $profession = $_POST['profession'];
    $heurs = $_POST['heurs'];
    $taux = $_POST['taux'];
    $total = $heurs * $taux;

    $manualEntryId = uniqid();
    

    $sql = "INSERT INTO personnels (id,type, nom, profession,heurs, taux,total) VALUES ( '".$manualEntryId."','final','".$nom."', '".$profession."','".$heurs."', '".$taux."','". $total."')";
    $result = $conn->query($sql);


    // Rediriger vers la page actuelle pour actualiser la liste
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
if ((isset($_POST['valider1'])))  {
    $nom = $_POST['nom'];
    $profession = $_POST['profession'];
    $taux = $_POST['taux'];
    $taux5 = $_POST['taux5'];
    $taux10 = $_POST['taux10'];
    $taux15 = $_POST['taux15'];
    $taux20 = $_POST['taux20'];
    $taux25 = $_POST['taux25'];
    $tauxn = $_POST['tauxn'];

    $manualEntryId = uniqid();
    $query = "SELECT COUNT(*) AS count FROM personnels WHERE nom = '".$nom."' and type='manuel1'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $count = $row['count'];
  
    if ($count == 0) {

    $sql = "INSERT INTO personnels (id,type, nom, profession, taux, taux5, taux10, taux15, taux20, taux25, tauxn) VALUES ( '".$manualEntryId."','manuel1','".$nom."', '".$profession."', '".$taux."', '".$taux5."', '".$taux10."', '".$taux15."', '".$taux20."', '".$taux25."', '".$tauxn."')";
    $result = $conn->query($sql);
    }
  
}



if ((isset($_FILES['files'])) && !(isset($_POST['valider']))) {
    $errors = [];
    $uploadedFiles = [];
    $extension = ['xls', 'xlsx'];

    $path = 'uploads/'; // Le dossier où les fichiers téléchargés seront stockés

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
        $id = $_POST['fil']; 
    
        $sql = "SELECT nom, profession, taux FROM personnels WHERE id = '".$id."'";
        $result = $conn->query($sql);
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
    
            $nom = $row['nom'];
            $profession = $row['profession'];
            $taux = $row['taux'];
    
            
        }
    
    
        
        foreach ($uploadedFiles as $uploadedFile) {
            addUploadedFile($uploadedFile, $nom, $profession, $taux);
           
        }
    }
}










?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Plogg | Personnels</title>
    <?php include 'includes/head-content.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" type="text/css" href="3.css">
    <link rel="stylesheet" href="custom.css">
    <style>
        .main-header, .main-footer, .content-wrapper, .card, .table {
            border-radius: 12px;
        }
        .card {
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            margin-bottom: 2rem;
        }
        .table thead th {
            background: #007bff;
            color: #fff;
            border: none;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f6fc;
        }
        .btn-custom {
            background: linear-gradient(90deg, #007bff 0%, #008cff 100%);
            color: #fff;
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn-custom:hover {
            background: linear-gradient(90deg, #0056b3 0%, #007bff 100%);
            color: #fff;
        }
        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #0c427b;
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
        }
        .form-control, .custom-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .input-file {
            font-size: 13px;
            font-weight: 500;
            color: #fff;
            background: #1e109d;
            border: none;
            padding: 7px 18px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .input-file:hover {
            background: #2a1ebd;
        }
        .table-actions .btn {
            margin-right: 0.5rem;
        }
        .table-actions .btn:last-child {
            margin-right: 0;
        }
        .radio-container {
            position: fixed;
            right: 150px;
            top: 500px;
            background: #fff;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .radio-button-group {
            display: flex;
            flex-direction: row;
            gap: 15px;
            margin-right: 15px;
        }
        
        .radio-button-group label {
            display: flex;
            align-items: center;
            padding: 8px 16px;
            background: #f8f9fa;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0;
        }
        
        .radio-button-group input[type="radio"] {
            margin-right: 10px;
        }
        
        .radio-button-group input[type="radio"]:checked + span {
            color: #007bff;
            font-weight: 600;
        }

        .export-controls {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            background: #fff;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .export-button {
            background: linear-gradient(90deg, #28a745 0%, #34ce57 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .export-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
        }
        @media (max-width: 768px) {
            .content-wrapper, .container-fluid, .card {
                padding: 0 5px !important;
            }
            .section-title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" class="nav-link">Accueil</a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
   
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="dashboard.php" class="brand-link">
      <span class="brand-text font-weight-light">Plogg</span>
    </a>

  

      

       <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
            <i class="fas fa-bars"></i>
              <p>
                Menu
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./dashboard.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <i class="nav-icon fas fa-file"></i>
                  <p>Expoter</p>
                </a>
              </li>
             
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./facture.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <i class="fas fa-user-cog"></i>
                  <p>Gestion</p>
                </a>
              </li>
             
            </ul>
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <a href="projects.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <i class="fas fa-user"></i>
                  <p>Personnels</p>
                </a>
              </li>
              
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./exclure.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <i class="fas fa-users-slash"></i>
                  <p>Projet a exclure</p>
                </a>
              </li>
             
            </ul>
          </li>
         
         </nav></div>
    
  </aside>
          
 


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Personnels</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Personnels</a></li>
              <li class="breadcrumb-item active">Exporter un fichier excel</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Personnels</h3>

          <div class="card-tools">
 
  
  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
    <i class="fas fa-minus"></i>
  </button>
  
  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
    <i class="fas fa-times"></i>
  </button>
</div>
          
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 20%">
                          Nom et Prénom
                      </th>
                      <th style="width: 20%">
                          Profession
                      </th>
                      <th >
                          Taux Cost
                      </th>
                      <th >
                          Taux 5%
                      </th>
                      <th >
                          Taux 10%
                      </th>
                      <th >
                          Taux 15%
                      </th>
                      <th >
                          Taux 20%
                      </th>
                      <th >
                          Taux 25%
                      </th>
                      <th >
                          Taux Normal
                      </th>
                      <th style="width: 20%" class="text-center">
                          Actions
                      
                  </tr>
              </thead>
              <tbody>
<?php 
$sql = "SELECT id, nom, profession, taux,taux5,taux10,taux15,taux20,taux25,tauxn FROM personnels WHERE type = 'manuel1'";
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


?>
<tr class='tablecnt'>
<td>
#
</td>
<td>
<a>
<?php echo htmlspecialchars($nom);
?></a>

</td>
<td>
<?php echo htmlspecialchars($profession);
?>
</li>
</ul>
</td>
<td >
<div >
<div >
</div>
</div>
<small>
<?php echo '$'.htmlspecialchars($taux); ?>
</small>
</td>
<td >
<div >
<div >
</div>
</div>
<small>
<?php echo '$'.htmlspecialchars($taux5); ?>
</small>
</td><td >
<div >
<div >
</div>
</div>
<small>
<?php echo '$'.htmlspecialchars($taux10); ?>
</small>
</td>
<td >
<div >
<div >
</div>
</div>
<small>
<?php echo '$'.htmlspecialchars($taux15); ?>
</small>
</td><td >
<div >
<div >
</div>
</div>
<small>
<?php echo '$'.htmlspecialchars($taux20); ?>
</small>
</td>
<td >
<div >
<div >
</div>
</div>
<small>
<?php echo '$'.htmlspecialchars($taux25); ?>
</small>
</td>
<td >
<div >
<div >
</div>
</div>
<small>
<?php echo '$'.htmlspecialchars($tauxn); ?>
</small>
</td>

    <td class="project-actions text-right">
<a class="btn btn-info btn-sm" href="modify.php?id=<?php echo htmlspecialchars($id); ?>">
<i class="fas fa-pencil-alt">
</i>
Edit
</a>
<a class="btn btn-danger btn-sm" href="delet1.php?id=<?php echo htmlspecialchars($id); ?>">
<i class="fas fa-trash">
</i>
Supprimer
</a>
</td>
</tr>

<?php } ?>
        <?php } ?>
        <?php 
    if (isset($_POST['ajoutaut1'])){
        
echo '<form method="POST">';
   
                    
                    echo "<tr><td>#</td><td><input type='text' name='nom' required></td><td><input type='text' name='profession' required></td><td><input type='number' name='taux' required style='width: 50px;'></td><td><input type='number' name='taux5' required style='width:  50px;'></td><td><input type='number' name='taux10' required style='width:  50px;'></td><td><input type='number' name='taux15' required style='width:  50px;'></td><td><input type='number' name='taux20' required style='width:  50px;'></td><td><input type='number' name='taux25' required style='width:  50px;'></td><td><input type='number' name='tauxn' required style='width:  50px;'></td>";
                    

        echo'<td><input type="submit" name="valider1" value="Valider" ></td></tr>'; 
        echo'</form>';}
     ?>
       
</tbody>
          </table>
        </div>
        <?php if (!isset($_POST['ajoutaut1'])) { ?>
    <form method="POST">
      <button type="submit" name="ajoutaut1" style="width: 300px;     margin-bottom: 10px;
    margin-top: 10px;font-family: 'Lato', sans-serif;color: #fff;
    background-color: #007bff;
    border-color: #007bff;border-radius: 4px;
    position: relative;
    right: -433px;
    box-shadow: none;">+ Ajouter un personnel</button>
    </form>
  <?php } ?>
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div><form method="POST" action="dashboard.php">
    <button type="submit" style="position: fixed; top: 564px; right: 8px; width: 100px; height: 100px; font-family: 'Lato', sans-serif; color: #fff; background-color:red;; border-color: #007bff; border-radius: 20%; box-shadow: none; text-align: center; line-height: 100px; padding: 0;">
    Exporter  <i class="fa fa-file-excel-o" style="color:red"></i>
</button>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Plogg</b> 2023
    </div>
    <strong>- &copy; 2023 <a href="#2">Plogg tunisie</a>.</strong>
  </footer>

  <!-- Control Sidebar -->
  
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>