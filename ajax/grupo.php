<?php 
require_once "../modelos/grupo.php";

$grupo=new Grupo();
 
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
			echo $horario_entrada;
			$rspta=$grupo->insertar($nuevoGrupoId,$idNivel,$idMaestro,$numDias,$dias,$fecha_inicio,$fecha_fin,$sede,$salon,$observacion,$horario_entrada,$horario_salida);
			echo $rspta ? "Grupo registrado correctamente." : "No se pudo registrar el grupo. Intente de nuevo por favor.";


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
		$rspta=$grupo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->ID_GRUPO,
 				"1"=>$reg->nombre,
                "2"=>$reg->DIAS,
                "3"=>$reg->HORARIO_ENTRADA,
                "4"=>$reg->HORARIO_SALIDA
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