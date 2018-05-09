<?php

class Fecha{

    const _FORMATO_VISTA_FECHA = 'd/m/Y';
    const _FORMATO_BD_FECHA = 'Y-m-d';

    const _FORMATO_VISTA_FECHA_HORA = 'd/m/Y H:i:s';
    const _FORMATO_BD_FECHA_HORA = 'Y-m-d H:i:s';

    const _DEFAULT_FORMATO_VISTA = '';
    const _DEFAULT_FORMATO_BD = null;
    const _DEFAULT_FORMATO = null;

    private static $_F_DIA_CON_CERO = 'd';
    private static $_F_DIA_SIN_CERO = 'j';
    private static $_F_DIA_SEMANA_NUM = 'N';
    private static $_F_SEMANA_NUM = 'W';
    private static $_F_MES_CON_CERO = 'm';
    private static $_F_MES_SIN_CERO = 'n';
    private static $_F_ANO_LARGO = 'Y';
    private static $_F_ANO_CORTO = 'y';

    private static $_F_HORA_12_CON_CERO = 'h';
    private static $_F_HORA_24_CON_CERO = 'H';
    private static $_F_HORA_12_SIN_CERO = 'g';
    private static $_F_HORA_24_SIN_CERO = 'G';
    private static $_F_MINUTOS = 'i';
    private static $_F_SEGUNDOS = 's';

    private static $_F_ZONA = 'e';

    private static $_NOMBRES_DIAS_SEMANA = array(
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo',
    );

    private static $_NOMBRES_MESES = array(
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    );

    public static function toFormatoVista($fecha, $formato_entrada = self::_FORMATO_BD_FECHA){
        if(self::esFecha($fecha, $formato_entrada)){
            return self::cambiarFormato($fecha, $formato_entrada, self::_FORMATO_VISTA_FECHA);
        }else{
            return self::_DEFAULT_FORMATO_VISTA;
        }
    }

    public static function toFormatoBd($fecha, $formato_entrada = self::_FORMATO_VISTA_FECHA){
        if(self::esFecha($fecha, $formato_entrada)){
            $arrFecha = self::toArray($fecha, $formato_entrada);
            return sprintf('%04d-%02d-%02d', $arrFecha['year'], $arrFecha['month'], $arrFecha['day']);
        }else{
            return self::_DEFAULT_FORMATO_BD;
        }
    }

    public static function toFormatoVistaFechaHora($fecha, $formato_entrada = self::_FORMATO_BD_FECHA_HORA){
        if(self::esFechaHora($fecha, $formato_entrada)){
            return self::cambiarFormato($fecha, $formato_entrada, self::_FORMATO_VISTA_FECHA_HORA);
        }else{
            return self::_DEFAULT_FORMATO_VISTA;
        }
    }

    public static function toFormatoBdFechaHora($fecha, $formato_entrada = self::_FORMATO_VISTA_FECHA_HORA){
        if(self::esFechaHora($fecha, $formato_entrada)){
            $arrFecha = self::toArray($fecha, $formato_entrada);
            return sprintf('%04d-%02d-%02d %02d:%02d:%02d', $arrFecha['year'], $arrFecha['month'], $arrFecha['day'], $arrFecha['hour'], $arrFecha['minute'], $arrFecha['second']);
        }else{
            return self::_DEFAULT_FORMATO_BD;
        }
    }

