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
                          <h1 class="box-title">Niveles <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                            <th>Curso</th>
                            <th>Costo</th>
                            <th>Inscripción</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                          <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Curso</th>
                            <th>Costo</th>
                            <th>Inscripción</th>
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
                            <label>Curso:</label>
                            <input type="text" class="form-control" name="curso" id="curso" maxlength="50" placeholder="Curso" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Duración:</label>
                            <input type="number" class="form-control" name="duracion" id="duracion" maxlength="50" placeholder="Duracion" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Material:</label>
                            <input type="text" class="form-control" name="material_libro" id="material_libro" maxlength="50" placeholder="Material" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Costo:</label>
                            <input type="text" class="form-control" name="costo" id="costo" maxlength="50" placeholder="Costo" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Inscripción:</label>
                            <input type="text" class="form-control" name="inscripcion" id="inscripcion" maxlength="6" placeholder="Inscripcion" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Documento:</label>
                            <input type="text" class="form-control" name="documento" id="documento" maxlength="50" placeholder="Documento" required>
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
<script type="text/javascript" src="scripts/nivel.js"></script>
<?php 
//}
//ob_end_flush();
?>


