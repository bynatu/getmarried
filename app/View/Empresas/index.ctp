<!--añadimos el script-->
<?php echo $this->Html->script('../js/versolicitudes.js'); ?>
<div class="row">
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
        <div class="m-top-1">
            <?php
            echo $this->Html->link(
                '<i class="fas fa-euro-sign"></i> Mis Ofertas ',
                array(
                    'controller' => 'ofertas',
                    'action' => 'ver',
                ),
                array(
                    'escape' => false,
                    'class' => 'btn btn-default sinfondo fondohover bordecolor boton'
                )
            )
            ?>
        </div>
    </div>
    <?php if (!empty($solicitudes)): ?>
        <!--mostramos las solicitudes de un usuario, por defecto cargaran las 3 primeras-->
        <div id="solicitudes" class="col-xs-12 col-sm-offset-1 col-sm-5">
            <?php foreach ($solicitudes as $solicitud): ?>
                <div class="divsolicitud">
                    <div class="m-1">
                        <p> <?php echo $solicitud['Solicitud']['descripcion']; ?></p>

                        <div class="col-xs-12 col-sm-6 m-top-1">
                            <i class="m-left-1 fas fa-user"></i>
                            <span> <?php echo $solicitud['Cliente']['nombre']; ?> </span>
                        </div>
                        <div class="col-xs-12 col-sm-6 m-top-1">
                            <i class="m-left-1 fas fa-map-marker-alt"></i>
                            <span> <?php echo $solicitud['Solicitud']['ubicacion']; ?> </span>
                        </div>
                        <div class="col-xs-12 col-sm-6 m-top-1">
                            <i class="m-left-1 fas fa-euro-sign"></i>
                            <span> <?php echo $solicitud['Solicitud']['precio']; ?> </span>
                        </div>
                        <div class="col-xs-12 col-sm-6 m-top-1">
                            <i class="m-left-1 fas fa-calendar-alt">
                            </i><span> <?php echo $solicitud['Solicitud']['fecha']; ?> </span>
                        </div>
                        <div class="ta-right">
                            <?php
                            echo $this->html->link(
                                '<i class="fas fa-envelope color-principal f-size-2"></i>',
                                array(
                                    'controller' => 'ofertas',
                                    'action' => 'nueva',
                                    $solicitud['Solicitud']['id']
                                ),
                                array(
                                    'escape' => false
                                )
                            )
                            ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (count($solicitudes) > ConstantesMinSolicitudes::TAMANO): ?>
                <!--boton que nos permitira ver el resto de solicitudes realizadas-->
                <div id="ver_mas_menos" class="f-right btn btn-default">
                    <i class="fas fa-arrow-circle-down"></i> VER MAS
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div>
            <p> Actualmente no dispone de solicitudes</p>
        </div>
    <?php endif; ?>
</div>