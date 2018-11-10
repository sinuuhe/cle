<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$concepto = "";
$formato = "";

function get_dialogs($tipo) {
    switch ($tipo) {
        case "cursos":
            $concepto = "Pago de curso";
            $formato = "pago_curso";
            break;
        case "extras";
            $concepto = "Pago de extra";
            $formato = "pago_extra";
            break;
        
        case "inscripcion":
            $concepto = "Pago de inscripción";
            $formato = "pago_inscripcion";
            break;
        
        case "libros":
            $concepto = "Pago de libro";
            $formato = "pago_libro";
            break;
        case "nominas":
            $concepto = "Pago de Nominas";
            $formato = "pago_nomina";
            brak;
    }
    ?>
    <!-- thediv to be viewed as dialog ver_recibo-->
    <div id="ver_recibo">
        <form target="_blank" action="../impresiones/tickets/ticketPDF.php" method="POST">
            <input name="idpago" type="hidden" class="idpago">
            <input type="hidden" id="concepto" name="concepto" value="<?php echo $concepto; ?>" />
            <input type="hidden" id="formato" name="formato" value="<?php echo $formato; ?>"/>
            <button type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-eye"></i> Ver recibo</button>
        </form>
    </div>
    <?php 
    if($tipo==="libros"){
    ?>
            <form id="form-pagar">
                <div class="form-horizontal">
                    <div class="form-group ">
                        <label for="alertify-libro" class="col-sm-3 control-label">Libro</label>
                        <div class="col-sm-9 ">
                            <input id="flibro" disabled type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alertify-comprador" class="col-sm-3 control-label">Comprador</label>
                        <div class="col-sm-9">
                            <input id="fcomprador" disabled type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alertify-forma-pago" class="col-sm-3 control-label">Forma Pago</label>
                        <div class="col-sm-9">
                            <input id="fforma_pago" disabled type="text" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alertify-monto-pago" class="col-sm-3 control-label">Total a pagar</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon">$</div>
                                <input id="fmonto-pago" disabled type="text" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-8 col-sm-12">
                            <button type="button"  class="btn btn-warning" id="btn-salir">Salir!</button>
                            <button id="btn-pago" type="submit" class="btn btn-primary"><i class="fa fa-money "></i> Pagar</button>
                        </div>
                    </div>
                </div>
            </form>
    <?php
    }else{
    ?>
    <!-- the form to be viewed as dialog pagar-->
    <form  id="form-pagar">
        <div class="form-horizontal">
            <div class="form-group">
                <label for="nombre" class="col-sm-3 control-label">Alumno</label>
                <div class="col-sm-9">
                    <input id="nombre" disabled type="text" class="form-control" >
                </div>
            </div>
            <div class="form-group">
                <label for="matricula" class="col-sm-3 control-label">Matrícula</label>
                <div class="col-sm-9">
                    <input id="matricula" disabled type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="total" class="col-sm-3 control-label">Total a pagar</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <div class="input-group-addon">$</div>
                        <input id="total" disabled type="text" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="forma_pago"  class="col-sm-3 control-label">Forma de pago</label>
                <div class="col-sm-9">
                    <select id="forma_pago" name="forma_pago" class="form-control">
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta Bancaria">Tarjeta Bancaria</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Transferencia">Transferencia</option>
                    </select>
                </div>
            </div>
            <input name="idpago" type="hidden" class="idpago">
            <div class="form-group">
                <div class="col-sm-offset-8 col-sm-12">
                    <button type="button"  class="btn btn-warning" id="btn-salir">Salir!</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-money "></i> Pagar</button>
                </div>
            </div>
        </div>
    </form>
    <?php
    }
}
