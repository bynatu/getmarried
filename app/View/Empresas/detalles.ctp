<!--Añdimos el script del mapa y el script de la api de google maps-->
<?php echo $this->Html->script('../js/gmap.js'); ?>
<?php echo $this->Html->script('https://maps.googleapis.com/maps/api/js?key=AIzaSyAlooq0GVC8KyzH3fuFISBiF8yGOhyepMk'); ?>
<div class="row">
    <div class="col-xs-12 col-sm-5 ta-center">
        <?php
        if (empty($image)) {
            echo $this->Html->image("empresa.png", array("alt" => "Registro Empresa", 'class' => 'logo'));
        } else {
            echo $this->Html->image("../" . $image['Image']['nombre'], array("alt" => "Registro Empresa", 'class' => 'logo'));
        } ?>
    </div>
    <!--Mostramos los datos de la empresa y las funciones para editar-->
    <div class="col-xs-12 col-sm-5">
        <h1 class="titulo"> <?php echo($datos['Empresa']['nombre']) ?></h1>
        <ul id="perfil-data">
            <li><span>Sector de Actividad: </span> <span><?php echo($datos['Tipo']['nombre']) ?></span></li>
            <li><span>Sitio Web: </span>
                <span> <a href="<?php echo($datos['Empresa']['www']) ?> " target="_blank"> <?php echo($datos['Empresa']['www']) ?> </a></span>
            </li>
            <li><span>NIF: </span> <span><?php echo($datos['Empresa']['NIF']) ?></span></li>
            <li><span>Telefono: </span> <span> <?php echo($datos['Empresa']['telefono']) ?></span></li>
            <li><span>Correo Electronico: </span> <span> <?php echo($datos['Empresa']['email']) ?> </span></li>
            <li><span>Dirección: </span> <span><?php echo($datos['Empresa']['direccion'] ." Nº ".$datos['Empresa']['numero']." ".$datos['Empresa']['piso']) ?> </span></li>
            <li><span>Poblacion: </span> <span><?php echo($datos['Empresa']['ciudad']) ?> <span></li>
            <li><span>Localidad: </span> <span><?php echo($datos['Empresa']['provincia']) ?> </span></li>
        </ul>
        <div class="m-1">
            <?php echo($datos['Empresa']['descripcion']) ?>
        </div>
        <?php
        if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::ADMIN){
            echo $this->Html->link(
                '<i class="fas fa-address-card"></i>' . 'EDITAR',
                array(
                    'controller' => 'empresas',
                    'action' => 'editar',
                    $datos['Empresa']['id']
                ),
                array(
                    'class' => 'btn btn-warning ancho100',
                    'escape' => false,
                )
            );
        }
        ?>
    </div>
    <!--Mostramos el mapa con los datos de la empresa-->
    <div id="map" class="col-xs-12 col-sm-6"
         data-lat="<?php echo($datos['Empresa']['latitud']) ?>"
         data-long="<?php echo($datos['Empresa']['longitud']) ?>"
         data-direccion="<?php echo($datos['Empresa']['direccion']) ?>"
         data-ciudad="<?php echo($datos['Empresa']['ciudad']) ?>"
         data-name="<?php echo($datos['Empresa']['nombre']) ?>">
    </div>
</div>

