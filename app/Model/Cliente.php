<?php

class Cliente extends AppModel
{
    //tabla de la bbdd ha utilizar
    public $useTable = 'clientes';
    //campo de la bbdd ha mostrar por defecto
    public $displayField = 'nombre';

    /**
     * Funcion para obtener los datos de un cliente mediante su clave unica no primaria de email
     * @param $email //email para la obtencion de datos del cliente
     * @return datos obtenidos de la consulta
     */
    public function obtenerdatosclientebymail($email){
        return $this->find('first', array(
            'conditions' => array(
                'Cliente.email' => $email
            ),
            'fields' => array(
                'Cliente.*',
            )
        ));
    }


    /**
     * Funcion para dar de alta un nuevo cliente
     * @param $cliente datos del cliente
     * @return bool|mixed true si se crea el cliente o false si hay algun error
     * @throws Exception
     */
    public function nuevo($cliente)
    {
        $fields = array(
            'Cliente' => array(
                'email',
                'DNI',
                'nombre',
                'apellidos',
                'fnto',
                'telefono',
                'direccion',
                'numero',
                'piso',
                'localidad',
                'ciudad',
                'nacionalidad',
            )
        );

        $this->create();

        if ($tmp = $this->save($cliente, $fields)) {
            return $tmp;
        }
        return false;

    }


    /**
     * Funcion que nos permite editar los datos de un cliente mandando en el conjunto
     * de los datos ($cliente) el email que en el formulario se encuentra oculto (hidden)
     * @param $cliente cliente a editar
     * @return bool true si se a podido editar el cliente o false si hay algun error
     * @throws Exception
     */
    public function edit($cliente){
        $fields = array(
            'Cliente' => array(
                'nombre',
                'apellidos',
                'f_nacimiento',
                'telefono',
                'direccion',
                'numero',
                'piso',
                'localidad',
                'ciudad',
                'nacionalidad',
            )
        );
        if($this->save($cliente, $fields)){
            return true;
        } else{
            return false;
        }

    }

    /**
     * Funcion para validar los datos antes de realizar crear o editar los registros
     */
    public $validate = array(
        'DNI' => array(
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
        'apellidos' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'Los apellidos son obligatorios'
            ),
        ),
    );


}