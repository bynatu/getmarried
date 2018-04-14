
<h1 class="titulo centrar"><?php echo($tipo['Tipo']['nombre']); ?></h1>
<table class="table table-sm">
<thead>
  <tr>
  <tr>
    <th scope="col"><?php echo $this->Paginator->sort('Empresa.nombre', 'NOMBRE', array('escape' => false)); ?></th>
    <th scope="col"><?php echo $this->Paginator->sort('Empresa.direccion', 'DIRECCION', array('escape' => false)); ?></th>
    <th scope="col"><?php echo $this->Paginator->sort('Empresa.ciudad', 'CIUDAD', array('escape' => false)); ?></th>
    <th scope="col"><?php echo $this->Paginator->sort('Empresa.localidad', 'LOCALIDAD', array('escape' => false)); ?></th>
  </tr>
  </tr>
</thead>
<tbody>

<?php 
foreach($empresas as $empresa):?>
  <tr>
    <td scope="row"> <?php echo($empresa['Empresa']['nombre']); ?> </td>
    <td> <?php echo($empresa['Empresa']['direccion']." Nº".$empresa['Empresa']['numero']." ".$empresa['Empresa']['piso']); ?> </td>
    <td> <?php echo($empresa['Empresa']['ciudad']); ?> </td>
    <td> <?php echo($empresa['Empresa']['provincia']); ?> </td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="row">
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
        <div class="m-top-1 col-md-5 col-md-offset-5">
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
            </div>