<?php 
require_once "../modelos/grupo.php";
session_start();
$grupo=new Grupo();

$id  = isset($_POST["id"])? limpiarCadena($_POST["id"]):"" ;
$idNivel  = isset($_POST["nivel"])? limpiarCadena($_POST["nivel"]):"" ;
$idMaestro  = isset($_POST["idMaestro"])? limpiarCadena($_POST["idMaestro"]):"";
$numDias  = isset($_POST["numDias"])? limpiarCadena($_POST["numDias"]):"";
$dias  = isset($_POST["dias"])? limpiarCadena($_POST["dias"]):"";
$fecha_inicio  = isset($_POST["fecha_inicio"])? limpiarCadena($_POST["fecha_inicio"]):"";
$fecha_fin  = isset($_POST["fecha_fin"])? limpiarCadena($_POST["fecha_fin"]):"";
$sede  = 1;
$salon  = isset($_POST["salon"])? limpiarCadena($_POST["salon"]):"";
$observacion  = isset($_POST["observacion"])? limpiarCadena($_POST["observacion"]):"";
$horario_entrada  = isset($_POST["horario_entrada"])? limpiarCadena($_POST["horario_entrada"]):"";
$horario_salida  = isset($_POST["horario_salida"])? limpiarCadena($_POST["horario_salida"]):"";
$idGrupo = isset($_GET["g"])? limpiarCadena($_GET["g"]):"";
$idAlumno = isset($_GET["idAlumno"])? limpiarCadena($_GET["idAlumno"]):"";
$fecha = isset($_GET["fecha"])? limpiarCadena($_GET["fecha"]):"";
$observaciones = isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";


switch ($_GET["op"]){
    case 'iniciar_niveles':
        $dataNiveles = Array();

        $rspta = $grupo->listarNiveles();
        if ($rspta) {
            while ($reg = $rspta->fetch_object()) {
                //---CHECAR DATOS DE NIVELES!!!---
                $dataNiveles[] = array(
					'id' => $reg->ID,
                    'nombre' => $reg->NOMBRE,
                    'curso' => $reg->CURSO,
                    'material' => $reg->MATERIAL_LIBRO,
                    'costo' => $reg->COSTO
                );
            }
        } else {
            echo "Error al listar Niveles: " . $conexion->error;
            exit();
        }
        echo json_encode($dataNiveles);
        break;

        case 'iniciar_maestros':
        $dataMaestros = Array();

        $rspta = $grupo->listarMaestros();
        if ($rspta) {
            while ($reg = $rspta->fetch_object()) {
                //---CHECAR DATOS DE NIVELES!!!---
                $dataMaestros[] = array(
                    'id' => $reg->id,
                    'nombre' => $reg->nombre,
                    'apellidoP' => $reg->apellidoP,
                    'apellidoM' => $reg->apellidoM
                );
            }
        } else {
            echo "Error al listar Niveles: " . $conexion->error;
            exit();
        }
        echo json_encode($dataMaestros);
        break;        
	case 'guardaryeditar':
		if (empty($id)){
			//get the new Id
			$nuevoGrupoId = "G".Grupo::obtenerCantidad();
			$rspta=$grupo->insertar($nuevoGrupoId,$idNivel,$idMaestro,$numDias,$dias,$fecha_inicio,$fecha_fin,$sede,$salon,$observacion,$horario_entrada,$horario_salida);
			echo $rspta ? "Grupo registrado correctamente." : "No se pudo registrar el grupo. Intente de nuevo por favor.";

		}
		else {
			$rspta=$grupo->editar($id,$idNivel,$idMaestro,$numDias,$dias,$fecha_inicio,$fecha_fin,$sede,$salon,$observacion,$horario_entrada,$horario_salida);
			echo $rspta ? "Grupo actualizado correctamente.": "No se pudo actuailzar el grupo. Intente de nuevo por favor.";
		}
	break;

	case 'listarAlumnos':
	$rspta=$grupo->listarAlumnos($idGrupo);
	 //Vamos a declarar un array
	 $data= Array();

	 while ($reg=$rspta->fetch_object()){
		 $data[]=array(
			"0"=>$reg->nombre,
			"1"=>'<button class="btn btn-danger" onclick="eliminarAlumno(\''.$reg->id.'\',\''.$reg->ID_GRUPO.'\')"><i class=""></i>Remover</button>'
			 );
	 }
	 $results = array(
		 "sEcho"=>1, //Información para el datatables
		 "iTotalRecords"=>count($data), //enviamos el total registros al datatable
		 "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		 "aaData"=>$data);
	 echo json_encode($results);

break;

case 'listarAsistencias':
	
///////////////////////////////////////////////
	$fechas = $grupo -> listarFechas($idGrupo);
	//Vamos a declarar un array
	 if(!$fechas){die($conexion->error);}
	 $fecha = Array();
	 while ($reg=$fechas->fetch_object()){
		 $fecha[]=array(
			"fechas"=>$reg -> fecha,
		);
	 }
///////////////////////////////////////////////
	$rspta=$grupo->listarAsistencias($idGrupo);
	if ($rspta) {
		$data = Array();
		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				'id' => $reg->matricula,
				'fecha' => $reg->fecha,
				'asistencia' => $reg->asistencias
			);
		}
	} else {
		die("Error al listar Niveles: " . $conexion->error);
	}
	///////////////////////////////////////////////
	$rspta=$grupo->listarAlumnos($idGrupo);
	 //Vamos a declarar un array
	 if(!$rspta){die($conexion->error);}
	 $alumnos= Array();
	 while ($reg=$rspta->fetch_object()){
		 $alumnos[]=array(
			"id"=>$reg->id,
			"nombre"=>$reg->nombre,
			 );
	 }

	$datos[] = array(
			'alumnos' => $alumnos,
            'asistencias' => $data,
            'fechas' => $fecha,
        );

	echo json_encode($datos);
