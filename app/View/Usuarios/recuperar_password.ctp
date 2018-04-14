<div class="row contenedor-login">
        <?php
        echo $this->Form->create(
            'Usuario');
        ?>
        <div class="row">
            <div class="columns medium-8 medium-offset-2">
                <?php
                echo $this->Form->input(
                    'Usuario.email',
                    array(
                        'placeholder' => __('Usuario'),
                        'label' => __('Usuario'),
                        'type' => 'text',
                        'autofocus'
                    )
                );
                ?>
            </div>
        </div>
        <div class="row">
            <div class="columns medium-8 medium-offset-2">
                <?php
                echo $this->Form->submit(__('Enviar Contraseña'));
                ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>