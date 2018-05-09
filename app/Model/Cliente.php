<?php

class Cliente extends AppModel
{
    /**
     * @var TABLA DE LA BASE DE DATOS A UTILIZAR
     */
    public $useTable = 'clientes';

    /**
     * @var CAMPO A MOSTRAR POR DEFECTO
     */
    public $displayField = 'nombre';

    /**
     * FUNCION PARA OBTENER LOS DATOS DE UN CLIENTE MEDIANTE SU EMAIL
     * @param $email - CORREO DEL CLIENTE - (UNIQUE)
     * @return array|null - DATOS DEL CLIENTE
     */
    public function obtenerdatosclientebymail($email)
    {
        return $this->find('first', array(
            'conditions' => array(
                'Cliente.email' => $email
            ),
            'fields' => array(
                'Cliente.*',
            )
        ));
    }


    public function obtenerdatosclientebyId($cliente)
    {
        return $this->find('first', array(
            'conditions' => array(
                'Cliente.id' => $cliente
            ),
            'fields' => array(
                'Cliente.*',
            )
        ));
    }

    /**
     * FUNCION PARA DAR DE ALTA UN NUEVO CLIENTE
     * @param $cliente - DATOS DEL NUEVO CLIENTE
     * @return bool|mixed - RETURN TRUE SI ES CREADOO FALSE SI DA ERROR
     * @throws Exception -SQL EXCEPTION
     */
    public function nuevo($cliente)
    {
        $cliente['f_nacimiento'] = Fecha::toFormatoBd($cliente['f_nacimiento']);
        //CAMPOS A GUARDAR EN LA BASE DE DATOS
        $fields = array(
            'Cliente' => array(
                'email',
                'DNI',
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
        //FUNCION PARA QUE CREE EL REGISTRO
        $this->create();

        //GUARDAR LOS DATOS DEL CLIENTE
        if ($tmp = $this->save($cliente, $fields)) {
            return $tmp;
        }
        return false;

    }


    /**
     * FUNCION QUE NOS PERMITE EDITAR LOS DATOS DE UN CLIENTE
     * @param $cliente - DATOS DEL CLIENTE
     * @return bool - RETURN TRUE SI ES CREADOO FALSE SI DA ERROR
     * @throws Exception  -SQL EXCEPTION
     */
    public function edit($cliente)
    {
        $cliente['f_nacimiento'] = Fecha::toFormatoBd($cliente['f_nacimiento']);
        //CAMPOS A GUARDAR EN LA BASE DE DATOS
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

        //GUARDAR LOS DATOS DEL CLIENTE
        if ($this->save($cliente, $fields)) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * FUNCION PARA VALIDAR LOS DATOS ANTES DE INSERTARLES EN LA BASE DE DATOS
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

    /**
     * CONSULTA PERTENECIENTE AL LISTADO DE CLIENTES
     */
    public $_consultas = array(

        'search' => array(
            'fields' => array(
                'Cliente.id',
                'Cliente.nombre',
                'Cliente.direccion',
                'Cliente.numero',
                'Cliente.piso',
                'Cliente.ciudad',
                'Cliente.apellidos',
                'Cliente.email',
                'Cliente.telefono',

            ),
        ),
    );


    /**
     * CONSULTA PERTENECIENTE AL LISTADO DE CLIENTES
     * @param $index - BUSCADOR
     * @return sql para la consulta
     */
    public function consulta($index)
    {
        return $this->_consultas[$index];
    }



    /**
     * CONSULTA PERTENECIENTE AL LISTADO DE CLIENTES SEGUN EL BUSCADOR (condiciones)
     * @param $fields - BUSCADOR
     * @return sql para la consulta
     */
    public function condiciones($fields)
    {
        $condiciones[] = array();
        if (!empty($fields['nombre'])) {
            $condiciones[] = $this->_condicionNombre($fields['nombre']);
        }
        if (!empty($fields['apellidos'])) {
            $condiciones[] = $this->_condicionApellidos($fields['apellidos']);
        }
        if (!empty($fields['email'])) {
            $condiciones[] = $this->_condicionEmail($fields['email']);
        }
        if (!empty($fields['ciudad'])) {
            $condiciones[] = $this->_condicionCiudad($fields['ciudad']);
        }
        if (!empty($fields['DNI'])) {
            $condiciones[] = $this->_condicionDNI($fields['DNI']);
        }
        return $condiciones;
    }

    /// - CONDICIONES DEL BUSCADOR - ///
    private function _condicionNombre($name)
    {
        return array('Cliente.nombre LIKE' => '%' . $name . '%');
    }

    private function _condicionApellidos($apellido)
    {
        return array('Cliente.apellidos LIKE' => '%' . $apellido . '%');
    }

    private function _condicionEmail($mail)
    {
        return array('Cliente.email' => $mail);
    }

    private function _condicionCiudad($ciudad)
    {
        return array('Cliente.ciudad LIKE' => '%' . $ciudad . '%');
    }

    private function _condicionDNI($DNI)
    {
        return array('Cliente.DNI' => $DNI);
    }

    public function obtenertodo(){
        $clientes =  $this->find('all',array(
            'fields'=> array(
                'id',
                'email',
                'DNI',
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
        ));
        return $clientes;
    }

}