<div class="row">
    <div class="page-header">
        <h1 class="f-size-2 color-principal ta-center">¿ CUÁL ES SU PERFIL ?</h1>
    </div>
</div>
<div class="row centrar">
    <div class="col-xs-12 col-sm-4 col-sm-offset-2 ">
        <?php
        echo $this->Html->link(
            $this->Html->image("cliente.png", array("alt" => "Registro Cliente", 'class' => 'logo')) . '<p>CLIENTES</p>',
            array(
                'controller' => 'clientes',
                'action' => 'registro',
            ),
            array(
                'escape' => false,
                'class' => 'registro'
            )
        );
        ?>
    </div>

    <div class="col-xs-12 col-sm-4 ">
        <?php
        echo $this->Html->link(
            $this->Html->image("empresa.png", array("alt" => "Registro Empresas", 'class' => 'logo')) . '<p>EMPRESAS</p>',
            array(
                'controller' => 'empresas',
                'action' => 'registro',
            ),
            array('escape' => false, 'class' => 'registro')
        );
        ?>
    </div>
</div>
