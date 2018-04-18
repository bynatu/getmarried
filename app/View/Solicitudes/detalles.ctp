<div class="row">
    <h1 class="titulo centrar"> Solicitud  <?php echo $solicitud['Tipo']['nombre'];  ?> </h1>
    <div class="col-xs-12 col-sm-offset-1 col-sm-4">
        <?php echo  $this->Html->image('/img'.$solicitud['Tipo']['image'], 
                    array(
                        'alt' => $solicitud['Tipo']['nombre'])
            )
        ?>
    </div> 
    <div class="col-xs-12  col-sm-offset-1 col-sm-4">
        <p> <?php echo $solicitud['Solicitud']['descripcion'];?></p> 
        <div>
            <p><i class="m-left-1 fas fa-map-marker-alt"></i><span class="m-left-1"> <?php echo $solicitud['Solicitud']['ubicacion'];?> </span> </p>
            <p><i class="m-left-1 fas fa-euro-sign"></i><span class="m-left-1"> <?php echo $solicitud['Solicitud']['precio'];?> </span> </p>
            <p><i class="m-left-1 fas fa-calendar-alt"></i><span class="m-left-1"> <?php echo $solicitud['Solicitud']['fecha'];?> </span> </p>
            <?php 
                if(!$solicitud['Solicitud']['aceptado'])
                     $empresas= '<span class="m-left-1 cursiva alerta"> 99999 ofertas recibidas </span>';
                else
                    $empresas = '<span class="m-left-1 cursiva aceptado"> Oferta aceptada </span>';
                ?>
                <div class="hidden-xs">
                    <i class="m-left-1 fas fa-building"></i>
                    <?php
                    echo $empresas;
                    echo $this->Html->link(
                        '<i class="fas fa-eye"></i> <span> VER </span>',
                        array(
                            'controller' => 'ofertas',
                            'action'=> 'ofertassolicitud',
                            $solicitud['Solicitud']['id']
                            ),
                            array(
                                'class' => 'm-1 noenlace',
                                'escape'=>false
                        )
                    ); ?>
                </div>
                <div class="visible-xs">
                    <div>
                        <i class="m-left-1 fas fa-building"></i>
                        <?php echo $empresas;?>
                    </div>
                    <div class="m-top-1">
                        <?php echo $this->Html->link(
                        '<i class="fas fa-eye"></i> <span> VER </span>',
                        array(
                            'controller' => 'ofertas',
                            'action'=> 'ofertassolicitud',
                            $solicitud['Solicitud']['id']
                            ),
                            array(
                                'class' => 'm-1 noenlace',
                                'escape'=>false
                            )
                        ); ?>
                    </div>
                </div>
        </div>   
    </div> 
    </div>
</div>
