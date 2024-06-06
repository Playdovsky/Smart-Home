document.getElementById("profileForm").addEventListener("submit", function(event) {
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response);
            alert('Zmiany zostały zapisane.');
            window.location.replace("panel-uzytkownika.php");
        },
        error: function(xhr, status, error) {
            console.error('Wystąpił błąd podczas zapisywania zmian.', xhr.responseText);
            alert('Wystąpił błąd podczas zapisywania zmian. Spróbuj ponownie.');
        }
    });
});

$(document).on('click', '#deactivateAccountBtn', function() {
    var confirmed = confirm("Czy na pewno chcesz dezaktywować konto? Utracisz dostęp do swojego konta i urządzeń z nim powiązanych, ten proces jest odwracalny tylko po skontaktowaniu się z administratorem strony.");
    if (confirmed) {
        $.ajax({
            url: 'dezaktywuj-konto.php',
            type: 'POST',
            success: function(response) {
                console.log(response);
                alert('Twoje konto zostało dezaktywowane.');
                window.location.replace("panel-uzytkownika.php");
            },
            error: function(xhr, status, error) {
                console.error('Wystąpił błąd podczas dezaktywacji konta.', xhr.responseText);
            }
        });
    } else {
        console.log('Dezaktywacja konta anulowana.');
    }
});