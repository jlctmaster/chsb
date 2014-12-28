<?php
   require_once("class_bd.php");
class Usuario{
     private $nombre_usuario;
     private $contrasena;
     private $cedula_persona;
     private $codigo_perfil;

	function __construct(){
		$this->pgsql=new Conexion();
	}

	public function nombre_usuario(){
	$Num_Parametro=func_num_args();
	if($Num_Parametro==0) return $this->nombre_usuario;

	if($Num_Parametro>0){
		$this->nombre_usuario=func_get_arg(0);
	}
	}

	public function contrasena(){
	$Num_Parametro=func_num_args();
	if($Num_Parametro==0) return  $this->contrasena;

	if($Num_Parametro>0){
		$this->contrasena=sha1(md5(func_get_arg(0)));
	}
	}
	public function cedula_persona(){
	$Num_Parametro=func_num_args();
	if($Num_Parametro==0) return $this->cedula_persona;

	if($Num_Parametro>0){
		$this->cedula_persona=func_get_arg(0);
	}
	}
	public function codigo_perfil(){
	$Num_Parametro=func_num_args();
	if($Num_Parametro==0) return $this->codigo_perfil;

	if($Num_Parametro>0){
		$this->codigo_perfil=func_get_arg(0);
	}
	}

	public function Cambiar_Clave($user){
		$sqlx="UPDATE seguridad.tcontrasena SET estado=0,modificado_por='$user',fecha_modificacion=NOW() WHERE nombre_usuario='$this->nombre_usuario'";
		if($this->pgsql->Ejecutar($sqlx)!=null){
			$sql="INSERT INTO seguridad.tcontrasena (contrasena,nombre_usuario,estado,creado_por,fecha_creacion) VALUES 
			('$this->contrasena','$this->nombre_usuario',1,'$user',NOW())";
			if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
	}

	public function Buscar_ultimas_3_clave(){
	    $sql="SELECT contrasena FROM seguridad.tcontrasena 
	    WHERE nombre_usuario='$this->nombre_usuario' 
	    ORDER BY fecha_modificacion DESC LIMIT 3";
	   	$ABC=false;
		$query=$this->pgsql->Ejecutar($sql);
	   	while($a=$this->pgsql->Respuesta($query)){
		    if($a['contrasena']==$this->contrasena)
		        $ABC=true;
	    }
	    return $ABC;  
	 }

    public function Actualizar($user,$pold,$pnew,$rnew){
    	$con=0;
    	if(count($pold) == count($pnew)){
	    	for($i=0;$i<count($pnew);$i++){
				$sql1="UPDATE seguridad.trespuesta_secreta SET pregunta = '".$pnew[$i]."',
				respuesta =  '".$rnew[$i]."',modificado_por = '$user',fecha_modificacion=NOW() 
				WHERE nombre_usuario='$this->nombre_usuario' AND pregunta = '".$pold[$i]."'";
				if($this->pgsql->Ejecutar($sql1)!=null)
					$con++;
				else
					$con--;
	    	}
    	}
    	else if(count($pold) < count($pnew)){
    		$prest = count($pnew)-count($pold);
    		for($i=0;$i<count($pold);$i++){
				$sql1="UPDATE seguridad.trespuesta_secreta SET pregunta = '".$pnew[$i]."',
				respuesta =  '".$rnew[$i]."',modificado_por = '$user',fecha_modificacion=NOW() 
				WHERE nombre_usuario='$this->nombre_usuario' AND pregunta = '".$pold[$i]."'";
				if($this->pgsql->Ejecutar($sql1)!=null)
					$con++;
				else
					$con--;
	    	}
	    	for ($j=$prest-1;$j < count($pnew);$j++) { 
	    		$sql2="INSERT INTO seguridad.trespuesta_secreta (nombre_usuario,pregunta,respuesta,creado_por,fecha_creacion) 
	    		VALUES ('$this->nombre_usuario','".$pnew[$j]."','".$rnew[$j]."','$user',NOW());";
	    		if($this->pgsql->Ejecutar($sql2))
	    			$con++;
	    		else
	    			$con--;
	    	}
    	}
    	else{
    		$prest = count($pold)-count($pnew);
    		for($i=0;$i<count($pnew);$i++){
				$sql1="UPDATE seguridad.trespuesta_secreta SET pregunta = '".$pnew[$i]."',
				respuesta =  '".$rnew[$i]."',modificado_por = '$user',fecha_modificacion=NOW() 
				WHERE nombre_usuario='$this->nombre_usuario' AND pregunta = '".$pold[$i]."'";
				if($this->pgsql->Ejecutar($sql1)!=null)
					$con++;
				else
					$con--;
	    	}
	    	for ($k=$prest-1;$k < count($pold);$k++) { 
	    		$sql2="DELETE FROM seguridad.trespuesta_secreta WHERE nombre_usuario='$this->nombre_usuario' AND pregunta='".$pold[$k]."';";
	    		if($this->pgsql->Ejecutar($sql2))
	    			$con++;
	    		else
	    			$con--;
	    	}
    	}
    	if($con==count($pnew))
    		return true;
    	else
    		return false;
	}
   
	public function Registrar($user){
		$sqlx="INSERT INTO seguridad.tusuario (cedula_persona,nombre_usuario,codigo_perfil,creado_por,fecha_creacion) VALUES 
		('$this->cedula_persona','$this->nombre_usuario','$this->codigo_perfil','$user',NOW())";
		if($this->pgsql->Ejecutar($sqlx)!=null){
			$this->contrasena("12345678");
			$sql="INSERT INTO seguridad.tcontrasena (estado,nombre_usuario,contrasena,creado_por,fecha_creacion) VALUES 
			(3,'$this->nombre_usuario','$this->contrasena','$user',NOW())";
			$this->pgsql->Ejecutar($sql);
				return true;
		}
		else
			return false;
	}

	public function Intento_Fallido($bool){
		if($bool==true){
			$sql="UPDATE seguridad.tusuario SET intentos_fallidos=(intentos_fallidos+1),modificado_por='$this->nombre_usuario',fecha_modificacion=NOW() WHERE nombre_usuario='$this->nombre_usuario'";
		}else{ 
			$sql="UPDATE seguridad.tusuario SET intentos_fallidos=0,modificado_por='$this->nombre_usuario',fecha_modificacion=NOW() WHERE nombre_usuario='$this->nombre_usuario'";
		}
		if($this->pgsql->Ejecutar($sql)!=null){
			return true;
		}else
			return false;
	}

	public function Bloquear_Usuario(){
		$sql="SELECT u.intentos_fallidos FROM seguridad.tusuario u 
		INNER JOIN seguridad.tperfil p ON u.codigo_perfil = p.codigo_perfil 
		INNER JOIN seguridad.tconfiguracion c ON p.codigo_configuracion = c.codigo_configuracion 
		WHERE u.nombre_usuario='$this->nombre_usuario' AND u.intentos_fallidos >= c.intentos_fallidos";
		$sql_action="UPDATE seguridad.tcontrasena set estado=4,modificado_por='$this->nombre_usuario' where nombre_usuario='$this->nombre_usuario' and estado=1";
		$query=$this->pgsql->Ejecutar($sql);
		if($this->pgsql->Total_Filas($query)>0){
			$query=$this->pgsql->Ejecutar($sql_action);
			return true;
		}
		else{
			return false;
		}
	}

	public function DesbloquearUsuario($user){
		$sql="UPDATE seguridad.tcontrasena SET estado=1,modificado_por='$user',fecha_modificacion=NOW() WHERE nombre_usuario='$this->nombre_usuario' AND estado = 4";
		if($this->pgsql->Ejecutar($sql)!=null){
			return true;
		}else
			return false;
	}

	public function Buscar(){
    $sql="SELECT estado AS estado,
    CASE WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NOT NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NOT NULL THEN INITCAP(p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido||' '||p.segundo_apellido) 
    WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NOT NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NULL THEN INITCAP(p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido) 
    WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NOT NULL THEN INITCAP(p.primer_nombre||' '||p.primer_apellido||' '||p.segundo_apellido) 
    ELSE INITCAP(p.primer_nombre||' '||p.primer_apellido) END AS fullname_user, 
    (CASE WHEN (NOW() - CAST(conf.dias_vigenciaclave || ' DAY' AS INTERVAL)) < pas.fecha_creacion THEN '0' ELSE '1' END) AS caducidad,    
    INITCAP(pf.nombre_perfil) AS perfil,pf.codigo_perfil, 
	u.nombre_usuario AS name, pas.contrasena, 
	u.cedula_persona AS cedula,
	rs.pregunta AS preguntas,
	rs.respuesta AS respuestas,
    conf.dias_aviso,
    conf.numero_preguntas,
    conf.numero_preguntasaresponder 
	FROM general.tpersona AS p 
	INNER JOIN seguridad.tusuario AS u ON u.cedula_persona = p.cedula_persona
	INNER JOIN seguridad.tperfil AS pf ON pf.codigo_perfil = u.codigo_perfil 
	INNER JOIN seguridad.tconfiguracion AS conf ON pf.codigo_configuracion = conf.codigo_configuracion 
	INNER JOIN seguridad.tcontrasena AS pas ON pas.nombre_usuario=u.nombre_usuario
	LEFT JOIN seguridad.trespuesta_secreta AS rs ON u.nombre_usuario = rs.nombre_usuario 
	WHERE u.nombre_usuario='$this->nombre_usuario' AND pas.contrasena='$this->contrasena' 
	AND pas.estado<>0 AND u.estatus = '1' ORDER BY pas.fecha_creacion DESC";
	$query=$this->pgsql->Ejecutar($sql);
	while($Obj[]=$this->pgsql->Respuesta_assoc($query))
		$rows=$Obj;
	if(!empty($rows))
   		return $rows;
	else
	   return null;
	}

	public function Generar_NombreUsuario($cedula,$perfil){
		$sql="SELECT CONCAT(SUBSTRING(nombre_perfil,1,5),'$cedula') nombreusuario FROM seguridad.tperfil WHERE codigo_perfil = '$perfil'";
		$query = $this->pgsql->Ejecutar($sql);
		if($Obj=$this->pgsql->Respuesta($query)){
			return $Obj['nombreusuario'];
		}
		else return false;
	}

	public function Consultar_personal(){
		$sql="SELECT * FROM general.tpersona p 
		INNER JOIN general.ttipo_persona tp ON p.codigo_tipopersona = tp.codigo_tipopersona 
		WHERE cedula_persona='$this->cedula_persona' AND es_usuariosistema='Y'";
		$query=$this->pgsql->Ejecutar($sql);
		if($this->pgsql->Total_Filas($query)>0)
			return true;
		else
			return false;
	}

	public function Buscar_1(){
	$sql="SELECT CASE WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NOT NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NOT NULL THEN INITCAP(p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido||' '||p.segundo_apellido) 
    WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NOT NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NULL THEN INITCAP(p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido) 
    WHEN p.primer_nombre IS NOT NULL AND p.segundo_nombre IS NULL AND p.primer_apellido IS NOT NULL AND p.segundo_apellido IS NOT NULL THEN INITCAP(p.primer_nombre||' '||p.primer_apellido||' '||p.segundo_apellido) 
    ELSE INITCAP(p.primer_nombre||' '||p.primer_apellido) END AS fullname_user, 
	u.codigo_perfil,
	INITCAP(pf.nombre_perfil) AS perfil, 
	u.nombre_usuario AS name,
	c.contrasena AS password,
	u.cedula_persona as cedula_persona,
	rs.pregunta as preguntas,
	rs.respuesta as respuestas,
	c.estado as estado_clave,
    conf.numero_preguntas,
    conf.numero_preguntasaresponder 
	FROM general.tpersona AS p 
	INNER JOIN seguridad.tusuario AS u ON u.cedula_persona = p.cedula_persona
	INNER JOIN seguridad.tcontrasena c ON u.nombre_usuario = c.nombre_usuario AND c.estado <> 0
	INNER JOIN seguridad.tperfil AS pf ON pf.codigo_perfil = u.codigo_perfil 
	INNER JOIN seguridad.tconfiguracion AS conf ON pf.codigo_configuracion = conf.codigo_configuracion 
	LEFT JOIN seguridad.trespuesta_secreta rs ON u.nombre_usuario = rs.nombre_usuario 
	WHERE u.nombre_usuario='$this->nombre_usuario' and u.estatus = '1'
	ORDER BY RANDOM()";
	$query=$this->pgsql->Ejecutar($sql);
	while($Obj[]=$this->pgsql->Respuesta_assoc($query))
		$rows=$Obj;
	if(!empty($rows))
   		return $rows;
	else
	   return null;
	}

	public function CompletarDatos($user,$pnew,$rnew){
    	$con=0;
    	for($i=0;$i<count($pnew);$i++){
			$sql1="INSERT INTO seguridad.trespuesta_secreta (nombre_usuario,pregunta,respuesta,creado_por,fecha_creacion)
			VALUES ('$this->nombre_usuario','".$pnew[$i]."','".$rnew[$i]."','$user',NOW())";
			if($this->pgsql->Ejecutar($sql1)!=null)
				$con++;
			else
				$con--;
    	}
    	if($con==count($pnew))
    		return true;
    	else
    		return false;
	}

}
?>