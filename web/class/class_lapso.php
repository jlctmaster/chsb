<?php
require_once("class_bd.php");
class tlapso {
	private $codigo_lapso; 
	private $lapso;
	private $codigo_ano_academico; 
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_lapso=null;
		$this->lapso=null;
		$this->codigo_ano_academico=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_lapso(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_lapso;

		if($Num_Parametro>0){
			$this->codigo_lapso=func_get_arg(0);
		}
    }

    public function lapso(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->lapso;

		if($Num_Parametro>0){
			$this->lapso=func_get_arg(0);
		}
    }

    public function codigo_ano_academico(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_ano_academico;

		if($Num_Parametro>0){
			$this->codigo_ano_academico=func_get_arg(0);
		}
    }

    public function estatus(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus;

		if($Num_Parametro>0){
			$this->estatus=func_get_arg(0);
		}
    }
   
   	public function Registrar($user){
	    $sql="INSERT INTO educacion.tlapso (lapso,codigo_ano_academico,creado_por,fecha_creacion) VALUES 
	    ('$this->lapso','$this->codigo_ano_academico','$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE educacion.tlapso SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW()  WHERE codigo_lapso=$this->codigo_lapso";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM educacion.tlapso l WHERE l.codigo_lapso = $this->codigo_lapso 
    	AND (EXISTS (SELECT 1 FROM educacion.tperiodo p WHERE p.codigo_lapso = l.codigo_lapso))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE educacion.tlapso SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_lapso=$this->codigo_lapso";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE educacion.tlapso SET lapso='$this->lapso',codigo_ano_academico=$this->codigo_ano_academico,
	    modificado_por='$user' WHERE codigo_lapso='$this->codigo_lapso'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar($comprobar){
   		if($comprobar==true){
		    $sql="SELECT * FROM educacion.tlapso WHERE lapso='$this->lapso' AND codigo_ano_academico = '$this->codigo_ano_academico'";
			$query=$this->pgsql->Ejecutar($sql);
		    if($this->pgsql->Total_Filas($query)!=0){
				$lapso=$this->pgsql->Respuesta($query);
				$this->estatus($lapso['estatus']);
				return true;
			}
			else{
				return false;
			}
   		}else
   			return false;
   }
}
?>