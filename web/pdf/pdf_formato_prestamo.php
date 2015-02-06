<?php
require_once("../librerias/fpdf/fpdf.php");
require_once("../class/class_bd.php");
session_start();
class clsFpdf extends FPDF {
	var $widths;
	var $aligns;
	//Cabecera de página
	public function Header(){
		$this->Image("../images/cintillo.jpg" , 25 ,10, 170 , 25, "JPG" ,$_SERVER['HTTP_HOST']."/CHSB/web/");
		$this->Image("../images/logo.jpg" ,75,85,75,90, "JPG");
		$this->Ln(25);
		$pgsql=new Conexion();
		$sql="SELECT * FROM biblioteca.tprestamo
		WHERE codigo_prestamo =".$pgsql->comillas_inteligentes($_GET['p1'])."";	
		$data=$pgsql->Ejecutar($sql);
		$fila=array();
		while ($row=$pgsql->Respuesta($data)){
			$fila['codigo_prestamo'][]=$row['codigo_prestamo'];
		}
		$r1  = $this->w - 81;
		$r2  = $r1 + 60;
		$y1  = 49;
		$y2  = $y1 -39;
		$this->Ln(2);
		$this->SetFillColor(0,0,140); 
		$avnzar=18;
		$altura=4;
		$anchura=10;
		$color_fondo=false;
		$this->SetFont('Arial','B',10);
		$this->SetTextColor(0,0,0);
		$this->Cell($avnzar); 
		$this->Cell($anchura*2,$altura,"LICEO BOLIVARIANO BICENTENARIO",0,1,'L',$color_fondo);
		$this->Cell($avnzar); 
		$this->Cell($anchura*2,$altura,"DE LA INDEPENDENCIA DE VENEZUELA.",0,1,'L',$color_fondo);
		$this->SetFont('Arial','',8); 
		$this->Cell($avnzar); 
		$this->Cell($anchura*2,$altura,'RIF.: J-000000000',0,1,'L',$color_fondo);
		$this->Cell($avnzar);
		$this->Cell($anchura*2,$altura,'Complejo Habitacional',0,1,'L',$color_fondo);
		$this->Cell($avnzar);
		$this->Cell($anchura*2,$altura,'Simón Bolivar',0,1,'L',$color_fondo);
		$this->Cell($avnzar);
		$this->Cell($anchura*2,$altura,'Araure, Estado Portuguesa',0,1,'L',$color_fondo);
		$this->Cell($avnzar);
		$this->Cell($anchura*2,$altura,'Telf.: 0255-0000000',0,1,'L',$color_fondo);
		$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 1.5, 'D');
		$this->SetXY( $r1 + ($r2-$r1)/2 - 26, $y1+3 );
		$this->SetFont('Arial','B',10);
		$this->SetTextColor(0,0,0);
		$this->Cell($anchura*2,$altura,'Cód Préstamo: ',0,1,'L',$color_fondo);
		$this->SetXY( $r1 + ($r2-$r1)/2, $y1+3 );
		$this->SetFont('Arial','',10);
		$this->SetTextColor(0,0,0);
		$this->Cell($anchura*2,$altura,$fila['codigo_prestamo'][0],0,1,'R',$color_fondo);
		$this->Ln(5);
		$this->SetFont('Arial','BU',12);
		$this->SetTextColor(0,0,0);
		$this->Cell($avnzar); 
		$this->Cell($anchura*16,$altura,"Préstamos",0,1,'C',$color_fondo);
	}

	//Pie de página
	public function Footer(){
		$pgsql=new Conexion();
		$sql="SELECT e.primer_nombre||' '||e.primer_apellido AS elaborado_por,
		r.primer_nombre||' '||r.primer_apellido AS recibido_por
		FROM biblioteca.tprestamo a 
		INNER JOIN seguridad.tusuario u ON a.creado_por = u.nombre_usuario 
		INNER JOIN general.tpersona e ON u.cedula_persona = e.cedula_persona 
		INNER JOIN general.tpersona r ON a.cedula_persona = r.cedula_persona 
		WHERE a.codigo_prestamo =".$pgsql->comillas_inteligentes($_GET['p1'])."";
		$data=$pgsql->Ejecutar($sql);
		$fila=array();
		while ($row=$pgsql->Respuesta($data)){
			$fila['elaborado_por'][]=$row['elaborado_por'];
			$fila['recibido_por'][]=$row['recibido_por'];
		}
		$this->SetFont( "Arial", "B", 10);
		$this->SetXY(28,-60);
		$this->Cell(1);
		$this->SetFillColor(140,140,140);
		$this->SetWidths(array(80,80));
		$this->Row(array('Elaborado Por:','Recibido Por:'),true);
		$this->Cell(19);
		$this->SetFont("Arial","",10);
		$this->Row(array($fila['elaborado_por'][0],$fila['recibido_por'][0]),false);
		$this->SetFont('Arial','B',10);
		$this->Cell(60,10,"Fecha De Emisión: ",0,0,'R',false);
        $this->SetFont('Arial','',10);  
        $this->Cell(32,10,date("d/m/y H:i:s"),0,1,'R',false); 
		//Posición: a 2 cm del final
		$this->SetY(-20);
		//Arial italic 8
		$this->SetFont("Arial","I",8);
		//Dirección
		//Número de página
		$this->SetFont('Arial','',13);
		$this->SetFillColor(240,240,240);
		$this->SetTextColor(200, 200, 200);     
		$this->Cell(0,5,"______________________________________________________________________________________________________________",0,1,"C",false);
		$this->SetFont('Arial','',9);
		$this->SetTextColor(0,0,0);     
		$this->Cell(170);
		$this->Cell(25,8,'Página '.$this->PageNo()."/{nb}",0,1,'C',true);
		//Fecha
		//setlocale(LC_ALL,"es_VE.UTF8");
		$this->Ln(-9);
		$this->SetFont("Arial","I",6);
		$avanzar=30;
		$this->Cell($avanzar);
		$empresa="Liceo Bolivariano Bicentenario de la Independencia de Venezuela";
		$dir="Dirección: Complejo Habitacional Simon Bolivar, 3302 Acarigua";
		$tel="Teléfono: 04168110432";
		$empresa1="Todos los Derechos Reservados\"© 2014 FUNDABIT-DTIC.\"";
		$this->Cell(130,4,$empresa,0,1,"C");
		$this->Cell($avanzar);  
		$this->Cell(130,4,$dir,0,1,"C");
		$this->Cell($avanzar);  
		$this->Cell(130,4,$tel,0,1,"C");
	}

	function SetWidths($w){
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a){
		//Set the array of column alignments
		$this->aligns=$a;
	}

	function Row($data,$color){
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++){
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			//Print the text
			if((count($data)-1)==$i && (strtolower($data[count($data)-1])=='desactivado'))        
				$this->SetTextColor(255, 0, 0);
			else 
				$this->SetTextColor(0, 0, 0);
			$this->MultiCell($w,5,$data[$i],0,$a,$color);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h){
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt){
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb){
			$c=$s[$i];
			if($c=="\n"){
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax){
				if($sep==-1){
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
			$i++;
		}
		return $nl;
	}

	public function RoundedRect($x, $y, $w, $h, $r, $style = ''){
		$k = $this->k;
		$hp = $this->h;
		if($style=='F')
			$op='f';
		elseif($style=='FD' || $style=='DF')
			$op='B';
		else
			$op='S';
		$MyArc = 4/3 * (sqrt(2) - 1);
		$this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
		$xc = $x+$w-$r ;
		$yc = $y+$r;
		$this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));
		$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
		$xc = $x+$w-$r ;
		$yc = $y+$h-$r;
		$this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
		$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
		$xc = $x+$r ;
		$yc = $y+$h-$r;
		$this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
		$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
		$xc = $x+$r ;
		$yc = $y+$r;
		$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
		$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
		$this->_out($op);
	}

	public function _Arc($x1, $y1, $x2, $y2, $x3, $y3){
		$h = $this->h;
		$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
		$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
	}
}

