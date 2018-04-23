<?php

class UsuariosController extends AppController {

/**
 * FUNCION PARA DAR ACCESO A CIERTAS PARTES DE LA APLICACION SIN NECESIDAD DE LOGUEO
 */
public function beforeFilter() {
    $this->Auth->allow(array(
        'recuperar_password',
        'add',
    ));
    parent::beforeFilter();
}

/**
 * FUNCION QUE NOS PERMITE LOGEARNOS
 */
public function login() {
    if($this->request->is('post')){
        //INTENTAMOS REALIZAR LA VALIDACION DE UN USUARIO 
        //MANDANDO LOS DATOS DESPUES DE REALIZAR EL LOGEO
        $user = $this->Acceso->obtenerDatosUsuario($this->request, $this->response);
        //COMPROBAMOS SI SE PUEDE LOGEAR UN USUARIO
        if ($this->Auth->login($user)) {
            //SI SE LOGEA REALIZAMOS UN REDIRECCIONAMIENTO
            $this->redirect($this->Auth->redirectUrl());
        }else{
            //SINO  LOS DATOS NO COINCIDEN
            $this->Flash->error( ConstantesMensaje::CONTRASEÑAS_MAL);
        }
    }
 }

 /**
  * FUNCION PARA CERRAR LA SESION
  */
public function logout() {
    $this->redirect($this->Auth->logout());
}

public function add(){
    if($this->request->is('post')){
        return $this->Usuario->nuevo($this->request->data);
    }
}


 //Lo que hace este metodo es redireccionar al usuario dependiendo del grupo al que pertenesca
 public function loginRedirect(){
    $userinfo = $this->Auth->user();
    switch($userinfo['Usuario']['rol'])
    {
        //case '3': $this->redirect(array ( 'controller' => 'clientes', 'action' => 'index'),null,true);
        case ConstantesRoles::CLIENTE: $this->redirect(array ( 'controller' => 'clientes', 'action' => 'index'));
        break;
                 
        case ConstantesRoles::EMPRESA: $this->redirect(array ( 'controller' => 'empresas', 'action' => 'index'));
        break;

        case '1': $this->redirect(array ( 'controller' => 'admins', 'action' => 'index'));
        break;
    }
 }

 public function recuperar_password(){
    if($this->request->is('post')){
        $datos = $this->Usuario->findByEmail($this->request->data('Usuario.email'));
        debug($datos);
    }
 }

}