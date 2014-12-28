<?php
require_once("class_bd.php");
class adquisicion {
	private $codigo_adquisicion; 
	private $fecha_adquisicion;
	private $tipo_adquisicion;
	private $rif_organizacion;
	private $cedula_persona;
	private $sonlibros;
	private $estatus; 
	private $error; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_adquisicion=null;
		$this->fecha_adquisicion=null;
		$this->tipo_adquisicion=null;
		$this->rif_organizacion=null;
		$this->cedula_persona=null;
		$this->sonlibros=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_adquisicion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_adquisicion;

		if($Num_Parametro>0){
			$this->codigo_adquisicion=func_get_arg(0);
		}
    }

    public function fecha_adquisicion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha_adquisicion;
     
		if($Num_Parametro>0){
	   		$this->fecha_adquisicion=func_get_arg(0);
	 	}
    }

    public function tipo_adquisicion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->tipo_adquisicion;

		if($Num_Parametro>0){
			$this->tipo_adquisicion=func_get_arg(0);
		}
    }

    public function rif_organizacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->rif_organizacion;

		if($Num_Parametro>0){
			$this->rif_organizacion=func_get_arg(0);
		}
    }

    public function cedula_persona(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cedula_persona;

		if($Num_Parametro>0){
			$this->cedula_persona=func_get_arg(0);
		}
    }

    public function sonlibros(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->sonlibros;

		if($Num_Parametro>0){
			$this->sonlibros=func_get_arg(0);
		}
    }

    public function estatus(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus;

		if($Num_Parametro>0){
			$this->estatus=func_get_arg(0);
		}
    }

    public function error(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->error;

		if($Num_Parametro>0){
			$this->error=func_get_arg(0);
		}
    }

	public function EliminarAdquisiciones(){
		$sql="DELETE FROM inventario.tdetalle_adquisicion WHERE codigo_adquisicion='$this->codigo_adquisicion'";
		if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
	}

	public function InsertarAdquisiciones($user,$items,$cantidad,$ubicacion){
	    $sql="INSERT INTO inventario.tdetalle_adquisicion(codigo_adquisicion,codigo_item,cantidad,codigo_ubicacion,creado_por,fecha_creacion) VALUES ";
	    for ($i=0; $i < count($items); $i++){
	    	$sql.="('$this->codigo_adquisicion','".$items[$i]."','".$cantidad[$i]."','".$ubicacion[$i]."','$user',NOW()),";
	    }
	    $sql=substr($sql,0,-1);
	    $sql=$sql.";";
	    if($this->pgsql->Ejecutar($sql)!=null)
	      return true;
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
    }
   
   	public function Registrar($user){
	    $sql="INSERT INTO inventario.tadquisicion (fecha_adquisicion,tipo_adquisicion,rif_organizacion,cedula_persona,sonlibros,creado_por,fecha_creacion) VALUES 
	    ('$this->fecha_adquisicion','$this->tipo_adquisicion','$this->rif_organizacion','$this->cedula_persona','$this->sonlibros','$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null){
	    	$sqlx="SELECT codigo_adquisicion FROM inventario.tadquisicion 
	    	WHERE fecha_adquisicion='$this->fecha_adquisicion' AND rif_organizacion = '$this->rif_organizacion' 
	    	AND cedula_persona = '$this->cedula_persona' AND tipo_adquisicion = '$this->tipo_adquisicion'";
	    	$query=$this->pgsql->Ejecutar($sqlx);
	    	if($this->pgsql->Total_Filas($query)!=0){
				$tadquisicion=$this->pgsql->Respuesta($query);
				$this->codigo_adquisicion($tadquisicion['codigo_adquisicion']);
	    		return true;
			}
	    }
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE inventario.tadquisicion SET estatus = '1', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_adquisicion='$this->codigo_adquisicion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM inventario.tadquisicion a WHERE a.codigo_adquisicion = '$this->codigo_adquisicion' 
    	AND (EXISTS (SELECT 1 FROM inventario.tdetalle_adquisicion da WHERE a.codigo_adquisicion = da.codigo_adquisicion))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE inventario.tadquisicion SET estatus = '0', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_adquisicion=$this->codigo_adquisicion";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE inventario.tadquisicion SET fecha_adquisicion='$this->fecha_adquisicion',tipo_adquisicion='$this->tipo_adquisicion',
	    rif_organizacion='$this->rif_organizacion',cedula_persona='$this->cedula_persona',sonlibros='$this->sonlibros',
	    modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_adquisicion='$this->codigo_adquisicion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM inventario.tadquisicion 
	    WHERE fecha_adquisicion='$this->fecha_adquisicion' AND rif_organizacion = '$this->rif_organizacion' 
	    AND cedula_persona = '$this->cedula_persona' AND tipo_adquisicion = '$this->tipo_adquisicion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tadquisicion=$this->pgsql->Respuesta($query);
			$this->codigo_adquisicion($tadquisicion['codigo_adquisicion']);
			$this->fecha_adquisicion($tadquisicion['fecha_adquisicion']);
			$this->tipo_adquisicion($tadquisicion['tipo_adquisicion']);
			$this->rif_organizacion($tadquisicion['rif_organizacion']);
			$this->cedula_persona($tadquisicion['cedula_persona']);
			$this->sonlibros($tadquisicion['sonlibros']);
			$this->estatus($tadquisicion['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
