<?php

class Solicitud extends AppModel {
    public $useTable = 'solicitudes'; 


    /**
     * Funcion para validar los datos antes de realizar crear o editar los registros
     */
    public $validate = array(
        'descripcion' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'La descripcion es obligatoria'
            ),
        ),
        'ubicacion' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'La ubicacion es obligatoria'
            ),
        ),
        'fecha' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'La fecha es obligatoria'
            ),
        ),
        'precio' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'El precio es obligatorio'
            ),
        ),
    );
    
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
            'order' => array('Solicitud.fecha_creacion'=>'desc')
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

    public function aceptarOferta($oferta){
        $fields = array(
            'Solicitud'=>array(
                'id',
                'precio',
                'aceptado',
            )
            );
        $this->save($oferta,$fields);
    }


}