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
        $rspta = "";
        $permiso = 0;
        $ruta = "";
        //Hash SHA256 en la contraseña
        //$clavehash=hash("SHA256",$clavea);
        switch ($user){
            case substr($user, 0, 1) == "A"://ver si es alumno
                $rspta = $usuario -> verificarA($user, $pass);
                $permiso = 2;
                $ruta = "panel-alumnos.php";
                break;
            case substr($user, 0, 1) == "R"://ver si es root
                $rspta = $usuario->verificarR($user, $pass);
                $permiso = 1;
                $ruta = "panel-administracion.php";
                break;
            case substr($user, 0, 1) == "C"://ver si es personal
                $rspta = $usuario->verificarP($user, $pass);
                $permiso = 4;
                $ruta = "panel-personal.php";
                break;
            case substr($user, 0, 1) == "M"://ver si es maestros
                $rspta = $usuario->verificarM($user, $pass);
                $permiso = 3;
                $ruta = "panel-maestros.php";
                $perfil = "perfilm.php";

                //Declaramos el array que contendrá a los ID de sus grupos.
                $gruposMaestro = Array();

                //obtenemos los grupos correspondientes de cada maestro
                require_once "../modelos/grupo.php";
                $grupo = new Grupo();
                $res=$grupo->listarGrupos($user);
                while ($reg=$res->fetch_object()){
                    $gruposMaestro[] = array('id' => $reg -> ID_GRUPO,  'nombre' => $reg -> NOMBRE);
                }

                $_SESSION['grupos'] = $gruposMaestro;

                $alumnosExtra = Array();
                $res=$grupo->listarAlumnosExtra($user,"Extra");
                while ($reg=$res->fetch_object()){
                    $alumnosExtra[] = array('id' => $reg -> id,  'nombre' => $reg -> nombre);
                }

                $_SESSION['alumnosExtra'] = $alumnosExtra;
                
                $alumnosSegundoExtra = Array();
                $res=$grupo->listarAlumnosExtra($user,"Seg-Extra");
                while ($reg=$res->fetch_object()){
                    $alumnosSegundoExtra[] = array('id' => $reg -> id,  'nombre' => $reg -> nombre);
                }

                $_SESSION['alumnosSegundoExtra'] = $alumnosSegundoExtra;

                break;
        }
        if ($rspta) {
            $fetch = $rspta->fetch_object();
            if (isset($fetch)) {
                //Declaramos las variables de sesión
                $_SESSION['id'] = $user;
                $_SESSION['nombre'] = $fetch->nombre;
                $_SESSION['imagen'] = $fetch->foto;
                $_SESSION['permiso'] = $permiso;
                $_SESSION['ruta'] = $ruta;
                $_SESSION['sede'] = $fetch->sede;
                $_SESSION['perfil'] = $perfil;
                $fetch->ruta = $ruta;
            } else {
                echo  $permiso." ".$ruta;
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