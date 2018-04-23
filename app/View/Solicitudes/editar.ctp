<?php if($this->Session->read('Auth.User.Usuario.rol')==ConstantesRoles::CLIENTE):?>
    <?php $this->extend('Elements/form'); ?>
<?php endif;?>