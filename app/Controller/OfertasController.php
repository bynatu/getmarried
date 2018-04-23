 <?php

Class OfertasController extends AppController{

    public $uses = array(
        'Oferta',
        'Solicitud',
    );
        
    /**
     * FUNCION PARA OBTENER LAS OFERTAS DE UNA SOLICITUD
     * @param $solicitud_id - id de la solicitud
     * */
    public function ofertassolicitud($solicitud_id){
        //MANDAMOS LOS DATOS DE LA EMPRESA CON LA CONDICION DEL TIPO DE ID
        $ofertas = $this->paginar(
            $this->Oferta->consulta('listado'),
            $this->Oferta->condicion_solicitud($solicitud_id),
            6
        );
        $this->set(array(
            'ofertas' => $ofertas,
        ));
    }

    /**
     * FUNCION PARA ACEPTAR UNA OFERTA Y DESECHAR EL RESTO y actualizar el precio de la solicitud
     */
    public function aceptar($oferta_id){
        $oferta = $this->Oferta->findById($oferta_id);
        $oferta['Oferta']['aceptado'] = ConstantesBool::VERDADERO;
        $solicitud_id = $oferta['Oferta']['solicitud']; 
        $solicitud = $this->Solicitud->findById($solicitud_id);
        $solicitud['Solicitud']['aceptado'] = ConstantesBool::VERDADERO;
        $solicitud['Solicitud']['precio'] = $oferta['Oferta']['presupuesto'];
        $this->Oferta->aceptarOferta($oferta);
        $this->Solicitud->aceptarOferta($solicitud);
        echo Router::url(array('controller'=>'solicitudes','action'=>'detalles', $solicitud_id));
        $this->layout = false;
        $this->autoRender = false;
    }

    /**
     * FUNCION PARA ACEPTAR UNA OFERTA Y DESECHAR EL RESTO y actualizar el precio de la solicitud
     */
    public function cancelar($oferta_id){
        $oferta = $this->Oferta->findById($oferta_id);
        $solicitud_id = $oferta['Oferta']['solicitud']; 
        $this->Oferta->delete($oferta_id);
        echo Router::url(array('controller'=>'ofertas','action'=>'ofertassolicitud', $solicitud_id));
        $this->layout = false;
        $this->autoRender = false;
    }
}