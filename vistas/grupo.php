<?php
//Activamos el almacenamiento en el buffer
//ob_start();
//session_start();

//if (!isset($_SESSION["nombre"]))
//{
//  header("Location: login.html");
//}
//else
//{
require 'header.php';

//if ($_SESSION['almacen']==1)
//{
//
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
                          <h1 class="box-title">Grupos <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Grupo</th>
                            <th>Maestro</th>
                            <th>Horario</th>
                            <th>Días</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Grupo</th>
                            <th>Maestro</th>
                            <th>Horario</th>
                            <th>Días</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <select required name="nivel" title="Selecciona un nivel..."  data-style="btn btn-primary btn-round" id="nivel" data-live-search="true" class="selectpicker "></select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <select required name="maestro" title="Selecciona un maestro..."  data-style="btn btn-primary btn-round" id="maestro" data-live-search="true" class="selectpicker "></select>
                          </div>                          
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Días:</label>
                            <select required name="numDias" title="Selecciona un día..."  data-style="btn btn-primary btn-round" id="numDias" data-live-search="true" class="selectpicker ">
                                <option value="1">1 Día a la semana</option>
                                <option value="3">3 Días a la semana</option>
                                <option value="5">5 Días a la semana</option>
                            </select>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Días de la semana:</label>
                            <input type="text" class="form-control" name="diasDeLaSemana" id="diasDeLaSemanalidoP" maxlength="50" placeholder="Días de la semana" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Horario entrada:</label>
                            <input type="text" class="form-control" name="horario_entrada" id="horario_entrada" maxlength="50" placeholder="Horario entrada" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Horario salida:</label>
                            <input type="text" class="form-control" name="horario_salida" id="horario_salida" maxlength="50" placeholder="Horario salida" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha inicio:</label>
                            <input data-provider = "datepicker" type="text" class="form-control" name="fecha_inicio" id="fecha_inicio" maxlength="50" placeholder="Fecha Inicio" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha fin:</label>
                            <input data-provider = "datepicker" type="text" class="form-control" name="fecha_fin" id="fecha_fin" maxlength="50" placeholder="Fecha Fin" required>
                          </div>
                          <!--Sede debe ser la de la sesion-->
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Salón:</label>
                            <select class="form-control" name="salon" id="salon"></select>
                          </div><div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Observaciones:</label>
                            <input type="text" class="form-control" name="observaciones" id="observaciones" maxlength="50" placeholder="Observaciones" required>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
//}
//else
//{
  //require 'noacceso.php';
//}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/grupo.js"></script>
<?php 
//}
//ob_end_flush();
?>


