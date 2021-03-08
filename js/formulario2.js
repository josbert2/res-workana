jQuery(document).ready(function(){
    function deleteAllCookies() {
        var cookies = document.cookie.split(";");
    
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            var eqPos = cookie.indexOf("=");
            var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }
    }

    deleteAllCookies();
    
    jQuery('#cont_benef').on('click', function(event) {        
        verificarTitular();
    });
    
    jQuery('#cont_titular').on('click', function(event) {   
        hideBeneficiarios();
        showTitular();
    });
    
    jQuery('#conf_modal').on('click', function(event) {   
        verifyForm();
    });
    
    jQuery('#btn_pagar').on('click', function(event) {   
        event.preventDefault();
        if(document.querySelector('#tyc:checked')){
            $('#btn_pagar').attr('disabled', 'disabled');
            registrarOrden();
        }
        else{
            alert("Para poder continuar debe aceptar los términos y condiciones");
        }
    });
    
    $('#num_benef').change(function(){
        var benef = $("#num_benef").val();
        
        if(benef > 0){
            if($(".titular").css('display') == 'block'){
               jQuery('#cont_benef').show();
            }
            
            var html = "";
            var dia_html = '<option selected="true" disabled="disabled" value="0">día</option>';
            var mes_html = '<option selected="true" disabled="disabled" value="0">mes</option>';
            var ano_html = '<option selected="true" disabled="disabled" value="0">año</option>';
            
            for(i = 1; i <= 31; i++){
                if(i < 10){
                    dia_html += '<option value="0' + i + '">' + i + '</option>';
                }
                else{
                    dia_html += '<option value="' + i + '">' + i + '</option>';
                }
            }
            for(i = 1; i <= 12; i++){
                if(i < 10){
                    mes_html += '<option value="0' + i + '">' + i + '</option>';
                }
                else{
                    mes_html += '<option value="' + i + '">' + i + '</option>';
                }
            }
            for(i = 1920; i <= 2020; i++){
                ano_html += '<option value="' + i + '">' + i + '</option>';
            }
            for(i = 1; i <= benef; i++){
                html += '<div class="benef"><div class="caja_info"><div class="titulo_caja"><div class="nombre_caja">Beneficiario ' + i + '</div></div><div class="contenido_caja"><input required class="input" type="text" id="nombres_' + i + '"    placeholder="Nombres"><input required class="input" type="text" id="apellido_p_' + i + '" placeholder="Apellido  Paterno"><input required class="input" type="text" id="apellido_m_' + i + '" placeholder="Apellido  Materno"><div class="flex" id="fecha_nac_' + i + '"><select required class="input" id="dia_' + i + '">' + dia_html + '</select><select required class="input middle"  id="mes_' + i + '">' + mes_html +  '</select><select class="input" id="ano_' + i + '">' + ano_html + '</select></div></div></div></div>';
            }   
            $('#beneficiarios').html(html);
        }
        else{
            $('#beneficiarios').html("");
        }
        
        if(document.querySelector('#check_benef:checked')){
            var nombre     = document.getElementById('nombres').value;
            var apellido_p = document.getElementById('apellido_p').value;
            var apellido_m = document.getElementById('apellido_m').value;
            var dia        = document.getElementById('dia').value;
            var mes        = document.getElementById('mes').value;
            var ano        = document.getElementById('ano').value;
            $('#nombres_1').val(nombre);
            $('#apellido_p_1').val(apellido_p);
            $('#apellido_m_1').val(apellido_m);
            $('#dia_1').val(dia);
            $('#mes_1').val(mes);
            $('#ano_1').val(ano);
            $('#nombres_1').prop("disabled", true);
            $('#apellido_p_1').prop("disabled", true);
            $('#apellido_m_1').prop("disabled", true);
            $('#dia_1').prop("disabled", true);
            $('#mes_1').prop("disabled", true);
            $('#ano_1').prop("disabled", true);
        }
    });
    
    $('#soy_benef').change(function(){
        var checked = 0;
        var benef = $("#num_benef").val();
        if(document.querySelector('#check_benef:checked')){
            checked = 1;
        }
        if((benef) > 0){
            jQuery('#cont_benef').show();
            var html = "";
            var dia_html = '<option selected="true" disabled="disabled" value="0">día</option>';
            var mes_html = '<option selected="true" disabled="disabled" value="0">mes</option>';
            var ano_html = '<option selected="true" disabled="disabled" value="0">año</option>';
            for(i = 1; i <= 31; i++){
                if(i < 10){
                    dia_html += '<option value="0' + i + '">' + i + '</option>';
                }
                else{
                    dia_html += '<option value="' + i + '">' + i + '</option>';
                }
            }
            for(i = 1; i <= 12; i++){
                if(i < 10){
                    mes_html += '<option value="0' + i + '">' + i + '</option>';
                }
                else{
                    mes_html += '<option value="' + i + '">' + i + '</option>';
                }
            }
            for(i = 1920; i <= 2020; i++){
                ano_html += '<option value="' + i + '">' + i + '</option>';
            }
            for(i = 1; i <= benef; i++){
                html += '<div class="benef"><div class="caja_info"><div class="titulo_caja"><div class="nombre_caja">Beneficiario ' + i + '</div></div><div class="contenido_caja"><input required class="input" type="text" id="nombres_' + i + '"    placeholder="Nombres"><input required class="input" type="text" id="apellido_p_' + i + '" placeholder="Apellido  Paterno"><input required class="input" type="text" id="apellido_m_' + i + '" placeholder="Apellido  Materno"><div class="flex" id="fecha_nac_' + i + '"><select required class="input" id="dia_' + i + '">' + dia_html + '</select><select required class="input middle"  id="mes_' + i + '">' + mes_html +  '</select><select class="input" id="ano_' + i + '">' + ano_html + '</select></div></div></div></div>';
            }   
            $('#beneficiarios').html(html);
        }
        else{
            $('#beneficiarios').html("");
        }
    });
    
    $('input').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });
    
    $('input').blur(function(){
        if(document.querySelector('#check_benef:checked')){
            var nombre     = document.getElementById('nombres').value;
            var apellido_p = document.getElementById('apellido_p').value;
            var apellido_m = document.getElementById('apellido_m').value;
            var dia        = document.getElementById('dia').value;
            var mes        = document.getElementById('mes').value;
            var ano        = document.getElementById('ano').value;
            $('#nombres_1').val(nombre);
            $('#apellido_p_1').val(apellido_p);
            $('#apellido_m_1').val(apellido_m);
            $('#dia_1').val(dia);
            $('#mes_1').val(mes);
            $('#ano_1').val(ano);
            $('#nombres_1').prop("disabled", true);
            $('#apellido_p_1').prop("disabled", true);
            $('#apellido_m_1').prop("disabled", true);
            $('#dia_1').prop("disabled", true);
            $('#mes_1').prop("disabled", true);
            $('#ano_1').prop("disabled", true);
        }
    });
    
    
    
    $('#nombres').change(function(){
        if(document.getElementById('nombres').value == "" || hasNumbers(document.getElementById('nombres').value)){
            $('#nombres').addClass("error");
        }
        else{
            if($('#nombres').hasClass("error")){
                $('#nombres').removeClass("error");
            }
        }
    });
    
    $('#apellido_p').change(function(){
        if(document.getElementById('apellido_p').value == "" || hasNumbers(document.getElementById('apellido_p').value)){
            $('#apellido_p').addClass("error");
        }
        else{
            if($('#apellido_p').hasClass("error")){
                $('#apellido_p').removeClass("error");
            }
        }
    });
    
    $('#apellido_m').change(function(){
        if(document.getElementById('apellido_m').value == "" || hasNumbers(document.getElementById('apellido_m').value)){
            $('#apellido_m').addClass("error");
        }
        else{
            if($('#apellido_m').hasClass("error")){
                $('#apellido_m').removeClass("error");
            }
        }
    });
    
    $('#direccion').change(function(){
        if(document.getElementById('direccion').value == ""){
            $('#direccion').addClass("error");
        }
        else{
            if($('#direccion').hasClass("error")){
                $('#direccion').removeClass("error");
            }
        }
    });
    
    $('#rut').change(function(){
        formatearRut();
        if(!verificarRut()){
            $('#rut').addClass("error");
        }
        else{
            if($('#rut').hasClass("error")){
                $('#rut').removeClass("error");
            }
        }
    });
    
    $('#fono_p').change(function(){
        if(!verificarFono()){
            $('#fono_p').addClass("error");
        }
        else{
            if($('#fono_p').hasClass("error")){
                $('#fono_p').removeClass("error");
            }
        }
    });
    
    $('#fono_s').change(function(){
        var fono_s = document.getElementById('fono_s').value;
        if(fono_s.length > 0){
            if(fono_s.toUpperCase() != fono_s.toLowerCase()){
                alert("El número de teléfono no puede contener letras");
                $('#fono_s').addClass("error");
            }
            else{
                if(fono_s.length != 9){
                    alert("El número de teléfono debe contener 9 números");
                    $('#fono_s').addClass("error");
                }
                else{
                    if(fono_s.substring(0,1) == 0){
                        alert("El número de teléfono no puede comenzar en 0");
                        $('#fono_s').addClass("error");
                    }
                    else{
                        if($('#fono_s').hasClass("error")){
                            $('#fono_s').removeClass("error");
                        }
                    }
                }
            }   
        }
        else{
            if($('#fono_s').hasClass("error")){
                $('#fono_s').removeClass("error");
            }
        }
    });
    
    $('#correo').change(function(){
        if(document.getElementById('correo').value != "" && document.getElementById('correo_conf').value != ""){
            if(!verificarCorreo()){
                $('#correo').addClass("error");
                $('#correo_conf').addClass("error");
            }
            else{
                if($('#correo').hasClass("error")){
                    $('#correo').removeClass("error");
                }
                if($('#correo_conf').hasClass("error")){
                    $('#correo_conf').removeClass("error");
                }
            }
        }
    });
    
    $('#correo_conf').change(function(){
        if(document.getElementById('correo').value != "" && document.getElementById('correo_conf').value != ""){
            if(!verificarCorreo()){
                $('#correo').addClass("error");
                $('#correo_conf').addClass("error");
            }
            else{
                if($('#correo').hasClass("error")){
                    $('#correo').removeClass("error");
                }
                if($('#correo_conf').hasClass("error")){
                    $('#correo_conf').removeClass("error");
                }
            }
        }
    });
});

