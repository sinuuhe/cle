<?php 
require_once "../modelos/PagoExtras.php";

$pago_extras=new PagoExtras();

$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idcategoria)){
			$rspta=$pago_extras->insertar($nombre,$descripcion);
			echo $rspta ? "Categoría registrada" : "Categoría no se pudo registrar";
		}
		else {
			$rspta=$pago_extras->editar($idcategoria,$nombre,$descripcion);
			echo $rspta ? "Categoría actualizada" : "Categoría no se pudo actualizar";
		}
	break;

	case 'cancelar_pago':
		$rspta=$pago_extras->cancelar_pago($idcategoria);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
	break;

	case 'pagar':
		$rspta=$pago_extras->pagar($idcategoria,date("Y-m-d H:i:s"),"TARJETA DEBITO");
 		echo $rspta ? "Categoría activada" : "Categoría no se puede activar";
	break;

	case 'mostrar':
		$rspta=$pago_extras->mostrar($idcategoria);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$pago_extras->listar_adeudos();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>(!$reg->status)?'<button class="btn btn-danger" onclick="pagar('.$reg->id.')"><i class="fa fa-money"></i>  Pagar</button>':
 					'<button class="btn btn-success" onclick="ver_recibo('.$reg->id.')"><i class="fa fa-eye"></i> Recibo</button>',
 				"1"=>$reg->matricula,
 				"2"=>$reg->nombre,
                                "3"=>$reg->ID_GRUPO,
                                "4"=>$reg->nivel,
                                "5"=>$reg->monto_pago,
                                "6"=>$reg->FORMA_PAGO,
 				"7"=>($reg->status)?'<span class="label bg-green">Pagado</span>':
 				'<span class="label bg-red">Adeudo</span>'
 				);
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