"use strict";function vald(){return!!document.getElementById("num_benef").value}function update(){StepActive&&circles.forEach(function(e,t){t<currentActive?(e.classList.add("active"),stepContainer.hide(),$(".container-items-step[data-id="+t+"]").show(),1==t?($("#step_2_btn").show(),$("#cont_benef").show()):($("#step_2_btn").hide(),$("#cont_benef").hide())):e.classList.remove("active")});var e=document.querySelectorAll(".active");progress.style.width=(e.length-1)/(circles.length-1)*100+"%"}function isMobileDevice(){return void 0!==window.orientation||-1!==navigator.userAgent.indexOf("IEMobile")}function crear_select(){for(var e=document.querySelectorAll("[data-mate-select='active']"),t="",r=0;r<e.length;r++){e[r].setAttribute("data-indx-select",r),e[r].setAttribute("data-selec-open","false");var c=document.querySelectorAll("[data-indx-select='"+r+"'] > .cont_list_select_mate > ul");t=document.querySelectorAll("[data-indx-select='"+r+"'] >select")[0],isMobileDevice()&&t.addEventListener("change",function(){_select_option(t.selectedIndex,r)});var n=t.options;document.querySelectorAll("[data-indx-select='"+r+"']  > .selecionado_opcion ")[0].setAttribute("data-n-select",r),document.querySelectorAll("[data-indx-select='"+r+"']  > .icon_select_mate ")[0].setAttribute("data-n-select",r);for(var l=0;l<n.length;l++)li[l]=document.createElement("li"),1!=n[l].selected&&t.value!=n[l].innerHTML||(li[l].className="active",document.querySelector("[data-indx-select='"+r+"']  > .selecionado_opcion ").innerHTML=n[l].innerHTML),li[l].setAttribute("data-index",l),li[l].setAttribute("data-selec-index",r),li[l].addEventListener("click",function(){_select_option(this.getAttribute("data-index"),this.getAttribute("data-selec-index"))}),li[l].innerHTML=n[l].innerHTML,c[0].appendChild(li[l])}}function open_select(e){var t=e.getAttribute("data-n-select"),r=document.querySelectorAll("[data-indx-select='"+t+"'] .cont_select_int > li"),c=0,n=document.querySelectorAll("[data-indx-select='"+t+"']")[0].getAttribute("data-selec-open"),l=document.querySelectorAll("[data-indx-select='"+t+"'] select")[0];if(isMobileDevice())if(window.document.createEvent){var a=window.document.createEvent("MouseEvents");a.initMouseEvent("mousedown",!1,!0,window,0,0,0,0,0,!1,!1,!1,!1,0,null),l.dispatchEvent(a)}else l.fireEvent?l.fireEvent("onmousedown"):l.click();else{for(var i=0;i<r.length;i++)c+=r[i].offsetHeight;"false"==n?(document.querySelectorAll("[data-indx-select='"+t+"']")[0].setAttribute("data-selec-open","true"),document.querySelectorAll("[data-indx-select='"+t+"'] > .cont_list_select_mate > ul")[0].style.height=c+"px",document.querySelectorAll("[data-indx-select='"+t+"'] > .icon_select_mate")[0].style.transform="rotate(180deg)"):(document.querySelectorAll("[data-indx-select='"+t+"']")[0].setAttribute("data-selec-open","false"),document.querySelectorAll("[data-indx-select='"+t+"'] > .icon_select_mate")[0].style.transform="rotate(0deg)",document.querySelectorAll("[data-indx-select='"+t+"'] > .cont_list_select_mate > ul")[0].style.height="0px")}}function salir_select(e){document.querySelectorAll("[data-indx-select='"+e+"'] > select")[0];document.querySelectorAll("[data-indx-select='"+e+"'] > .cont_list_select_mate > ul")[0].style.height="0px",document.querySelector("[data-indx-select='"+e+"'] > .icon_select_mate").style.transform="rotate(0deg)",document.querySelectorAll("[data-indx-select='"+e+"']")[0].setAttribute("data-selec-open","false")}function _select_option(e,t){isMobileDevice()&&(t-=1);for(var r=document.querySelectorAll("[data-indx-select='"+t+"'] > select")[0],c=document.querySelectorAll("[data-indx-select='"+t+"'] .cont_select_int > li"),n=(document.querySelectorAll("[data-indx-select='"+t+"'] > .selecionado_opcion")[0].innerHTML=c[e].innerHTML,document.querySelectorAll("[data-indx-select='"+t+"'] > select > option")),l=0;l<c.length;l++)"active"==c[l].className&&(c[l].className=""),c[e].className="active";n[e].selected=!0,r.selectedIndex=e,r.onchange(),salir_select(t)}function revisarDigito(e){var t=e+"";return"0"==t||"1"==t||"2"==t||"3"==t||"4"==t||"5"==t||"6"==t||"7"==t||"8"==t||"9"==t||"k"==t||"K"==t||(alert("Debe ingresar un digito verificador valido"),!1)}function revisarDigito2(e){var t=e.length;if(t<2)return alert("Debe ingresar el rut completo"),!1;if(t>2)var r=e.substring(0,t-1);else var r=e.charAt(0);var c=e.charAt(t-1);if(revisarDigito(c),null==r||null==c)return 0;for(var n="0",l=0,a=2,i=r.length-1;i>=0;i--)l+=r.charAt(i)*a,7==a?a=2:a++;var o=l%11;if(1==o)var n="k";else if(0==o)var n="0";else{var s=11-o;n=s+""}return n==c.toLowerCase()||(alert("El rut es incorrecto"),!1)}function ValidarRut(e){e=[e.slice(0,e.length-1),"-",e.slice(e.length-1)].join("");for(var t="",r=0;r<e.length;r++)" "!=e.charAt(r)&&"."!=e.charAt(r)&&"-"!=e.charAt(r)&&(t+=e.charAt(r));var e=t,c=e.length;if(c<2)return alert("Debe ingresar el rut completo"),!1;for(r=0;r<c;r++)if("0"!=e.charAt(r)&&"1"!=e.charAt(r)&&"2"!=e.charAt(r)&&"3"!=e.charAt(r)&&"4"!=e.charAt(r)&&"5"!=e.charAt(r)&&"6"!=e.charAt(r)&&"7"!=e.charAt(r)&&"8"!=e.charAt(r)&&"9"!=e.charAt(r)&&"k"!=e.charAt(r)&&"K"!=e.charAt(r))return alert("El valor ingresado no corresponde a un R.U.T valido"),!1;var n="";for(r=c-1,i=0;r>=0;r--,i++)n+=e.charAt(r);var l="";l+=n.charAt(0),l+="-";var a=0,i=0;for(r=1,i=2;r<c;r++,i++)3==a?(l+=".",i++,l+=n.charAt(r),a=1):(l+=n.charAt(r),a++);for(n="",r=l.length-1,i=0;r>=0;r--,i++)n+=l.charAt(r);return!!revisarDigito2(e)}function rutFormat(e){for(var t=e.trim(),r=0,c="",n="",l=t.length-1;l>=0;l--)c+=t.charAt(l),l==t.length-1?c+="-":3==r&&(c+=".",r=0),r++;for(var a=c.length-1;a>=0;a--)"."!=c.charAt(c.length-1)?n+=c.charAt(a):a!=c.length-1&&(n+=c.charAt(a));return n.toUpperCase()}function rutFormatBlur(e){var t=e.val();if(e.val(t.toLowerCase().replace(/[^\dk]/g,"").toUpperCase()),""!==(t=e.val())){ValidarRut(t)?e.val(rutFormat(t.toUpperCase())):e.val("")}}function goToByScroll(e){e=e.replace("link",""),$("html,body").animate({scrollTop:$("#"+e).offset().top},"slow")}var progress=document.getElementById("progress"),next=document.getElementById("next"),circles=document.querySelectorAll(".circle"),stepContainer=$(".container-items-step"),StepActive=0,currentActive=1;next.addEventListener("click",function(){currentActive++,StepActive=vald(),currentActive>circles.length&&(currentActive=circles.length),circles.forEach(function(e,t){e.classList.remove("active")}),update()}),window.onload=function(){crear_select()};var li=new Array,cont_slc=0;Number.prototype.formatNumber=function(e,t,r){var c=this,e=isNaN(e=Math.abs(e))?0:e,t=void 0==t?",":t,r=void 0==r?".":r,n=c<0?"-":"",l=String(parseInt(c=Math.abs(Number(c)||0).toFixed(e))),a=(a=l.length)>3?a%3:0;return n+(a?l.substr(0,a)+r:"")+l.substr(a).replace(/(\d{3})(?=\d)/g,"$1"+r)+(e?t+Math.abs(c-l).toFixed(e).slice(2):"")},$("body").on("blur","#rut",function(e){rutFormatBlur($(this)),$(this).keyup()}),$("#step_2_btn").click(function(){$("#titular").hide(),$("#new_benificiario").show(),$(".btn-steps").css("cssText","display:none!important")}),$(".back_to_steps").click(function(){$("#titular").show(),$(".btn-steps").css("cssText","display:flex!important"),$("#new_benificiario").hide()}),$(".items-collapse-primary").click(function(){$(this).next().toggle()}),$("#tipo_pago").change(function(){setTimeout(function(){var e=String($("#precio_sin_dscto").text());e=e.replace("$",""),e=e.replace(".","");var t=$("#tipo_pago :selected").attr("id"),r=Math.trunc(e/t);$("#text-cuota").text(r),$("#cuotas-meses").text(t)},200)}),$(".btn__table__main").click(function(e){e.preventDefault(),goToByScroll("suscribir");var t=$(this).closest(".table__pricing").find(".title__pricing").text();$("#main-text__section").text(t);var r=$(this).closest(".table__pricing").attr("for");$("."+r).click()});
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImluZGV4LmpzIl0sIm5hbWVzIjpbInZhbGQiLCJkb2N1bWVudCIsImdldEVsZW1lbnRCeUlkIiwidmFsdWUiLCJ1cGRhdGUiLCJTdGVwQWN0aXZlIiwiY2lyY2xlcyIsImZvckVhY2giLCJjaXJjbGUiLCJpZHgiLCJjdXJyZW50QWN0aXZlIiwiY2xhc3NMaXN0IiwiYWRkIiwic3RlcENvbnRhaW5lciIsImhpZGUiLCIkIiwic2hvdyIsInJlbW92ZSIsImFjdGl2ZXMiLCJxdWVyeVNlbGVjdG9yQWxsIiwicHJvZ3Jlc3MiLCJzdHlsZSIsIndpZHRoIiwibGVuZ3RoIiwiaXNNb2JpbGVEZXZpY2UiLCJ3aW5kb3ciLCJvcmllbnRhdGlvbiIsIm5hdmlnYXRvciIsInVzZXJBZ2VudCIsImluZGV4T2YiLCJjcmVhcl9zZWxlY3QiLCJkaXZfY29udF9zZWxlY3QiLCJzZWxlY3RfIiwiZSIsInNldEF0dHJpYnV0ZSIsInVsX2NvbnQiLCJhZGRFdmVudExpc3RlbmVyIiwiX3NlbGVjdF9vcHRpb24iLCJzZWxlY3RlZEluZGV4Iiwic2VsZWN0X29wdGlvbmVzIiwib3B0aW9ucyIsImkiLCJsaSIsImNyZWF0ZUVsZW1lbnQiLCJzZWxlY3RlZCIsImlubmVySFRNTCIsImNsYXNzTmFtZSIsInF1ZXJ5U2VsZWN0b3IiLCJ0aGlzIiwiZ2V0QXR0cmlidXRlIiwiYXBwZW5kQ2hpbGQiLCJvcGVuX3NlbGVjdCIsImlkeDEiLCJ1bF9jb250X2xpIiwiaGciLCJzbGVjdF9vcGVuIiwic2xlY3RfZWxlbWVudF9vcGVuIiwiY3JlYXRlRXZlbnQiLCJldnQiLCJpbml0TW91c2VFdmVudCIsImRpc3BhdGNoRXZlbnQiLCJmaXJlRXZlbnQiLCJjbGljayIsIm9mZnNldEhlaWdodCIsImhlaWdodCIsInRyYW5zZm9ybSIsInNhbGlyX3NlbGVjdCIsImluZHgiLCJzZWxjIiwibGlfcyIsIm9uY2hhbmdlIiwicmV2aXNhckRpZ2l0byIsImR2ciIsImR2IiwiYWxlcnQiLCJyZXZpc2FyRGlnaXRvMiIsImNydXQiLCJsYXJnbyIsInJ1dCIsInN1YnN0cmluZyIsImNoYXJBdCIsInN1bWEiLCJtdWwiLCJyZXMiLCJkdmkiLCJ0b0xvd2VyQ2FzZSIsIlZhbGlkYXJSdXQiLCJ0ZXh0byIsInNsaWNlIiwiam9pbiIsInRtcHN0ciIsImludmVydGlkbyIsImoiLCJkdGV4dG8iLCJjbnQiLCJydXRGb3JtYXQiLCJzUnV0MSIsInRyaW0iLCJuUG9zIiwic0ludmVydGlkbyIsInNSdXQiLCJ0b1VwcGVyQ2FzZSIsInJ1dEZvcm1hdEJsdXIiLCJlbGVtZW50IiwidmFsIiwicmVwbGFjZSIsImdvVG9CeVNjcm9sbCIsImlkIiwiYW5pbWF0ZSIsInNjcm9sbFRvcCIsIm9mZnNldCIsInRvcCIsIm5leHQiLCJvbmxvYWQiLCJBcnJheSIsImNvbnRfc2xjIiwiTnVtYmVyIiwicHJvdG90eXBlIiwiZm9ybWF0TnVtYmVyIiwiYyIsImQiLCJ0IiwibiIsImlzTmFOIiwiTWF0aCIsImFicyIsInVuZGVmaW5lZCIsInMiLCJTdHJpbmciLCJwYXJzZUludCIsInRvRml4ZWQiLCJzdWJzdHIiLCJvbiIsImtleXVwIiwiY3NzIiwidG9nZ2xlIiwiY2hhbmdlIiwic2V0VGltZW91dCIsInByZWNpbyIsInRleHQiLCJ4IiwiYXR0ciIsInRvdGFsIiwidHJ1bmMiLCJwcmV2ZW50RGVmYXVsdCIsImNsb3Nlc3QiLCJmaW5kIl0sIm1hcHBpbmdzIjoiWUFPQSxTQUFBQSxRQUVBLFFBREFDLFNBQUFDLGVBQUEsYUFDQUMsTUEwQkEsUUFBQUMsVUFDQUMsWUFDQUMsUUFBQUMsUUFBQSxTQUFBQyxFQUFBQyxHQUdBQSxFQUFBQyxlQUNBRixFQUFBRyxVQUFBQyxJQUFBLFVBQ0FDLGNBQUFDLE9BQ0FDLEVBQUEsaUNBQUFOLEVBQUEsS0FBQU8sT0FDQSxHQUFBUCxHQUVBTSxFQUFBLGVBQUFDLE9BQ0FELEVBQUEsZUFBQUMsU0FFQUQsRUFBQSxlQUFBRCxPQUNBQyxFQUFBLGVBQUFELFNBR0FOLEVBQUFHLFVBQUFNLE9BQUEsV0FX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LEdBQUFDLEdBQUFWLE9BQUFqSCxFQUFBLHFCQUFBNEgsT0FDQUQsR0FBQUEsRUFBQWpDLFFBQUEsSUFBQSxJQUNBaUMsRUFBQUEsRUFBQWpDLFFBQUEsSUFBQSxHQUNBLElBQUFtQyxHQUFBN0gsRUFBQSx3QkFBQThILEtBQUEsTUFDQUMsRUFBQWxCLEtBQUFtQixNQUFBTCxFQUFBRSxFQUNBN0gsR0FBQSxlQUFBNEgsS0FBQUcsR0FDQS9ILEVBQUEsaUJBQUE0SCxLQUFBQyxJQUNBLE9BY0E3SCxFQUFBLHFCQUFBK0MsTUFBQSxTQUFBN0IsR0FFQUEsRUFBQStHLGlCQUVBdEMsYUFBQSxZQUNBLElBQUFpQyxHQUFBNUgsRUFBQWlDLE1BQUFpRyxRQUFBLG1CQUFBQyxLQUFBLG1CQUFBUCxNQUNBNUgsR0FBQSx1QkFBQTRILEtBQUFBLEVBQ0EsSUFBQWhDLEdBQUE1RixFQUFBaUMsTUFBQWlHLFFBQUEsbUJBQUFKLEtBQUEsTUFDQTlILEdBQUEsSUFBQTRGLEdBQUE3QyIsImZpbGUiOiJhcHAuanMiLCJzb3VyY2VzQ29udGVudCI6WyJjb25zdCBwcm9ncmVzcyA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdwcm9ncmVzcycpXG5cbmNvbnN0IG5leHQgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbmV4dCcpXG5jb25zdCBjaXJjbGVzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmNpcmNsZScpXG5jb25zdCBzdGVwQ29udGFpbmVyID0gJCgnLmNvbnRhaW5lci1pdGVtcy1zdGVwJylcbi8vIG9yIGluIGpRdWVyeSB1c2U6IHNlbGVjdCA9IHRoaXM7XG52YXIgU3RlcEFjdGl2ZSA9IDBcbmZ1bmN0aW9uIHZhbGQoKXtcbiAgICB2YXIgc2VsZWN0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ251bV9iZW5lZicpOyBcbiAgICBpZiAoc2VsZWN0LnZhbHVlKSB7XG4gICAgLy8gdmFsdWUgaXMgc2V0IHRvIGEgdmFsaWQgb3B0aW9uLCBzbyBzdWJtaXQgZm9ybVxuICAgIHJldHVybiB0cnVlO1xuICAgIH1cbiAgICByZXR1cm4gZmFsc2U7XG59XG5sZXQgY3VycmVudEFjdGl2ZSA9IDFcblxubmV4dC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsICgpID0+IHtcbiAgY3VycmVudEFjdGl2ZSsrXG4gIFN0ZXBBY3RpdmUgPSB2YWxkKClcblxuICBpZihjdXJyZW50QWN0aXZlID4gY2lyY2xlcy5sZW5ndGgpe1xuICAgIGN1cnJlbnRBY3RpdmUgPSBjaXJjbGVzLmxlbmd0aFxuICB9XG4gIGNpcmNsZXMuZm9yRWFjaCgoY2lyY2xlLCBpZHgpID0+IHtcbiAgICBjaXJjbGUuY2xhc3NMaXN0LnJlbW92ZSgnYWN0aXZlJylcbiAgfSlcblxudXBkYXRlKClcbiAgLy9jb25zb2xlLmxvZyhjdXJyZW50QWN0aXZlKVxuXG59KVxuXG5cblxuZnVuY3Rpb24gdXBkYXRlKCl7XG4gICAgaWYgKFN0ZXBBY3RpdmUpe1xuICAgICAgICBjaXJjbGVzLmZvckVhY2goKGNpcmNsZSwgaWR4KSA9PiB7XG4gICAgICAgICAgICBcbiAgICAgICAgXG4gICAgICAgICAgICBpZiAoaWR4IDwgY3VycmVudEFjdGl2ZSkge1xuICAgICAgICAgICAgICAgIGNpcmNsZS5jbGFzc0xpc3QuYWRkKCdhY3RpdmUnKVxuICAgICAgICAgICAgICAgIHN0ZXBDb250YWluZXIuaGlkZSgpXG4gICAgICAgICAgICAgICAgJCgnLmNvbnRhaW5lci1pdGVtcy1zdGVwW2RhdGEtaWQ9JyArIGlkeCArICddJykuc2hvdygpXG4gICAgICAgICAgICAgICAgaWYgKGlkeCA9PSAxKXtcbiAgICAgICAgICAgICAgICAgICAgXG4gICAgICAgICAgICAgICAgJCgnI3N0ZXBfMl9idG4nKS5zaG93KClcbiAgICAgICAgICAgICAgICAkKCcjY29udF9iZW5lZicpLnNob3coKVxuICAgICAgICAgICAgICAgIH1lbHNle1xuICAgICAgICAgICAgICAgICQoJyNzdGVwXzJfYnRuJykuaGlkZSgpXG4gICAgICAgICAgICAgICAgJCgnI2NvbnRfYmVuZWYnKS5oaWRlKClcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9ZWxzZXtcbiAgICAgICAgICAgICAgICBjaXJjbGUuY2xhc3NMaXN0LnJlbW92ZSgnYWN0aXZlJylcbiAgICAgICAgICAgIFxuICAgICAgICAgICAgfVxuICAgIFxuICAgICAgICBcbiAgICB9KVxuICAgIH1lbHNle1xuICAgICAgICBcbiAgICAgICAgfVxuXG5cbiAgY29uc3QgYWN0aXZlcyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5hY3RpdmUnKVxuXG4gIHByb2dyZXNzLnN0eWxlLndpZHRoID0gKGFjdGl2ZXMubGVuZ3RoIC0gMSkgLyAoY2lyY2xlcy5sZW5ndGggLSAxKSAqIDEwMCArICclJ1xuXG5cbiAgXG59XG5cblxuLy8gU0VMRUNUIFxuXG53aW5kb3cub25sb2FkID0gZnVuY3Rpb24gKCkge1xuICAgIGNyZWFyX3NlbGVjdCgpO1xufTtcblxuZnVuY3Rpb24gaXNNb2JpbGVEZXZpY2UoKSB7XG4gICAgcmV0dXJuIHR5cGVvZiB3aW5kb3cub3JpZW50YXRpb24gIT09IFwidW5kZWZpbmVkXCIgfHwgbmF2aWdhdG9yLnVzZXJBZ2VudC5pbmRleE9mKFwiSUVNb2JpbGVcIikgIT09IC0xO1xufVxuXG52YXIgbGkgPSBuZXcgQXJyYXkoKTtcbmZ1bmN0aW9uIGNyZWFyX3NlbGVjdCgpIHtcbiAgICB2YXIgZGl2X2NvbnRfc2VsZWN0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLW1hdGUtc2VsZWN0PSdhY3RpdmUnXVwiKTtcbiAgICB2YXIgc2VsZWN0XyA9IFwiXCI7XG4gICAgZm9yICh2YXIgZSA9IDA7IGUgPCBkaXZfY29udF9zZWxlY3QubGVuZ3RoOyBlKyspIHtcbiAgICAgICAgZGl2X2NvbnRfc2VsZWN0W2VdLnNldEF0dHJpYnV0ZShcImRhdGEtaW5keC1zZWxlY3RcIiwgZSk7XG4gICAgICAgIGRpdl9jb250X3NlbGVjdFtlXS5zZXRBdHRyaWJ1dGUoXCJkYXRhLXNlbGVjLW9wZW5cIiwgXCJmYWxzZVwiKTtcbiAgICAgICAgdmFyIHVsX2NvbnQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgZSArIFwiJ10gPiAuY29udF9saXN0X3NlbGVjdF9tYXRlID4gdWxcIik7XG4gICAgICAgIHNlbGVjdF8gPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgZSArIFwiJ10gPnNlbGVjdFwiKVswXTtcbiAgICAgICAgaWYgKGlzTW9iaWxlRGV2aWNlKCkpIHtcbiAgICAgICAgICAgIHNlbGVjdF8uYWRkRXZlbnRMaXN0ZW5lcihcImNoYW5nZVwiLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgX3NlbGVjdF9vcHRpb24oc2VsZWN0Xy5zZWxlY3RlZEluZGV4LCBlKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgICAgIHZhciBzZWxlY3Rfb3B0aW9uZXMgPSBzZWxlY3RfLm9wdGlvbnM7XG4gICAgICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCJbZGF0YS1pbmR4LXNlbGVjdD0nXCIgKyBlICsgXCInXSAgPiAuc2VsZWNpb25hZG9fb3BjaW9uIFwiKVswXS5zZXRBdHRyaWJ1dGUoXCJkYXRhLW4tc2VsZWN0XCIsIGUpO1xuICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgZSArIFwiJ10gID4gLmljb25fc2VsZWN0X21hdGUgXCIpWzBdLnNldEF0dHJpYnV0ZShcImRhdGEtbi1zZWxlY3RcIiwgZSk7XG4gICAgICAgIGZvciAodmFyIGkgPSAwOyBpIDwgc2VsZWN0X29wdGlvbmVzLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgICAgICBsaVtpXSA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoXCJsaVwiKTtcbiAgICAgICAgICAgIGlmIChzZWxlY3Rfb3B0aW9uZXNbaV0uc2VsZWN0ZWQgPT0gdHJ1ZSB8fCBzZWxlY3RfLnZhbHVlID09IHNlbGVjdF9vcHRpb25lc1tpXS5pbm5lckhUTUwpIHtcbiAgICAgICAgICAgICAgICBsaVtpXS5jbGFzc05hbWUgPSBcImFjdGl2ZVwiO1xuICAgICAgICAgICAgICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoXCJbZGF0YS1pbmR4LXNlbGVjdD0nXCIgKyBlICsgXCInXSAgPiAuc2VsZWNpb25hZG9fb3BjaW9uIFwiKS5pbm5lckhUTUwgPSBzZWxlY3Rfb3B0aW9uZXNbaV0uaW5uZXJIVE1MO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgbGlbaV0uc2V0QXR0cmlidXRlKFwiZGF0YS1pbmRleFwiLCBpKTtcbiAgICAgICAgICAgIGxpW2ldLnNldEF0dHJpYnV0ZShcImRhdGEtc2VsZWMtaW5kZXhcIiwgZSk7XG4gICAgICAgICAgICAvLyBmdW5jaW9uIGNsaWNrIGFsIHNlbGVjaW9uYXJcbiAgICAgICAgICAgIGxpW2ldLmFkZEV2ZW50TGlzdGVuZXIoXCJjbGlja1wiLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgX3NlbGVjdF9vcHRpb24odGhpcy5nZXRBdHRyaWJ1dGUoXCJkYXRhLWluZGV4XCIpLCB0aGlzLmdldEF0dHJpYnV0ZShcImRhdGEtc2VsZWMtaW5kZXhcIikpO1xuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgIGxpW2ldLmlubmVySFRNTCA9IHNlbGVjdF9vcHRpb25lc1tpXS5pbm5lckhUTUw7XG4gICAgICAgICAgICB1bF9jb250WzBdLmFwcGVuZENoaWxkKGxpW2ldKTtcbiAgICAgICAgfSAvLyBGaW4gRm9yIHNlbGVjdF9vcHRpb25lc1xuICAgIH0gLy8gZmluIGZvciBkaXZzX2NvbnRfc2VsZWN0XG59IC8vIEZpbiBGdW5jdGlvblxuXG52YXIgY29udF9zbGMgPSAwO1xuZnVuY3Rpb24gb3Blbl9zZWxlY3QoaWR4KSB7XG4gICAgdmFyIGlkeDEgPSBpZHguZ2V0QXR0cmlidXRlKFwiZGF0YS1uLXNlbGVjdFwiKTtcbiAgICB2YXIgdWxfY29udF9saSA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCJbZGF0YS1pbmR4LXNlbGVjdD0nXCIgKyBpZHgxICsgXCInXSAuY29udF9zZWxlY3RfaW50ID4gbGlcIik7XG4gICAgdmFyIGhnID0gMDtcbiAgICB2YXIgc2xlY3Rfb3BlbiA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCJbZGF0YS1pbmR4LXNlbGVjdD0nXCIgKyBpZHgxICsgXCInXVwiKVswXS5nZXRBdHRyaWJ1dGUoXCJkYXRhLXNlbGVjLW9wZW5cIik7XG4gICAgdmFyIHNsZWN0X2VsZW1lbnRfb3BlbiA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCJbZGF0YS1pbmR4LXNlbGVjdD0nXCIgKyBpZHgxICsgXCInXSBzZWxlY3RcIilbMF07XG4gICAgaWYgKGlzTW9iaWxlRGV2aWNlKCkpIHtcbiAgICAgICAgaWYgKHdpbmRvdy5kb2N1bWVudC5jcmVhdGVFdmVudCkge1xuICAgICAgICAgICAgLy8gQWxsXG4gICAgICAgICAgICB2YXIgZXZ0ID0gd2luZG93LmRvY3VtZW50LmNyZWF0ZUV2ZW50KFwiTW91c2VFdmVudHNcIik7XG4gICAgICAgICAgICBldnQuaW5pdE1vdXNlRXZlbnQoXCJtb3VzZWRvd25cIiwgZmFsc2UsIHRydWUsIHdpbmRvdywgMCwgMCwgMCwgMCwgMCwgZmFsc2UsIGZhbHNlLCBmYWxzZSwgZmFsc2UsIDAsIG51bGwpO1xuICAgICAgICAgICAgc2xlY3RfZWxlbWVudF9vcGVuLmRpc3BhdGNoRXZlbnQoZXZ0KTtcbiAgICAgICAgfSBlbHNlIGlmIChzbGVjdF9lbGVtZW50X29wZW4uZmlyZUV2ZW50KSB7XG4gICAgICAgICAgICAvLyBJRVxuICAgICAgICAgICAgc2xlY3RfZWxlbWVudF9vcGVuLmZpcmVFdmVudChcIm9ubW91c2Vkb3duXCIpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgc2xlY3RfZWxlbWVudF9vcGVuLmNsaWNrKCk7XG4gICAgICAgIH1cbiAgICB9IGVsc2Uge1xuICAgICAgICBmb3IgKHZhciBpID0gMDsgaSA8IHVsX2NvbnRfbGkubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgICAgIGhnICs9IHVsX2NvbnRfbGlbaV0ub2Zmc2V0SGVpZ2h0O1xuICAgICAgICB9XG4gICAgICAgIGlmIChzbGVjdF9vcGVuID09IFwiZmFsc2VcIikge1xuICAgICAgICAgICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLWluZHgtc2VsZWN0PSdcIiArIGlkeDEgKyBcIiddXCIpWzBdLnNldEF0dHJpYnV0ZShcImRhdGEtc2VsZWMtb3BlblwiLCBcInRydWVcIik7XG4gICAgICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgaWR4MSArIFwiJ10gPiAuY29udF9saXN0X3NlbGVjdF9tYXRlID4gdWxcIilbMF0uc3R5bGUuaGVpZ2h0ID0gaGcgKyBcInB4XCI7XG4gICAgICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgaWR4MSArIFwiJ10gPiAuaWNvbl9zZWxlY3RfbWF0ZVwiKVswXS5zdHlsZS50cmFuc2Zvcm0gPSBcInJvdGF0ZSgxODBkZWcpXCI7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgaWR4MSArIFwiJ11cIilbMF0uc2V0QXR0cmlidXRlKFwiZGF0YS1zZWxlYy1vcGVuXCIsIFwiZmFsc2VcIik7XG4gICAgICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgaWR4MSArIFwiJ10gPiAuaWNvbl9zZWxlY3RfbWF0ZVwiKVswXS5zdHlsZS50cmFuc2Zvcm0gPSBcInJvdGF0ZSgwZGVnKVwiO1xuICAgICAgICAgICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLWluZHgtc2VsZWN0PSdcIiArIGlkeDEgKyBcIiddID4gLmNvbnRfbGlzdF9zZWxlY3RfbWF0ZSA+IHVsXCIpWzBdLnN0eWxlLmhlaWdodCA9IFwiMHB4XCI7XG4gICAgICAgIH1cbiAgICB9XG59IC8vIGZpbiBmdW5jdGlvbiBvcGVuX3NlbGVjdFxuXG5mdW5jdGlvbiBzYWxpcl9zZWxlY3QoaW5keCkge1xuICAgIHZhciBzZWxlY3RfID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLWluZHgtc2VsZWN0PSdcIiArIGluZHggKyBcIiddID4gc2VsZWN0XCIpWzBdO1xuICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCJbZGF0YS1pbmR4LXNlbGVjdD0nXCIgKyBpbmR4ICsgXCInXSA+IC5jb250X2xpc3Rfc2VsZWN0X21hdGUgPiB1bFwiKVswXS5zdHlsZS5oZWlnaHQgPSBcIjBweFwiO1xuICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoXCJbZGF0YS1pbmR4LXNlbGVjdD0nXCIgKyBpbmR4ICsgXCInXSA+IC5pY29uX3NlbGVjdF9tYXRlXCIpLnN0eWxlLnRyYW5zZm9ybSA9IFwicm90YXRlKDBkZWcpXCI7XG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLWluZHgtc2VsZWN0PSdcIiArIGluZHggKyBcIiddXCIpWzBdLnNldEF0dHJpYnV0ZShcImRhdGEtc2VsZWMtb3BlblwiLCBcImZhbHNlXCIpO1xufVxuXG5mdW5jdGlvbiBfc2VsZWN0X29wdGlvbihpbmR4LCBzZWxjKSB7XG4gICAgaWYgKGlzTW9iaWxlRGV2aWNlKCkpIHtcbiAgICAgICAgc2VsYyA9IHNlbGMgLSAxO1xuICAgIH1cbiAgICB2YXIgc2VsZWN0XyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCJbZGF0YS1pbmR4LXNlbGVjdD0nXCIgKyBzZWxjICsgXCInXSA+IHNlbGVjdFwiKVswXTtcblxuICAgIHZhciBsaV9zID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLWluZHgtc2VsZWN0PSdcIiArIHNlbGMgKyBcIiddIC5jb250X3NlbGVjdF9pbnQgPiBsaVwiKTtcbiAgICB2YXIgcF9hY3QgPSAoZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLWluZHgtc2VsZWN0PSdcIiArIHNlbGMgKyBcIiddID4gLnNlbGVjaW9uYWRvX29wY2lvblwiKVswXS5pbm5lckhUTUwgPSBsaV9zW2luZHhdLmlubmVySFRNTCk7XG4gICAgdmFyIHNlbGVjdF9vcHRpb25lcyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCJbZGF0YS1pbmR4LXNlbGVjdD0nXCIgKyBzZWxjICsgXCInXSA+IHNlbGVjdCA+IG9wdGlvblwiKTtcbiAgICBmb3IgKHZhciBpID0gMDsgaSA8IGxpX3MubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgaWYgKGxpX3NbaV0uY2xhc3NOYW1lID09IFwiYWN0aXZlXCIpIHtcbiAgICAgICAgICAgIGxpX3NbaV0uY2xhc3NOYW1lID0gXCJcIjtcbiAgICAgICAgfVxuICAgICAgICBsaV9zW2luZHhdLmNsYXNzTmFtZSA9IFwiYWN0aXZlXCI7XG4gICAgfVxuICAgIHNlbGVjdF9vcHRpb25lc1tpbmR4XS5zZWxlY3RlZCA9IHRydWU7XG4gICAgc2VsZWN0Xy5zZWxlY3RlZEluZGV4ID0gaW5keDtcbiAgICBzZWxlY3RfLm9uY2hhbmdlKCk7XG4gICAgc2FsaXJfc2VsZWN0KHNlbGMpO1xufVxuXG5cbmZ1bmN0aW9uIHJldmlzYXJEaWdpdG8oZHZyKSB7XG4gICAgdmFyIGR2ID0gZHZyICsgXCJcIlxuICAgIGlmIChkdiAhPSAnMCcgJiYgZHYgIT0gJzEnICYmIGR2ICE9ICcyJyAmJiBkdiAhPSAnMycgJiYgZHYgIT0gJzQnICYmIGR2ICE9ICc1JyAmJiBkdiAhPSAnNicgJiYgZHYgIT0gJzcnICYmIGR2ICE9ICc4JyAmJiBkdiAhPSAnOScgJiYgZHYgIT0gJ2snICYmIGR2ICE9ICdLJykge1xuICAgICAgICBhbGVydCgnRGViZSBpbmdyZXNhciB1biBkaWdpdG8gdmVyaWZpY2Fkb3IgdmFsaWRvJyk7XG4gICAgICAgIHJldHVybiBmYWxzZTtcbiAgICB9XG4gICAgcmV0dXJuIHRydWU7XG59XG5cbmZ1bmN0aW9uIHJldmlzYXJEaWdpdG8yKGNydXQpIHtcbiAgICB2YXIgbGFyZ28gPSBjcnV0Lmxlbmd0aDtcbiAgICBpZiAobGFyZ28gPCAyKSB7XG4gICAgICAgIGFsZXJ0KCdEZWJlIGluZ3Jlc2FyIGVsIHJ1dCBjb21wbGV0bycpXG4gICAgICAgIHJldHVybiBmYWxzZTtcbiAgICB9XG4gICAgaWYgKGxhcmdvID4gMilcbiAgICAgICAgdmFyIHJ1dCA9IGNydXQuc3Vic3RyaW5nKDAsIGxhcmdvIC0gMSk7XG4gICAgZWxzZVxuICAgICAgIHZhciBydXQgPSBjcnV0LmNoYXJBdCgwKTtcbiAgICB2YXIgZHYgPSBjcnV0LmNoYXJBdChsYXJnbyAtIDEpO1xuICAgIHJldmlzYXJEaWdpdG8oZHYpO1xuXG4gICAgaWYgKHJ1dCA9PSBudWxsIHx8IGR2ID09IG51bGwpXG4gICAgICAgIHJldHVybiAwXG5cbiAgICB2YXIgZHZyID0gJzAnXG4gICAgdmFyIHN1bWEgPSAwXG4gICAgdmFyIG11bCA9IDJcblxuICAgIGZvciAodmFyIGkgPSBydXQubGVuZ3RoIC0gMTsgaSA+PSAwOyBpLS0pIHtcbiAgICAgICAgc3VtYSA9IHN1bWEgKyBydXQuY2hhckF0KGkpICogbXVsXG4gICAgICAgIGlmIChtdWwgPT0gNylcbiAgICAgICAgICAgIG11bCA9IDJcbiAgICAgICAgZWxzZVxuICAgICAgICAgICAgbXVsKytcbiAgICB9XG4gICAgdmFyIHJlcyA9IHN1bWEgJSAxMVxuICAgIGlmIChyZXMgPT0gMSlcbiAgICAgICAgdmFyIGR2ciA9ICdrJ1xuICAgIGVsc2UgaWYgKHJlcyA9PSAwKVxuICAgICAgICB2YXIgZHZyID0gJzAnXG4gICAgZWxzZSB7XG4gICAgICAgIHZhciBkdmkgPSAxMSAtIHJlc1xuICAgICAgICBkdnIgPSBkdmkgKyBcIlwiXG4gICAgfVxuICAgIGlmIChkdnIgIT0gZHYudG9Mb3dlckNhc2UoKSkge1xuICAgICAgICBhbGVydCgnRWwgcnV0IGVzIGluY29ycmVjdG8nKVxuICAgICAgICByZXR1cm4gZmFsc2VcbiAgICB9XG5cbiAgICByZXR1cm4gdHJ1ZVxufVxuXG5mdW5jdGlvbiBWYWxpZGFyUnV0KHRleHRvKSB7XG4gICAgdGV4dG8gPSBbdGV4dG8uc2xpY2UoMCwgdGV4dG8ubGVuZ3RoIC0gMSksICctJywgdGV4dG8uc2xpY2UodGV4dG8ubGVuZ3RoIC0gMSldLmpvaW4oJycpO1xuICAgIHZhciB0bXBzdHIgPSBcIlwiO1xuICAgIGZvciAodmFyIGkgPSAwOyBpIDwgdGV4dG8ubGVuZ3RoOyBpKyspXG4gICAgICAgIGlmICh0ZXh0by5jaGFyQXQoaSkgIT0gJyAnICYmIHRleHRvLmNoYXJBdChpKSAhPSAnLicgJiYgdGV4dG8uY2hhckF0KGkpICE9ICctJylcbiAgICAgICAgICAgIHRtcHN0ciA9IHRtcHN0ciArIHRleHRvLmNoYXJBdChpKTtcbiAgICB2YXIgdGV4dG8gPSB0bXBzdHI7XG4gICAgdmFyIGxhcmdvID0gdGV4dG8ubGVuZ3RoO1xuXG4gICAgaWYgKGxhcmdvIDwgMikge1xuICAgICAgICBhbGVydCgnRGViZSBpbmdyZXNhciBlbCBydXQgY29tcGxldG8nKVxuICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgfVxuXG4gICAgZm9yIChpID0gMDsgaSA8IGxhcmdvOyBpKyspIHtcbiAgICAgICAgaWYgKHRleHRvLmNoYXJBdChpKSAhPSBcIjBcIiAmJiB0ZXh0by5jaGFyQXQoaSkgIT0gXCIxXCIgJiYgdGV4dG8uY2hhckF0KGkpICE9IFwiMlwiICYmIHRleHRvLmNoYXJBdChpKSAhPSBcIjNcIiAmJiB0ZXh0by5jaGFyQXQoaSkgIT0gXCI0XCIgJiYgdGV4dG8uY2hhckF0KGkpICE9IFwiNVwiICYmIHRleHRvLmNoYXJBdChpKSAhPSBcIjZcIiAmJiB0ZXh0by5jaGFyQXQoaSkgIT0gXCI3XCIgJiYgdGV4dG8uY2hhckF0KGkpICE9IFwiOFwiICYmIHRleHRvLmNoYXJBdChpKSAhPSBcIjlcIiAmJiB0ZXh0by5jaGFyQXQoaSkgIT0gXCJrXCIgJiYgdGV4dG8uY2hhckF0KGkpICE9IFwiS1wiKSB7XG4gICAgICAgICAgICBhbGVydCgnRWwgdmFsb3IgaW5ncmVzYWRvIG5vIGNvcnJlc3BvbmRlIGEgdW4gUi5VLlQgdmFsaWRvJyk7XG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICB2YXIgaW52ZXJ0aWRvID0gXCJcIjtcbiAgICBmb3IgKGkgPSAobGFyZ28gLSAxKSwgaiA9IDA7IGkgPj0gMDsgaS0tLCBqKyspXG4gICAgICAgIGludmVydGlkbyA9IGludmVydGlkbyArIHRleHRvLmNoYXJBdChpKTtcbiAgICB2YXIgZHRleHRvID0gXCJcIjtcbiAgICBkdGV4dG8gPSBkdGV4dG8gKyBpbnZlcnRpZG8uY2hhckF0KDApO1xuICAgIGR0ZXh0byA9IGR0ZXh0byArICctJztcbiAgICB2YXIgY250ID0gMDtcbiAgICB2YXIgaiA9IDBcbiAgICBmb3IgKGkgPSAxLCBqID0gMjsgaSA8IGxhcmdvOyBpKyssIGorKykge1xuICAgICAgICAvL2FsZXJ0KFwiaT1bXCIgKyBpICsgXCJdIGo9W1wiICsgaiArXCJdXCIgKTtcbiAgICAgICAgaWYgKGNudCA9PSAzKSB7XG4gICAgICAgICAgICBkdGV4dG8gPSBkdGV4dG8gKyAnLic7XG4gICAgICAgICAgICBqKys7XG4gICAgICAgICAgICBkdGV4dG8gPSBkdGV4dG8gKyBpbnZlcnRpZG8uY2hhckF0KGkpO1xuICAgICAgICAgICAgY250ID0gMTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIGR0ZXh0byA9IGR0ZXh0byArIGludmVydGlkby5jaGFyQXQoaSk7XG4gICAgICAgICAgICBjbnQrKztcbiAgICAgICAgfVxuICAgIH1cblxuICAgIGludmVydGlkbyA9IFwiXCI7XG4gICAgZm9yIChpID0gKGR0ZXh0by5sZW5ndGggLSAxKSwgaiA9IDA7IGkgPj0gMDsgaS0tLCBqKyspXG4gICAgICAgIGludmVydGlkbyA9IGludmVydGlkbyArIGR0ZXh0by5jaGFyQXQoaSk7XG5cbiAgICAvLyQoJ1tpZCQ9X3J1dF0nKS52YWwoaW52ZXJ0aWRvLnRvVXBwZXJDYXNlKCkpO1xuXG4gICAgaWYgKHJldmlzYXJEaWdpdG8yKHRleHRvKSlcbiAgICAgICAgcmV0dXJuIHRydWU7XG5cbiAgICByZXR1cm4gZmFsc2U7XG59XG5cbmZ1bmN0aW9uIHJ1dEZvcm1hdCh2YWx1ZSkge1xuICAgIHZhciBzUnV0MSA9IHZhbHVlLnRyaW0oKTtcbiAgICB2YXIgblBvcyA9IDA7XG4gICAgdmFyIHNJbnZlcnRpZG8gPSBcIlwiO1xuICAgIHZhciBzUnV0ID0gXCJcIjtcbiAgICBmb3IgKHZhciBpID0gc1J1dDEubGVuZ3RoIC0gMTsgaSA+PSAwOyBpLS0pIHtcbiAgICAgICAgc0ludmVydGlkbyArPSBzUnV0MS5jaGFyQXQoaSk7XG4gICAgICAgIGlmIChpID09IHNSdXQxLmxlbmd0aCAtIDEpXG4gICAgICAgICAgICBzSW52ZXJ0aWRvICs9IFwiLVwiO1xuICAgICAgICBlbHNlIGlmIChuUG9zID09IDMpIHtcbiAgICAgICAgICAgIHNJbnZlcnRpZG8gKz0gXCIuXCI7XG4gICAgICAgICAgICBuUG9zID0gMDtcbiAgICAgICAgfVxuICAgICAgICBuUG9zKys7XG4gICAgfVxuICAgIGZvciAodmFyIGogPSBzSW52ZXJ0aWRvLmxlbmd0aCAtIDE7IGogPj0gMDsgai0tKSB7XG4gICAgICAgIGlmIChzSW52ZXJ0aWRvLmNoYXJBdChzSW52ZXJ0aWRvLmxlbmd0aCAtIDEpICE9IFwiLlwiKVxuICAgICAgICAgICAgc1J1dCArPSBzSW52ZXJ0aWRvLmNoYXJBdChqKTtcbiAgICAgICAgZWxzZSBpZiAoaiAhPSBzSW52ZXJ0aWRvLmxlbmd0aCAtIDEpXG4gICAgICAgICAgICBzUnV0ICs9IHNJbnZlcnRpZG8uY2hhckF0KGopO1xuXG4gICAgfVxuICAgIHJldHVybiBzUnV0LnRvVXBwZXJDYXNlKCk7XG59XG5cbk51bWJlci5wcm90b3R5cGUuZm9ybWF0TnVtYmVyID0gZnVuY3Rpb24gKGMsIGQsIHQpIHtcbiAgICB2YXIgbiA9IHRoaXMsXG4gICAgICAgIGMgPSBpc05hTihjID0gTWF0aC5hYnMoYykpID8gMCA6IGMsXG4gICAgICAgIGQgPSBkID09IHVuZGVmaW5lZCA/IFwiLFwiIDogZCxcbiAgICAgICAgdCA9IHQgPT0gdW5kZWZpbmVkID8gXCIuXCIgOiB0LFxuICAgICAgICBzID0gbiA8IDAgPyBcIi1cIiA6IFwiXCIsXG4gICAgICAgIGkgPSBTdHJpbmcocGFyc2VJbnQobiA9IE1hdGguYWJzKE51bWJlcihuKSB8fCAwKS50b0ZpeGVkKGMpKSksXG4gICAgICAgIGogPSAoaiA9IGkubGVuZ3RoKSA+IDMgPyBqICUgMyA6IDA7XG4gICAgcmV0dXJuIHMgKyAoaiA/IGkuc3Vic3RyKDAsIGopICsgdCA6IFwiXCIpICsgaS5zdWJzdHIoaikucmVwbGFjZSgvKFxcZHszfSkoPz1cXGQpL2csIFwiJDFcIiArIHQpICsgKGMgPyBkICsgTWF0aC5hYnMobiAtIGkpLnRvRml4ZWQoYykuc2xpY2UoMikgOiBcIlwiKTtcbn07XG5cbiQoJ2JvZHknKS5vbignYmx1cicsICcjcnV0JywgZnVuY3Rpb24gKGUpIHtcbiAgICBydXRGb3JtYXRCbHVyKCQodGhpcykpO1xuICAgICQodGhpcykua2V5dXAoKTtcblxufSk7XG5cbmZ1bmN0aW9uIHJ1dEZvcm1hdEJsdXIoZWxlbWVudClcbntcbiAgICB2YXIgdmFsID0gZWxlbWVudC52YWwoKTtcbiAgICAvL2VsZW1lbnQudmFsKHJ1dEZvcm1hdChlbGVtZW50LnZhbCgpLnRvVXBwZXJDYXNlKCkpKTtcbiAgICBlbGVtZW50LnZhbCh2YWwudG9Mb3dlckNhc2UoKS5yZXBsYWNlKC9bXlxcZGtdL2csIFwiXCIpLnRvVXBwZXJDYXNlKCkpO1xuICAgIHZhbCA9IGVsZW1lbnQudmFsKCk7XG4gICAgaWYgKHZhbCAhPT0gJycpIHtcbiAgICAgICAgdmFyIHJ1dCA9IFZhbGlkYXJSdXQodmFsKTtcbiAgICAgICAgaWYgKHJ1dCkge1xuICAgICAgICAgICAgZWxlbWVudC52YWwocnV0Rm9ybWF0KHZhbC50b1VwcGVyQ2FzZSgpKSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICBlbGVtZW50LnZhbCgnJyk7XG4gICAgICAgIH1cbiAgICB9XG59XG5cbiQoJyNzdGVwXzJfYnRuJykuY2xpY2soZnVuY3Rpb24oKXtcbiAgICAkKCcjdGl0dWxhcicpLmhpZGUoKVxuICAgICQoJyNuZXdfYmVuaWZpY2lhcmlvJykuc2hvdygpXG4gICAgJCgnLmJ0bi1zdGVwcycpLmNzcygnY3NzVGV4dCcsICdkaXNwbGF5Om5vbmUhaW1wb3J0YW50Jyk7XG59KVxuXG4kKCcuYmFja190b19zdGVwcycpLmNsaWNrKGZ1bmN0aW9uKCl7XG4gICAgJCgnI3RpdHVsYXInKS5zaG93KClcbiAgICAkKCcuYnRuLXN0ZXBzJykuY3NzKCdjc3NUZXh0JywgJ2Rpc3BsYXk6ZmxleCFpbXBvcnRhbnQnKTtcbiAgICAkKCcjbmV3X2JlbmlmaWNpYXJpbycpLmhpZGUoKVxuICAgIFxufSlcblxuXG4kKCcuaXRlbXMtY29sbGFwc2UtcHJpbWFyeScpLmNsaWNrKGZ1bmN0aW9uKCl7XG4gICAgJCh0aGlzKS5uZXh0KCkudG9nZ2xlKCk7XG59KTtcblxuXG4kKCcjdGlwb19wYWdvJykuY2hhbmdlKGZ1bmN0aW9uKCl7XG4gICBzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG4gICAgICAgIHZhciBwcmVjaW8gPSBTdHJpbmcoJCgnI3ByZWNpb19zaW5fZHNjdG8nKS50ZXh0KCkpXG4gICAgICAgIHByZWNpbyAgPSBwcmVjaW8ucmVwbGFjZSgnJCcsICcnKVxuICAgICAgICBwcmVjaW8gID0gcHJlY2lvLnJlcGxhY2UoJy4nLCAnJylcbiAgICAgICAgdmFyIHggPSAkKCcjdGlwb19wYWdvIDpzZWxlY3RlZCcpLmF0dHIoJ2lkJylcbiAgICAgICAgdmFyIHRvdGFsID0gTWF0aC50cnVuYyhwcmVjaW8gLyB4KVxuICAgICAgICAkKCcjdGV4dC1jdW90YScpLnRleHQodG90YWwpXG4gICAgICAgICQoJyNjdW90YXMtbWVzZXMnKS50ZXh0KHgpXG4gICB9LCAyMDApXG59KVxuXG5cblxuZnVuY3Rpb24gZ29Ub0J5U2Nyb2xsKGlkKSB7XG4gICAgLy8gUmVtb3ZlIFwibGlua1wiIGZyb20gdGhlIElEXG4gICAgaWQgPSBpZC5yZXBsYWNlKFwibGlua1wiLCBcIlwiKTtcbiAgICAvLyBTY3JvbGxcbiAgICAkKCdodG1sLGJvZHknKS5hbmltYXRlKHtcbiAgICAgICAgc2Nyb2xsVG9wOiAkKFwiI1wiICsgaWQpLm9mZnNldCgpLnRvcFxuICAgIH0sICdzbG93Jyk7XG59XG5cbiQoXCIuYnRuX190YWJsZV9fbWFpblwiKS5jbGljayhmdW5jdGlvbihlKSB7XG4gICAgLy8gUHJldmVudCBhIHBhZ2UgcmVsb2FkIHdoZW4gYSBsaW5rIGlzIHByZXNzZWRcbiAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgLy8gQ2FsbCB0aGUgc2Nyb2xsIGZ1bmN0aW9uXG4gICAgZ29Ub0J5U2Nyb2xsKCdzdXNjcmliaXInKTtcbiAgICB2YXIgdGV4dCA9ICQodGhpcykuY2xvc2VzdCgnLnRhYmxlX19wcmljaW5nJykuZmluZCgnLnRpdGxlX19wcmljaW5nJykudGV4dCgpXG4gICAgJCgnI21haW4tdGV4dF9fc2VjdGlvbicpLnRleHQodGV4dClcbiAgICB2YXIgaWQgPSAkKHRoaXMpLmNsb3Nlc3QoJy50YWJsZV9fcHJpY2luZycpLmF0dHIoJ2ZvcicpXG4gICAgJCgnLicgKyBpZCkuY2xpY2soKVxufSk7Il19
