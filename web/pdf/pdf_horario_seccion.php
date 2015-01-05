<?php
  require_once("../librerias/fpdf/fpdf.php");
  include_once("../class/class_horario.php");
  session_start();

  $horario=new horario();
  $profesor=new horario();
  if(isset($_POST['lapso']) and !empty($_POST['lapso'])){
    $lapso=trim($_POST['lapso']);
  }
  if(isset($_POST['seccion']) and !empty($_POST['seccion'])){
    $seccion=trim($_POST['seccion']);
  }
  $horario->seccion($seccion);
  $horario->codigo_ano_academico($lapso);	
  if($horario->Comprobar_existencia_horario_seccion()==true){
    $datos=$horario->Consultar_H_SECCION();
    for($i=0;$i<count($datos['cedula']);$i++){
      $_SESSION['datos']['dia'][$i]=$datos['dia'][$i];
      $_SESSION['datos']['hora'][$i]=$datos['hora'][$i];
      $_SESSION['datos']['celda'][$i]=$datos['celda'][$i];
      $_SESSION['datos']['id_hora'][$i]=$datos['codigo_bloque_hora'][$i];
      $_SESSION['datos']['lapso'][$i]=$datos['codigo_ano_academico'][$i];
      $_SESSION['datos']['cedula'][$i]=$datos['cedula'][$i];
      $_SESSION['datos']['nombre'][$i]=$datos['nombre'][$i];
      $_SESSION['datos']['apellido'][$i]=$datos['apellido'][$i];
      $_SESSION['datos']['ambiente'][$i]=$datos['codigo_ambiente'][$i];
      $_SESSION['datos']['nombre_ambiente'][$i]=$datos['nombre_ambiente'][$i];
      $_SESSION['datos']['nombre_materia'][$i]=$datos['nombre_materia'][$i];
      $_SESSION['datos']['materia'][$i]=$datos['materia'][$i];
      $_SESSION['datos']['seccion'][$i]=$datos['seccion'][$i];
      $_SESSION['datos']['nombre_seccion'][$i]=$datos['nombre_seccion'][$i];
      $_SESSION['datos']['name_seccion'][$i]=$datos['name_seccion'][$i];
    }

    if(isset($_SESSION['datos']['dia'])){
      $dia=$_SESSION['datos']['dia'];
      $hora=$_SESSION['datos']['hora'];
      $id_celda=$_SESSION['datos']['celda'];
    }
  }
  else {
    $_SESSION['datos']['mensaje']="No hay horario para esta sección";
    header("Location: ../view/");	
  }
  //Defined to Class clsFpdf
  class clsFpdf extends FPDF {
    //===============================================
    function SetWidths($w){
      //Set the array of column widths
      $this->widths=$w;
    }

    function SetAligns($a){
      //Set the array of column alignments
      $this->aligns=$a;
    }

    function Row($data){
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
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
      }
      //Go to the next line
      $this->Ln($h);
    }

    function CheckPageBreak($h){
      //If the height h would cause an overflow, add a new page immediately
      if($this->GetY()+$h>$this->PageBreakTrigger)
      //$this->AddPage($this->CurOrientation);
      $this->AddPage("L");
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
    //===============================================
    //Cabecera de página
    public function Header(){
      //Logo
      //$this->Image("../images/UDS.jpg" , 10 ,15, 40 , 40, "JPG" ,$_SERVER['HTTP_HOST']."/udesur/vistas");
      //$this->Image("../images/cintillo.jpg" , 10 ,5, 270 , 8, "JPG" ,$_SERVER['HTTP_HOST']);
      $this->Image("../images/banner.jpg" , 25 ,15, 250 , 25, "JPG" ,$_SERVER['HTTP_HOST']."/CHSB/web/view/menu_principal.php");
      $this->Ln(35); 
      $this->SetFont('Arial','B',14);
      $this->Cell(0,7,"* HORARIO DE LA ".$_SESSION['datos']['name_seccion'][0]." *",0,1,"C");  
      $this->Ln(5); 
      $this->SetFont('Arial','B',10);
      $this->SetFont("arial","B",9);
      $anchura=32.2;
      $altura=6;
      $margin=10;
      $alignacion="C";
      $this->SetFillColor(240,240,240);
      $this->Cell($margin);
      $this->Cell($anchura-7,($altura-1)*2,utf8_encode("Hora"),1,0,"C",true);
      $this->Cell($anchura*7,$altura,utf8_encode("Día de la Semana"),1,1,"C",true);
      $this->Cell($margin);
      $this->Cell($anchura-7);
      $this->Cell($anchura,$altura-2,utf8_encode("Lunes"),1,0,$alignacion,true);
      $this->Cell($anchura,$altura-2,utf8_encode("Martes"),1,0,$alignacion,true);
      $this->Cell($anchura,$altura-2,utf8_encode("Miércoles"),1,0,$alignacion,true);
      $this->Cell($anchura,$altura-2,utf8_encode("Jueves"),1,0,$alignacion,true);
      $this->Cell($anchura,$altura-2,utf8_encode("Viernes"),1,0,$alignacion,true);
      $this->Cell($anchura,$altura-2,utf8_encode("Sábado"),1,0,$alignacion,true);
      $this->Cell($anchura,$altura-2,utf8_encode("Domingo"),1,1,$alignacion,true);
      $this->Cell($margin);
    }

    //Pie de página
    public function Footer(){
      //Posición: a 2 cm del final
      $this->SetY(-22);
      //Arial italic 8
      $this->SetFont("Arial","I",8);
      //Dirección
      $empresa=utf8_encode("Liceo Bolivariano Bicentenario de la Independencia de Venezuela");
      $dir=utf8_encode("Dirección: Complejo Habitacional Simon Bolivar, 3302 Acarigua");
      $tel=utf8_encode("Teléfono: 04168110432");
      $empresa1=utf8_encode("Todos los Derechos Reservados\"© 2014 FUNDABIT-DTIC.\"");
      $this->Cell(0,4,$empresa,0,1,"C");
      $this->Cell(0,4,$dir,0,0,"C");
      //Número de página
      $this->Cell(-5,5,utf8_encode("Página ".$this->PageNo()."/{nb}"),0,1,"R");
      $this->Cell(0,4,$tel,0,0,"C");
      //Fecha
      include_once("../class/class_horario.php");
      $horario=new horario();
      $lcFecha=$horario->FECHA_SISTEMA();
      $this->Cell(-8,3,$lcFecha,0,0,"R");
      $this->Cell(10);
    }
  }

  setlocale(LC_ALL,"es_VE.UTF8");
  $lobjPdf=new clsFpdf();
  $lobjPdf->AliasNbPages();
  $lobjPdf->AddPage('P',array(290,183));
  $lobjPdf->SetFont("arial","B",9);

  $anchura=32.2;
  $altura=6;
  $margin=10;
  $background=false;
  $alignacion="C";
  $weekend=1;
  $lobjPdf->SetFont("arial","",9);
  $lobjPdf->SetFillColor(255,0,0);
  if(isset($_SESSION['datos']['dia'])){
    $dia=$_SESSION['datos']['dia'];
    $hora=$_SESSION['datos']['hora'];
    $id_celda=$_SESSION['datos']['celda'];
  }
  if(isset($_SESSION['datos']['id_hora'])){
    $id_hora=$_SESSION['datos']['id_hora'];
  }
  include_once("../class/class_horario.php");
  $bloque_horas=new horario();
  $turno=0;
  $get_hora=$bloque_horas->bloque_hora("todos");
  $lobjPdf->SetWidths(array($anchura-7,$anchura,$anchura,$anchura,$anchura,$anchura,$anchura,$anchura));
  $valor_a_buscar=array();
  $lobjPdf->Cell(-10);

  for($i=0;$i<count($get_hora['id']);$i++){
    $x=$get_hora['id'][$i];     
    $hora_nombre=$get_hora['hora_inicio'][$i]."-".$get_hora['hora_fin'][$i];
    $lobjPdf->Cell($margin);
    if(in_array($x."-1",$_SESSION['datos']['celda'],true)){$valor=array_search($x."-1",$_SESSION['datos']['celda']);}
    (in_array($x."-1",$_SESSION['datos']['celda'],true)) ? ($datos_celda=$datos_celda="Materia: ".$_SESSION['datos']['nombre_materia'][$valor].' Seccion:'.$_SESSION['datos']['nombre_seccion'][$valor].' Aula: '.$_SESSION['datos']['nombre_ambiente'][$valor]) :  $datos_celda=' ';

    $valor_a_buscar[0]=$datos_celda;
    if(in_array($x."-2",$_SESSION['datos']['celda'],true)){$valor=array_search($x."-1",$_SESSION['datos']['celda']);}   
    (in_array($x."-2",$_SESSION['datos']['celda'],true)) ? ($datos_celda=$datos_celda="Materia: ".$_SESSION['datos']['nombre_materia'][$valor].' Seccion:'.$_SESSION['datos']['nombre_seccion'][$valor].' Aula: '.$_SESSION['datos']['nombre_ambiente'][$valor]) :  $datos_celda=' ';

    $valor_a_buscar[1]=$datos_celda;
    if(in_array($x."-3",$_SESSION['datos']['celda'],true)){$valor=array_search($x."-1",$_SESSION['datos']['celda']);}
    (in_array($x."-3",$_SESSION['datos']['celda'],true)) ? ($datos_celda=$datos_celda="Materia: ".$_SESSION['datos']['nombre_materia'][$valor].' Seccion:'.$_SESSION['datos']['nombre_seccion'][$valor].' Aula: '.$_SESSION['datos']['nombre_ambiente'][$valor]) :  $datos_celda=' ';

    $valor_a_buscar[2]=$datos_celda;
    if(in_array($x."-4",$_SESSION['datos']['celda'],true)){$valor=array_search($x."-1",$_SESSION['datos']['celda']);}  
    (in_array($x."-4",$_SESSION['datos']['celda'],true)) ? ($datos_celda=$datos_celda="Materia: ".$_SESSION['datos']['nombre_materia'][$valor].' Seccion:'.$_SESSION['datos']['nombre_seccion'][$valor].' Aula: '.$_SESSION['datos']['nombre_ambiente'][$valor]) :  $datos_celda=' ';

    $valor_a_buscar[3]=$datos_celda;
    if(in_array($x."-5",$_SESSION['datos']['celda'],true)){$valor=array_search($x."-1",$_SESSION['datos']['celda']);}
    (in_array($x."-5",$_SESSION['datos']['celda'],true)) ? ($datos_celda=$datos_celda="Materia: ".$_SESSION['datos']['nombre_materia'][$valor].' Seccion:'.$_SESSION['datos']['nombre_seccion'][$valor].' Aula: '.$_SESSION['datos']['nombre_ambiente'][$valor]) :  $datos_celda=' ';

    $valor_a_buscar[4]=$datos_celda;
    if($get_hora['id_turno'][$i]=='2'){
      $lobjPdf->SetFillColor(240,240,240);
      if(in_array($x."-6",$_SESSION['datos']['celda'],true)){$valor=array_search($x."-1",$_SESSION['datos']['celda']);}
      (in_array($x."-6",$_SESSION['datos']['celda'],true)) ? ($datos_celda=$datos_celda="Materia: ".$_SESSION['datos']['nombre_materia'][$valor].' Seccion:'.$_SESSION['datos']['nombre_seccion'][$valor].' Aula: '.$_SESSION['datos']['nombre_ambiente'][$valor]) :  $datos_celda='-';

      $valor_a_buscar[5]=$datos_celda;
      if(in_array($x."-0",$_SESSION['datos']['celda'],true)){$valor=array_search($x."-1",$_SESSION['datos']['celda']);}
      (in_array($x."-0",$_SESSION['datos']['celda'],true)) ? ($datos_celda=$datos_celda="Materia: ".$_SESSION['datos']['nombre_materia'][$valor].' Seccion:'.$_SESSION['datos']['nombre_seccion'][$valor].' Aula: '.$_SESSION['datos']['nombre_ambiente'][$valor]) :  $datos_celda='-';

      $valor_a_buscar[6]=$datos_celda;
    }else{
      if(in_array($x."-1",$_SESSION['datos']['celda'],true)){$valor=array_search($x."-1",$_SESSION['datos']['celda']);}
      (in_array($x."-6",$_SESSION['datos']['celda'],true)) ? ($datos_celda=$datos_celda="Materia: ".$_SESSION['datos']['nombre_materia'][$valor].' Seccion:'.$_SESSION['datos']['nombre_seccion'][$valor].' Aula: '.$_SESSION['datos']['nombre_ambiente'][$valor]) :  $datos_celda='-';

      $valor_a_buscar[5]=$datos_celda;
      if(in_array($x."-1",$_SESSION['datos']['celda'],true)){$valor=array_search($x."-1",$_SESSION['datos']['celda']);}
      (in_array($x."-0",$_SESSION['datos']['celda'],true)) ? ($datos_celda=$datos_celda="Materia: ".$_SESSION['datos']['nombre_materia'][$valor].' Seccion:'.$_SESSION['datos']['nombre_seccion'][$valor].' Aula: '.$_SESSION['datos']['nombre_ambiente'][$valor]) :  $datos_celda='-';

      $valor_a_buscar[6]=$datos_celda;
    }

    if(@$get_hora['id_turno'][$i-1]=='M' and $get_hora['id_turno'][$i]=='T'){
      $lobjPdf->SetFont("arial","B",9);
      $lobjPdf->SetFillColor(240,240,240);
      $background=!$background;
      $lobjPdf->Cell($anchura*8-7,$altura-1,utf8_encode('Receso'),1,1,$alignacion,$background);
      $background=!$background;
      $lobjPdf->SetFont("arial","",9);
      $lobjPdf->Cell($margin);
    }

    $lobjPdf->Row(array($hora_nombre,$valor_a_buscar[0],$valor_a_buscar[1],$valor_a_buscar[2],$valor_a_buscar[3],$valor_a_buscar[4],$valor_a_buscar[5],$valor_a_buscar[6]));
  }
  $lobjPdf->Output("HORARIO",'I');
  if(isset($_SESSION['datos'])) unset($_SESSION['datos']); 
?>
