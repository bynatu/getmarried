<?php

Class ClientesController extends AppController{

    /**
     * MODELOS PARA USAR
     */
    public $uses = array(
      'Cliente',
      'Usuario',
      'Solicitud'
    );

    /**
     * PARTES DE ACCESO SIN NEESIDAD DE ESTAR LOGUEADO
     */
    public function beforeFilter(){
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
    public function index(){
        //OBTENER DATOS DEL USUARIO LOGUEADO
        $mail = $this->Session->read('Auth.User.Usuario.email');
        //OBTENER DATOS DEL CLIENTE
        $cliente = $this->Cliente->findByEmail($mail);
        //OBTNER LAS SOLICITUDES DEL CLIENTE
        $solicitudes = $this->Solicitud->obtenerSolicitudesPorCliente($cliente['Cliente']['id']);
        //MANDAR LOS DATOS A LA VISTA
        $this->set(array(
            'solicitudes' => $solicitudes, 
            'cliente' => $cliente
        ));
    }

    /**
     * FUNCION PARA REGISTAR UN NUEVO USUARIO
     */
    public function registro() {
        //COMPROBAMOS SI LA FUNCION ES LLAMADO POR GET O POST
        //SI ES POR POST
        if ($this->request->is('post')) {
            //DEFINIMOS UN ARRAY PARA DAR DE ALTA EL USUARIO
            $usuario = array();
            //DEFINIMOS UN ARRAY PARA DAR DE ALTA EL CLIENTE
            $cliente = array();
            //OBTENEMOS LOS DATOS DEL USUARIO
            $usuario['email'] = $this->request->data['email'];
            $usuario['password'] = $this->request->data['password'];
            $usuario['rol'] = ConstantesRoles::CLIENTE;
            //OBTNEMOS LOS DATOS DEL CLIENTE
            foreach ($this->request->data as $key => $value) {
                if ($key != 'password') {
                    $cliente[$key] = $value;
                }
            }
            //DAMOS DE ALTA AMBOS REGISTROS
            if ($this->Usuario->nuevo($usuario) && $this->Cliente->nuevo($cliente)) {
                //MOSTRAMOS MENSAJE
                $this->Flash->success(ConstantesMensaje::REGISTRO_BIEN);
                //REDIRECCIOAMOS A LA PAGINA DE LOGIN
                $this->redirect(array(
                    'controller' => 'usuarios',
                    'action' => 'login'
                ));
            } else {
                $this->Flash->error( ConstantesMensaje::REGISTRO_MAL);
            }
        }
    }

    /**
     * FUNCION PARA OBENER LOS DATOS DE UN USUARIO
     */
    public function misdatos(){
        //OBTNEEMOS EL EMAIL DEL USUARIO LOGUEADO
        $user = $this->Session->read('Auth.User.Usuario.email');
        //OBTENEMOS LOS DATOS DEL CLIENTE MEDIANTE EL CORREO
        $datos = $this->Cliente->obtenerdatosclientebymail($user);
        //PASAMOS LOS DATOS DEL USUARIO A LA VISTA
        $this->set(array(
            'datos' => $datos
        ));
    }

    /**
     * FUNCION PARA EDITAR LOS DATOS DE UN CLIENTE
     * @PARAMS - ID DEL CLIENTE A EDITAR 
     */
    public function editar($cliente_id){
        //OBTENEMOS LOS DATOS DEL CLIENTE MEDIANTE SU ID
        $cliente = $this->Cliente->findById($cliente_id);
        if (!$cliente) {
            throw new NotFoundException();
        }
        //COMPROBAMOS SI LA PETICION SE REALIZO POR GET O POST
        //SI ES GET - COLOCAMOS EL REQUEST DATA LOS DATOS DEL CLIENTE
        if ($this->request->is('get')) {
            $this->request->data = $cliente;
        } 
        //MANDAMOS LOS DATOS DEL CLIENTE A EDITAR
        else {
            //MANDAMOS LOS DATOS RECIBIDOS DEL FORMULARIO
            if ($this->Cliente->edit($this->request->data)) {
                //MOSTRAMOS MENSAJE
                $this->Flash->success(ConstantesMensaje::EDITAR_BIEN);
                //REDIRECIONAMOS A LA PAGINA PRINCIPAL DEL CLIENTE
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Flash->error( ConstantesMensaje::EDITAR_MAL);
            }
        }

    }

}