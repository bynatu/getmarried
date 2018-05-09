<?php

App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

/**
 * @property AclComponent $Acl
 * @property AuthComponent $Auth
 */
class AccesoComponent extends Component
{

    /**
     * USO DE COMPONENTES PARA LA AUTENTICACION DE USUARIOS
     */
    public $components = array(
        'Acl',
        'Auth'
    );

    /**
     * FUNCION PARA OBTENER EL ROL DE UN USUARIO
     */
    public function rol()
    {
        return $this->usuario('rol');
    }

    /**
     * FUNCION PARA OBTENER LOS DATOS DE UN USUARIO LOGUEADO
     */
    public function user($key = null)
    {
        return $this->Auth->usuario($key);
    }

    /**
     * FUNCION PARA OBTENER LOS DATOS DE UN USUARIO
     * COMPROBAMOS SI LA CONTRASEÑA Y EL USUARIO COINCIDEN CON ALGUNO
     * DE LOS REGISTRADOS EN LA BASE DE DATOS
     * RETURN -> DATOS DEL USUARIO SI ES VALIDO O NULL SI NO SE HA ENCONTRADO
     */
    function obtenerDatosUsuario($usuario = null)
    {
        if (isset($usuario['data'])) {
            //ESPECIFICAMOS LA CLASE A UTILIZAR
            $this->Usuario = ClassRegistry::init('Usuario');
            //OBTENEMOS LA CONTRASEÑA
            $password = $usuario['data']['password'];
            //OBTENEMOS LOS DATOS DEL USUARIO
            $usuario = $this->Usuario->findByEmail($usuario['data']['email']);
            if (!empty($usuario)) {
                $passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
                if ($passwordHasher->hash($password) == $usuario['Usuario']['password']) {
                    unset($usuario['Usuario']['password']);
                    return $usuario;
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

}