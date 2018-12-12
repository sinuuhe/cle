<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])){
  header("Location: login.php");
}
else{
require 'header.php';

if ($_SESSION['permiso']==3){
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
            <h1 class="box-title" id = "tituloPagina">Subir calificaciones extra</h1>
            <div class="box-tools pull-right">
            </div>
          </div>
          <!-- /.box-header -->
          <!-- centro -->
          <div class="panel-body" id="formularioregistros">
            <div id="tbllistadoWrapper">
              <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                  <th>Nombre</th>
                  <th>Calificación</th>
                </thead>
                <tbody>                            
                </tbody>
                </table>
                <button class="btn btn-success" id="subirCalificaciones" onclick = "subirCalificaciones();" type="button"><i class="fa fa-save"></i> Guardar</button>
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
<script type="text/javascript" src="scripts/extra.js"></script>
<?php
}else{
  require 'noacceso.php';
  require 'footer.php';
}
}
ob_end_flush();
?>