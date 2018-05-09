<?php

class Empresa extends AppModel
{
    /**
     * @var TABLA DE LA BASE DE DATOS A UTILIZAR
     */
    public $useTable = 'empresas';

    /**
     * @var CAMPO A MOSTRAR POR DEFECTO
     */
    public $displayField = 'nombre';

    /**
     * FUNCION PARA OBTENER LOS DATOS DE LA EMPRESA POR EMAIL
     * @param $email - EMAIL DE LA EMPRESA - (UNIQUE)
     * @return array|null - DATOS DE LA EMPRESA
     */
    public function obtenerdatosempresabymail($email)
    {
        return $this->find('first', array(
            'joins' => array(
                array(
                    'alias' => 'Tipo',
                    'table' => 'tipos',
                    'conditions' => array(
                        'Empresa.tipo = Tipo.id'
                    ),
                )
            ),
            'conditions' => array(
                'Empresa.email' => $email
            ),
            'fields' => array(
                'Empresa.*',
                'Tipo.*'
            )
        ));
    }



    /**
     * FUNCION PARA OBTENER LOS DATOS DE LA EMPRESA POR EMAIL
     * @param $empresa_id - ID DE LA EMPRESA - (UNIQUE)
     * @return array|null - DATOS DE LA EMPRESA
     */
    public function obtenerdatosempresabyId($empresa_id)
    {
        return $this->find('first', array(
            'joins' => array(
                array(
                    'alias' => 'Tipo',
                    'table' => 'tipos',
                    'conditions' => array(
                        'Empresa.tipo = Tipo.id'
                    ),
                )
            ),
            'conditions' => array(
                'Empresa.id' => $empresa_id
            ),
            'fields' => array(
                'Empresa.*',
                'Tipo.*'
            )
        ));
    }

    /**
     * FUNCION PARA DAR DE ALTA UNA NUEVA EMPRESA
     * @param $empresa - DATOS DE LA EMPRESA
     * @return bool|mixed - RETURN TRUE SI SE PUEDO GUARDAR O FALSE SI OCURRIO UN ERROR
     * @throws Exception -SQL EXCEPTION
     */
    public function nuevo($empresa)
    {
        //CAMPOS A GUARDAR EN LA BASE DE DATOS
        $fields = array(
            'Empresa' => array(
                'email',
                'nombre',
                'tipo',
                'www',
                'telefono',
                'direccion',
                'numero',
                'piso',
                'provincia',
                'ciudad',
                'latitud',
                'longitud',
            )
        );

        //FUNCION PARA INDICAR QUE CREE UN NUEVO REGISTRO
        $this->create();

        //GUARDAR LOS DATOS EN LA BASE DE DATOS
        if ($tmp = $this->save($empresa, $fields)) {
            return $tmp;
        }
        return false;

    }

    /**
     * FUNCION PARA EDITAR LOS DATOS DE UNA EMPRESA
     * @param $empresa - DATOS DE LA EMPRESA
     * @return bool - RETURN TRUE SI SE GUARDARON LOS DATOS Y FALSE SI OCURRIO ALGUN ERROR
     * @throws Exception - SQLEXCEPTION
     */
    public function edit($empresa)
    {
        //CAMPOS A GUARDAR
        $fields = array(
            'Empresa' => array(
                'email',
                'NIF',
                'nombre',
                'tipo',
                'www',
                'telefono',
                'direccion',
                'numero',
                'piso',
                'provincia',
                'ciudad',
                'latitud',
                'longitud',
            )
        );
        //GUARDAR LOS DATOS
        if ($this->save($empresa, $fields)) {
            return true;
        } else {
            return false;
        }


    }

