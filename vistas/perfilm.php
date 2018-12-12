<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
//else
{
require 'header.php';

if ($_SESSION['permiso']==1 || $_SESSION['permiso']==3)
{

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
                          <h1 class="box-title">Editar</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <img src="" alt="" id = "vistaFoto" name = "vistaFoto"  class = "text-center img-responsive">
                          </div>
                          <div id = "fotoDiv"class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Foto:</label>
                            <input type="file" class="form-control" data-rutaFoto = "" name="foto" id="foto" maxlength="50" placeholder="Foto">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Contraseña:</label>
                            <input type="text" hidden name = 'id' id='id'>
                            <input type="text" class="form-control" name="password" id="password" maxlength="50" placeholder="Contraseña" required>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            <p>*Nota: La imagen puede tardar unos minutos en actualizar.</p>
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
  //require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/perfilm.js"></script>
<?php 
}
ob_end_flush();
?>