function hasNumbers(t)
{
    var regex = /\d/g;
    return regex.test(t);
}    

function hideTitular(){
    jQuery('.titular').toggle('hide');
    jQuery('#soy_benef').toggle('hide');
    jQuery('#cont_benef').toggle('hide');
}

function showTitular(){
    jQuery('.titular').toggle('show');
    jQuery('#soy_benef').toggle('show');
    jQuery('#cont_benef').toggle('show');
}

function hideBeneficiarios(){
    jQuery('.beneficiarios').toggle('hide');
    jQuery('#cont_titular').toggle('hide');
    jQuery('#cont_modal').toggle('hide');
}

function showBeneficiarios(){
    jQuery('.beneficiarios').toggle('show');
    jQuery('#cont_titular').toggle('show');
    jQuery('#cont_modal').toggle('show');
}

function formatearRut(){
    var rut = $('#rut').val();
    while(rut.includes(".") || rut.includes("-")){
        rut = rut.replace(".", "");
        rut = rut.replace("-", "");
    }
    if(rut.length == 9){
        rut = rut.substring(0, 2) + '.' + rut.substring(2, 5) + '.' + rut.substring(5, 8) + '-' + rut.substring(8, 9);
    }
    else if(rut.length == 8){
        rut = rut.substring(0, 1) + '.' + rut.substring(1, 4) + '.' + rut.substring(4, 7) + '-' + rut.substring(7, 8);
    }
    $('#rut').val(rut);
}

