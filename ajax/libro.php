<?php 
require_once "../modelos/libro.php";

$libro=new Libro();
 
$id  = isset($_POST["id"])? limpiarCadena($_POST["id"]):"" ;
$nombre  = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$costo  = isset($_POST["costo"])? limpiarCadena($_POST["costo"]):"";
$cantidad  = isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";
$clave  = isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";

switch ($_GET["op"]){

	case 'guardaryeditar':
		if (empty($id)){
			//get the new Id
			$id = 0;
			$rspta=$libro->insertar($id,$clave,$nombre,$costo,$cantidad);
			echo $rspta ? "Libro registrado correctamente." : "No se pudo registrar el libro. Intente de nuevo por favor.";

		}
		else {
			$rspta=$libro->editar($id,$clave,$nombre,$costo,$cantidad);
			echo $rspta ? "Libro actualizado correctamente.": "No se pudo actuailzar el libro. Intente de nuevo por favor.";
		}
	break;

	case 'eliminar':
		$rspta=$libro->eliminar($id);
 		echo $rspta ? "Libro eliminado correctamente" : "Libro no se puede eliminar";
	break;

	case 'mostrar':
		$rspta=$libro->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$libro->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				"0"=>'<button class="btn btn-danger" onclick="eliminar(\''.$reg->id.'\',\''.$reg->nombre.'\')"><i class=""></i>Eliminar</button>
				      <button class="btn btn-warning" onclick="mostrar(\''.$reg->id.'\',\''.$reg->nombre.'\')"><i class=""></i>Editar</button>',
 				"1"=>$reg->clave,
 				"2"=>$reg->nombre,
                "3"=>$reg->costo,
                "4"=>$reg->cantidad
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