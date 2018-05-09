<?php

Class SolicitudesController extends AppController
{

    /**
     * MODELOS PARA USAR
     */
    public $uses = array(
        'Solicitud',
        'Oferta',
        'Tipo',
        'Cliente',
        'Empresa',
        'Usuario'
    );


    /**
     * FUNCION PARA OBTENER LOS DATOS DE UNA SOLICITUD Y SUS OFERTAS
     * LAS OFERTAS SE OBTIENEN RENDERIZANDO OTRO CTP
     * @param - $solicitud_id = ID DE LA SOLICITUD
     */
    public function detalles($solicitud_id)
    {
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE or $this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::EMPRESA) {
            $solicitud = $this->Solicitud->obtenerSolicitudesbyID($solicitud_id);
            $solicitud['Solicitud']['fecha'] = Fecha::toFormatoVista($solicitud['Solicitud']['fecha']);
            //OBTNEMOS EL ID DEL USUARIO LOGUEADO
            $user = $this->Session->read('Auth.User.Usuario.id');
            //OBTNEMOS EL EMAIL DEL USUARIO LOGUEADO
            $mail = $this->Usuario->obtenermail($user);
            $ofertas = $this->Oferta->findAllBySolicitud($solicitud['Solicitud']['id']);
            if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE) {
                //OBTENER DATOS DEL CLIENTE
                $cliente = $this->Cliente->findByEmail($mail);
                //OBTNER LAS SOLICITUDES DEL CLIENTE
                if ($solicitud['Solicitud']['cliente'] != $cliente['Cliente']['id']) {
                    $this->render('Errors/missing_view');
                }
            } else {
                //OBTENER DATOS DEL CLIENTE
                $empresa = $this->Empresa->findByEmail($mail);
                $empresa_id = $empresa['Empresa']['id'];
                $num = $this->Oferta->findByEmpresaAndSolicitud($empresa_id, $solicitud_id);
                if (count($num) < 1) {
                    $this->render('Errors/missing_view');
                }
            }
            $this->set(array(
                'solicitud' => $solicitud,
                'numofertas' => count($ofertas),
            ));
        }
    }

    /**
     * FUNCION PARA AÑADIR UNA NUEVA SOLICITUD A UN CLIENTE
     */
    public function nueva()
    {
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE) {
            //COMPROBAMOS SI NOS VIENEN LOS DATOS MEDIANTE POST
            if ($this->request->is('post')) {
                //OBTNEMOS EL ID DEL USUARIO LOGUEADO
                $user = $this->Session->read('Auth.User.Usuario.id');
                //OBTNEMOS EL EMAIL DEL USUARIO LOGUEADO
                $mail = $this->Usuario->obtenermail($user);
                //OBTENEMOS LOS DATOS DEL CLIENTE MEDIANTE EL MAIL
                $datos = $this->Cliente->obtenerdatosclientebymail($mail);
                //CAMBIAMOS EL DATA DEL CLIENTE POR EL ID DEL CLIENTE
                $this->request->data['cliente'] = $datos['Cliente']['id'];
                //CAMBIAMOS LA FECHA DE CREACION POR LA ACTUAL
                $this->request->data['fecha_creacion'] = date('Y-m-d');
                $this->request->data['descripcion'] = nl2br($this->request->data['descripcion']);
                $this->request->data['fecha'] = Fecha::toFormatoBd($this->request->data['fecha']);
                //GUARDAMOS LOS CAMBIOS REALIZADOS, CREANDO LA SOLICITUD
                // NO ES NECESARIO CREAR UNA FUNCION EXTERNA YA QUE GUARDAMOS TODOS LOS CAMPOS
                if ($this->Solicitud->save($this->request->data)) {
                    //MOSTRAMOS MENSAJE CORRECTO
                    $this->Flash->success(ConstantesMensaje::SOLICITUD_BIEN);
                } else {
                    //MOSTRAMOS MENSAJE DE ERROR
                    $this->Flash->error(ConstantesMensaje::SOLICITUD_MAL);
                }
                //REDIRECCIONAMOS A LA PAGINA INICIAL DEL CLIENTE
                $this->redirect(array(
                    'controller' => 'clientes', 'action' => 'index'
                ));
            }
            //SI NO TENEMOS DATOS POR POST ES PORQUE ESTAMOS INTENTANDO VISUALIZAR EL FORMULARIO DE REGISTRO
            //LE MANDAMOS LAS OPCIONES DEL TIPO DE EMPRESA
            $options = $this->Tipo->find('list');
            $this->set(array(
                'options' => $options,
            ));
        } else {
            $this->render('Errors/missing_view');
        }

    }

    /**
     * FUNCION PARA OBTENER LOS DATOS DE UNA OFERTA ACEPTADA MOSTRANDOLOS EN UNA PANTALLA MODAL
     */
    public function ajax_aceptada()
    {
        //OBTENEMOS EL ID DE LA SOLICITUD MEDIANTE EL DATA PROVENIENTE DE AJAX
        $solicitud_id = $this->request->data('solicitud');
        //OBTENEMOS LOS DATOS DE LA OFERTA
        $oferta = $this->Oferta->obtenerOfertaAceptada($solicitud_id);
        //CREAMOS UN JSON DE LOS DATOS PARA LEERLOS DESDE JQUERY
        echo json_encode($oferta);
        //NO RENDERIZAMOS NI LAYOUT NI VISTA
        $this->layout = false;
        $this->autoRender = false;
    }

    /**
     * FUNCION PARA BORRAR LOS DATOS DE UNA SOLICITUD
     */
    public function ajax_borrar()
    {
        //OBTENEMOS EL ID DE LA SOLICITUD MEDIANTE EL DATA PROVENIENTE DE AJAX
        $solicitud_id = $this->request->data('solicitud');
        //OBTENEMOS LAS OFERTAS DE LA SOLICITUD
        $ofertas = $this->Oferta->obtenerofertasdesolicitud($solicitud_id);
        //SI NO TENEMOS OFERTAS
        if (count($ofertas) == 0) {
            //BORRAMOS LA SOLICITUD
            $this->Solicitud->delete($solicitud_id);
            //REDIRECCIONAMOS A LA PAGINA RINCIPAL DE LOS CLIENTES
            echo Router::url(array('controller' => 'clientes', 'action' => 'index'));
        } else {
            //SI TENEMOS OFERTAS, MANDAMOS UN FALSE PARA QUE NO PUEDA BORRAR UNA SOLICITUD CON OFERTAS
            echo 0;
        }
        //NO RENDERIZAMOS NI LAYOUT NI VISTA
        $this->layout = false;
        $this->autoRender = false;
    }

    /**
     * FUNCION PARA EDITAR LOS DATOS DE UNA SOLICITUD
     */
    public function ajax_editar()
    {
        //OBTENEMOS EL ID DE LA SOLICITUD MEDIANTE EL DATA PROVENIENTE DE AJAX
        $solicitud_id = $this->request->data('solicitud');
        //OBTENEMOS LAS OFERTAS DE LA SOLICITUD
        $ofertas = $this->Oferta->obtenerofertasdesolicitud($solicitud_id);
        //SI NO TENEMOS OFERTAS
        if (count($ofertas) == 0) {
            //REDIRECCIONAMOS A LA PAGINA PARA EDITAR LA SOLICITUD
            echo Router::url(array('controller' => 'solicitudes', 'action' => 'editar', $solicitud_id));
        } else {
            //SI TENEMOS OFERTAS, MANDAMOS UN FALSE PARA QUE NO PUEDA EDITAR UNA SOLICITUD CON OFERTAS
            echo 0;
        }
        //NO RENDERIZAMOS NI LAYOUT NI VISTA
        $this->layout = false;
        $this->autoRender = false;
    }


    /**
     * FUNCION PARA EDITAR LOS DATOS DE UNA SOLICITUD
     * @param - ID DEL CLIENTE A EDITAR
     */
    public function editar($solicitud_id)
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
            if (!$solicitud) {
                throw new NotFoundException();
            }
            //COMPROBAMOS SI LA PETICION SE REALIZO POR GET O POST
            //SI ES GET - COLOCAMOS EL REQUEST DATA LOS DATOS DE LA SOLICITUD
            if ($this->request->is('get')) {
                $solicitud['Solicitud']['fecha'] = Fecha::toFormatoVista($solicitud['Solicitud']['fecha']);
                $this->request->data = $solicitud;
            } //MANDAMOS LOS DATOS DE LA SOLICITUD A EDITAR
            else {
                //MANDAMOS LOS DATOS RECIBIDOS DEL FORMULARIO PARA GUARDAR,
                // NO ES NECESARIO CREAR UNA FUNCION EXTERNA YA QUE GUARDAMOS TODOS LOS CAMPOS
                $this->request->data['descripcion'] = nl2br($this->request->data['descripcion']);
                $this->request->data['fecha'] = Fecha::toFormatoBd($this->request->data['fecha']);
                if ($this->Solicitud->save($this->request->data)) {
                    //MOSTRAMOS MENSAJE
                    $this->Flash->success(ConstantesMensaje::EDITAR_BIEN);
                    //REDIRECIONAMOS A LA PAGINA PRINCIPAL DE LA SOLICITUD
                    $this->redirect(array(
                        'controller' => 'solicitudes', 'action' => 'detalles', $solicitud_id
                    ));
                } else {
                    $this->Flash->error(ConstantesMensaje::EDITAR_MAL);
                }
            }
            //SI NO TENEMOS DATOS POR POST ES PORQUE ESTAMOS INTENTANDO VISUALIZAR EL FORMULARIO DE REGISTRO
            //LE MANDAMOS LAS OPCIONES DEL TIPO DE EMPRESA
            $options = $this->Tipo->find('list');
            $this->set(array(
                'options' => $options,
                'solicitud' => $solicitud_id
            ));
        } else {
            $this->render('Errors/missing_view');
        }

    }


}