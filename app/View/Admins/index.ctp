<?php if($this->Session->read('Auth.User.Usuario.rol')==1):?>
<h1>BIENVENIDO ADMIN</h1>
<?php else:?>
<h1>NO TIENE PERMISO DE ACCESO</h1>
<?php endif;?>