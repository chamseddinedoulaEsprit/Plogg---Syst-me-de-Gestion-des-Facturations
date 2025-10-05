<?php
require 'PHPSpreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Connexion unique à la base de données
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

// Gestion de l'ajout de projet
if (isset($_POST['valider'])) {
    $nom = $conn->real_escape_string($_POST['nom']);
    $sql = "INSERT INTO projet (nom) VALUES (?)";
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nom);
        if (!$stmt->execute()) {
            throw new Exception("Erreur lors de l'ajout du projet");
        }
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Plogg | Projets à exclure</title>
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
 <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" class="nav-link">Accueil</a>
   
    </ul>

    
    
  </nav>
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
                <a href="projects.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <i class="fas fa-user"></i>
                  <p>Personnels</p>
                </a>
              </li>
              
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./exclure.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <i class="fas fa-users-slash"></i>
                  <p>Projet à exclure</p>
                </a>
              </li>
             
            </ul>
          </li>
         
         </nav></div>
    
  </aside>
          
 
  
  <div class="content-wrapper">
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Projet à exclure</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Accueil</a></li>
              <li class="breadcrumb-item active">Exporter un fichier excel</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    
    
  <?php
$sql = "SELECT nom FROM projet";
$result = $conn->query($sql);

   
      
    ?>
   
   
  


<?php 

    ?>


        

      
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">PROJETS :</h3>

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
                      <th style="width: 80%">
                    NOM DU PROJET
                      </th>
                      
                      <th style="width: 20%">
                      Actions
                      </th>
                  </tr>
              </thead>
              <tbody>
<?php  if ($result->num_rows > 0) {
      

    while ($row = $result->fetch_assoc()) {
        $nom = $row['nom'];
        
        
        
?>
                   <tr>
  <td>#</td>
  <td><?php echo htmlspecialchars($nom); ?></td>
  
<?php echo "<td>";
                    ?>
<a class="btn btn-danger btn-sm" href="deletpr.php?id=<?php echo htmlspecialchars($nom); ?>">
<i class="fas fa-trash">
</i>
Supprimer
</a>
                   
                </li>
            <?php  echo "</td></tr>";}}
    if (isset($_POST['ajoutaut'])){
       
echo '
    <form method="POST">';
   
    echo "<tr><td>#</td><td><input type='text' name='nom' required style='width: 900px;'></td>";
  

        echo '<td><input type="submit" name="valider" value="Valider" >';
    echo'</td></tr></form>';}
 echo  "</table>"; ?>
        
            
       
</tbody>
          </table>
        </div><?php
        if (!(isset($_POST['ajoutaut']))){?>
    <br><br><form method="POST">
    <button type="submit" name="ajoutaut" value="+ Ajouter manuellement" style="position: relative;
    right: -400px; width: 300px; font-family: 'Lato', sans-serif;color: #fff;
    background-color: #007bff;
    border-color: #007bff;border-radius: 4px;
    box-shadow: none;" > + Ajouter des projets à exclure</button>
</form><br><br>





    <?php }?>
    </div>
      

    </section>

  </div></div></div><form method="POST" action="dashboard.php">
    <button type="submit" style="position: fixed; top: 564px; right: 8px; width: 100px; height: 100px; font-family: 'Lato', sans-serif; color: #fff; background-color:red;; border-color: #007bff; border-radius: 20%; box-shadow: none; text-align: center; line-height: 100px; padding: 0;">
    Exporter  <i class="fa fa-file-excel-o" style="color:red"></i>
</button>
  
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Plogg</b> 2023
    </div>
    <strong>- &copy; 2023 <a href="#2">Plogg tunisie</a>.</strong>
  </footer>
  <aside class="control-sidebar control-sidebar-dark">
  
  </aside>

</div>


<script src="../../plugins/jquery/jquery.min.js"></script>

<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="../../dist/js/adminlte.min.js"></script>

<script src="../../dist/js/demo.js"></script>
</body>
</html>