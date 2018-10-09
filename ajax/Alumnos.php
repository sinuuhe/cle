<?php 
require_once "../modelos/Alumnos.php";

$alumno=new Alumno();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$apellidoP=isset($_POST["apellidoP"])? limpiarCadena($_POST["apellidoP"]):"";
$apellidoM = isset($_POST["apellidoM"])? limpiarCadena($_POST["apellidoM"]):"";
$calle = isset($_POST["calle"])? limpiarCadena($_POST["calle"]):"";
$colonia = isset($_POST["colonia"])? limpiarCadena($_POST["colonia"]):"";
$numero = isset($_POST["numero"])? limpiarCadena($_POST["numero"]):"";
$municipio = isset($_POST["municipio"])? limpiarCadena($_POST["municipio"]):"";
$telefono = isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$celular = isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
$email = isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$fecha_nacimiento = isset($_POST["fecha_nacimiento"])? limpiarCadena($_POST["fecha_nacimiento"]):"";
$fecha_ingreso = isset($_POST["fecha_ingreso"])? limpiarCadena($_POST["fecha_ingreso"]):"";
$foto = isset($_POST["foto"])? limpiarCadena($_POST["foto"]):"";
$empresa = isset($_POST["empresa"])? limpiarCadena($_POST["empresa"]):"";
$beca = isset($_POST["beca"])? limpiarCadena($_POST["beca"]):"";
$password = isset($_POST["password"])? limpiarCadena($_POST["password"]):"";
$sede = isset($_POST["sede"])? limpiarCadena($_POST["sede"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id)){
			//get the new Id
			$nuevoIdAlumno = "A".Alumno::obtenerCantidad();

			$rspta=$alumno->insertar($nuevoIdAlumno,$nombre,$apellidoP,$apellidoM,$calle,$colonia,$numero,$municipio,$telefono,$celular,$email,$fecha_nacimiento,$fecha_ingreso,$foto,$empresa,$beca,$password,$sede);
			echo $rspta ? "Alumno registrado correctamente." : "No se pudo registrar el alumno. Intente de nuevo por favor.";
			//Foto
			$ext = explode(".", $_FILES["foto"]["name"]);
			if ($_FILES['foto']['type'] == "image/jpg" || $_FILES['foto']['type'] == "image/jpeg" || $_FILES['foto']['type'] == "image/png")
			{
				$foto = $nuevoIdAlumno. '.' . end($ext);
				move_uploaded_file($_FILES["foto"]["tmp_name"], "../files/fotosAlumnos/" . $foto);
			}
		}
		else {
			$rspta=$alumno->insertar($id,$nombre,$apellidoP,$apellidoM,$calle,$colonia,$numero,$municipio,$telefono,$celular,$email,$fecha_nacimiento,$fecha_ingreso,$foto,$empresa,$beca,$password,$sede);
			echo $rspta ? "Alumno actualizado correctamente." : "No se pudo actuailzar el alumno. Intente de nuevo por favor.";
		}
	break;

	case 'cancelar_pago':
		$rspta=$alumno->cancelar_pago($idcategoria);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
	break;

	case 'pagar':
		$rspta=$alumno->pagar($idcategoria,date("Y-m-d H:i:s"),"TARJETA DEBITO");
 		echo $rspta ? "Categoría activada" : "Categoría no se puede activar";
	break;

	case 'mostrar':
		$rspta=$alumno->mostrar($idcategoria);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$alumno->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>(!$reg->status)?'<button class="btn btn-danger" onclick="pagar('.$reg->id.')"><i class="fa fa-money"></i>  Pagar</button>':
 					'<button class="btn btn-success" onclick="ver_recibo('.$reg->id.')"><i class="fa fa-eye"></i> Recibo</button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->apellidoP,
                "3"=>$reg->apellidoM,
                "4"=>$reg->status
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