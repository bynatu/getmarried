<?php

Class SolicitudesController extends AppController{

    /**
     * MODELOS PARA USAR
     */
    public $uses = array(
      'Solicitud',
      'Oferta',
      'Tipo',
      'Cliente',
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


    public function nueva(){
        if($this->request->is('post')){
            $mail = $this->Session->read('Auth.User.Usuario.email');
            $datos = $this->Cliente->obtenerdatosclientebymail($mail);
            $this->request->data['cliente'] =  $datos['Cliente']['id'];
            $this->request->data['fecha_creacion'] =  date('Y-m-d');
            if($this->Solicitud->save($this->request->data)){
                $this->Flash->success( ConstantesMensaje::SOLICITUD_BIEN);
            }else{
                $this->Flash->success( ConstantesMensaje::SOLICITUD_MAL);
            }
            $this->redirect(array(
                'controller' => 'clientes', 'action' => 'index'
            ));
        }
         //SI NO TENEMOS DATOS POR POST ES PORQUE ESTAMOS INTENTANDO VISUALIZAR EL FORMULARIO DE REGISTRO
        //LE MANDAMOS LAS OPCIONES DEL TIPO DE EMPRESA
        $options = $this->Tipo->selecttipos();
        $this->set(array(
            'options' => $options,
        ));
    }

    public function ajax_aceptada(){
        $solicitud_id = $this->request->data('solicitud');
        $oferta = $this->Oferta->obtenerOfertaAceptada($solicitud_id);
        echo json_encode( $oferta);
        $this->layout = false;
        $this->autoRender = false;
    }
    
    public function ajax_borrar(){
        $solicitud_id = $this->request->data('solicitud');
        $ofertas = $this->Oferta->obtenerofertasdesolicitud($solicitud_id);
        if(count($ofertas) == 0){
            $this->Solicitud->delete($solicitud_id );
            echo Router::url(array('controller'=>'clientes', 'action'=>'index'));
        }
        else{
            echo 0;
        }
        $this->layout = false;
        $this->autoRender = false;
    }

    public function ajax_editar(){
        $solicitud_id = $this->request->data('solicitud');
        $ofertas = $this->Oferta->obtenerofertasdesolicitud($solicitud_id);
        if(count($ofertas) == 0){
            echo Router::url(array('controller'=>'solicitudes', 'action'=>'editar', $solicitud_id));
        }
        else{
            echo 0;
        }
        $this->layout = false;
        $this->autoRender = false;
    }


        /**
     * FUNCION PARA EDITAR LOS DATOS DE UNA SOLICITUD 
     * @PARAMS - ID DEL CLIENTE A EDITAR 
     */
    public function editar($solicitud_id){
        //OBTENEMOS LOS DATOS DE LA SOLICITUD MEDIANTE SU ID
        $solicitud = $this->Solicitud->findById($solicitud_id);
        if (!$solicitud) {
            throw new NotFoundException();
        }
        //COMPROBAMOS SI LA PETICION SE REALIZO POR GET O POST
        //SI ES GET - COLOCAMOS EL REQUEST DATA LOS DATOS DE LA SOLICITUD
        if ($this->request->is('get')) {
            $this->request->data = $solicitud;
        } 
        //MANDAMOS LOS DATOS DE LA SOLICITUD A EDITAR
        else {
            //MANDAMOS LOS DATOS RECIBIDOS DEL FORMULARIO
            if ($this->Solicitud->save($this->request->data)) {
                //MOSTRAMOS MENSAJE
                $this->Flash->success(ConstantesMensaje::EDITAR_BIEN);
                //REDIRECIONAMOS A LA PAGINA PRINCIPAL DE LA SOLICITUD
                $this->redirect(array(
                    'controller'=>'solicitudes','action' => 'detalles',$solicitud_id
                ));
            } else {
                $this->Flash->error( ConstantesMensaje::EDITAR_MAL);
            }
        }
            //SI NO TENEMOS DATOS POR POST ES PORQUE ESTAMOS INTENTANDO VISUALIZAR EL FORMULARIO DE REGISTRO
        //LE MANDAMOS LAS OPCIONES DEL TIPO DE EMPRESA
        $options = $this->Tipo->selecttipos();
        $this->set(array(
            'options' => $options,
        ));
    }


    

}