<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Maestro
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function obtenerCantidad(){
		$sql="SELECT * FROM maestros";
		$result = ejecutarConsulta($sql);	
		return $result -> num_rows + 1; 
	}

	//Implementamos un método para insertar registros
	public function insertar($id,$nombre,$apellidoP,$apellidoM,$telefono,$celular,$email,$fecha_nacimiento,$fecha_ingreso,$foto,$password,$sede)
	{
		
		$sql="INSERT INTO maestros (id,nombre,apellidoP,apellidoM,telefono,celular,email,fecha_nacimiento,
        fecha_ingreso,foto,status,password,sede)
		VALUES ('$id','$nombre','$apellidoP','$apellidoM','$telefono',$celular,'$email',
		'$fecha_nacimiento','$fecha_ingreso','$foto',1,'$password',$sede)";
		echo $sql;
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id,$nombre,$apellidoP,$apellidoM,$telefono,$celular,$email,$fecha_nacimiento,$fecha_ingreso,$foto,$password,$sede)
	{
		$sql="UPDATE maestros SET nombre = '$nombre',apellidoP = '$apellidoP',apellidoM = '$apellidoM',telefono = '$telefono',celular = '$celular',email = '$email',fecha_nacimiento = '$fecha_nacimiento',fecha_ingreso = '$fecha_ingreso',password = '$password',sede = '$sede' WHERE id='$id'";
		
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idcategoria)
	{
		$sql="UPDATE categoria SET condicion='0' WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function baja($id)
	{
		$sql="UPDATE maestros SET status='0' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	public function alta($id)
	{
		$sql="UPDATE maestros SET status='1' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idcategoria)
	{
		$sql="UPDATE categoria SET condicion='1' WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id)
	{
		$sql="SELECT * FROM maestros WHERE id='$id'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM maestros";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM convenios where condicion=1";
		return ejecutarConsulta($sql);		
	}

}

?>