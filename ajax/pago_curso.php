<?php 

require_once dirname(__DIR__,1). "/modelos/PagoCurso.php";

$pago_curso=new PagoCurso();

$idpagocurso=isset($_POST["idpago"])? limpiarCadena($_POST["idpago"]):"";
$pago=isset($_GET["pago"])? limpiarCadena($_GET["pago"]):"";
$forma_pago=isset($_POST["forma_pago"])? limpiarCadena($_POST["forma_pago"]):"";

switch ($_GET["op"]){
	case 'cancelar_pago':
		$rspta=$pago_curso->cancelar_pago($idpagocurso);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
	break;

	case 'pagar':
		$rspta=$pago_curso->pagar($idpagocurso,date("Y-m-d H:i:s"),$forma_pago);
 		echo $rspta ?  json_encode(array('verificar' => 'success', 'mensaje' => 'Pago realizado con éxito.')) :
                               json_encode(array('verificar' => 'error',   'mensaje' => $conexion->error));
	break;

	case 'listar_pago':
		$rspta=$pago_curso->listar_pago($idpagocurso);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
        case 'listar':
            $rspta=$pago_curso->listar_pagos($pago=='ver_pagados');
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetch_object()){
                    $descuentos=$pago_curso->obtener_descuento($reg->COSTO, $reg->beca);
                    $semanasDeRetraso=$pago_curso->semanas_retraso($reg->FECHA_INICIO);
                    $totalRetraso=$pago_curso->obtener_retraso($semanasDeRetraso);
                    $totalAPagar=$pago_curso->obtener_total($reg->COSTO, $totalRetraso, $descuentos); 
                    $bandera=$pago_curso->actualizar_pago($reg->ID_PAGO, $semanasDeRetraso, $totalRetraso, $reg->COSTO, $totalAPagar, $descuentos);
                    if(!$bandera){
                        die($conexion->error);
                    }
                    if($pago != 'ver_pagados'){
                        $data[]=array(
                            "0"=>$reg->matricula,
                            "1"=>$reg->nombre,
                            "2"=>$reg->nivel,
                            "3"=>$reg->COSTO,
                            "4"=>$totalRetraso,
                            "5"=>$descuentos,
                            "6"=>$totalAPagar,
                            "7"=>$semanasDeRetraso,
                            "8"=>'<button data-id="'.$reg->ID_PAGO.'" class="btn btn-danger btn-block"><i class="fa fa-money"></i>  Pagar</button>');
                    }else{
                        $data[]=array(
                            "0"=>$reg->matricula,
                            "1"=>$reg->nombre,
                            "2"=>$reg->nivel,
                            "3"=>$reg->COSTO,
                            "4"=>$totalRetraso,
                            "5"=>$descuentos,
                            "6"=>$totalAPagar,
                            "7"=>$semanasDeRetraso,
                            "8"=>$reg->FECHA_PAGO,
                            "9"=>'<form target="_blank" action="../impresiones/tickets/ticketPDF.php" method="POST">
                                        <input name="idpago" value="'.$reg->ID_PAGO.'" type="hidden" class="idpago">
                                        <input type="hidden" id="concepto" name="concepto" value="Pago de inscripción" />
                                        <input type="hidden" id="formato" name="formato" value="pago_inscripcion"/>
                                        <button type="submit" class="btn btn-success btn-block"><i class="fa fa-eye"></i> Ver recibo</button>
                                    </form>
                               ');    
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

