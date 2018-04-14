<!--formulario de registro de clientes-->
<div class="row">
    <div class="col-md-12 text-center">
        <?php echo $this->Form->create() ?>
        <div class="col-md-offset-3 col-md-6">
            <?php echo $this->Form->input(
                'Usuario.email',
                array(
                    'type' => 'email',
                    'name' => 'email',
                    'label' => 'Email',
                    'class' => "form-control input-lg"
                )
            ) ?>
            <?php echo $this->Form->input(
                'Usuario.password',
                array(
                    'type' => 'password',
                    'name' => 'password',
                    'label' => 'Contraseña',
                    'class' => "form-control input-lg"
                )
            ) ?>
        </div>
        <div class="col-md-offset-3 col-md-6">
            <?php echo $this->Form->input(
                'Cliente.nombre',
                array(
                    'type' => 'text',
                    'name' => 'nombre',
                    'label' => 'Nombre',
                    'class' => "form-control input-lg"
                )
            ) ?>
            <?php echo $this->Form->input(
                'Cliente.apellidos',
                array(
                    'type' => 'text',
                    'name' => 'apellidos',
                    'label' => 'Apellidos',
                    'class' => "form-control input-lg"
                )
            ) ?>
            <?php echo $this->Form->input(
                'Cliente.f_nacimiento',
                array(
                    'type' => 'text',
                    'name' => 'f_nacimiento',
                    'label' => 'Fecha de nacimiento',
                    'class' => "form-control input-lg fecha"
                )
            ) ?>
            <?php echo $this->Form->input(
                'Cliente.telefono',
                array(
                    'type' => 'tel',
                    'name' => 'telefono',
                    'label' => 'Telefono',
                    'class' => "form-control input-lg"
                )
            ) ?>
            <div class="col-xs-12 col-sm-6">
            <?php echo $this->Form->input(
                'Cliente.direccion',
                array(
                    'type' => 'text',
                    'name' => 'direccion',
                    'label' => 'Direccion',
                    'class' => "form-control input-lg"
                )
            ) ?>
            </div>
            <div class="col-xs-12 col-sm-3">
                <?php echo $this->Form->input(
                    'Cliente.numero',
                    array(
                        'type' => 'text',
                        'name' => 'numero',
                        'label' => 'Numero',
                        'class' => "form-control input-lg"
                    )
                ) ?>
            </div>
            <div class="col-xs-12 col-sm-3">
                <?php echo $this->Form->input(
                    'Cliente.piso',
                    array(
                        'type' => 'text',
                        'name' => 'piso',
                        'label' => 'Piso',
                        'class' => "form-control input-lg"
                    )
                ) ?>
            </div>
            <?php echo $this->Form->input(
                'Cliente.ciudad',
                array(
                    'type' => 'text',
                    'name' => 'ciudad',
                    'label' => 'Ciudad o Localidad',
                    'class' => "form-control input-lg"
                )
            ) ?>

            <?php echo $this->Form->input(
                'Cliente.localidad',
                array(
                    'type' => 'text',
                    'name' => 'localidad',
                    'label' => 'Localidad',
                    'class' => "form-control input-lg"
                )
            ) ?>


            <?php echo $this->Form->input(
                'Cliente.Nacionalidad',
                array(
                    'type' => 'text',
                    'name' => 'nacionalidad',
                    'label' => 'Nacionalidad',
                    'class' => "form-control input-lg"
                )
            ) ?>
        </div>
        <div class="col-xs-offset-3 col-xs-6 text-center">
            <button type="submit" class="btn btn-success btn-lg btnaccion">REGISTRARSE </button>
        </div>

        <?php echo $this->Form->end() ?>
    </div>
</div>
