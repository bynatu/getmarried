<?php

Class OfertasController extends AppController
{

    /**
     * MODELOS A UTILIZAR
     */
    public $uses = array(
        'Oferta',
        'Solicitud',
        'Usuario',
        'Image',
        'Cliente',
        'Empresa',
    );

    /**
     * FUNCION PARA OBTENER LAS OFERTAS DE UNA SOLICITUD
     * @param $solicitud_id - id de la solicitud
     * */
    public function ofertassolicitud($solicitud_id)
    {
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE) {
            //OBTENEMOS LOS DATOS DE LA SOLICITUD MEDIANTE SU ID
            $solicitud = $this->Solicitud->findById($solicitud_id);
            //OBTNEMOS EL ID DEL USUARIO LOGUEADO
            $user = $this->Session->read('Auth.User.Usuario.id');
            //OBTNEMOS EL EMAIL DEL USUARIO LOGUEADO
            $mail = $this->Usuario->obtenermail($user);
            //OBTENER DATOS DEL CLIENTE
            $cliente = $this->Cliente->findByEmail($mail);
            //OBTNER LAS SOLICITUDES DEL CLIENTE
            if ($solicitud['Solicitud']['cliente'] != $cliente['Cliente']['id']) {
                $this->render('Errors/missing_view');
            }
            //MANDAMOS LOS DATOS DE LA EMPRESA CON LA CONDICION DEL TIPO DE ID
            $ofertas = $this->paginar(
                $this->Oferta->consulta('listado'),
                $this->Oferta->condicion_solicitud($solicitud_id),
                ConstantesPaginar::TAMANO_PAG
            );
            $this->set(array(
                'ofertas' => $ofertas,
            ));
        }
    }

    /**
     * FUNCION PARA ACEPTAR UNA OFERTA Y DESECHAR EL RESTO Y ACTUALIZAR EL PRECIO DEL RESTO
     * @param $oferta_id = ID DE LA OFERTA
     */
    public function aceptar($oferta_id)
    {
        //OBTENEMOS LOS DATOS DE UNA OFERTA
        $oferta = $this->Oferta->findById($oferta_id);
        //COMBIAMOS EL VALOR DEL CAMPO DE ACEPTADO A VERDADERO
        $oferta['Oferta']['aceptado'] = ConstantesBool::VERDADERO;
        //OBTENEMOS EL ID DE LA SOLICITUD MEDIANTE EL ID INCLUIDO EN LA OFERTA
        $solicitud_id = $oferta['Oferta']['solicitud'];
        //OBTENEMOS LOS DATOS DE LA SOLICITUD
        $solicitud = $this->Solicitud->findById($solicitud_id);
        //CAMBIAMOS EL CAMPO DE LA SOLICITUD A ACEPTADO
        $solicitud['Solicitud']['aceptado'] = ConstantesBool::VERDADERO;
        //CAMBIAMOS EL PRECIO DE LA SOLICITUD POR EL PRESUPUESTADO POR LA EMPRESA
        $solicitud['Solicitud']['precio'] = $oferta['Oferta']['presupuesto'];
        //GUARDAMOS LOS CAMBIOS
        $this->Oferta->aceptarOferta($oferta);
        $this->Solicitud->aceptarOferta($solicitud);
        //ESCRIBIMOS LA URL PARA PODER REDIRECCIONARLA DESDE JAVASCRIPT
        echo Router::url(array('controller' => 'solicitudes', 'action' => 'detalles', $solicitud_id));
        //NO RENDERIZAMOS NI LAYOUT NI VISTA
        $this->layout = false;
        $this->autoRender = false;
    }

    /**
     * FUNCION PARA DESECHAR UNA OFERTA
     * @param $oferta_id = ID DE LA OFERTA
     */
    public function cancelar($oferta_id)
    {
        //OBTENEMOS LOS DATOS DE LA OFERTA
        $oferta = $this->Oferta->findById($oferta_id);
        //OBTENEMOS EL ID DE LA SOLICITUD, PARA PODER REDIRECCIONAR
        $solicitud_id = $oferta['Oferta']['solicitud'];
        //ELIMINAMOS LA OFERTA
        $this->Oferta->delete($oferta_id);
        //ESCRIBIMOS LA URL PARA PODER REDIRECCIONARLA DESDE JAVASCRIPT
        echo Router::url(array('controller' => 'ofertas', 'action' => 'ofertassolicitud', $solicitud_id));
        //NO RENDERIZAMOS NI LAYOUT NI VISTA
        $this->layout = false;
        $this->autoRender = false;
    }


    /**
     * FUNCION PARA VER LAS OFERTAS DE UNA EMPRESA Y CLASIFICARLAS SEGUN SEAN ACTIVAS O PENDIENTES
     * LA CLASIFICACION SE REALIZA MEDIANTE JQUERY
     */
    public function ver()
    {
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::EMPRESA) {
            //OBTNEMOS EL ID DEL USUARIO LOGUEADO
            $user = $this->Session->read('Auth.User.Usuario.id');
            //OBTNEMOS EL EMAIL DEL USUARIO LOGUEADO
            $mail = $this->Usuario->obtenermail($user);
            $empresa = $this->Empresa->obtenerdatosempresabymail($mail);
            $ofertas = $this->Oferta->obtenerOfertasEmpresa($empresa['Empresa']['id']);
            $images = $this->Image->findByUsuario($this->Session->read('Auth.User.Usuario.id'));
            $this->set(array(
                'ofertas' => $ofertas,
                'empresa' => $empresa,
                'image' => $images
            ));
        }

    }

    /**
     * FUNCION PARA CREAR UNA NUEVA OFERTA DE UNA SOLICITUD
     * @param $solicitud_id - ID DE LA SOLICITUD
     */
    public function nueva($solicitud_id)
    {
        if ($this->request->is('post')) {
            //OBTNEMOS EL ID DEL USUARIO LOGUEADO
            $user = $this->Session->read('Auth.User.Usuario.id');
            //OBTNEMOS EL EMAIL DEL USUARIO LOGUEADO
            $mail = $this->Usuario->obtenermail($user);
            $empresa = $this->Empresa->obtenerdatosempresabymail($mail);
            //PREPARAMOS LOS DATOS
            $oferta['Oferta']['solicitud'] = $this->request->data('solicitud');
            $oferta['Oferta']['presupuesto'] = $this->request->data('presupuesto');
            //nl2br: nos permite transformar los intros pra poder mostrarlo correctamente
            $oferta['Oferta']['prestacion'] = nl2br($this->request->data('prestacion'));
            $oferta['Oferta']['empresa'] = $empresa['Empresa']['id'];
            $oferta['Oferta']['aceptado'] = ConstantesBool::FALSO;
            if ($this->Oferta->save($oferta)) {
                //MOSTRAMOS MENSAJE CORRECTO
                $this->Flash->success(ConstantesMensaje::OFERTA_BIEN);
            } else {
                //MOSTRAMOS MENSAJE DE ERROR
                $this->Flash->error(ConstantesMensaje::OFERTA_MAL);
            }
            //REDIRECCIONAMOS A LA PAGINA INICIAL DE LA EMPRESA
            $this->redirect(array(
                'controller' => 'empresas', 'action' => 'index'
            ));


        }
        //OBTENEMOS LOS DATOS DE LA SOLICITUD
        $solicitud = $this->Solicitud->findById($solicitud_id);
        $this->set(array(
                'solicitud' => $solicitud,
            )
        );
    }
}