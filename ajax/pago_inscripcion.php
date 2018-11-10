<?php 

require_once dirname(__DIR__,1). "/modelos/PagoInscripcion.php";

$pago_inscripcion=new PagoInscripcion();

$idpagoinscripcion=isset($_POST["idpago"])? limpiarCadena($_POST["idpago"]):"";
$pago=isset($_GET["pago"])? limpiarCadena($_GET["pago"]):"";
$forma_pago=isset($_POST["forma_pago"])? limpiarCadena($_POST["forma_pago"]):"";

switch ($_GET["op"]){
	case 'cancelar_pago':
		$rspta=$pago_inscripcion->cancelar_pago($idpagoinscripcion);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
	break;

	case 'pagar':
		$rspta=$pago_inscripcion->pagar($idpagoinscripcion,date("Y-m-d H:i:s"),$forma_pago);
 		echo $rspta ?  json_encode(array('verificar' => 'success', 'mensaje' => 'Pago realizado con éxito.')) :
                               json_encode(array('verificar' => 'error',   'mensaje' => 'Pago no realizado.'));
	break;

	case 'listar_pago':
		$rspta=$pago_inscripcion->listar_pago($idpagoinscripcion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
        case 'listar':
            $rspta=$pago_inscripcion->listar_pagos($pago=='ver_pagados');
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
                    if($pago != 'ver_pagados'){
                        $data[]=array(
 				"0"=>$reg->matricula,
 				"1"=>$reg->nombre,
                                "2"=>$reg->monto_pago,
                                "3"=>$reg->descuento,
                                "4"=>$reg->total_pago,
                                "5"=>'<button data-id="'.$reg->id.'" class="btn btn-danger btn-block"><i class="fa fa-money"></i>  Pagar</button>');
                    }else{
                        $data[]=array(
 				"0"=>$reg->matricula,
 				"1"=>$reg->nombre,
                                "2"=>$reg->monto_pago,
                                "3"=>$reg->descuento,
                                "4"=>$reg->total_pago,
                                "5" =>$reg->fecha_pago,
                                "6"=>'
                                    <div class="text-center">
                                    <form class="no-display-block" target="_blank" action="../impresiones/tickets/ticketPDF.php" method="POST">
                                        <input name="idpago" value="'.$reg->id.'" type="hidden" class="idpago">
                                        <input type="hidden" id="concepto" name="concepto" value="Pago de inscripción" />
                                        <input type="hidden" id="formato" name="formato" value="pago_inscripcion"/>
                                        <button type="submit" class="btn btn-success"> Ver recibo</button>
                                    </form>'
                                    . '<form class="no-display-block" target="_blank" action="../impresiones/tickets/inscripcionPDF.php" method="POST">
                                        <input name="idpago" value="'.$reg->id.'" type="hidden" class="idpago">
                                        <button type="submit" class="btn btn-info"> Acuse</button>
                                    </form>
                                    </div>');
                    }
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
            break;
}
?>