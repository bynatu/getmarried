<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class Usuario extends AppModel {
    
    public $table = 'usuarios';
    public $displayField = 'email';

    /**
     * campos a validar antes de guaradar o ediatar los datos de un usuario
     */
    public $validate = array(
        'email' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'required' => true,
                'message' => 'El email es obligatorio'
            ),
            'maxLength' => array(
                'rule' => array('maxLength','50'),
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
     * filtros antes de realizar el guardado, en este caso cifrar las contraseñas
     */
    public function beforeSave($options = array()) {
        if (!empty($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }

    /**
     * funcion para dar de alta un nuevo usuario
     * @param $usuario = datos del usuario
     */
    public function nuevo($usuario){
        $fields = array(
            'Usuario' => array(
                'email',
                'password',
                'rol',
            )
        );
        $this->create();
        if ($tmp = $this->save($usuario, $fields)) {
            return $tmp;
        }
        debug($tmp);
        return false;

        }

    }
