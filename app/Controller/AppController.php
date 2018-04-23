<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    /*HELPERS PARA DESARROLLO RAPIDO DE HTML DESDE CAKEPHP*/ 
    public $helpers = array(
        'Html',
        'Form',
        'Flash',
    );
    
    /**
     * COMPONENTES QUE VA A UTILIZAR LA APLICACION
     */
    public $components = array(
        'Session' => array('className' => 'Session'),
        'DebugKit.Toolbar',
        'Flash',
        'Acceso',
        'Acl',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'usuarios',
                'action' => 'login',
            ),
            'loginRedirect' => array(
                'controller' => 'paginas',
                'action' => 'home'
            ),
            'logoutRedirect' => array(
                'controller' => 'usuarios',
                'action' => 'login'
            ),
            'authError' => 'Acceso Restringido',
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => array(
                        'className' => 'Simple',
                        'hashType' => 'sha256'
                    ),
                    'userModel' => 'Usuario',
                    'fields' => array(
                        'username' => 'username',
                        'password' => 'password'
                    ),
                    'scope' => array(
                        'activo' => 1
                    ),
                )
            ),
        ),
    );

    /**
     * FUNCION PARA INDICAR EL INICIO DE UNA TRANSACCION SQL
     */
    public function begin(){
        $this->{$this->modelClass}->getDataSource()->begin();
    }

    /**
     * FUNCION PARA CONFIRMAR LOS CAMBIOS DE LA TRANSACION SQL
     */
    public function commit(){
        $this->{$this->modelClass}->getDataSource()->commit();
    }
    
    /**
     * FUNCION PARA AL INICIAR SESION COMPORBAR LOS CAMPOS QUE QUE SE HAN DE VALIDAR
     */
    function beforeFilter() {
        $this->Auth->userModel = 'Usuario';
        $this->Auth->fields = array('username' => 'email', 'password' => 'password');
        $this->Auth->loginAction = array('admin' => false, 'controller' => 'usuarios', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'usuarios', 'action' => 'loginRedirect');
    }

    /**
     * FUNCION PARA MEJORAR LA PAGINACION DEL COMPONENTE PAGINATOR
     */
    public function paginar($param_consulta, $condiciones, $limit = 5, $modelo = null) {
        $this->Paginator = $this->Components->load(
            'Paginator',
            Hash::merge(
                $param_consulta,
                array(
                    'limit' => $limit,
                )
            )
        );
        if(isset($modelo)){
            return $this->Paginator->paginate($modelo, $condiciones);
        }else{
            return $this->Paginator->paginate($condiciones);
        }
    }

    
}
