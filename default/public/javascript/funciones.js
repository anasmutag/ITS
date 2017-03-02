function validar_email(email){
    var regexpattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    
    if((email.match(regexpattern))){
        return true;
    }else{
        return false;
    }
}

function validar_codigoestudiante(codigo){
    //return true;
    
    $.ajax({
        type: 'POST',
        url: window.public_path + 'grade/validarCodigoEstudiante/',
        data: {
            codigo: codigo
        },
        dataType: 'json',
        beforeSend: function(){
            $('body').addClass('menuopen');
            
            $.blockUI({
                message: "Validando código..."
            });
        },
        success: function(data) {
            $('body').removeClass('menuopen');
            
            if(data !== null && data.res === 'ok'){
                return true;
            }else{
                return false;
            }
        },
        error: function(){
            return false;
        }
    }).always(function(){
        $.unblockUI();
    });
}

function convertiranumero(cadena){
    //cadena = cadena.replace(/\./g, "");
    cadena = cadena.replace(',','.');
    
    return parseFloat(cadena);
}

function puntoporcoma(cadena){
    cadena = cadena.replace(',','.');
    
    return parseFloat(cadena);
}

function soloNumeros(e){
    var keynum = window.event ? window.event.keyCode : e.which;

    if((keynum == 8) || (keynum == 46))
        return true;

    return /\d/.test(String.fromCharCode(keynum));
}

function rs(){
    hb = $('body').innerHeight();
    hw = window.innerHeight;

    h = (hw - hb) / 2;

    if(hb <= hw){
        $('html').addClass('contenido');
        $('body').addClass('cuerpo_alterno');
        $('body').css({
            'margin-top': h.toString() + "px"
        });
        $('#cab_alterno').addClass('cabecera_alterno');
        $('#dv_informacion_instituto').addClass('pie_alterno');
    }else{
        $('html').removeClass('contenido');
        $('body').removeClass('cuerpo_alterno');
        $('body').removeAttr('style');
        $('#cab_alterno').removeClass('cabecera_alterno');
        $('#dv_informacion_instituto').removeClass('pie_alterno');
    }
}

function alturamenu(){
    var alturaoc = $('#dv_opcionesactivasmenu').height(),
        altura = $('#dv_opcionesmenu').height() - alturaoc;
    
    if(altura > 0){
        $('#dv_noopcionmenu').css({width: '100%', height: altura});
        $('#dv_noopcionmenu div').css({width: '60px', height: '100%', 'background-color': '#00529B'});
    }else{
        $('#dv_noopcionmenu').css({width: '100%', height: '0'});
    }
}