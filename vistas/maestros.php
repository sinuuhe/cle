<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["nombre"])) {
    header("Location: login.php");
    exit();
}
require 'header.php';
if ($_SESSION['permiso'] == 1 || $_SESSION['permiso'] == 4) {
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
                          <h1 class="box-title">Maestros <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                          <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Teléfono</th>
                            <th>Status</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                          <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Teléfono</th>
                            <th>Status</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="" alt="" id = "vistaFoto" name = "vistaFoto"  class = "rounded">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre:</label>
                            <input type="hidden" name="id" id="id">
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="50" placeholder="Nombre" required>
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Apellido Paterno:</label>
                            <input type="text" class="form-control" name="apellidoP" id="apellidoP" maxlength="50" placeholder="Apellido Materno" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Apellido Materno:</label>
                            <input type="text" class="form-control" name="apellidoM" id="apellidoM" maxlength="50" placeholder="Apellido Materno" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Teléfono:</label>
                            <input type="text" class="form-control" name="telefono" id="telefono" maxlength="50" placeholder="Teléfono" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Celular:</label>
                            <input type="text" class="form-control" name="celular" id="celular" maxlength="50" placeholder="Celular" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Correo electrónico:</label>
                            <input type="text" class="form-control" name="email" id="email" maxlength="50" placeholder="Correo electrónico" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha de nacimiento:</label>
                            <input data-provider = "datepicker" type="text" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" maxlength="50" placeholder="Fecha nacimiento" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Fecha de ingreso:</label>
                            <input data-provider = "datepicker" type="text" class="form-control" name="fecha_ingreso" id="fecha_ingreso" maxlength="50" placeholder="Fecha ingreso" required>
                          </div>
                          <div id = "fotoDiv"class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Foto:</label>
                            <input type="file" class="form-control" data-rutaFoto = "" name="foto" id="foto" maxlength="50" placeholder="Foto">
                          </div>
                          
                          <div id = "idDiv"class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Id:</label>
                            <input disabled type="text" class="form-control"   id="id_usuario" maxlength="50">
                          </div>
                          
                          <div id = "passDiv"class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Contraseña:</label>
                            <input disabled type="text" class="form-control"   id="pass" maxlength="50">
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
} else {
    require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/maestro.js"></script>

<?php
ob_end_flush();

