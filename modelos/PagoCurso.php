<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Incluímos inicialmente la conexión a la base de datos
require dirname(__DIR__, 1) . "/config/Conexion.php";

Class PagoCurso {

    //Implementamos nuestro constructor
    public function __construct() {
        
    }

    public function corte_caja($fecha_inicio, $fecha_fin) {
        $sql = "SELECT pc.ID as ID_PAGO, a.id as matricula, CONCAT(a.nombre,' ', a.apellidoP, ' ',a.apellidoM) as nombre, a.beca, n.CURSO, n.COSTO, 
	ga.FECHA_INICIO,CONCAT(ag.ID_GRUPO,'-',n.CURSO,'-',n.NOMBRE) as nivel, pc.FECHA_PAGO as fecha_pago , pc.TOTAL_PAGAR, pc.TOTAL_PAGAR as monto_pago, pc.FORMA_PAGO,pc.status
	FROM alumnos a
	INNER JOIN alumnos_grupos_activos ag on a.id=ag.ID_ALUMNO 
	INNER JOIN grupos_activos ga on ag.ID_GRUPO=ga.ID_GRUPO 
	INNER JOIN niveles n on ga.ID_NIVEL=n.ID
	INNER JOIN pago_cursos pc on a.id=pc.ID_ALUMNO and ga.ID_GRUPO=pc.ID_GRUPO and ga.ID_NIVEL=pc.ID_NIVEL
	WHERE (pc.FECHA_PAGO BETWEEN '$fecha_inicio' AND '$fecha_fin') 
            AND
              (pc.status = 1)
        ORDER BY pc.FECHA_PAGO";

        return ejecutarConsulta($sql);
    }

    //Implementamos un método para insertar registros
    public function insertar($id_alumno, $id_grupo_activo, $id_nivel, $fecha_pago, $monto_pago, $status, $forma_pago) {
        $sql = "INSERT INTO pago_cursos (id_alumno,id_grupo_activo,id_nivel,fecha_pago,monto_pago,status,FORMA_PAGO)
		VALUES ('$id_alumno','$id_grupo_activo',$id_nivel,'$fecha_pago',$monto_pago,0,'$forma_pago')";

        return ejecutarConsulta($sql);
    }

    //Implementamos un método para cambiar estatus de pago a "pagado".
    public function pagar($id, $fecha_pago, $forma_pago) {
        $sql = "UPDATE pago_cursos SET status=1,fecha_pago='$fecha_pago',FORMA_PAGO='$forma_pago' WHERE ID='$id'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para estatus de pago a "adeudo".
    public function cancelar_pago($id) {
        $sql = "UPDATE pago_cursos SET status=0,fecha_pago='',FORMA_PAGO='' WHERE id='$id'";

        return ejecutarConsulta($sql);
    }

    public function actualizar_pago($id, $semanasDeRetraso, $totalRetraso, $costo, $totalAPagar, $descuento) {
        $sql = "UPDATE pago_cursos SET SEMANAS_RETRASO='$semanasDeRetraso',
		RECARGOS='$totalRetraso', COSTO_NIVEL=".$costo.",
		TOTAL_PAGAR='$totalAPagar', DESCUENTO='$descuento'
		WHERE ID=".$id." and status=0";

        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function listar_pagos($status) {
        $sql = "SELECT pc.ID as ID_PAGO, a.id as matricula, CONCAT(a.nombre,' ', a.apellidoP, ' ',a.apellidoM) as nombre, a.beca, n.CURSO, n.COSTO, 
	ga.FECHA_INICIO,CONCAT(ag.ID_GRUPO,'-',n.CURSO,'-',n.NOMBRE) as nivel, pc.FECHA_PAGO, pc.FECHA_PAGO as fecha_pago , pc.TOTAL_PAGAR, pc.TOTAL_PAGAR as monto_pago, pc.FORMA_PAGO,pc.status
	FROM alumnos a
	INNER JOIN alumnos_grupos_activos ag on a.id=ag.ID_ALUMNO 
	INNER JOIN grupos_activos ga on ag.ID_GRUPO=ga.ID_GRUPO 
	INNER JOIN niveles n on ga.ID_NIVEL=n.ID
	INNER JOIN pago_cursos pc on a.id=pc.ID_ALUMNO and ga.ID_GRUPO=pc.ID_GRUPO and ga.ID_NIVEL=pc.ID_NIVEL
	WHERE pc.status = '$status'";

        return ejecutarConsulta($sql);
    }

    function semanas_retraso($date1) {
        $date2 = date("Y-m-d H:i:s");
        $datetime1 = new DateTime($date1);
        $datetime2 = new DateTime($date2);
        $interval = $datetime1->diff($datetime2);

        return floor(($interval->format('%a') / 7));
    }

    function obtener_descuento($costo, $beca) {

        return $beca != 0 ? ($costo * $beca) / 100 : 0;
    }

    function obtener_retraso($semanas_retraso) {

        return $semanas_retraso * 50;
    }

    function obtener_total($costo, $retraso, $descuento) {

        return ($costo + $retraso) - $descuento;
    }

    //Implementar un método para listar los registros
    public function listar_pago($id) {
        $sql = "SELECT pc.ID as ID_PAGO, a.id as matricula, CONCAT(a.nombre,' ', a.apellidoP, ' ',a.apellidoM) as nombre, a.beca, n.CURSO, n.COSTO, 
	ga.FECHA_INICIO,CONCAT(ag.ID_GRUPO,'-',n.CURSO,'-',n.NOMBRE) as nivel, pc.FECHA_PAGO, pc.FECHA_PAGO as fecha_pago , pc.TOTAL_PAGAR, pc.TOTAL_PAGAR as monto_pago, pc.FORMA_PAGO,pc.status
	FROM alumnos a
	INNER JOIN alumnos_grupos_activos ag on a.id=ag.ID_ALUMNO 
	INNER JOIN grupos_activos ga on ag.ID_GRUPO=ga.ID_GRUPO 
	INNER JOIN niveles n on ga.ID_NIVEL=n.ID
	INNER JOIN pago_cursos pc on a.id=pc.ID_ALUMNO and ga.ID_GRUPO=pc.ID_GRUPO and ga.ID_NIVEL=pc.ID_NIVEL
	WHERE pc.ID = '$id'";

        return ejecutarConsultaSimpleFila($sql);
    }

}
