<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])){
  header("Location: login.php");
}
else{
require 'header.php';

function compGrupo(){
  $verficar = FALSE;
   foreach ($_SESSION['grupos'] as $valor) {
    if($valor['id'] === $_GET["g"]){  
      $verficar = TRUE;
    }
  }
  return $verficar;
}

if ($_SESSION['permiso']==3 && compGrupo()){
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
            <h1 class="box-title">Asistencia</h1>
            <div class="box-tools pull-right">
            </div>
          </div>
          <!-- /.box-header -->
          <!-- centro -->
          <div class="panel-body" id="formularioregistros">

            <div class="form-group col-lg-6 col-lg-offset-3  col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
              <label>Fecha:</label>
              <input data-provider = "datepicker" type="text" class="form-control" name="fechaAsistencia" id="fechaAsistencia" maxlength="50" onchange = "checarFecha();" placeholder="Fecha de asistencia" required>
            </div>
            
            <div hidden id="tbllistadoWrapper">
              <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                  <th>Alumno</th>
                </thead>
                <tbody>                            
                </tbody>
                </table>
                <button class="btn btn-warning" onclick="agregarClase()" type="button"><i class="fa fa-plus-square"></i> Agregar hora</button>
                <button class="btn btn-success" onclick="nuevaAsistencia()" type="button"><i class="fa fa-save"></i> Guardar</button>
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
<script type="text/javascript" src="scripts/asistencia.js"></script>
<?php
}else{
  require 'noacceso.php';
  require 'footer.php';
}
}
ob_end_flush();



