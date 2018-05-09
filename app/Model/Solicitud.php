<?php

class Solicitud extends AppModel
{

    /**
     * @var TABLA DE LA BASE DE DATOS A UTILIZAR
     */
    public $useTable = 'solicitudes';


    /**
     * FUNCION PARA VALIDAR LOS REGISTROS ANTES DE GUARDAR LOS DATOS
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
     * FUNCION PARA OBTENER LAS SOLICITUDES DE UN CLIENTE
     * @param $cliente - ID DEL CLIENTE
     * @return array|null - DATOS DE LAS SOLICITUDES
     */
    public function obtenerSolicitudesPorCliente($cliente)
    {
        return $this->find('all', array(
                'joins' => array(
                    array(
                        'alias' => 'Tipo',
                        'table' => 'tipos',
                        'type' => 'INNER',
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
                'order' => array('Solicitud.fecha_creacion' => 'desc')
            )
        );
    }


    /**
     * FUNCION PARA OBTENER LAS SOLICITUDES DE UN TIPO DE EMPRESA
     * @param $empresa_tipo - ID DEL TIPO DE EMPRESA
     * @return array|null - DATOS DE LAS SOLICITUDES
     */
    public function obtenerSolicitudesPorEmpresa($empresa_tipo)
    {
        return $this->find('all', array(
                'joins' => array(
                    array(
                        'alias' => 'Tipo',
                        'table' => 'tipos',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Solicitud.servicio = Tipo.id'
                        ),
                    ),
                    array(
                        'alias' => 'Cliente',
                        'table' => 'clientes',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Solicitud.cliente = Cliente.id'
                        ),
                    ),
                ),
                'conditions' => array(
                    'Solicitud.servicio' => $empresa_tipo,
                    'Solicitud.aceptado' => ConstantesBool::FALSO,
                ),
                'fields' => array(
                    'Solicitud.*',
                    'Tipo.nombre',
                    'Cliente.nombre',
                ),
                'order' => array('Solicitud.fecha_creacion' => 'desc')
            )
        );
    }


    /**
     * FUNCION PARA OBTENER LOS DATOS DE UNA SOLICITUD POR ID CON JOIN DEL TIPO
     * @param $solicitud_id - ID DE LA SOLICITUD
     * @return array|null - DATOS DE LA SOLICITUD
     */
    public function obtenerSolicitudesbyID($solicitud_id)
    {
        return $this->find('first', array(
                'joins' => array(
                    array(
                        'alias' => 'Tipo',
                        'table' => 'tipos',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Solicitud.servicio = Tipo.id'
                        ),
                    )
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

    /**
     * FUNCION PARA ACEPTAR UNA OFERTA
     * @param $oferta - ID DE LA OFERTA
     * @throws Exception SQLEXCEPTION
     */
    public function aceptarOferta($oferta)
    {
        //CAMPOS DE LA BASE DE DATOS
        $fields = array(
            'Solicitud' => array(
                'id',
                'precio',
                'aceptado',
            )
        );
        //GUARDAR LOS CAMBIOS
        $this->save($oferta, $fields);
    }

    /**
     * OBTENER LAS SOLICITUDES SIN OFERTAS
     * @param $total - TODAS LAS SOLICITUDES
     * @param $out - SOLICITUDES A EXTRAER
     */
    public function limpiarregistros($total, $out)
    {
        $solicitudes = array();
        foreach ($total as $solicitud) {
            $id = $solicitud['Solicitud']['id'];
            $i = 0;
            $encontrado = ConstantesBool::FALSO;
            while ($i < count($out) and $encontrado == ConstantesBool::FALSO) {
                if ($out[$i]['Oferta']['solicitud'] == $id) {
                    $encontrado = ConstantesBool::VERDADERO;
                } else {
                    $i++;
                }
            }
            if($encontrado == ConstantesBool::FALSO){
                $solicitudes[] = $solicitud;
            }
        }
        return $solicitudes;

    }


}