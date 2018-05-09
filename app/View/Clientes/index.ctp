<!--añadimos el script-->
<?php echo $this->Html->script('../js/versolicitudes.js'); ?>
<div class="row">
    <!--mostramos los datos del usuario solo en version movil-->
    <div class="hidden-xs col-sm-offset-1 col-sm-4">
        <?php
        if (empty($image)) {
            echo $this->Html->image("cliente.png", array("alt" => "Registro Cliente", 'class' => 'logo'));
        } else {
            echo $this->Html->image("../".$image['Image']['nombre'], array("alt" => "Registro Cliente", 'class' => 'logo'));
        } ?>
        <div class="m-top-1">
            <p class="color-principal negrita"> <?php echo $cliente['Cliente']['nombre'] . " " . $cliente['Cliente']['apellidos'] ?></p>

            <p><i class="fas fa-address-card"></i><span
                    class="m-left-1"> <?php echo $cliente['Cliente']['direccion'] ?> </span></p>

            <p><i class="fas fa-phone-volume"></i><span
                    class="m-left-1"> <?php echo $cliente['Cliente']['telefono'] ?> </span></p>

            <p><i class="fas fa-envelope"></i><span
                    class="m-left-1"> <?php echo $cliente['Cliente']['email'] ?> </span>
            </p>
            <?php
            echo $this->Html->link(
                '<i class="fas fa-book"></i> Mi Perfil',
                array(
                    'controller' => 'clientes',
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
                '<i class="fas fa-plus-circle"></i> Crear nueva solicitud',
                array(
                    'controller' => 'solicitudes',
                    'action' => 'nueva',
                ),
                array(
                    'escape' => false,
                    'class' => 'btn btn-default sinfondo fondohover bordecolor boton'
                )
            )
            ?>
        </div>
        <div class="m-top-1">
            <?php
            echo $this->Html->link(
                '<i class="fas fa-search"></i> Buscar empresas',
                array(
                    'controller' => 'empresas',
                    'action' => 'lista',
                ),
                array(
                    'escape' => false,
                    'class' => 'btn btn-default sinfondo fondohover bordecolor boton'
                )
            )
            ?>
        </div>
    </div>
    <!--mostramos las solicitudes de un usuario, por defecto cargaran las 3 primeras-->
    <div id="solicitudes" class="col-xs-12 col-sm-offset-1 col-sm-5">
        <?php if (!empty($solicitudes)): ?>
            <?php foreach ($solicitudes as $solicitud): ?>
                <div class="divsolicitud">
                    <h1 class="subtitulo"> <?php echo $solicitud['Tipo']['nombre']; ?>  </h1>
                    <?php
                    if ($solicitud['Solicitud']['aceptado']) {
                        echo $this->Html->image('aceptado.png', array(
                            'alt' => 'ACEPTADO', 'title' => 'ACEPTADO'));
                    } else {
                        echo $this->Html->image('pendiente.png', array(
                            'alt' => 'PENDIENTE', 'title' => 'PENDIENTE'));
                    }

                    ?>
                    <div class="m-1">
                        <p> <?php echo $solicitud['Solicitud']['descripcion']; ?></p>

                        <div class="col-xs-12 col-sm-4">
                            <i class="m-left-1 fas fa-map-marker-alt"></i>
                            <span> <?php echo $solicitud['Solicitud']['ubicacion']; ?> </span>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <i class="m-left-1 fas fa-euro-sign"></i>
                            <span> <?php echo $solicitud['Solicitud']['precio']; ?> </span>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <i class="m-left-1 fas fa-calendar-alt">
                            </i><span> <?php $solicitud['Solicitud']['fecha'] = Fecha::toFormatoVista($solicitud['Solicitud']['fecha']);
                                echo $solicitud['Solicitud']['fecha']; ?> </span>
                        </div>
                        <div class="ta-right">
                            <?php
                            echo $this->html->link(
                                '<i class="fas fa-sign-in-alt color-principal f-size-2"></i>',
                                array(
                                    'controller' => 'solicitudes',
                                    'action' => 'detalles',
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
        <?php else: ?>
            <div>
                <p> Actualmente no dispone de solicitudes</p>

                <div class="m-top-1 visible-xs">
                    <?php
                    echo $this->Html->link(
                        '<i class="fas fa-plus-circle"></i> Crear nueva solicitud',
                        array(
                            'controller' => 'solicitudes',
                            'action' => 'nueva',
                        ),
                        array(
                            'escape' => false,
                            'class' => 'btn btn-default sinfondo fondohover bordecolor boton'
                        )
                    )
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>