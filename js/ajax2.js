$(document).ready(function(){
        
    //Cambia el Valor Mensual cuando se cambia el plan
    $('input[name=plan]').change(function(){
        var plan = $("input:radio[name=plan]:checked").val();
        var benef = $("#num_benef").val();
        $.ajax({
            url: 'admin/config/ajax2.php',
            type: 'POST',
            data: {plan_id: plan, num_benef: benef},
            success: function(data){
                if(data){
                    var result = "$" + data;
                    $('#valor_mensual').html(result);
                }
                else{
                    $('#valor_mensual').html("$");
                }
            }
        });
    });
    
    //Cambia el Valor Mensual cuando se cambia la cantidad de beneficiarios
    $('#num_benef').change(function(){

        var plan = $("input:checkbox[name=e]:checked").val();
        var benef = $("#num_benef").val();
        $.ajax({
            url: 'admin/config/ajax2.php',
            type: 'POST',
            data: {plan_id: plan, num_benef: benef},
            success: function(data){
                console.log(data)
                if(data){
                    var result = "$" + data;
                    $('#valor_mensual').html(result);
                }
                else{
                    $('#valor_mensual').html("$");
                }
            }
        });
    });
    var pagoString = 0 
    //Cambia los valores de Precio Sin Dscto, Valor a Pagar y Ahorro cuando se cambia el tipo de pago
    $('#tipo_pago').change(function(){
        var plan = $("input:radio[name=plan]:checked").val();
        var benef = $("#num_benef").val();
        var select = document.getElementById("tipo_pago");
        var pago = select.options[select.selectedIndex].value;
        $.ajax({
            url: 'admin/config/ajax2.php',
            type: 'POST',
            dataType: "json",
            data: {plan_id: plan, num_benef: benef, tipo_pago: pago},
            success: function(data){
                pagoString = data
                if((data[0] != null) && (data[1] != null) && (data[2] != null)){
                    var precio_sin_dscto = data[0];
                    var valor_pagar = data[1];
                    var ahorro = data[2];
                    $('#precio_sin_dscto').html("$" + precio_sin_dscto);
                    $('#valor_pagar').html("$" + valor_pagar);
                    $('#ahorro').html("$" + ahorro);
                }
                else{
                    $('#precio_sin_dscto').html("$");
                    $('#valor_pagar').html("$");
                    $('#ahorro').html("$");
                }
            }
        });
    });
    
    //Cambia los valores de Precio Sin Dscto, Valor a Pagar y Ahorro cuando se cambia el tipo de plan
    $('input[name=plan]').change(function(){
        var plan = $("input:radio[name=plan]:checked").val();
        var benef = $("#num_benef").val();
        var select = document.getElementById("tipo_pago");
        var pago = 0 // select.options[select.selectedIndex].value;
        $.ajax({
            url: 'admin/config/ajax2.php',
            type: 'POST',
            dataType: "json",
            data: {plan_id: plan, num_benef: benef, tipo_pago: pago},
            success: function(data){
                if((data[0] != null) && (data[1] != null) && (data[2] != null)){
                    var precio_sin_dscto = data[0];
                    var valor_pagar = data[1];
                    var ahorro = data[2];
                    $('#precio_sin_dscto').html("$" + precio_sin_dscto);
                    $('#valor_pagar').html("$" + valor_pagar);
                    $('#ahorro').html("$" + ahorro);
                }
                else{
                    $('#precio_sin_dscto').html("$");
                    $('#valor_pagar').html("$");
                    $('#ahorro').html("$");
                }
            }
        });
    });
    
    //Cambia los valores de Precio Sin Dscto, Valor a Pagar y Ahorro cuando se cambia la cantidad de beneficiarios
    $('#num_benef').change(function(){
        var plan = $("input:radio[name=plan]:checked").val();
        var benef = $("#num_benef").val();
        var select = document.getElementById("tipo_pago");
        var pago = select.options[select.selectedIndex].value;
        $.ajax({
            url: 'admin/config/ajax2.php',
            type: 'POST',
            dataType: "json",
            data: {plan_id: plan, num_benef: benef, tipo_pago: pago},
            success: function(data){
                console.log(data)
                if((data[0] != null) && (data[1] != null) && (data[2] != null)){
                    var precio_sin_dscto = data[0];
                    var valor_pagar = data[1];
                    var ahorro = data[2];
                    $('#precio_sin_dscto').html("$" + precio_sin_dscto);
                    $('#valor_pagar').html("$" + valor_pagar);
                    $('#ahorro').html("$" + ahorro);
                }
                else{
                    $('#precio_sin_dscto').html("$");
                    $('#valor_pagar').html("$");
                    $('#ahorro').html("$");
                }
            }
        });
    });
});

