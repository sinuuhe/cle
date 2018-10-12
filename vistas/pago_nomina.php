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
                <div class="box  ">
                    <div class="box-header  with-border">
                        <div class="pull-left">
                            <h3 class="box-title">Pago de nómina semana <span  class="label label-info" id="numero_semana"></span> </h3>
                        <p id="semana" class="text-info">Del día <span class="label label-info" id="semana_inicio"></span> al <span class="label label-info" id="semana_fin"></span></p>
                        </div>
                        
                        <div class=" pull-right">
                            <button type="button" class="btn btn-success" id="btnverpagados" onclick="listar('ver_pagados')"> <i class="fa fa-check-square-o" aria-hidden="true"></i> Pagos</button>
                            <button type="button" class="btn btn-danger" id="btnvernopagados" onclick="listar('ver_nopagados')"> <i class="fa fa-times-circle" aria-hidden="true"></i> Adeudos</button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body " id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover nowrap" style="width:100%">
                            <thead>
                            <th>Matrícula</th>
                            <th>Maestro</th>
                            <th>Grupo(s)</th>
                            <th>Horas Tra.</th>
                            <th>Monto Pago</th>
                            <th>Opciones</th>
                            </thead>
                            <tbody>                            
                            </tbody>
                            <tfoot>
                            <th>Matrícula</th>
                            <th>Maestro</th>
                            <th>Grupo(s)</th>
                            <th>Horas Tra.</th>
                            <th>Monto Pago</th>
                            <th>Opciones</th>
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
<script type="text/javascript" src="scripts/pago_nomina.js"></script>


