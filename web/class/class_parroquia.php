<?php
require_once("class_bd.php");
class parroquia {
	private $codigo_parroquia; 
	private $descripcion;
	private $codigo_municipio; 
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_parroquia=null;
		$this->descripcion=null;
		$this->codigo_municipio=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_parroquia(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_parroquia;

		if($Num_Parametro>0){
			$this->codigo_parroquia=func_get_arg(0);
		}
    }

    public function descripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->descripcion;
     
		if($Num_Parametro>0){
	   		$this->descripcion=func_get_arg(0);
	 	}
    }

    public function codigo_municipio(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_municipio;

		if($Num_Parametro>0){
			$this->codigo_municipio=func_get_arg(0);
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
	    $sql="INSERT INTO general.tparroquia (descripcion,codigo_municipio,creado_por,fecha_creacion) VALUES 
	    ('$this->descripcion',$this->codigo_municipio,'$user',NOW())";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE general.tparroquia SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_parroquia=$this->codigo_parroquia";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM general.tparroquia p WHERE p.codigo_parroquia = $this->codigo_parroquia 
    	AND (EXISTS (SELECT 1 FROM general.torganizacion o WHERE o.codigo_parroquia = p.codigo_parroquia) OR 
    	EXISTS (SELECT 1 FROM general.tpersona per WHERE per.lugar_nacimiento = p.codigo_parroquia) OR 
    	EXISTS (SELECT 1 FROM biblioteca.tautor a WHERE a.codigo_parroquia = p.codigo_parroquia) OR 
    	EXISTS (SELECT 1 FROM biblioteca.teditorial e WHERE e.codigo_parroquia = p.codigo_parroquia) OR 
    	EXISTS (SELECT 1 FROM seguridad.tsistema s WHERE s.codigo_parroquia = p.codigo_parroquia))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE general.tparroquia SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_parroquia=$this->codigo_parroquia";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE general.tparroquia SET descripcion='$this->descripcion',codigo_municipio=$this->codigo_municipio,modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_parroquia='$this->codigo_parroquia'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

	public function Comprobar($comprobar){
	    if($comprobar==true){
		    $sql="SELECT * FROM general.tparroquia WHERE descripcion='$this->descripcion'";
			$query=$this->pgsql->Ejecutar($sql);
		    if($this->pgsql->Total_Filas($query)!=0){
				$tparroquia=$this->pgsql->Respuesta($query);
				$this->estatus($tparroquia['estatus']);
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
