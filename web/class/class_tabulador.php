<?php
class tabulador{
	private $indice;

	public function __construct(){
		$this->indice=null;
	}

 	public function __destruct(){}

 	public function ObtenerIndice($edad,$peso,$talla){
 		$acum=0;
 		//	Indice por Edad
 		switch ($edad) {
 			case ($edad <=6):
 				$acum=1;
 				break;
 			case ($edad >= 6.01 && $edad <= 6.05 ):
 				$acum=2;
 				break;
 			case ($edad >= 6.06 && $edad <= 6.10 ):
 				$acum=3;
 				break;
 			case ($edad >= 6.11 && $edad <= 7.02 ):
 				$acum=4;
 				break;
 			case ($edad >= 7.03 && $edad <= 7.07 ):
 				$acum=5;
 				break;
 			case ($edad >= 7.08 && $edad <= 8 ):
 				$acum=6;
 				break;
 			case ($edad >= 8.01 && $edad <= 8.05 ):
 				$acum=7;
 				break; 				
 			case ($edad >= 8.06 && $edad <= 8.10 ):
 				$acum=8;
 				break;
 			case ($edad >= 8.11 && $edad <= 9.02 ):
 				$acum=9;
 				break;
 			case ($edad >= 9.03 && $edad <= 9.07 ):
 				$acum=10;
 				break;
 			case ($edad >= 9.08 && $edad <= 10 ):
 				$acum=11;
 				break;
 			case ($edad >= 10.01 && $edad <= 10.05 ):
 				$acum=12;
 				break;
 			case ($edad >= 10.06 && $edad <= 10.10 ):
 				$acum=13;
 				break;
 			case ($edad >= 10.11 && $edad <= 11.02 ):
 				$acum=14;
 				break;
 			case ($edad >= 11.03 && $edad <= 11.07 ):
 				$acum=15;
 				break;
 			case ($edad >= 11.08 && $edad <= 12 ):
 				$acum=16;
 				break;
 			case ($edad >= 12.01 && $edad <= 12.05 ):
 				$acum=17;
 				break;
 			case ($edad >= 12.06 && $edad <= 12.10 ):
 				$acum=18;
 				break;
 			case ($edad >= 12.11 && $edad <= 13.02 ):
 				$acum=19;
 				break;
 			case ($edad >= 13.03 && $edad <= 13.07 ):
 				$acum=20;
 				break;
 			case ($edad >= 13.08 && $edad <= 14 ):
 				$acum=21;
 				break;
 			case ($edad >= 14.01 && $edad <= 14.05 ):
 				$acum=22;
 				break;
 			case ($edad >= 14.06 && $edad <= 14.10 ):
 				$acum=23;
 				break;
 			case ($edad >= 14.11 && $edad <= 15.02 ):
 				$acum=24;
 				break;
 			case ($edad >= 15.03 && $edad <= 15.07 ):
 				$acum=25;
 				break;
 			case ($edad >= 15.08 && $edad <= 16 ):
 				$acum=26;
 				break;
 			case ($edad >= 16.01 && $edad <= 16.05 ):
 				$acum=27;
 				break;
 			case ($edad >= 16.06 && $edad <= 16.10 ):
 				$acum=28;
 				break;
 			case ($edad >= 16.11 && $edad <= 17.02 ):
 				$acum=29;
 				break;
 			case ($edad >= 17.03 ):
 				$acum=30;
 				break;
 			default:
 				$acum=0;
 				break;
 		}
 		//	Indice por Peso
 		switch ($peso) {
 			case ($peso <=10):
 				$acum+=1;
 				break;
 			case ($peso >= 10.1 && $peso <= 12.6 ):
 				$acum+=2;
 				break;
 			case ($peso >= 12.7 && $peso <= 15.2 ):
 				$acum+=3;
 				break;
 			case ($peso >= 15.3 && $peso <= 17.8 ):
 				$acum+=4;
 				break;
 			case ($peso >= 17.9 && $peso <= 20.4 ):
 				$acum+=5;
 				break;
 			case ($peso >= 20.5 && $peso <= 23 ):
 				$acum+=6;
 				break;
 			case ($peso >= 23.1 && $peso <= 25.6 ):
 				$acum+=7;
 				break; 				
 			case ($peso >= 25.7 && $peso <= 28.2 ):
 				$acum+=8;
 				break;
 			case ($peso >= 28.3 && $peso <= 30.8 ):
 				$acum+=9;
 				break;
 			case ($peso >= 30.9 && $peso <= 33.4 ):
 				$acum+=10;
 				break;
 			case ($peso >= 33.5 && $peso <= 36 ):
 				$acum+=11;
 				break;
 			case ($peso >= 36.1 && $peso <= 38.6 ):
 				$acum+=12;
 				break;
 			case ($peso >= 38.7 && $peso <= 41.2 ):
 				$acum+=13;
 				break;
 			case ($peso >= 41.3 && $peso <= 43.8 ):
 				$acum+=14;
 				break;
 			case ($peso >= 43.9 && $peso <= 46.4 ):
 				$acum+=15;
 				break;
 			case ($peso >= 46.5 && $peso <= 49 ):
 				$acum+=16;
 				break;
 			case ($peso >= 49.1 && $peso <= 51.6 ):
 				$acum+=17;
 				break;
 			case ($peso >= 51.7 && $peso <= 54.2 ):
 				$acum+=18;
 				break;
 			case ($peso >= 54.3 && $peso <= 56.8 ):
 				$acum+=19;
 				break;
 			case ($peso >= 56.9 && $peso <= 59.4 ):
 				$acum+=20;
 				break;
 			case ($peso >= 59.5 && $peso <= 62 ):
 				$acum+=21;
 				break;
 			case ($peso >= 62.1 && $peso <= 64.6 ):
 				$acum+=22;
 				break;
 			case ($peso >= 64.7 && $peso <= 67.2 ):
 				$acum+=23;
 				break;
 			case ($peso >= 67.3 && $peso <= 69.8 ):
 				$acum+=24;
 				break;
 			case ($peso >= 69.9 && $peso <= 72.4 ):
 				$acum+=25;
 				break;
 			case ($peso >= 72.5 && $peso <= 75 ):
 				$acum+=26;
 				break;
 			case ($peso >= 75.1 && $peso <= 77.6 ):
 				$acum+=27;
 				break;
 			case ($peso >= 77.7 && $peso <= 80.2 ):
 				$acum+=28;
 				break;
 			case ($peso >= 80.3 && $peso <= 82.8 ):
 				$acum+=29;
 				break;
 			case ($peso >= 82.9 ):
 				$acum+=30;
 				break;
 			default:
 				$acum+=0;
 				break;
 		}
 		//	Indice por Talla
 		switch ($talla) {
 			case ($talla <=80):
 				$acum+=1;
 				break;
 			case ($talla >= 80.1 && $talla <= 83.6 ):
 				$acum+=2;
 				break;
 			case ($talla >= 83.7 && $talla <= 87.2 ):
 				$acum+=3;
 				break;
 			case ($talla >= 87.3 && $talla <= 90.8 ):
 				$acum+=4;
 				break;
 			case ($talla >= 90.9 && $talla <= 94.4 ):
 				$acum+=5;
 				break;
 			case ($talla >= 94.5 && $talla <= 98 ):
 				$acum+=6;
 				break;
 			case ($talla >= 98.1 && $talla <= 101.6 ):
 				$acum+=7;
 				break; 				
 			case ($talla >= 101.7 && $talla <= 105.2 ):
 				$acum+=8;
 				break;
 			case ($talla >= 105.3 && $talla <= 108.8 ):
 				$acum+=9;
 				break;
 			case ($talla >= 108.9 && $talla <= 112.4 ):
 				$acum+=10;
 				break;
 			case ($talla >= 112.5 && $talla <= 116 ):
 				$acum+=11;
 				break;
 			case ($talla >= 116.1 && $talla <= 119.6 ):
 				$acum+=12;
 				break;
 			case ($talla >= 119.7 && $talla <= 123.2 ):
 				$acum+=13;
 				break;
 			case ($talla >= 123.3 && $talla <= 126.8 ):
 				$acum+=14;
 				break;
 			case ($talla >= 126.9 && $talla <= 130.4 ):
 				$acum+=15;
 				break;
 			case ($talla >= 130.5 && $talla <= 134 ):
 				$acum+=16;
 				break;
 			case ($talla >= 134.1 && $talla <= 137.6 ):
 				$acum+=17;
 				break;
 			case ($talla >= 137.7 && $talla <= 141.2 ):
 				$acum+=18;
 				break;
 			case ($talla >= 141.3 && $talla <= 144.8 ):
 				$acum+=19;
 				break;
 			case ($talla >= 144.9 && $talla <= 148.4 ):
 				$acum+=20;
 				break;
 			case ($talla >= 148.5 && $talla <= 152 ):
 				$acum+=21;
 				break;
 			case ($talla >= 152.1 && $talla <= 155.6 ):
 				$acum+=22;
 				break;
 			case ($talla >= 155.7 && $talla <= 159.2 ):
 				$acum+=23;
 				break;
 			case ($talla >= 159.3 && $talla <= 162.8 ):
 				$acum+=24;
 				break;
 			case ($talla >= 162.9 && $talla <= 166.4 ):
 				$acum+=25;
 				break;
 			case ($talla >= 166.5 && $talla <= 170 ):
 				$acum+=26;
 				break;
 			case ($talla >= 170.1 && $talla <= 173.6 ):
 				$acum+=27;
 				break;
 			case ($talla >= 173.7 && $talla <= 177.2 ):
 				$acum+=28;
 				break;
 			case ($talla >= 177.3 && $talla <= 180.8 ):
 				$acum+=29;
 				break;
 			case ($talla >= 180.9 ):
 				$acum+=30;
 				break;
 			default:
 				$acum+=0;
 				break;
 		}
 		$this->indice = $acum;
 		return $this->indice;
 	}
}
?>