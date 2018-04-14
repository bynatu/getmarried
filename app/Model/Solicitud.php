<?php

class Solicitud extends AppModel {
    public $useTable = 'solicitudes'; 
    
    /**
     * funcion para onbtener las solicitudes de un cliente
     * @param $cliente = el id del cliente
     */
    public function obtenerSolicitudesPorCliente($cliente) {
        return $this -> find('all', array(
            'joins' => array(
                    array(
                        'alias' => 'Tipo', 
                        'table' => 'tipos', 
                        'type'=>'INNER',
                        'conditions' => array(
                            'Solicitud.servicio = Tipo.id'
                            ), 
                        ), 
                    ), 
            'conditions' => array(
                'Solicitud.cliente' => $cliente
                ), 
            'fields' => array(
                'Solicitud.*',
                'Tipo.nombre'
            ), 
            )
        ); 
    }


}