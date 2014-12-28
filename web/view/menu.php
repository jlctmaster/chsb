<div id="header">
	<div class="top">
		<!-- Logo -->
		<div id="logo">
			<span class="image"><img src="images/SIGEBIB.png" alt="" /></span>
			<?php
			echo '<h1 id="title">'.$_SESSION['fullname_user'].'</h1>';
			echo '<span class="byline">'.$_SESSION['user_perfil'].'</span>';
			?>
		</div>

		<!-- Nav -->
		<div class="accordion" id="leftMenu">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" href="./menu_principal.php">
						Principal <i class="icon-home icon-white"></i> 
					</a>
				</div>
			</div>
			<?php  
			require_once("../class/class_perfil.php");
			$perfil=new Perfil();
			$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
			$a=$perfil->IMPRIMIR_MODULOS();
			for($x=0;$x<count($a);$x++) {
				$titulo=$a[$x]['nombre_modulo'];
				echo '	
				<div class="accordion-group">
				<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#collapse_'.$x.'">
				'.$a[$x]['nombre_modulo'].'<i class="'.$a[$x]['icono'].' icon-white"></i> 
				</a>
				</div>
				<div id="collapse_'.$x.'" class="accordion-body collapse" style="height: 0px; ">
				<div class="accordion-inner">
				<ul class="navi">';
				$perfil->codigo_modulo($a[$x]['codigo_modulo']);
				$b=$perfil->IMPRIMIR_SERVICIOS();
				for($y=0;$y<count($b);$y++) {
					echo 	'<li><a href="menu_principal.php?'.$b[$y]['url'].'">'.$b[$y]['nombre_servicio'].'</a></li>';
				}
				echo '</ul>
				</div>
				</div>
				</div> ';
			}
			?>
		<!--	<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" onclick="salir()">
						Salir <i class="icon-off icon-white"></i>
					</a>
				</div>
			</div>  -->
		</div>
	</div>
</div>