<?php

class ConstantesMensaje{
    const REGISTRO_BIEN = 'Bienvenido su cuenta de usuario ya esta disponible';
    const EDITAR_BIEN = 'Sus datos han sido actualizados';
    const REGISTRO_MAL =  'Ha ocurrido un error intentelo de nuevo mas tarde';
    const EDITAR_MAL = 'Ha ocurrido un problema al intentar actualizar sus datos';
    const PASSWORD_MAL = 'Usuario o contraseña incorrectos';
    const SOLICITUD_BIEN = 'Solicitud creada';
    const SOLICITUD_MAL = 'Ha ocurrido un probleama, intentelo de nuevo mas tarde';
}
class ConstantesRoles{
    const ADMIN = 1;
    const EMPRESA = 2;
    const CLIENTE = 3;
}
class ConstantesBool{
    const FALSO = 0;
    const VERDADERO = 1;
}

class ConstantesPaginar{
    const TAMANO_PAG = 10;
}
class ConstantesMinSolicitudes{
    const TAMANO = 3;
}