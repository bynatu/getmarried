<div class="buscador">
    <?php
    echo $this->Form->create(
        'Buscador',
        array(
            'class' => 'buscador',
            'type' => 'get',
            'url' => array(
                'controller' => 'empresas',
                'action' => 'lista'
            ),
        )
    );
    ?>
    <div class="col-xs-12 col-sm-4">
        <?php echo $this->Form->input(
            'NIF',
            array(
                'label' => 'NIF',
                'type' => 'text',
                'class' => 'ancho100 search_imput'
            )
        ); ?>
    </div>
    <div class="col-xs-12 col-sm-4">
        <?php echo $this->Form->input(
            'nombre',
            array(
                'label' => 'Nombre',
                'type' => 'text',
                'class' => 'ancho100 search_imput'
            )
        ); ?>
    </div>
    <div class="col-xs-12 col-sm-4">
        <?php echo $this->Form->input(
            'tipo',
            array(
                'label' => 'Servicio',
                'type' => 'select',
                'empty' => true,
                'options' => $options,
                'class' => 'ancho100 search_imput'
            )
        ); ?>
    </div>
    <div class="col-xs-12 col-sm-4">
        <?php echo $this->Form->input(
            'email',
            array(
                'label' => 'Correo Electronico',
                'type' => 'text',
                'class' => 'ancho100 search_imput'
            )
        ); ?>
    </div>
    <div class="col-xs-12 col-sm-4">
        <?php echo $this->Form->input(
            'ciudad',
            array(
                'label' => 'Ciudad',
                'type' => 'text',
                'class' => 'ancho100 search_imput'
            )
        ); ?>
    </div>
    <?php if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::ADMIN) : ?>
        <div class="col-xs-12 col-sm-4">
            <div class="col-xs-12 col-sm-6">
                <?php
                echo $this->Form->button(
                    '<i class="fas fa-search"></i>' . ' Buscar',
                    array(
                        'type' => 'submit',
                        'class' => 'btn-default ion-ios-search',
                        'escape' => false,
                        'class' => 'ancho100 search search_imput m-bottom-1'
                    )
                );
                ?>
            </div>
            <div class="col-xs-12 col-sm-6 m-bottom-1">
                <?php
                echo $this->Html->link(
                    '<i class="fas fa-file-excel"></i>' . ' EXTRAER',
                    array(
                        'controller' => 'empresas',
                        'action' => 'export_excel',
                    ),
                    array(
                        'class' => 'btn btn-excel ancho100',
                        'escape' => false,
                    )
                ); ?>
            </div>
        </div>
    <?php else: ?>
        <div class="col-xs-12 col-sm-4">
            <?php
            echo $this->Form->button(
                '<i class="fas fa-search"></i>' . ' Buscar',
                array(
                    'type' => 'submit',
                    'class' => 'btn-default ion-ios-search',
                    'escape' => false,
                    'class' => 'ancho100 search search_imput m-bottom-1'
                )
            );
            ?>
        </div>
    <?php endif; ?>
    <?php if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::ADMIN) : ?>
        <div class="m-1 f-right">
            <?php
            echo $this->Html->link(
                '<i class="fas fa-plus-circle"></i> Crear nueva empresa',
                array(
                    'controller' => 'empresas',
                    'action' => 'registro',
                ),
                array(
                    'escape' => false,
                    'class' => 'btn btn-default sinfondo fondohover bordecolor boton'
                )
            )
            ?>
        </div>
    <?php endif; ?>
    <?php echo $this->Form->end(); ?>
</div>
<?php echo $this->element('Empresa/lista_buscador'); ?>
