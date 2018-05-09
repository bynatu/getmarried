<?php

class UsuariosController extends AppController
{

    /**
     * MODELOS QUE VAMOS A UTILIZAR
     */
    public $uses = array(
        'Cliente',
        'Usuario',
        'Empresa'
    );

    /**
     * FUNCION PARA DAR ACCESO A CIERTAS PARTES DE LA APLICACION SIN NECESIDAD DE LOGUEO
     */
    public function beforeFilter()
    {
        $this->Auth->allow(array(
            'password',
            'add',
        ));
        parent::beforeFilter();
    }

    /**
     * FUNCION QUE NOS PERMITE LOGEARNOS
     */
    public function login()
    {
        if ($this->request->is('post')) {
            //INTENTAMOS REALIZAR LA VALIDACION DE UN USUARIO
            //MANDANDO LOS DATOS DESPUES DE REALIZAR EL LOGEO
            $user = $this->Acceso->obtenerDatosUsuario($this->request, $this->response);
            //COMPROBAMOS SI SE PUEDE LOGEAR UN USUARIO
            if ($this->Auth->login($user)) {
                //SI SE LOGEA REALIZAMOS UN REDIRECCIONAMIENTO
                $this->redirect($this->Auth->redirectUrl());
            } else {
                //SINO  LOS DATOS NO COINCIDEN
                $this->Flash->error(ConstantesMensaje::PASSWORD_MAL);
            }
        }
    }

    /**
     * FUNCION PARA CERRAR LA SESION
     */
    public function logout()
    {
        $this->redirect($this->Auth->logout());
    }

    /**
     * FUNCION PARA AÑADIR UN NUEVO USUARIO
     * @return LLAMADA A FUNCION PARA CREAR USUARIO
     */
    public function add()
    {
        //SI TENEMOS DATOS POR POST
        if ($this->request->is('post')) {
            //GUARDAMOS LOS DATOS
            return $this->Usuario->nuevo($this->request->data);
        }
    }


    /**
     * REDIRECCIONAMIENTO POSTERIOR A LOGIN
     */
    public function loginRedirect()
    {
        //OBTENEMOS LOS DATOS DEL USUARIO LOGUEADO
        $userinfo = $this->Auth->user();
        //COMPROBAMOS SU ROL Y REDIRECCIONAMOS SEGUN EL CUAL SEA
        switch ($userinfo['Usuario']['rol']) {
            case ConstantesRoles::CLIENTE:
                $this->redirect(array('controller' => 'clientes', 'action' => 'index'));
                break;
            case ConstantesRoles::EMPRESA:
                $this->redirect(array('controller' => 'empresas', 'action' => 'index'));
                break;
            case ConstantesRoles::ADMIN:
                $this->redirect(array('controller' => 'admins', 'action' => 'index'));
                break;
        }
    }

    /**
     * FUNCION PARA EDITAR LOS DATOS DEL USUARIO
     */
    public function editar()
    {
        //OBTNEMOS EL ID DEL USUARIO LOGUEADO
        $user_id = $this->Session->read('Auth.User.Usuario.id');;
        //OBTENEMOS LOS DATOS DEL USUARIO MEDIANTE SU ID
        $user = $this->Usuario->findById($user_id);

        //COMPROBAMOS SI LLEGAN LOS DATOS POR POST O POR GET
        if ($this->request->is('post')) {
            $this->request->data['id'] = $user['Usuario']['id'];
            $this->request->data['rol'] = $user['Usuario']['rol'];
            if (isset($this->request->data['email'])) {
                $this->request->data['verificacion'] = $user['Usuario']['verificacion'];
                $this->request->data['password'] = $user['Usuario']['verificacion'];
            } else {
                if ($this->request->data['password'] != $this->request->data['passwordrepeat']) {
                    $error = 0;
                }
                $this->request->data['verificacion'] = $this->request->data['password'];
                $this->request->data['email'] = $user['Usuario']['email'];
            }
            if (isset($error)) {
                $this->Flash->error('NO COINCIDEN LAS CONTRASEÑAS');
            } else {
                $verificacion = str_replace(' ', '', $this->request->data['verificacion']);
                $password = str_replace(' ', '', $this->request->data['password']);;
                $this->request->data['verificacion'] = $verificacion;
                $this->request->data['password'] = $password;
                //EDITAMOS LOS DATOS
                $tmp = $this->Usuario->save($this->request->data);
                if ($tmp == false) {
                    $this->Flash->error(ConstantesMensaje::EDITAR_MAL);
                } else {
                    $this->Flash->success(ConstantesMensaje::EDITAR_BIEN);
                    $this->redirect(array(
                        'controller' => 'clientes',
                        'action' => 'index'
                    ));
                }
            }
        } else {
            $this->request->data = $user;
        }
    }

    public function password()
    {
        if ($this->request->is('post')) {
            $datos = $this->Usuario->findByEmail($this->request->data('email'));
            $mensaje = "Hemos recibido una solicitud, para recordar su contraseña, sus credenciales son:";
            $mensaje .= "\n\t Email: '" . $this->request->data('email')."'";
            $mensaje .= "\n\t Contraseña: '" . $datos['Usuario']['verificacion']."'";;
            $mensaje .= "\nAtentamente soporte de getmarried.ml";
            $email = new CakeEmail('gmail');
			 //$email = new CakeEmail('default');
            //$email->from('info@getmarried.ml');
            $email->to($this->request->data('email'));
            $email->subject('Recordar credenciales');
            $email->send($mensaje);
            $this->redirect(array('controller' => 'usuarios', 'action' => 'login'));
            $this->Flash->success('Le hemos enviado sus credenciales. Conpruebe su correo electronico');

    }
    }

}