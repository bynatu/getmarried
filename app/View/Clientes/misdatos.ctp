<div class="row">
    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
        <h1 class="titulo"> <?php echo($datos['Cliente']['nombre'] . " " . $datos['Cliente']['apellidos']) ?></h1>
        <ul id="perfil-data">
            <li><span>Fecha Nacimiento: </span> <span> <?php echo($datos['Cliente']['f_nacimiento']) ?></span></li>
            <li><span>Telefono: </span> <span> <?php echo($datos['Cliente']['telefono']) ?></span></li>
            <li><span>Correo Electronico: </span> <span> <?php echo($datos['Cliente']['email']) ?> </span></li>
            <li><span>Dirección: </span>
                <span><?php echo($datos['Cliente']['direccion'] . " Nº " . $datos['Cliente']['numero'] . " " . $datos['Cliente']['piso']) ?> </span>
            </li>
            <li><span>Localidad: </span> <span><?php echo($datos['Cliente']['localidad']) ?> </span></li>
            <li><span>Ciudad: </span> <span><?php echo($datos['Cliente']['ciudad']) ?> <span></li>
            <li><span>Nacionalidad: </span> <span><?php echo($datos['Cliente']['nacionalidad']) ?> <span></li>
        </ul>
        <div class="col-xs-12 col-md-6">
            <?php
            echo $this->Html->link(
                '<i class="glyphicon glyphicon-user"></i>' . ' CAMBIAR EMAIL   /   ' . '<i class="glyphicon glyphicon-lock"></i>' . ' CONTRASEÑA',
                array(
                    'controller' => 'usuarios',
                    'action' => 'editar',
                    $datos['Cliente']['email']
                ),
                array(
                    'class' => 'btn btn-warning',
                    'escape' => false,
                )
            )
            ?>
        </div>
        <div class="col-xs-12 col-md-6">
            <?php
            echo $this->Html->link(
                '<i class="fas fa-address-card"></i>' . ' CAMBIAR DATOS PERSONALES',
                array(
                    'controller' => 'clientes',
                    'action' => 'editar',
                    $datos['Cliente']['id']
                ),
                array(
                    'class' => 'btn btn-warning',
                    'escape' => false,
                )
            );
            echo $user;
            ?>
        </div>

    </div>
</div>

