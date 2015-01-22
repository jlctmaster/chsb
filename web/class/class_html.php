<?php
require_once("class_bd.php");
require_once("class_perfil.php");
class Html 
{
	private $c,$con;
	public function __construct()
	{
		$this->c=new Conexion();
	}
	
	public function __destruct()
	{	  
	}
	
	public function Generar_Opciones($sql,$codigo,$descripcion,$Seleccionado)
	{ 
		$lbResultado=false;
		
		$query=$this->c->Ejecutar($sql);
		$Seleccionado!="null"? 
		$opcion_inicial="<option value='null' > Elige una opcion...</option>": $opcion_inicial="<option value='' selected> Elige una opcion...</option>";
		echo $opcion_inicial;
		while($Datos=$this->c->Respuesta($query))
		{
			$lbResultado=true;
			$id=$Datos[$codigo];
			$value=$Datos[$descripcion];
			if ($id==$Seleccionado)
			{
				echo "<option value='$id' selected> $value</option>";
			}
			else
			{
				echo "<option value='$id'>$value</option>";
			}
		}
		return $lbResultado;
	}
	
	public function Generar_checkbox($sql,$codigo,$descripcion,$Seleccionado)
	{ 
		$lbResultado=false;
		$query=$this->c->Ejecutar($sql);
		$x=-1;
		while($Datos=$this->c->Respuesta($query))
		{
			$x++;			    
			$lbResultado=true;
			$id=$Datos[$codigo];
			$value=$Datos[$descripcion];
			$var=false;
			if(is_array($Seleccionado)){
				$var=in_array($id,$Seleccionado);			   	
			}
			if (is_array($Seleccionado)==true && $var==true)
			{
				echo $value."<input type='checkbox' value='".$id."' name='".$codigo."[]' id='".$codigo.$x."' checked />&nbsp; | &nbsp;";
			}
			else
			{
				echo $value."<input type='checkbox'  value='".$id."' name='".$codigo."[]' id='".$codigo.$x."' />&nbsp;|&nbsp; ";
			}
		}
		// $this->c->Liberar_Resultado($Datos);
		return $lbResultado;
	}
	

	public function tabla_accesos($perfil_usuario)
	{
		echo "<script>
		function checkear(param){
			var x=0;
			var AB = document.getElementsByClassName(param);
			for(i=1;i<AB.length;i++){
				if(AB[i].checked){
					AB[0].checked=true;
					x++;
				}
			}
			if(AB[0].checked==true && x==0){
				AB[0].checked=false;
				return false;
			}
		}
		
		function checkear2(param){
			var x=0;
			var AB = document.getElementsByClassName(param);
			if(AB[0].checked){
				prompt('yes')               	
			}	            
			for(i=1;i<AB.length;i++){
				if(AB[i].checked){
					AB[0].checked=true;
					x++;
				}
			}
			if(AB[0].checked==true && x==0){
				AB[0].checked=false;
				return false;
			}
		}
		
		
		function seleccionar_todos(param){
			
			var t=document.getElementsByTagName('input');

			for(i=0;i<t.length;i++){
				if(t[i].type=='checkbox')
					t[i].checked=param; 
			}
			document.getElementById('todos').checked=true;
			if(param==true){
				document.getElementById('todos').checked=true;
				document.getElementById('ninguno').checked=false;
			}else{
				document.getElementById('todos').checked=false;
				document.getElementById('ninguno').checked=true;
			}            	
		}

		</script>"; 
		$perfil=new Perfil();
		$query=$this->c->Ejecutar("SELECT * FROM seguridad.tmodulo where estatus = '1' ORDER BY orden ASC");
		echo "Todos&nbsp;&nbsp;
		<input onclick=seleccionar_todos(true) type='checkbox' name='todos' id='todos'/> 
		/ Ninguno&nbsp;&nbsp;<input onclick=seleccionar_todos(false) type='checkbox' name='ninguno' id='ninguno'/>";		 
		echo "<table class='table table-striped table-bordered table-condensed'>";
		echo "<tr><td>SERVICIOS / OPCIONES</td><td><table class='options'><tr>";
		$query3=$this->c->Ejecutar("SELECT * FROM seguridad.topcion where estatus = '1' ORDER BY orden ASC");
		 while($Datos3=$this->c->Respuesta($query3)){  //opciones
		 	echo "<td>".$Datos3['nombre_opcion']."</td>";
		 }
		 echo "</tr></table></td></tr>";
		 while($Datos1=$this->c->Respuesta($query)) // modulos
		 {
		 	$query2=$this->c->Ejecutar("SELECT * FROM seguridad.tservicio where codigo_modulo='".$Datos1['codigo_modulo']."' AND estatus = '1'");         	
		 	echo "<tr class='theader'>";
		 	echo "<th align='left' style='color:#FFFFFF;'><input type='hidden' value='".$Datos1['codigo_modulo']."' name='modulos[]'/>"."&nbsp;&nbsp;&nbsp;".$Datos1['nombre_modulo']."</th><th>".""."</th>";
		 	echo "</tr>";
	           while($Datos2=$this->c->Respuesta($query2)){  // servicios
	           	$perfil->codigo_perfil($perfil_usuario);
	           	$perfil->codigo_servicio($Datos2['codigo_servicio']);             	       	
	           	$perfil->Consultar_SERVICIOS()==true? $checked='checked': $checked='';
	           	echo "<tr>";
	           	echo "<td align='left' style='padding-left:2em;'>"; 
	           	echo "<input onclick=checkear2(this.class) class='cls_".$Datos2['codigo_servicio']."' $checked type='checkbox' name='servicios[]' value='".$Datos2['codigo_servicio']."'/>"; 
	           	echo $Datos2['nombre_servicio']; 
	           	echo "</td>"; 
	           	$query3=$this->c->Ejecutar("SELECT * FROM seguridad.topcion where estatus = '1' ORDER BY orden ASC");
	           	echo "<td><table class='options'><tr>"; 
	           	
	                   while($Datos3=$this->c->Respuesta($query3)){  //opciones
	                   	echo "<td>";          	
	                   	$perfil->codigo_opcion($Datos3['codigo_opcion']);             	       	
	                   	$perfil->Consultar_OPCIONES()==true? $checked='checked': $checked='';
	                   	echo "<center><input onclick=checkear('cls_".$Datos2['codigo_servicio']."') 
	                   	class='cls_".$Datos2['codigo_servicio']."'
	                   	$checked type='checkbox' value='".$Datos3['codigo_opcion']."' 
	                   	name='opciones[".$Datos2['codigo_servicio']."][]'/></center>"."                      ";
	                   	echo "</td>";          	
	                   }   
                   echo "</tr></table></td>";    	 
                   echo "</tr>";
	            }
	        }
	        echo "<tr><td colspan=2><center>FIN DE SERVICIOS</center></td></tr></table>";		 
	       }   
	   }
	   ?>