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
                console.log("Loaded device options for ID:", deviceId);
                $('#deviceOptionsContent').html(response);
            },
            error: function() {
                alert('Wystąpił błąd podczas ładowania opcji urządzenia.');
            }
        });
    }
    
    $(document).on('click', '#saveForm', function() {
        var deviceId = $('#deviceId').val();
        console.log('Device ID:', deviceId);
    
        var formData = $('#deviceOptionsForm').serialize();
    
        var checkbox = $('input[name="settingValue"]');
        var checkboxExists = checkbox.length > 0 && checkbox.attr('type') === 'checkbox';
    
        if (checkboxExists) {
            var checkboxValue = checkbox.prop('checked') ? 1 : 0;
            formData += '&settingValue=' + checkboxValue;
        }
    
        $.ajax({
            url: 'edytuj-urzadzenie.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response); 
                alert("Zmiany zostały zapisane.");
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Wystąpił błąd podczas zapisywania zmian.', xhr.responseText);
                alert("Nie udało się wprowadzić zmian. Popraw wprowadzone dane lub zmniejsz ilość znaków i spróbuj ponownie.");
            }
        });
    });
    
    $(document).on('change', 'input[name="settingValue"]', function() {
        var checkboxValue = $(this).prop('checked') ? 1 : 0;
    });
    
    
    $(document).on('click', '#deleteForm', function() {
        var deviceId = $('#deviceId').val();
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