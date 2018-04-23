<?php if ($this->Session->read('Auth.User.Usuario.rol') == ConstantesRoles::EMPRESA): ?>
    <h1>BIENVENIDA EMPRESA</h1>

    <?php
    echo $this->Html->link(
        'Mis datos',
        array('controller' => 'empresas', 'action' => 'misdatos', $this->Session->read('Auth.User.Usuario.email')),
        array('class' => 'button', 'target' => '_blank')
    );
    ?>
<?php else: ?>
    <h1>NO TIENE PERMISO DE ACCESO</h1>
<?php endif; ?>