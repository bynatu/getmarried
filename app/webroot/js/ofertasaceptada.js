$(document).ready(function(){  

    $('.ventana').click(function(event){
        event.preventDefault();
        data = {};
        data.solicitud =  $(this).data('solicitud')
        $.ajax({
            method: "POST",
            url: $(this).data('url'),
            data: data
          })
            .done(function(data) {
                oferta = JSON.parse(data);
                swal({
                    title: '<i>'+oferta['Empresa']['nombre']+'<i>',
                    html:
                      '<div class="ta-left"> <span class="negrita">SITIO WEB </span> <a href="'+oferta['Empresa']['www']+'" target="_black">'+oferta['Empresa']['www']+'</a></div>'+
                      '<div class="ta-left"> <span class="negrita">PRESTACIÓN </span>' +oferta['Oferta']['prestacion']+'</div>'+
                      '<div class="ta-left"> <span class="negrita">PRESUPUESTO </span>' +oferta['Oferta']['presupuesto']+' €'+'</div>',
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                  })
            });    
    });

});