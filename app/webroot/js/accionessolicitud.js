$(document).ready(function(){  

    $('#solicitud_editar').click(function(){
        $data = {};
        $data.solicitud = $(this).data('solicitud');
        $.ajax({
            method: "POST",
            url: $(this).data('url'),
            data: $data,
        })
            .done(function(data) {
            if(data != 0){
                window.location.href = data;
            }
            else{
                swal(
                    'No se pudo editar',
                    'Revise las ofertas activas de esta solicitud',
                    'error'
                )
            }
        });
        
    });

    $('#solicitud_borrar').click(function(){
        $data = {};
        $data.solicitud = $(this).data('solicitud');
        swal({
            title: '¿Seguro que desea borrar esta solicitud?',
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
                    data: $data,
                })
                .done(function(data) {
                    if(data != 0){
                        swal(
                            'Oferta borrada',
                            '',
                            'success'
                        ).then((result) => {
                            if (result.value) {
                                window.location.href = data;
                            }
                        });   
                    }
                    else{
                        swal(
                            'No se pudo borrar',
                            'Revise las ofertas activas de esta solicitud',
                            'error'
                        )
                    }
                });
            }
          })
    });

});