$(document).ready(function () {

    $("#image").change(function(){
        var file = document.getElementById('image').files[0];
        if(file){
            if(file.size > 2097152){
                swal(
                    '',
                    'El fichero supera 2 MB',
                    'error'
                );
                $('#formimage')[0].reset();

            }
            else{
                $size = parseInt(file.size)/1024;
                $size = parseFloat($size);
                $size = $size.toFixed(2);
                console.log($size);
                $cadena = '<i class="fas fa-trash borrar m-right-1"></i>'+file.name+" ("+$size+' KB)';
                $('#addimage').html($cadena);
            }

        }
    });

    $('#addimage').on('click','.borrar',function(){
        $('#formimage')[0].reset();
        $('#addimage').html('');
    })


});