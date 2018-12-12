<?php

require_once dirname(__DIR__, 1) . "/modelos/PagoLibro.php";
require_once dirname(__DIR__, 1) . "/modelos/Alumnos.php";

$pago_libro = new PagoLibro();
$alumno = new Alumno();

$id_libro = isset($_POST["libro"]) ? limpiarCadena($_POST["libro"]) : "";
$id_alumno = isset($_POST["alumno"]) ? limpiarCadena($_POST["alumno"]) : "";
$fecha_pago = date("Y-m-d H:i:s");
$costo_libro = isset($_POST["libro_costo"]) ? limpiarCadena($_POST["libro_costo"]) : "";
$forma_pago = isset($_POST["forma_pago"]) ? limpiarCadena($_POST["forma_pago"]) : "";

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
                    'costo' => $reg->costo,
                    'cantidad' => $reg -> cantidad
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
        $id_generado = 0;
        $rspta = $pago_libro->pagar($fecha_pago, $id_alumno, $id_libro, $costo_libro, $forma_pago);
        if($rspta){
            $id_generado =  $conexion->insert_id;
            $res = $pago_libro -> descontar($id_libro);
            if($res){
                $resp = $pago_libro -> insertar_salida($fecha_pago, $id_alumno, $id_libro);
                if(!$resp){
                    die ($conexion->error);
                }
            }else{
                die ($conexion->error);
            }
        }
        echo $rspta ? json_encode(array('verificar' => 'success', 'mensaje' => 'Pago realizado con éxito.', 'id_generado' => $id_generado)) :
                json_encode(array('verificar' => 'error', 'mensaje' => 'Pago no realizado.' . $conexion->error));
        break;
    case 'listar_pago':
        $rspta = $pago_libro->listar_pago($idpagolibro);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    case 'listar':
        $rspta = $pago_libro->listar_pagos();
        if ($rspta) {
            
        } else {
            echo "Error al listar libros: " . $conexion->error;
            exit();
        }

        //Vamos a declarar un array
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->libro,
                "1" => $reg->alumno ,
                "2" => $reg->fecha_pago ,
                "3" => $reg->forma_pago,
                "4" => $reg->total_pago ,
                "5" => '<form target="_blank" action="../impresiones/tickets/ticketPDF.php" method="POST">
                            <input name="idpago" value="'.$reg->id.'" type="hidden" class="idpago">
                            <input type="hidden" id="concepto" name="concepto" value="Pago de libro" />
                            <input type="hidden" id="formato" name="formato" value="pago_libro"/>
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-eye"></i> Ver recibo</button>
                        </form>',
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
