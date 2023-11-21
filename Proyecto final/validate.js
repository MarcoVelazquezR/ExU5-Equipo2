    $(document).ready(function() {
    $('#loginForm').submit(function(e) {
        e.preventDefault(); // Evita el envío del formulario por defecto

        // Validación del lado del cliente
        var login = $('#login').val();
        var password = $('#password').val();

        if (login === '' || password === '') {
            alert('Por favor, complete todos los campos.');
            return;
        }

        // Envío del formulario
        $.ajax({
            type: 'POST',
            url: 'login_process.php',
            data: $(this).serialize(),
            success: function(response) {
                // Manejar la respuesta del servidor, por ejemplo, redirigir a otra página si el inicio de sesión es exitoso
                console.log(response);
            },
            error: function(error) {
                console.log('Error en la solicitud AJAX: ' + error);
            }
        });
    });
});
