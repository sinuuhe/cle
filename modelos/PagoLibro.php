<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Incluímos inicialmente la conexión a la base de datos
require dirname(__DIR__, 1) . "/config/Conexion.php";

Class PagoLibro {

    //Implementamos nuestro constructor
    public function __construct() {
        
    }

    public function corte_caja($fecha_inicio, $fecha_fin) {
        $sql = "SELECT CONCAT(a.id,' - ',a.nombre,' ',a.apellidoP) as nombre, l.nombre as libro, l.COSTO as monto_pago, pl.FECHA_PAGO as fecha_pago,pl.FORMA_PAGO as forma_pago,pl.ID as id 
                FROM libros l 
                INNER JOIN pago_libros pl on pl.ID_LIBRO = l.id 
                INNER JOIN alumnos a on pl.ID_ALUMNO = a.id
	WHERE (pl.FECHA_PAGO BETWEEN '$fecha_inicio' AND '$fecha_fin') 
        ORDER BY pl.FECHA_PAGO";

        return ejecutarConsulta($sql);
    }

    public function listar_libros() {
        $sql = "SELECT * FROM libros";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para insertar registros
    public function insertar($id_alumno, $id_grupo_activo, $id_nivel, $fecha_pago, $monto_pago, $status, $forma_pago) {
        $sql = "INSERT INTO pago_cursos (id_alumno,id_grupo_activo,id_nivel,fecha_pago,monto_pago,status,FORMA_PAGO)
		VALUES ('$id_alumno','$id_grupo_activo',$id_nivel,'$fecha_pago',$monto_pago,0,'$forma_pago')";

        return ejecutarConsulta($sql);
    }

    //Implementamos un método para cambiar estatus de pago a "pagado".
    public function pagar($fecha_pago, $id_alumno, $id_libro, $costo_libro, $forma_pago) {
        $sql = "INSERT INTO pago_libros (ID_ALUMNO,TOTAL_PAGO,ID_LIBRO,FECHA_PAGO,FORMA_PAGO) VALUES ('$id_alumno',$costo_libro,'$id_libro','$fecha_pago','$forma_pago')";

        return ejecutarConsulta($sql);
    }

    //Implementamos un método para estatus de pago a "adeudo".
    public function cancelar_pago($id) {
        $sql = "UPDATE pago_cursos SET status=0,fecha_pago='',FORMA_PAGO='' WHERE id='$id'";

        return ejecutarConsulta($sql);
    }

    public function actualizar_pago($id, $semanasDeRetraso, $totalRetraso, $costo, $totalAPagar, $descuento) {
        $sql = "UPDATE pago_cursos SET SEMANAS_RETRASO=$semanasDeRetraso,
		RECARGOS=$totalRetraso, COSTO_NIVEL=" . $costo . ",
		TOTAL_PAGAR=$totalAPagar, DESCUENTO=$descuento
		WHERE ID=" . $id . "and status=0";

        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function listar_pagos() {
        $sql = "SELECT CONCAT(a.id,' - ',a.nombre,' ',a.apellidoP) as alumno, "
                . "l.nombre as libro, "
                . "l.COSTO as total_pago, "
                . "pl.FECHA_PAGO as fecha_pago,"
                . "pl.FORMA_PAGO as forma_pago,"
                . "pl.ID as id "
                . "FROM libros l "
                . "INNER JOIN pago_libros pl on pl.ID_LIBRO = l.id "
                . "INNER JOIN alumnos a on pl.ID_ALUMNO = a.id";

        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function listar_pago($id) {
        $sql = "SELECT  CONCAT(a.nombre, ' ', a.apellidoP, ' ', a.apellidoM) AS nombre, pl.TOTAL_PAGO as monto_pago,pl.FECHA_PAGO as fecha_pago,
            pl.FORMA_PAGO, l.nombre as libro
            FROM alumnos a 
            INNER JOIN pago_libros pl on a.id=pl.ID_ALUMNO
            INNER JOIN libros l on l.id=pl.ID_LIBRO
            WHERE pl.ID = '$id'";

        return ejecutarConsultaSimpleFila($sql);
    }

}
