<?php

class Oferta extends AppModel
{
    public $useTable = 'ofertas';

    public function obtenerofertasdesolicitud($solicitud_id){
        return $this->find('all',array(
            'joins'=>array(
                array(
                    'alias' => 'Empresa', 
                    'table' => 'empresas', 
                    'type'=>'INNER',
                    'conditions' => array(
                        'Oferta.empresa = Empresa.id'
                        ), 
                    ), 
                ), 
            'conditions' => array(
                'Oferta.solicitud' => $solicitud_id
                ),
            'fields' => array(
                'Oferta.*',
                'Empresa.nombre'
            )
        )
        );
    }

    public $_consultas = array(
        'listado' => array(
            'joins'=> array(
                array(
                    'alias'=>'Empresa',
                    'table'=>'empresas',
                    'type'=>'INNER',
                    'conditions' => array(
                        'Empresa.id = Oferta.empresa'
                    )
                )
               
            ),
            'fields' => array(
                'Oferta.*',
                'Empresa.nombre',
            ),
            'order' => array(
                'Oferta.nombre' => 'desc',
            )
        ),
    );

    public function consulta($index){
        return $this->_consultas[$index];
    }

    public function condicion_solicitud($solicitud){
        $condiciones[] = array('Oferta.solicitud' => $solicitud);
        return $condiciones;
    }

}