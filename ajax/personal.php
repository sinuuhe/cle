<?php 
require_once "../modelos/personal.php";

$empleado=new Personal();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$apellidoP=isset($_POST["apellidoP"])? limpiarCadena($_POST["apellidoP"]):"";
$apellidoM = isset($_POST["apellidoM"])? limpiarCadena($_POST["apellidoM"]):"";
$telefono = isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$celular = isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
$email = isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$fecha_nacimiento = isset($_POST["fecha_nacimiento"])? limpiarCadena($_POST["fecha_nacimiento"]):"";
$fecha_ingreso = isset($_POST["fecha_ingreso"])? limpiarCadena($_POST["fecha_ingreso"]):"";
$foto = isset($_POST["foto"])? limpiarCadena($_POST["foto"]):"";
$sede = 1;
$status = isset($_POST["status"])? limpiarCadena($_POST["status"]):"";
$password = isset($_POST["password"])? limpiarCadena($_POST["password"]):"";
$puesto = isset($_POST["puesto"])? limpiarCadena($_POST["puesto"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id)){
			//get the new Id
			$nuevoMaestroId = "CLE-PE".Personal::obtenerCantidad();
			$password = strtoupper($nombre).strtoupper($apellidoP);
			$ext = explode(".", $_FILES["foto"]["name"]);
			$foto = $nuevoMaestroId. '.' . end($ext);
			$ruta = "/files/fotosPersonal/".$foto;
			$rspta=$empleado->insertar($nuevoMaestroId,$nombre,$apellidoP,$apellidoM,$telefono,$celular,$email,$fecha_nacimiento,$fecha_ingreso,$ruta,$password,$sede,$puesto);
			echo $rspta ? "Trabajador registrado correctamente." : "No se pudo registrar al trabajador. Intente de nuevo por favor.";


			//Foto
			
			if ($_FILES['foto']['type'] == "image/jpg" || $_FILES['foto']['type'] == "image/jpeg" || $_FILES['foto']['type'] == "image/png")
			{
				move_uploaded_file($_FILES["foto"]["tmp_name"], "../files/fotosPersonal/" . $foto);
			}
		}
		else {
			$ext = explode(".", $_FILES["foto"]["name"]);
			$foto = $id. '.' . end($ext);
			$ruta = "/files/fotosPersonal/".$foto;

			if ($_FILES['foto']['type'] == "image/jpg" || $_FILES['foto']['type'] == "image/jpeg" || $_FILES['foto']['type'] == "image/png")
			{
				
				move_uploaded_file($_FILES["foto"]["tmp_name"], "../files/fotosPersonal/" . $foto);
			}


			$rspta=$empleado->editar($id,$nombre,$apellidoP,$apellidoM,$telefono,$celular,$email,$fecha_nacimiento,$fecha_ingreso,$ruta,$password,$sede,$puesto);
			echo $rspta ? "Trabajador actualizado correctamente.": "No se pudo actuailzar el trabajador. Intente de nuevo por favor.";
		}
	break;

	case 'baja':
		$rspta=$empleado->baja($id);
 		echo $rspta ? "Empleado dado de baja correctamente" : "Empleado no se puede dar de baja";
	break;

	case 'alta':
		$rspta=$empleado->alta($id);
 		echo $rspta ? "Empleado dado de alta correctamente" : "Empleado no se puede dar de alta";
	break;

	case 'mostrar':
		$rspta=$empleado->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$empleado->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>(!$reg->status)?'<button class="btn btn-success" onclick="alta(\''.$reg->id.'\',\''.$reg->nombre.' '.$reg->apellidoP.' '.$reg->apellidoM.'\')"><i class=""></i>Alta</button>':
					 '<button class="btn btn-danger" onclick="baja(\''.$reg->id.'\',\''.$reg->nombre.' '.$reg->apellidoP.' '.$reg->apellidoM.'\')"><i class=""></i> Baja</button>
					 <button class="btn btn-warning" onclick="mostrar(\''.$reg->id.'\',\''.$reg->nombre.' '.$reg->apellidoP.' '.$reg->apellidoM.'\')"><i class=""></i>Editar</button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->apellidoP,
                "3"=>$reg->apellidoM,
                "4"=>$reg->telefono,
                "5"=>($reg->status)?'<span class="label bg-green">Activo</span>':
									'<span class="label bg-red">Baja</span>'
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