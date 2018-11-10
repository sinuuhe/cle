<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
require "Alumnos.php";

Class Asistencia
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function obtenerCantidadDeClases($grupoId){
		$sql="SELECT NUM_DIAS * 4 as numClases FROM `grupos_activos` WHERE grupos_activos.ID_GRUPO = '$grupoId'";
		$result = ejecutarConsultaSimpleFila($sql);	
		return $result -> numClases; 
    }
    
    public function listarAlumnos($idGrupo)
	{
		$sql="select alumnos_grupos_activos.ID_ALUMNO , alumnos_grupos_activos.ID_GRUPO, concat (alumnos.nombre,' ',alumnos.apellidoP,' ',alumnos.apellidoM) as NOMBRE from alumnos_grupos_activos INNER JOIN alumnos on alumnos.id = alumnos_grupos_activos.ID_ALUMNO WHERE alumnos_grupos_activos.ID_GRUPO = '$idGrupo'";
		return ejecutarConsulta($sql);		
    }

	//Implementamos un método para insertar registros
	public function insertar($id_grupo,$id_nivel,$id_maestro,$num_dias,$dias,$fecha_inicio,$fecha_fin,$sede,$salon,$observacion,$horario_entrada,$horario_salida)
	{
		echo $horario_entrada;
		$sql="INSERT INTO grupos_activos (ID_GRUPO,ID_NIVEL,ID_MAESTRO,NUM_DIAS,DIAS,FECHA_INICIO,FEHA_FIN,SEDE,
        SALON,OBSERVACION,HORARIO_ENTRADA,HORARIO_SALIDA)
		VALUES ('$id_grupo','$id_nivel','$id_maestro',$num_dias,'$dias','$fecha_inicio','$fecha_fin',
		$sede,$salon,'$observacion','$horario_entrada','$horario_salida')";
		echo $sql;
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_grupo,$id_nivel,$id_maestro,$num_dias,$dias,$fecha_inicio,$fecha_fin,$sede,$salon,$observacion,$horario_entrada,$horario_salida)
	{
		$sql="UPDATE grupos_activos SET ID_NIVEL = '$id_nivel',ID_MAESTRO = '$id_maestro',NUM_DIAS = '$num_dias',DIAS = '$dias',FECHA_INICIO = '$fecha_inicio',FECHA_FIN = '$fecha_fin',SEDE = '$sede',SALON = '$salon',OBSERVACION = '$observacion',HORARIO_ENTRADA = '$horario_entrada',HORARIO_SALIDA = '$horario_salida' WHERE id='$id_grupo'";
		
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
		$sql="UPDATE grupos_activos SET status='0' WHERE id='$id'";
		return ejecutarConsulta($sql);
	}

	public function alta($id)
	{
		$sql="UPDATE grupos_activos SET status='1' WHERE id='$id'";
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
		$sql="SELECT * FROM grupos_activos WHERE ID_GRUPO='$id'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT concat (maestros.nombre,' ',maestros.apellidoP,' ',maestros.apellidoM) as nombre,grupos_activos.ID_GRUPO,grupos_activos.DIAS,grupos_activos.HORARIO_ENTRADA,grupos_activos.HORARIO_SALIDA  from maestros INNER join grupos_activos on grupos_activos.ID_MAESTRO = maestros.id";
		return ejecutarConsulta($sql);		
    }
    
    public function listarNiveles()
	{
        $sql="SELECT * FROM niveles";
		return ejecutarConsulta($sql);		
    }
    
    public function listarMaestros()
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