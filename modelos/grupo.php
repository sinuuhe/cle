<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Grupo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function obtenerCantidad(){
		$sql="SELECT * FROM grupos_activos";
		$result = ejecutarConsulta($sql);	
		return $result -> num_rows + 1; 
	}

	public function obtenerNivel($idGrupo){
		$sql="SELECT ID_NIVEL as idNivel FROM grupos_activos WHERE ID_GRUPO = '$idGrupo'";
		$result = ejecutarConsultaSimpleFila($sql);	
		return $result->idNivel; 
	}

	public function obtenerGrupo($idAlumno){
		$sql="SELECT ID_GRUPO as idGrupo FROM alumnos_grupos_activos WHERE ID_ALUMNO = '$idAlumno'";
		$result = ejecutarConsultaSimpleFila($sql);	
		return $result->idGrupo; 
	}

	//Implementamos un método para insertar registros
	public function insertar($id_grupo,$id_nivel,$id_maestro,$num_dias,$dias,$fecha_inicio,$fecha_fin,$sede,$salon,$observacion,$horario_entrada,$horario_salida)
	{
		
		$sql="INSERT INTO grupos_activos (ID_GRUPO,ID_NIVEL,ID_MAESTRO,NUM_DIAS,DIAS,FECHA_INICIO,FEHA_FIN,SEDE,
        SALON,OBSERVACION,HORARIO_ENTRADA,HORARIO_SALIDA)
		VALUES ('$id_grupo','$id_nivel','$id_maestro',$num_dias,'$dias','$fecha_inicio','$fecha_fin',
		$sede,$salon,'$observacion','$horario_entrada','$horario_salida')";
		
		return ejecutarConsulta($sql);
	}

	public function inscribirAlumno($idGrupo,$idAlumno){
		$sql="INSERT INTO alumnos_grupos_activos values (0,'$idGrupo','$idAlumno',0,'Normal')";
		return ejecutarConsulta($sql);

	}

	public function insertarCosto($idGrupo,$idAlumno){
		$idNivel = self::obtenerNivel($idGrupo);
		$sql = "INSERT INTO pago_cursos VALUES (NULL, '$idAlumno', '$idGrupo', $idNivel,0,0,0,0,'','','',0);";
		return ejecutarConsulta($sql);
	}
	//Implementamos un método para editar registros
	public function editar($id_grupo,$id_nivel,$id_maestro,$num_dias,$dias,$fecha_inicio,$fecha_fin,$sede,$salon,$observacion,$horario_entrada,$horario_salida)
	{
		$sql="UPDATE grupos_activos SET ID_NIVEL = '$id_nivel',ID_MAESTRO = '$id_maestro',NUM_DIAS = '$num_dias',DIAS = '$dias',FECHA_INICIO = '$fecha_inicio',FEHA_FIN = '$fecha_fin',SEDE = '$sede',SALON = '$salon',OBSERVACION = '$observacion',HORARIO_ENTRADA = '$horario_entrada',HORARIO_SALIDA = '$horario_salida' WHERE ID_GRUPO='$id_grupo'";
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

	public function listarTotalGrupos(){
		$sql = "SELECT ga.ID_GRUPO as idGrupo, CONCAT(n.CURSO, ' ' , n.NOMBRE) as nivel, CONCAT(m.nombre, ' ', m.apellidoP, ' ', m.apellidoM) as nombreMaestro FROM grupos_activos ga
		INNER JOIN maestros m on ga.ID_MAESTRO =m.id 
		INNER JOIN niveles n on ga.ID_NIVEL = n.ID";

		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT concat (maestros.nombre,' ',maestros.apellidoP,' ',maestros.apellidoM) as nombre,grupos_activos.ID_GRUPO,grupos_activos.DIAS,grupos_activos.HORARIO_ENTRADA,grupos_activos.HORARIO_SALIDA,CONCAT(niveles.NOMBRE,' ',niveles.CURSO) as infoNivel from maestros INNER join grupos_activos on grupos_activos.ID_MAESTRO = maestros.id INNER join niveles on niveles.ID = grupos_activos.ID_NIVEL";
		return ejecutarConsulta($sql);		
    }
    
    public function listarNiveles()
	{
        $sql="SELECT * FROM niveles";
		return ejecutarConsulta($sql);		
	}

	public function checarFecha($idGrupo,$fecha)
	{
		$sql="SELECT id,id_grupo,asistencia,fecha,id_alumno FROM asistencia_alumnos where id_grupo = '$idGrupo' and fecha = '$fecha'";
		
		return ejecutarConsulta($sql);		
	}
	

	public function listarGrupos($idMaestro)
	{
		$sql="select grupos_activos.ID_GRUPO, niveles.NOMBRE from grupos_activos inner join niveles on grupos_activos.ID_NIVEL = niveles.ID where grupos_activos.ID_MAESTRO = '$idMaestro'";
		return ejecutarConsulta($sql);		
    }
    
    public function listarMaestros()
	{
        $sql="SELECT * FROM maestros";
		return ejecutarConsulta($sql);		
	}
	public function listarAlumnos($idGrupo)
	{
		$sql="SELECT concat(alumnos.nombre,' ',alumnos.apellidoP,' ',alumnos.apellidoM) as nombre,alumnos.id, alumnos_grupos_activos.ID_GRUPO, grupos_activos.ID_MAESTRO as idMaestro FROM alumnos_grupos_activos inner join alumnos ON alumnos.id = alumnos_grupos_activos.ID_ALUMNO inner join grupos_activos on grupos_activos.ID_GRUPO = alumnos_grupos_activos.ID_GRUPO where alumnos_grupos_activos.ID_GRUPO = '$idGrupo'";
		
		return ejecutarConsulta($sql);		
    }
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM convenios where condicion=1";
		return ejecutarConsulta($sql);		
	}

	public function removerAlumno($idAlumno,$idGrupo){
		$sql="delete from alumnos_grupos_activos WHERE ID_GRUPO='$idGrupo' and ID_ALUMNO = '$idAlumno'";
		return ejecutarConsulta($sql);
	}
	public function subirLista($alumnoId,$asistencia,$idGrupo,$fecha){
		$sql="INSERT INTO asistencia_alumnos (id_grupo,id_alumno,fecha,asistencia) VALUES ('$idGrupo','$alumnoId','$fecha','$asistencia')";

		return ejecutarConsulta($sql);
	}

	public function actualizarLista($id,$alumnoId,$asistencia,$idGrupo,$fecha){
		$sql="UPDATE asistencia_alumnos SET id_grupo = '$idGrupo', id_alumno = '$alumnoId', fecha = '$fecha', asistencia = '$asistencia' WHERE id='$id'";

		return ejecutarConsulta($sql);
	}

	public function listarAsistencias($id_grupo,$id_alumno){
		if($id_alumno == null){
			$sql = "SELECT id_alumno as matricula, fecha, GROUP_CONCAT( asistencia ORDER BY id) as asistencias FROM asistencia_alumnos WHERE id_grupo = '$id_grupo' GROUP BY fecha,id_alumno";
		}
		else{
			$sql = "SELECT id_alumno as matricula, fecha, asistencia FROM asistencia_alumnos WHERE id_grupo = '$id_grupo' AND id_alumno = '$id_alumno'";
		}

		return ejecutarConsulta($sql);
	}

	
	public function listarFechas($id_grupo){
		$sql = "SELECT fecha FROM asistencia_alumnos WHERE id_grupo = '$id_grupo' GROUP BY fecha";

		return ejecutarConsulta($sql);
	}

	public function actualizarStatusAlumno($idAlumno,$status,$idMaestro){
		$sql = "update alumnos_grupos_activos set STATUS = '$status' where ID_ALUMNO = '$idAlumno' and ID_MAESTRO = '$idMaestro'";
		return ejecutarConsulta($sql);
	}

	public function actualizarStatusAlumnoExtra($idAlumno,$status,$idMaestro){
		$sql = "update alumnos_extra set STATUS = '$status' where ID_ALUMNO = '$idAlumno' and id_maestro = '$idMaestro'";
		return ejecutarConsulta($sql);
	}

	public function insertarHistoricoAlumnos($idGrupo,$idAlumno,$calificacion,$status){
		$sql = "insert into historico_alumnos_grupos (id,ID_GRUPO,ID_ALUMNO,CALIFICACION,STATUS) values (0,'$idGrupo','$idAlumno',$calificacion,'$status')";
		echo $sql;
		return ejecutarConsulta($sql);
	}
	public function asignarCalificacion($idAlumno,$calificacion){
		$sql = "update alumnos_grupos_activos set CALIFICACION = $calificacion where ID_ALUMNO = '$idAlumno'";
		return ejecutarConsulta($sql);
	}

	public function asignarSiguienteNivel($idGrupo){
		$sigNivel = self::existeSiguienteNivel($idGrupo);
		if($sigNivel != 0){
			$sql = "update grupos_activos set ID_NIVEL = $sigNivel where ID_GRUPO = '$idGrupo'";

			return ejecutarConsulta($sql);
		}
	}
	public function existeSiguienteNivel($idGrupo){
		$idNivel = self::obtenerNivel($idGrupo);

		$sql = "select NIVEL as nivel from niveles where ID = $idNivel";
		$result = ejecutarConsultaSimpleFila($sql);	
		$nivel = $result->nivel;
		$idNivel++;
		$sql = "select NIVEL as nivel from niveles where ID = $idNivel";
		$result = ejecutarConsultaSimpleFila($sql);	
		$sigNivel = $result->nivel;

		if($nivel < $sigNivel){
			return $idNivel;
		}else{
			return 0;
		}
	}

	public function insertarHistoricoGrupos($idGrupo,$observaciones){
		$grupo = self::mostrar($idGrupo);
		$sql = "INSERT INTO historico_grupos (ID_GRUPO,ID_NIVEL,ID_MAESTRO,NUM_DIAS,DIAS,FECHA_INICIO,FECHA_FIN,SEDE,
        SALON,OBSERVACION,ENTREGOE,HORARIO_ENTRADA,HORARIO_SALIDA)
		VALUES ('$grupo->ID_GRUPO','$grupo->ID_NIVEL','$grupo->ID_MAESTRO',$grupo->NUM_DIAS,'$grupo->DIAS','$grupo->FECHA_INICIO','$grupo->FEHA_FIN',
		$grupo->SEDE,$grupo->SALON,'$observaciones',1,'$grupo->HORARIO_ENTRADA','$grupo->HORARIO_SALIDA')";
		return ejecutarConsulta($sql);
	}

	public function asignarExtraAlumnoMaestro($idAlumno,$idMaestro,$idGrupo){
		$idNivel = self::obtenerNivel($idGrupo);
		$sql = "insert into alumnos_extra (id,id_alumno,id_maestro,id_nivel,status) values (0,'$idAlumno','$idMaestro','$idNivel','Extra')";
		return ejecutarConsulta($sql);
	}

	public function removerExtraAlumnoMaestro($idAlumno,$idMaestro){
		$sql = "delete from alumnos_extra where id_alumno = '$idAlumno' and id_maestro = '$idMaestro'";
		return ejecutarConsulta($sql);
	}

	public function listarAlumnosExtra($idMaestro,$status){
		$sql="SELECT concat(alumnos.nombre,' ',alumnos.apellidoP,' ',alumnos.apellidoM) as nombre,alumnos.id FROM alumnos inner join alumnos_extra ON alumnos.id = alumnos_extra.id_alumno where alumnos_extra.id_maestro = '$idMaestro' and alumnos_extra.status = '$status'";
		return ejecutarConsulta($sql);		
	}

}

?>