function verificarRut(){
    var rut = document.getElementById('rut').value;
    if(rut.length > 0){
        if((rut.length == 11) || (rut.length == 12)){
            var tmp  = rut.split('-');
            var digv = tmp[1];
            var rut  = tmp[0];
            if(rut.toUpperCase() != rut.toLowerCase()){
                alert("Ingrese un de RUT formato válido.");
                return false;
            }
            else{
                while(rut.includes(".")){
                    rut = rut.replace(".", "");
                }
                var i = rut.length;
                var j = 2;
                var serie_a = 0;
                while(i > 0){
                    if(j < 7){
                        serie_a += rut.substring(i - 1, i) * j;
                        i--;
                        j++;
                    }
                    else if(j == 7){
                        serie_a += rut.substring(i - 1, i) * j;
                        i--;
                        j = 2;
                    }
                }
                var serie_b = Math.trunc(serie_a / 11);
                serie_b = serie_b * 11;
                var digv2 = Math.abs(serie_a - serie_b);
                digv2 = 11 - digv2;
                if(digv2 == 11){
                    digv2 = 0;
                }
                else if(digv2 == 10){
                    digv2 = 'K';
                }
                if(digv == digv2){
                    return true;
                }
                else{
                    alert("El dígito verificador del RUT es incorrecto.");
                    return false;
                }
            }
        }
        else{
            alert("Ingrese un formato de RUT válido.");
            return false;
        }
    }
    else{
        return false;
    }
}

