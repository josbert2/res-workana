const progress = document.getElementById('progress')

const next = document.getElementById('next')
const circles = document.querySelectorAll('.circle')
const stepContainer = $('.container-items-step')
// or in jQuery use: select = this;
var StepActive = 0
function vald(){
    var select = document.getElementById('num_benef'); 
    if (select.value) {
    // value is set to a valid option, so submit form
    return true;
    }
    return false;
}
let currentActive = 1

next.addEventListener('click', () => {
  currentActive++
  StepActive = vald()

  if(currentActive > circles.length){
    currentActive = circles.length
  }
  circles.forEach((circle, idx) => {
    circle.classList.remove('active')
  })

update()
  //console.log(currentActive)

})



function update(){
    if (StepActive){
        circles.forEach((circle, idx) => {
            
        
            if (idx < currentActive) {
                circle.classList.add('active')
                stepContainer.hide()
                $('.container-items-step[data-id=' + idx + ']').show()
                if (idx == 1){
                    
                $('#step_2_btn').show()
                $('#cont_benef').show()
                }else{
                $('#step_2_btn').hide()
                $('#cont_benef').hide()
                }
            }else{
                circle.classList.remove('active')
            
            }
    
        
    })
    }else{
        
        }


  const actives = document.querySelectorAll('.active')

  progress.style.width = (actives.length - 1) / (circles.length - 1) * 100 + '%'


  
}


// SELECT 

window.onload = function () {
    crear_select();
};

function isMobileDevice() {
    return typeof window.orientation !== "undefined" || navigator.userAgent.indexOf("IEMobile") !== -1;
}

var li = new Array();
function crear_select() {
    var div_cont_select = document.querySelectorAll("[data-mate-select='active']");
    var select_ = "";
    for (var e = 0; e < div_cont_select.length; e++) {
        div_cont_select[e].setAttribute("data-indx-select", e);
        div_cont_select[e].setAttribute("data-selec-open", "false");
        var ul_cont = document.querySelectorAll("[data-indx-select='" + e + "'] > .cont_list_select_mate > ul");
        select_ = document.querySelectorAll("[data-indx-select='" + e + "'] >select")[0];
        if (isMobileDevice()) {
            select_.addEventListener("change", function () {
                _select_option(select_.selectedIndex, e);
            });
        }
        var select_optiones = select_.options;
        document.querySelectorAll("[data-indx-select='" + e + "']  > .selecionado_opcion ")[0].setAttribute("data-n-select", e);
        document.querySelectorAll("[data-indx-select='" + e + "']  > .icon_select_mate ")[0].setAttribute("data-n-select", e);
        for (var i = 0; i < select_optiones.length; i++) {
            li[i] = document.createElement("li");
            if (select_optiones[i].selected == true || select_.value == select_optiones[i].innerHTML) {
                li[i].className = "active";
                document.querySelector("[data-indx-select='" + e + "']  > .selecionado_opcion ").innerHTML = select_optiones[i].innerHTML;
            }
            li[i].setAttribute("data-index", i);
            li[i].setAttribute("data-selec-index", e);
            // funcion click al selecionar
            li[i].addEventListener("click", function () {
                _select_option(this.getAttribute("data-index"), this.getAttribute("data-selec-index"));
            });

            li[i].innerHTML = select_optiones[i].innerHTML;
            ul_cont[0].appendChild(li[i]);
        } // Fin For select_optiones
    } // fin for divs_cont_select
} // Fin Function