//generar el listado 
setlocale(LC_ALL,"es_VE.UTF8");
$lobjPdf=new clsFpdf();
$lobjPdf->AddPage("P");
$lobjPdf->AliasNbPages();
$lobjPdf->Ln(15);
//Table with 20 rows and 5 columns
$lobjPdf->SetWidths(array(80,40,20));
$pgsql=new Conexion();
$sql="SELECT a.codigo_prestamo,a.cedula_responsable||' '||r.primer_nombre||' '||r.primer_apellido AS responsable,
p.telefono_movil,a.cedula_persona||' '||p.primer_nombre||' '||p.primer_apellido AS persona,
ar.descripcion AS area,a.cota,TO_CHAR(a.fecha_salida,'DD/MM/YYYY') AS fecha_salida, 
TO_CHAR(a.fecha_entrada,'DD/MM/YYYY') AS fecha_entrada,
da.codigo_ejemplar||' - '||l.codigo_isbn_libro||' '||l.titulo AS ejemplar,da.cantidad,
   u.codigo_ubicacion||' '||u.descripcion AS ubicacion
  FROM biblioteca.tprestamo a 
  INNER JOIN general.tpersona r ON a.cedula_responsable = r.cedula_persona 
  INNER JOIN general.tpersona p ON a.cedula_persona = p.cedula_persona
  INNER JOIN general.tarea ar ON a.codigo_area = ar.codigo_area  
  INNER JOIN biblioteca.tdetalle_prestamo da ON a.codigo_prestamo = da.codigo_prestamo 
  LEFT JOIN biblioteca.tejemplar b ON da.codigo_ejemplar = b.codigo_ejemplar 
  INNER JOIN biblioteca.tlibro l on b.codigo_isbn_libro=l.codigo_isbn_libro 
  INNER JOIN inventario.tubicacion u ON da.codigo_ubicacion = u.codigo_ubicacion
  WHERE a.codigo_prestamo =".$pgsql->comillas_inteligentes($_GET['p1']);
