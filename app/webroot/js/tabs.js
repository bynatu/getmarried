$(document).ready(function () {
    $data = $('#ofertas-js').val();
    $url = $('#url-js').val();
    $datos = JSON.parse($data);
    $cadena_aceptado = "";
    $cadena_pendiente = "";

    $.each($datos, function (i, val) {
        $cadena = '<div class="col-xs-12 m-top-1"> ' +
            '<div class="col-xs-12 f-size-2 color-principal ta-center"> <i class="fas fa-user"></i>' + val['Cliente']['nombre'] + '</div> ' +
            '<div class="col-xs-12">' + val['Oferta']['prestacion'] + '</div>' +
            '<div class="col-xs-6 m-top-1">' + val['Oferta']['presupuesto'] + ' <i class="fas fa-euro-sign"></i> </div>';
        if(val['Oferta']['aceptado'] == 1)
            $cadena_aceptado += $cadena +'<div class="col-xs-6 m-top-1 ta-right"> <a href="'+$url+'/'+val['Solicitud']['id']+'"><i class="fas fa-sign-in-alt color-principal f-size-2"></i></a></div>' +
                '</div>';
        else
            $cadena_pendiente += $cadena + '</div>';;

    });
    $('#tab1').html($cadena_pendiente);
    $('#tab2').html($cadena_aceptado);
    //When page loads...
    $(".tab_content").hide(); //Hide all content
    $("ul.tabs li:first").addClass("active").show(); //Activate first tab
    $(".tab_content:first").show(); //Show first tab content

    //On Click Event
    $("ul.tabs li").click(function () {

        $("ul.tabs li").removeClass("active"); //Remove any "active" class
        $(this).addClass("active"); //Add "active" class to selected tab
        $(".tab_content").hide(); //Hide all tab content

        var activeTab = $(this).find("a").attr("href"); //Find the href attribute value toidentify the active tab + content
        $(activeTab).fadeIn(); //Fade in the active ID content
        return false;
    });
});