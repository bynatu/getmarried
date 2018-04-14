<div class="row" id="pwd-container">
    <div class="col-md-4 col-md-offset-4">
        <?php echo $this->Form->create();?>
        <?php echo $this->Html->image("//ssl.gstatic.com/accounts/ui/avatar_2x.png", array('class' => 'img-responsive profile-img-card')); ?>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <?php echo $this->Form->input(
                'Usuarios.email',
                array(
                    'type' => 'email',
                    'name' => 'email',
                    'placeholder' => 'Email',
                    'class' => "form-control input-lg"
                )
            ) ?>
        </div>

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <?php echo $this->Form->input(
                'Usuarios.password',
                array(
                    'type' => 'password',
                    'name' => 'password',
                    'placeholder' => '****',
                    'class' => "form-control input-lg"
                )
            ) ?>
        </div>
        <div class="col-md-12 text-center">
            <?php echo $this->Form->button(
                'Iniciar Sesion',
                array(
                    'type' => 'submit',
                    'class' => "btn btn-default btn-lg",
                )
            ) ?>
        </div>


        <div class="options">
            <p>
                <?php echo $this->Html->link(
                    'Registrate',
                    array(
                        'controller' => 'Registro',
                        'action' => 'index',
                    ),
                    array(
                            'class' => 'enlace'
                    )
                ) ?>
            </p>
            <p>
                <?php echo $this->Html->link(
                    '¿He olvidado mi contraseña?',
                    array(
                        'controller' => 'Registro',
                        'action' => 'index',
                    ),
                    array(
                        'class' => 'enlace'
                    )
                ) ?>
            </p>

        </div>
            <?php echo $this->Form->end();?>
    </div>

</div>