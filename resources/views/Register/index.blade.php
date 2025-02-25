<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <title>Document</title>
</head>

<body>
    <div class="wrapper">
        <div id="formContent">
            <!-- Tabs Titles -->
            <h2 class="active"> Registro </h2>
            <!-- Icon -->
            <!-- Login Form -->
            <form method="POST" action="register">
                @csrf
                <input type="text" id="email" class="second" name="email" placeholder="Correo">


                <input type="password" id="password" class="third" name="password" placeholder="Contraseña">


                <input type="password" id="password_confirmation" class="third" name="password_confirmation" placeholder="Confirmar Contraseña">
                <div>

                    <small id="emailError" style="color: red;">Debe ser un correo válido.</small>
                    <small id="passwordError" style="color: red;">
                        <br> La contraseña debe tener al menos una mayúscula, una minúscula, un carácter especial y 8 caracteres.
                    </small>
                    <small id="passwordMatchError" style="color: red;"><br>Las contraseñas no coinciden.</small>
                    <br>
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                    @if ($errors->has('g-recaptcha-response'))
                    <span style="color: red;">{{ $errors->first('g-recaptcha-response') }}</span>
                    @endif
                    @if ($errors->any())
            <div class="alert alert-danger" style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
                <!-- Widget de reCAPTCHA -->
            

                <input type="submit" class="fourth" value="Registrar" disabled id="submitButton">
            </form>
            <input type="button" class="underlineHover" value="Login" onclick="window.location.href='login'">


            <!-- Remind Passowrd -->
           
        </div>
    </div>
    <script>
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");
        const passwordConfirmationInput = document.getElementById("password_confirmation");
        const submitButton = document.getElementById("submitButton");

        const emailError = document.getElementById("emailError");
        const passwordError = document.getElementById("passwordError");
        const passwordMatchError = document.getElementById("passwordMatchError");

        // Validación de correo
        emailInput.addEventListener("input", () => {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailRegex.test(emailInput.value)) {
                emailError.style.color = "green";
                emailInput.style.borderColor = "green";
            } else {
                emailError.style.color = "red";
                emailInput.style.borderColor = "red";
            }
            toggleSubmitButton();
        });

        // Validación de contraseña
        passwordInput.addEventListener("input", () => {
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/;
            if (passwordRegex.test(passwordInput.value)) {
                passwordInput.style.borderColor = "green";
                passwordError.style.color = "green";
            } else {
                passwordError.style.color = "red";
                passwordInput.style.borderColor = "red";
            }
            toggleSubmitButton();
        });

        // Validación de confirmación de contraseña
        passwordConfirmationInput.addEventListener("input", () => {
            if (passwordConfirmationInput.value === passwordInput.value) {
                passwordConfirmationInput.style.borderColor = "green";
                passwordMatchError.style.color = "green";
            } else {
                passwordMatchError.style.color = "red";
                passwordConfirmationInput.style.borderColor = "red";
            }
            toggleSubmitButton();
        });

        // Habilitar el botón de submit si todo es válido
        function toggleSubmitButton() {
            const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);
            const passwordValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/.test(passwordInput.value);
            const passwordsMatch = passwordInput.value === passwordConfirmationInput.value;

            submitButton.disabled = !(emailValid && passwordValid && passwordsMatch);
        }
    </script>
</body>

