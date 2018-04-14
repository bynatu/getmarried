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

    public $helpers = array(
        'Html',
        'Form',
        'Flash',
    );
    
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

    public function begin(){
        $this->{$this->modelClass}->getDataSource()->begin();
    }

    public function commit(){
        $this->{$this->modelClass}->getDataSource()->commit();
    }
    

    function beforeFilter() {
        $this->Auth->userModel = 'Usuario';
        $this->Auth->fields = array('username' => 'email', 'password' => 'password');
        $this->Auth->loginAction = array('admin' => false, 'controller' => 'usuarios', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'usuarios', 'action' => 'loginRedirect');
    }
}
