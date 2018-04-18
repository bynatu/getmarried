 <?php

Class OfertasController extends AppController{

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
}