$i=-1;
$data=$pgsql->Ejecutar($sql);
if($pgsql->Total_Filas($data)!=0){
	$filas=array();
	while($rows=$pgsql->Respuesta($data)){
		$filas['codigo_prestamo'][]=$rows['codigo_prestamo'];
		$filas['responsable'][]=$rows['responsable'];
		$filas['telefono_movil'][]=$rows['telefono_movil'];
		$filas['persona'][]=$rows['persona'];
		$filas['area'][]=$rows['area'];
		$filas['cota'][]=$rows['cota'];
		$filas['fecha_salida'][]=$rows['fecha_salida'];
		$filas['fecha_entrada'][]=$rows['fecha_entrada'];
		$filas['ejemplar'][]=$rows['ejemplar'];
		$filas['cantidad'][]=$rows['cantidad'];
		$filas['ubicacion'][]=$rows['ubicacion'];
	}
	$lobjPdf->SetFillColor(0,0,140); 
	$avnzar=18;
	$altura=4;
	$anchura=10;
	$color_fondo=false;
	$lobjPdf->Cell($avnzar*1.95);
	$lobjPdf->SetFont('Arial','B',10);
	$lobjPdf->SetTextColor(0,0,0);
	$lobjPdf->Cell($anchura*2,$altura,'Responsable: ',0,0,'R',$color_fondo);
	$lobjPdf->SetFont('Arial','',9);
	$lobjPdf->SetTextColor(0,0,0); 
	$lobjPdf->Cell($anchura*2,$altura,$filas['responsable'][0],0,1,'L',$color_fondo);
	$lobjPdf->Cell($avnzar*1.61);
	$lobjPdf->SetFont('Arial','B',10);
	$lobjPdf->SetTextColor(0,0,0);
	$lobjPdf->Cell($anchura*2,$altura,'Teléfono: ',0,0,'L',$color_fondo);
	$lobjPdf->SetFont('Arial','',9);
	$lobjPdf->SetTextColor(0,0,0); 
	$lobjPdf->Cell($avnzar-11);
	$lobjPdf->Cell($anchura*2,$altura,$filas['telefono_movil'][0],0,1,'L',$color_fondo);
	$lobjPdf->Cell($avnzar*1.61);
	$lobjPdf->SetFont('Arial','B',10);
	$lobjPdf->SetTextColor(0,0,0);
	$lobjPdf->Cell($anchura*2,$altura,'Fecha Salida: ',0,0,'L',$color_fondo);
	$lobjPdf->SetFont('Arial','',9);
	$lobjPdf->SetTextColor(0,0,0); 
	$lobjPdf->Cell($avnzar-11);
	$lobjPdf->Cell($anchura*8,$altura,$filas['fecha_salida'][0],0,1,'L',$color_fondo);
	$lobjPdf->Cell($avnzar*1.61);
	$lobjPdf->SetFont('Arial','B',10);
	$lobjPdf->SetTextColor(0,0,0);
	$lobjPdf->Cell($anchura*2,$altura,'Fecha Entrada: ',0,0,'L',$color_fondo);
	$lobjPdf->SetFont('Arial','',9);
	$lobjPdf->SetTextColor(0,0,0); 
	$lobjPdf->Cell($avnzar-11);
	$lobjPdf->Cell($anchura*8,$altura,$filas['fecha_entrada'][0],0,1,'L',$color_fondo);
	$lobjPdf->Ln(20);
	$lobjPdf->Cell($avnzar);
	$lobjPdf->SetFont("arial","B",10);
	$lobjPdf->Row(array('Ubicación','Ejemplar','Cantidad'),false);
	$lobjPdf->SetFont("arial","",10);
	$lobjPdf->Cell($avnzar);
	$lobjPdf->aligns[2]='R';
	$total=0;
	for($i=0;$i<count($filas['codigo_prestamo']);$i++){
		$total+=$filas['cantidad'][$i];
		$lobjPdf->Row(array(
		$filas['ubicacion'][$i],
		$filas['ejemplar'][$i],
		$filas['cantidad'][$i]),false);
		$lobjPdf->Cell($avnzar);
	}
	$lobjPdf->SetWidths(array(130,20));
	$lobjPdf->SetFont("arial","B",10 ,'R');
	$lobjPdf->Cell($avnzar*6.67,$altura,'TOTAL:',1,0,'R',$color_fondo);
	$lobjPdf->Cell($avnzar*1.11,$altura,$total,1,1,'R',$color_fondo);
	$lobjPdf->ln(10);
	$lobjPdf->Output('documento',"I");
}else{
	echo "ERROR AL GENERAR ESTE REPORTE!";          
}
?>