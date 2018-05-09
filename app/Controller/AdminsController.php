<?php

Class AdminsController extends AppController
{

    public function index(){
        if (!$this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::ADMIN) {
            $this->render('Errors/missing_view');
        }
    }
}