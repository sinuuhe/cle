<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["nombre"])) {
    header("Location: login.php");
    exit();
}
require 'header.php';
if ($_SESSION['permiso'] == 3) {
    ?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">        
        <!-- Main content -->
        <div class="col-md-12 text-center">
            <!-- USERS LIST --><br>
            <h1>¡EN CONSTRUCCIÓN!</h1>
            <p>Puedes cambiar tu contraseña haciendo clic sobre tu nombre en la esquina superior derecha.</p>
        </div>
        <!-- /.col -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    <?php
} else {
    require 'noacceso.php';
}

require 'footer.php';
?>
<!-- <script type="text/javascript" src="scripts/panelMaestros.js"></script>  -->
<?php
ob_end_flush();


