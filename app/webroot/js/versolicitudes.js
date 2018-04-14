$(document).ready(function(){  
    $("#ver_mas_menos").click(function(){
        $('#solicitudes').children('.divsolicitud').css("display", "block");
        $(this).removeClass( "btn btn-default" )
        $(this).html('');
        }
    );
});

