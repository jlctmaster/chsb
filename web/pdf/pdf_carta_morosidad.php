<?php
session_start();
require_once("../librerias/fpdf/fpdf.php");
require_once("../class/class_bd.php");
class clsFpdf extends FPDF {
  var $widths;
  var $aligns;

  /*************************************
  Devuelve una cadena con la fecha que se 
  le manda como parámetro en formato largo.
  *************************************/
  function FechaFormateada2($FechaStamp){ 
    $ano = date('Y',$FechaStamp);
    $mes = date('n',$FechaStamp);
    $dia = date('d',$FechaStamp);
    $diasemana = date('w',$FechaStamp);

    $diassemanaN= array("Domingo","Lunes","Martes","Miércoles",
    "Jueves","Viernes","Sábado"); $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
    "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    return "$dia de ". $mesesN[$mes] ." de $ano";
  }

  //Cabecera de página
  public function Header(){
    //  Fecha
    $fecha = time();

    $this->Image("../images/cintillo.jpg" , 25 ,10, 170 , 25, "JPG" ,$_SERVER['HTTP_HOST']."/CHSB/web/");
    $this->Image("../images/logo.jpg" ,45,85,115,105, "JPG");
    $this->Ln(30);
    $this->SetFont('Arial','',12);
    $this->Cell(150);  
    $this->Cell(23,5,"Acarigua, ".$this->FechaFormateada2($fecha),0,1,'R',false); 
    $this->Ln(10); 
    $this->SetFont('Arial','B',16);
    $this->Cell(65);
    $this->Cell(69,5,'CARTA DE MOROSIDAD',0,0,'R');
    $this->Ln(15);
    $this->SetFont("Arial","B",12);
    $avanzar=10;
    $this->Cell($avanzar);
    $empresa="Centro de Recursos para el Aprendizaje (C.R.A)";
    $dir="Liceo Bolivariano Bicentenario de la Independencia de Venezuela.";
    $this->Cell(130,4,$empresa,0,1,"L");
    $this->Ln(2); 
    $this->Cell($avanzar); 
    $this->SetFont("Arial","",12);
    $this->Cell(130,4,$dir,0,1,"L");
    $this->Ln(10); 
    $this->SetFont("Arial","B",10);
    $this->Cell($avanzar);
    $this->Cell(60,4,'Atención:',0,0,'L');
    $this->Ln(4); 
    $this->Cell($avanzar);
    $this->Cell(80,5,'_____________________',0,1,"L");
  }