    /**
     * FUNCION PARA VALIDAR LOS DATOS ANTES DE INSERTARLES EN LA BASE DE DATOS
     */
    public $validate = array(
        'NIF' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'El dni es obligatorio'
            ),
        ),
        'nombre' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'El nombre es obligatorio'
            ),
        ),
        'direccion' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'Revise los campos de la dreccion'
            ),
        ),
        'numero' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'Revise los campos de la dreccion'
            ),
        ),
        'piso' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'Revise los campos de la dreccion'
            ),
        ),
        'provincia' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'La localidad es obligatoria'
            ),
        ),
        'ciudad' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'La ciudad es obligatoria'
            )
        ),
    );

    /**
     * CONSULTA PERTENECIENTE AL LISTADO DE EMPRESAS SEGUN SU TIPO
     * @param $tipo - ID DEL TIPO DE EMPRESA
     */
    public $_consultas = array(
        'listado' => array(
            'fields' => array(
                'Empresa.*',
            ),
            'order' => array(
                'Empresa.nombre' => 'desc',
            )
        ),
        'search' => array(
            'joins' => array(
                array(
                    'alias' => 'Tipo',
                    'table' => 'tipos',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Empresa.tipo = Tipo.id'
                    )
                )

            ),
            'fields' => array(
                'Empresa.id',
                'Empresa.nombre',
                'Empresa.direccion',
                'Empresa.numero',
                'Empresa.piso',
                'Empresa.ciudad',
                'Tipo.nombre',

            ),
        ),
    );

    /**
     * CONSULTA PERTENECIENTE AL LISTADO DE EMPRESAS SEGUN SU TIPO (funcion publica)
     * @param $index - ID DEL TIPO DE EMPRESA
     * @return sql para la consulta
     */
    public function consulta($index)
    {
        return $this->_consultas[$index];
    }

    /**
     * CONSULTA PERTENECIENTE AL LISTADO DE EMPRESAS SEGUN SU TIPO (condiciones)
     * @param $index - ID DEL TIPO DE EMPRESA
     * @return sql para la consulta
     */
    public function condicion_tipo($tipo_id)
    {
        $condiciones[] = array('Empresa.tipo' => $tipo_id);
        return $condiciones;
    }

    /**
     * CONSULTA PERTENECIENTE AL LISTADO DE EMPRESAS SEGUN EL BUSCADOR (condiciones)
     * @param $index - ID DEL TIPO DE EMPRESA
     * @return sql para la consulta
     */
    public function condiciones($fields)
    {
        $condiciones[] = array();
        if (!empty($fields['nombre'])) {
            $condiciones[] = $this->_condicionNombre($fields['nombre']);
        }
        if (!empty($fields['tipo'])) {
            $condiciones[] = $this->_condicionTipo($fields['tipo']);
        }
        if (!empty($fields['ciudad'])) {
            $condiciones[] = $this->_condicionCiudad($fields['ciudad']);
        }
        if (!empty($fields['email'])) {
            $condiciones[] = $this->_condicionEmail($fields['email']);
        }
        if (!empty($fields['NIF'])) {
            $condiciones[] = $this->_condicionNIF($fields['NIF']);
        }
        return $condiciones;
    }

    /// - CONDICIONES DEL BUSCADOR - ///
    private function _condicionNombre($name)
    {
        return array('Empresa.nombre LIKE' => '%' . $name . '%');
    }

    private function _condicionTipo($tipo)
    {
        return array('Empresa.tipo' => $tipo);
    }

    private function _condicionCiudad($ciudad)
    {
        return array('Empresa.ciudad LIKE' => '%' . $ciudad . '%');
    }

    private function _condicionEmail($mail)
    {
        return array('Empresa.email' => $mail);
    }

    private function _condicionNIF($NIF)
    {
        return array('Empresa.NIF' => $NIF);
    }

    public function obtenertodo($tipo_id){
        $clientes =  $this->find('all',array(
            'conditions'=>array(
                'Empresa.tipo' => $tipo_id
            ),
            'fields'=> array(
                'id',
                'email',
                'NIF',
                'nombre',
                'www',
                'telefono',
                'direccion',
                'numero',
                'piso',
                'provincia',
                'ciudad',
                'descripcion',
                'latitud',
                'longitud',
            )
        ));
        return $clientes;
    }




}