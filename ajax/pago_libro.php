<?php

require_once dirname(__DIR__, 1) . "/modelos/PagoLibro.php";
require_once dirname(__DIR__, 1) . "/modelos/Alumnos.php";

$pago_libro = new PagoLibro();
$alumno = new Alumno();

switch ($_GET["op"]) {
    case 'iniciar_selects':
        $dataAlumnos = Array();
        $dataLibros = Array();

        $rspta = $alumno->listar();
        if ($rspta) {
            while ($reg = $rspta->fetch_object()) {
                $dataAlumnos[] = array(
                    'nombre' => $reg->nombre,
                    'apellidoP' => $reg->apellidoP,
                    'apellidoM' => $reg->apellidoM,
                    'id' => $reg->id
                );
            }
        } else {
            echo "Error al listar Alumnos: " . $conexion->error;
            exit();
        }
        $rspta = $pago_libro->listar_libros();
        if ($rspta) {
            while ($reg = $rspta->fetch_object()) {
                $dataLibro[] = array(
                    'nombre' => $reg->nombre,
                    'id' => $reg->id,
                    'costo' => $reg->COSTO
                );
            }
        } else {
            echo "Error al listar libros: " . $conexion->error;
            exit();
        }

        $selects[] = array(
            'libros' => $dataLibro,
            'alumnos' => $dataAlumnos
        );
        echo json_encode($selects);
        break;
    case 'cancelar_pago':
        $rspta = $pago_libro->cancelar_pago($idpagolibro);
        echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
        break;

    case 'pagar':
        $rspta = $pago_libro->pagar($idpagolibro, date("Y-m-d H:i:s"), $forma_pago);
        echo $rspta ? json_encode(array('verificar' => 'success', 'mensaje' => 'Pago realizado con éxito.')) :
                json_encode(array('verificar' => 'error', 'mensaje' => 'Pago no realizado.'));
        break;

    case 'listar_pago':
        $rspta = $pago_libro->listar_pago($idpagolibro);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    case 'listar':
         $rspta = $pago_libro->listar_pagos();
        if($rspta){
            
        }else{
             echo "Error al listar libros: " . $conexion->error;
            exit();
        }
       
        //Vamos a declarar un array
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => '<span data-var="matricula" class="idpago-' . $reg->id . '">' . $reg->libro . '</span>',
                "1" => '<span data-var="nombre" class="idpago-' . $reg->id . '">' . $reg->alumno. '</span>',
                "2" => '<span data-var="monto_pago"  class="idpago-' . $reg->id . '">' . $reg->fecha_pago . '</span>',
                "3" => '<span data-var="descuento"  class="idpago-' . $reg->id . '">' . $reg->forma_pago . '</span>',
                "4" => '$ <span data-var="total_pago"  class="idpago-' . $reg->id . '">' . $reg->total_pago . '</span>',
                "5" => '<button class="btn btn-success" onclick="ver_recibo(' . $reg->id . ')"><i class="fa fa-eye"></i> Recibo</button>',
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total vendedors al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data);
        echo json_encode($results);
        break;
}
?>