</html>
<style>
    @import url('https://fonts.googleapis.com/css?family=Poppins');


    html {
        background-color: rgb(62, 62, 62);
    }

    body {
        font-family: "Poppins", sans-serif;
        height: 100vh;
    }

    a {
        color: #92badd;
        display: inline-block;
        text-decoration: none;
        font-weight: 400;
    }

    h2 {
        text-align: center;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
        margin: 40px 8px 10px 8px;
        color: #cccccc;
    }


    .wrapper {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        width: 100%;
        min-height: 100%;
        padding: 20px;
    }

    #formContent {
        -webkit-border-radius: 10px 10px 10px 10px;
        border-radius: 10px 10px 10px 10px;
        background-color: rgb(216, 216, 216);
        padding: 30px;
        width: 90%;
        max-width: 450px;
        position: relative;
        padding: 0px;
        -webkit-box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
        box-shadow: 0 30px 60px 0 rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    #formFooter {
        background-color: #f6f6f6;
        border-top: 1px solid #dce8f1;
        padding: 25px;
        text-align: center;
        -webkit-border-radius: 0 0 10px 10px;
        border-radius: 0 0 10px 10px;
    }

    h2.inactive {
        color: #cccccc;
    }

    h2.active {
        color: #0d0d0d;
        border-bottom: 2px solid #5fbae9;
    }


    input[type=button],
    input[type=submit],
    input[type=reset] {
        background-color: #56baed;
        border: none;
        color: white;
        padding: 15px 80px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        font-size: 13px;
        -webkit-box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
        box-shadow: 0 10px 30px 0 rgba(95, 186, 233, 0.4);
        -webkit-border-radius: 5px 5px 5px 5px;
        border-radius: 5px 5px 5px 5px;
        margin: 5px 20px 40px 20px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    input[type=button]:hover,
    input[type=submit]:hover,
    input[type=reset]:hover {
        background-color: #39ace7;
    }

    input[type=button]:active,
    input[type=submit]:active,
    input[type=reset]:active {
        -moz-transform: scale(0.95);
        -webkit-transform: scale(0.95);
        -o-transform: scale(0.95);
        -ms-transform: scale(0.95);
        transform: scale(0.95);
    }

    input[type=text],
    input[type=password] {
        background-color: #f6f6f6;
        border: none;
        color: #0d0d0d;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 5px;
        width: 85%;
        border: 2px solid #f6f6f6;
        -webkit-transition: all 0.5s ease-in-out;
        -moz-transition: all 0.5s ease-in-out;
        -ms-transition: all 0.5s ease-in-out;
        -o-transition: all 0.5s ease-in-out;
        transition: all 0.5s ease-in-out;
        -webkit-border-radius: 5px 5px 5px 5px;
        border-radius: 5px 5px 5px 5px;
    }

    input[type=text]:focus {
        background-color: #fff;
        border-bottom: 2px solid #5fbae9;
    }

    input[type=text]:placeholder {
        color: #cccccc;
    }


    .fadeInDown {
        -webkit-animation-name: fadeInDown;
        animation-name: fadeInDown;
        -webkit-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }

    @-webkit-keyframes fadeInDown {
        0% {
            opacity: 0;
            -webkit-transform: translate3d(0, -100%, 0);
            transform: translate3d(0, -100%, 0);
        }

        100% {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
        }
    }

    @keyframes fadeInDown {
        0% {
            opacity: 0;
            -webkit-transform: translate3d(0, -100%, 0);
            transform: translate3d(0, -100%, 0);
        }

        100% {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
        }
    }

    /* Simple CSS3 Fade-in Animation */
    @-webkit-keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @-moz-keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .fadeIn {
        opacity: 0;
        -webkit-animation: fadeIn ease-in 1;
        -moz-animation: fadeIn ease-in 1;
        animation: fadeIn ease-in 1;

        -webkit-animation-fill-mode: forwards;
        -moz-animation-fill-mode: forwards;
        animation-fill-mode: forwards;

        -webkit-animation-duration: 1s;
        -moz-animation-duration: 1s;
        animation-duration: 1s;
    }

    .fadeIn.first {
        -webkit-animation-delay: 0.4s;
        -moz-animation-delay: 0.4s;
        animation-delay: 0.4s;
    }

    .fadeIn.second {
        -webkit-animation-delay: 0.6s;
        -moz-animation-delay: 0.6s;
        animation-delay: 0.6s;
    }

    .fadeIn.third {
        -webkit-animation-delay: 0.8s;
        -moz-animation-delay: 0.8s;
        animation-delay: 0.8s;
    }

    .fadeIn.fourth {
        -webkit-animation-delay: 1s;
        -moz-animation-delay: 1s;
        animation-delay: 1s;
    }

    .underlineHover:after {
        display: block;
        left: 0;
        bottom: -10px;
        width: 0;
        height: 2px;
        background-color: #56baed;
        content: "";
        transition: width 0.2s;
    }

    .underlineHover:hover {
        color: #0d0d0d;
    }

    .underlineHover:hover:after {
        width: 100%;
    }



    /* OTHERS */

    *:focus {
        outline: none;
    }

    #icon {
        width: 60%;
    }

    * {
        box-sizing: border-box;
    }
</style>