var cont_slc = 0;
function open_select(idx) {
    var idx1 = idx.getAttribute("data-n-select");
    var ul_cont_li = document.querySelectorAll("[data-indx-select='" + idx1 + "'] .cont_select_int > li");
    var hg = 0;
    var slect_open = document.querySelectorAll("[data-indx-select='" + idx1 + "']")[0].getAttribute("data-selec-open");
    var slect_element_open = document.querySelectorAll("[data-indx-select='" + idx1 + "'] select")[0];
    if (isMobileDevice()) {
        if (window.document.createEvent) {
            // All
            var evt = window.document.createEvent("MouseEvents");
            evt.initMouseEvent("mousedown", false, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
            slect_element_open.dispatchEvent(evt);
        } else if (slect_element_open.fireEvent) {
            // IE
            slect_element_open.fireEvent("onmousedown");
        } else {
            slect_element_open.click();
        }
    } else {
        for (var i = 0; i < ul_cont_li.length; i++) {
            hg += ul_cont_li[i].offsetHeight;
        }
        if (slect_open == "false") {
            document.querySelectorAll("[data-indx-select='" + idx1 + "']")[0].setAttribute("data-selec-open", "true");
            document.querySelectorAll("[data-indx-select='" + idx1 + "'] > .cont_list_select_mate > ul")[0].style.height = hg + "px";
            document.querySelectorAll("[data-indx-select='" + idx1 + "'] > .icon_select_mate")[0].style.transform = "rotate(180deg)";
        } else {
            document.querySelectorAll("[data-indx-select='" + idx1 + "']")[0].setAttribute("data-selec-open", "false");
            document.querySelectorAll("[data-indx-select='" + idx1 + "'] > .icon_select_mate")[0].style.transform = "rotate(0deg)";
            document.querySelectorAll("[data-indx-select='" + idx1 + "'] > .cont_list_select_mate > ul")[0].style.height = "0px";
        }
    }
} // fin function open_select

function salir_select(indx) {
    var select_ = document.querySelectorAll("[data-indx-select='" + indx + "'] > select")[0];
    document.querySelectorAll("[data-indx-select='" + indx + "'] > .cont_list_select_mate > ul")[0].style.height = "0px";
    document.querySelector("[data-indx-select='" + indx + "'] > .icon_select_mate").style.transform = "rotate(0deg)";
    document.querySelectorAll("[data-indx-select='" + indx + "']")[0].setAttribute("data-selec-open", "false");
}

function _select_option(indx, selc) {
    if (isMobileDevice()) {
        selc = selc - 1;
    }
    var select_ = document.querySelectorAll("[data-indx-select='" + selc + "'] > select")[0];

    var li_s = document.querySelectorAll("[data-indx-select='" + selc + "'] .cont_select_int > li");
    var p_act = (document.querySelectorAll("[data-indx-select='" + selc + "'] > .selecionado_opcion")[0].innerHTML = li_s[indx].innerHTML);
    var select_optiones = document.querySelectorAll("[data-indx-select='" + selc + "'] > select > option");
    for (var i = 0; i < li_s.length; i++) {
        if (li_s[i].className == "active") {
            li_s[i].className = "";
        }
        li_s[indx].className = "active";
    }
    select_optiones[indx].selected = true;
    select_.selectedIndex = indx;
    select_.onchange();
    salir_select(selc);
}


function revisarDigito(dvr) {
    var dv = dvr + ""
    if (dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' && dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k' && dv != 'K') {
        alert('Debe ingresar un digito verificador valido');
        return false;
    }
    return true;
}

function revisarDigito2(crut) {
    var largo = crut.length;
    if (largo < 2) {
        alert('Debe ingresar el rut completo')
        return false;
    }
    if (largo > 2)
        var rut = crut.substring(0, largo - 1);
    else
       var rut = crut.charAt(0);
    var dv = crut.charAt(largo - 1);
    revisarDigito(dv);

    if (rut == null || dv == null)
        return 0

    var dvr = '0'
    var suma = 0
    var mul = 2

    for (var i = rut.length - 1; i >= 0; i--) {
        suma = suma + rut.charAt(i) * mul
        if (mul == 7)
            mul = 2
        else
            mul++
    }
    var res = suma % 11
    if (res == 1)
        var dvr = 'k'
    else if (res == 0)
        var dvr = '0'
    else {
        var dvi = 11 - res
        dvr = dvi + ""
    }
    if (dvr != dv.toLowerCase()) {
        alert('El rut es incorrecto')
        return false
    }

    return true
}

function ValidarRut(texto) {
    texto = [texto.slice(0, texto.length - 1), '-', texto.slice(texto.length - 1)].join('');
    var tmpstr = "";
    for (var i = 0; i < texto.length; i++)
        if (texto.charAt(i) != ' ' && texto.charAt(i) != '.' && texto.charAt(i) != '-')
            tmpstr = tmpstr + texto.charAt(i);
    var texto = tmpstr;
    var largo = texto.length;

    if (largo < 2) {
        alert('Debe ingresar el rut completo')
        return false;
    }

    for (i = 0; i < largo; i++) {
        if (texto.charAt(i) != "0" && texto.charAt(i) != "1" && texto.charAt(i) != "2" && texto.charAt(i) != "3" && texto.charAt(i) != "4" && texto.charAt(i) != "5" && texto.charAt(i) != "6" && texto.charAt(i) != "7" && texto.charAt(i) != "8" && texto.charAt(i) != "9" && texto.charAt(i) != "k" && texto.charAt(i) != "K") {
            alert('El valor ingresado no corresponde a un R.U.T valido');
            return false;
        }
    }

    var invertido = "";
    for (i = (largo - 1), j = 0; i >= 0; i--, j++)
        invertido = invertido + texto.charAt(i);
    var dtexto = "";
    dtexto = dtexto + invertido.charAt(0);
    dtexto = dtexto + '-';
    var cnt = 0;
    var j = 0
    for (i = 1, j = 2; i < largo; i++, j++) {
        //alert("i=[" + i + "] j=[" + j +"]" );
        if (cnt == 3) {
            dtexto = dtexto + '.';
            j++;
            dtexto = dtexto + invertido.charAt(i);
            cnt = 1;
        } else {
            dtexto = dtexto + invertido.charAt(i);
            cnt++;
        }
    }

    invertido = "";
    for (i = (dtexto.length - 1), j = 0; i >= 0; i--, j++)
        invertido = invertido + dtexto.charAt(i);

    //$('[id$=_rut]').val(invertido.toUpperCase());

    if (revisarDigito2(texto))
        return true;

    return false;
}

function rutFormat(value) {
    var sRut1 = value.trim();
    var nPos = 0;
    var sInvertido = "";
    var sRut = "";
    for (var i = sRut1.length - 1; i >= 0; i--) {
        sInvertido += sRut1.charAt(i);
        if (i == sRut1.length - 1)
            sInvertido += "-";
        else if (nPos == 3) {
            sInvertido += ".";
            nPos = 0;
        }
        nPos++;
    }
    for (var j = sInvertido.length - 1; j >= 0; j--) {
        if (sInvertido.charAt(sInvertido.length - 1) != ".")
            sRut += sInvertido.charAt(j);
        else if (j != sInvertido.length - 1)
            sRut += sInvertido.charAt(j);

    }
    return sRut.toUpperCase();
}

Number.prototype.formatNumber = function (c, d, t) {
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 0 : c,
        d = d == undefined ? "," : d,
        t = t == undefined ? "." : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

$('body').on('blur', '#rut', function (e) {
    rutFormatBlur($(this));
    $(this).keyup();

});

function rutFormatBlur(element)
{
    var val = element.val();
    //element.val(rutFormat(element.val().toUpperCase()));
    element.val(val.toLowerCase().replace(/[^\dk]/g, "").toUpperCase());
    val = element.val();
    if (val !== '') {
        var rut = ValidarRut(val);
        if (rut) {
            element.val(rutFormat(val.toUpperCase()));
        } else {
            element.val('');
        }
    }
}

$('#step_2_btn').click(function(){
    $('#titular').hide()
    $('#new_benificiario').show()
    $('.btn-steps').css('cssText', 'display:none!important');
})

$('.back_to_steps').click(function(){
    $('#titular').show()
    $('.btn-steps').css('cssText', 'display:flex!important');
    $('#new_benificiario').hide()
    
})


$('.items-collapse-primary').click(function(){
    $(this).next().toggle();
});


