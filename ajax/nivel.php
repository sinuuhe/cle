<?php 
require_once "../modelos/nivel.php";

$nivel=new Nivel();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$curso=isset($_POST["curso"])? limpiarCadena($_POST["curso"]):"";
$duracion = isset($_POST["duracion"])? limpiarCadena($_POST["duracion"]):"";
$material_libro = isset($_POST["material_libro"])? limpiarCadena($_POST["material_libro"]):"";
$costo = isset($_POST["costo"])? limpiarCadena($_POST["costo"]):"";
$inscripcion = isset($_POST["inscripcion"])? limpiarCadena($_POST["inscripcion"]):"";
$documento = isset($_POST["documento"])? limpiarCadena($_POST["documento"]):"";
//sede sera tomada de la sesion
$sede = 1;
$status = isset($_POST["status"])? limpiarCadena($_POST["status"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id)){
			//get the new Id
            $id = 0;
            $rspta=$nivel->insertar($id,$nombre,$curso,$duracion,$material_libro,$costo,$inscripcion,$documento);
			echo $rspta ? "Nivel registrado correctamente." : "No se pudo registrar el nivel. Intente de nuevo por favor.";
		}
		else {

			$rspta=$nivel->editar($id,$nombre,$curso,$duracion,$material_libro,$costo,$inscripcion,$documento);
			echo $rspta ? "Nivel actualizado correctamente." : "No se pudo actuailzar el nivel. Intente de nuevo por favor.";
		}
    break;
    
	case 'mostrar':
		$rspta=$nivel->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
    break;

    case 'eliminar':
    $rspta=$nivel->eliminar($id);
     //Codificar el resultado utilizando json
     echo json_encode($rspta);
break;

	case 'listar':
		$rspta=$nivel->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-danger" onclick="eliminar(\''.$reg->ID.'\',\''.$reg->NOMBRE.'\')"><i class=""></i>Eliminar</button>
					 <button class="btn btn-warning" onclick="mostrar(\''.$reg->ID.'\',\''.$reg->NOMBRE.'\' )"><i class=""></i>Editar</button>',
 				"1"=>$reg->NOMBRE,
 				"2"=>$reg->CURSO,
				"3"=>$reg->COSTO,
				"4"=>$reg->INSCRIPCION
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