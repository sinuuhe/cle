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
            <h1 class="box-title">Calificaciones grupo <b><?php echo $_GET["g"] ?></b></h1>
            <div class="box-tools pull-right">
            </div>
          </div>
          <!-- /.box-header -->
          <!-- centro -->
          <div class="panel-body" id="formularioregistros">
            <div id="tbllistadoWrapper">
              <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                  <th>Alumno</th>
                  <th>C. Oral</th>
                  <th>C. Escrita</th>
                  <th>C. Participación</th>
                  <th>Promedio</th>
                </thead>
                <tbody>                            
                </tbody>
                </table>
                <label for="observaciones">Observaciones generales del grupo:</label>
                <input type="text" id = "observaciones" name = "observaciones" placeholder = "Observaciones">
                <button class="btn btn-success" onclick = "subirCalificaciones();" type="button"><i class="fa fa-save"></i> Guardar</button>
            </div>
            <h4>Estamos realizando los ultimos ajustas para hacer la actualización esta noche para las calificaciones normales y de extras.</h4>
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
<script type="text/javascript" src="scripts/calificaciones.js"></script>
<?php
}else{
  require 'noacceso.php';
  require 'footer.php';
}
}
ob_end_flush();
?>