<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Ingreso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-color: #f8f9fa; font-family: Arial, sans-serif; padding: 20px;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow rounded-4">
                    <div class="card-body text-center">
                        <h2 class="card-title mb-4 text-primary">Tu Código de Ingreso</h2>
                        <p class="card-text">Hola,</p>
                        <p>Tu código de ingreso es:</p>
                        <h1 class="fw-bold text-success mb-4">{{$random}}</h1>
                        <hr>
                        <p class="mb-0">Si no solicitaste este código, por favor ignora este mensaje.</p>
                    </div>
                </div>
                <footer class="text-center mt-4">
                    <p class="text-muted small">Este es un mensaje automático. Por favor, no respondas directamente a este correo.</p>
                </footer>
            </div>
        </div>
    </div>

</body>

</html>