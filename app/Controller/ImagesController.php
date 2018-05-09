<?php

class ImagesController extends AppController
{

    private function redimensionar($image)
    {
        $img_origen = imagecreatefromjpeg($image);
        $ancho_origen = imagesx($img_origen); //ancho imagen
        $alto_origen = imagesy($img_origen); //alto imagen
        $ancho_limite = 300;
        if ($ancho_origen > $alto_origen) {//imagenes horizontales
            $ancho_origen = $ancho_limite;
            $alto_origen = $ancho_limite * imagesy($img_origen) / imagesx($img_origen);
        } else { //imagenes verticales
            $alto_origen = $ancho_limite;
            $ancho_origen = $ancho_limite * imagesx($img_origen) / imagesy($img_origen);
        }
        $img_destino = imagecreatetruecolor($ancho_origen, $alto_origen);
        imagecopyresized($img_destino, $img_origen, 0, 0, 0, 0, $ancho_origen, $alto_origen, imagesx($img_origen), imagesy($img_origen));
        imagejpeg($img_destino, $image);
    }

    public function nuevo()
    {
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::EMPRESA or $this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE) {
            if ($this->request->is('post')) {
                if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::EMPRESA) {
                    $nombrearchivo = "files/empresa/" . $this->Session->read('Auth.User.Usuario.id') . '.jpg';
                } else {
                    $nombrearchivo = "files/cliente/" . $this->Session->read('Auth.User.Usuario.id') . '.jpg';
                }
                /* copiamos el archivo*/
                if ($this->request->data['Image']['file']['size'] >= 2097152) {
                    echo('El archivo supera el tamaño maximo permitido de 2MB');
                } else {
                    if (is_file($nombrearchivo)) {
                        unlink($nombrearchivo);
                    } else {
                        $this->request->data['Image']['file']['name'] = $nombrearchivo;
                        $this->Image->add($this->request->data, $this->Session->read('Auth.User.Usuario.id'), $this->Session->read('Auth.User.Usuario.rol'));
                    }
                    if (move_uploaded_file($this->data['Image']['file']['tmp_name'], $nombrearchivo)) {
                        $this->redimensionar($nombrearchivo);
                        /* mensaje al usaurio */
                        echo('Archivo subido satisfactoriamente');
                    } else {
                        /* mensaje al usaurio */
                        echo('Error al subir el archivo, verificar.');
                    }
                }

            }
        }


    }
}