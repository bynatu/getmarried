<div class="row">
    <div class="col-md-12 text-center">
        <?php echo $this->Form->create() ?>
        <div class="col-md-offset-3 col-md-6">
            <?php
            echo $this->Form->Hidden(
                'Solicitud.id',
                array(
                    'name' => 'solicitud',
                    'value'=> $solicitud['Solicitud']['id'],
                )
            ) ?>
            <?php echo $this->Form->input(
                'Oferta.prestacion',
                array(
                    'type' => 'textarea',
                    'name' => 'prestacion',
                    'label' => 'Prestación',
                    'class' => "form-control input-lg"
                )
            ) ?>
            <?php echo $this->Form->input(
                'Oferta.presupuesto',
                array(
                    'type' => 'Number',
                    'name' => 'presupuesto',
                    'label' => 'Presupuesto',
                    'class' => "form-control input-lg"
                )
            ) ?>

        </div>
        <div class="col-md-12 text-cnter">
            <button type="submit" class="btn btn-success btn-lg btnaccion">ENVIAR</button>
        </div>
        <?php echo $this->Form->end() ?>
    </div>
</div>