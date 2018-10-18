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
                        <h3 class="box-title">Pago de libro</h3>
                        <div class="box-tools pull-right">
                            <ul class="nav nav-pills ">
                                <li role="presentation" class="active"><a data-toggle="tab" href="#pagar_libros">Vender Libros</a></li>
                                <li role="presentation"><a data-toggle="tab"  href="#tabla_libros">Libros Pagados</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body  tab-content" >
                        <form class="form-horizontal tab-pane fade in active" id="pagar_libros">
                            <div class="form-group">
                                <label for="libro" class="col-sm-2 control-label">Libro</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                                        <select required name="libro" data-style="btn btn-primary btn-round" title="Selecciona un libro..." id="libro" class="selectpicker " data-live-search="true">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alumno" class="col-sm-2 control-label">Alumno</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <select required name="alumno" title="Selecciona un alumno..."  data-style="btn btn-primary btn-round" id="alumno" data-live-search="true" class="selectpicker ">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="forma_pago" class="col-sm-2 control-label">Forma de pago</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                        <select required title="Selecciona forma de pago..."  data-style="btn btn-primary btn-round" id="forma_pago" name="forma_pago" data-live-search="true" class="selectpicker ">
                                            <option>Efectivo</option>
                                            <option>Tarjeta Bancaria</option>
                                            <option>Cheque</option>
                                            <option>Transferencia</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit"  class="btn btn-bitbucket btn-large "><i class="fa fa-check-square-o" aria-hidden="true"></i> Pagar</button>
                                </div>
                            </div>
                        </form>
                        <div class="tab-pane fade" id="tabla_libros">
                            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover nowrap" style="width:100%">
                                <thead>
                                <th>Libro</th>
                                <th>Comprador</th>
                                <th>Fecha Pago</th>
                                <th>Forma Pago</th>
                                <th>Total</th>
                                <th>Opciones</th>
                                </thead>
                                <tbody>                            
                                </tbody>
                                <tfoot>
                                <th>Libro</th>
                                <th>Comprador</th>
                                <th>Fecha Pago</th>
                                <th>Forma Pago</th>
                                <th>Total</th>
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
require 'footer.php';
?>
<script type="text/javascript" src="scripts/pago_libro.js"></script>