function verificarFono(){
    var fono_p = document.getElementById('fono_p').value;
    var fono_s = document.getElementById('fono_s').value;
    if(fono_p.length > 0){
        if(fono_s.length > 0){
            if((fono_p.toUpperCase() != fono_p.toLowerCase()) || (fono_s.toUpperCase() != fono_s.toLowerCase())){
                alert("Los números de teléfono no puedes contener letras.");
                return false;
            }
            else{
                if((fono_p.length != 9) || (fono_s.length != 9)){
                    alert("Los números de teléfono deben contener 9 dígitos.");
                    return false;
                }
                else{
                    if((fono_p.substring(0,1) == 0) || (fono_p.substring(0,1) == 0)){
                        alert("Los números de teléfono no pueden comenzar en 0.");
                        return false;
                    }
                    else{
                        return true;
                    }
                }
            }
        }
        else{
            if((fono_p.toUpperCase() != fono_p.toLowerCase())){
                alert("El número de teléfono no puede contener letras.");
                return false;
            }
            else{
                if(fono_p.length != 9){
                    alert("El número de teléfono debe contener 9 dígitos.");
                    return false;
                }
                else{
                    if(fono_p.substring(0,1) == 0){
                        alert("El número de teléfono no puede comenzar en 0.");
                        return false;
                    }
                    else{
                        return true;
                    }
                }
            }
        }
    }
    else{
        return false;
    }
}

function verificarCorreo(){
    var correo = document.getElementById('correo').value;
    var correo_conf = document.getElementById('correo_conf').value;
    if((correo != "") && (correo_conf != "")){
        if(correo === correo_conf){
            if((correo.includes('.')) && (correo.includes('@')) &&
               (correo_conf.includes('.')) && (correo_conf.includes('@'))){
                return true;
            }
            else{
                alert("Los correos ingresados deben contener '@' y 's'.");
                return false;
            }
        }
        alert("Los correos ingresados no son iguales.");
        return false;
    }
    return false;
}

function verificarBeneficiarios(){
    var benef = $("#num_benef").val();
    var band  = true;
    for(i = 1; i <= benef; i++){
        
        var nombre     = "#nombres_" + i;
        var apellido_p = "#apellido_p_" + i;
        var apellido_m = "#apellido_m_" + i;
        var dia        = "#dia_" + i;
        var mes        = "#mes_" + i;
        var ano        = "#ano_" + i;
        
        var nombre_benef     = $(nombre).val();
        var apellido_p_benef = $(apellido_p).val();
        var apellido_m_benef = $(apellido_m).val();
        var dia_benef        = $(dia).children("option:selected").val();
        var mes_benef        = $(mes).children("option:selected").val();
        var ano_benef        = $(ano).children("option:selected").val();
        
        if((nombre_benef) && (apellido_p_benef) && (apellido_m_benef) && (dia_benef) && (mes_benef) && (ano_benef)){
            if((nombre_benef == "") || (apellido_p_benef == "") || (apellido_m_benef == "") || (dia_benef < 1) || (mes_benef < 1) || (ano_benef < 1900)){
               band = false;
            }
            else{
                if((hasNumbers(nombre_benef)) || (hasNumbers(apellido_p_benef)) || (hasNumbers(apellido_m_benef))){
                    band = false;
                }
            }
        }
        else{
            band = false;
        }
    }
    return band;
}

