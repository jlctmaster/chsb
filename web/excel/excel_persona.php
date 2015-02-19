<?php
	require_once("../class/class_bd.php");
	$mysql = new Conexion();
	$sql = "SELECT p.cedula_persona, p.primer_nombre, p.segundo_nombre, p.primer_apellido, p.segundo_apellido, p.sexo, p.fecha_nacimiento, l.descripcion as lugar_nacimiento, p.direccion, p.telefono_local, 
                 p.telefono_movil, p.estatus, t.descripcion as tipo_persona, 
                case 
                when segundo_nombre is not null and segundo_apellido is not null then INITCAP(primer_nombre||' '||segundo_nombre||' '||primer_apellido||' '||segundo_apellido) 
                when segundo_nombre is not null and segundo_apellido is null then INITCAP(primer_nombre||' '||segundo_nombre||' '||primer_apellido) 
                when segundo_nombre is null and segundo_apellido is not null then INITCAP(primer_nombre||' '||primer_apellido||' '||segundo_apellido)
                else INITCAP(primer_nombre||' '||primer_apellido) end as fullname, 
                CASE p.estatus when '1' then 'ACTIVO' when '0' then 'DESACTIVADO' end as estatus
          FROM general.tpersona as p
          INNER JOIN general.ttipo_persona as t on t.codigo_tipopersona = p.codigo_tipopersona 
          INNER JOIN general.tparroquia as l on l.codigo_parroquia = p.lugar_nacimiento";
	$query = $mysql->Ejecutar($sql);

	date_default_timezone_set('America/Caracas');

	/** Se agrega la libreria PHPExcel */
	require_once '../librerias/PHPExcel/PHPExcel.php';

	// Se crea el objeto PHPExcel
	$objPHPExcel = new PHPExcel();

	// Se asignan las propiedades del libro
	/*$objPHPExcel->getProperties()->setCreator("Codedrinks") //Autor
						 ->setLastModifiedBy("Codedrinks") //Ultimo usuario que lo modificó
						 ->setTitle("Reporte Excel con PHP y MySQL")
						 ->setSubject("Reporte Excel con PHP y MySQL")
						 ->setDescription("Reporte de alumnos")
						 ->setKeywords("reporte alumnos carreras")
						 ->setCategory("Reporte excel");*/

	$tituloReporte = "Listado de las Personas";
	$titulosColumnas = array('Cédula', 'Nombres y Apellidos', 'Sexo', 'Fecha Nac.', 'Lugar Nac.', 'Dirección', 'TLF. Local', 'TLF. Móvil', 'Rol', 'Estatus');
	
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1')->mergeCells('A2:J2');
					
	// Se agregan los titulos del reporte
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', $tituloReporte)
				->setCellValue('A3', $titulosColumnas[0])
				->setCellValue('B3', $titulosColumnas[1])
				->setCellValue('C3', $titulosColumnas[2])
				->setCellValue('D3', $titulosColumnas[3])
				->setCellValue('E3', $titulosColumnas[4])
				->setCellValue('F3', $titulosColumnas[5])
				->setCellValue('G3', $titulosColumnas[6])
				->setCellValue('H3', $titulosColumnas[7])
				->setCellValue('I3', $titulosColumnas[8])
				->setCellValue('J3', $titulosColumnas[9]);
	
	//Se agregan los datos de los alumnos
	$i = 5;
	while ($row = $mysql->Respuesta($query)){
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $row['cedula_persona'])
		->setCellValue('B'.$i, $row['fullname'])
		->setCellValue('C'.$i, $row['sexo'])
		->setCellValue('D'.$i, $row['fecha_nacimiento'])
		->setCellValue('E'.$i, $row['lugar_nacimiento'])
		->setCellValue('F'.$i, $row['direccion'])
		->setCellValue('G'.$i, $row['telefono_local'])
		->setCellValue('H'.$i, $row['telefono_movil'])
		->setCellValue('I'.$i, $row['tipo_persona'])
		->setCellValue('J'.$i, $row['estatus']);
		$i++;
	}
	
	$estiloTituloReporte = array(
    	'font' => array(
        	'name'      => 'Verdana',
	        'bold'      => true,
    	    'italic'    => false,
            'strike'    => false,
           	'size' =>16,
            'color'     => array('rgb' => '000000')
        ),

        'fill' => array(
			'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
			'color'	=> array('argb' => '969696')
		),

        'borders' => array(
           	'allborders' => array(
            	'style' => PHPExcel_Style_Border::BORDER_NONE                    
           	)
        ), 

        'alignment' =>  array(
    			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    			'rotation'   => 0,
    			'wrap'       => TRUE
		)
    );

	$estiloTituloColumnas = array(
        'font' => array(
            'name'      => 'Arial',
            'bold'      => true,                          
            'color'     => array(
                'rgb' => 'FF0000'
            )
        ),

        'fill' 	=> array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'rotation' => 90,
    		'startcolor' => array(
        		'rgb' => 'FAFAFA'
    		)
		),

        'borders' => array(
           	'allborders' => array(
            	'style' => PHPExcel_Style_Border::BORDER_NONE                   
           	)
        ), 

		'alignment' =>  array(
    			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    			'wrap'          => TRUE
		)
	);
		
	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray(
		array(

       		'font' => array(
	           	'name'      => 'Arial',
	           	'bold'      => true,         
	           	'color'     => array('rgb' => '000000')
       		),

       		'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'		=> array('argb' => 'FFFFFF')
			),

	       	'borders' => array(
           		'allborders' => array(
            		'style' => PHPExcel_Style_Border::BORDER_THIN                   
           		)
        	),

        	'alignment' =>  array(
    			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    			'wrap'          => TRUE
		)
    	)
	);
	 
	$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A3:J3')->applyFromArray($estiloTituloColumnas);		
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A5:J".($i-1));

	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
			
	for($i = 'A'; $i <= 'J'; $i++){
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
	}
	
	// Se asigna el nombre a la hoja
	$objPHPExcel->getActiveSheet()->setTitle('Listado de las Personas');

	// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
	$objPHPExcel->setActiveSheetIndex(0);
	// Inmovilizar paneles 
	//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
	$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

	// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Listado Personas.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;

?>