<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Incluímos inicialmente la conexión a la base de datos
require dirname(__DIR__, 1) . "/config/Conexion.php";

Class PagoInscripcion {

    //Implementamos nuestro constructor
    public function __construct() {
        
    }

    public function corte_caja($fecha_inicio, $fecha_fin) {
        $sql = "SELECT a.id as matricula, CONCAT(a.nombre, ' ', a.apellidoP, ' ', a.apellidoM) AS nombre, con.DES_INSCRIPCION, pi.monto_pago, pi.status,pi.fecha_pago, pi.descuento, pi.id, pi.total_pago, pi.FORMA_PAGO
            FROM alumnos a 
            INNER JOIN pago_inscripciones pi on a.id=pi.id_alumno 
            INNER JOIN convenios con on con.id=a.empresa
	WHERE (pi.fecha_pago BETWEEN '$fecha_inicio' AND '$fecha_fin') 
            AND
              (pi.status = 1)
        ORDER BY pi.fecha_pago";

        return ejecutarConsulta($sql);
    }

    //Implementamos un método para insertar registros
    public function insertar($id_alumno, $id_grupo_activo, $id_nivel, $fecha_pago, $monto_pago, $status, $forma_pago) {
        $sql = "INSERT INTO pago_inscripciones (id_alumno,id_grupo_activo,id_nivel,fecha_pago,monto_pago,status,FORMA_PAGO)
		VALUES ('$id_alumno','$id_grupo_activo',$id_nivel,'$fecha_pago',$monto_pago,0,'$forma_pago')";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para cambiar estatus de pago a "pagado".
    public function pagar($id, $fecha_pago, $forma_pago) {
        $sql = "UPDATE pago_inscripciones SET status=1,fecha_pago='$fecha_pago',FORMA_PAGO='$forma_pago' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para estatus de pago a "adeudo".
    public function cancelar_pago($id) {
        $sql = "UPDATE pago_inscripciones SET status=0,fecha_pago='',FORMA_PAGO='' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function listar_pagos($status) {
        $sql = "SELECT a.id as matricula, CONCAT(a.nombre, ' ', a.apellidoP, ' ', a.apellidoM) AS nombre, con.DES_INSCRIPCION, pi.monto_pago, pi.status,pi.fecha_pago, pi.descuento, pi.id, pi.total_pago, pi.FORMA_PAGO
            FROM alumnos a 
            INNER JOIN pago_inscripciones pi on a.id=pi.id_alumno 
            INNER JOIN convenios con on con.id=a.empresa
            WHERE pi.status = '$status'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function listar_pago($id) {
        $sql = "SELECT a.id as matricula, CONCAT(a.nombre, ' ', a.apellidoP, ' ', a.apellidoM) AS nombre,
            a.calle, a.numero, a.colonia, a.municipio, a.telefono,a.celular,a.fecha_nacimiento,a.email,a.password,
            pi.monto_pago, pi.status,pi.fecha_pago, pi.id, pi.total_pago, pi.FORMA_PAGO
            FROM alumnos a 
            INNER JOIN pago_inscripciones pi on a.id=pi.id_alumno 
            INNER JOIN convenios con on con.id=a.empresa
            WHERE pi.status = '1' AND pi.id='$id'";
        return ejecutarConsultaSimpleFila($sql);
    }

}
