<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
$data = Array();
switch ($_SESSION['permiso']) {
    case 1://Admin
        $data = array('permiso' => 'admin');
        break;

    case 2://Alumnos
        $data= array('permiso' => 'alumno');
        break;

    case 3://Maestros
        $data = array('permiso' => 'maestro');
        break;
    case 4://Personal
        $data = array('permiso' => 'personal');
        break;
}
echo json_encode($data);
?>