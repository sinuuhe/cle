<?php

require_once dirname(__DIR__, 2) . "/modelos/PagoInscripcion.php";
$obj = new PagoInscripcion();

//Se recibe por POST las variable: idpagoinscripcion
$id = isset($_POST["idpago"]) ? limpiarCadena($_POST["idpago"]) : "";
$rspta = $obj->listar_pago($id);

//Se reciben por POST las siguientes varibales:
//NombreAlumno, Calle, Numero, Colonia, Municipio, TelLocal, Celular, FechaNacimineto,
//Email, FormaContacto, TotalInscripcion, NombreQuienInscribe, Matricula, ContrasenaPlataforma,
//Grupo, esta variable solo en caso de que el alumno haya escogido grupo al momento de la inscripcion
//La variable "Grupo" debe ser un arreglo con los siguientes datos: 0.NombreCurso(Ej. Ingles basico1),
//1.Dias(Ej. Lunes a viernes), 2.Horario(Ej. 7pm-8pm), 3.Sede (Ej. Matriz), 4.Profesor(Es el profesor asignado a ese grupo),
//5.CostoMensualidad( esto es el costo del curso)
//La varibale "NombreQuienInscribe" se refiere a la secretaria que lo inscribio
session_start();
$grupo = $_POST["Grupo"];
$html = '<div class="container row">
		<div class="col s6 m6 l6 xl6">
			<img class="img-5x" src="img/logoBN.png" alt="CLE">
		</div>

		<div class="col s6 m6 l6 xl6 right-align">
			<h6><b>Fecha:</b>'. $rspta->fecha_pago .'</h6>
		</div>

		<div class="col s12 m12 l12 xl12 center-align">
			<h5>FORMATO DE INSCRIPCIÓN</h5>
			<p class="parrafo-linea">Datos del alumno</p>
		</div>

		<div class="col s12 m12 l12 xl12">
			<p><b>Nombre del(a) alumno(a):</b> ' . $rspta->nombre . '</p>
			<div class="mitad"><b>Calle:</b> ' . $rspta->calle . '</div>
			<div class="mitad"><b>Numero:</b> ' . $rspta->numero . '</div>
			<div class="mitad"><b>Colonia:</b> ' . $rspta->colonia . '</div>
			<div class="mitad"><b>Municipio:</b> ' . $rspta->municipio . '</div>
			<div class="mitad"><b>Tel.Local:</b> ' . $rspta->telefono . '</div>
			<div class="mitad"><b>Celular:</b> ' . $rspta->celular . '</div>
			<div class="mitad"><b>Fecha de nacimineto:</b> ' . $rspta->fecha_nacimiento . '</div>
			<div class="mitad"><b>Email:</b> ' . $rspta->email . '</div>
			<p class="col s12 m12 l12 xl12"><b>Forma de contacto:</b>PENDIENTE</p>
		</div>

		<div class="col s12 m12 l12 xl12 center-align">
			<p class="parrafo-linea">Información del curso</p>
			<table class="centered striped">
		        <thead>
		          <tr>
		              <th>Curso</th>
		              <th>Dia(s) y horario(s)</th>
		              <th>Sede</th>
		              <th>Profesor</th>
		              <th>Mensualidad</th>
		          </tr>
		        </thead>

		        <tbody>
		          <tr>
		            <td>' . $grupo[0] . '</td>
		            <td>' . $grupo[1] . '-' . $grupo[2] . '</td>
		            <td>' . $grupo[3] . '</td>
		            <td>' . $grupo[4] . '</td>
		            <td>' . $grupo[5] . '</td>
		          </tr>
		        </tbody>
		    </table>
		</div>
		<br>

		<div class="col s12 m12 l12 xl12 center-align">
			<div class="mitad"><b>Pago de inscripcion:</b> $ ' . $rspta->total_pago . '</div>
			<div class="mitad"><b>Nombre de quien inscribe:</b> ' . $_SESSION['nombre'] . '</div>
		</div>

		<div class="col s12 m12 l12 xl12 center-align">
			<p class="parrafo-linea">Datos de la plataforma</p>
			<br>
			<div class="mitad"><b>Usuario/Matricula:</b> ' . $rspta->matricula . '</div>
			<div class="mitad"><b>Contraseña:</b> ' . $rspta->password . '</div>
			<p class="col"><b>URL Plataforma: </b> https://clemorelia.com.mx/plataforma</p>
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
$mpdf->Output('Incripcion.pdf', 'I');
?>