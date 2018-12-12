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
                            <li><a href="personal.php">Personal</a></li>
                            <li><a href="grupo.php">Grupos</a></li>
                            <li><a href="nivel.php">Niveles</a></li>
                            <li><a href="convenio.php">Convenios</a></li>
                            <li><a href="libro.php">Libros</a></li>
                          </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-link"></i> <span>Financieros</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <li class="treeview">
                            <a href="#"><i class="fa fa-link"></i> <span>Maestros</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">';
                            require_once dirname(__DIR__, 1) . "/modelos/grupo.php";
                            $grupo = new Grupo();
                            $rspta=$grupo->listarTotalGrupos(); 
                            while ($reg = $rspta -> fetch_object()){
                                echo $grupos . '<li><a href="lista.php?g='.$reg -> idGrupo.'&maestro='.$reg -> nombreMaestro.'&nivel='.$reg -> nivel.'">'.$reg -> idGrupo.' '.$reg -> nivel.'</a></li>';
                            }
                            echo '</ul>
                        </li>
        ';
        break;

    case 2://alumno
        echo '
                        <li class="header">ALUMNO</li>
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
 
    $listas = "";
    $asistencias = "";
    $calificaciones = "";

    foreach ($_SESSION['grupos'] as $valor) {
        $asistencias = $asistencias.'<li><a href="asistencia.php?g='.$valor['id'].'">'.$valor['id'].' '.$valor['nombre'].'</a></li>';
        $listas = $listas . '<li><a href="lista.php?g='.$valor['id'].'">'.$valor['id'].' '.$valor['nombre'].'</a></li>';
        $calificaciones = $calificaciones . '<li><a href="calificaciones.php?g='.$valor['id'].'">'.$valor['id'].' '.$valor['nombre'].'</a></li>';
    }
        echo '
        <li class="header">MAESTROS</li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-link"></i> 
                <span>Mis Grupos</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu" id = "misGrupos">
                '.$asistencias.'
            </ul>
        </li>
        <li class="treeview">
            <a href="#" >
                <i class="fa fa-link"></i> 
                <span>Total Asistencias</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu" id = "misAsistencias">
                '.$listas.'
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-link"></i> 
                <span>Calificaciones</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu" id = "misCalificaciones">
                '.$calificaciones.'
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-link"></i> 
                <span>Extras</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu" id = "extras">
                <li><a href = "extra.php">Alumnos Extra</a></li>
                <li><a href = "segundoExtra.php">Alumnos Seg. Extra</a></li>
            </ul>
        </li>';
        
         
         
        break;

    case 4://PERSONAL
    echo '
                        <li class="header"><a href = "panel-personal.php">RECEPCIÓN</a></li>
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
                            <li><a href="grupo.php">Grupos</a></li>
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
                                <li><a href="pago_inscripcion.php">Pago de inscripción</a></li>
                                <li><a href="pago_curso.php">Pago de curso</a></li>
                                <li><a href="pago_libro.php">Pago de libro</a></li>
                            </ul>
                        </li>
        ';
        break;
}
echo "
         <script>
            /** add active class and stay opened when selected */
            var url = window.location;

            // for sidebar menu entirely but not cover treeview
            $('ul.sidebar-menu a').filter(function() {
               return this.href == url;
            }).parent().addClass('active');

            // for treeview
            $('ul.treeview-menu a').filter(function() {
               return this.href == url;
            }).parentsUntil('.sidebar-menu > .treeview-menu').addClass('active');
        </script>";
?>