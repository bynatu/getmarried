<?php if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::ADMIN): ?>
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-sm-offset-2 ">
            <?php
            echo $this->Html->link(
                $this->Html->image("cliente.png", array("alt" => "Registro Cliente", 'class' => 'logo')) . '<p>CLIENTES</p>',
                array(
                    'controller' => 'clientes',
                    'action' => 'lista',
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
                    'action' => 'lista',
                ),
                array('escape' => false, 'class' => 'registro')
            );
            ?>
        </div>

    </div>
<?php else: ?>
    <h1>NO TIENE PERMISO DE ACCESO</h1>
<?php endif; ?>