  //Pie de página
  public function Footer(){
    $pgsql=new Conexion();
    $sql="SELECT p.primer_nombre||' '||p.primer_apellido AS responsable
    FROM seguridad.tusuario u 
    INNER JOIN general.tpersona p ON u.cedula_persona = p.cedula_persona 
    WHERE u.nombre_usuario = '".$_SESSION['user_name']."'";
    $data=$pgsql->Ejecutar($sql);
    $fila=array();
    while($rows=$pgsql->Respuesta($data)){
    $filas['responsable'][]=$rows['responsable'];
    }
    $this->Cell(20);
    $this->SetFont('Arial','',12);
    $this->Cell(80,5,'Atentamente,',0,1,"L");
    $this->Ln(3);
    $this->Cell(10);
    $this->Cell(80,5,'__________________________________',0,1,"L");
    $this->Ln(3);
    $this->SetFont('Arial','B',12);
    $this->Cell(10);
    $this->Cell(65,5,$filas['responsable'][0],0,1,"L");
    $this->Ln(3);
    $this->SetFont('Arial','B',12);
    $this->Cell(10);
    $this->Cell(69,5,'COORDINACIÓN C.R.A.',0,0,"L");
    //Posición: a 2 cm del final
    $this->SetY(-20);
    //Arial italic 8
    $this->SetFont("Arial","I",8);
    //Dirección
    //Número de página
    $this->SetFont('Arial','',13);
    $this->SetFillColor(240,240,240);
    $this->SetTextColor(200, 200, 200);     
    $this->Cell(0,5,"______________________________________________________________________________________________________________",0,1,"L",false);
    $this->SetFont('Arial','',9);
    $this->SetTextColor(0,0,0);     
    $this->Cell(254);
    $this->Cell(25,8,'Página '.$this->PageNo()."/{nb}",0,1,'C',true);
    $this->Ln(-9);
    $this->SetFont("Arial","I",8);
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
$lobjPdf->AddPage("P,Letter");
$lobjPdf->AliasNbPages();
$lobjPdf->Ln(15);
$pgsql=new Conexion();
$sql="SELECT p.cedula_persona,
CASE WHEN p.segundo_nombre IS NOT NULL AND p.segundo_apellido IS NOT NULL THEN p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido||' '||p.segundo_apellido 
WHEN p.segundo_nombre IS NOT NULL AND p.segundo_apellido IS NULL THEN p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido
WHEN p.segundo_nombre IS NULL AND p.segundo_apellido IS NOT NULL THEN p.primer_nombre||' '||p.primer_apellido||' '||p.segundo_apellido 
ELSE p.primer_nombre||' '||p.primer_apellido END AS fullname,tp.descripcion AS tipo_persona, 
e.codigo_cra||' '||l.titulo AS libro,da.cantidad-COALESCE((SELECT SUM(de.cantidad) FROM biblioteca.tentrega e INNER JOIN biblioteca.tdetalle_entrega de ON e.codigo_entrega = de.codigo_entrega 
WHERE e.codigo_prestamo = b.codigo_prestamo AND da.codigo_ejemplar = de.codigo_ejemplar),0) AS cantidad,TO_CHAR(b.fecha_salida,'DD/MM/YYYY') AS fecha_salida, 
TO_CHAR(b.fecha_entrada,'DD/MM/YYYY') AS fecha_vencimiento
FROM  biblioteca.tprestamo b 
INNER JOIN biblioteca.tdetalle_prestamo da ON b.codigo_prestamo = da.codigo_prestamo 
INNER JOIN biblioteca.tejemplar e ON da.codigo_ejemplar = e.codigo_ejemplar 
INNER JOIN biblioteca.tlibro l on e.codigo_isbn_libro=l.codigo_isbn_libro 
INNER JOIN general.tpersona p ON b.cedula_persona = p.cedula_persona 
INNER JOIN general.ttipo_persona tp ON p.codigo_tipopersona = tp.codigo_tipopersona 
WHERE b.cedula_persona = '".$_POST['cedula_persona']."'"; 
$i=-1;
$data=$pgsql->Ejecutar($sql);
if($pgsql->Total_Filas($data)!=0){
  $filas=array();
  while($rows=$pgsql->Respuesta($data)){
    $filas['cedula_persona'][]=$rows['cedula_persona'];
    $filas['persona'][]=$rows['fullname'];
    $filas['tipo_persona'][]=$rows['tipo_persona'];
    $filas['libro'][]=$rows['libro'];
    $filas['cantidad'][]=$rows['cantidad'];
    $filas['fecha_salida'][]=$rows['fecha_salida'];
    $filas['fecha_vencimiento'][]=$rows['fecha_vencimiento'];
  }
  setlocale(LC_ALL,"es_VE.UTF8");
  $lobjPdf=new clsFpdf();
  // 2da Página
  $lobjPdf->AddPage("P,Letter");
  $lobjPdf->Ln(10);
  $lobjPdf->SetFont('Arial','',12);
  $lobjPdf->Cell(25);
  $lobjPdf->Cell(32,5,'Nos permitimos informar que ',0,0,'L');
  $lobjPdf->SetFont('Arial','BU',12);
  $lobjPdf->Cell(25);
  $lobjPdf->Cell(75,5,$filas['persona'][0],0,1,'L');
  $lobjPdf->SetFont('Arial','',12);
  $lobjPdf->Cell(12);
  $lobjPdf->Cell(60,5,'titular de la Cédula de Identidad Nº:',0,0,'L');
  $lobjPdf->SetFont('Arial','BU',12);
  $lobjPdf->Cell(10);
  $lobjPdf->Cell(14,5,$filas['cedula_persona'][0],0,0);
  $lobjPdf->SetFont('Arial','',12);
  $lobjPdf->Cell(10);
  $lobjPdf->Cell(15,5,'en su condición de ',0,0,'L');
  $lobjPdf->SetFont('Arial','BU',12);
  $lobjPdf->Cell(22);
  $lobjPdf->Cell(10,5,$filas['tipo_persona'][0],0,1);
  $lobjPdf->SetFont('Arial','',12);
  $lobjPdf->Cell(12);
  $lobjPdf->Cell(75,5,'de esta institución, presenta en nuestro registro ',0,0,'L');
  $lobjPdf->SetFont('Arial','B',12);
  $lobjPdf->Cell(16);
  $lobjPdf->Cell(33,5,'PRÉSTAMOS VENCIDOS,',0,0);
  $lobjPdf->SetFont('Arial','',12);
  $lobjPdf->Cell(20);
  $lobjPdf->Cell(18,5,'de recursos',0,1);
  $lobjPdf->Cell(12);
  $lobjPdf->Cell(18,5,'que se detallan a continuación:',0,1);
  $lobjPdf->Ln(10);
  //  Table
  $lobjPdf->Cell(12);
  $lobjPdf->SetWidths(array(70,20,40,40));
  $lobjPdf->SetFont('Arial','B',10);
  //  Align Columns Header 
  $lobjPdf->aligns[0]='C';
  $lobjPdf->aligns[1]='C';
  $lobjPdf->aligns[2]='C';
  $lobjPdf->aligns[3]='C';
  $lobjPdf->Row(array("Libro","Cantidad","Fecha de Prestamo","Fecha de Vencimiento"),false);
  $lobjPdf->SetTextColor(0,0,0);
  $lobjPdf->SetFont('Arial','',8);
  $lobjPdf->SetTextColor(0,0,0);
  //  Align Columns Detail 
  $lobjPdf->aligns[0]='L';
  $lobjPdf->aligns[1]='C';
  $lobjPdf->aligns[2]='C';
  $lobjPdf->aligns[3]='C';
  for($i=0;$i<count($filas['libro']);$i++){
    $lobjPdf->Cell(12);
    $lobjPdf->Row(array($filas['libro'][$i],$filas['cantidad'][$i],$filas['fecha_salida'][$i],$filas['fecha_vencimiento'][$i]),false);
  }
  $lobjPdf->Ln(10);
  $lobjPdf->SetFont('Arial','',12);
  $lobjPdf->Cell(12);
  $lobjPdf->Cell(18,5,'Le agradecemos que se acerque a este Centro lo antes posible, con el fin de registrar las',0,1);
  $lobjPdf->Cell(12);
  $lobjPdf->Cell(18,5,'devoluciones correspondientes y solucionar su situación de morosidad.',0,1);
  //  End Table
  $lobjPdf->ln(45);
  $lobjPdf->Output('documento',"I");
}else{
  $_SESSION['datos']['mensaje']="¡En estos momentos no se puede generar el reporte, intentelo luego!";
  header("Location: ../view/menu_principal.php");
}
?>