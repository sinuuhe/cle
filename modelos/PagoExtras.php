<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Incluímos inicialmente la conexión a la base de datos
require dirname(__DIR__,1) . "/config/Conexion.php";

Class PagoExtras {

    //Implementamos nuestro constructor
    public function __construct() {
        
    }

    //Implementamos un método para insertar registros
    public function insertar($id_alumno, $id_grupo_activo, $id_nivel, $fecha_pago, $monto_pago, $status, $forma_pago) {
        $sql = "INSERT INTO pago_extras (id_alumno,id_grupo_activo,id_nivel,fecha_pago,monto_pago,status,FORMA_PAGO)
		VALUES ('$id_alumno','$id_grupo_activo',$id_nivel,'$fecha_pago',$monto_pago,0,'$forma_pago')";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para cambiar estatus de pago a "pagado".
    public function pagar($id, $fecha_pago, $forma_pago) {
        $sql = "UPDATE pago_extras SET status=1,fecha_pago='$fecha_pago',FORMA_PAGO='$forma_pago' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para estatus de pago a "adeudo".
    public function cancelar_pago($id) {
        $sql = "UPDATE pago_extras SET status=0,fecha_pago='',FORMA_PAGO='' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function listar_pagos($status) {
         $sql = "SELECT a.id AS matricula,CONCAT(a.nombre, ' ', a.apellidoP, ' ', a.apellidoM) AS nombre,aga.ID_GRUPO,CONCAT(n.CURSO,' - ' ,n.NOMBRE) AS nivel, pe.monto_pago, pe.status,pe.fecha_pago, pe.id, pe.FORMA_PAGO
            FROM alumnos a 
            INNER JOIN alumnos_grupos_activos aga on a.id=aga.ID_ALUMNO 
            INNER JOIN grupos_activos ga on ga.ID_GRUPO=aga.ID_GRUPO 
            INNER JOIN niveles n on ga.ID_NIVEL=n.ID
            INNER JOIN pago_extras pe on a.id=pe.id_alumno and ga.ID_GRUPO=pe.id_grupo_activo and ga.ID_NIVEL=pe.ID_NIVEL WHERE pe.status = '$status'";
        return ejecutarConsulta($sql);
    }

     //Implementar un método para listar los registros
    public function listar_pago($id) {
        $sql = "SELECT a.id AS matricula,CONCAT(a.nombre, ' ', a.apellidoP, ' ', a.apellidoM) AS nombre,aga.ID_GRUPO,CONCAT(n.CURSO,' - ' ,n.NOMBRE) AS nivel, pe.monto_pago, pe.status,pe.fecha_pago, pe.id, pe.FORMA_PAGO
            FROM alumnos a 
            INNER JOIN alumnos_grupos_activos aga on a.id=aga.ID_ALUMNO 
            INNER JOIN grupos_activos ga on ga.ID_GRUPO=aga.ID_GRUPO 
            INNER JOIN niveles n on ga.ID_NIVEL=n.ID
            INNER JOIN pago_extras pe on a.id=pe.id_alumno and ga.ID_GRUPO=pe.id_grupo_activo and ga.ID_NIVEL=pe.ID_NIVEL WHERE pe.id = '$id'";
        return ejecutarConsultaSimpleFila($sql);
    }
   

}
