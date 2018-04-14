<div class="row">
    <div class="col-xs-12 col-md-offset-3 col-md-6 m-bottom-1">
        <?php
        echo $this->Html->image('portada1.jpg', array(
            'alt' => '',

        ));
        ?>
    </div>
    <?php foreach ($tipos as $tipo): 
        ?>
        <div class="col-xs-4">
            <div>
                <span class=" col-md-offset-2 col-md-3 ta-center"><?php
                   echo $this->Html->link(
                    $this->Html->image('/img'.$tipo['Tipo']['icono'], array(
                        'alt' => $tipo['Tipo']['nombre'],

                    )),
                    array(
                        'controller' => 'empresas',
                        'action'=> 'listado',
                        $tipo['Tipo']['id'],
                    ),
                   array(
                        'escape' => false
                    )
                    )
                    ?></span>
                <span class="col-md-3  m-top-1 ta-center m-bottom-1"> 
                <?php 
                 echo $this->Html->link(
                    $tipo['Tipo']['nombre'],
                    array(
                        'controller' => 'empresas',
                        'action'=> 'listado',
                        $tipo['Tipo']['id'],
                    ),
                    array(
                        'class' => 'color-negro'
                    ));
                    ?>
                </span>
            </div>
        </div>
    <?php endforeach; ?>
</div>