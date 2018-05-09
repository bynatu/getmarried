<?php

class Oferta extends AppModel
{
    /**
     * @var TABLA DE LA BASE DE DATOS A UTILIZAR
     */
    public $useTable = 'ofertas';

    /**
     * FUNCION PARA OBTENER LA OFERTAS DE UNA SOLICITUD
     * @param $solicitud_id - ID DE LA SOLICITUD
     * @return array|null - DATOS DE LAS OFERTAS DE UNA SOLICITUD
     */
    public function obtenerofertasdesolicitud($solicitud_id)
    {
        return $this->find('all', array(
                'joins' => array(
                    array(
                        'alias' => 'Empresa',
                        'table' => 'empresas',
                        'type' => 'INNER',
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

    /**
     * FUNCION PRIVADA PARA REALIZAR EL LISTADO PAGINADO DE LAS OFERTAS DE UNA SOLICITUD
     * @var array
     */
    public $_consultas = array(
        'listado' => array(
            'joins' => array(
                array(
                    'alias' => 'Empresa',
                    'table' => 'empresas',
                    'type' => 'INNER',
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

    /**
     * FUNCION PUBLICA PARA REALIZAR EL LISTADO PAGINADO DE LAS OFERTAS DE UNA SOLICITUD
     * @param $index - ID DE LA SOLICITUD
     * @return mixed - RETURN SQL
     */
    public function consulta($index)
    {
        return $this->_consultas[$index];
    }

    /**
     * CONDICIONES PARA REALIZAR EL LISTADO DE LAS OFERTAS SEGUN UNA SOLICITUD
     * @param $solicitud - ID DE LA SOLICITUD
     * @return array - CONDICIONES DE LA SOLICITUD
     */
    public function condicion_solicitud($solicitud)
    {
        $condiciones[] = array('Oferta.solicitud' => $solicitud);
        return $condiciones;
    }


    /**
     * FUNCION PARA ACEPTAR UNA SOLICITUD
     * @param $oferta - DATOS DE LA OFERTA
     * @throws Exception - SQLEXCEPTION
     */
    public function aceptarOferta($oferta)
    {
        //CAMPOS DE LA BASE DE DATOS
        $fields = array(
            'Oferta' => array(
                'id',
                'aceptado',
            )
        );
        //FUNCION PARA GUARDAR LOS CAMBIOS
        $this->save($oferta, $fields);
    }

    /**
     * FUNCION PARA OBTENER LA OFERTA ACEPTADA DE UNA SOLICITUD
     * @param $solicitud_id - ID DE LA SOLICITUD
     * @return array|null - DATOS DE LA OFERTA ACEPTADA
     */
    public function obtenerOfertaAceptada($solicitud_id)
    {
        return $this->find('first', array(
            'joins' => array(
                array(
                    'alias' => 'Empresa',
                    'table' => 'empresas',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Oferta.empresa = Empresa.id'
                    ),
                ),
            ),
            'conditions' => array(
                'solicitud' => $solicitud_id,
                'Oferta.aceptado' => ConstantesBool::VERDADERO
            ),
            'fields' => array(
                'Oferta.*',
                'Empresa.nombre',
                'Empresa.www',
            )
        ));
    }

    /**
     * FUNCION PARA OBTENER LOS DATOS DE LAS OFERTAS DE UNA EMPRESA
     * @param $empresa_id - ID DE LA EMPRESA
     */
    public function obtenerOfertasEmpresa($empresa_id)
    {
        return $this->find('all',array(
            'joins' => array(
                array(
                    'alias' => 'Solicitud',
                    'table' => 'solicitudes',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Oferta.solicitud = Solicitud.id'
                    ),
                ),
                array(
                    'alias' => 'Cliente',
                    'table' => 'clientes',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Solicitud.cliente = Cliente.id'
                    ),
                )
            ),
            'conditions' => array(
                'Oferta.empresa' => $empresa_id
            ),
            'fields' => array(
                'Oferta.aceptado',
                'Oferta.prestacion',
                'Oferta.presupuesto',
                'Solicitud.id',
                'Cliente.nombre',
            )
        ));
    }


    /**
     * FUNCION PARA VALIDAR LOS DATOS ANTES DE INSERTARLES EN LA BASE DE DATOS
     */
    public $validate = array(
        'prestacion' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'La prestacion es obligatoria'
            ),
        ),
        'presupuesto' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'El presupuesto es obligatorio'
            ),
        ),
    );


}