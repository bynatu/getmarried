<?php

class Empresa extends AppModel
{
    //tabla de la bbdd ha utilizar
    public $useTable = 'empresas';
     //campo de la bbdd ha mostrar por defecto
    public $displayField = 'nombre';

     /**
     * Funcion para obtener los datos de una empresa mediante su clave unica no primaria de email
     * @param $email //email para la obtencion de datos de la empresa
     * @return datos obtenidos de la consulta
     */
    public function obtenerdatosempresabymail($email){
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
     * Funcion para dar de alta un nueva empresa
     * @param $$empresa datos de la empresa
     * @return bool|mixed true si se crea la empresa o false si hay algun error
     * @throws Exception
     */
    public function nuevo($empresa)
    {
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

        $this->create();

        if ($tmp = $this->save($empresa, $fields)) {
            return $tmp;
        }
        return false;

    }

    /**
     * Funcion para editar una empresa
     * @param $empresa datos de la empresa
     * @return bool|mixed true si se editan los datos de la empresa o false si hay algun error
     * @throws Exception
     */
    public function edit($empresa)
    {
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
        if ($this->save($empresa, $fields)) {
            return true;
        } else {
            return false;
        }


    }

    /**
     * Funcion para validar los datos antes de realizar crear o editar los registros
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
            ),
        ),
    );

    public function obtenerdatosempresabyTipo($tipo)
    {
        return $this->find('all', array(
            'conditions' => array(
                'Empresa.tipo' => $tipo
            ),
        ));
    }


    public $_consultas = array(
        'listado' => array(
            'fields' => array(
                'Empresa.*',
            ),
            'order' => array(
                'Empresa.nombre' => 'desc',
            )
        ),
    );

    public function consulta($index){
        return $this->_consultas[$index];
    }

    public function condicion_tipo($tipo_id){
        $condiciones[] = array('Empresa.tipo' => $tipo_id);
        return $condiciones;
    }


}