function verificarSolicitud(){
    var val = true;
    var regex = /[!$%^&*()+|~=`{}\[\]:";'<>?,\/]/gi;
    $('body :input').each(function() {
        if(regex.test($(this).val()) == true){
            val = false;
        }
    });
    $('body select').each(function() {
        if(regex.test($(this).children('option:selected').val()) == true){
            val = false;
        }
    });
    return val;
}

function registrarTitular(){
    var nombres    = $("#nombres").val();
    var apellido_p = $("#apellido_p").val();
    var apellido_m = $("#apellido_m").val();
    var rut        = $("#rut").val();
    var dia        = $("#dia").val();
    var mes        = $("#mes").val();
    var ano        = $("#ano").val(); 
    var correo     = $("#correo").val();
    var fono_p     = $("#fono_p").val();
    var fono_s     = $("#fono_s").val();
    var direccion  = $("#direccion").val();
    var comuna     = $("#comunas").val();
    var plan       = $("input:radio[name=plan]:checked").val();
    var benef      = $("#num_benef").val();
    var fecha_nac  = dia + '-' + mes + '-' + ano;
    
    var utm_source   = $("#utm_source").val();
    var utm_medium   = $("#utm_medium").val();
    var utm_campaign = $("#utm_campaign").val();
    
    if(true){
    //if(verificarSolicitud()){
        $.ajax({
            url: 'admin/config/ajax2.php',
            type: 'POST',
            data: {function:   'registrarTitular', 
                   nombres:    nombres,
                   apellido_p: apellido_p,
                   apellido_m: apellido_m,
                   rut:        rut,
                   fecha_nac:  fecha_nac,
                   correo:     correo,
                   fono_p:     fono_p,
                   fono_s:     fono_s,
                   direccion:  direccion,
                   comuna:     comuna,
                   plan:       plan,
                   benef:      benef,
                   utm_source: utm_source,
                   utm_medium: utm_medium,
                   utm_campaign: utm_campaign
                  },
            success: function(data){
                //alert(data);
                disableForm();
                hideBeneficiarios();
                showTitular();
                jQuery('#cont_benef').toggle('hide');
                document.getElementById('btn_pagar').disabled = false;
                document.getElementById('btn_pagar').style.backgroundColor="#0049a2";
                disablePlan();
            }
        });
    }
    else{
        alert("El ingreso de caracteres especiales no es válido. Vuelva a intentarlo");
    }
}


function sendToken(datos){
    tbk_token = document.getElementById("tbk_token");
    tbk_token.value = datos[0];
    tbkform = document.getElementById("tbkform");
    tbkform.action = datos[1];
    form = document.getElementById("registro");

    form.reset();
    tbkform.submit();
}


function getToken(pagos){
    var email    = $("#correo").val();
    if(pagos){
        $.ajax({
            url: 'admin/config/ajax2.php',
            type: 'POST',
            dataType: "json",
            data: {function: 'getToken',
                   pagos:    pagos,
                   email:    email},
            success: function(data){
                sendToken(data);
                //alert(data);
            }
        });
    }
}

function registrarBeneficiarios(pagos){
    var benef         = $("#num_benef").val();
    var beneficiarios = [];
    
    for(var i = 1; i <= benef; i++){
        var nombres_str    = '#nombres_' + i;
        var apellido_p_str = '#apellido_p_' + i;
        var apellido_m_str = '#apellido_m_' + i;
        var dia_str        = '#dia_' + i;
        var mes_str        = '#mes_' + i;
        var ano_str        = '#ano_' + i;
        
        var nombres    = $(nombres_str).val();
        var apellido_p = $(apellido_p_str).val();
        var apellido_m = $(apellido_m_str).val();
        var dia        = $(dia_str).val();
        var mes        = $(mes_str).val();
        var ano        = $(ano_str).val();
        var fecha_nac  = ano + '-' + mes + '-' + dia;
        
        var array = [pagos, nombres, apellido_p, apellido_m, fecha_nac, i];
        beneficiarios[i - 1] = array;
    }
    
    $.ajax({
        url: 'admin/config/ajax2.php',
        type: 'POST',
        data: {function: 'registrarBeneficiarios', 
               beneficiarios: beneficiarios},
        success: function(data){
            //alert(data);
        }
    });
}

function registrarOrden(){
    var nombres     = $("#nombres").val();
    var apellido_p  = $("#apellido_p").val();
    var apellido_m  = $("#apellido_m").val();
    var rut         = $("#rut").val();
    var dia         = $("#dia").val();
    var mes         = $("#mes").val();
    var ano         = $("#ano").val();
    var correo      = $("#correo").val();
    var fono_p      = $("#fono_p").val();
    var fono_s      = $("#fono_s").val();
    var direccion   = $("#direccion").val();
    var comuna      = $("#comunas").val();
    var plan        = $("input:radio[name=plan]:checked").val();
    var benef       = $("#num_benef").val();
    var fecha_nac   = dia + '-' + mes + '-' + ano;
    var cod_pago    = $('#tipo_pago').val();
    var tipo_pago   = $('#tipo_pago option:selected').text();
    var num_mes     = $('#tipo_pago option:selected').attr("id");
    var ahorro      = $('#ahorro').text();
    var valor_pagar = $('#valor_pagar').text();
    ahorro          = ahorro.replace('.', '');
    valor_pagar     = valor_pagar.replace('.', '');
    ahorro          = ahorro.substring(1, ahorro.length);
    valor_pagar     = valor_pagar.substring(1, valor_pagar.length);
    
    var utm_source   = $("#utm_source").val();
    var utm_medium   = $("#utm_medium").val();
    var utm_campaign = $("#utm_campaign").val();
    
    if(true){
    //if(verificarSolicitud()){
        $.ajax({
            url: 'admin/config/ajax2.php',
            type: 'POST',
            //dataType: "json",
            data: {function:   'registrarOrden', 
                   nombres:     nombres,
                   apellido_p:  apellido_p,
                   apellido_m:  apellido_m,
                   rut:         rut,
                   fecha_nac:   fecha_nac,
                   correo:      correo,
                   fono_p:      fono_p,
                   fono_s:      fono_s,
                   direccion:   direccion,
                   comuna:      comuna,
                   plan:        plan,
                   benef:       benef,
                   cod_pago:    cod_pago,
                   tipo_pago:   tipo_pago,
                   num_mes:     num_mes,
                   ahorro:      ahorro,
                   valor_pagar: valor_pagar,
                   utm_source: utm_source,
                   utm_medium: utm_medium,
                   utm_campaign: utm_campaign
                  },
            success: function(data){
                registrarBeneficiarios(data);
                getToken(data);
                //alert(data);
            }
        });
    }
    else{
        alert("El ingreso de caracteres especiales no es válido. Vuelva a intentarlo");
        $('#btn_pagar').prop('disabled', false);
    }
}