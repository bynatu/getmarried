<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <meta name="viewport" content="width=device-width, user-scalable=no"/>
    <title>
        <?php echo $this->fetch('title'); ?>
    </title>
    <?php
    echo $this->Html->meta('icon', '/img/anillo.ico', array('type' => 'icon'));
    echo $this->Html->css('../js/lib/bootstrap/css/bootstrap.css');
    echo $this->Html->css('../js/lib/bootstrap/css/bootstrap-theme.css');
    echo $this->Html->css('../js/lib/jquery-ui-1.10.4/themes/base/minified/jquery-ui.min.css');
    echo $this->Html->css('estilos.css');
    echo $this->Html->script('../js/lib/jquery/jquery-3.3.1.min.js');
    echo $this->Html->script('../js/lib/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js');
    echo $this->Html->script('../js/lib/bootstrap/js/bootstrap.js');
    echo $this->Html->script('../js/fecha.js');
    echo $this->Html->script('../js/fecha.js');
    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    $user = $this->Session->read('Auth.User.Usuario.email');
    $user_rol = $this->Session->read('Auth.User.Usuario.rol');
    if ($user_rol == 2) {
        $controller = "empresas";
    } elseif ($user_rol == 3) {
        $controller = "clientes";
    } else {
        $controller = "admin";
    }
    ?>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js"
            integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl"
            crossorigin="anonymous"></script>
</head>
<body>
<div id="container">
    <header>
        <nav class="navbar navbar-default" role="navigation">
            <!-- El logotipo y el icono que despliega el menú se agrupan
                 para mostrarlos mejor en los dispositivos móviles -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target=".navbar-ex1-collapse">
                    <!--<span class="sr-only">Desplegar navegación</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>-->
                    <i class="fas fa-bars"></i>
                </button>
                <?php
                echo $this->Html->link(
                    $this->Html->image("logo.png", array("alt" => "inicio", 'class' => 'icono')),
                    array(
                        'controller' => 'Usuarios',
                        'action' => 'login',
                    ),
                    array(
                        'escape' => false,
                    )
                );
                ?>
            </div>

            <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                 otro elemento que se pueda ocultar al minimizar la barra -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <?php if (is_null($user)): ?>
                        <li>
                            <?php echo $this->Html->link(
                                'Iniciar Sesion',
                                array(
                                    'controller' => 'Usuarios',
                                    'action' => 'login',
                                )
                            ) ?>
                        </li>
                    <?php else: ?>
                        <li class="visible-xs">
                        <?php
                                    echo $this->Html->link(
                                        'Mis datos',
                                        array(
                                            'controller' => $controller,
                                            'action' => 'misdatos',
                                        )
                                    ) ?>
                        </li>
                        <li class="visible-xs">
                            <?php echo $this->Html->link(
                                'Cerrar Sesion',
                                array(
                                    'controller' => 'usuarios',
                                    'action' => 'logout',
                                )
                            ) ?>
                        </li>
                        <li class="dropdown hidden-xs">
                            <span><?php echo $user ?></span>
                            <a id="dropdownmenu" href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <?php
                                    echo $this->Html->link(
                                        'Mis datos',
                                        array(
                                            'controller' => $controller,
                                            'action' => 'misdatos',
                                        )
                                    ) ?>
                                </li>
                                <li>
                                    <?php echo $this->Html->link(
                                        'Cerrar Sesion',
                                        array(
                                            'controller' => 'usuarios',
                                            'action' => 'logout',
                                        )
                                    ) ?>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

    </header>
    <div id="content">

        <?php echo $this->Flash->render(); ?>

        <?php echo $this->fetch('content'); ?>
    </div>
    <footer>
        <div class="options"><a href="tel:+34-677-895-220" class="fas fa-phone-volume"></a><span>677895220</span></div>
        <div class="options"><a href="mailto:quetecasas@gmail.com" class="fas fa-envelope"></a><span>quetecasas@gmail.com</span>
        </div>
    </footer>
</div>
</body>
</html>
