<?php 

require_once dirname(__DIR__,1). "/modelos/PagoCurso.php";

$pago_curso=new PagoCurso();

$idpagocurso=isset($_POST["idpagocurso"])? limpiarCadena($_POST["idpagocurso"]):"";
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
                    $pago_curso->actualizar_pago($reg->ID_PAGO, $semanasDeRetraso, $totalRetraso, $reg->COSTO, $totalAPagar, $descuentos);
                   if($pago != 'ver_pagados'){
                        $data[]=array(
                            "0"=>'<span data-var="matricula" class="idpago-'.$reg->ID_PAGO.'">'.$reg->matricula.'</span>',
                            "1"=>'<span data-var="nombre" class="idpago-'.$reg->ID_PAGO.'">'.$reg->nombre.'</span>',
                            "2"=>'<span data-var="grupo" class="idpago-'.$reg->ID_PAGO.'">'.$reg->nivel.'</span>',
                            "3"=>'<span data-var="costo" class="idpago-'.$reg->ID_PAGO.'">'.$reg->COSTO.'</span>',
                            "4"=>'<span data-var="cargo" class="idpago-'.$reg->ID_PAGO.'">'.$totalRetraso.'</span>',
                            "5"=>'<span data-var="descuento" class="idpago-'.$reg->ID_PAGO.'">'.$descuentos.'</span>',
                            "6"=>'<span data-var="monto_pago" class="idpago-'.$reg->ID_PAGO.'">'.$totalAPagar.'</span>',
                            "7"=>'<span data-var="semanas_retraso" class="idpago-'.$reg->ID_PAGO.'">'.$semanasDeRetraso.'</span>',
                            "8"=>(!$reg->status)?'<button class="btn btn-danger" onclick="pagar('.$reg->ID_PAGO.')"><i class="fa fa-money"></i>  Pagar</button>':
                                '<button class="btn btn-success" onclick="ver_recibo('.$reg->ID_PAGO.')"><i class="fa fa-eye"></i> Recibo</button>');   
                    }else{
                        $data[]=array(
                            "0"=>'<span data-var="matricula" class="idpago-'.$reg->ID_PAGO.'">'.$reg->matricula.'</span>',
                            "1"=>'<span data-var="nombre" class="idpago-'.$reg->ID_PAGO.'">'.$reg->nombre.'</span>',
                            "2"=>'<span data-var="grupo" class="idpago-'.$reg->ID_PAGO.'">'.$reg->nivel.'</span>',
                            "3"=>'<span data-var="costo" class="idpago-'.$reg->ID_PAGO.'">'.$reg->COSTO.'</span>',
                            "4"=>'<span data-var="cargo" class="idpago-'.$reg->ID_PAGO.'">'.$totalRetraso.'</span>',
                            "5" => '<span data-var="fecha_pago"  class="idpago-' . $reg->ID_PAGO . '">' . $reg->FECHA_PAGO . '</span>',
                            "6"=>'<span data-var="descuento" class="idpago-'.$reg->ID_PAGO.'">'.$descuentos.'</span>',
                            "7"=>'<span data-var="monto_pago" class="idpago-'.$reg->ID_PAGO.'">'.$totalAPagar.'</span>',
                            "8"=>'<span data-var="semanas_retraso" class="idpago-'.$reg->ID_PAGO.'">'.$semanasDeRetraso.'</span>',
                            "9"=>(!$reg->status)?'<button class="btn btn-danger" onclick="pagar('.$reg->ID_PAGO.')"><i class="fa fa-money"></i>  Pagar</button>':
                                '<button class="btn btn-success" onclick="ver_recibo('.$reg->ID_PAGO.')"><i class="fa fa-eye"></i> Recibo</button>');    
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
