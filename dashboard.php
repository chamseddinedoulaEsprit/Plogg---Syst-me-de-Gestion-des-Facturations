<?php
require 'PHPSpreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Connexion à la base de données
$host = 'localhost';     // Corriger l'URL - utiliser simplement localhost
$username = 'root';      // Utilisateur défini dans docker-compose
$password = '';  // Mot de passe défini dans docker-compose
$database = 'excel1';

try {
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        throw new Exception("Échec de la connexion à la base de données : " . $conn->connect_error);
    }
} catch (Exception $e) {
    die($e->getMessage());
}

// Fonction pour ajouter un fichier uploadé
function addUploadedFile($uploadedFile, $nom, $profession, $taux, $conn) {
    try {
        $spreadsheet = IOFactory::load($uploadedFile);
        $sheet = $spreadsheet->getActiveSheet();
        
        // Recherche de la dernière ligne avec des données
        $j = 0;
        for ($i = 5; $i < 1000; $i++) {
            if (empty($sheet->getCellByColumnAndRow(10, $i)->getValue())) {
                $j = $i;
                break;
            }
        }

        // Calcul du total pour la première insertion avec conversion de type
        $heures = floatval($sheet->getCellByColumnAndRow(10, 5)->getValue());
        $tauxValue = floatval($taux);
        $total = $heures * $tauxValue;
        $fileId = uniqid();

        // Vérification si le nom existe déjà
        $query = "SELECT COUNT(*) AS count FROM personnels WHERE nom = ? AND type = 'final'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $nom);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $stmt->close();

        if ($count == 0) {
            // Insertion dans la table personnels (type 'final')
            $sql = "INSERT INTO personnels (id, type, nom, profession, heurs, taux, total) VALUES (?, 'final', ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssdd", $fileId, $nom, $profession, $heures, $taux, $total);
            $stmt->execute();
            $stmt->close();
        }

        // Insertion des lignes du fichier
        for ($i = 6; $i < $j; $i++) {
            $heures = floatval($sheet->getCellByColumnAndRow(10, $i)->getValue());
            $pro = $sheet->getCellByColumnAndRow(1, $i)->getValue();
            $cat = $sheet->getCellByColumnAndRow(2, $i)->getValue();
            $total = $heures * $tauxValue;

            $sql = "INSERT INTO personnels (id, type, nom, profession, heurs, taux, total, projet, category) VALUES (?, 'file', ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssddss", $fileId, $nom, $profession, $heures, $taux, $total, $pro, $cat);
            $stmt->execute();
            $stmt->close();
        }
    } catch (Exception $e) {
        echo "Erreur lors du traitement du fichier : " . $e->getMessage();
    }
}

// Gestion des redirections
if (isset($_POST['fac'])) {
    if ($_POST['fac'] == "Facturation") {
        header("Location: chams123.php");
        exit;
    } elseif ($_POST['fac'] == "KPI") {
        header("Location: kpi.php");
        exit;
    }
}

// Gestion de l'entrée manuelle (valider)
if (isset($_POST['valider']) && !isset($_FILES['files'])) {
    $nom = $_POST['nom'];
    $profession = $_POST['profession'];
    $heurs = $_POST['heurs'];
    $taux = $_POST['taux'];
    $total = $heurs * $taux;
    $manualEntryId = uniqid();

    $sql = "INSERT INTO personnels (id, type, nom, profession, heurs, taux, total) VALUES (?, 'final', ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdd", $manualEntryId, $nom, $profession, $heurs, $taux, $total);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Gestion de l'entrée manuelle (valider1)
if (isset($_POST['valider1'])) {
    $nom = $_POST['nom'];
    $profession = $_POST['profession'];
    $taux = $_POST['taux'];
    $manualEntryId = uniqid();

    $sql = "INSERT INTO personnels (id, type, nom, profession, taux) VALUES (?, 'manuel1', ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssd", $manualEntryId, $nom, $profession, $taux);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Gestion de l'upload de fichiers
