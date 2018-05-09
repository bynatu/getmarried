<div class="row">
    <div class="col-xs-12 col-sm-4 ta-center">
        <?php
        if (empty($image)) {
            echo $this->Html->image("cliente.png", array("alt" => "Registro Cliente", 'class' => 'logo'));
        } else {
            echo $this->Html->image("../" . $image['Image']['nombre'], array("alt" => "Registro Cliente", 'class' => 'logo'));
        } ?>
    </div>
    <div class="col-xs-12 col-sm-6">
        <h1 class="titulo"> <?php echo($datos['Cliente']['nombre'] . " " . $datos['Cliente']['apellidos']) ?></h1>
        <ul id="perfil-data">
            <li><span>DNI: </span> <span> <?php echo($datos['Cliente']['DNI']) ?></span></li>
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
        <?php
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::ADMIN) {
            echo $this->Html->link(
                '<i class="fas fa-address-card"></i>' . 'EDITAR',
                array(
                    'controller' => 'clientes',
                    'action' => 'editar',
                    $datos['Cliente']['id']
                ),
                array(
                    'class' => 'btn btn-warning ancho100',
                    'escape' => false,
                )
            );
        }
        ?>

    </div>
</div>

