$(document).ready(function(){
    $('form *').prop('disabled', true);
});

$('#clase').change(function(){
    if($(this).children('option:selected').val() != ""){
        $('form *').prop('disabled', false);
    }
});

$('#reset').click(function(){
    limpiarCampos();
    limpiarErrores();
    $("#clase").val($("#clase option:first").val());
    $('form *').prop('disabled', true);
});

$('input').change(function(){
    if($(this).val() == ""){
        $(this).addClass("error");
    }
    else{
        $(this).val($(this).val().toLocaleUpperCase());
        if($(this).hasClass("error")){
            $(this).removeClass("error");
        }
    }
});

$('textarea').change(function(){
    if($(this).val() == ""){
        $(this).addClass("error");
    }
    else{
        $(this).val($(this).val().toLocaleUpperCase());
        if($(this).hasClass("error")){
            $(this).removeClass("error");
        }
    }
});

$('input').keypress(function(e) {
    if(($(e.target).attr('id') == 'telefono') || ($(e.target).attr('id') == 'descuento')){
        if(e.which < 48 || e.which > 57){
            e.preventDefault();
        }
    }
    else if(($(e.target).attr('id') == 'monto') || ($(e.target).attr('id') == 'meses')){
        if((e.which < 48 || e.which > 57) && (e.which != 46)){
            e.preventDefault();
        }
    }
    else if($(e.target).attr('id') == 'rut'){
        if((e.which < 48 || e.which > 57) && (e.which != 75) && (e.which != 107)){
            e.preventDefault();
        }
    }
    else if($(e.target).attr('id') != 'email'){
        if(e.which < 58 && e.which > 47){
            e.preventDefault();
        }
    }
});

$('#rut').blur(function(){
    formatearRut();
    if(!validarRUT()){
        $(this).addClass("error");
    }
    else{
        if($(this).hasClass("error")){
            $(this).removeClass("error");
        }
    }
});

$('#telefono').blur(function(){
    if($(this).val().length != 9){
        $(this).addClass('error');
    }
    else{
        if($(this).attr('class').includes('error')){
            $(this).removeClass('error');
        }
    }
})

$('#factura').change(function(){
    if($(this).val().length != 10){
        $(this).addClass('error');
    }
    else{
        if($(this).hasClass('error')){
            $(this).removeClass('error');
        }
    }
});

$('#email').blur(function(){
    if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($('#email').val())){
        if($(this).hasClass("error")){
            $(this).removeClass("error");
        }
    }
    else{
        $(this).addClass("error");
    }
});

$('#monto').blur(function(){
    if(!$(this).val() || $(this).val() == 0){
        $(this).val(1);
    }
    var monto       = $(this).val();
    while(monto.includes('.')){
        monto = monto.replace('.', '');
    }
    
    var descuento   = 100 - $('#descuento').val();
    var nuevo_monto = Math.round((monto/100) * descuento);
    var meses       = $('#meses').val();
    if(!meses){
        meses = 1;
    }
    
    $(this).val(formatNumber(monto));
    $('#nuevo_monto').val(formatNumber(nuevo_monto * meses));
});

$('#descuento').blur(function(){
    var monto = $('#monto').val();
    var meses = $('#meses').val();
    while(monto.includes('.')){
        monto = monto.replace('.', '');
    }
    
    if($(this).val() > 100){
        $(this).val(100);
    }
    else if(!$(this).val()){
        $(this).val(0);
    }
    
    if(!meses){
        meses = 1;
    }
    
    var descuento   = 100 - $(this).val();
    var nuevo_monto = Math.trunc((monto/100) * descuento);
    
    $('#nuevo_monto').val(formatNumber(nuevo_monto * meses));
});

$('#factura').datepicker({ closeText: 'Cerrar',
                           prevText: '< Ant',
                           nextText: 'Sig >',
                           currentText: 'Hoy',
                           monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
                                        'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                           monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                           dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                           dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                           dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                           weekHeader: 'Sm',
                           dateFormat: 'dd-mm-yy',
                           minDate: 0,
                           defaultDate: '+1m'}
);

$('#meses').blur(function(){
    if(!($(this).val()) || $(this).val() == 0){
        $(this).val(1);
    }
    if($(this).val() >= 1){
        var monto = $('#monto').val();
        while(monto.includes('.')){
            monto = monto.replace('.', '');
        }
        var descuento   = 100 - $('#descuento').val();
        var nuevo_monto = Math.round((monto/100) * descuento);
        
        $('#nuevo_monto').val(formatNumber(nuevo_monto * $(this).val()));
    }
    $('#factura').datepicker("setDate", '+' + $(this).val() + 'm');
});

