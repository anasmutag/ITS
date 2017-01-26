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
    cadena = cadena.replace(/\./g, "");
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