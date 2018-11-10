<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

switch ($_SESSION['permiso']) {
    case 1://admin
        echo '
                        <li class="header">ADMINISTRADOR</li>
                        <!-- Optionally, you can add icons to the links -->
                        <li class="treeview">
                            <a href="#"><i class="fa fa-link"></i> <span>Académicos</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="Alumnos.php">Alumnos</a></li>
                                <li><a href="maestros.php">Maestros</a></li>
                                <li><a href="grupos.php">Grupos</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-link"></i> <span>Financieros</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pago_extras.php">Pago de extra</a></li>
                                <li><a href="pago_nomina.php">Pago de nómina</a></li>
                                <li><a href="pago_inscripcion.php">Pago de inscripción</a></li>
                                <li><a href="pago_curso.php">Pago de curso</a></li>
                                <li><a href="pago_libro.php">Pago de libro</a></li>
                            </ul>
                        </li>
        ';
        break;

    case 2://alumno
        echo '
                        <li class="header">ADMINISTRADOR</li>
                        <!-- Optionally, you can add icons to the links -->
                        <li class="treeview">
                            <a href="#"><i class="fa fa-link"></i> <span>Académicos</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="Alumnos.php">Alumnos</a></li>
                                <li><a href="maestros.php">Maestros</a></li>
                                <li><a href="grupos.php">Grupos</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-link"></i> <span>Financieros</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pago_extras.php">Pago de extra</a></li>
                                <li><a href="pago_nomina.php">Pago de nómina</a></li>
                                <li><a href="pago_inscripcion.php">Pago de inscripción</a></li>
                                <li><a href="pago_curso.php">Pago de curso</a></li>
                                <li><a href="pago_libro.php">Pago de libro</a></li>
                            </ul>
                        </li>
        ';
        break;

    case 3://Maestros

        break;

    case 4://PERSONAL
        break;
}
?>