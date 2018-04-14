<?php

Class RegistroController extends AppController{
    /**
     * FUNCIONES A LAS QUE PUEDE ACCEDER SIN NECESIDAD DE LOGUEARSE
     */
    public function beforeFilter(){
        $this->Auth->allow(array(
            'index',
        ));
        parent::beforeFilter();
    }

    //FUNCION INICIAL
    public function index(){

    }
}