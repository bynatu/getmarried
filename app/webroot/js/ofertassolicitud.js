$(document).ready(function(){  

    $('.aceptado').click(function(){
        swal({
            title: '¿Seguro que desea aceptar esta oferta?',
            text: "Se eliminaran todas las ofertas restantes y se cerrara la solicitud",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'green',
            cancelButtonColor: 'red',
            confirmButtonText: 'ACEPTAR',
            cancelButtonText: 'CANCELAR',
          }).then((result) => {
            if (result.value) {
                $.ajax({
                    method: "POST",
                    url: $(this).data('url'),
                  })
                    .done(function(data) {
                        swal(
                            'Aceptado',
                            'Oferta aceptada se le notificara a la empresa',
                            'success'
                        ).then((result) => {
                            if (result.value) {
                                window.location.href = data;
                            }
                        });
                    });
              }
          })
    });

    $('.alerta').click(function(){
        swal({
            title: '¿Seguro que desea borrar esta oferta?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'green',
            cancelButtonColor: 'red',
            confirmButtonText: 'ACEPTAR',
            cancelButtonText: 'CANCELAR',
          }).then((result) => {
            if (result.value) {
                $.ajax({
                    method: "POST",
                    url: $(this).data('url'),
                })
                .done(function(data) {
                    swal(
                        'Eliminar',
                        'Su oferta ha sido eliminada',
                        'success'
                    ).then((result) => {
                        if (result.value) {
                            window.location.href = data;
                        }
                    });
                });
            }
          })
    });

});