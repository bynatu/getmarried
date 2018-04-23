<?php echo $this->Form->create();?>
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <?php
            echo $this->Form->Hidden(
                'Solicitud.id',
                array(
                    'name' => 'id',
                )
            ) ?>
            <?php
            echo $this->Form->Hidden(
                'Solicitud.cliente',
                array(
                    'name' => 'cliente',
                )
            ) ?>
            <?php echo $this->Form->input(
                'Solicitud.servicio',
                array(
                    'type' => 'select',
                    'name' => 'servicio',
                    'label' => 'Solicitud',
                    'options'=> $options,
                    'class' => "form-control input-lg"
                )
            ) ?>
            <?php echo $this->Form->input(
                'Solicitud.descripcion',
                array(
                    'type' => 'textarea',
                    'name' => 'descripcion',
                    'label' => 'Detalles',
                    'class' => "form-control input-lg"
                )
            ) ?>
            <?php echo $this->Form->input(
                'Solicitud.ubicacion',
                array(
                    'type' => 'text',
                    'name' => 'ubicacion',
                    'label' => 'Lugar',
                    'class' => "form-control input-lg"
                )
            ) ?>
            <?php echo $this->Form->input(
                'Solicitud.fecha',
                array(
                    'type' => 'text',
                    'name' => 'fecha',
                    'label' => 'Fecha',
                    'class' => "form-control input-lg fecha"
                )
            ) ?>
            <?php echo $this->Form->input(
                'Solicitud.precio',
                array(
                    'type' => 'number',
                    'name' => 'precio',
                    'label' => 'Presupuesto por unidad (€)',
                    'class' => "form-control input-lg"
                )
            ) ?>
        </div>
        </div>
        <div class="centrar">
            <button type="submit" class="btn btn-success btn-lg btnaccion">ACEPTAR</button>
            <button type="reset" class="btn btn-danger btn-lg btnaccion">CANCELAR</button>
        </div>
    <?php $this->Form->end();?>