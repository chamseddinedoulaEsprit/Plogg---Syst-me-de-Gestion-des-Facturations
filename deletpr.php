<!DOCTYPE html>
<html>
<head>
    <title>Suppression d'une entrée</title>
</head>
<body>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const nom = urlParams.get('id');

        // Envoi de la valeur de `id` à PHP via une requête AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'dl.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`id=${nom}`);
        xhr.onload = function() {
            if (xhr.status === 200) {
                window.location.href = 'exclure.php';
            }
        };
    </script>
   
</body>
</html>
