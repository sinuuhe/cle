<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
if (isset($_SESSION['ruta'])){
    header("Location: ".$_SESSION['ruta']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Login V12</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->	
        <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../public/login/vendor/bootstrap/css/bootstrap.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../public/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../public/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../public/login/vendor/animate/animate.css">
        <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="../public/login/vendor/css-hamburgers/hamburgers.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../public/login/vendor/select2/select2.min.css">
        <!-- CSS -->
        <link rel="stylesheet" href="../public/bower_components/alertify/css/alertify.min.css"/>
        <!-- Default theme -->
        <link rel="stylesheet" href="../public/bower_components/alertify/css/themes/default.min.css"/>
        <!-- Semantic UI theme -->
        <link rel="stylesheet" href="../public/bower_components/alertify/css/themes/semantic.min.css"/>
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../public/login/css/util.css">
        <link rel="stylesheet" type="text/css" href="../public/login/css/main.css">
        <!--===============================================================================================-->
    </head>
    <body>

        <div class="limiter">
            <div class="container-login100" style="background-image: url('../public/login/images/img-01.jpg');">
                <div class="wrap-login100 p-t-190 p-b-30">
                    <form id="login" class="login100-form validate-form" autocomplete="off">
                        <div class="login100-form-avatar">
                            <img src="../public/login/images/logo.png" alt="AVATAR">
                        </div>
                        <span class="login100-form-title p-t-20 p-b-45">
                            BIENVENIDO
                        </span>

                        <div class="wrap-input100 validate-input m-b-10" data-validate = "Nombre de usuario requerido">
                            <input required  class="input100" type="text" name="usuario" placeholder="Usuario" autocomplete="asd2qñame">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-10" data-validate = "Contraseña es requerida">
                            <input required  autocomplete="currdasñent-password" class="input100" type="password" name="contrasena" placeholder="Contraseña">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-lock"></i>
                            </span>
                        </div>

                        <div class="container-login100-form-btn p-t-10">
                            <button id="ingresar" type="submit" class="login100-form-btn">
                                Iniciar Sesión
                            </button>
                        </div>

                        <div class="text-center w-full p-t-25 p-b-230">
                            <a href="#" class="txt1">
                                ¿Olvidaste tú contraseña?
                            </a>
                        </div>

                        <div class="text-center w-full">
                            2018 CLEMORELIA – Todos los derechos reservados. Diseñado por <a href="https://www.ghopar.com" target="_blank">GHOPAR</a>.
                        </div>
                    </form>
                </div>
            </div>
        </div>
       
        <!--===============================================================================================-->	
        <script src="../public/login/vendor/jquery/jquery-3.2.1.min.js"></script>
        <!--===============================================================================================-->
        <script src="../public/login/vendor/bootstrap/js/popper.js"></script>
        <script src="../public/login/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../public/bower_components/alertify/js/alertify.min.js"></script>
        <!--===============================================================================================-->
        <script src="../public/login/vendor/select2/select2.min.js"></script>
        <!--===============================================================================================-->
        <script src="../public/login/js/main.js"></script>1
         <script src="scripts/login.js"></script>

    </body>
</html>