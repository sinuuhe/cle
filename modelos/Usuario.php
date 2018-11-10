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

    //Función para verificar el acceso al sistema
    public function verificar($user, $pass) {
        $sql = "SELECT 
                    CONCAT(IFNULL(a.id,''),IFNULL(p.id,''),IFNULL(m.id,''),IFNULL(ad.id,'')) AS usuario,
                    CONCAT(IFNULL(a.nombre,''),IFNULL(p.nombre,''),IFNULL(m.nombre,''),IFNULL(ad.nombre,''),' ',
                           IFNULL(a.apellidoP,''),IFNULL(p.apellidoP,''),IFNULL(m.apellidoP,''),IFNULL(ad.apellidoP,'')) as nombre,
                    CONCAT(IFNULL(a.foto,''),IFNULL(p.foto,''),IFNULL(m.foto,''),IFNULL(ad.foto,'')) as imagen,
                    u.TIPO as permiso,
                    tu.PANEL as ruta
                FROM 
                    alumnos a
                    RIGHT JOIN usuarios u ON a.id=u.ID_USER 
                    LEFT JOIN maestros m ON m.id=u.ID_USER 
                    LEFT JOIN personal p ON p.id=u.ID_USER
                    LEFT JOIN administrativos ad ON ad.id=u.ID_USER
                    INNER JOIN tipo_user tu ON u.TIPO=tu.ID_TIPO_USER
                    WHERE u.ID_USER='$user' AND u.PASSWORD='$pass' AND u.STATUS = 1";
        
        return ejecutarConsulta($sql);
    }

}

?>