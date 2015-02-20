<?php
 require_once("class_bd.php");
 class Perfil
 {
     private $codigo_perfil; 
     private $codigo_configuracion; 
     private $url; 
     private $codigo_servicio; 
     private $codigo_modulo; 
     private $codigo_opcion; 
     private $nombre_perfil; 
     private $estatus; 
     private $pgsql; 
	 
   public function __construct(){
     $this->nombre_perfil=null;
     $this->codigo_perfil=null;
	 $this->pgsql=new Conexion();
   }
   
 public function __destruct(){}

 public function Transaccion($value){
	 if($value=='iniciANDo') return $this->pgsql->Incializar_Transaccion();
	 if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
	 if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	 }

   public function codigo_perfil(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->codigo_perfil;
     
	 if($Num_Parametro>0){
	   $this->codigo_perfil=func_get_arg(0);
	 }
   }

   public function codigo_configuracion(){
      $Num_Parametro=func_num_args();
   if($Num_Parametro==0) return $this->codigo_configuracion;
     
   if($Num_Parametro>0){
     $this->codigo_configuracion=func_get_arg(0);
   }
   }
   
      public function estatus(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->estatus;
     
	 if($Num_Parametro>0){
	   $this->estatus=func_get_arg(0);
	 }
   }
      public function codigo_servicio(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->codigo_servicio;
     
	 if($Num_Parametro>0){
	   $this->codigo_servicio=func_get_arg(0);
	 }
   }
      public function url(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->url;
     
	 if($Num_Parametro>0){
	   $this->url=func_get_arg(0);
	 }
   }
       public function codigo_opcion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->codigo_opcion;
     
	 if($Num_Parametro>0){
	   $this->codigo_opcion=func_get_arg(0);
	 }
   }
   
   public function codigo_modulo(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->codigo_modulo;
     
	 if($Num_Parametro>0){
	   $this->codigo_modulo=func_get_arg(0);
	 }
   }
   
   public function nombre_perfil(){
   $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->nombre_perfil;
     
	 if($Num_Parametro>0){
	   $this->nombre_perfil=func_get_arg(0);
	 }
   }   

   public function Registrar($user){
    $sql="INSERT INTO seguridad.tperfil (nombre_perfil,codigo_configuracion,creado_por,fecha_creacion) VALUES 
    ('$this->nombre_perfil','$this->codigo_configuracion','$user',NOW());";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
   
     public function Activar($user){
    $sql="UPDATE seguridad.tperfil SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW() WHERE (codigo_perfil='$this->codigo_perfil');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
    public function Desactivar($user){
    $sqlx="SELECT * FROM seguridad.tperfil p WHERE p.codigo_perfil = '$this->codigo_perfil' AND 
    (EXISTS (SELECT 1 FROM seguridad.tdetalle_servicio_perfil_opcion dspo WHERE p.codigo_perfil = dspo.codigo_perfil) OR 
    EXISTS (SELECT 1 FROM seguridad.tusuario u WHERE p.codigo_perfil = u.codigo_perfil))";
    $sql="UPDATE seguridad.tperfil SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE (codigo_perfil='$this->codigo_perfil');";
    $query=$this->pgsql->Ejecutar($sqlx);
    if($this->pgsql->Total_Filas($query)==0){
      if($this->pgsql->Ejecutar($sql)!=null)
    	  return true;
    	else
        return false;
    }
    else
      return false;
   }
   
    public function Actualizar($user){
    $sql="UPDATE seguridad.tperfil SET nombre_perfil='$this->nombre_perfil',codigo_configuracion='$this->codigo_configuracion'
    ,modificado_por='$user',fecha_modificacion=NOW() 
    WHERE (codigo_perfil='$this->codigo_perfil');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   }
   
   public function ELIMINAR_OPCION_SERVICIO_PERFIL(){
    $sql="DELETE FROM seguridad.tdetalle_servicio_perfil_opcion WHERE (codigo_perfil='$this->codigo_perfil');";
    if($this->pgsql->Ejecutar($sql)!=null)
	return true;
	else
	return false;
   } 
   
   public function INSERTAR_OPCION_SERVICIO_PERFIL($user,$modulo,$servicio,$opcion){
    $sql="INSERT INTO seguridad.tdetalle_servicio_perfil_opcion(codigo_perfil,codigo_servicio,codigo_opcion,creado_por,fecha_creacion) VALUES ";
    foreach ($servicio as $keyS => $valueS) {
      if(!empty($opcion[$valueS])){
        foreach ($opcion[$valueS] as $keyO => $valueO) {
          $sql.="('$this->codigo_perfil',$valueS,$valueO,'$user',NOW()),";
        }
      }else{
        $sql.="('$this->codigo_perfil',$valueS,NULL,'$user',NOW()),";
      }
    }
    $sql=substr($sql,0,-1);
    $sql=$sql.";";
    if($this->pgsql->Ejecutar($sql)!=null)
      return true;
    else
      return false;
    }
    
      public function Consultar_SERVICIOS(){
        if($this->codigo_perfil==''){
          $sql="SELECT * FROM seguridad.tdetalle_servicio_perfil_opcion tsuo 
          inner join seguridad.tperfil tper on tper.codigo_perfil=tsuo.codigo_perfil 
          inner join seguridad.tservicio tser on tser.codigo_servicio=tsuo.codigo_servicio 
          WHERE tser.codigo_servicio='$this->codigo_servicio' AND tper.codigo_perfil IS NULL 
          AND tser.estatus = '1' AND tper.estatus = '1'";
        }
        else{
          $sql="SELECT * FROM seguridad.tdetalle_servicio_perfil_opcion tsuo 
          inner join seguridad.tperfil tper on tper.codigo_perfil=tsuo.codigo_perfil 
          inner join seguridad.tservicio tser on tser.codigo_servicio=tsuo.codigo_servicio 
          WHERE tper.codigo_perfil='$this->codigo_perfil' AND tser.codigo_servicio='$this->codigo_servicio' 
          AND tser.estatus = '1' AND tper.estatus = '1'";
        }
	 $query=$this->pgsql->Ejecutar($sql);
    if(@$this->pgsql->Total_Filas($query)!=0){
	   return true;
	  }
	   else{
	    return false;
	    }
   }
         public function Consultar_OPCIONES(){
          if($this->codigo_perfil==''){
            $sql="SELECT * FROM seguridad.tdetalle_servicio_perfil_opcion tsuo 
            inner join seguridad.tperfil tper on tper.codigo_perfil=tsuo.codigo_perfil 
            inner join seguridad.tservicio tser on tser.codigo_servicio=tsuo.codigo_servicio
            inner join seguridad.topcion topc on topc.codigo_opcion=tsuo.codigo_opcion 
            WHERE topc.codigo_opcion='$this->codigo_opcion' AND 
            tser.codigo_servicio='$this->codigo_servicio' AND tper.codigo_perfil IS NULL 
            AND tser.estatus = '1' AND tper.estatus = '1' 
            AND topc.estatus = '1'"; 
          }
          else{
            $sql="SELECT * FROM seguridad.tdetalle_servicio_perfil_opcion tsuo 
            inner join seguridad.tperfil tper on tper.codigo_perfil=tsuo.codigo_perfil 
            inner join seguridad.tservicio tser on tser.codigo_servicio=tsuo.codigo_servicio
            inner join seguridad.topcion topc on topc.codigo_opcion=tsuo.codigo_opcion 
            WHERE topc.codigo_opcion='$this->codigo_opcion' AND 
            tper.codigo_perfil='$this->codigo_perfil' AND 
            tser.codigo_servicio='$this->codigo_servicio' 
            AND tser.estatus = '1' AND tper.estatus = '1' 
            AND topc.estatus = '1'"; 
          }
	$query=$this->pgsql->Ejecutar($sql);
    if(@$this->pgsql->Total_Filas($query)!=0){
	   return true;
	  }
	   else{
	    return false;
	    }
   }
   
      public function IMPRIMIR_MODULOS(){
    $sql="SELECT DISTINCT tmod.codigo_modulo, INITCAP(tmod.nombre_modulo) nombre_modulo,tmod.icono,tmod.orden 
    FROM seguridad.tmodulo tmod 
    INNER JOIN seguridad.tservicio tserv ON tmod.codigo_modulo = tserv.codigo_modulo 
    INNER JOIN seguridad.tdetalle_servicio_perfil_opcion tdspo ON tserv.codigo_servicio = tdspo.codigo_servicio 
    WHERE tdspo.codigo_perfil = '$this->codigo_perfil'
    ORDER BY tmod.orden ASC";
    $x=array();
    $i=0;
	$query=$this->pgsql->Ejecutar($sql);
   while($a=$this->pgsql->Respuesta($query)){
   	$x[$i]['nombre_modulo']=$a['nombre_modulo'];
   	$x[$i]['codigo_modulo']=$a['codigo_modulo'];
   	$x[$i]['icono']=$a['icono'];
    $x[$i]['orden']=$a['orden'];
      $i++;     
     }
     return $x;    
 }  
  
  public function IMPRIMIR_SERVICIOS(){
    $sql="SELECT DISTINCT tserv.codigo_servicio, INITCAP(tserv.nombre_servicio) nombre_servicio, LOWER(tserv.url) url, tserv.orden     
    FROM seguridad.tservicio tserv 
    INNER JOIN seguridad.tdetalle_servicio_perfil_opcion tdspo ON tserv.codigo_servicio = tdspo.codigo_servicio 
    WHERE tdspo.codigo_perfil = '$this->codigo_perfil' and tserv.codigo_modulo = $this->codigo_modulo 
    ORDER BY tserv.orden ASC";
	 $x=array();
    $i=0;
	$query=$this->pgsql->Ejecutar($sql);
   while($a=$this->pgsql->Respuesta($query)){
   	$x[$i]['nombre_servicio']=$a['nombre_servicio'];
   	$x[$i]['codigo_servicio']=$a['codigo_servicio'];
    $x[$i]['url']=$a['url'];
      $i++;     
     }
     return $x;     
   }
   
    public function IMPRIMIR_OPCIONES(){
    $sql="SELECT DISTINCT INITCAP(top.nombre_opcion) AS nombre_opcion,top.orden,top.icono,
    CASE WHEN top.estatus = '1' THEN 'Activo' ELSE 'Desactivado' END estatus
    FROM seguridad.topcion top 
    INNER JOIN seguridad.tdetalle_servicio_perfil_opcion tdspo ON top.codigo_opcion = tdspo.codigo_opcion 
    INNER JOIN seguridad.tservicio tserv ON tdspo.codigo_servicio = tserv.codigo_servicio 
    WHERE tdspo.codigo_perfil = '$this->codigo_perfil' AND lower(tserv.url) = '$this->url' 
    ORDER BY top.orden ASC";
		 $x=array();
    $i=0;
	$query=$this->pgsql->Ejecutar($sql);
   while($a=$this->pgsql->Respuesta($query)){
   	$x[$i]['nombre_opcion']=$a['nombre_opcion'];
   	$x[$i]['orden']=$a['orden'];
    $x[$i]['icono']=$a['icono'];
   	$x[$i]['estatus']=$a['estatus'];
      $i++;     
     }
     return $x;   
   }

  public function Comprobar($comprobar){
    if($comprobar==true){
      $sql="SELECT * FROM seguridad.tperfil WHERE nombre_perfil='$this->nombre_perfil'";
      $query=$this->pgsql->Ejecutar($sql);
      if($this->pgsql->Total_Filas($query)!=0){
        $tperfil=$this->pgsql->Respuesta($query);
        $this->estatus($tperfil['estatus']);
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
