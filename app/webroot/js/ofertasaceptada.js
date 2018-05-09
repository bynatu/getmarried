$(document).ready(function () {

    $('.ventana').click(function () {
        data = {};
        data.solicitud = $(this).data('solicitud')
        $.ajax({
                method: "POST",
                url: $(this).data('url'),
                data: data
            })
            .done(function (data) {
                oferta = JSON.parse(data);
                $('#myModalLabel').html(oferta['Empresa']['nombre']);
                $('#www').html('Pagina web: <a href="'+oferta['Empresa']['www']+'" target="_blank">'+oferta['Empresa']['www']+'</a>');
                $('#desc').html(oferta['Oferta']['prestacion']);
                $('#precio').html('PRECIO: '+oferta['Oferta']['presupuesto']+'€');
            });
    });

});