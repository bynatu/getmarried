<?php

$this->PhpExcel->createWorksheet();

$this->PhpExcel->setDefaultFont('Verdana', 12);
$this->PhpExcel->setDefaultBorder();

$rgbColor = 'FFFFFF';
$rgbBackgroundColor = '5BAAA1';
$font_color_row = '000000';

//Cabecera
$header = array();
$header[] = array( 'label' => 'Id', 'width' => '5');
$header[] = array( 'label' => 'NIF', 'width' => '10' );
$header[] = array( 'label' => 'NOMBRE', 'width' => '20' );
$header[] = array( 'label' => 'SITIO WEB', 'width' => '25' );
$header[] = array( 'label' => 'EMAIL', 'width' => '35' );
$header[] = array( 'label' => 'TELEFONO', 'width' => '10' );
$header[] = array( 'label' => 'DIRECCION', 'width' => '30' );
$header[] = array( 'label' => 'PISO', 'width' => '10' );
$header[] = array( 'label' => 'NUMERO', 'width' => '10' );
$header[] = array( 'label' => 'LOCALIDAD', 'width' => '15' );
$header[] = array( 'label' => 'PROVINCIA', 'width' => '15' );
$header[] = array( 'label' => 'LATITUD', 'width' => '15' );
$header[] = array( 'label' => 'LONGITUD', 'width' => '15' );
$this->PhpExcel->addTableHeader($header, array(), $rgbColor, $rgbBackgroundColor, false);
$i = 0;
foreach($empresas as $key => $tipo_empresa){
    if($i == 0){
        $this->PhpExcel->cambiarTituloHoja($key);
    }
    else{
        $this->PhpExcel->addHoja($key);
        $this->PhpExcel->irAHoja($i);
        $this->PhpExcel->setRow(1); //reset the row number
        $this->PhpExcel->addTableHeader($header, array(), $rgbColor, $rgbBackgroundColor, false);
    }
    foreach($tipo_empresa as $empresa){
        $row = array();
        $row[] = $empresa['Empresa']['id'];
        $row[] = $empresa['Empresa']['NIF'];
        $row[] = $empresa['Empresa']['nombre'];
        $row[] = $empresa['Empresa']['www'];
        $row[] = $empresa['Empresa']['email'];
        $row[] = $empresa['Empresa']['telefono'];
        $row[] = $empresa['Empresa']['direccion'];
        $row[] = $empresa['Empresa']['piso'];
        $row[] = $empresa['Empresa']['numero'];
        $row[] = $empresa['Empresa']['ciudad'];
        $row[] = $empresa['Empresa']['provincia'];
        $row[] = $empresa['Empresa']['latitud'];
        $row[] = $empresa['Empresa']['longitud'];
        $this->PhpExcel->addTableRow($row, $font_color_row);
    }
    $i++;


}



$this->PhpExcel->output("Empresas_".date('Y').'_'.date('m').'_'.date('d').'.xls');
header('Set-Cookie: fileDownload=true; path=/');