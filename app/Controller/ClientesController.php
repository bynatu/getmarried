<?php

Class ClientesController extends AppController
{

    /**
     * MODELOS QUE VAMOS A UTILIZAR
     */
    public $uses = array(
        'Cliente',
        'Usuario',
        'Image',
        'Solicitud'
    );

    /**
     * PARTES DE ACCESO SIN NECESIDAD DE ESTAR LOGUEADO
     */
    public function beforeFilter()
    {
        $this->Auth->allow(array(
            'registro',
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
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE) {
            //OBTNEMOS EL ID DEL USUARIO LOGUEADO
            $user = $this->Session->read('Auth.User.Usuario.id');
            //OBTNEMOS EL EMAIL DEL USUARIO LOGUEADO
            $mail = $this->Usuario->obtenermail($user);
            //OBTENER DATOS DEL CLIENTE
            $cliente = $this->Cliente->findByEmail($mail);
            //OBTNER LAS SOLICITUDES DEL CLIENTE
            $solicitudes = $this->Solicitud->obtenerSolicitudesPorCliente($cliente['Cliente']['id']);
            $images = $this->Image->findByUsuario($this->Session->read('Auth.User.Usuario.id'));
            //MANDAR LOS DATOS A LA VISTA
            $this->set(array(
                'solicitudes' => $solicitudes,
                'cliente' => $cliente,
                'image' => $images
            ));
        } else {
            $this->render('Errors/missing_view');
        }

    }

    /**
     * FUNCION PARA REGISTAR UN NUEVO USUARIO
     */
    public function registro()
    {
        //COMPROBAMOS SI LA FUNCION ES LLAMADO POR GET O POST
        //SI ES POR POST
        if ($this->request->is('post')) {
            $captcha = $this->request->data('g-recaptcha-response');
            if (!empty($captcha)) {
                //DEFINIMOS UN ARRAY PARA DAR DE ALTA EL USUARIO
                $usuario = array();
                //DEFINIMOS UN ARRAY PARA DAR DE ALTA EL CLIENTE
                $cliente = array();
                //OBTENEMOS LOS DATOS DEL USUARIO
                $verificacion = str_replace(' ', '', $this->request->data['password']);
                $password = str_replace(' ', '', $this->request->data['password']);
                $this->request->data['verificacion'] = $verificacion;
                $this->request->data['password'] = $password;
                $usuario['email'] = $this->request->data['email'];
                $usuario['password'] = $this->request->data['password'];
                $usuario['rol'] = ConstantesRoles::CLIENTE;
                $usuario['verificacion'] = $this->request->data['password'];
                //OBTNEMOS LOS DATOS DEL CLIENTE
                foreach ($this->request->data as $key => $value) {
                    if ($key != 'password') {
                        $cliente[$key] = $value;
                    }
                }
                //DAMOS DE ALTA AMBOS REGISTROS
                if ($this->Usuario->nuevo($usuario) && $this->Cliente->nuevo($cliente)) {
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
                    //MOSTRAMOS MENSAJE
                    $this->Flash->success(ConstantesMensaje::REGISTRO_BIEN);
                    //REDIRECCIOAMOS A LA PAGINA DE LOGIN
                    $this->redirect(array(
                        'controller' => 'usuarios',
                        'action' => 'login'
                    ));
                } else {
                    $this->Flash->error(ConstantesMensaje::REGISTRO_MAL);
                }
            }
        }
    }

    /**
     * FUNCION PARA OBENER LOS DATOS DE UN USUARIO
     */
    public function misdatos()
    {
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE) {
//OBTNEMOS EL ID DEL USUARIO LOGUEADO
            $user = $this->Session->read('Auth.User.Usuario.id');
//OBTNEMOS EL EMAIL DEL USUARIO LOGUEADO
            $mail = $this->Usuario->obtenermail($user);
//OBTENEMOS LOS DATOS DEL CLIENTE MEDIANTE EL CORREO
            $datos = $this->Cliente->obtenerdatosclientebymail($mail);
            $datos['Cliente']['f_nacimiento'] = Fecha::toFormatoVista($datos['Cliente']['f_nacimiento']);
            $images = $this->Image->findByUsuario($this->Session->read('Auth.User.Usuario.id'));
//PASAMOS LOS DATOS DEL USUARIO A LA VISTA
            $this->set(array(
                'datos' => $datos,
                'image' => $images
            ));
        } else {
            $this->render('Errors/missing_view');
        }
    }

    /**
     * FUNCION PARA EDITAR LOS DATOS DE UN CLIENTE
     * @param - ID DEL CLIENTE A EDITAR
     */
    public function editar($cliente_id)
    {
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE or $this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::ADMIN) {
            if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE) {
//OBTNEMOS EL ID DEL USUARIO LOGUEADO
                $user = $this->Session->read('Auth.User.Usuario.id');
//OBTNEMOS EL EMAIL DEL USUARIO LOGUEADO
                $mail = $this->Usuario->obtenermail($user);
//OBTENEMOS LOS DATOS DEL CLIENTE MEDIANTE EL CORREO
                $datos = $this->Cliente->obtenerdatosclientebymail($mail);
                $cliente_id = $datos['Cliente']['id'];
            }
//OBTENEMOS LOS DATOS DEL CLIENTE MEDIANTE SU ID
            $cliente = $this->Cliente->findById($cliente_id);
            if (!$cliente) {
                throw new NotFoundException();
            }
//COMPROBAMOS SI LA PETICION SE REALIZO POR GET O POST
//SI ES GET - COLOCAMOS EL REQUEST DATA LOS DATOS DEL CLIENTE
            if ($this->request->is('get')) {
                $cliente['Cliente']['f_nacimiento'] = Fecha::toFormatoVista($cliente['Cliente']['f_nacimiento']);
                $this->request->data = $cliente;
            } //MANDAMOS LOS DATOS DEL CLIENTE A EDITAR
            else {
//MANDAMOS LOS DATOS RECIBIDOS DEL FORMULARIO
                if ($this->Cliente->edit($this->request->data)) {
//MOSTRAMOS MENSAJE
                    $this->Flash->success(ConstantesMensaje::EDITAR_BIEN);
                    if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE) {
//REDIRECIONAMOS A LA PAGINA PRINCIPAL DEL CLIENTE
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
     * FUNCION PARA LISTAR LOS CLIENTES
     */
    public function lista()
    {
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::ADMIN) {
            $buscador = $this->request->query;
            $this->request->data['Buscador'] = $buscador;
            $clientes = $this->paginar(
                $this->Cliente->consulta('search'),
                $this->Cliente->condiciones($buscador),
                ConstantesPaginar::TAMANO_PAG
            );
            $this->set(array(
                'clientes' => $clientes,
            ));
        } else {
            $this->render('Errors/missing_view');
        }
    }


    /**
     * FUNCION PARA OBENER LOS DATOS DE UN USUARIO
     */
    public function detalles($cliemte)
    {
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::ADMIN) {
            //OBTENEMOS LOS DATOS DEL CLIENTE MEDIANTE EL ID
            $datos = $this->Cliente->obtenerdatosclientebyId($cliemte);
            $datos['Cliente']['f_nacimiento'] = Fecha::toFormatoVista($datos['Cliente']['f_nacimiento']);
            if (!empty($datos)) {
                $user = $this->Usuario->findByEmail( $datos['Cliente']['email']);
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
     * FUNCION PARA EXPORTAR LOS DATOS A EXCEL
     */
    public
    function export_excel()
    {
        $clientes = $this->Cliente->obtenertodo();
        $this->set(
            array(
                'clientes' => $clientes,
            )
        );

        set_time_limit(18000);
        ini_set('memory_limit', '-1');

        $this->render('/Clientes/export_excel');
        $this->response->type('xls');
        $this->layout = false;
    }

}