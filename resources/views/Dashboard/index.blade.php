<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <div class="container">
    <h1>¡Bienvenido al Dashboard!</h1>
        <div class="row">
            <div class="col-6 col-md-6">
                <img src="https://media.gettyimages.com/id/673115623/photo/hand-of-man-stroking-tabby-cat.jpg?b=1&s=170667a&w=0&k=20&c=wvSe7JU3nmvTG7y3edAnXH497L8GMEo47luDysHj4wE=" alt="imagen gato">
            </div>
            <div class="col-6 col-md-6">
                <h1>has iniciado sesion, ahora puedes ver el gato</h1>
            </div>
        </div>
    </div>

    <form method="POST" action="logout">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
</body>

</html>