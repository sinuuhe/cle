<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Incluímos inicialmente la conexión a la base de datos
require dirname(__DIR__, 1) . "/config/Conexion.php";

Class PagoNomina {

   
    //Implementamos nuestro constructor
    public function __construct() {
        
    }

    //Implementamos un método para insertar registros
    public function insertar($id_alumno, $id_grupo_activo, $id_nivel, $fecha_pago, $monto_pago, $status, $forma_pago) {
        $sql = "INSERT INTO pago_nomina (id_alumno,id_grupo_activo,id_nivel,fecha_pago,monto_pago,status,FORMA_PAGO)
		VALUES ('$id_alumno','$id_grupo_activo',$id_nivel,'$fecha_pago',$monto_pago,0,'$forma_pago')";
        return ejecutarConsulta($sql);
    }
    
   

    //Implementamos un método para cambiar estatus de pago a "pagado".
    public function pagar($id, $fecha_pago) {
        $sql = "UPDATE pago_nomina SET status=1,fecha_pago='$fecha_pago' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para estatus de pago a "adeudo".
    public function cancelar_pago($id) {
        $sql = "UPDATE pago_nomina SET status=0,fecha_pago='' WHERE id='$id'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function listar_pagos($status,$semana) {
        $sql = "SELECT pn.horas_trabajadas,m.fecha_ingreso,m.id as matricula,CONCAT(m.nombre, ' ', m.apellidoP, ' ', m.apellidoM) AS nombre,ga.ID_GRUPO, pn.monto_pago, pn.status,pn.fecha_pago, pn.id, pn.semana,pn.grupo
        FROM maestros m 
        INNER JOIN grupos_activos ga on ga.ID_MAESTRO=m.id 
        INNER JOIN niveles n on ga.ID_NIVEL=n.ID 
        INNER JOIN pago_nomina pn on m.id=pn.id_maestro and ga.ID_GRUPO=pn.id_grupo
        WHERE pn.status = '$status' AND pn.semana='$semana'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function listar_pago($id) {
        $sql = "SELECT pn.horas_trabajadas,m.fecha_ingreso,m.id as matricula,CONCAT(m.nombre, ' ', m.apellidoP, ' ', m.apellidoM) AS nombre,ga.ID_GRUPO, pn.monto_pago, pn.status,pn.fecha_pago, pn.id, pn.semana,pn.grupo
        FROM maestros m 
        INNER JOIN grupos_activos ga on ga.ID_MAESTRO=m.id 
        INNER JOIN niveles n on ga.ID_NIVEL=n.ID 
        INNER JOIN pago_nomina pn on m.id=pn.id_maestro and ga.ID_GRUPO=pn.id_grupo
        WHERE pn.status = '$status' WHERE pe.id = '$id'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function obtenerAntiguedad($fecha) {
        list($Y, $m, $d) = explode("-", $fecha);
        return( date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y );
    }

    public function obtenerCostoHora($antiguedad) {
        $precio_hora;
        switch ($antiguedad) {
            case $antiguedad > 0 && $antiguedad < 1:
                $precio_hora = 60;
                break;
            case $antiguedad > 1 && $antiguedad < 2:
                $precio_hora = 65;
                break;
            case $antiguedad > 2:
                $precio_hora = 70;
                break;
        }
        return $precio_hora;
    }
    
    public function obtenerNumSemana($fecha){
        $num_semana = date("W", strtotime($fecha));
                
        return $num_semana;
    }
    
    public function obtenerSemanaInicio($fecha){
        $semana=date("W", strtotime($fecha));
        $semana_obj = new DateTime();
        $semana_obj->setISODate(2018,$semana);
        $semana_start= $semana_obj->format('d-m-Y');
        
        return $semana_start;
    }
    
    public function obtenerSemanaFin($fecha){
        $semana=date("W", strtotime($fecha));
        $semana_obj = new DateTime();
        $semana_obj->setISODate(2018,$semana,7);
        $semana_final= $semana_obj->format('d-m-Y');
        
        return $semana_final;
    }
}
