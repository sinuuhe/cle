<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["nombre"])) {
    header("Location: login.php");
    exit();
}
require 'header.php';
if ($_SESSION['permiso'] == 1) {
    ?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">        
        <!-- Main content -->
        <div class="col-md-12">
        <h2>Cambios realizados:</h2>
        <h3>
            <ul>
                <li>Ya se puede editar el celular de los alumnos</li>
            </ul>
        </h3>
        <h3>Notas: <br>
            Para realizar un cobro en pago extra, nómina, inscripción o curso, es necesario hacer clic en el botón "Adeudos", que se encuentra en la esquina superior derecha.
        </h3>
        
            <!-- USERS LIST --><br>
            <!--
            <div class="box box-primary">
                
                <div class="box-header with-border">
                    <h3 class="box-title">Últimos estudiantes</h3>
                    <div class="box-tools pull-right">
                        <span class="label label-danger">8 nuevos estudiantes</span>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
      
                <!-- /.box-header -->
                <!--
                <div class="box-body no-padding">
                    <ul class="users-list clearfix">
                        <li>
                            <img src="dist/img/user1-128x128.jpg" alt="User Image">
                            <a class="users-list-name" href="#">Alexander Pierce</a>
                            <span class="users-list-date">Today</span>
                        </li>
                        <li>
                            <img src="dist/img/user8-128x128.jpg" alt="User Image">
                            <a class="users-list-name" href="#">Norman</a>
                            <span class="users-list-date">Yesterday</span>
                        </li>
                        <li>
                            <img src="dist/img/user7-128x128.jpg" alt="User Image">
                            <a class="users-list-name" href="#">Jane</a>
                            <span class="users-list-date">12 Jan</span>
                        </li>
                        <li>
                            <img src="dist/img/user6-128x128.jpg" alt="User Image">
                            <a class="users-list-name" href="#">John</a>
                            <span class="users-list-date">12 Jan</span>
                        </li>
                        <li>
                            <img src="dist/img/user2-160x160.jpg" alt="User Image">
                            <a class="users-list-name" href="#">Alexander</a>
                            <span class="users-list-date">13 Jan</span>
                        </li>
                        <li>
                            <img src="dist/img/user5-128x128.jpg" alt="User Image">
                            <a class="users-list-name" href="#">Sarah</a>
                            <span class="users-list-date">14 Jan</span>
                        </li>
                        <li>
                            <img src="dist/img/user4-128x128.jpg" alt="User Image">
                            <a class="users-list-name" href="#">Nora</a>
                            <span class="users-list-date">15 Jan</span>
                        </li>
                        <li>
                            <img src="dist/img/user3-128x128.jpg" alt="User Image">
                            <a class="users-list-name" href="#">Nadia</a>
                            <span class="users-list-date">15 Jan</span>
                        </li>
                    </ul>
                    <!-- /.users-list -->
                    <!--
                </div>
                
                <!-- /.box-body -->
                <!--
                <div class="box-footer text-center">
                    <a href="javascript:void(0)" class="uppercase">View All Users</a>
                </div>
                <!-- /.box-footer -->
                <!--
            </div>
            -->
            <!--/.box -->
        </div>
        <!-- /.col -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    <?php
} else {
    require 'noacceso.php';
}

require 'footer.php';
?>

<?php
ob_end_flush();


