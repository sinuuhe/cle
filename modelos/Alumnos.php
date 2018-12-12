<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Alumno
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function obtenerCantidad(){
		$sql="SELECT * FROM alumnos";
		$result = ejecutarConsulta($sql);	
		return $result -> num_rows + 1; 
	}

	//Implementamos un método para insertar registros
	public function insertar($id,$nombre,$apellidoP,$apellidoM,$calle,$colonia,$numero,$municipio,$telefono,$celular,$email,$fecha_nacimiento,$fecha_ingreso,$foto,$empresa,$beca,$password,$sede)
	{
		
		$sql="INSERT INTO alumnos (id,nombre,apellidoP,apellidoM,calle,colonia,numero,municipio,telefono,celular,email,fecha_nacimiento,
        fecha_ingreso,foto,status,empresa,beca,password,sede)
		VALUES ('$id','$nombre','$apellidoP','$apellidoM','$calle','$colonia','$numero','$municipio','$telefono',$celular,'$email',
		'$fecha_nacimiento','$fecha_ingreso','$foto',1,'$empresa',$beca,'$password',$sede)";
		
		return ejecutarConsulta($sql);
	}

	public function obtenerIdNivel($idGrupo){
		$sql = "SELECT ID_NIVEL as id_nivel FROM grupos_activos WHERE ID_GRUPO = '$idGrupo'";
		$idNivel = ejecutarConsultaSimpleFila($sql);
		return $idNivel -> id_nivel;
	}

	public function inscribirAlumno($id_grupo, $id_alumno)
	{
		//Checar si existe en tabla alumnos_grupos_activos para actualizar o insertar.
		//$sql = "SELECT * FROM alumnos_grupos_activos WHERE ID_ALUMNO = '$id_alumno'";
		//$existe_en_grupos = ejecutarConsultaSimpleFila($sql);
//
		//if(!$existe_en_grupos)
		//{
		//	$sql = "INSERT INTO alumnos_grupos_activos (id, ID_GRUPO, ID_ALUMNO, CALIFICACION, STATUS)
		//		VALUES ( null,'$id_grupo', '$id_alumno', 0, 'Normal')";
//
			//$nivelId = self::obtenerIdNivel($id_grupo);
		
		//	$sqlPagos = "INSERT INTO pago_cursos VALUES (NULL, '$id_alumno', '$id_grupo', $nivelId,0,0,0,0,'','',0);";
		//	echo $sqlPagos;
		//	ejecutarConsulta($sqlPagos);
		//}
		//else
		//{
		//	$sql = "UPDATE alumnos_grupos_activos 
		//			SET ID_GRUPO = '$id_grupo', CALIFICACION = 0, STATUS = 'Normal'
		//			WHERE ID_ALUMNO = '$id_alumno'";
		//}

		//return ejecutarConsulta($sql);
	}

	public function dejarGrupos($id_alumno)
	{
		// Borrar la relacion
		$sql = "DELETE FROM alumnos_grupos_activos 
				WHERE ID_ALUMNO = '$id_alumno'";
		
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id,$nombre,$apellidoP,$apellidoM,$calle,$colonia,$numero,$municipio,$telefono,$celular,$email,$fecha_nacimiento,$fecha_ingreso,$foto,$status,$empresa,$beca,$password,$sede)
	{
		$sql="UPDATE alumnos SET nombre = '$nombre',apellidoP = '$apellidoP',apellidoM = '$apellidoM',calle = '$calle',colonia = '$colonia',numero = '$numero',municipio = '$municipio',telefono = '$telefono',celular = '$celular',email = '$email',fecha_nacimiento = '$fecha_nacimiento',fecha_ingreso = '$fecha_ingreso',status = '$status',empresa = '$empresa' ,beca = '$beca',password = '$password',sede = '$sede' WHERE id='$id'";
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
		$sql="UPDATE alumnos SET status='0' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	public function alta($id)
	{
		$sql="UPDATE alumnos SET status='1' WHERE id='$id'";
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
		$sql= "SELECT  a.*, aga.ID_GRUPO AS id_grupo FROM alumnos a LEFT JOIN alumnos_grupos_activos aga ON a.id = aga.ID_ALUMNO WHERE a.id='$id'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM alumnos";
		return ejecutarConsulta($sql);		
	}

	public function listarGrupos()
	{
		//Obtener grupos activos con nombres de maesto
		$sql = "SELECT 
			ga.ID_GRUPO, 
			CONCAT(m.nombre,' ',m.apellidoP,' ',m.apellidoM) AS nombre_maestro,
			ga.HORARIO_ENTRADA, 
			ga.HORARIO_SALIDA 
			FROM grupos_activos ga 
			INNER JOIN maestros m 
				on ga.ID_MAESTRO = m.id;";

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