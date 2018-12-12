<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])){
  header("Location: login.php");
}else{

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
$user = $_SESSION['permiso'] == 3 ? compGrupo() : $_SESSION['permiso'] == 1;
if ($user){
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
            <h1 class="box-title">Listas</h1>
            <div class="box-tools pull-right">
            </div>
          </div>
          <!-- /.box-header -->
          <!-- centro -->
          <div class="panel-body" id="formularioregistros">
            <?php if($_SESSION['permiso'] == 1){ ?>
            <h4>Maestro: <i><?php echo $_GET['maestro'];?></i></h4>
            <h4>Grupo: <i><?php echo $_GET['nivel'];?></i></h4>
            <?php } ?>

            <div id="tbllistadoWrapper">
              <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                  <th>Alumno</th>
                </thead>
                <tbody>                            
                </tbody>
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
<script type="text/javascript" src="scripts/lista.js"></script>
<?php
}else{
  require 'noacceso.php';
  require 'footer.php';
}
}
ob_end_flush();

