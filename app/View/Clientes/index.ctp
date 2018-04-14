<!--añadimos el script-->
<?php echo $this->Html->script('../js/versolicitudes.js'); ?>
<!--comprobamos el rol del usuario logueado-->
<?php if($this->Session->read('Auth.User.Usuario.rol')==3):?>
    <div class="row">
        <!--mostramos los datos del usuario solo en version movil-->
        <div class= "hidden-xs col-sm-offset-1 col-sm-4">
            <?php echo $this->Html->image("cliente.png", array("alt" => "Registro Cliente", 'class' => 'logo')) ?>
            <div class="m-top-1">
                <p class="color-principal negrita"> <?php echo $cliente['Cliente']['nombre']." ".$cliente['Cliente']['apellidos']  ?></p>
                <p> <i class="fas fa-address-card"></i><span class="m-left-1"> <?php echo $cliente['Cliente']['direccion'] ?> </span></p>
                <p> <i class="fas fa-phone-volume"></i><span class="m-left-1"> <?php echo $cliente['Cliente']['telefono']  ?> </span></p>
                <p> <i class="fas fa-envelope"></i><span class="m-left-1"> <?php echo $cliente['Cliente']['email']  ?> </span></p>
            </div>
            <?php
                echo $this->Html->link(
                    '<i class="fas fa-pencil-alt"></i> Mi Perfil',
                    array(
                        'controller' => 'clientes',
                        'action' => 'misdatos',
                    ),
                    array(
                        'escape'=>false
                    )
                ) 
            ?>
        </div>
          <!--mostramos las solicitudes de un usuario, por defecto cargaran las 3 primeras-->
        <div id="solicitudes" class="col-xs-12 col-sm-offset-1 col-sm-5">
            <?php foreach($solicitudes as $solicitud):?>
            <div class="divsolicitud">
                <h1 class="subtitulo"> <?php echo $solicitud['Tipo']['nombre'];?>  </h1>
                <?php 
                    if($solicitud['Solicitud']['aceptado']){
                        echo $this->Html->image('aceptado.png', array(
                            'alt' => 'ACEPTADO','title' => 'ACEPTADO'));
                    }
                    else{
                        echo $this->Html->image('pendiente.png', array(
                            'alt' => 'PENDIENTE','title' => 'PENDIENTE'));
                    }
                    
                ?>
                <div class="m-1"> 
                        <p> <?php echo $solicitud['Solicitud']['descripcion'];?></p> 
                        <p>
                            <i class="m-left-1 fas fa-map-marker-alt"></i><span class="m-left-1"> <?php echo $solicitud['Solicitud']['ubicacion'];?> </span> 
                            <i class="m-left-1 fas fa-euro-sign"></i><span class="m-left-1"> <?php echo $solicitud['Solicitud']['precio'];?> </span> 
                            <i class="m-left-1 fas fa-calendar-alt"></i><span class="m-left-1"> <?php echo $solicitud['Solicitud']['fecha'];?> </span> 
                        </p>
                </div>
            </div>
            <?php endforeach;?>
            <!--boton que nos permitira ver el resto de solicitudes realizadas-->
            <div id="ver_mas_menos" class="f-right btn btn-default"> 
                <i class="fas fa-arrow-circle-down"></i> VER MAS
            </div>
        </div>
    </div>       
<?php else:?>
<h1>NO TIENE PERMISO DE ACCESO</h1>
<?php endif;?>