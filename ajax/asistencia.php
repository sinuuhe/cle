<?php 
require_once "../modelos/asistencia.php";

$asistencia=new Asistencia();

$idGrupo=isset($_POST["idGrupo"])? limpiarCadena($_POST["idGrupo"]):"";
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
//sede sera tomada de la sesion
$sede = 1;
$status = isset($_POST["status"])? limpiarCadena($_POST["status"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id)){
			//get the new Id
			$nuevoIdAlumno = "A".Alumno::obtenerCantidad();
			$password = strtoupper($nombre).strtoupper($apellidoP);
			$ext = explode(".", $_FILES["foto"]["name"]);
			$foto = $nuevoIdAlumno. '.' . end($ext);
			$ruta = "/files/fotosAlumnos/".$foto;
			$rspta=$asistencia->insertar($nuevoIdAlumno,$nombre,$apellidoP,$apellidoM,$calle,$colonia,$numero,$municipio,$telefono,$celular,$email,$fecha_nacimiento,$fecha_ingreso,$ruta,$empresa,$beca,$password,$sede);
			echo $rspta ? "Alumno registrado correctamente." : "No se pudo registrar el alumno. Intente de nuevo por favor.";


			//Foto
			
			if ($_FILES['foto']['type'] == "image/jpg" || $_FILES['foto']['type'] == "image/jpeg" || $_FILES['foto']['type'] == "image/png")
			{
				
				move_uploaded_file($_FILES["foto"]["tmp_name"], "../files/fotosAlumnos/" . $foto);
			}
		}
		else {
			$ext = explode(".", $_FILES["foto"]["name"]);
			$foto = $id. '.' . end($ext);
			$ruta = "/files/fotosAlumnos/".$foto;

			if ($_FILES['foto']['type'] == "image/jpg" || $_FILES['foto']['type'] == "image/jpeg" || $_FILES['foto']['type'] == "image/png")
			{
				
				move_uploaded_file($_FILES["foto"]["tmp_name"], "../files/fotosAlumnos/" . $foto);
			}


			$rspta=$asistencia->editar($id,$nombre,$apellidoP,$apellidoM,$calle,$colonia,$numero,$municipio,$telefono,$celular,$email,$fecha_nacimiento,$fecha_ingreso,$foto,$status,$empresa,$beca,$password,$sede);
			echo $rspta ? "Alumno actualizado correctamente." : "No se pudo actuailzar el alumno. Intente de nuevo por favor.";
		}
    break;
    
    case 'listar':
        
    break;

	case 'mostrar':
		$rspta=$asistencia->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'obtenerAlumnosYNoClases':
		$rspta=$asistencia->listarAlumnos($idGrupo);
 		//Vamos a declarar un array
 		$data= Array();
        $numClass=$asistencia->obtenerCantidadDeClases($idGrupo);

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->ID_ALUMNO,
 				"1"=>$reg->ID_GRUPO,
                "2"=>$reg->NOMBRE,
                "4"=>$numClass
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