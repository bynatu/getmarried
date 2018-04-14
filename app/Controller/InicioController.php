<?php

Class InicioController extends AppController{
    /**
     * MODELOS A UTILIZAR
     */
    public $uses = array(
        'Tipo',
    );

    /**
     * FUNCIONES CON ACCESO SIN LOGUEO
     */
    public function beforeFilter(){
        $this->Auth->allow(array(
            'index',
        ));
        parent::beforeFilter();
    }

    /**
     * FUNCION PARA CARGAR LOS DATOS DE LOS TIPOS DE EMPRESAS
     */
    public function index() {
        $tipos = $this->Tipo->find('all');
        $this->set(array(
           'tipos' => $tipos
        ));
    }




}