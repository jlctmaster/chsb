<?php
$id_hora=array();
$turno='todos';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Horario</title>
		<link rel="stylesheet" href="../css/estilo-03.css" />
		<link rel="stylesheet" href="../css/estilo-02.css" />
		<script src="js/chsb_horario.js"></script>
		<style>
			select{
				width: auto;     	
			}
		</style>
	</head>
	<body>
		<div id="xx">
			<section>
				<form class="form-horizontal" action="../controllers/control_horario.php" method="post" id="form1">  
					<fieldset>
						<legend><center>Vista: HORARIO DE LA SECCIÓN</center></legend>		
						<div id="paginador" class="enjoy-css">				
							<?php
							include_once("../class/class_horario.php");
							$bloque_horas=new horario();
							$get_hora=$bloque_horas->bloque_hora($turno);
							$lapso_actual=$bloque_horas->lapso_actual();      
							?>
							<h2><?php echo $lapso_actual['nombre_lapso_actual'][0];?>  </h2>
							<form class="form-horizontal" action="../controllers/control_horario.php" method="post" id="form1">  
								<input type="hidden" id="codigo_ano_academico" name="codigo_ano_academico" value="<?php echo $lapso_actual['codigo_ano_academico'][0];?>" />
								<table id="filtro_tabla_horario" >
									<tr>
										<td><label>Ambiente</label>
											<select class="bootstrap-select form-control" id="codigo_ambiente" name="codigo_ambiente">
												<?php 
												include_once("../class/class_html.php");
												$html=new Html();
												$id="codigo_ambiente";
												$descripcion="descripcion";
												$sql="SELECT * FROM general.tambiente WHERE tipo_ambiente <> '3' AND estatus = '1' ORDER BY codigo_ambiente";
												$Seleccionado='null';
												$html->Generar_Opciones($sql,$id,$descripcion,$Seleccionado); 
												?>
											</select>
										</td>
										<td><label>Sección</label>
											<select class="bootstrap-select form-control" id="seccion" name="seccion" >
												<?php 
												include_once("../class/class_html.php");
												$html=new Html();
												$id="seccion";
												$descripcion="nombre_seccion";
												$sql="SELECT * FROM educacion.tseccion WHERE estatus = '1' ORDER BY seccion";
												$Seleccionado='null';
												$html->Generar_Opciones($sql,$id,$descripcion,$Seleccionado); 
												?>
											</select>
										</td>
									</tr>
									<tr> 
										<td><label>Profesor</label>
											<input class="input-xlarge" type="text" name="cedula_persona" id="cedula_persona" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 /> 
										</td>
										<td><label>Materia</label>
											<select class="bootstrap-select form-control" id="codigo_materia" name="codigo_materia" disabled="">
												<option value="">Elige una opción...</option>
											</select>
										</td>
									</tr>
								</table>	
								<img src="../images/add.png" alt="" style="cursor:pointer" title="Agregar" id="btaceptar">
								<input value="<?php echo $turno;?>" type="hidden" name="turno" id="turno"/>
								<br><br>
								<table id="tb_horario">
									<CAPTION>FORMULARIO HORARIO </CAPTION>
									<tr>
										<td rowspan=2>Hora</td>
										<td colspan=7>Día de la Semana</td>
									</tr>
									<tr>
										<td>Lunes</td>
										<td>Martes</td>
										<td>Miércoles</td>
										<td>Jueves</td>
										<td>Viernes</td>
										<td>Sabado</td>
										<td>Domingo</td>
									</tr>
									<?php 
									for($i=0;$i<count($get_hora['id']);$i++){
										if(!isset($_SESSION['datos']['dia'])){
									?>
									<tr>
										<td>
										<?php  
											$hora=$get_hora['hora_inicio'][$i]."<br>".$get_hora['hora_fin'][$i]; 
											echo $hora;
											$x=trim($get_hora['id'][$i]);
										?>
										</td>
										<td id="<?php echo $x."-1"; ?>" title="<?php echo $hora;?>" <?php if(in_array($x."-1",$id_hora,true)) echo "class='h_academica'";  ?>>  </td>
										<td id="<?php echo $x."-2"; ?>" title="<?php echo $hora;?>"  <?php if(in_array($x."-2",$id_hora,true)) echo "class='h_academica'";  ?>>  </td>
										<td id="<?php echo $x."-3"; ?>" title="<?php echo $hora;?>"  <?php if(in_array($x."-3",$id_hora,true)) echo "class='h_academica'";  ?>>  </td>
										<td id="<?php echo $x."-4"; ?>" title="<?php echo $hora;?>"  <?php if(in_array($x."-4",$id_hora,true)) echo "class='h_academica'"; ?>>  </td>
										<td id="<?php echo $x."-5"; ?>" title="<?php echo $hora;?>"  <?php if(in_array($x."-5",$id_hora,true)) echo "class='h_academica'"; ?>>  </td>
										<?php 
											if($get_hora['id_turno'][$i]!='N'){ 
										?>
										<td id="<?php echo $x."-6"; ?>"  title="<?php echo $hora;?>"  class="weekend_noche"><i>No Laboral</i></td>
										<td id="<?php echo $x."-0"; ?>"  title="<?php echo $hora;?>"  class="weekend_noche"><i>No Laboral</i></td>
										<?php
											}else{
										?>
										<td id="<?php echo $x."-6"; ?>" title="<?php echo $hora;?>" <?php if(in_array($x."-6",$id_hora,true)) echo "class='h_academica'"; ?>>  </td>
										<td id="<?php echo $x."-0"; ?>" title="<?php echo $hora;?>" <?php if(in_array($x."-0",$id_hora,true)) echo "class='h_academica'"; ?>>  </td>
										<?php }?>
									</tr>
									<?php
										}else{
									?>
										<tr>
										<td>
										<?php 
											echo $get_hora['hora_inicio'][$i]."-".$get_hora['hora_fin'][$i];
											$x=trim($get_hora['id'][$i]);
										?>	
										</td>
										<td id="<?php echo $x."-1"; ?>" <?php if(in_array($x."-1",@$id_hora,true)) echo "class='h_academica'";?> <?php if(in_array($x."-1",$id_celda,true)) echo "class='asignado'";?>> <?php if(in_array($x."-1",$id_celda,true)){$valor=array_search($x."-1",$id_celda);echo "Asignado<input id='$x-1_vo' type='hidden' name='contenidos[]' value='".$id_celda[$valor]."-".$ambiente[$valor]."-".$desc[$valor]."'/>"."<img src='Imagenes/pst-ver.gif' alt='".$desc[$valor]."'/>";} ?>  </td>
										<td id="<?php echo $x."-2"; ?>" <?php if(in_array($x."-2",@$id_hora,true)) echo "class='h_academica'";?> <?php if(in_array($x."-2",$id_celda,true)) echo "class='asignado'";?>> <?php if(in_array($x."-2",$id_celda,true)){$valor=array_search($x."-2",$id_celda);echo "Asignado<input id='$x-2_vo' type='hidden' name='contenidos[]' value='".$id_celda[$valor]."-".$ambiente[$valor]."-".$desc[$valor]."'/>"."<img src='Imagenes/pst-ver.gif' alt='".$desc[$valor]."'/>";} ?>  </td>
										<td id="<?php echo $x."-3"; ?>" <?php if(in_array($x."-3",@$id_hora,true)) echo "class='h_academica'";?> <?php if(in_array($x."-3",$id_celda,true)) echo "class='asignado'";?>> <?php if(in_array($x."-3",$id_celda,true)){$valor=array_search($x."-3",$id_celda);echo "Asignado<input id='$x-3_vo' type='hidden' name='contenidos[]' value='".$id_celda[$valor]."-".$ambiente[$valor]."-".$desc[$valor]."'/>"."<img src='Imagenes/pst-ver.gif' alt='".$desc[$valor]."'/>";} ?>  </td>
										<td id="<?php echo $x."-4"; ?>" <?php if(in_array($x."-4",@$id_hora,true)) echo "class='h_academica'";?> <?php if(in_array($x."-4",$id_celda,true)) echo "class='asignado'";?>> <?php if(in_array($x."-4",$id_celda,true)){$valor=array_search($x."-4",$id_celda);echo "Asignado<input id='$x-4_vo' type='hidden' name='contenidos[]' value='".$id_celda[$valor]."-".$ambiente[$valor]."-".$desc[$valor]."'/>"."<img src='Imagenes/pst-ver.gif' alt='".$desc[$valor]."'/>";} ?>  </td>
										<td id="<?php echo $x."-5"; ?>" <?php if(in_array($x."-5",@$id_hora,true)) echo "class='h_academica'";?> <?php if(in_array($x."-5",$id_celda,true)) echo "class='asignado'";?>> <?php if(in_array($x."-5",$id_celda,true)){$valor=array_search($x."-5",$id_celda);echo "Asignado<input id='$x-5_vo' type='hidden' name='contenidos[]' value='".$id_celda[$valor]."-".$ambiente[$valor]."-".$desc[$valor]."'/>"."<img src='Imagenes/pst-ver.gif' alt='".$desc[$valor]."'/>";} ?>  </td>
										<?php 
											if($get_hora['id_turno'][$i]!='N'){
										?>
										<td id="<?php echo $x."-6"; ?>"  class="weekend_noche" <?php if(in_array($x."-6",@$id_hora,true)) echo "class='h_academica'";?> <?php if(in_array($x."-6",$id_celda,true)) echo "class='asignado'";?> > <i>No Laborable</i> <?php if(in_array($x."-6",$id_celda,true)){$valor=array_search($x."-6",$id_celda);echo "Asignado<input id='$x-6_vo' type='hidden' name='contenidos[]' value='".$id_celda[$valor]."-".$ambiente[$valor]."-".$desc[$valor]."'/>"."<img src='Imagenes/pst-ver.gif' alt='".$desc[$valor]."'/>";} ?>  </td>
										<td id="<?php echo $x."-0"; ?>"  class="weekend_noche" <?php if(in_array($x."-0",@$id_hora,true)) echo "class='h_academica'";?> <?php if(in_array($x."-0",$id_celda,true)) echo "class='asignado'";?> ><i>No Laborable</i> <?php if(in_array($x."-0",$id_celda,true)){$valor=array_search($x."-0",$id_celda);echo "Asignado<input id='$x-0_vo' type='hidden' name='contenidos[]' value='".$id_celda[$valor]."-".$ambiente[$valor]."-".$desc[$valor]."'/>"."<img src='Imagenes/pst-ver.gif' alt='".$desc[$valor]."'/>";} ?>  </td>
										<?php
											}else{
										?>
										<td id="<?php echo $x."-6"; ?>" <?php if(in_array($x."-6",@$id_hora,true)) echo "class='h_academica'";?> <?php if(in_array($x."-6",$id_celda,true)) echo "class='asignado'";?>><?php if(in_array($x."-6",$id_celda,true)){$valor=array_search($x."-6",$id_celda);echo "Asignado<input id='$x-6_vo' type='hidden' name='contenidos[]' value='".$id_celda[$valor]."-".$ambiente[$valor]."-".$desc[$valor]."'/>"."<img src='Imagenes/pst-ver.gif' alt='".$desc[$valor]."'/>";} ?>  </td>
										<td id="<?php echo $x."-0"; ?>" <?php if(in_array($x."-0",@$id_hora,true)) echo "class='h_academica'";?> <?php if(in_array($x."-0",$id_celda,true)) echo "class='asignado'";?>><?php if(in_array($x."-0",$id_celda,true)){$valor=array_search($x."-0",$id_celda);echo "Asignado<input id='$x-0_vo' type='hidden' name='contenidos[]' value='".$id_celda[$valor]."-".$ambiente[$valor]."-".$desc[$valor]."'/>"."<img src='Imagenes/pst-ver.gif' alt='".$desc[$valor]."'/>";} ?>  </td>		   
										<?php
											}
										?>
										</tr>
									<?php
										}
									}
									?>
									<tr>
										<td colspan=8>
										<br>
										<br>
										<button type="button" id="btnGuardar" class="btn btn-large btn-primary"> <i class="icon-hdd"></i>&nbsp;Aceptar</button>
										<a href="?horario"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
									</tr>
									<tr>
										<td>Asignado</td>
										<td>Libre</td>
										<td>Total</td>
									</tr>
									<tr>
										<td id="celdaasignado" class=""><?php  //echo count(@$id_celda);?> </td>
										<td id="celdalibre" class=""><?php //echo (@$_SESSION['datos']['hora_ad']-count(@$id_celda));?></td> 
										<td id="celdatotal" class=""><?php //echo @$_SESSION['datos']['hora_ad'];?></td>
									</tr>
									<tr>
										<td colspan=3><?php echo "Turno: ".ucwords(str_replace("manana","mañana",$turno));?></td>
									</tr>
								</table>
								<input  type="hidden" value="0<?php //echo @$_SESSION['datos']['hora_ad'];?>" id="T"/>
								<input  type="hidden" value="0<?php //echo (@$_SESSION['datos']['hora_ad']-count(@$id_celda));?>" id="L"/>
								<input  type="hidden" value="0<?php //echo count(@$id_celda);?>" id="A"/>
							</fieldset>
						</form>
					</fieldset>
				</form>
			</section>
		</div> 
	</body>
</html>
<?php 
if(isset($_SESSION['datos']['mensaje']))
		echo "<script>alert('".$_SESSION['datos']['mensaje']."')</script>";
if(isset($_SESSION['datos'])) 
		unset($_SESSION['datos']); 
?>