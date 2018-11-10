<?php

require_once dirname(__DIR__, 2) . "/modelos/PagoNomina.php";
$obj = new PagoNomina();

//Se recibe por POST las variable: IDNOMINA
$id = isset($_POST["idpagonomina"]) ? limpiarCadena($_POST["idpagonomina"]) : "";
$rspta = $obj->listar_pago($id);

if (!$rspta) {
    die("HA OCURRIDO UN ERROR " . $conexion->error);
}
$html = '<div class="container row">
		<div class="col s6 m6 l6 xl6">
			<img class="img-5x" src="img/logoBN.png" alt="CLE">
		</div>

		<div class="col s6 m6 l6 xl6 center-align">
			<h4 class="top-5x">Pago de honorarios</h4>
		</div>

		<div class="col s12 m12 l12 xl12 center-align">
			<p>Yo, el <b>C. ' . $rspta->nombre . '</b> recibí del <b>L.C Angel Leonardo Aguilar Ochoa</b> la cantidad de <b>$' . $rspta->monto_pago . '</b> por concepto de <b>"' . $rspta->horas . ' Horas impartidas de clase"</b>.</p>
			<br>
			<p><b>Firmas</b></p>
			<br>
			<div class="mitad">C. ' . $rspta->nombre . '</div>
			<div class="mitad">L.C Angel Leonardo Aguilar Ochoa</div>		
		</div>
	</div>';

require_once  dirname(__DIR__,2) . '/vendor/mpdf/mpdf/mpdf.php';

$mpdf = new \mPDF('', '', 0, '', 0, 0, 5, 0);
/**
 * @brief  Se cargan las hojas de estilo y los archivos js al html y se define el nombre cuando se descargue al oordenador
 */
$css = file_get_contents('css/estilos_impresion_ticket.css');
$css2 = file_get_contents('css/materialize.min.css');
$mpdf->writeHTML($css2, 1);
$mpdf->writeHTML($css, 1);

$mpdf->writeHTML($html);
$mpdf->Output('reciboHonorarios.pdf', 'I');
?>