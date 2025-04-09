<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 419</title>
</head>
<body>
    <h1>Sesión expirada</h1>
    <p>Tu sesión ha expirado. Por favor, vuelve a iniciar sesión.</p>
    <a href="/">Volver al inicio</a>
    <a href="javascript:history.back()">Volver a la página anterior</a>
    <script>
        // Optional: Redirect to login page after a few seconds
        setTimeout(function() {
            window.location.href = '/login'; // Cambia esto a la URL de tu página de inicio de sesión
        }, 5000); // 5000 ms = 5 seconds
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        h1 {
            color: red;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: blue;
        }
        a:hover {
            text-decoration: underline;
        }
        p {
            font-size: 18px;
            color: #333;
        }
        @media (max-width: 600px) {
            body {
                font-size: 14px;
            }
            h1 {
                font-size: 24px;
            }
        }
    </style>
</body>
</html>