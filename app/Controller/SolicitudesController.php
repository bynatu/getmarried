<?php

Class SolicitudesController extends AppController{

    /**
     * MODELOS PARA USAR
     */
    public $uses = array(
      'Solicitud',
    );



    /**
     * FUNCION PARA OBTENER LOS DATOS DE UNA SOLICITUD Y SUS OFERTAS
     * LAS OFERTAS SE OBTIENEN RENDERIZANDO OTRO CTP
     * @PARAM - $solicitud_id = ID DE LA SOLICITUD
     */
    public function detalles($solicitud_id){
        $solicitud = $this->Solicitud->obtenerSolicitudesbyID($solicitud_id);
        $this->set(array(
            'solicitud' => $solicitud,
        ));
    }


    public function nuevo(){
        debug('Pagina en desarrollo');exit;
    }

    

}