$('#submit').click(function(){
    if(verificarCampos()){
        registrarCliente();
    }
    else{
        alert("Debe completar los datos de forma válida");
    }
});
    
$('#copy').click(function(){
    $('#link').select();
    document.execCommand("copy");
});

function verificarCampos(){
    return (camposVacios() && camposErrores());
}

function camposVacios(){
    var val = true;
    $('form input[type=text]').each(function(){
        if(!$(this).val() && $(this).attr("id") != 'nuevo_monto'){
            $(this).addClass('error');
            val = false;
        }
    });
    $('form textarea').each(function(){
        if(!$(this).val()){
            $(this).addClass('error');
            val = false;
        }
    });
    return val;
}

function camposErrores(){
    var val = true;
    $('form input[type=text]').each(function(){
        if($(this).attr("class").includes('error')){
            val = false;
        }
    });
    $('form textarea').each(function(){
        if($(this).attr("class").includes('error')){
            val = false;
        }
    });
    return val;
}

function limpiarCampos(){
    $('form input[type=text]').each(function(){
        $(this).val("");
    });
    $('form textarea').each(function(){
        $(this).val("");
    });
    $('#descuento').val("0");
    $('#link').val("");
}

function limpiarErrores(){
    $('form input[type=text]').each(function(){
        if($(this).attr("class").includes('error')){
            $(this).removeClass('error');
        }
    });
    $('form textarea').each(function(){
        if($(this).attr("class").includes('error')){
            $(this).removeClass('error');
        }
    });
}

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
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

function validarRUT(){
    var rut = $('#rut').val();
    if(rut.length == 11 || rut.length == 12){
        var split = rut.split('-');
        var rut   = split[0];
        var digv  = split[1];
        while(rut.includes('.')){
            rut = rut.replace('.', '');
        }
        var i      = rut.length;
        var j      = 2;
        var serieA = 0;
        while(i > 0){
            serieA += rut.substring(i - 1, i) * j;
            i--;
            if(j < 7){
                j++;
            }
            else{
                j = 2;
            }   
        }
        var serieB = Math.trunc(serieA/11);
        serieB *= 11;
        var dig = Math.abs(serieA - serieB);
        dig = 11 - dig;
        if(dig == 11){
            dig = 0;
        }
        else if(dig == 10){
            dig = 'K';
        }
        if(dig == digv){
            return true;
        }
        else{
            return false;
        } 
    }
    else{
        return false;
    }
}

function registrarCliente(){
    var clase         = $('#clase').children('option:selected').val();
    var nombre        = $('#nombre').val();
    var apellido_p    = $('#apellido_p').val();
    var apellido_m    = $('#apellido_m').val();
    var rut           = $('#rut').val();
    var email         = $('#email').val();
    var telefono      = $('#telefono').val();
    var meses         = $('#meses').val();
    var monto         = $('#monto').val();
    while(monto.includes('.')){
        monto = monto.replace('.', '');
    }
    var nuevo_monto   = $('#nuevo_monto').val();
    while(nuevo_monto.includes('.')){
        nuevo_monto = nuevo_monto.replace('.', '');
    }
    var descuento     = (monto * meses) - nuevo_monto;
    var observaciones = $('#observaciones').val();
    var factura       = $('#factura').val();
    var split         = factura.split('-');
    factura           = split[2] + '-' + split[1] + '-' + split[0];
    var userid        = $('#userid').text();
    
    //alert("clase: " + clase + ", nombre: " + nombre + ", apellido p: " + apellido_p + ", apellido m: " + apellido_m + ", rut: " + rut + ", email: " + email + ", telefono: " + telefono + ", monto: " + monto + ", descuento: " + descuento + ", nuevo monto: " + nuevo_monto);
    
    $.ajax({
        url: 'config/ajax.php',
        type: 'POST',
        data: {function:     'registrarCliente', 
               clase:         clase,
               nombre:        nombre,
               apellido_p:    apellido_p,
               apellido_m:    apellido_m,
               rut:           rut,
               email:         email,
               telefono:      telefono,
               meses:         meses,
               monto:         monto,
               descuento:     descuento,
               nuevo_monto:   nuevo_monto,
               observaciones: observaciones,
               factura:       factura,
               userid:        userid},
        success: function(data){
            if(data){
                setLink(data);
            }
            else{
                alert("ERROR DE REGISTRO");
            }
        }
    });
}

function setLink(pagos){
    $.ajax({
        url: 'config/ajax.php',
        type: 'POST',
        data: {function: 'getUsername', 
               pagos:     pagos},
        success: function(data){   
            if(data){
                var username = data;
                $('#link').val("https://planes.rest911.cl/reg.php?id=" + username);
            }
            else{
                alert("ERROR DE REGISTRO");
            }
        }
    });
}