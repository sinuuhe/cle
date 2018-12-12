<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Convenio
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($id,$nombre,$desMensualidad,$desInscripcion)
	{
		$sql="INSERT INTO convenios (ID,NOMBRE,DES_MENSUALIDAD,DES_INSCRIPCION)
		VALUES ($id,'$nombre',$desMensualidad,$desInscripcion)";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id,$nombre,$desMensualidad,$desInscripcion)
	{
		$sql="UPDATE convenios SET NOMBRE = '$nombre',DES_MENSUALIDAD = $desMensualidad, DES_INSCRIPCION = $desInscripcion WHERE id=$id";
		
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id)
	{
		$sql="SELECT * FROM convenios WHERE id=$id";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM convenios";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function eliminar($id)
	{
		$sql="delete from convenios WHERE id=$id";
		return ejecutarConsulta($sql);		
	}
}

?>