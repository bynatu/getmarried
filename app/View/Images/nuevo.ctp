<?php echo $this->Html->script('../js/subirimage.js'); ?>
<div class="col-sm-12">
    <?php
    //mirar http://www.edsonmm.com/generar-pdf-en-cakephp-con-el-plugin-cakepdf/#cakephp2
    /* Se crea el formulario con la opción para enviar archivos */
    echo $this->Form->create(
        'Image',
        array(
            'enctype' => 'multipart/form-data',
            'id' => 'formimage',
        )
    );
    /* creamos el input para seleccionar el archivo */
    /* creamos el input para seleccionar el archivo */
    /* Cerramos el formulario y se coloca en boton para hacer submit */
    echo $this->Form->input('file', array('type' => 'file', 'label' => '', 'id' => 'image', 'accept' => 'image/*' )); ?>
    <span id="addimage"></span>
    <?php echo $this->Form->input('GUARDAR', array('type' => 'submit', 'value' => 'Cambiar', 'label' => false, 'class' => 'm-top-1 btn btn-success'));
    echo $this->Form->end(); ?>
</div>
<div class="col-sm-3">


</div>



