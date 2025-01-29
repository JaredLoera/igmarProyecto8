<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmacion de correo</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow rounded-4">
                    <div class="card-body text-center">
                        <h2 class="card-title mb-4 text-primary">Confirmacion de correo</h2>
                        <p class="card-text">Hola,</p>
                        <p>Para confirmar tu correo, por favor da click en el siguiente boton:</p>
                        <a href="{{$url}}" class="btn btn-primary">Confirmar correo</a>
                        <hr>
                        <p class="mb-0">Si no solicitaste este correo, por favor ignora este mensaje.</p>
                    </div>
                </div>
                <footer class="text-center mt-4">
                    <p class="text-muted
                    small">Este es un mensaje automático. Por favor, no respondas directamente a este correo.</p>
                </footer>
            </div>
        </div>
    </div>
</body>
</html>