<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require 'header.php';
?>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">        
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Categoría <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover text-center" style="width:100%">
                            <thead>
                            <th>Opciones</th>
                            <th>Matrícula</th>
                            <th>Alumno</th>
                            <th>Grupo</th>
                            <th>Nivel</th>
                            <th>Precio</th>
                            <th>Forma Pago</th>
                            <th>Estatus</th>
                            </thead>
                            <tbody>                            
                            </tbody>
                            <tfoot>
                            <th>Opciones</th>
                            <th>Matrícula</th>
                            <th>Alumno</th>
                            <th>Grupo</th>
                            <th>Nivel</th>
                            <th>Precio</th>
                            <th>Forma Pago</th>
                            <th>Estatus</th>
                            </tfoot>
                        </table>
                    </div>
                    <!--Fin centro -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->
<?php
require 'footer.php';
?>
<script type="text/javascript" src="scripts/pago_extras.js"></script>


