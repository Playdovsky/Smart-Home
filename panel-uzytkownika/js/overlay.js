$(document).ready(function() {
    $('#showForm').click(function() {
        $('#overlay').removeClass('d-none').fadeIn();
    });

    $('#hideForm').click(function() {
        $('#overlay').fadeOut(function() {
            $(this).addClass('d-none');
        });
    });

    $(document).ready(function() {
        $(document).on('click', '.showFormOptions', function() {
            var deviceId = $(this).data('device-id');
            $('#deviceId').val(deviceId);
            $('#overlayOptions').removeClass('d-none').fadeIn();
            loadDeviceOptions(deviceId);
        });
    });

    $('#hideFormOptions').click(function() {
        $('#overlayOptions').fadeOut(function() {
            $(this).addClass('d-none');
        });
    });

    function loadDeviceOptions(deviceId) {
        $.ajax({
            url: 'dane-urzadzen.php',
            type: 'GET',
            data: { device_id: deviceId },
            success: function(response) {
                $('#deviceOptionsContent').html(response);
            },
            error: function() {
                alert('Wystąpił błąd podczas ładowania opcji urządzenia.');
            }
        });
    }

    $(document).ready(function() {
        $(document).on('click', '#deleteForm', function() {
            var deviceId = $(this).closest('#overlayOptions').find('#deviceId').val();

            var confirmed = confirm("Czy na pewno chcesz usunąć to urządzenie?");

            if (confirmed) {
                var data = {
                    device_id: deviceId
                };

                $.ajax({
                    url: 'usun-urzadzenie.php',
                    type: 'POST', 
                    data: data,
                    success: function(response) { 
                        console.log(response);
                        location.reload();
                    },
                    error: function() {
                        console.error('Wystąpił błąd podczas usuwania urządzenia.');
                    }
                });
            }
        });
    });   
});