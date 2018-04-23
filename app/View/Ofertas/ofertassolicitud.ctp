<?php if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::CLIENTE): ?>
<!--añadimos el script-->
<?php echo $this->Html->script('../js/ofertassolicitud.js'); ?>
<div class="hidden-xs col-sm-10 col-sm-offset-1">
    <table id="oferta" class="table table-sm">
    <thead>
    <tr>
    <tr>
        <th scope="col"><?php echo $this->Paginator->sort('Empresa.nombre', 'EMPRESA', array('escape' => false)); ?></th>
        <th scope="col"><?php echo $this->Paginator->sort('Oferta.prestacion', 'PRESTACION', array('escape' => false)); ?></th>
        <th scope="col"><?php echo $this->Paginator->sort('Oferta.presupuesto', 'PRESUPUESTO', array('escape' => false)); ?></th>
        <th scope="col"></th>
    </tr>
    </tr>
    </thead>
    <tbody>

    <?php 
    foreach($ofertas as $oferta):?>
    <tr>
        <td  scope="row"> <?php echo($oferta['Empresa']['nombre']); ?> </td>
        <td> <?php echo($oferta['Oferta']['prestacion']); ?> </td>
        <td> <?php echo($oferta['Oferta']['presupuesto']); ?> </td>
        <td> 
        <div class="aceptado" data-url="<?php
            echo Router::url(array(
                'controller' => 'ofertas',
                'action' => 'aceptar',
                $oferta['Oferta']['id']
            )); ?>"> 
            <i class="far fa-check-circle aceptado" ></i> 
        </div>
        <div class="alerta" data-url="<?php
            echo Router::url(array(
                'controller' => 'ofertas',
                'action' => 'cancelar',
                $oferta['Oferta']['id']
            )); 
            ?>"> 
            <i class="fas fa-ban alerta m-left-1"></i> 
        </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
</div>
<div class="visible-xs hidden-sm">
<?php 
    foreach($ofertas as $oferta):?>
    <div class="m-top-1 p-0 col-xs-10 col-xs-offset-1 bordecolor">
        <div class="fondo color-blanco col-xs-12"><?php echo($oferta['Empresa']['nombre']); ?> </div>
        <div class="col-xs-12"><?php echo($oferta['Oferta']['prestacion']); ?> </div>
        <div class="col-xs-8 negrita"> <?php echo($oferta['Oferta']['presupuesto']."€"); ?></div>
        <div class="col-xs-4"> 
            <div class="aceptado" data-url="<?php
                    echo Router::url(array(
                        'controller' => 'ofertas',
                        'action' => 'aceptar',
                        $oferta['Oferta']['id']
                    )); 
                ?>"> 
                <i class="far fa-check-circle aceptado">
                </i> 
            </div>
            <div class="alerta" data-url="<?php
                echo Router::url(array(
                    'controller' => 'ofertas',
                    'action' => 'cancelar',
                    $oferta['Oferta']['id']
                )) 
                ?>"> 
                <i class="fas fa-ban alerta m-left-1"></i>
            </div> 
        </div>
    </div>
<?php endforeach; ?>
</div>
<?php
    //PAGINATOR
    //actual page
    $current = $this->Paginator->counter(
        array(
            'format' => '{:page}'
        )
    );

    //total pages
    $numbers = $this->Paginator->numbers(
        array(
            'separator' => '',
            'tag' => 'li'
        )
    );
    ?>

    <?php if($numbers) { ?>
        <div class="col-xs-12">
        <div class="m-top-1">
        <nav>
            <ul class="paginar text-center">
                <?php echo $this->Paginator->prev(__('<'), array('tag' => 'li'));?>
                <?php echo $numbers; ?>
                <?php echo $this->Paginator->next(__('>'), array('tag' => 'li')); ?>
            </ul>
        </nav>
        </div>
    </div>
    <?php } ?>
<?php endif; ?>