break;

case 'listarAlumnosGrupo':

$rspta=$grupo->listarAlumnos($idGrupo);
 //Vamos a declarar un array
 if(!$rspta){die($conexion->error);}
 $data= Array();

 while ($reg=$rspta->fetch_object()){
	 $data[]=array(
		"0"=>$reg->id,
		"1"=>$reg->nombre,
		"2"=>$reg->ID_GRUPO,
		"3"=>$reg->idMaestro
		 );
 }

 echo json_encode($data);

break;

case 'listarAlumnosExtra':

$rspta=$grupo->listarAlumnosExtra($_SESSION['id'],'Extra');
 //Vamos a declarar un array
 if(!$rspta){die($conexion->error);}
 $data= Array();

 while ($reg=$rspta->fetch_object()){
	 $data[]=array(
		"0"=>$reg->id,
		"1"=>$reg->nombre
		 );
 }

 echo json_encode($data);

break;

	case 'listar_grupos';
	$rspta=$grupo->listarGrupos($_SESSION['id']);
	//Vamos a declarar un array
	$data= Array();

	while ($reg=$rspta->fetch_object()){
		$data[]=array(
			"0"=>$reg->ID_GRUPO,
			"1"=>$reg->NOMBRE,
			);
	}
	echo json_encode($data);

	break;

	case 'inscribirAlumno':
	$rspta=$grupo->inscribirAlumno($idGrupo,$idAlumno);
	if(!$rspta){die($conexion->error);}
	if($rspta){
		$resp2 = $grupo->insertarCosto($idGrupo,$idAlumno);
		if(!$rspta2){die($conexion->error);}
		echo $rspta2 ? "Alumno inscrito" : "Alumno no se puede inscribir en este momento";
	}else{
		echo 'Error al crear el pago del alumno';
	}
	 
