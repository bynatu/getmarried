<table id='tablaresponsive' class='table stacktable' border='0'>
    <thead>
    <tr>
        <th scope="col"><?php echo $this->Paginator->sort('Cliente.nombre', 'NOMBRE', array('escape' => false)); ?></th>
        <th scope="col"><?php echo $this->Paginator->sort('Cliente.direccion', 'DIRECCION', array('escape' => false)); ?></th>
        <th scope="col"><?php echo $this->Paginator->sort('Cliente.email', 'CORREO ELECTRONICO', array('escape' => false)); ?></th>
        <th scope="col"><?php echo $this->Paginator->sort('Cliente.telefono', 'TELEFONO', array('escape' => false)); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($clientes as $cliente):?>
        <tr>
            <td scope="row">
                <?php echo $this->Html->link(
                $cliente['Cliente']['nombre']." ".$cliente['Cliente']['apellidos'],
                array(
                    'controller' => 'clientes',
                    'action' => 'detalles',
                    $cliente['Cliente']['id']
                ));
                array(
                    'escape' => false
                )
                ?>
            </td>
            <td> <?php echo($cliente['Cliente']['direccion'] . " Nº" . $cliente['Cliente']['numero'] . " " . $cliente['Cliente']['piso']." (".$cliente['Cliente']['ciudad'].")"); ?> </td>
            <td> <?php echo($cliente['Cliente']['email']); ?></td>
            <td> <?php echo($cliente['Cliente']['telefono']); ?></td>
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

    <?php if ($numbers) { ?>
        <div class="col-xs-12">
            <div class="m-top-1">
                <nav>
                    <ul class="paginar text-center">
                        <?php echo $this->Paginator->prev(__('<'), array('tag' => 'li')); ?>
                        <?php echo $numbers; ?>
                        <?php echo $this->Paginator->next(__('>'), array('tag' => 'li')); ?>
                    </ul>
                </nav>
            </div>
        </div>
    <?php } ?>
</div>