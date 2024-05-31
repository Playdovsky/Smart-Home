$(document).ready(function() {
    $('#showForm').click(function() {
        $('#overlay').removeClass('d-none').fadeIn();
    });

    $('#hideForm').click(function() {
        $('#overlay').fadeOut(function() {
            $(this).addClass('d-none');
        });
    });

    //$('#overlay form').submit(function(event) {
    //    event.preventDefault();
    //    alert('Dodano nowe urządzenie do panelu!');
    //    $('#overlay').fadeOut();
    //});
});
