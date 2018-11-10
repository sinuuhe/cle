<?php 
require_once "../modelos/Convenios.php";

$convenio=new Convenio();

$id  = isset($_POST["id"])? limpiarCadena($_POST["id"]):"" ;
$nombre  = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"" ;
$des_mensualidad  = isset($_POST["des_mensualidad"])? limpiarCadena($_POST["des_mensualidad"]):"";
$des_inscripcion  = isset($_POST["des_inscripcion"])? limpiarCadena($_POST["des_inscripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
	
		if (empty($id)){
			//get the new Id
			$id = 0;
			$rspta=$convenio->insertar($id,$nombre,$des_mensualidad,$des_inscripcion);
			echo $rspta ? "Convenio registrado correctamente." : "No se pudo registrar el convenio. Intente de nuevo por favor.";

		}
		else {
			$rspta=$convenio->editar($id,$nombre,$des_mensualidad,$des_inscripcion);
			echo $rspta ? "Convenio actualizado correctamente.": "No se pudo actuailzar el convenio. Intente de nuevo por favor.";
		}
	

		case 'mostrar':
		$rspta=$convenio->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$convenio->listar();
 		//Vamos a declarar un array
 		$data= Array();
         
 		while ($reg=$rspta->fetch_assoc()){
 			$data[]=array(
                "id" =>$reg["ID"], 
				 "nombre"=>$reg["NOMBRE"],
				 "des_mensualidad"=>$reg["DES_MENSUALIDAD"]
 				);
         }
         echo json_encode($data);
	break;

	case 'listarTodo':
	$rspta=$convenio->listar();
	 //Vamos a declarar un array
	 $data= Array();
	 
	 while ($reg=$rspta->fetch_assoc()){
		 $data[]=array(
			"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg["ID"].	')"><i class=""></i>Editar</button>
			<button class="btn btn-danger" onclick="eliminar('.$reg["ID"].	')"><i class=""></i>Eliminar</button>',
			 "1"=>$reg["NOMBRE"],
			 "2"=>$reg["DES_MENSUALIDAD"].' %',
			 "3"=>$reg["DES_INSCRIPCION"].' %'
			 );
	 }
	 $results = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count($data), //enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		"aaData"=>$data);
	echo json_encode($results);
	break;

	case 'eliminar':
		$rspta=$convenio->eliminar($id);
		echo $rspta ? "Convenio eliminado correctamente" : "No se pudo eliminar el convenio";
	break;
}
?>