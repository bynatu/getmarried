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
$header[] = array( 'label' => 'DNI', 'width' => '10' );
$header[] = array( 'label' => 'NOMBRE', 'width' => '20' );
$header[] = array( 'label' => 'APELLIDOS', 'width' => '25' );
$header[] = array( 'label' => 'EMAIL', 'width' => '35' );
$header[] = array( 'label' => 'TELEFONO', 'width' => '10' );
$header[] = array( 'label' => 'FECHA DE NACIMIENTO', 'width' => '25' );
$header[] = array( 'label' => 'DIRECCION', 'width' => '30' );
$header[] = array( 'label' => 'PISO', 'width' => '10' );
$header[] = array( 'label' => 'NUMERO', 'width' => '10' );
$header[] = array( 'label' => 'LOCALIDAD', 'width' => '15' );
$header[] = array( 'label' => 'PROVINCIA', 'width' => '15' );
$header[] = array( 'label' => 'NACIONALIDAD', 'width' => '15' );

$this->PhpExcel->addTableHeader($header, array(), $rgbColor, $rgbBackgroundColor, false);

//Contenido del excel
foreach($clientes as $cliente){
    $row = array();
    $row[] = $cliente['Cliente']['id'];
    $row[] = $cliente['Cliente']['DNI'];
    $row[] = $cliente['Cliente']['nombre'];
    $row[] = $cliente['Cliente']['apellidos'];
    $row[] = $cliente['Cliente']['email'];
    $row[] = $cliente['Cliente']['telefono'];
    $row[] = $cliente['Cliente']['f_nacimiento'];
    $row[] = $cliente['Cliente']['direccion'];
    $row[] = $cliente['Cliente']['piso'];
    $row[] = $cliente['Cliente']['numero'];
    $row[] = $cliente['Cliente']['localidad'];
    $row[] = $cliente['Cliente']['ciudad'];
    $row[] = $cliente['Cliente']['nacionalidad'];
    $this->PhpExcel->addTableRow($row, $font_color_row);
}


$this->PhpExcel->output("Clientes_".date('Y').'_'.date('m').'_'.date('d').'.xls');
header('Set-Cookie: fileDownload=true; path=/');