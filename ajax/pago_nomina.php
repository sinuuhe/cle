<?php

require_once dirname(__DIR__, 1) . "/modelos/PagoNomina.php";

$pago_nomina = new PagoNomina();

$idpagonomina = isset($_POST["idpagonomina"]) ? limpiarCadena($_POST["idpagonomina"]) : "";
$pago = isset($_GET["pago"]) ? limpiarCadena($_GET["pago"]) : "";
$fecha = isset($_GET["fecha"]) ? limpiarCadena($_GET["fecha"]) : date("Y-m-d H:i:s");
$fech = isset($_POST["fech"]) ? limpiarCadena($_POST["fech"]) : date("Y-m-d H:i:s");

switch ($_GET["op"]) {
    case 'cambiar_semana':
        $num_semana = $pago_nomina->obtenerNumSemana($fecha);
        $semana_inicio = $pago_nomina->obtenerSemanaInicio($fecha);
        $semana_fin = $pago_nomina->obtenerSemanaFin($fecha);

        echo json_encode(array('num_semana' => $num_semana, 'semana_inicio' => $semana_inicio, 'semana_fin' => $semana_fin));

        break;
    case 'cancelar_pago':
        $rspta = $pago_nomina->cancelar_pago($idpagonomina);
        echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
        break;

    case 'pagar':
        $rspta = $pago_nomina->pagar($idpagonomina, date("Y-m-d H:i:s"));
        echo $rspta ? json_encode(array('verificar' => 'success', 'mensaje' => 'Pago realizado con éxito.','fecha' => "$fech")) :
                json_encode(array('verificar' => 'error', 'mensaje' => 'Pago no realizado.'));
        break;

    case 'listar_pago':
        $rspta = $pago_nomina->listar_pago($idpagonomina);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    case 'listar':
        $semana = $pago_nomina->obtenerNumSemana($fecha);
        $status =  $pago == "ver_nopagados" ? 0 : 1;
        $rspta = $pago_nomina->listar_pagos($status, $semana);
        //Vamos a declarar un array
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            if ($pago != 'ver_pagados') {
                $data[] = array(
                    "0" => '<span data-var="matricula" class="idpago-' . $reg->id . '">' . $reg->matricula . '</span>',
                    "1" => '<span data-var="nombre"  class="idpago-' . $reg->id . '">' . $reg->nombre . '</span>',
                    /* "2"=>($reg->status)?'<span class="label bg-green">Pagado</span>':
                      '<span class="label bg-red">Adeudo</span>', */
                    "2" => '<span data-var="grupo"  class="idpago-' . $reg->id . '">' . $reg->grupo . '</span>',
                    "3" => '<span data-var="horas_trabajadas"  class="idpago-' . $reg->id . '">' . $reg->horas_trabajadas . '</span>',
                    "4" => '<span data-var="monto_pago"  class="idpago-' . $reg->id . '">' . $reg->monto_pago . '</span>',
                    "5" => (!$reg->status) ? '<button class="btn btn-danger" onclick="pagar(' . $reg->id . ')"><i class="fa fa-money"></i>  Pagar</button>' :
                    '<button class="btn btn-success" onclick="ver_recibo(' . $reg->id . ')"><i class="fa fa-eye"></i> Recibo</button>');
            } else {
                $data[] = array(
                    "0" => '<span data-var="matricula"  class="idpago-' . $reg->id . '">' . $reg->matricula . '</span>',
                    "1" => '<span data-var="nombre"  class="idpago-' . $reg->id . '">' . $reg->nombre . '</span>',
                    /* "2"=>($reg->status)?'<span class="label bg-green">Pagado</span>':
                      '<span class="label bg-red">Adeudo</span>', */
                    "2" => '<span data-var="grupo"  class="idpago-' . $reg->id . '">' . $reg->grupo . '</span>',
                    "3" => '<span data-var="horas_trabajadas"  class="idpago-' . $reg->id . '">' . $reg->horas_trabajadas . '</span>',
                    "4" => '<span data-var="monto_pago"  class="idpago-' . $reg->id . '">' . $reg->monto_pago . '</span>',
                    "6" => (!$reg->status) ? '<button class="btn btn-danger" onclick="pagar(' . $reg->id . ')"><i class="fa fa-money"></i>  Pagar</button>' :
                    '<button class="btn btn-success" onclick="ver_recibo(' . $reg->id . ')"><i class="fa fa-eye"></i> Recibo</button>',
                    "5" => '<span data-var="fecha_pago"  class="idpago-' . $reg->id . '">' . $reg->fecha_pago . '</span>');
            }
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data);
        echo json_encode( $results);
        break;
}
?>