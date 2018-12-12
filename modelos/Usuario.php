<?php

//Incluímos inicialmente la conexión a la base de datos
require dirname(__DIR__, 1) . "/config/Conexion.php";

Class Usuario {

    //Implementamos nuestro constructor
    public function __construct() {
        
    }

    //Implementamos un método para desactivar categorías
    public function desactivar($idusuario) {
        $sql = "UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para activar categorías
    public function activar($idusuario) {
        $sql = "UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario'";
        
        return ejecutarConsulta($sql);
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idusuario) {
        $sql = "SELECT * FROM usuario WHERE idusuario='$idusuario'";
        
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar un método para listar los registros
    public function listar() {
        $sql = "SELECT * FROM usuario";
        return ejecutarConsulta($sql);
    }
    public function verificarR($user, $pass){
        $sql = "SELECT sede,id,password, foto, CONCAT(nombre,' ',apellidoP) as nombre FROM administrativos WHERE id = '$user' AND password = '$pass' AND status = 1";
        
        return ejecutarConsulta($sql);
    }
     public function verificarA($user, $pass){
        $sql = "SELECT sede,id,password, foto, CONCAT(nombre,' ',apellidoP) as nombre FROM alumnos WHERE id = '$user' AND password = '$pass' AND status = 1";
        
        return ejecutarConsulta($sql);
    }
     public function verificarP($user, $pass){
        $sql = "SELECT sede,id,password, foto, CONCAT(nombre,' ',apellidoP) as nombre FROM personal WHERE id = '$user' AND password = '$pass' AND status = 1";
        
        return ejecutarConsulta($sql);
    }
     public function verificarM($user, $pass){
        $sql = "SELECT sede,id,password, foto, CONCAT(nombre,' ',apellidoP) as nombre FROM maestros WHERE id = '$user' AND password = '$pass' AND status = 1";
        
        return ejecutarConsulta($sql);
    }
}

?>