<?php if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE or $this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::EMPRESA): ?>
    <?php echo $this->Html->script('../js/ofertasaceptada.js'); ?>
    <?php echo $this->Html->script('../js/accionessolicitud.js'); ?>
    <div class="row">
        <h1 class="titulo centrar"> Solicitud <?php echo $solicitud['Tipo']['nombre']; ?> </h1>

        <div class="col-xs-12 col-sm-offset-1 col-sm-4">
            <?php echo $this->Html->image('/img' . $solicitud['Tipo']['image'],
                array(
                    'alt' => $solicitud['Tipo']['nombre'])
            )
            ?>
        </div>
        <div class="col-xs-12  col-sm-offset-1 col-sm-4">
            <p> <?php echo $solicitud['Solicitud']['descripcion']; ?></p>

            <div>
                <p><i class="m-left-1 fas fa-map-marker-alt"></i><span
                        class="m-left-1"> <?php echo $solicitud['Solicitud']['ubicacion']; ?> </span></p>

                <p><i class="m-left-1 fas fa-euro-sign"></i><span
                        class="m-left-1"> <?php echo $solicitud['Solicitud']['precio']; ?> € </span></p>

                <p><i class="m-left-1 fas fa-calendar-alt"></i><span
                        class="m-left-1"> <?php echo $solicitud['Solicitud']['fecha']; ?> </span></p>
                <i class="m-left-1 fas fa-building"></i>
                <?php if (!$solicitud['Solicitud']['aceptado']):
                    if($numofertas > 0) {
                        $empresas = '<span class="m-left-1 cursiva alerta">'.$numofertas.' ofertas recibidas </span>';
                        echo $empresas;
                        echo $this->Html->link(
                            '<i class="fas fa-eye"></i> <span> VER </span>',
                            array(
                                'controller' => 'ofertas',
                                'action' => 'ofertassolicitud',
                                $solicitud['Solicitud']['id']
                            ),
                            array(
                                'class' => 'm-1 noenlace',
                                'escape' => false
                            )
                        );
                    }
                    else{
                        $empresas = '<span class="m-left-1 cursiva alerta"> No ha recibido ninguna oferta </span>';
                        echo $empresas;
                    }
                ?>
                <?php else:
                    $empresas = '<span class="m-left-1 cursiva aceptado"> Oferta aceptada </span>';
                    echo $empresas;
                    echo $this->Html->link(
                        '<i class="fas fa-eye"></i> <span> VER </span>',
                        'javascript:void(0)',
                        array(
                            'class' => 'm-1 noenlace ventana',
                            'escape' => false,
                            'data-url' => Router::url(
                                array(
                                    'controller' => 'solicitudes',
                                    'action' => 'ajax_aceptada'
                                )
                            ),
                            'data-solicitud' => $solicitud['Solicitud']['id'],
                            'data-toggle' => 'modal',
                            'data-target' => '#miModal'
                        )
                    ); ?>
                <?php endif; ?>
            </div>
            <?php if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE): ?>
            <div class="centrar m-top-1">
                <?php echo $this->form->Button(
                    'EDITAR',
                    array(
                        'id' => 'solicitud_editar',
                        'class' => 'btn btn-warning',
                        'data-url' => Router::url(array(
                            'controller' => 'solicitudes',
                            'action' => 'ajax_editar',

                        )),
                        'data-solicitud' => $solicitud['Solicitud']['id']
                    )
                ); ?>
                <?php echo $this->form->Button(
                    'BORRAR',
                    array(
                        'id' => 'solicitud_borrar',
                        'class' => 'btn btn-danger',
                        'data-url' => Router::url(array(
                            'controller' => 'solicitudes',
                            'action' => 'ajax_borrar'
                        )),
                        'data-redirect' => Router::url(array(
                            'controller' => 'clientes',
                            'action' => 'index'
                        )),
                        'data-solicitud' => $solicitud['Solicitud']['id']
                    )
                ); ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title subtitulo" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body">
                        <ul class="list-unstyled">
                            <li id="www"></li>
                            <li id="desc"></li>
                            <li id="precio"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>



