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
                          <h1 class="box-title">Alumnos <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Status</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Status</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
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
                            <label>Calle:</label>
                            <input type="text" class="form-control" name="calle" id="calle" maxlength="50" placeholder="Calle" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Colonia:</label>
                            <input type="text" class="form-control" name="colonia" id="colonia" maxlength="50" placeholder="Colonia" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Número:</label>
                            <input type="text" class="form-control" name="numero" id="numero" maxlength="6" placeholder="Número" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Municipio:</label>
                            <input type="text" class="form-control" name="municipio" id="municipio" maxlength="50" placeholder="Municipio" required>
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
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Foto:</label>
                            <input type="file" class="form-control" name="foto" id="foto" maxlength="50" placeholder="Foto" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Empresa:</label>
                            <select class="form-control" name="empresa" id="empresa"></select>
                          </div><div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Beca:</label>
                            <input type="text" class="form-control" name="beca" id="beca" maxlength="50" placeholder="Beca" required>
                          </div><div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Password:</label>
                            <input type="text" class="form-control" name="password" id="password" maxlength="50" placeholder="Password" required>
                          </div><div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Sede:</label>
                            <input type="text" class="form-control" name="sede" id="sede" maxlength="50" placeholder="Sede" required>
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
<script type="text/javascript" src="scripts/Alumnos.js"></script>
<?php 
//}
//ob_end_flush();
?>


