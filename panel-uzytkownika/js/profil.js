$(document).on('click', '#deactivateAccountBtn', function() {
    var confirmed = confirm("Czy na pewno chcesz dezaktywować konto? Utracisz dostęp do swojego konta i urządzeń z nim powiązanych, ten proces jest odwracalny tylko po skontaktowaniu się z administratorem strony.");
    if (confirmed) {
        $.ajax({
            url: 'dezaktywuj-konto.php',
            type: 'POST',
            success: function(response) {
                console.log(response);
                window.location.replace("panel-uzytkownika.php");
            },
            error: function(xhr, status, error) {
                console.error('Wystąpił błąd podczas dezaktywacji konta.', xhr.responseText);
            }
        });
    }
    else{
        alert('Anulowano procedurę dezaktywacji konta.');
        window.location.replace("profil-uzytkownika.php");
    }
});