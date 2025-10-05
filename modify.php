
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>|  editer  |</title>
  <link rel="stylesheet" type="text/css" href="3.css" />
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
      </li>
      
    </ul>


  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <a href="dashboard.php" class="brand-link">
      <span class="brand-text font-weight-light">Plogg</span>
    </a>

  

      

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Exporter
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./dashboard.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Expoter</p>
                </a>
              </li>
             
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./facture.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ges facture</p>
                </a>
              </li>
             
            </ul>
          </li>
         
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Personnels
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <a href="projects.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Personnels</p>
                </a>
              </li>
              
            </ul>
              
          </li></nav></div>
     </aside>
          
 
  <div class="content-wrapper">
   
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Modification d'un personnel</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Accueil</a></li>
              <li class="breadcrumb-item active">Modification d'un personnel</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
        <div>
    
    <?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'excel1';

    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données: " . $conn->connect_error);
    }
    
    $id = $_GET['id'];




   
    $sql = "SELECT * FROM personnels WHERE id='".$id."'";
    $result = $conn->query($sql);
    $entry = $result->fetch_assoc();

    $nom = $entry['nom'];
    $profession = $entry['profession'];
    $taux = $entry['taux'];
    $taux5 = $entry['taux5'];
    $taux10 = $entry['taux10'];
    $taux15 = $entry['taux15'];
    $taux20 = $entry['taux20'];
    $taux25 = $entry['taux25'];
    $tauxn = $entry['tauxn'];
  
    

    echo "<table border='2'><form action='modify_entry.php' method='POST'>";
                    echo "<tr><td colspan='2'>Production Hub - synode</td><td>Taux</td><td>Taux 5%</td><td>Taux 10%</td><td>Taux 15%</td><td>Taux 20%</td><td>Taux 25%</td><td>Taux Normal</td></tr>";
                    echo "<tr><td><input type='text' name='nom' value='".htmlspecialchars($nom)."'></td><td><input type='text' name='profession' value='" . htmlspecialchars($profession) . "'></td><td><input type='number' name='taux' value='" . htmlspecialchars($taux) . "' style='width: 50px;'></td><td><input type='number' name='taux5' value='" . htmlspecialchars($taux5) . "' style='width: 50px;'></td><td><input type='number' name='taux10' value='" . htmlspecialchars($taux10) . "' style='width: 50px;'></td><td><input type='number' name='taux15' value='" . htmlspecialchars($taux15) . "' style='width: 50px;'></td><td><input type='number' name='taux20' value='" . htmlspecialchars($taux20) . "' style='width: 50px;'></td><td><input type='number' name='taux25' value='" . htmlspecialchars($taux25) . "' style='width: 50px;'></td><td><input type='number' name='tauxn' value='" . htmlspecialchars($tauxn) . "'style='width: 50px;'></td></table><br>";
                    echo "<input type='hidden' id='hiddenField' name='id' value='".$id."'>
                    <input type='submit' value='Enregistrer les modifications'></form>";
                    ?>
                    <br><br><br><br>
                     <a class="btn btn-danger btn-sm" href="projects.php">
                    <i class="fas fa-trash">
                    </i>
                    Annuler les modifications
                    </a>
   
</div> 
</section>
</div>
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Plogg</b> 2023
    </div>
    <strong>- &copy; 2023 <a href="#2">Plogg Tunisie</a>.</strong>
  </footer>

  
  <aside class="control-sidebar control-sidebar-dark">
   
  </aside>


 
<script src="plugins/jquery/jquery.min.js"></script>

<script src="plugins/jquery-ui/jquery-ui.min.js"></script>

<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="plugins/chart.js/Chart.min.js"></script>

<script src="plugins/sparklines/sparkline.js"></script>

<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>

<script src="plugins/jquery-knob/jquery.knob.min.js"></script>

<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>

<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<script src="plugins/summernote/summernote-bs4.min.js"></script>

<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<script src="dist/js/adminlte.js"></script>

<script src="dist/js/demo.js"></script>

<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>
