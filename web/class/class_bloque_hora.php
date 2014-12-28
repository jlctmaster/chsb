<?php
require_once("class_bd.php");
class bloque_hora {
	private $codigo_bloque_hora; 
	private $hora_inicio;
	private $hora_fin;
	private $turno;  
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_bloque_hora=null;
		$this->hora_inicio=null;
		$this->hora_fin=null;
		$this->turno=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_bloque_hora(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_bloque_hora;

		if($Num_Parametro>0){
			$this->codigo_bloque_hora=func_get_arg(0);
		}
    }

    public function hora_inicio(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->hora_inicio;
     
		if($Num_Parametro>0){
	   		$this->hora_inicio=func_get_arg(0);
	 	}
    }

    public function hora_fin(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->hora_fin;

		if($Num_Parametro>0){
			$this->hora_fin=func_get_arg(0);
		}
    }

   public function turno(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->turno;
     
	 if($Num_Parametro>0){
	   $this->turno=func_get_arg(0);
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
	    $sql="INSERT INTO educacion.tbloque_hora (hora_inicio,hora_fin,turno,creado_por,fecha_creacion) VALUES 
	    ('$this->hora_inicio','$this->hora_fin','$this->turno','$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE educacion.tbloque_hora SET estatus = '1',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_bloque_hora='$this->codigo_bloque_hora'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM educacion.tbloque_hora bh WHERE bh.codigo_bloque_hora = '$this->codigo_bloque_hora' 
    	AND (EXISTS (SELECT 1 FROM educacion.thorario h WHERE h.codigo_bloque_hora = bh.codigo_bloque_hora))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE educacion.tbloque_hora SET estatus = '0',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_bloque_hora='$this->codigo_bloque_hora'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE educacion.tbloque_hora SET hora_inicio='$this->hora_inicio',
	    hora_fin='$this->hora_fin',turno='$this->turno',
	    modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_bloque_hora='$this->codigo_bloque_hora'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM educacion.tbloque_hora WHERE (hora_inicio='$this->hora_inicio' AND turno ='$this->turno')
	    OR (hora_fin='$this->hora_fin' AND turno ='$this->turno')";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tbloque_hora=$this->pgsql->Respuesta($query);
			$this->codigo_bloque_hora($tbloque_hora['codigo_bloque_hora']);
			$this->hora_inicio($tbloque_hora['hora_inicio']);
			$this->hora_fin($tbloque_hora['hora_fin']);
			$this->turno($tbloque_hora['turno']);
			$this->estatus($tbloque_hora['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
