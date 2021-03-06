<div class="row">
    <div class="col-md-12 text-center">
        <?php echo $this->Form->create() ?>
        <div class="col-md-offset-3 col-md-6">
            <?php
            echo $this->Form->Hidden(
                'Empresa.id',
                array(
                    'name' => 'id',
                )
            ) ?>
              <?php echo $this->Form->input(
                'Empresa.NIF',
                array(
                    'type' => 'text',
                    'name' => 'NIF',
                    'label' => 'NIF',
                    'class' => "form-control input-lg"
                )
            ) ?>
            <?php echo $this->Form->input(
                'Empresa.nombre',
                array(
                    'type' => 'text',
                    'name' => 'nombre',
                    'label' => 'Nombre',
                    'class' => "form-control input-lg"
                )
            ) ?>
            <?php echo $this->Form->input(
                'Empresa.tipo',
                array(
                    'type' => 'select',
                    'name' => 'tipo',
                    'label' => 'Sector de Actividad',
                    'options' => $options,
                    'class' => "form-control input-lg"
                )
            ) ?>
            <?php echo $this->Form->input(
                'Empresa.www',
                array(
                    'type' => 'uri',
                    'name' => 'www',
                    'label' => 'Sitio Web',
                    'class' => "form-control input-lg"
                )
            ) ?>
            <?php echo $this->Form->input(
                'Empresa.telefono',
                array(
                    'type' => 'tel',
                    'name' => 'telefono',
                    'label' => 'Telefono',
                    'class' => "form-control input-lg"
                )
            ) ?>

            <div class="col-xs-12 col-sm-6">
                <?php echo $this->Form->input(
                    'Empresa.direccion',
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
                    'Empresa.numero',
                    array(
                        'type' => 'text',
                        'name' => 'numero',
                        'class' => "form-control input-lg col-xs-3"
                    )
                ) ?>
            </div>
            <div class="col-xs-12 col-sm-3">
                <?php echo $this->Form->input(
                    'Empresa.piso',
                    array(
                        'type' => 'text',
                        'name' => 'piso',
                        'class' => "form-control input-lg col-xs-3"
                    )
                ) ?>
            </div>

            <?php echo $this->Form->input(
                'Empresa.provincia',
                array(
                    'type' => 'text',
                    'name' => 'provincia',
                    'label' => 'Provincia',
                    'class' => "form-control input-lg"
                )
            ) ?>


            <?php echo $this->Form->input(
                'Empresa.ciudad',
                array(
                    'type' => 'text',
                    'name' => 'ciudad',
                    'label' => 'Ciudad',
                    'class' => "form-control input-lg"
                )
            ) ?>

            <?php echo $this->Form->input(
                'Empresa.descripcion',
                array(
                    'type' => 'textarea',
                    'name' => 'descripcion',
                    'label' => 'Descripcion',
                    'class' => "form-control input-lg"
                )
            ) ?>

        </div>
        <div class="col-md-12 text-cnter">
            <button type="submit" class="btn btn-success btn-lg btnaccion">ACEPTAR</button>
        </div>
        <?php echo $this->Form->end() ?>
    </div>
</div>