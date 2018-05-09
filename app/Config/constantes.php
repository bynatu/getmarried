<?php

class ConstantesMensaje
{
    const REGISTRO_BIEN = 'Bienvenido su cuenta de usuario ya esta disponible';
    const EDITAR_BIEN = 'Sus datos han sido actualizados';
    const REGISTRO_MAL = 'Ha ocurrido un error intentelo de nuevo mas tarde';
    const EDITAR_MAL = 'Ha ocurrido un problema al intentar actualizar sus datos';
    const PASSWORD_MAL = 'Usuario o contraseña incorrectos';
    const SOLICITUD_BIEN = 'Solicitud creada';
    const SOLICITUD_MAL = 'Ha ocurrido un probleama, intentelo de nuevo mas tarde';
    const OFERTA_BIEN = 'Oferta enviada';
    const OFERTA_MAL = 'Ha ocurrido un probleama, intentelo de nuevo mas tarde';
}

class ConstantesRoles
{
    const ADMIN = 1;
    const EMPRESA = 2;
    const CLIENTE = 3;
}

class ConstantesBool
{
    const FALSO = 0;
    const VERDADERO = 1;
}

class ConstantesPaginar
{
    const TAMANO_PAG = 10;
}

class ConstantesMinSolicitudes
{
    const TAMANO = 3;
}

class ConstantesTipos
{
    const Floristeria = 1;
    const Hosteleria = 2;
    const Animaciones = 3;
    const Ubicacion = 4;
    const Transporte = 5;
    const Joyeria = 6;
    const Vestuario = 7;
    const Recordatorios = 8;
    const Fotografos = 9;
    const Peluquería = 10;
    const Viajes = 11;
    const Vehiculos = 12;
}