<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Personal
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function obtenerCantidad(){
		$sql="SELECT * FROM personal";
		$result = ejecutarConsulta($sql);	
		return $result -> num_rows + 1; 
	}

	//Implementamos un método para insertar registros
	public function insertar($id,$nombre,$apellidoP,$apellidoM,$telefono,$celular,$email,$fecha_nacimiento,$fecha_ingreso,$foto,$password,$sede,$puesto)
	{
		
		$sql="INSERT INTO personal (id,nombre,apellidoP,apellidoM,telefono,celular,email,fecha_nacimiento,
        fecha_ingreso,foto,status,password,sede,puesto)
		VALUES ('$id','$nombre','$apellidoP','$apellidoM','$telefono','$celular','$email',
        '$fecha_nacimiento','$fecha_ingreso','$foto',1,'$password',$sede,'$puesto')";
        echo $sql;
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id,$nombre,$apellidoP,$apellidoM,$telefono,$celular,$email,$fecha_nacimiento,$fecha_ingreso,$foto,$password,$sede)
	{
		$sql="UPDATE personal SET nombre = '$nombre',apellidoP = '$apellidoP',apellidoM = '$apellidoM',telefono = '$telefono',celular = '$celular',email = '$email',fecha_nacimiento = '$fecha_nacimiento',fecha_ingreso = '$fecha_ingreso',password = '$password',sede = '$sede', puesto = '$puesto' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function baja($id)
	{
		$sql="UPDATE personal SET status='0' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	public function alta($id)
	{
		$sql="UPDATE personal SET status='1' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id)
	{
		$sql="SELECT * FROM personal WHERE id='$id'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM personal";
		return ejecutarConsulta($sql);		
	}
}

?>