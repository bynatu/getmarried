<?php

class Tipo extends AppModel
{
    public $useTable = 'tipos';
    public $displayField = 'nombre';

    /**
     * funcion para obtener los datos de los tipos de empresa en forma de lista
     */
    public function selecttipos(){
        $data = $this->find('all',array(
            'fields' => array(
                'id','nombre'
            ),
        ));
        foreach ($data as $dat){
            $datos[$dat['Tipo']['id']] = $dat['Tipo']['nombre'] ;
        }
        return $datos;
    }






}