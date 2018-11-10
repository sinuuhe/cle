<?php 
require_once "../modelos/maestro.php";

$maestro=new Maestro();

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

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id)){
			//get the new Id
			$nuevoMaestroId = "MA".Maestro::obtenerCantidad();
			$password = strtoupper($nombre).strtoupper($apellidoP);
			$ext = explode(".", $_FILES["foto"]["name"]);
			$foto = $nuevoMaestroId. '.' . end($ext);
			$ruta = "/files/fotosMaestros/".$foto;
			$rspta=$maestro->insertar($nuevoMaestroId,$nombre,$apellidoP,$apellidoM,$telefono,$celular,$email,$fecha_nacimiento,$fecha_ingreso,$ruta,$password,$sede);
			echo $rspta ? "Maestro registrado correctamente." : "No se pudo registrar al maestro. Intente de nuevo por favor.";


			//Foto
			
			if ($_FILES['foto']['type'] == "image/jpg" || $_FILES['foto']['type'] == "image/jpeg" || $_FILES['foto']['type'] == "image/png")
			{
				
				move_uploaded_file($_FILES["foto"]["tmp_name"], "../files/fotosMaestros/" . $foto);
			}
		}
		else {
			$ext = explode(".", $_FILES["foto"]["name"]);
			$foto = $id. '.' . end($ext);
			$ruta = "/files/fotosMaestros/".$foto;

			if ($_FILES['foto']['type'] == "image/jpg" || $_FILES['foto']['type'] == "image/jpeg" || $_FILES['foto']['type'] == "image/png")
			{
				
				move_uploaded_file($_FILES["foto"]["tmp_name"], "../files/fotosMaestros/" . $foto);
			}


			$rspta=$maestro->editar($id,$nombre,$apellidoP,$apellidoM,$telefono,$celular,$email,$fecha_nacimiento,$fecha_ingreso,$ruta,$password,$sede);
			echo $rspta ? "Maestro actualizado correctamente.": "No se pudo actuailzar el maestro. Intente de nuevo por favor.";
		}
	break;

	case 'cancelar_pago':
		$rspta=$maestro->cancelar_pago($idcategoria);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
	break;

	case 'pagar':
		$rspta=$maestro->pagar($idcategoria,date("Y-m-d H:i:s"),"TARJETA DEBITO");
 		echo $rspta ? "Categoría activada" : "Categoría no se puede activar";
	break;

	case 'baja':
		$rspta=$maestro->baja($id);
 		echo $rspta ? "Maestro dado de baja correctamente" : "Maestro no se puede dar de baja";
	break;

	case 'alta':
		$rspta=$maestro->alta($id);
 		echo $rspta ? "Maestro dado de alta correctamente" : "Maestro no se puede dar de alta";
	break;

	case 'mostrar':
		$rspta=$maestro->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$maestro->listar();
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