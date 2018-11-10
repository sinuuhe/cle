<?php 
$obj=null;
$nivel=null;
$mes=null;

switch ($_POST["formato"]) {
    case "pago_extra":
        require_once dirname(__DIR__, 2) . "/modelos/PagoExtras.php";
        $obj= new PagoExtras();
        $mes='Pago de extra del mes de ';
        break;
    case "pago_libro":
        require_once dirname(__DIR__, 2) . "/modelos/PagoLibro.php";
        $obj= new PagoLibro();
        $mes='Pago de libro en el mes de ';
        break;
    case "pago_curso":
        require_once dirname(__DIR__, 2) . "/modelos/PagoCurso.php";
        $obj= new PagoCurso();
        $mes='Pago del curso del mes de ';
        break;
    case "pago_inscripcion":
        require_once dirname(__DIR__, 2) . "/modelos/PagoInscripcion.php";
        $obj= new PagoInscripcion();
        $nivel="Inscripción nuevo nivel";
        $mes='Pago de inscripción del mes de ';
        break;
    default:
        break;
}

$id=isset($_POST["idpago"])? limpiarCadena($_POST["idpago"]):"";
$concepto=isset($_POST["concepto"])? limpiarCadena($_POST["concepto"]):"";
$rspta=$obj->listar_pago($id);
$nivel=$rspta->nivel?$rspta->nivel:$nivel;
$mes=$mes.strftime("%B",strtotime($rspta->fecha_pago));
$campo=$rspta->libro?"Libro: ":"Curso: ";
$campo1=$rspta->libro?$rspta->libro:$nivel;
$html  =  '<div class="tamano">
		<div class="row">

			<div class="col s6 m6 l6 xl6">
				<img class="responsive-img" src="img/logoBN.png" alt="CLE">
			</div>

			<div class="col s6 m6 l6 xl6">
				<p class="center-align"><b>Ticket de pago</b></p>
			</div>

			<div class="col s12 m12 l12 xl12 sinEspacioParrafo">
				<p><b>Nombre:</b></p>
			</div>

			<div class="col s12 m12 l12 xl12">
				<p class="sinEspacio">'.$rspta->nombre.'</p>
			</div>

			<div class="col s12 m12 l12 xl12 sinEspacioParrafo">
				<p><b>Fecha de pago:</b></p>
			</div>

			<div class="col s12 m12 l12 xl12">
				<p class="sinEspacio">'.$rspta->fecha_pago.'</p>
			</div>

			<div class="col s12 m12 l12 xl12 sinEspacioParrafo">
				<p><b>Monto:</b></p>
			</div>

			<div class="col s12 m12 l12 xl12">
				<p class="sinEspacio">$'.$rspta->monto_pago.'</p>
			</div>

			<div class="col s12 m12 l12 xl12 sinEspacioParrafo">
				<p><b>Forma de pago:</b></p>
			</div>

			<div class="col s12 m12 l12 xl12">
				<p class="sinEspacio">'.$rspta->FORMA_PAGO.'</p>
			</div>

			<div class="col s12 m12 l12 xl12 sinEspacioParrafo">
				<p><b>Concepto:</b></p>
			</div>

			<div class="col s12 m12 l12 xl12">
				<p class="sinEspacio">'.$concepto.'</p>
			</div>

			<div class="col s12 m12 l12 xl12 sinEspacioParrafo">
				<p><b>Definición:</b></p>
			</div>

			<div class="col s12 m12 l12 xl12">
				<p class="sinEspacio">'.$mes.'</p>
			</div>

			<div class="col s12 m12 l12 xl12 sinEspacioParrafo">
				<p><b>Queda a deber:</b></p>
			</div>

			<div class="col s12 m12 l12 xl12">
				<p class="sinEspacio">$0.00</p>
			</div>

			<div class="col s12 m12 l12 xl12 sinEspacioParrafo">
				<p><b>'.$campo.'</b></p>
			</div>

			<div class="col s12 m12 l12 xl12">
				<p class="sinEspacio">'.$campo1.'</p>
			</div>

			<div class="col s12 m12 l12 xl12 sinEspacioParrafo">
				<p class="center-align"><b>*************************</b></p>
			</div>

			<div class="col s12 m12 l12 xl12 sinEspacioParrafo">
				<p class="center-align">FIRMAS DE CONFORMIDAD</p>
			</div>

			<div class="col s12 m12 l12 xl12 abajo">
				<p class="parrafo">PAGA</p>
				<p>RECIBE</p>
			</div>

			<div class="col s12 m12 l12 xl12 sinEspacioParrafo">
				<p class="center-align"><b>*************************</b></p>
			</div>

		</div>
	</div>';
	require_once  dirname(__DIR__,2) . '/vendor/mpdf/mpdf/mpdf.php';

	$mpdf = new \mPDF('','',0,'',0,0,0,0);
	
        $css =file_get_contents('css/estilos_impresion_ticket.css');
	$css2 =file_get_contents('css/materialize.min.css');
	$mpdf->writeHTML($css2,1);
	$mpdf->writeHTML($css,1);
        
	$mpdf->writeHTML($html);
	$mpdf->Output('ticket.pdf', 'I');
        exit();
 ?>