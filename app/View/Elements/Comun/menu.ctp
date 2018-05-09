<?php
$user = $this->Session->read('Auth.User.Usuario.email');
$user_rol = $this->Session->read('Auth.User.Usuario.rol');
if ($user_rol == ConstantesRoles::EMPRESA) {
    $controller = "empresas";
} elseif ($user_rol == ConstantesRoles::CLIENTE) {
    $controller = "clientes";
} else {
    $controller = "admin";
}
?>
<nav class="navbar navbar-default f-size-1medio">
    <!-- El logotipo y el icono que despliega el menú se agrupan
         para mostrarlos mejor en los dispositivos móviles -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target=".navbar-ex1-collapse">
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
                        '<i class="fas fa-user-circle"></i> Iniciar Sesion',
                        array(
                            'controller' => 'Usuarios',
                            'action' => 'login',
                        ),
                        array(
                            'escape' => false
                        )
                    ) ?>
                </li>
            <?php else: ?>
                <li class="visible-xs float-left ancho100 ta-left">
                    <?php
                    echo $this->Html->link(
                        '<i class="fas fa-address-card"></i>  Mi Perfil ',
                        array(
                            'controller' => $controller,
                            'action' => 'index',
                        ),
                        array(
                            'escape' => false
                        )
                    )
                    ?>
                </li>
                <?php if ($user_rol == ConstantesRoles::CLIENTE): ?>
                    <li class="visible-xs float-left ancho100 ta-left">
                        <?php
                        echo $this->Html->link(
                            '<i class="fas fa-plus-circle"></i>  Crear nueva solicitud ',
                            array(
                                'controller' => 'solicitudes',
                                'action' => 'nueva',
                            ),
                            array(
                                'escape' => false
                            )
                        )
                        ?>
                    </li>
                    <li class="visible-xs float-left ancho100 ta-left">
                        <?php
                        echo $this->Html->link(
                            '<i class="fas fa-search"></i>  Buscar Empresas ',
                            array(
                                'controller' => 'empresas',
                                'action' => 'lista',
                            ),
                            array(
                                'escape' => false
                            )
                        )
                        ?>
                    </li>
                <?php endif; ?>
                <?php if ($user_rol == ConstantesRoles::EMPRESA): ?>
                    <li class="visible-xs float-left ancho100 ta-left">
                        <?php
                        echo $this->Html->link(
                            '<i class="fas fa-euro-sign"></i> Mis Ofertas ',
                            array(
                                'controller' => 'ofertas',
                                'action' => 'ver',
                            ),
                            array(
                                'escape' => false
                            )
                        )
                        ?>
                    </li>
                <?php endif; ?>
                <li class="visible-xs float-left ancho100 ta-left">
                    <?php
                    echo $this->Html->link(
                        '<i class="fas fa-book"></i>  Mis datos',
                        array(
                            'controller' => $controller,
                            'action' => 'misdatos',
                        ),
                        array(
                            'escape' => false
                        )
                    )
                    ?>
                </li>
                <li class="visible-xs float-left ancho100 ta-left">
                    <?php echo $this->Html->link(
                        '<i class="fas fa-user-circle"></i> Cerrar Sesion',
                        array(
                            'controller' => 'usuarios',
                            'action' => 'logout',
                        ),
                        array(
                            'escape' => false
                        )
                    ) ?>
                </li>
                <li class="dropdown hidden-xs">
                    <span><i class="fas fa-user-circle"></i><?php  echo ' '.$user ?></span>
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