<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticación</title>
    <script>
        // Esperar a que la ventana principal esté disponible
        window.onload = function() {
            if (window.opener) {
                try {
                    console.log("Popup Origin:", window.origin); // Log the origin

                    console.log("Popup User:", @json($user)); // Log the user

                    console.log("Popup Token:", "{{ $token }}"); // Log the token

                    @isset($errorMessage)
                        window.opener.postMessage({ error: "{{ $errorMessage }}", success: false }, 'http://localhost:5174');
                        window.opener.postMessage({ error: "{{ $errorMessage }}", success: false }, 'http://localhost:5175');
                        window.opener.postMessage({ error: "{{ $errorMessage }}", success: false }, 'https://frontend.projectogb4.ddaw.es/');

                        window.close();
                    @endisset
                    @isset($token)
                        // Enviar el token a la ventana principal
                        window.opener.postMessage({ token: "{{ $token }}", user: @json($user), success: true }, 'http://localhost:5174');
                        window.opener.postMessage({ token: "{{ $token }}", user: @json($user), success: true }, 'http://localhost:5175');
                        window.opener.postMessage({ token: "{{ $token }}", user: @json($user), success: true }, 'https://frontend.projectogb4.ddaw.es/');

                        window.close();
                    @endisset
                } catch (e) {
                    console.error("Error in popup:", e);
                    window.opener.postMessage({ error: e.message, success: false }, 'http://localhost:5174');
                    window.opener.postMessage({ error: e.message, success: false }, 'http://localhost:5175');
                    window.opener.postMessage({ error: e.message, success: false }, 'https://frontend.projectogb4.ddaw.es/');

                    window.close();
                }
            } else {
                console.error("No opener window found.");
            }
        };
    </script>
</head>
<body>
    <p>Autenticando...</p>
</body>
</html>