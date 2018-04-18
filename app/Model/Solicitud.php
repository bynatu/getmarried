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


    /**
     * funcion para obtener los datos de solicitud por id
     * @param $solicitud_id = el id de la solicitud
     */
    public function obtenerSolicitudesbyID($solicitud_id) {
        return $this -> find('first', array(
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
                'Solicitud.id' => $solicitud_id
                ), 
            'fields' => array(
                'Solicitud.*',
                'Tipo.nombre',
                'Tipo.image',
            ), 
            )
        ); 
    }


}