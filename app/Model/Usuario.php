<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class Usuario extends AppModel
{

    /**
     * @var TABLA DE LA BASE DE DATOS A UTILIZAR
     */
    public $table = 'usuarios';

    /**
     * @var CAMPO A MOSTRAR POR DEFECTO
     */
    public $displayField = 'email';

    /**
     * FUNCION PARA VALIDAR LOS DATOS ANTES DE GUARDAR LOS CAMBIOS
     */
    public $validate = array(
        'email' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'El email es obligatorio'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', '50'),
                'message' => 'El email es demasiado largo',
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'allowEmpty' => true,
                'message' => 'Ya existe este email'
            ),
        ),
        'password' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'La contraseña es obligatoria'
            ),
        ),
        'rol' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'El rol es obligatorio'
            ),
        ),
    );

    /**
     * FILTROS QUE SE REALIZARAN ANTES DE GUARDAR LOS CAMBIOS
     * @param array $options
     * @return bool
     */
    public function beforeSave($options = array())
    {
        if (!empty($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }

    /**
     * FUNCION PARA AÑADIR UN NUEVO USUARIO
     * @param $usuario - DATOS DEL USUARIO
     * @return bool|mixed - RETURN TRUE SI SE REALIZAN LOS CAMBIOS O FALSE SI OCURRE ALGUN PROBLEMA
     * @throws Exception - SQLEXCEPTION
     */
    public function nuevo($usuario)
    {
        //CAMPOS
        $fields = array(
            'Usuario' => array(
                'email',
                'password',
                'rol',
            )
        );
        //FUNCION PARA CREAR REGISTRO
        $this->create();

        //GUARDAMOS LOS CAMBIOS
        if ($tmp = $this->save($usuario, $fields)) {
            return $tmp;
        }
        return false;

    }


    public function obtenermail($usuario_id)
    {
        $user = $this->findById($usuario_id);
        return $user['Usuario']['email'];
    }


    public function editar($usuario)
    {
        $user = $this->findById($usuario['id']);
        $user['Usuario']['email'] = $usuario['email'];
        $user['Usuario']['password'] = $usuario['password'];
        $tmp = $this->save($user);
        return $tmp;
    }


}
