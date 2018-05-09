<div class="row">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <img src="./img/portada1.jpg" alt="slide1">
    </div>

    <div class="item">
      <img src="./img/portada1.jpg" alt="slide2">
    </div>

    <div class="item">
      <img src="./img/portada1.jpg" alt="slide3">
    </div>
  </div>
</div>
    <?php foreach ($tipos as $tipo): 
        ?>
        <div class="col-xs-4 m-top-1 item-type">
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
    <?php endforeach; ?>
</div>