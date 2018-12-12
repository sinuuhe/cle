<?php

//Se recibe por POST las varibales: FechaInicio, FechaFin, Tipo(Esta variable se refiere a si es corte de nomina , o inscripciones, etc)
//La variable "Tipo" puede tener solo estos valores: "Cursos","Inscripcion", "Extras", "Libros", "Nomina"
//Las variables de fecha deben tener esta formato: YYYY-mm-dd
$obj = null;
$totalFinal = 0;


switch ($_POST["tipo"]) {
    case "Extras":
        require_once dirname(__DIR__, 2) . "/modelos/PagoExtras.php";
        $obj = new PagoExtras();
        break;
    case "Libros":
        require_once dirname(__DIR__, 2) . "/modelos/PagoLibro.php";
        $obj = new PagoLibro();
        break;
    case "Cursos":
        require_once dirname(__DIR__, 2) . "/modelos/PagoCurso.php";
        $obj = new PagoCurso();
        break;
    case "Inscripciones":
        require_once dirname(__DIR__, 2) . "/modelos/PagoInscripcion.php";
        $obj = new PagoInscripcion();
        break;
    case "Nominas":
        require_once dirname(__DIR__, 2) . "/modelos/PagoNomina.php";
        $obj = new PagoNomina();
        break;
    default:
        break;
}

$fecha_inicio = isset($_POST["fecha_i"]) ? limpiarCadena($_POST["fecha_i"]) : "";
$fecha_fin = isset($_POST["fecha_f"]) ? limpiarCadena($_POST["fecha_f"]) : "";
$rspta = $obj->corte_caja($fecha_inicio, $fecha_fin);
if(!$rspta){
    die ("No se encontraron registros");
}
$html = '
<div class="container row">
    <div class="col s6 m6 l6 xl6">
    	<img class="img-5x" src="img/logoBN.png" alt="CLE">
    </div>
<br><br>
    <div class="col s6 m6 l6 xl6 center-align">
    	<h4 class="top-5x">Corte de caja de <b>' . $_POST["tipo"] . '</b></h4>
    </div>

    <div class="col s12 m12 l12 xl12 center-align">
    	<h6><b>Fecha: </b>'.$fecha_inicio.' al '.$fecha_fin.'</h6>
    </div>

    <div class="col s12 m12 l12 xl12 center-align">
    	<table>
    	    <thead>
                <tr>
                    <th>Fecha</th>
                    <th>alumnos</th>
                    <th>Operación</th>
                    <th>Total</th>
                </tr>
    	    </thead>

            <tbody>';

while ($reg = $rspta->fetch_object()) {
    $html .=
           '    <tr>
                    <td>' . $reg->fecha_pago . '</td>
                    <td>' . $reg->nombre . '</td>
                    <td>Pago de ' . $_POST["tipo"] . '</td>
                    <td>$' . $reg->monto_pago . '</td>
                </tr>';
    $totalFinal += $reg->monto_pago;
}

$html .= '      <tr>
                    <td></td>
                    <td></td>
                    <td class="right-align"><b>Total:</b></td>
                    <td><b>$' . $totalFinal . '</b></td>
                </tr>
            </tbody>
        </table>	
    </div>
</div>';


require_once dirname(__DIR__, 2) . '/vendor/mpdf/mpdf/mpdf.php';

$mpdf = new \mPDF('', '', 0, '', 0, 0, 5, 0);
/**
 * @brief  Se cargan las hojas de estilo y los archivos js al html y se define el nombre cuando se descargue al oordenador
 */
$css = file_get_contents('css/estilos_impresion_ticket.css');
$css2 = file_get_contents('css/materialize.min.css');
$mpdf->writeHTML($css2, 1);
$mpdf->writeHTML($css, 1);

$mpdf->writeHTML($html);
$mpdf->Output('CorteDeCaja.pdf', 'I');
?>