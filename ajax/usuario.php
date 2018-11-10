<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
require_once dirname(__DIR__, 1) . "/modelos/Usuario.php";

$usuario = new Usuario();

switch ($_GET["op"]) {
    case 'verificar':
        $user = isset($_POST["usuario"]) ? limpiarCadena($_POST["usuario"]) : "";
        $pass = isset($_POST["contrasena"]) ? limpiarCadena($_POST["contrasena"]) : "";

        //Hash SHA256 en la contraseña
        //$clavehash=hash("SHA256",$clavea);

        $rspta = $usuario->verificar($user, $pass);
        if ($rspta) {
            $fetch = $rspta->fetch_object();
            if (isset($fetch)) {
                //Declaramos las variables de sesión
                $_SESSION['usuario'] = $fetch->usuario;
                $_SESSION['nombre'] = $fetch->nombre;
                $_SESSION['imagen'] = $fetch->imagen;
                $_SESSION['permiso'] = $fetch->permiso;
                $_SESSION['ruta'] = $fetch->ruta;
            } else {
                die("ERROR AL DEFINIR VARIABLES DE SESIÓN");
            }
        } else {
            die($conexion->error);
        }
        echo json_encode($fetch);
        break;

    case 'salir':
        //Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");
        break;
}
?>