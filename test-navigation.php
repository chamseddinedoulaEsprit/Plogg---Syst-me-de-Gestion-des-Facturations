<?php
session_start();

// Simuler différents chemins de redirection
if(isset($_GET['action'])) {
    switch($_GET['action']) {
        case 'facture':
            header('Location: facture.php');
            exit;
        case 'projects':
            header('Location: projects.php');
            exit;
        case 'exclure':
            header('Location: exclure.php');
            exit;
        // Ajouter d'autres cas au besoin
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Navigation</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Test de Navigation</h2>
        
        <div class="card">
            <div class="card-body">
                <h4>Liens de Navigation</h4>
                <ul>
                    <li><a href="dashboard.php">Page principale</a></li>
                    <li><a href="?action=facture">Vers Facture</a></li>
                    <li><a href="?action=projects">Vers Projects</a></li>
                    <li><a href="?action=exclure">Vers Exclure</a></li>
                </ul>

                <h4>Test des formulaires</h4>
                <form method="POST" action="dashboard.php">
                    <div class="mb-3">
                        <label>Test Radio Buttons</label><br>
                        <input type="radio" name="fac" value="Facturation"> Facturation
                        <input type="radio" name="fac" value="KPI"> KPI
                    </div>
                    <button type="submit" class="btn btn-primary">Tester Redirection</button>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h4>Informations de Debug</h4>
                <pre>
                <?php
                echo "Session : \n";
                print_r($_SESSION);
                echo "\nPOST : \n";
                print_r($_POST);
                echo "\nGET : \n";
                print_r($_GET);
                ?>
                </pre>
            </div>
        </div>
    </div>
</body>
</html>
