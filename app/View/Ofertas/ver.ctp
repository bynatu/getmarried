<?php echo $this->Html->script('../js/tabs.js'); ?>
<?php echo $this->form->hidden(
    '',
    array(
        'id' => 'ofertas-js',
        'value' => json_encode($ofertas),
    )
) ?>
<?php echo $this->form->hidden(
    '',
    array(
        'id' => 'url-js',
        'value' => Router::url(array('controller' => 'solicitudes', 'action' => 'detalles')),
    )
) ?>
<!--mostramos los datos del usuario solo en version movil sera oculto-->
<div class="hidden-xs col-sm-offset-1 col-sm-4">
    <?php
    if (empty($image)) {
        echo $this->Html->image("empresa.png", array("alt" => "Registro Empresa", 'class' => 'logo'));
    } else {
        echo $this->Html->image("../".$image['Image']['nombre'], array("alt" => "Registro Empresa", 'class' => 'logo'));
    } ?>
    <div class="m-top-1">
        <p class="color-principal negrita"> <?php echo $empresa['Empresa']['nombre'] ?></p>

        <p><i class="fas fa-address-card"></i><span
                class="m-left-1"><?php echo($empresa['Empresa']['direccion'] . " Nº " . $empresa['Empresa']['numero'] . " " . $empresa['Empresa']['piso']) ?> </span>
        </p>

        <p><i class="fas fa-phone-volume"></i><span
                class="m-left-1"> <?php echo $empresa['Empresa']['telefono'] ?> </span></p>

        <p><i class="fas fa-envelope"></i><span
                class="m-left-1"> <?php echo $empresa['Empresa']['email'] ?> </span></p>
        <?php
        echo $this->Html->link(
            '<i class="fas fa-book"></i> Mi Perfil',
            array(
                'controller' => 'empresas',
                'action' => 'misdatos',
            ),
            array(
                'escape' => false
            )
        )
        ?>
    </div>
</div>

<div class="col-xs-12 col-sm-offset-1 col-sm-5">
    <ul class="tabs">
        <li><a href="#tab1" class="active">Pendientes</a></li>
        <li><a href="#tab2">Aceptadas</a></li>
    </ul>

    <div class="tab_container">
        <div class="tab_content" id="tab1">
            pendiente
        </div>
        <div class="tab_content" id="tab2">
            aceptada
        </div>
    </div>
</div>