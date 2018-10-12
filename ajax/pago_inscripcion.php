<?php 

require_once dirname(__DIR__,1). "/modelos/PagoInscripcion.php";

$pago_inscripcion=new PagoInscripcion();

$idpagoinscripcion=isset($_POST["idpagoinscripcion"])? limpiarCadena($_POST["idpagoinscripcion"]):"";
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
 				"0"=>'<span data-var="matricula" class="idpago-'.$reg->id.'">'.$reg->matricula.'</span>',
 				"1"=>'<span data-var="nombre" class="idpago-'.$reg->id.'">'.$reg->nombre.'</span>',
                                /*"2"=>($reg->status)?'<span class="label bg-green">Pagado</span>':
 				'<span class="label bg-red">Adeudo</span>',*/
                                "2"=>'$ <span data-var="monto_pago"  class="idpago-'.$reg->id.'">'.$reg->monto_pago.'</span>',
                                "3"=>'<span data-var="descuento"  class="idpago-'.$reg->id.'">'.$reg->descuento.' %</span>',
                                "4"=>'$ <span data-var="total_pago"  class="idpago-'.$reg->id.'">'.$reg->total_pago.'</span>',
                                "5"=>(!$reg->status)?'<button class="btn btn-danger" onclick="pagar('.$reg->id.')"><i class="fa fa-money"></i>  Pagar</button>':
 					'<button class="btn btn-success" onclick="ver_recibo('.$reg->id.')"><i class="fa fa-eye"></i> Recibo</button>');
                    }else{
                        $data[]=array(
 				"0"=>'<span data-var="matricula" class="idpago-'.$reg->id.'">'.$reg->matricula.'</span>',
 				"1"=>'<span data-var="nombre" class="idpago-'.$reg->id.'">'.$reg->nombre.'</span>',
                                /*"2"=>($reg->status)?'<span class="label bg-green">Pagado</span>':
 				'<span class="label bg-red">Adeudo</span>',*/
                                "2"=>'$ <span data-var="monto_pago"  class="idpago-'.$reg->id.'">'.$reg->monto_pago.'</span>',
                                "3"=>'<span data-var="descuento"  class="idpago-'.$reg->id.'">'.$reg->descuento.' %</span>',
                                "4"=>'$ <span data-var="total_pago"  class="idpago-'.$reg->id.'">'.$reg->total_pago.'</span>',
                                "5" => '<span data-var="fecha_pago"  class="idpago-' . $reg->id . '">' . $reg->fecha_pago . '</span>',
                                "6"=>(!$reg->status)?'<button class="btn btn-danger" onclick="pagar('.$reg->id.')"><i class="fa fa-money"></i>  Pagar</button>':
 					'<button class="btn btn-success" onclick="ver_recibo('.$reg->id.')"><i class="fa fa-eye"></i> Recibo</button>',
 				);
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