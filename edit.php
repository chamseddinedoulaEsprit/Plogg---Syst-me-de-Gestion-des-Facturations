<form id="cookieForm">
    <label for="nom">Nom :</label>
    <input type="text" id="cookieKey" name="cookieKey" required value='..'>
    <label for="profession">Profession :</label>
    <input type="text" id="cookieProfession" name="cookieProfession" required value='..'>
    <label for="taux">Valeur :</label>
    <input type="text" id="cookieValue" name="cookieValue" required value='..'>

    <button type="submit">Modifier</button>
</form>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    // Envoi de la valeur de `id` à PHP via une requête AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_entry.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(`id=${id}`);

    const cookieForm = document.getElementById('cookieForm');

    cookieForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const cookieKey = document.getElementById('cookieKey').value;
        const cookieProfession = document.getElementById('cookieProfession').value;
        const cookieValue = document.getElementById('cookieValue').value;

        // Modification du cookie via une requête AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'modify_cookie.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`key=${cookieKey}&profession=${cookieProfession}&value=${cookieValue}`);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert('Le cookie a été modifié avec succès.');
                window.location.reload(); // Recharger la page après la modification
            } else {
                alert('Une erreur est survenue lors de la modification du cookie.');
            }
        };
    });
</script>
