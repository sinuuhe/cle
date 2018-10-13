<?php 
require_once "../modelos/Convenios.php";

$convenio=new Convenio();


switch ($_GET["op"]){
	case 'guardaryeditar':

	break;

	case 'cancelar_pago':

	break;

	case 'pagar':

	break;

	case 'mostrar':

	break;

	case 'listar':
		$rspta=$convenio->listar();
 		//Vamos a declarar un array
 		$data= Array();
         
 		while ($reg=$rspta->fetch_assoc()){
 			$data[]=array(
                "id" =>$reg["ID"], 
				 "nombre"=>$reg["NOMBRE"],
				 "des_mensualidad"=>$reg["DES_MENSUALIDAD"]
 				);
         }
         echo json_encode($data);
	break;
}
?>