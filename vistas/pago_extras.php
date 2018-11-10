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
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header  with-border">
                            <h3 class="box-title">Pago de extras</h3>
                            <div class="box-tools pull-right">
                                <ul class="nav nav-pills ">
                                    <li role="presentation" class="active">
                                        <a id="btnverpagados" data-tipo="ver_pagados"  data-toggle="tab" href="#pagos">
                                            <i class="fa fa-check-square-o" aria-hidden="true"></i> Pagos
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a id="btnvernopagados" data-tipo="ver_nopagados" data-toggle="tab"  href="#adeudos">
                                            <i class="fa fa-times-circle" aria-hidden="true"></i> Adeudos
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <!-- centro -->
                        <div class="panel-body tab-content" id="listadoregistros">
                            <div id="pagos" class="tab-pane fade in active">
                                <table id="tb-pagos" class="table table-striped table-bordered table-condensed table-hover nowrap" style="width:100%">
                                    <thead>
                                    <th>Matrícula</th>
                                    <th>Alumno</th>
                                    <th>Grupo</th>
                                    <th>Nivel</th>
                                    <th>Precio</th>
                                    <th>Fecha Pago</th>
                                    <th>Opciones</th>
                                    </thead>
                                    <tbody>                            
                                    </tbody>
                                    <tfoot>
                                    <th>Matrícula</th>
                                    <th>Alumno</th>
                                    <th>Grupo</th>
                                    <th>Nivel</th>
                                    <th>Precio</th>
                                    <th>Fecha Pago</th>
                                    <th>Opciones</th>
                                    </tfoot>
                                </table>
                            </div>
                            <div id="adeudos" class="tab-pane fade">
                                <table id="tb-adeudos" class="table table-striped table-bordered table-condensed table-hover nowrap" style="width:100%">
                                    <thead>
                                    <th>Matrícula</th>
                                    <th>Alumno</th>
                                    <th>Grupo</th>
                                    <th>Nivel</th>
                                    <th>Precio</th>
                                    <th>Opciones</th>
                                    </thead>
                                    <tbody>                            
                                    </tbody>
                                    <tfoot>
                                    <th>Matrícula</th>
                                    <th>Alumno</th>
                                    <th>Grupo</th>
                                    <th>Nivel</th>
                                    <th>Precio</th>
                                    <th>Opciones</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!--Fin centro -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    <?php
} else {
    require 'noacceso.php';
}
require 'dialogos.php';
    get_dialogs("extras");
require 'footer.php';
?>
<script type="text/javascript" src="scripts/pago_extras.js"></script>

<?php
ob_end_flush();
