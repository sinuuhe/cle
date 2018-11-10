<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Nivel
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function obtenerCantidad(){
		$sql="SELECT * FROM niveles";
		$result = ejecutarConsulta($sql);	
		return $result -> num_rows + 1; 
	}

	//Implementamos un método para insertar registros
	public function insertar($id,$nombre,$curso,$duracion,$material_libro,$costo,$inscripcion,$documento)
	{
		
		$sql="INSERT INTO niveles (ID,NOMBRE,CURSO,DURACION,MATERIAL_LIBRO,COSTO,INSCRIPCION,DOCUMENTO)
		VALUES ($id,'$nombre','$curso',$duracion,'$material_libro',$costo,$inscripcion,'$documento')";
		
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id,$nombre,$curso,$duracion,$material_libro,$costo,$inscripcion,$documento)
	{
		$sql="UPDATE niveles SET ID = '$id',NOMBRE = '$nombre',CURSO = '$curso',DURACION = $duracion,COSTO = $costo,INSCRIPCION = '$inscripcion',DOCUMENTO = '$documento' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function eliminar($id)
	{
		$sql="delete from niveles WHERE ID='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id)
	{
		$sql="SELECT * FROM niveles WHERE id='$id'";
		
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM niveles";
		return ejecutarConsulta($sql);		
	}
}

?>