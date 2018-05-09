<?php

class Image extends AppModel{

    public $table = 'images';

    public function add($image,$user,$rol){
        $fields = array(
            'Image'=> array(
                'usuario',
                'rol',
                'nombre',
                'tipo',
                'size',
            )
        );

        $datos['usuario'] = $user;
        $datos['rol'] = $rol;
        $datos['nombre'] = $image['Image']['file']['name'];
        $datos['tipo'] = $image['Image']['file']['type'];
        $datos['size'] = $image['Image']['file']['size'];
        $this->save($datos,$fields);
    }
}
