<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Libro
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
    public function insertar($id,$clave,$nombre,$costo,$cantidad)
	{
		
		$sql="INSERT INTO libros (id,clave,nombre,costo,cantidad)
		VALUES ($id,'$clave','$nombre',$costo,$cantidad)";
		echo $sql;
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id,$clave,$nombre,$costo,$cantidad)
	{
		$sql="UPDATE libros SET clave = '$clave', nombre = '$nombre',costo = $costo,cantidad = $cantidad WHERE id=$id";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function eliminar($id)
	{
		$sql="delete from libros WHERE id=$id";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id)
	{
		$sql="SELECT * FROM libros WHERE id=$id";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM libros";
		return ejecutarConsulta($sql);		
	}
}

?>