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

	//Implementamos un método para insertar registros
	public function insertar($id_grupo,$id_nivel,$id_maestro,$num_dias,$dias,$fecha_inicio,$fecha_fin,$sede,$salon,$observacion,$horario_entrada,$horario_salida)
	{
		
		$sql="INSERT INTO grupos_activos (ID_GRUPO,ID_NIVEL,ID_MAESTRO,NUM_DIAS,DIAS,FECHA_INICIO,FECHA_FIN,SEDE,
        SALON,OBSERVACION,HORARIO_ENTRADA,HORARIO_SALIDA)
		VALUES ('$id_grupo','$id_nivel','$id_maestro',$num_dias,'$dias',$fecha_inicio,'$fecha_fin',
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
		$sql="SELECT * FROM grupos_activos WHERE id='$id'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM grupos_activos";
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