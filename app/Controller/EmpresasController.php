<?php

Class EmpresasController extends AppController
{
    /**
     * MODELOS A UTILIZAR
     */
    public $uses = array(
        'Empresa',
        'Tipo',
        'Usuario',
        'Image',
        'Solicitud',
        'Oferta'
    );


    /**
     * PAGINAS QUE NO SERA NECESARIO ESTAR LOGUEADO
     */
    public function beforeFilter()
    {
        $this->Auth->allow(array(
            'registro',
            'listado',
        ));
        parent::beforeFilter();
    }

    /**
     * FUNCION POR DEFECTO DE INICIO, LA CUAL NOS MOSTRARA:
     * VERSION MOVIL -> SOLICITUDES
     * VERSION PC -> SOLICITUDES Y DATOS DE PERFIL
     */
    public function index()
    {

        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::EMPRESA) {
            //OBTNEMOS EL ID DEL USUARIO LOGUEADO
            $user = $this->Session->read('Auth.User.Usuario.id');
            //OBTNEMOS EL EMAIL DEL USUARIO LOGUEADO
            $mail = $this->Usuario->obtenermail($user);
            //OBTENER DATOS DEL CLIENTE
            $empresa = $this->Empresa->findByEmail($mail);
//        //OBTNER LAS SOLICITUDES DEL CLIENTE
            $solicitudes_all = $this->Solicitud->obtenerSolicitudesPorEmpresa($empresa['Empresa']['tipo']);
            $solicitudes_ofertas = $this->Oferta->findAllByEmpresa(($empresa['Empresa']['id']));
            $solicitudes = $this->Solicitud->limpiarregistros($solicitudes_all, $solicitudes_ofertas);
            $images = $this->Image->findByUsuario($this->Session->read('Auth.User.Usuario.id'));
            //MANDAR LOS DATOS A LA VISTA
            $this->set(array(
                'solicitudes' => $solicitudes,
                'empresa' => $empresa,
                'image' => $images
            ));
        } else {
            $this->render('Errors/missing_view');
        }
    }


    /**
     * FUNCION PARA REGISTRAR LOS DATOS DE UNA EMPRESA
     */
    public function registro()
    {
        //COMPROBAMOS SI LOS DATOS SON MANDADOS POR POST
        if ($this->request->is('post')) {
            $captcha = $this->request->data('g-recaptcha-response');
            if (!empty($captcha)) {
                //ARRAY DE USUARIO
                $usuario = array();
                //ARRAY DE EMPRESA
                $empresa = array();
                //OBTENEMOS LOS DATOS DEL USUARIO
                $verificacion = str_replace(' ', '', $this->request->data['password']);
                $password = str_replace(' ', '', $this->request->data['password']);
                $this->request->data['verificacion'] = $verificacion;
                $this->request->data['password'] = $password;
                $usuario['email'] = $this->request->data['email'];
                $usuario['password'] = $this->request->data['password'];
                $usuario['rol'] = ConstantesRoles::CLIENTE;
                $usuario['verificacion'] = $this->request->data['password'];
                //OBTENEMOS LOS DATOS DE LA EMPRESA
                foreach ($this->request->data as $key => $value) {
                    if ($key != 'password') {
                        $empresa[$key] = $value;
                    }
                }
                //CONTRUIMOS LA DIRECCION DE LA EMPRESA
                $address = $empresa['direccion'] . "," . $empresa['numero'] . "," . $empresa['ciudad'] . "," . $empresa['provincia'];
                //OBTENEMOS LOS DATOS DE LATITUD Y LONGITUD
                $coords = $this->obtener_coordenadas($address);
                //COLOCAMOS LOS DATOS DE LAS COORDENADAS
                $empresa['latitud'] = $coords[0];
                $empresa['longitud'] = $coords[1];
                //GUARDAMOS LOS DOS REGISTROS
                if ($this->Usuario->nuevo($usuario) && $this->Empresa->nuevo($empresa)) {
                    $mensaje = "BIenvenido a nuestra plataforma, tus datos de sesion son:";
                    $mensaje .= "\n\t Email: '" . $this->request->data('email')."'";
                    $mensaje .= "\n\t Contraseña: '" .  $this->request->data('password')."'";;
                    $mensaje .= "\nAtentamente getmarried.ml";
                    $email = new CakeEmail('gmail');
                    //$email = new CakeEmail('default');
                    //$email->from('info@getmarried.ml');
                    $email->to($this->request->data('email'));
                    $email->subject('Registro');
                    $email->send($mensaje);
                    //MOSTRAMOS MENSAJE DE REGISTRO
                    $this->Flash->success(ConstantesMensaje::REGISTRO_BIEN);
                    //REDIRECCIONAMOS AL LOGIN
                    $this->redirect(array(
                        'controller' => 'usuarios',
                        'action' => 'login'
                    ));
                } else {
                    $this->Flash->error(ConstantesMensaje::REGISTRO_MAL);
                }
            }
        }
        //SI NO TENEMOS DATOS POR POST ES PORQUE ESTAMOS INTENTANDO VISUALIZAR EL FORMULARIO DE REGISTRO
        //LE MANDAMOS LAS OPCIONES DEL TIPO DE EMPRESA
        $options = $this->Tipo->find('list');
        $this->set(array(
            'options' => $options,
        ));

    }

    /**
     * FUNCION PARA EDITAR LOS DATOS DE LA EMPRESA
     * @param - EMPRESA
     */
    public function editar($empresa_id)
    {
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::EMPRESA or $this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::ADMIN) {
            if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::EMPRESA) {
                //OBTNEMOS EL ID DEL USUARIO LOGUEADO
                $user = $this->Session->read('Auth.User.Usuario.id');
                //OBTNEMOS EL EMAIL DEL USUARIO LOGUEADO
                $mail = $this->Usuario->obtenermail($user);
                //OBTENEMOS LOS DATOS DEL CLIENTE MEDIANTE EL CORREO
                $datos = $this->Empresa->obtenerdatosempresabymail($mail);
                $empresa_id = $datos['Empresa']['id'];
            }
            //OBTENEMOS LOS DATOS DE LA EMPRESA
            $empresa = $this->Empresa->findById($empresa_id);
            if (!$empresa) {
                throw new NotFoundException();
            }
            //SI LOS DATOS PROCEDEN DE GET ES PARA VISUALIZAR EL FRMULARIO
            if ($this->request->is('get')) {
                //COLOCAMOS LOS DATOS PARA PODER VISUALIZARLOS
                $this->request->data = $empresa;
                //OPTENEMOS LOS TIPOS DE EMPRESA PARA MOSTRARLOS
                $options = $this->Tipo->find('list');
                $this->set(array(
                    'options' => $options,
                ));
            } //SI PROCEDEN POR POST
            else {
                //COMPRUEBO SI SE HA CAMBIADO ALGUN DATO DE LA DIRECCION
                if ($empresa['Empresa']['direccion'] != $this->request->data['direccion'] ||
                    $empresa['Empresa']['numero'] != $this->request->data['numero'] ||
                    $empresa['Empresa']['piso'] != $this->request->data['piso'] ||
                    $empresa['Empresa']['provincia'] != $this->request->data['provincia'] ||
                    $empresa['Empresa']['ciudad'] != $this->request->data['ciudad']
                ) {
                    $address = $this->request->data['direccion'] . "," . $this->request->data['numero'] . "," . $this->request->data['ciudad'] . "," . $this->request->data['provincia'];
                    $coords = $this->obtener_coordenadas($address);
                    $this->request->data['latitud'] = $coords[0];
                    $this->request->data['longitud'] = $coords[1];
                } //SINO COLOCAREMOS LOS DATOS DE LA EMPRESA PARA QUE NO SE MODIFIQUEN
                else {
                    $this->request->data['latitud'] = $empresa['Empresa']['latitud'];
                    $this->request->data['longitud'] = $empresa['Empresa']['longitud'];
                }
                $this->request->data['descripcion'] = nl2br($this->request->data['descripcion']);
                //EDITAMOS EL REGISTRO
                if ($this->Empresa->edit($this->request->data)) {
                    //MOSTRAMOS EL MENSAJE
                    $this->Flash->success(ConstantesMensaje::EDITAR_BIEN);
                    //REDIRECCIONAMOS A SU PAGINA PRICIPAL
                    if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::EMPRESA) {
                        $this->redirect(array(
                            'action' => 'index'
                        ));
                    } else {
                        $this->redirect(array(
                            'action' => 'detalles',
                            $this->request->data['id']
                        ));
                    }

                } else {
                    $this->Flash->error(ConstantesMensaje::EDITAR_MAL);
                }
            }
        } else {
            $this->render('Errors/missing_view');
        }

    }

    /**
     * FUNCION PARA VISUALIZAR MIS DATOS
     */
    public function misdatos()
    {
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::EMPRESA){
            //OBTNEMOS EL ID DEL USUARIO LOGUEADO
            $user = $this->Session->read('Auth.User.Usuario.id');
            //OBTNEMOS EL EMAIL DEL USUARIO LOGUEADO
            $mail = $this->Usuario->obtenermail($user);
            //OBTENEMOS LOS DATOS DE LA EMPRESA MEDIANTE SU MAIL
            $datos = $this->Empresa->obtenerdatosempresabymail($mail);
            $images = $this->Image->findByUsuario($this->Session->read('Auth.User.Usuario.id'));
            //MANDAMOS LOS DATOS A LA VISTA
            $this->set(array(
                'datos' => $datos,
                'image' => $images
            ));
        }

    }

    /**
     * FUNCION PARA VISUALIZAR LOS DATOS DE UNA EMPRESA
     */
    public function detalles($empresa_id)
    {

        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE or $this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::ADMIN) {
            $datos = $this->Empresa->obtenerdatosempresabyId($empresa_id);
            if (!empty($datos)) {
                $user = $this->Usuario->findByEmail( $datos['Empresa']['email']);
                $images = $this->Image->findByUsuario($user['Usuario']['id']);
                //MANDAMOS LOS DATOS A LA VISTA
                $this->set(array(
                    'datos' => $datos,
                    'image' => $images
                ));
            } else {
                $this->render('Errors/missing_view');
            }
        } else {
            $this->render('Errors/missing_view');
        }


    }

    /**
     * FUNCION PARA VER UN LISTADO DE LAS EMPRESAS SEGUN SU TIPO
     */
    public function listado($tipo_id)
    {
        //MANDAMOS LOS DATOS DE LA EMPRESA CON LA CONDICION DEL TIPO DE ID
        $empresas = $this->paginar(
            $this->Empresa->consulta('listado'),
            $this->Empresa->condicion_tipo($tipo_id),
            ConstantesPaginar::TAMANO_PAG
        );
        if (!empty($empresas)) {
            //OBTENEMOS EL TIPO DE EMPRESA PARA MOSTRAR EL TITULO
            $tipo = $this->Tipo->findById($tipo_id);
            //MANDAMOS LOS DATOS A LA VISTA
            $this->set(array(
                'tipo' => $tipo,
                'empresas' => $empresas
            ));
        } else {
            $this->render('Errors/missing_view');
        }

    }

    /**
     * FUNCION PHP PARA OBTENER LAS COORDENADAS MEDIANTE UNA DIRECCION
     * @PARAMS - DIRECCION
     */
    private function obtener_coordenadas($address)
    {
        //DECODIFICAMOS DE LA URL LA DIRECCION
        $address = urlencode($address);
        //CONCATENO LA DIRECCION DE GOOGLE MAPS CONCATENANDO LA DIRECCION
        $url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyAlooq0GVC8KyzH3fuFISBiF8yGOhyepMk&address=" . $address;
        //OBTENEMOS LA RESUESTA LEYENDO LOS DATOS DEL ARCHIVO DE LA URL
        $response = file_get_contents($url);
        //LOS CODIFICAMOS A UN JSON
        $json = json_decode($response, true);
        //COMPROBAMOS EL ESTADO PARA SABER SI HEMOS OBTENIDO RESULTADOS
        if ($json['status'] == 'ZERO_RESULTS') {
            return false;
        } //SI HEMOS OBTENIDO LOS DATOS
        else {
            //OBTENEMOS LOS DATOS DE LAS COORDENADAS Y DEVOLCEMOS UN ARRAY DE DOS POSICIONES
            $lat = $json['results'][0]['geometry']['location']['lat'];
            $lng = $json['results'][0]['geometry']['location']['lng'];
            return array($lat, $lng);
        }

    }

    /**
     * FUNCION PARA CREAR EL LISTADO DE EMPRESAS PAGINADO
     */
    public function lista()
    {
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE or $this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::ADMIN) {
            $buscador = $this->request->query;
            $this->request->data['Buscador'] = $buscador;
            $empresas = $this->paginar(
                $this->Empresa->consulta('search'),
                $this->Empresa->condiciones($buscador),
                ConstantesPaginar::TAMANO_PAG
            );
            $options = $this->Tipo->find('list');
            $this->set(array(
                'empresas' => $empresas,
                'options' => $options
            ));
        } else {
            $this->render('Errors/missing_view');
        }
    }


    /**
     * FUNCION PARA EXPORTAR LOS DATOS A EXCEL
     */
    public function export_excel()
    {
        $empresas = array();
        $empresas['Animaciones'] = $this->Empresa->obtenertodo(ConstantesTipos::Animaciones);
        $empresas['Floristeria'] = $this->Empresa->obtenertodo(ConstantesTipos::Floristeria);
        $empresas['Fotografos'] = $this->Empresa->obtenertodo(ConstantesTipos::Fotografos);
        $empresas['Viajes'] = $this->Empresa->obtenertodo(ConstantesTipos::Viajes);
        $empresas['Vestuario'] = $this->Empresa->obtenertodo(ConstantesTipos::Vestuario);
        $empresas['Vehiculos'] = $this->Empresa->obtenertodo(ConstantesTipos::Vehiculos);
        $empresas['Ubicacion'] = $this->Empresa->obtenertodo(ConstantesTipos::Ubicacion);
        $empresas['Transporte'] = $this->Empresa->obtenertodo(ConstantesTipos::Transporte);
        $empresas['Recordatorios'] = $this->Empresa->obtenertodo(ConstantesTipos::Recordatorios);
        $empresas['Peluquería'] = $this->Empresa->obtenertodo(ConstantesTipos::Peluquería);
        $empresas['Joyeria'] = $this->Empresa->obtenertodo(ConstantesTipos::Joyeria);
        $empresas['Hosteleria'] = $this->Empresa->obtenertodo(ConstantesTipos::Hosteleria);
        $this->set(
            array(
                'empresas' => $empresas,
            )
        );
        set_time_limit(18000);
        ini_set('memory_limit', '-1');

        $this->render('/Empresas/export_excel');
        $this->response->type('xls');
        $this->layout = false;
    }

}