if (isset($_FILES['files']) && !isset($_POST['valider'])) {
    $errors = [];
    $uploadedFiles = [];
    $extension = ['xls', 'xlsx'];
    $path = 'Uploads/';

    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['files']['name'][$key];
        $file_tmp = $_FILES['files']['tmp_name'][$key];
        $file_size = $_FILES['files']['size'][$key];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($file_ext, $extension)) {
            $new_file_name = uniqid() . '.' . $file_ext;
            $dest = $path . $new_file_name;

            if (move_uploaded_file($file_tmp, $dest)) {
                $uploadedFiles[] = $dest;
            } else {
                $errors[] = 'Erreur lors du téléchargement du fichier ' . htmlspecialchars($file_name);
            }
        } else {
            $errors[] = 'Extension de fichier non autorisée : ' . htmlspecialchars($file_name);
        }
    }

    if ($errors) {
        print_r($errors);
    } else {
        $id = $_POST['fil'];
        $sql = "SELECT nom, profession FROM personnels WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nom = $row['nom'];
            $profession = $row['profession'];
            $taux = $_POST['taux'];

            foreach ($uploadedFiles as $uploadedFile) {
                addUploadedFile($uploadedFile, $nom, $profession, $taux, $conn);
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exporter</title>
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
<body class="hold-transition sidebar-mini layout-fixed" style="background-color: #f4f6f9;">
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
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-bars"></i>
                        <p>Menu <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./dashboard.php" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <i class="nav-icon fas fa-file"></i>
                                <p>Exporter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./facture.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <i class="fas fa-user-cog"></i>
                                <p>Gestion</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="projects.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <i class="fas fa-user"></i>
                                <p>Personnels</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./exclure.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <i class="fas fa-users-slash"></i>
                                <p>Projet à exclure</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </aside>

    <div class="content-wrapper" style="min-height: 583.4px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="section-title">Exporter un fichier Excel</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                            <li class="breadcrumb-item active">Exporter un fichier Excel</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <!-- Bloc Facture -->
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                $sql = "SELECT numero, dj, fj, m, adresse, societe FROM facture WHERE id = 1";
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

                                    $mois1 = match ($liste1[1]) {
                                        "01" => "Janvier",
                                        "02" => "Février",
                                        "03" => "Mars",
                                        "04" => "Avril",
                                        "05" => "Mai",
                                        "06" => "Juin",
                                        "07" => "Juillet",
                                        "08" => "Août",
                                        "09" => "Septembre",
                                        "10" => "Octobre",
                                        "11" => "Novembre",
                                        "12" => "Décembre",
                                        default => "Mois inconnu"
                                    };

                                    $mois2 = match ($liste2[1]) {
                                        "01" => "Janvier",
                                        "02" => "Février",
                                        "03" => "Mars",
                                        "04" => "Avril",
                                        "05" => "Mai",
                                        "06" => "Juin",
                                        "07" => "Juillet",
                                        "08" => "Août",
                                        "09" => "Septembre",
                                        "10" => "Octobre",
                                        "11" => "Novembre",
                                        "12" => "Décembre",
                                        default => "Mois inconnu"
                                    };

                                    $mois3 = match ($liste3[1]) {
                                        "01" => "Janvier",
                                        "02" => "Février",
                                        "03" => "Mars",
                                        "04" => "Avril",
                                        "05" => "Mai",
                                        "06" => "Juin",
                                        "07" => "Juillet",
                                        "08" => "Août",
                                        "09" => "Septembre",
                                        "10" => "Octobre",
                                        "11" => "Novembre",
                                        "12" => "Décembre",
                                        default => "Mois inconnu"
                                    };
                                ?>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="6"><?php echo htmlspecialchars($so); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5"><?php echo htmlspecialchars($so1); ?></td>
                                            <td style="width: 150px;"><?php echo htmlspecialchars($liste1[2] . '/' . $mois1 . '/' . $liste1[0]); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">Facture #<?php echo htmlspecialchars($num); ?> (Du <?php echo htmlspecialchars($liste2[2] . '/' . $mois2 . '/' . $liste2[0]); ?> au <?php echo htmlspecialchars($liste3[2] . '/' . $mois3 . '/' . $liste3[0]); ?>)</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="facture.php" class="text-center mb-4">
                    <button type="submit" class="btn btn-custom btn-lg">
                        <i class="fas fa-file-invoice-dollar mr-2"></i>GESTION DE FACTURE
                    </button>
                </form>

                <!-- Tableau des personnels -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0"><i class="fas fa-users mr-2"></i>Personnels</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom et Prénom</th>
                                        <th>Profession</th>
                                        <th>Taux</th>
                                        <th>Fichier</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT id, nom, profession, heurs, taux, taux5, taux10, taux15, taux20, taux25, tauxn FROM personnels WHERE type = 'manuel1'";
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
                                    <form method="POST" enctype="multipart/form-data">
                                        <tr>
                                            <td>#</td>
                                            <td><?php echo htmlspecialchars($nom); ?></td>
                                            <td><?php echo htmlspecialchars($profession); ?></td>
                                            <td>
                                                $<select name="taux" required>
                                                    <?php
                                                    $variables = array_filter([$taux, $taux5, $taux10, $taux15, $taux20, $taux25, $tauxn], function($value) {
                                                        return !is_null($value) && $value !== '';
                                                    });
                                                    foreach ($variables as $variable) {
                                                        echo '<option value="' . htmlspecialchars($variable) . '">' . htmlspecialchars($variable) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="file" name="files[]" class="input-file" accept=".xls,.xlsx">
                                                <input type="hidden" name="fil" value="<?php echo htmlspecialchars($id); ?>">
                                            </td>
                                            <td><input type="submit" value="Importer" class="butt1"></td>
                                        </tr>
                                    </form>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <h1>Les tableaux finaux :</h1>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Facture</h3>
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
                                    <th style="width: 1%">#</th>
                                    <th style="width: 20%" colspan='2'>NOM ET PROFESSION</th>
                                    <th style="width: 30%">Heures</th>
                                    <th>Taux</th>
                                    <th>Total</th>
                                    <th style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT id, nom, profession, heurs, taux, total FROM personnels WHERE type = 'final'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0 || isset($_POST['ajoutaut'])) {
                                    while ($row = $result->fetch_assoc()) {
                                        $id = $row['id'];
                                        $nom = $row['nom'];
                                        $profession = $row['profession'];
                                        $taux = $row['taux'];
                                        $total = $row['total'];

                                        $sql = "SELECT SUM(heurs) AS heur FROM personnels WHERE type = 'file' AND nom = ? AND projet NOT IN (SELECT nom FROM projet)";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("s", $nom);
                                        $stmt->execute();
                                        $r = $stmt->get_result();
                                        $heurs = $r->fetch_assoc()['heur'] ?? 0;
                                        $stmt->close();
                                ?>
                                <tr>
                                    <td>#</td>
                                    <td><?php echo htmlspecialchars($nom); ?></td>
                                    <td><?php echo htmlspecialchars($profession); ?></td>
                                    <td><?php echo htmlspecialchars($heurs); ?></td>
                                    <td><?php echo "$" . htmlspecialchars($taux); ?></td>
                                    <td><?php echo "$" . htmlspecialchars($heurs * $taux); ?></td>
                                    <td>
                                        <a class="btn btn-danger btn-sm" href="delet.php?id=<?php echo htmlspecialchars($id); ?>">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                    }
                                    if (isset($_POST['ajoutaut'])) {
                                ?>
                                <form method="POST">
                                    <tr>
                                        <td>#</td>
                                        <td><input type="text" name="nom" required></td>
                                        <td><input type="text" name="profession" required></td>
                                        <td><input type="number" name="heurs" required></td>
                                        <td style="width:80px;"><input type="number" name="taux" required></td>
                                        <td></td>
                                        <td><input type="submit" name="valider" value="Valider"></td>
                                    </tr>
                                </form>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if (!isset($_POST['ajoutaut'])) { ?>
                <br><br>
                <form method="POST">
                    <button type="submit" name="ajoutaut" value="+ Ajouter manuellement" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-plus mr-2"></i>+ Ajouter manuellement
                    </button>
                </form><br><br>

                <form method="POST" action="dashboard.php" class="export-controls">
                    <div class="radio-button-group">
                        <label>
                            <input type="radio" name="fac" value="Facturation" checked>
                            <span>Facturation</span>
                        </label>
                        <label>
                            <input type="radio" name="fac" value="KPI">
                            <span>KPI</span>
                        </label>
                    </div>
                    <input type="hidden" name="dataList" value="<?php echo htmlspecialchars(base64_encode(serialize($dataList ?? []))); ?>">
                    <button type="submit" class="export-button">
                        <i class="fa fa-file-excel-o mr-2"></i>Exporter
                    </button>
                </form>
                <?php } ?>
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Plogg</b> 2023
        </div>
        <strong>&copy; 2023 <a href="#2">Plogg Tunisie</a>.</strong>
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/demo.js"></script>
</body>
</html>