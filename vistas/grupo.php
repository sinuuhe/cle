<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.php");
  exit();
}
else
{
require 'header.php';

if ($_SESSION['permiso']==1 || $_SESSION['permiso']==4)
{
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
                            <th>Días</th>
                            <th>H. Entrada</th>
                            <th>H. Salida</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                          <th>Opciones</th>  
                            <th>Grupo</th>
                            <th>Maestro</th>
                            <th>Días</th>
                            <th>H. Entrada</th>
                            <th>H. Salida</th>
                          </tfoot>
                        </table>
                        </div>
                        <div class="panel-body table-responsive" id="listadoAlumnos">
                        <table id="tbllistadoAlumnos" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Nombre</th>
                            <th>Opciones</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot> 
                          <th>Nombre</th>
                          <th>Opciones</th>
                          </tfoot>
                        </table>
                        <button class="btn btn-danger" onclick="cancelarAlumnos()" type="button"><i class="fa fa-arrow-circle-left"></i>Volver</button>
                        <h3>Agregar alumnos al grupo</h3>
                        <div class="form-group">
                                <label for="alumno" class="col-sm-2 control-label">Alumno</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <select onchange = 'agregarAlumno()' required name="alumno" title="Selecciona un alumno..."  data-style="btn btn-primary btn-round" id="alumno" data-live-search="true" class="selectpicker ">

                                        </select>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <label>Nivel:</label>
                                <select required name="nivel" title="Selecciona un nivel..."  data-style="btn btn-primary btn-round" id="nivel" data-live-search="true" class="selectpicker "></select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <label>Maestro:</label>
                                <select required name="idMaestro" title="Selecciona un maestro..."  data-style="btn btn-primary btn-round" id="idMaestro" data-live-search="true" class="selectpicker "></select>
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
                            <input type="hidden" name="id" id="id">
                            <input type="text" class="form-control" name="dias" id="dias" maxlength="50" placeholder="Días de la semana" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Horario entrada:</label>
                            <input type="time"   class="form-control" name="horario_entrada" id="horario_entrada" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Horario salida:</label>
                            <input type="time" class="form-control" name="horario_salida" id="horario_salida" maxlength="50" placeholder="Horario salida" required>
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
                            <input type="text" class="form-control" name="salon" id="salon" maxlength="50" placeholder="Salon" required>
                          </div><div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Observaciones:</label>
                            <input type="text" class="form-control" name="observaciones" id="observaciones" maxlength="50" placeholder="Observaciones">
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
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/grupo.js"></script>
<?php 
}
ob_end_flush();
?>