break;

	

	case 'nueva':
	$obj = json_decode($_POST['array']);
	foreach($obj as $clave) {
		if(empty ($clave -> id)){
			$rspta=$grupo->subirLista($clave -> alumnoId, $clave -> asistencia, $_GET["grupo"], $_GET["fecha"]);
		}else{
			$rspta=$grupo->actualizarLista($clave -> id,$clave -> alumnoId, $clave -> asistencia, $_GET["grupo"], $_GET["fecha"]);
		}
	}

	echo $rspta;
	break;

	case 'subirCalificacionesExtra';
	echo "Entre al case";
	$obj = json_decode($_POST['array']);
	foreach($obj as $alumno) {
		echo "
		Entre al for";
		if($alumno -> calificacion >= 80){
			echo "
		Entre al if";
			//Pasa el extra
			//remueve alumno de tabla extras
			$grupo -> removerExtraAlumnoMaestro($alumno -> alumnoId,$_SESSION['id']);
			echo "
		Entre al 1";
			//Se cambia status, calificacion, y se hace el insert en historico alumnos
			$grupo -> actualizarStatusAlumno($alumno -> alumnoId,"Normal-Extra",$_SESSION['id']);
			echo "
		Entre al 2";
			$grupo -> asignarCalificacion($alumno -> alumnoId,$alumno -> calificacion);
			echo "
		Entre al 3";
			$idGrupoAlumno = $grupo -> obtenerGrupo($alumno -> alumnoId);
			echo "
		Entre al 4";
			$grupo -> insertarHistoricoAlumnos($idGrupoAlumno,$alumno -> alumnoId,$alumno -> calificacion,"Normal-Extra");
			echo "
		Entre al 5";
		}else{
			echo "
		Entre al else";
			//Va a segundo extra
			$idGrupoAlumno = $grupo -> obtenerGrupo($alumno -> alumnoId);
			echo "
		Entre al 2.1";
			$grupo -> actualizarStatusAlumno($alumno -> alumnoId,"Seg-Extra",$_SESSION['id']);
			$grupo -> actualizarStatusAlumnoExtra($alumno -> alumnoId,"Seg-Extra",$_SESSION['id']);
			echo "
		Entre al 22";
			$grupo -> asignarCalificacion($alumno -> alumnoId,$alumno -> calificacion);
			echo "
		Entre al 23";
			$idGrupoAlumno = $grupo -> obtenerGrupo($alumno -> alumnoId);
			echo "
		Entre al 24";
			$grupo -> insertarHistoricoAlumnos($idGrupoAlumno,$alumno -> alumnoId,$alumno -> calificacion,"Seg-Extra");
			echo "
		Entre al 25";
		}
	}
	break;

	case 'subirCalificaciones':
	$obj = json_decode($_POST['array']);
	foreach($obj as $alumno) {
		if(empty ($alumno -> id)){
			$totalA = 0; $totalF = 0; $totalS = 0;
			$asistencias = $grupo->listarAsistencias($idGrupo, $alumno -> alumnoId);
			if(!$asistencias) die($conexion->error);
			while ($reg=$asistencias->fetch_object()){
				switch ($reg -> asistencia){
					case "A":
						$totalA++;
					break;
					case "F":
						$totaF++;
					break;
					case "S":
						$totaS++;
					break;
				}
			}

			$granTotal = $asistencias -> num_rows;
			$porcentaje = ($totalA * 100) / $granTotal;
			echo "alumno: ".$alumno->alumnoId." Total horas : ".$granTotal." totalA: ".$totalA." potcentaje : ".$porcentaje;
			if($porcentaje >= 75 && $alumno->calificacion >= 70){
				//normal
				$grupo -> insertarHistoricoAlumnos($idGrupo,$alumno -> alumnoId,$alumno->calificacion,"Normal");
				$grupo -> asignarCalificacion($alumno -> alumnoId,$alumno->calificacion);
				$grupo -> actualizarStatusAlumno($alumno -> alumnoId,"Normal",$_SESSION['id']);
			}
			else {
				//extra
				$grupo -> asignarCalificacion($alumno -> alumnoId,$alumno->calificacion);
				$grupo -> actualizarStatusAlumno($alumno -> alumnoId,"Extra",$_SESSION['id']);
				$grupo -> insertarHistoricoAlumnos($idGrupo,$alumno -> alumnoId,$alumno->calificacion,"Extra");
				$grupo -> asignarExtraAlumnoMaestro($alumno -> alumnoId,$_SESSION['id'],$idGrupo);
			}
			//$rspta=$grupo->subirCalificacion($alumno -> alumnoId, $alumno -> asistencia, $_GET["grupo"], $_GET["fecha"]);
		}else{
			//$rspta=$grupo->actualizarLista($clave -> id,$clave -> alumnoId, $clave -> asistencia, $_GET["grupo"], $_GET["fecha"]);
		}
	} 
	$grupo -> insertarHistoricoGrupos($idGrupo,$observaciones);
	$rspta = $grupo -> asignarSiguienteNivel($idGrupo);
	//if(!$rspta){die($conexion->error);}
	

	echo $rspta ? "Carga de calificaciones correcta" : "No se pudieron cargar las calificaciones. Intente más tarde.";
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
		$rspta=$grupo->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$grupo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				"0"=>'<button class="btn btn-warning" onclick="mostrar(\''.$reg->ID_GRUPO.'\')"><i class=""></i>Editar</button>
				<button class="btn btn-success" onclick="verAlumnos(\''.$reg->ID_GRUPO.'\',true)"><i class=""></i>Alumnos</button>',
 				"1"=>$reg->infoNivel,
 				"2"=>$reg->nombre,
                "3"=>$reg->DIAS,
                "4"=>$reg->HORARIO_ENTRADA,
                "5"=>$reg->HORARIO_SALIDA
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	
	case 'removerAlumno':
	$rspta=$grupo->removerAlumno($idAlumno,$idGrupo);
	echo $rspta ? "Alumno removido correctamente" : "No se pudo remover al alumno";
	break;

	case 'checarFecha':
	$data = Array();

	$rspta = $grupo->checarFecha($idGrupo,$fecha);
	if ($rspta) {
		while ($reg = $rspta->fetch_object()) {
			//---CHECAR DATOS DE NIVELES!!!---
			$data[] = array(
				'id' => $reg->id,
				'idAlumno' => $reg->id_alumno,
				'idGrupo' => $reg->id_grupo,
				'fecha' => $reg->fecha,
				'asistencia' => $reg->asistencia
			);
		}
	} else {
		echo "Error al listar Niveles: " . $conexion->error;
		exit();
	}
	echo json_encode($data);
	break;
}
?>