    public static function cambiarFormato($fecha, $formato_entrada, $formato_salida){
        if( self::esFechaHora($fecha, $formato_entrada) ){
            if($formato_entrada != self::_FORMATO_BD_FECHA_HORA){
                $fecha = self::toFormatoBdFechaHora($fecha, $formato_entrada);
            }
            return date($formato_salida, strtotime($fecha));
        }elseif( self::esFecha($fecha, $formato_entrada) ){
            if($formato_entrada != self::_FORMATO_BD_FECHA){
                $fecha = self::toFormatoBd($fecha, $formato_entrada);
            }
            return date($formato_salida, strtotime($fecha));
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function esFecha($fecha, $formato_entrada = self::_FORMATO_BD_FECHA){
        $arrFecha = self::toArray($fecha, $formato_entrada);
        return checkdate($arrFecha['month'], $arrFecha['day'], $arrFecha['year']);
    }

    public static function esHora($hora){
        $arrHora = explode(":", $hora);
        if(count($arrHora) != 2 && count($arrHora) != 3){
            return false;
        }

        $hora = $arrHora[0];
        $minutos = $arrHora[1];

        if(!self::_esNumNatural($hora) || $hora > 23 || !self::_esNumNatural($minutos) || $minutos > 59){
            return false;
        }
        if(count($arrHora) == 3){
            $segundos = $arrHora[2];
            if(!self::_esNumNatural($segundos) || $segundos > 59){
                return false;
            }
        }

        return true;
    }

    private static function _esNumNatural($numero){
        return is_numeric($numero) && !is_float($numero) && $numero >= 0;
    }

    public static function esFechaHora($txt){
        $asPartes = explode(" ", $txt);
        if(count($asPartes) != 2){
            return false;
        }

        return self::esFecha($asPartes[0]) && self::esHora($asPartes[1]);
    }

    public static function toArray($fecha, $formato_entrada = self::_FORMATO_BD_FECHA){
        return date_parse_from_format($formato_entrada, $fecha); //(PHP 5 >= 5.3.0)
    }

    public static function crearFechaBD($ano, $mes, $dia){
        return $ano.'-'.$mes.'-'.$dia;
    }

    public static function getHoy(){
        return date(self::_FORMATO_BD_FECHA);
    }

    public static function getAhora(){
        return date(self::_FORMATO_BD_FECHA_HORA);
    }

    public static function getDia($fecha, $incluir_cero = true, $formato_entrada = self::_FORMATO_BD_FECHA){
        if( self::esFecha($fecha, $formato_entrada) ){
            $fecha = self::toFormatoBd($fecha, $formato_entrada);
            if($incluir_cero){
                return date(self::$_F_DIA_CON_CERO, strtotime($fecha));
            }else{
                return date(self::$_F_DIA_SIN_CERO, strtotime($fecha));
            }
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function getDiaNombre($dia, $corto = false, $tam = 2){
        if($corto){
            return substr(self::$_NOMBRES_DIAS_SEMANA[$dia], 0, $tam);
        }else{
            return self::$_NOMBRES_DIAS_SEMANA[$dia];
        }
    }

    public static function getDiaSemanaNum($fecha, $formato_entrada = self::_FORMATO_BD_FECHA){
        if( self::esFecha($fecha, $formato_entrada) ){
            $fecha = self::toFormatoBd($fecha, $formato_entrada);
            return date(self::$_F_DIA_SEMANA_NUM, strtotime($fecha));
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function getSemana($fecha, $formato_entrada = self::_FORMATO_BD_FECHA){
        if( self::esFecha($fecha, $formato_entrada) ){
            $fecha = self::toFormatoBd($fecha, $formato_entrada);
            return date(self::$_F_SEMANA_NUM, strtotime($fecha));
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function getMes($fecha, $incluir_cero = true, $formato_entrada = self::_FORMATO_BD_FECHA){
        if( self::esFecha($fecha, $formato_entrada) ){
            $fecha = self::toFormatoBd($fecha, $formato_entrada);
            if($incluir_cero){
                return date(self::$_F_MES_CON_CERO, strtotime($fecha));
            }else{
                return date(self::$_F_MES_SIN_CERO, strtotime($fecha));
            }
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function getMesNombre($mes, $corto = false, $tam = 3){
        if($corto){
            return substr(self::$_NOMBRES_MESES[$mes], 0, $tam);
        }else{
            return self::$_NOMBRES_MESES[$mes];
        }
    }

    public static function getAno($fecha, $corto = false, $formato_entrada = self::_FORMATO_BD_FECHA){
        if( self::esFecha($fecha, $formato_entrada) ){
            $fecha = self::toFormatoBd($fecha, $formato_entrada);
            if($corto){
                return date(self::$_F_ANO_CORTO, strtotime($fecha));
            }else{
                return date(self::$_F_ANO_LARGO, strtotime($fecha));
            }
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function getHora($fecha, $formato_24 = true, $incluir_cero = true, $formato_entrada = self::_FORMATO_BD_FECHA_HORA){
        $fecha = self::toFormatoBdFechaHora($fecha, $formato_entrada);

        if($formato_24){
            if($incluir_cero){
                return date(self::$_F_HORA_24_CON_CERO, strtotime($fecha));
            }else{
                return date(self::$_F_HORA_24_SIN_CERO, strtotime($fecha));
            }
        }else{
            if($incluir_cero){
                return date(self::$_F_HORA_12_CON_CERO, strtotime($fecha));
            }else{
                return date(self::$_F_HORA_12_SIN_CERO, strtotime($fecha));
            }
        }
    }

    public static function getMinutos($fecha, $formato_entrada = self::_FORMATO_BD_FECHA_HORA){
        $fecha = self::toFormatoBdFechaHora($fecha, $formato_entrada);
        return date(self::$_F_MINUTOS, strtotime($fecha));
    }

    public static function getSegundos($fecha, $formato_entrada = self::_FORMATO_BD_FECHA_HORA){
        $fecha = self::toFormatoBdFechaHora($fecha, $formato_entrada);
        return date(self::$_F_SEGUNDOS, strtotime($fecha));
    }

    public static function getZona($fecha, $formato_entrada = self::_FORMATO_BD_FECHA){
        if( self::esFecha($fecha, $formato_entrada) ){
            $fecha = self::toFormatoBd($fecha, $formato_entrada);
            return date(self::$_F_ZONA, strtotime($fecha));
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function sumarDias($fecha, $num_dias, $formato_entrada = self::_FORMATO_BD_FECHA){
        if( self::esFecha($fecha, $formato_entrada) ){
            $fecha = self::toFormatoBd($fecha, $formato_entrada);
            return date( $formato_entrada, strtotime("+ " . $num_dias . " day", strtotime($fecha)) );
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function restarDias($fecha, $num_dias, $formato_entrada = self::_FORMATO_BD_FECHA){
        if( self::esFecha($fecha, $formato_entrada) ){
            $fecha = self::toFormatoBd($fecha, $formato_entrada);
            return date( $formato_entrada, strtotime("- " . $num_dias . " day", strtotime($fecha)) );
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function sumarMeses($fecha, $num_meses, $formato_entrada = self::_FORMATO_BD_FECHA){
        if( self::esFecha($fecha, $formato_entrada) ){
            $fecha = self::toFormatoBd($fecha, $formato_entrada);
            return date( $formato_entrada, strtotime("+ " . $num_meses . " month", strtotime($fecha)) );
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function restarMeses($fecha, $num_meses, $formato_entrada = self::_FORMATO_BD_FECHA){
        if( self::esFecha($fecha, $formato_entrada) ){
            $fecha = self::toFormatoBd($fecha, $formato_entrada);
            return date( $formato_entrada, strtotime("- " . $num_meses . " month", strtotime($fecha)) );
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function sumarAnos($fecha, $num_anos, $formato_entrada = self::_FORMATO_BD_FECHA){
        if( self::esFecha($fecha, $formato_entrada) ){
            $fecha = self::toFormatoBd($fecha, $formato_entrada);
            return date( $formato_entrada, strtotime("+ " . $num_anos . " year", strtotime($fecha)) );
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function restarAnos($fecha, $num_anos, $formato_entrada = self::_FORMATO_BD_FECHA){
        if( self::esFecha($fecha, $formato_entrada) ){
            $fecha = self::toFormatoBd($fecha, $formato_entrada);
            return date( $formato_entrada, strtotime("- " . $num_anos . " year", strtotime($fecha)) );
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function getDistancia($fecha1, $fecha2, $formato_entrada = self::_FORMATO_BD_FECHA, $unit = 'd', $abs = false, $redondear = 'floor'){
        if( self::esFecha($fecha1, $formato_entrada) && self::esFecha($fecha2, $formato_entrada)){
            $fecha1 = self::toFormatoBdFechaHora($fecha1, $formato_entrada);
            $fecha2 = self::toFormatoBdFechaHora($fecha2, $formato_entrada);
            $result = strtotime($fecha2) - strtotime($fecha1);
            switch($unit){
                case 'w':
                    $result = $result / (60 * 60 * 24 * 7);
                    break;
                case 'd':
                    $result = $result / (60 * 60 * 24);
                    break;
                case 'h':
                    $result = $result / (60 * 60);
                    break;
                case 'i':
                    $result = $result / 60;
                    break;
                case 's':
                    break;
                default:
                    $result = $result / (60 * 60 * 24);
            }

            switch($redondear){
                case 'floor':
                    $result = floor($result);
                    break;
                case 'round':
                    $result = round($result);
                    break;
                case 'ceil':
                    $result = ceil($result);
                    break;
                case '':
                case false:
                    break;
                default:
                    $result = floor($result);
            }

            return ($abs)? abs($result) : $result;
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function getProximasFechas($fecha, $num_dias, $formato_entrada = self::_FORMATO_BD_FECHA){
        if( self::esFecha($fecha, $formato_entrada) ){
            $fechas = array();
            for($i=0; $i <= $num_dias; $i++){
                $fechas[] = self::sumarDias($fecha, $i, $formato_entrada);
            }
            return $fechas;
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function getAnterioresFechas($fecha, $num_dias, $formato_entrada = self::_FORMATO_BD_FECHA){
        if( self::esFecha($fecha, $formato_entrada) ){
            $fechas = array();
            for($i=0; $i <= $num_dias; $i++){
                $fechas[] = self::restarDias($fecha, $i, $formato_entrada);
            }
            return $fechas;
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function getNumDiasLaborables($mes, $ano, $dias_no_laborables =  array('6', '7')){
        $fecha_inicio = self::crearFechaBD($ano, $mes, '01');
        if( self::esFecha($fecha_inicio, self::_FORMATO_BD_FECHA) ){
            $num_dias = 0;
            $fecha_fin = self::sumarMeses($fecha_inicio, 1);
            for($fecha = $fecha_inicio; $fecha != $fecha_fin; $fecha = self::sumarDias($fecha, 1)){
                $dia = self::getDiaSemanaNum($fecha);
                if(!in_array($dia, $dias_no_laborables)){
                    $num_dias++;
                }
            }
            return $num_dias;
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function getNumDiasMes($mes, $ano){
        $fecha = self::crearFechaBD($ano, $mes, '01');
        if( self::esFecha($fecha, self::_FORMATO_BD_FECHA) ){
            return date('t', strtotime($fecha));
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function esBisiesto($ano){
        $fecha = self::crearFechaBD($ano, '01', '01');
        if( self::esFecha($fecha, self::_FORMATO_BD_FECHA) ){
            return date('L', strtotime($fecha));
        }else{
            return self::_DEFAULT_FORMATO;
        }
    }

    public static function getSemanasMes($ano, $mes){
        $semanas = array();
        $fecha_inicio = self::crearFechaBD($ano, $mes, '01');
        do{
            $semana = self::getFechasSemana($fecha_inicio);
            $semanas[] = $semana;
            $fecha_inicio = self::sumarDias($semana['fin'], 1);
        }while($mes == self::getMes($fecha_inicio) );

        return $semanas;
    }

    public static function getFechasSemana($inicio_semana){
        $num_dia_inicio_semana = date('N', strtotime($inicio_semana));
        switch($num_dia_inicio_semana){
            case 7:
                $num_dia_para_fin = 0;
                break;
            case 1:
                $num_dia_para_fin = 6;
                break;
            case 2:
                $num_dia_para_fin = 5;
                break;
            case 3:
                $num_dia_para_fin = 4;
                break;
            case 4:
                $num_dia_para_fin = 3;
                break;
            case 5:
                $num_dia_para_fin = 2;
                break;
            case 6:
                $num_dia_para_fin = 1;
                break;
            default:
                return array();
        }

        $num_semana = self::getSemana($inicio_semana);
        $mes = self::getMes($inicio_semana);
        $final_semana = self::sumarDias($inicio_semana, $num_dia_para_fin);
        while(self::getMes($final_semana) != $mes){
            $final_semana = self::restarDias($final_semana, 1);
        }

        return array(
            'num' => $num_semana,
            'inicio' => $inicio_semana,
            'fin' => $final_semana,
        );
    }

    public static function getNombresDias(){
        return self::$_NOMBRES_DIAS_SEMANA;
    }

    public static function getNombresMeses(){
        return self::$_NOMBRES_MESES;
    }

}