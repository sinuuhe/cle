<?php
/* 
 * I.S.C. Heriberto Orozco Rocha
 * GHOPAR  * 
 */
require_once 'Conexion.php';

$fecha=date("Y-m-d H:i:s");
$week=date("W");

function calculaAntiguedad($fecha) {
    list($Y,$m,$d) = explode("-",$fecha);
    return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}

function calculaCostoHora($antiguedad){
    $precio_hora;
    switch($antiguedad){
        case $antiguedad < 1:
            $precio_hora=60;
        break;
        case $antiguedad >= 1 && $antiguedad < 2:
            $precio_hora=65;
        break;
        case $antiguedad>=2:
            $precio_hora=70;
        break;
    }
    return $precio_hora;
}
 
$query = "SELECT ga.ID_MAESTRO,ga.ID_GRUPO, GROUP_CONCAT(CONCAT(ga.ID_GRUPO,' - ',n.Curso,' ',n.NOMBRE)) as grupo,sum(cast(time_to_sec(SEC_TO_TIME((UNIX_TIMESTAMP(ga.HORARIO_SALIDA) - UNIX_TIMESTAMP(ga.HORARIO_ENTRADA)))) / (60 * 60) as decimal(10, 1))*ga.NUM_DIAS) AS horastrabajadas,CONCAT(m.nombre,' ',m.apellidoP,' ',m.apellidoM) as nombre, m.fecha_ingreso FROM grupos_activos ga INNER JOIN maestros m on m.id=ga.ID_MAESTRO INNER JOIN niveles n on n.ID=ga.ID_NIVEL GROUP BY ga.ID_MAESTRO";

if($result= $conexion -> query($query)){
     echo "Consulta realizada con exito";
}else{
     echo " Error updating record: " . $con->error;
     exit();
}

while ($row = $result->fetch_array(MYSQLI_ASSOC)){
    $antiguedad=calculaAntiguedad($row['fecha_ingreso']);
    $precio_hora= calculaCostoHora($antiguedad);
    $monto_pago= $precio_hora*$row['horastrabajadas'];
    //echo  '\nFecha Ingreso: '.$row['fecha_ingreso'].'\nAntiguedad: '.$antiguedad.'\n Precio Hora: '.$precio_hora.'\n monto_pago: '.$monto_pago;
   
    $insert = "INSERT INTO pago_nomina VALUES (null,$week,'".$row['ID_GRUPO']."','".$row['ID_MAESTRO']."','".$row['grupo']."',".$row['horastrabajadas'].",$monto_pago,'$fecha',0)";
    if ($conexion->query($insert) === TRUE) {
        echo "Record updated successfully";
    }else{
        echo " Error updating record: " . $con->error;
         exit();
    }
}