function verificarTitular(){
    var msg = "Para poder continuar debe completar los siguientes campos: ";
    
    var nombres     = document.getElementById('nombres').value;
    var apellido_p  = document.getElementById('apellido_p').value;
    var apellido_m  = document.getElementById('apellido_m').value;
    var rut         = document.getElementById('rut').value;
    var correo      = document.getElementById('correo').value;
    var correo_conf = document.getElementById('correo_conf').value;  
    var dia         = document.getElementById('dia').value;
    var mes         = document.getElementById('mes').value;
    var ano         = document.getElementById('ano').value;
    var fono_p      = document.getElementById('fono_p').value;
    var direccion   = document.getElementById('direccion').value;
    
    if($("input:radio[name=plan]:checked").val() == undefined){
        msg += "Plan";
    }
    
    if($("#num_benef").val() == 0){
        if(msg != "Para poder continuar debe completar los siguientes campos: "){
            msg += ", ";
        }
        msg += "Número de Beneficiarios";
    }
    
    if(nombres.length == 0 || $('#nombres').hasClass("error")){
        if(msg != "Para poder continuar debe completar los siguientes campos: "){
            msg += ", ";
        }
        msg += "Nombres";
    }
    if(apellido_p.length == 0 || $('#apellido_p').hasClass("error")){
        if(msg != "Para poder continuar debe completar los siguientes campos: "){
            msg += ", ";
        }
        msg += "Apellido Paterno";
    }
    if(apellido_m.length == 0 || $('#apellido_m').hasClass("error")){
        if(msg != "Para poder continuar debe completar los siguientes campos: "){
            msg += ", ";
        }
       msg += "Apellido Materno";
    }
    if(rut.length == 0 || $('#rut').hasClass("error")){
        if(msg != "Para poder continuar debe completar los siguientes campos: "){
            msg += ", ";
        }
       msg += "RUT";
    }
    if(correo.length == 0 || $('#correo').hasClass("error")){
        if(msg != "Para poder continuar debe completar los siguientes campos: "){
            msg += ", ";
        }
       msg += "Correo";
    }
    if(correo_conf.length == 0 || $('#correo_conf').hasClass("error")){
        if(msg != "Para poder continuar debe completar los siguientes campos: "){
            msg += ", ";
        }
       msg += "Confirmación del Correo";
    }
    if(dia == 0){
        if(msg != "Para poder continuar debe completar los siguientes campos: "){
            msg += ", ";
        }
       msg += "Día";
    }
    if(mes == 0){
        if(msg != "Para poder continuar debe completar los siguientes campos: "){
            msg += ", ";
        }
       msg += "Mes";
    }
    if(ano == 0){
        if(msg != "Para poder continuar debe completar los siguientes campos: "){
            msg += ", ";
        }
       msg += "Año";
    }
    if(fono_p.length == 0 || $('#fono_p').hasClass("error")){
        if(msg != "Para poder continuar debe completar los siguientes campos: "){
            msg += ", ";
        }
       msg += "Teléfono";
    }
    if($('#fono_s').hasClass("error")){
        if(msg != "Para poder continuar debe completar los siguientes campos: "){
            msg += ", ";
        }
       msg += "Teléfono Opcional";
    }
    if(direccion.length == 0 || $('#direccion').hasClass("error")){
        if(msg != "Para poder continuar debe completar los siguientes campos: "){
            msg += ", ";
        }
       msg += "Dirección";
    }
    
    if(msg != "Para poder continuar debe completar los siguientes campos: "){
        alert(msg);
    }
    else{
        hideTitular();
        showBeneficiarios();
    }
}

function disableForm(){
    document.getElementById('nombres').disabled = true;
    document.getElementById('apellido_p').disabled = true;
    document.getElementById('apellido_m').disabled = true;
    document.getElementById('rut').disabled = true;
    document.getElementById('correo').disabled = true;
    document.getElementById('correo_conf').disabled = true;
    document.getElementById('dia').disabled = true;
    document.getElementById('mes').disabled = true;
    document.getElementById('ano').disabled = true;
    document.getElementById('fono_p').disabled = true;
    document.getElementById('fono_s').disabled = true;
    document.getElementById('direccion').disabled = true;
    document.getElementById('comunas').disabled = true;
    document.getElementById('check_benef').disabled  = true;
    document.getElementById('num_benef').disabled = true;
}

function disablePlan(){
    var inputs = document.querySelectorAll('input[type="radio"]');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].disabled = 'true';
    }
}

function verifyForm(){
    var verRut    = verificarRut();
    var verFono   = verificarFono();
    var verCorreo = verificarCorreo();
    var verBenef  = verificarBeneficiarios();
    
    if(verificarBeneficiarios()){
        registrarTitular();
    }
    else{
        alert("Debe completar todos los campos de los beneficiarios y de forma válida");
    }
}