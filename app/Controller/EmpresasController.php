<?php

Class EmpresasController extends AppController{
    /**
     * MODELOS A UTILIZAR
     */
    public $uses = array(
        'Empresa',
        'Tipo',
        'Usuario',
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
     * FUNCION INDEX POR DEFECTO DE LA EMPRESA
     */
    public function index(){
    }

    /**
     * FUNCION PARA REGISTRAR LOS DATOS DE UNA EMPRESA
     */
    public function registro(){
        //COMPROBAMOS SI LOS DATOS SON MANDADOS POR POST
        if ($this->request->is('post')) {
            //ARRAY DE USUARIO
            $usuario = array();
            //ARRAY DE EMPRESA
            $empresa = array();
            //OBTENEMOS LOS DATOS DEL USUARIO
            $usuario['email'] = $this->request->data['email'];
            $usuario['password'] = $this->request->data['password'];
            $usuario['rol'] = 2;
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
                //MOSTRAMOS MENSAJE DE REGISTRO
                $this->Flash->success('SE HA REGISTRADO EXISTOSAMENTE');
                //REDIRECCIONAMOS AL LOGIN
                $this->redirect(array(
                    'controller' => 'usuarios',
                    'action' => 'login'
                ));
            } else {
                $this->Flash->error('SE HA PRODUCIDO UN ERROR, INTENTELO DE NUEVO');
            }
        }
        //SI NO TENEMOS DATOS POR POST ES PORQUE ESTAMOS INTENTANDO VISUALIZAR EL FORMULARIO DE REGISTRO
        //LE MANDAMOS LAS OPCIONES DEL TIPO DE EMPRESA
        $options = $this->Tipo->selecttipos();
        $this->set(array(
            'options' => $options,
        ));

    }

    /**
     * FUNCION PARA EDITAR LOS DATOS DE LA EMPRESA
     * @PARAMS - EMPRESA
     */
    public function editar($empresa_id){
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
            $options = $this->Tipo->selecttipos();
            $this->set(array(
                'options' => $options,
            ));
        } 
        //SI PROCEDEN POR POST
        else {
            //COMPRUEBO SI SE HA CAMBIADO ALGUN DATO DE LA DIRECCION 
            if ($empresa['Empresa']['direccion'] != $this->request->data['direccion'] ||
                $empresa['Empresa']['numero'] != $this->request->data['numero'] ||
                $empresa['Empresa']['piso'] != $this->request->data['piso'] ||
                $empresa['Empresa']['provincia'] != $this->request->data['provincia'] ||
                $empresa['Empresa']['ciudad'] != $this->request->data['ciudad']) {
                $address = $this->request->data['direccion'] . "," . $this->request->data['numero'] . "," . $this->request->data['ciudad'] . "," . $this->request->data['provincia'];
                $coords = $this->obtener_coordenadas($address);
                $this->request->data['latitud'] = $coords[0];
                $this->request->data['longitud'] = $coords[1];
            }
            //SINO COLOCAREMOS LOS DATOS DE LA EMPRESA PARA QUE NO SE MODIFIQUEN 
            else {
                $this->request->data['latitud'] = $empresa['Empresa']['latitud'];
                $this->request->data['longitud'] = $empresa['Empresa']['longitud'];
            }
            //EDITAMOS EL REGISTRO
            if ($this->Empresa->edit($this->request->data)) {
                //MOSTRAMOS EL MENSAJE
                $this->Flash->success('SUS DATOS HAN SIDO ACTUALIZADOS');
                //REDIRECCIONAMOS A SU PAGINA PRICIPAL
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Flash->error('ERROR AL EDITAR LOS DATOS');
            }
        }

    }
    /**
     * FUNCION PARA VISUALIZAR MIS DATOS
     */
    public function misdatos(){
        //OBTENEMOS EL EMAIL DE LA EMPRESA LOGUEADA
        $user = $this->Session->read('Auth.User.Usuario.email');
        //OBTENEMOS LOS DATOS DE LA EMPRESA MEDIANTE SU MAIL
        $datos = $this->Empresa->obtenerdatosempresabymail($user);
        //MANDAMOS LOS DATOS A LA VISTA
        $this->set(array(
            'datos' => $datos
        ));
    }

    /**
     * FUNCION PARA VER UN LISTADO DE LAS EMPRESAS SEGUN SU TIPO
     */
    function listado($tipo_id){
        //MANDAMOS LOS DATOS DE LA EMPRESA CON LA CONDICION DEL TIPO DE ID
        $empresas = $this->paginar(
            $this->Empresa->consulta('listado'),
            $this->Empresa->condicion_tipo($tipo_id),
            7
        );

        //OBTENEMOS EL TIPO DE EMPRESA PARA MOSTRAR EL TITULO
        $tipo = $this->Tipo->findById($tipo_id);
        //MANDAMOS LOS DATOS A LA VISTA
        $this->set(array(
            'tipo'=>$tipo,
            'empresas'=> $empresas
        ));
    }

    /**
     * FUNCION PHP PARA OBTENER LAS COORDENADAS MEDIANTE UNA DIRECCION
     * @PARAMS - DIRECCION
     */
    private function obtener_coordenadas($address){
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
        }
        //SI HEMOS OBTENIDO LOS DATOS 
        else {
            //OBTENEMOS LOS DATOS DE LAS COORDENADAS Y DEVOLCEMOS UN ARRAY DE DOS POSICIONES
            $lat = $json['results'][0]['geometry']['location']['lat'];
            $lng = $json['results'][0]['geometry']['location']['lng'];
            return array($lat, $lng);
        }

    }

    


}