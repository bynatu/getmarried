<?php echo $this->Form->create(
    array(
        'id' => 'form_editar'
    )
); ?>
<div class="row">
    <div class="col-md-offset-3 col-md-6">
        <?php echo $this->Form->input(
            'Usuario.email',
            array(
                'type' => 'text',
                'name' => 'email',
                'label' => 'Correo Electronico',
                'class' => "form-control input-lg"
            )
        ) ?>
    </div>
    <div class="centrar nofloat">
        <button type="submit" class="btn btn-success btn-lg btnaccion">ENVIAR EMAIL</button>
    </div>
</div>
<?php echo $this->Form->end() ?>
