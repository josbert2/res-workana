"use strict";function update(){circles.forEach(function(e,t){t<currentActive?(e.classList.add("active"),stepContainer.hide(),$(".container-items-step[data-id="+t+"]").show(),1==t?$("#step_2_btn").show():$("#step_2_btn").hide()):e.classList.remove("active")});var e=document.querySelectorAll(".active");progress.style.width=(e.length-1)/(circles.length-1)*100+"%",1===currentActive||(currentActive===circles.length?next.disabled=!0:next.disabled=!1)}function isMobileDevice(){return void 0!==window.orientation||-1!==navigator.userAgent.indexOf("IEMobile")}function crear_select(){for(var e=document.querySelectorAll("[data-mate-select='active']"),t="",r=0;r<e.length;r++){e[r].setAttribute("data-indx-select",r),e[r].setAttribute("data-selec-open","false");var c=document.querySelectorAll("[data-indx-select='"+r+"'] > .cont_list_select_mate > ul");t=document.querySelectorAll("[data-indx-select='"+r+"'] >select")[0],isMobileDevice()&&t.addEventListener("change",function(){_select_option(t.selectedIndex,r)});var l=t.options;document.querySelectorAll("[data-indx-select='"+r+"']  > .selecionado_opcion ")[0].setAttribute("data-n-select",r),document.querySelectorAll("[data-indx-select='"+r+"']  > .icon_select_mate ")[0].setAttribute("data-n-select",r);for(var n=0;n<l.length;n++)li[n]=document.createElement("li"),1!=l[n].selected&&t.value!=l[n].innerHTML||(li[n].className="active",document.querySelector("[data-indx-select='"+r+"']  > .selecionado_opcion ").innerHTML=l[n].innerHTML),li[n].setAttribute("data-index",n),li[n].setAttribute("data-selec-index",r),li[n].addEventListener("click",function(){_select_option(this.getAttribute("data-index"),this.getAttribute("data-selec-index"))}),li[n].innerHTML=l[n].innerHTML,c[0].appendChild(li[n])}}function open_select(e){var t=e.getAttribute("data-n-select"),r=document.querySelectorAll("[data-indx-select='"+t+"'] .cont_select_int > li"),c=0,l=document.querySelectorAll("[data-indx-select='"+t+"']")[0].getAttribute("data-selec-open"),n=document.querySelectorAll("[data-indx-select='"+t+"'] select")[0];if(isMobileDevice())if(window.document.createEvent){var a=window.document.createEvent("MouseEvents");a.initMouseEvent("mousedown",!1,!0,window,0,0,0,0,0,!1,!1,!1,!1,0,null),n.dispatchEvent(a)}else n.fireEvent?n.fireEvent("onmousedown"):n.click();else{for(var i=0;i<r.length;i++)c+=r[i].offsetHeight;"false"==l?(document.querySelectorAll("[data-indx-select='"+t+"']")[0].setAttribute("data-selec-open","true"),document.querySelectorAll("[data-indx-select='"+t+"'] > .cont_list_select_mate > ul")[0].style.height=c+"px",document.querySelectorAll("[data-indx-select='"+t+"'] > .icon_select_mate")[0].style.transform="rotate(180deg)"):(document.querySelectorAll("[data-indx-select='"+t+"']")[0].setAttribute("data-selec-open","false"),document.querySelectorAll("[data-indx-select='"+t+"'] > .icon_select_mate")[0].style.transform="rotate(0deg)",document.querySelectorAll("[data-indx-select='"+t+"'] > .cont_list_select_mate > ul")[0].style.height="0px")}}function salir_select(e){document.querySelectorAll("[data-indx-select='"+e+"'] > select")[0];document.querySelectorAll("[data-indx-select='"+e+"'] > .cont_list_select_mate > ul")[0].style.height="0px",document.querySelector("[data-indx-select='"+e+"'] > .icon_select_mate").style.transform="rotate(0deg)",document.querySelectorAll("[data-indx-select='"+e+"']")[0].setAttribute("data-selec-open","false")}function _select_option(e,t){isMobileDevice()&&(t-=1);for(var r=document.querySelectorAll("[data-indx-select='"+t+"'] > select")[0],c=document.querySelectorAll("[data-indx-select='"+t+"'] .cont_select_int > li"),l=(document.querySelectorAll("[data-indx-select='"+t+"'] > .selecionado_opcion")[0].innerHTML=c[e].innerHTML,document.querySelectorAll("[data-indx-select='"+t+"'] > select > option")),n=0;n<c.length;n++)"active"==c[n].className&&(c[n].className=""),c[e].className="active";l[e].selected=!0,r.selectedIndex=e,r.onchange(),salir_select(t)}function revisarDigito(e){var t=e+"";return"0"==t||"1"==t||"2"==t||"3"==t||"4"==t||"5"==t||"6"==t||"7"==t||"8"==t||"9"==t||"k"==t||"K"==t||(alert("Debe ingresar un digito verificador valido"),!1)}function revisarDigito2(e){var t=e.length;if(t<2)return alert("Debe ingresar el rut completo"),!1;if(t>2)var r=e.substring(0,t-1);else var r=e.charAt(0);var c=e.charAt(t-1);if(revisarDigito(c),null==r||null==c)return 0;for(var l="0",n=0,a=2,i=r.length-1;i>=0;i--)n+=r.charAt(i)*a,7==a?a=2:a++;var o=n%11;if(1==o)var l="k";else if(0==o)var l="0";else{var s=11-o;l=s+""}return l==c.toLowerCase()||(alert("El rut es incorrecto"),!1)}function ValidarRut(e){e=[e.slice(0,e.length-1),"-",e.slice(e.length-1)].join("");for(var t="",r=0;r<e.length;r++)" "!=e.charAt(r)&&"."!=e.charAt(r)&&"-"!=e.charAt(r)&&(t+=e.charAt(r));var e=t,c=e.length;if(c<2)return alert("Debe ingresar el rut completo"),!1;for(r=0;r<c;r++)if("0"!=e.charAt(r)&&"1"!=e.charAt(r)&&"2"!=e.charAt(r)&&"3"!=e.charAt(r)&&"4"!=e.charAt(r)&&"5"!=e.charAt(r)&&"6"!=e.charAt(r)&&"7"!=e.charAt(r)&&"8"!=e.charAt(r)&&"9"!=e.charAt(r)&&"k"!=e.charAt(r)&&"K"!=e.charAt(r))return alert("El valor ingresado no corresponde a un R.U.T valido"),!1;var l="";for(r=c-1,i=0;r>=0;r--,i++)l+=e.charAt(r);var n="";n+=l.charAt(0),n+="-";var a=0,i=0;for(r=1,i=2;r<c;r++,i++)3==a?(n+=".",i++,n+=l.charAt(r),a=1):(n+=l.charAt(r),a++);for(l="",r=n.length-1,i=0;r>=0;r--,i++)l+=n.charAt(r);return!!revisarDigito2(e)}function rutFormat(e){for(var t=e.trim(),r=0,c="",l="",n=t.length-1;n>=0;n--)c+=t.charAt(n),n==t.length-1?c+="-":3==r&&(c+=".",r=0),r++;for(var a=c.length-1;a>=0;a--)"."!=c.charAt(c.length-1)?l+=c.charAt(a):a!=c.length-1&&(l+=c.charAt(a));return l.toUpperCase()}function rutFormatBlur(e){var t=e.val();if(e.val(t.toLowerCase().replace(/[^\dk]/g,"").toUpperCase()),""!==(t=e.val())){ValidarRut(t)?e.val(rutFormat(t.toUpperCase())):e.val("")}}var progress=document.getElementById("progress"),next=document.getElementById("next"),circles=document.querySelectorAll(".circle"),stepContainer=$(".container-items-step"),currentActive=1;next.addEventListener("click",function(){currentActive++,currentActive>circles.length&&(currentActive=circles.length),circles.forEach(function(e,t){e.classList.remove("active")}),update()}),window.onload=function(){crear_select()};var li=new Array,cont_slc=0;Number.prototype.formatNumber=function(e,t,r){var c=this,e=isNaN(e=Math.abs(e))?0:e,t=void 0==t?",":t,r=void 0==r?".":r,l=c<0?"-":"",n=String(parseInt(c=Math.abs(Number(c)||0).toFixed(e))),a=(a=n.length)>3?a%3:0;return l+(a?n.substr(0,a)+r:"")+n.substr(a).replace(/(\d{3})(?=\d)/g,"$1"+r)+(e?t+Math.abs(c-n).toFixed(e).slice(2):"")},$("body").on("blur","#rut",function(e){rutFormatBlur($(this)),$(this).keyup()}),$("#step_2_btn").click(function(){$("#titular").hide(),$("#new_benificiario").show(),$(".btn-steps").css("cssText","display:none!important")}),$(".back_to_steps").click(function(){$("#titular").show(),$(".btn-steps").css("cssText","display:flex!important"),$("#new_benificiario").hide()}),$(".items-collapse-primary").click(function(){$(this).next().toggle()});
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImluZGV4LmpzIl0sIm5hbWVzIjpbInVwZGF0ZSIsImNpcmNsZXMiLCJmb3JFYWNoIiwiY2lyY2xlIiwiaWR4IiwiY3VycmVudEFjdGl2ZSIsImNsYXNzTGlzdCIsImFkZCIsInN0ZXBDb250YWluZXIiLCJoaWRlIiwiJCIsInNob3ciLCJyZW1vdmUiLCJhY3RpdmVzIiwiZG9jdW1lbnQiLCJxdWVyeVNlbGVjdG9yQWxsIiwicHJvZ3Jlc3MiLCJzdHlsZSIsIndpZHRoIiwibGVuZ3RoIiwibmV4dCIsImRpc2FibGVkIiwiaXNNb2JpbGVEZXZpY2UiLCJ3aW5kb3ciLCJvcmllbnRhdGlvbiIsIm5hdmlnYXRvciIsInVzZXJBZ2VudCIsImluZGV4T2YiLCJjcmVhcl9zZWxlY3QiLCJkaXZfY29udF9zZWxlY3QiLCJzZWxlY3RfIiwiZSIsInNldEF0dHJpYnV0ZSIsInVsX2NvbnQiLCJhZGRFdmVudExpc3RlbmVyIiwiX3NlbGVjdF9vcHRpb24iLCJzZWxlY3RlZEluZGV4Iiwic2VsZWN0X29wdGlvbmVzIiwib3B0aW9ucyIsImkiLCJsaSIsImNyZWF0ZUVsZW1lbnQiLCJzZWxlY3RlZCIsInZhbHVlIiwiaW5uZXJIVE1MIiwiY2xhc3NOYW1lIiwicXVlcnlTZWxlY3RvciIsInRoaXMiLCJnZXRBdHRyaWJ1dGUiLCJhcHBlbmRDaGlsZCIsIm9wZW5fc2VsZWN0IiwiaWR4MSIsInVsX2NvbnRfbGkiLCJoZyIsInNsZWN0X29wZW4iLCJzbGVjdF9lbGVtZW50X29wZW4iLCJjcmVhdGVFdmVudCIsImV2dCIsImluaXRNb3VzZUV2ZW50IiwiZGlzcGF0Y2hFdmVudCIsImZpcmVFdmVudCIsImNsaWNrIiwib2Zmc2V0SGVpZ2h0IiwiaGVpZ2h0IiwidHJhbnNmb3JtIiwic2FsaXJfc2VsZWN0IiwiaW5keCIsInNlbGMiLCJsaV9zIiwib25jaGFuZ2UiLCJyZXZpc2FyRGlnaXRvIiwiZHZyIiwiZHYiLCJhbGVydCIsInJldmlzYXJEaWdpdG8yIiwiY3J1dCIsImxhcmdvIiwicnV0Iiwic3Vic3RyaW5nIiwiY2hhckF0Iiwic3VtYSIsIm11bCIsInJlcyIsImR2aSIsInRvTG93ZXJDYXNlIiwiVmFsaWRhclJ1dCIsInRleHRvIiwic2xpY2UiLCJqb2luIiwidG1wc3RyIiwiaW52ZXJ0aWRvIiwiaiIsImR0ZXh0byIsImNudCIsInJ1dEZvcm1hdCIsInNSdXQxIiwidHJpbSIsIm5Qb3MiLCJzSW52ZXJ0aWRvIiwic1J1dCIsInRvVXBwZXJDYXNlIiwicnV0Rm9ybWF0Qmx1ciIsImVsZW1lbnQiLCJ2YWwiLCJyZXBsYWNlIiwiZ2V0RWxlbWVudEJ5SWQiLCJvbmxvYWQiLCJBcnJheSIsImNvbnRfc2xjIiwiTnVtYmVyIiwicHJvdG90eXBlIiwiZm9ybWF0TnVtYmVyIiwiYyIsImQiLCJ0IiwibiIsImlzTmFOIiwiTWF0aCIsImFicyIsInVuZGVmaW5lZCIsInMiLCJTdHJpbmciLCJwYXJzZUludCIsInRvRml4ZWQiLCJzdWJzdHIiLCJvbiIsImtleXVwIiwiY3NzIiwidG9nZ2xlIl0sIm1hcHBpbmdzIjoiWUEwQkEsU0FBQUEsVUFDQUMsUUFBQUMsUUFBQSxTQUFBQyxFQUFBQyxHQUVBQSxFQUFBQyxlQUNBRixFQUFBRyxVQUFBQyxJQUFBLFVBQ0FDLGNBQUFDLE9BQ0FDLEVBQUEsaUNBQUFOLEVBQUEsS0FBQU8sT0FDQSxHQUFBUCxFQUVBTSxFQUFBLGVBQUFDLE9BRUFELEVBQUEsZUFBQUQsUUFHQU4sRUFBQUcsVUFBQU0sT0FBQSxXQU1BLElBQUFDLEdBQUFDLFNBQUFDLGlCQUFBLFVBRUFDLFVBQUFDLE1BQUFDLE9BQUFMLEVBQUFNLE9BQUEsSUFBQWxCLFFBQUFrQixPQUFBLEdBQUEsSUFBQSxJQUdBLElBQUFkLGdCQUVBQSxnQkFBQUosUUFBQWtCLE9BQ0FDLEtBQUFDLFVBQUEsRUFFQUQsS0FBQUMsVUFBQSxHQVdBLFFBQUFDLGtCQUNBLFdBQUEsS0FBQUMsT0FBQUMsY0FBQSxJQUFBQyxVQUFBQyxVQUFBQyxRQUFBLFlBSUEsUUFBQUMsZ0JBR0EsSUFBQSxHQUZB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LEdBQUFBLEVBQUFwRCxFQUFBcEIsUUFBQSxFQUFBd0UsRUFBQSxFQUFBLENBQ0EsT0FBQTZCLElBQUE3QixFQUFBcEQsRUFBQXFGLE9BQUEsRUFBQWpDLEdBQUF1QixFQUFBLElBQUEzRSxFQUFBcUYsT0FBQWpDLEdBQUFhLFFBQUEsaUJBQUEsS0FBQVUsSUFBQUYsRUFBQUMsRUFBQUksS0FBQUMsSUFBQUgsRUFBQTVFLEdBQUFvRixRQUFBWCxHQUFBekIsTUFBQSxHQUFBLEtBR0E3RSxFQUFBLFFBQUFtSCxHQUFBLE9BQUEsT0FBQSxTQUFBOUYsR0FDQXNFLGNBQUEzRixFQUFBcUMsT0FDQXJDLEVBQUFxQyxNQUFBK0UsVUFvQkFwSCxFQUFBLGVBQUFtRCxNQUFBLFdBQ0FuRCxFQUFBLFlBQUFELE9BQ0FDLEVBQUEscUJBQUFDLE9BQ0FELEVBQUEsY0FBQXFILElBQUEsVUFBQSw0QkFHQXJILEVBQUEsa0JBQUFtRCxNQUFBLFdBQ0FuRCxFQUFBLFlBQUFDLE9BQ0FELEVBQUEsY0FBQXFILElBQUEsVUFBQSwwQkFDQXJILEVBQUEscUJBQUFELFNBS0FDLEVBQUEsMkJBQUFtRCxNQUFBLFdBQ0FuRCxFQUFBcUMsTUFBQTNCLE9BQUE0RyIsImZpbGUiOiJhcHAuanMiLCJzb3VyY2VzQ29udGVudCI6WyJjb25zdCBwcm9ncmVzcyA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdwcm9ncmVzcycpXHJcblxyXG5jb25zdCBuZXh0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ25leHQnKVxyXG5jb25zdCBjaXJjbGVzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmNpcmNsZScpXHJcbmNvbnN0IHN0ZXBDb250YWluZXIgPSAkKCcuY29udGFpbmVyLWl0ZW1zLXN0ZXAnKVxyXG5cclxuXHJcbmxldCBjdXJyZW50QWN0aXZlID0gMVxyXG5cclxubmV4dC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsICgpID0+IHtcclxuICBjdXJyZW50QWN0aXZlKytcclxuXHJcbiAgaWYoY3VycmVudEFjdGl2ZSA+IGNpcmNsZXMubGVuZ3RoKXtcclxuICAgIGN1cnJlbnRBY3RpdmUgPSBjaXJjbGVzLmxlbmd0aFxyXG4gIH1cclxuICBjaXJjbGVzLmZvckVhY2goKGNpcmNsZSwgaWR4KSA9PiB7XHJcbiAgICBjaXJjbGUuY2xhc3NMaXN0LnJlbW92ZSgnYWN0aXZlJylcclxuICB9KVxyXG5cclxudXBkYXRlKClcclxuICAvL2NvbnNvbGUubG9nKGN1cnJlbnRBY3RpdmUpXHJcblxyXG59KVxyXG5cclxuXHJcblxyXG5mdW5jdGlvbiB1cGRhdGUoKXtcclxuICBjaXJjbGVzLmZvckVhY2goKGNpcmNsZSwgaWR4KSA9PiB7XHJcbiAgICBcclxuICAgIGlmIChpZHggPCBjdXJyZW50QWN0aXZlKSB7XHJcbiAgICAgIGNpcmNsZS5jbGFzc0xpc3QuYWRkKCdhY3RpdmUnKVxyXG4gICAgICBzdGVwQ29udGFpbmVyLmhpZGUoKVxyXG4gICAgICAkKCcuY29udGFpbmVyLWl0ZW1zLXN0ZXBbZGF0YS1pZD0nICsgaWR4ICsgJ10nKS5zaG93KClcclxuICAgICAgaWYgKGlkeCA9PSAxKXtcclxuICAgICAgICAgIFxyXG4gICAgICAgICQoJyNzdGVwXzJfYnRuJykuc2hvdygpXHJcbiAgICAgIH1lbHNle1xyXG4gICAgICAgICQoJyNzdGVwXzJfYnRuJykuaGlkZSgpXHJcbiAgICAgIH1cclxuICAgIH1lbHNle1xyXG4gICAgICBjaXJjbGUuY2xhc3NMaXN0LnJlbW92ZSgnYWN0aXZlJylcclxuICAgIFxyXG4gICAgfVxyXG4gIH0pXHJcblxyXG5cclxuICBjb25zdCBhY3RpdmVzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmFjdGl2ZScpXHJcblxyXG4gIHByb2dyZXNzLnN0eWxlLndpZHRoID0gKGFjdGl2ZXMubGVuZ3RoIC0gMSkgLyAoY2lyY2xlcy5sZW5ndGggLSAxKSAqIDEwMCArICclJ1xyXG5cclxuXHJcbiAgaWYoY3VycmVudEFjdGl2ZSA9PT0xKXtcclxuICAgXHJcbiAgfWVsc2UgaWYgKGN1cnJlbnRBY3RpdmUgPT09IGNpcmNsZXMubGVuZ3RoKSB7XHJcbiAgICBuZXh0LmRpc2FibGVkID0gdHJ1ZVxyXG4gIH1lbHNle1xyXG4gICAgbmV4dC5kaXNhYmxlZCA9IGZhbHNlXHJcbiAgfVxyXG59XHJcblxyXG5cclxuLy8gU0VMRUNUIFxyXG5cclxud2luZG93Lm9ubG9hZCA9IGZ1bmN0aW9uICgpIHtcclxuICAgIGNyZWFyX3NlbGVjdCgpO1xyXG59O1xyXG5cclxuZnVuY3Rpb24gaXNNb2JpbGVEZXZpY2UoKSB7XHJcbiAgICByZXR1cm4gdHlwZW9mIHdpbmRvdy5vcmllbnRhdGlvbiAhPT0gXCJ1bmRlZmluZWRcIiB8fCBuYXZpZ2F0b3IudXNlckFnZW50LmluZGV4T2YoXCJJRU1vYmlsZVwiKSAhPT0gLTE7XHJcbn1cclxuXHJcbnZhciBsaSA9IG5ldyBBcnJheSgpO1xyXG5mdW5jdGlvbiBjcmVhcl9zZWxlY3QoKSB7XHJcbiAgICB2YXIgZGl2X2NvbnRfc2VsZWN0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLW1hdGUtc2VsZWN0PSdhY3RpdmUnXVwiKTtcclxuICAgIHZhciBzZWxlY3RfID0gXCJcIjtcclxuICAgIGZvciAodmFyIGUgPSAwOyBlIDwgZGl2X2NvbnRfc2VsZWN0Lmxlbmd0aDsgZSsrKSB7XHJcbiAgICAgICAgZGl2X2NvbnRfc2VsZWN0W2VdLnNldEF0dHJpYnV0ZShcImRhdGEtaW5keC1zZWxlY3RcIiwgZSk7XHJcbiAgICAgICAgZGl2X2NvbnRfc2VsZWN0W2VdLnNldEF0dHJpYnV0ZShcImRhdGEtc2VsZWMtb3BlblwiLCBcImZhbHNlXCIpO1xyXG4gICAgICAgIHZhciB1bF9jb250ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLWluZHgtc2VsZWN0PSdcIiArIGUgKyBcIiddID4gLmNvbnRfbGlzdF9zZWxlY3RfbWF0ZSA+IHVsXCIpO1xyXG4gICAgICAgIHNlbGVjdF8gPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgZSArIFwiJ10gPnNlbGVjdFwiKVswXTtcclxuICAgICAgICBpZiAoaXNNb2JpbGVEZXZpY2UoKSkge1xyXG4gICAgICAgICAgICBzZWxlY3RfLmFkZEV2ZW50TGlzdGVuZXIoXCJjaGFuZ2VcIiwgZnVuY3Rpb24gKCkge1xyXG4gICAgICAgICAgICAgICAgX3NlbGVjdF9vcHRpb24oc2VsZWN0Xy5zZWxlY3RlZEluZGV4LCBlKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIHZhciBzZWxlY3Rfb3B0aW9uZXMgPSBzZWxlY3RfLm9wdGlvbnM7XHJcbiAgICAgICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLWluZHgtc2VsZWN0PSdcIiArIGUgKyBcIiddICA+IC5zZWxlY2lvbmFkb19vcGNpb24gXCIpWzBdLnNldEF0dHJpYnV0ZShcImRhdGEtbi1zZWxlY3RcIiwgZSk7XHJcbiAgICAgICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLWluZHgtc2VsZWN0PSdcIiArIGUgKyBcIiddICA+IC5pY29uX3NlbGVjdF9tYXRlIFwiKVswXS5zZXRBdHRyaWJ1dGUoXCJkYXRhLW4tc2VsZWN0XCIsIGUpO1xyXG4gICAgICAgIGZvciAodmFyIGkgPSAwOyBpIDwgc2VsZWN0X29wdGlvbmVzLmxlbmd0aDsgaSsrKSB7XHJcbiAgICAgICAgICAgIGxpW2ldID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudChcImxpXCIpO1xyXG4gICAgICAgICAgICBpZiAoc2VsZWN0X29wdGlvbmVzW2ldLnNlbGVjdGVkID09IHRydWUgfHwgc2VsZWN0Xy52YWx1ZSA9PSBzZWxlY3Rfb3B0aW9uZXNbaV0uaW5uZXJIVE1MKSB7XHJcbiAgICAgICAgICAgICAgICBsaVtpXS5jbGFzc05hbWUgPSBcImFjdGl2ZVwiO1xyXG4gICAgICAgICAgICAgICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcihcIltkYXRhLWluZHgtc2VsZWN0PSdcIiArIGUgKyBcIiddICA+IC5zZWxlY2lvbmFkb19vcGNpb24gXCIpLmlubmVySFRNTCA9IHNlbGVjdF9vcHRpb25lc1tpXS5pbm5lckhUTUw7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgbGlbaV0uc2V0QXR0cmlidXRlKFwiZGF0YS1pbmRleFwiLCBpKTtcclxuICAgICAgICAgICAgbGlbaV0uc2V0QXR0cmlidXRlKFwiZGF0YS1zZWxlYy1pbmRleFwiLCBlKTtcclxuICAgICAgICAgICAgLy8gZnVuY2lvbiBjbGljayBhbCBzZWxlY2lvbmFyXHJcbiAgICAgICAgICAgIGxpW2ldLmFkZEV2ZW50TGlzdGVuZXIoXCJjbGlja1wiLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgICAgICAgICBfc2VsZWN0X29wdGlvbih0aGlzLmdldEF0dHJpYnV0ZShcImRhdGEtaW5kZXhcIiksIHRoaXMuZ2V0QXR0cmlidXRlKFwiZGF0YS1zZWxlYy1pbmRleFwiKSk7XHJcbiAgICAgICAgICAgIH0pO1xyXG5cclxuICAgICAgICAgICAgbGlbaV0uaW5uZXJIVE1MID0gc2VsZWN0X29wdGlvbmVzW2ldLmlubmVySFRNTDtcclxuICAgICAgICAgICAgdWxfY29udFswXS5hcHBlbmRDaGlsZChsaVtpXSk7XHJcbiAgICAgICAgfSAvLyBGaW4gRm9yIHNlbGVjdF9vcHRpb25lc1xyXG4gICAgfSAvLyBmaW4gZm9yIGRpdnNfY29udF9zZWxlY3RcclxufSAvLyBGaW4gRnVuY3Rpb25cclxuXHJcbnZhciBjb250X3NsYyA9IDA7XHJcbmZ1bmN0aW9uIG9wZW5fc2VsZWN0KGlkeCkge1xyXG4gICAgdmFyIGlkeDEgPSBpZHguZ2V0QXR0cmlidXRlKFwiZGF0YS1uLXNlbGVjdFwiKTtcclxuICAgIHZhciB1bF9jb250X2xpID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLWluZHgtc2VsZWN0PSdcIiArIGlkeDEgKyBcIiddIC5jb250X3NlbGVjdF9pbnQgPiBsaVwiKTtcclxuICAgIHZhciBoZyA9IDA7XHJcbiAgICB2YXIgc2xlY3Rfb3BlbiA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCJbZGF0YS1pbmR4LXNlbGVjdD0nXCIgKyBpZHgxICsgXCInXVwiKVswXS5nZXRBdHRyaWJ1dGUoXCJkYXRhLXNlbGVjLW9wZW5cIik7XHJcbiAgICB2YXIgc2xlY3RfZWxlbWVudF9vcGVuID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLWluZHgtc2VsZWN0PSdcIiArIGlkeDEgKyBcIiddIHNlbGVjdFwiKVswXTtcclxuICAgIGlmIChpc01vYmlsZURldmljZSgpKSB7XHJcbiAgICAgICAgaWYgKHdpbmRvdy5kb2N1bWVudC5jcmVhdGVFdmVudCkge1xyXG4gICAgICAgICAgICAvLyBBbGxcclxuICAgICAgICAgICAgdmFyIGV2dCA9IHdpbmRvdy5kb2N1bWVudC5jcmVhdGVFdmVudChcIk1vdXNlRXZlbnRzXCIpO1xyXG4gICAgICAgICAgICBldnQuaW5pdE1vdXNlRXZlbnQoXCJtb3VzZWRvd25cIiwgZmFsc2UsIHRydWUsIHdpbmRvdywgMCwgMCwgMCwgMCwgMCwgZmFsc2UsIGZhbHNlLCBmYWxzZSwgZmFsc2UsIDAsIG51bGwpO1xyXG4gICAgICAgICAgICBzbGVjdF9lbGVtZW50X29wZW4uZGlzcGF0Y2hFdmVudChldnQpO1xyXG4gICAgICAgIH0gZWxzZSBpZiAoc2xlY3RfZWxlbWVudF9vcGVuLmZpcmVFdmVudCkge1xyXG4gICAgICAgICAgICAvLyBJRVxyXG4gICAgICAgICAgICBzbGVjdF9lbGVtZW50X29wZW4uZmlyZUV2ZW50KFwib25tb3VzZWRvd25cIik7XHJcbiAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgc2xlY3RfZWxlbWVudF9vcGVuLmNsaWNrKCk7XHJcbiAgICAgICAgfVxyXG4gICAgfSBlbHNlIHtcclxuICAgICAgICBmb3IgKHZhciBpID0gMDsgaSA8IHVsX2NvbnRfbGkubGVuZ3RoOyBpKyspIHtcclxuICAgICAgICAgICAgaGcgKz0gdWxfY29udF9saVtpXS5vZmZzZXRIZWlnaHQ7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGlmIChzbGVjdF9vcGVuID09IFwiZmFsc2VcIikge1xyXG4gICAgICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgaWR4MSArIFwiJ11cIilbMF0uc2V0QXR0cmlidXRlKFwiZGF0YS1zZWxlYy1vcGVuXCIsIFwidHJ1ZVwiKTtcclxuICAgICAgICAgICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLWluZHgtc2VsZWN0PSdcIiArIGlkeDEgKyBcIiddID4gLmNvbnRfbGlzdF9zZWxlY3RfbWF0ZSA+IHVsXCIpWzBdLnN0eWxlLmhlaWdodCA9IGhnICsgXCJweFwiO1xyXG4gICAgICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgaWR4MSArIFwiJ10gPiAuaWNvbl9zZWxlY3RfbWF0ZVwiKVswXS5zdHlsZS50cmFuc2Zvcm0gPSBcInJvdGF0ZSgxODBkZWcpXCI7XHJcbiAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIltkYXRhLWluZHgtc2VsZWN0PSdcIiArIGlkeDEgKyBcIiddXCIpWzBdLnNldEF0dHJpYnV0ZShcImRhdGEtc2VsZWMtb3BlblwiLCBcImZhbHNlXCIpO1xyXG4gICAgICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgaWR4MSArIFwiJ10gPiAuaWNvbl9zZWxlY3RfbWF0ZVwiKVswXS5zdHlsZS50cmFuc2Zvcm0gPSBcInJvdGF0ZSgwZGVnKVwiO1xyXG4gICAgICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgaWR4MSArIFwiJ10gPiAuY29udF9saXN0X3NlbGVjdF9tYXRlID4gdWxcIilbMF0uc3R5bGUuaGVpZ2h0ID0gXCIwcHhcIjtcclxuICAgICAgICB9XHJcbiAgICB9XHJcbn0gLy8gZmluIGZ1bmN0aW9uIG9wZW5fc2VsZWN0XHJcblxyXG5mdW5jdGlvbiBzYWxpcl9zZWxlY3QoaW5keCkge1xyXG4gICAgdmFyIHNlbGVjdF8gPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgaW5keCArIFwiJ10gPiBzZWxlY3RcIilbMF07XHJcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgaW5keCArIFwiJ10gPiAuY29udF9saXN0X3NlbGVjdF9tYXRlID4gdWxcIilbMF0uc3R5bGUuaGVpZ2h0ID0gXCIwcHhcIjtcclxuICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoXCJbZGF0YS1pbmR4LXNlbGVjdD0nXCIgKyBpbmR4ICsgXCInXSA+IC5pY29uX3NlbGVjdF9tYXRlXCIpLnN0eWxlLnRyYW5zZm9ybSA9IFwicm90YXRlKDBkZWcpXCI7XHJcbiAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgaW5keCArIFwiJ11cIilbMF0uc2V0QXR0cmlidXRlKFwiZGF0YS1zZWxlYy1vcGVuXCIsIFwiZmFsc2VcIik7XHJcbn1cclxuXHJcbmZ1bmN0aW9uIF9zZWxlY3Rfb3B0aW9uKGluZHgsIHNlbGMpIHtcclxuICAgIGlmIChpc01vYmlsZURldmljZSgpKSB7XHJcbiAgICAgICAgc2VsYyA9IHNlbGMgLSAxO1xyXG4gICAgfVxyXG4gICAgdmFyIHNlbGVjdF8gPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgc2VsYyArIFwiJ10gPiBzZWxlY3RcIilbMF07XHJcblxyXG4gICAgdmFyIGxpX3MgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKFwiW2RhdGEtaW5keC1zZWxlY3Q9J1wiICsgc2VsYyArIFwiJ10gLmNvbnRfc2VsZWN0X2ludCA+IGxpXCIpO1xyXG4gICAgdmFyIHBfYWN0ID0gKGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCJbZGF0YS1pbmR4LXNlbGVjdD0nXCIgKyBzZWxjICsgXCInXSA+IC5zZWxlY2lvbmFkb19vcGNpb25cIilbMF0uaW5uZXJIVE1MID0gbGlfc1tpbmR4XS5pbm5lckhUTUwpO1xyXG4gICAgdmFyIHNlbGVjdF9vcHRpb25lcyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCJbZGF0YS1pbmR4LXNlbGVjdD0nXCIgKyBzZWxjICsgXCInXSA+IHNlbGVjdCA+IG9wdGlvblwiKTtcclxuICAgIGZvciAodmFyIGkgPSAwOyBpIDwgbGlfcy5sZW5ndGg7IGkrKykge1xyXG4gICAgICAgIGlmIChsaV9zW2ldLmNsYXNzTmFtZSA9PSBcImFjdGl2ZVwiKSB7XHJcbiAgICAgICAgICAgIGxpX3NbaV0uY2xhc3NOYW1lID0gXCJcIjtcclxuICAgICAgICB9XHJcbiAgICAgICAgbGlfc1tpbmR4XS5jbGFzc05hbWUgPSBcImFjdGl2ZVwiO1xyXG4gICAgfVxyXG4gICAgc2VsZWN0X29wdGlvbmVzW2luZHhdLnNlbGVjdGVkID0gdHJ1ZTtcclxuICAgIHNlbGVjdF8uc2VsZWN0ZWRJbmRleCA9IGluZHg7XHJcbiAgICBzZWxlY3RfLm9uY2hhbmdlKCk7XHJcbiAgICBzYWxpcl9zZWxlY3Qoc2VsYyk7XHJcbn1cclxuXHJcblxyXG5mdW5jdGlvbiByZXZpc2FyRGlnaXRvKGR2cikge1xyXG4gICAgdmFyIGR2ID0gZHZyICsgXCJcIlxyXG4gICAgaWYgKGR2ICE9ICcwJyAmJiBkdiAhPSAnMScgJiYgZHYgIT0gJzInICYmIGR2ICE9ICczJyAmJiBkdiAhPSAnNCcgJiYgZHYgIT0gJzUnICYmIGR2ICE9ICc2JyAmJiBkdiAhPSAnNycgJiYgZHYgIT0gJzgnICYmIGR2ICE9ICc5JyAmJiBkdiAhPSAnaycgJiYgZHYgIT0gJ0snKSB7XHJcbiAgICAgICAgYWxlcnQoJ0RlYmUgaW5ncmVzYXIgdW4gZGlnaXRvIHZlcmlmaWNhZG9yIHZhbGlkbycpO1xyXG4gICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgIH1cclxuICAgIHJldHVybiB0cnVlO1xyXG59XHJcblxyXG5mdW5jdGlvbiByZXZpc2FyRGlnaXRvMihjcnV0KSB7XHJcbiAgICB2YXIgbGFyZ28gPSBjcnV0Lmxlbmd0aDtcclxuICAgIGlmIChsYXJnbyA8IDIpIHtcclxuICAgICAgICBhbGVydCgnRGViZSBpbmdyZXNhciBlbCBydXQgY29tcGxldG8nKVxyXG4gICAgICAgIHJldHVybiBmYWxzZTtcclxuICAgIH1cclxuICAgIGlmIChsYXJnbyA+IDIpXHJcbiAgICAgICAgdmFyIHJ1dCA9IGNydXQuc3Vic3RyaW5nKDAsIGxhcmdvIC0gMSk7XHJcbiAgICBlbHNlXHJcbiAgICAgICB2YXIgcnV0ID0gY3J1dC5jaGFyQXQoMCk7XHJcbiAgICB2YXIgZHYgPSBjcnV0LmNoYXJBdChsYXJnbyAtIDEpO1xyXG4gICAgcmV2aXNhckRpZ2l0byhkdik7XHJcblxyXG4gICAgaWYgKHJ1dCA9PSBudWxsIHx8IGR2ID09IG51bGwpXHJcbiAgICAgICAgcmV0dXJuIDBcclxuXHJcbiAgICB2YXIgZHZyID0gJzAnXHJcbiAgICB2YXIgc3VtYSA9IDBcclxuICAgIHZhciBtdWwgPSAyXHJcblxyXG4gICAgZm9yICh2YXIgaSA9IHJ1dC5sZW5ndGggLSAxOyBpID49IDA7IGktLSkge1xyXG4gICAgICAgIHN1bWEgPSBzdW1hICsgcnV0LmNoYXJBdChpKSAqIG11bFxyXG4gICAgICAgIGlmIChtdWwgPT0gNylcclxuICAgICAgICAgICAgbXVsID0gMlxyXG4gICAgICAgIGVsc2VcclxuICAgICAgICAgICAgbXVsKytcclxuICAgIH1cclxuICAgIHZhciByZXMgPSBzdW1hICUgMTFcclxuICAgIGlmIChyZXMgPT0gMSlcclxuICAgICAgICB2YXIgZHZyID0gJ2snXHJcbiAgICBlbHNlIGlmIChyZXMgPT0gMClcclxuICAgICAgICB2YXIgZHZyID0gJzAnXHJcbiAgICBlbHNlIHtcclxuICAgICAgICB2YXIgZHZpID0gMTEgLSByZXNcclxuICAgICAgICBkdnIgPSBkdmkgKyBcIlwiXHJcbiAgICB9XHJcbiAgICBpZiAoZHZyICE9IGR2LnRvTG93ZXJDYXNlKCkpIHtcclxuICAgICAgICBhbGVydCgnRWwgcnV0IGVzIGluY29ycmVjdG8nKVxyXG4gICAgICAgIHJldHVybiBmYWxzZVxyXG4gICAgfVxyXG5cclxuICAgIHJldHVybiB0cnVlXHJcbn1cclxuXHJcbmZ1bmN0aW9uIFZhbGlkYXJSdXQodGV4dG8pIHtcclxuICAgIHRleHRvID0gW3RleHRvLnNsaWNlKDAsIHRleHRvLmxlbmd0aCAtIDEpLCAnLScsIHRleHRvLnNsaWNlKHRleHRvLmxlbmd0aCAtIDEpXS5qb2luKCcnKTtcclxuICAgIHZhciB0bXBzdHIgPSBcIlwiO1xyXG4gICAgZm9yICh2YXIgaSA9IDA7IGkgPCB0ZXh0by5sZW5ndGg7IGkrKylcclxuICAgICAgICBpZiAodGV4dG8uY2hhckF0KGkpICE9ICcgJyAmJiB0ZXh0by5jaGFyQXQoaSkgIT0gJy4nICYmIHRleHRvLmNoYXJBdChpKSAhPSAnLScpXHJcbiAgICAgICAgICAgIHRtcHN0ciA9IHRtcHN0ciArIHRleHRvLmNoYXJBdChpKTtcclxuICAgIHZhciB0ZXh0byA9IHRtcHN0cjtcclxuICAgIHZhciBsYXJnbyA9IHRleHRvLmxlbmd0aDtcclxuXHJcbiAgICBpZiAobGFyZ28gPCAyKSB7XHJcbiAgICAgICAgYWxlcnQoJ0RlYmUgaW5ncmVzYXIgZWwgcnV0IGNvbXBsZXRvJylcclxuICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICB9XHJcblxyXG4gICAgZm9yIChpID0gMDsgaSA8IGxhcmdvOyBpKyspIHtcclxuICAgICAgICBpZiAodGV4dG8uY2hhckF0KGkpICE9IFwiMFwiICYmIHRleHRvLmNoYXJBdChpKSAhPSBcIjFcIiAmJiB0ZXh0by5jaGFyQXQoaSkgIT0gXCIyXCIgJiYgdGV4dG8uY2hhckF0KGkpICE9IFwiM1wiICYmIHRleHRvLmNoYXJBdChpKSAhPSBcIjRcIiAmJiB0ZXh0by5jaGFyQXQoaSkgIT0gXCI1XCIgJiYgdGV4dG8uY2hhckF0KGkpICE9IFwiNlwiICYmIHRleHRvLmNoYXJBdChpKSAhPSBcIjdcIiAmJiB0ZXh0by5jaGFyQXQoaSkgIT0gXCI4XCIgJiYgdGV4dG8uY2hhckF0KGkpICE9IFwiOVwiICYmIHRleHRvLmNoYXJBdChpKSAhPSBcImtcIiAmJiB0ZXh0by5jaGFyQXQoaSkgIT0gXCJLXCIpIHtcclxuICAgICAgICAgICAgYWxlcnQoJ0VsIHZhbG9yIGluZ3Jlc2FkbyBubyBjb3JyZXNwb25kZSBhIHVuIFIuVS5UIHZhbGlkbycpO1xyXG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XHJcbiAgICAgICAgfVxyXG4gICAgfVxyXG5cclxuICAgIHZhciBpbnZlcnRpZG8gPSBcIlwiO1xyXG4gICAgZm9yIChpID0gKGxhcmdvIC0gMSksIGogPSAwOyBpID49IDA7IGktLSwgaisrKVxyXG4gICAgICAgIGludmVydGlkbyA9IGludmVydGlkbyArIHRleHRvLmNoYXJBdChpKTtcclxuICAgIHZhciBkdGV4dG8gPSBcIlwiO1xyXG4gICAgZHRleHRvID0gZHRleHRvICsgaW52ZXJ0aWRvLmNoYXJBdCgwKTtcclxuICAgIGR0ZXh0byA9IGR0ZXh0byArICctJztcclxuICAgIHZhciBjbnQgPSAwO1xyXG4gICAgdmFyIGogPSAwXHJcbiAgICBmb3IgKGkgPSAxLCBqID0gMjsgaSA8IGxhcmdvOyBpKyssIGorKykge1xyXG4gICAgICAgIC8vYWxlcnQoXCJpPVtcIiArIGkgKyBcIl0gaj1bXCIgKyBqICtcIl1cIiApO1xyXG4gICAgICAgIGlmIChjbnQgPT0gMykge1xyXG4gICAgICAgICAgICBkdGV4dG8gPSBkdGV4dG8gKyAnLic7XHJcbiAgICAgICAgICAgIGorKztcclxuICAgICAgICAgICAgZHRleHRvID0gZHRleHRvICsgaW52ZXJ0aWRvLmNoYXJBdChpKTtcclxuICAgICAgICAgICAgY250ID0gMTtcclxuICAgICAgICB9IGVsc2Uge1xyXG4gICAgICAgICAgICBkdGV4dG8gPSBkdGV4dG8gKyBpbnZlcnRpZG8uY2hhckF0KGkpO1xyXG4gICAgICAgICAgICBjbnQrKztcclxuICAgICAgICB9XHJcbiAgICB9XHJcblxyXG4gICAgaW52ZXJ0aWRvID0gXCJcIjtcclxuICAgIGZvciAoaSA9IChkdGV4dG8ubGVuZ3RoIC0gMSksIGogPSAwOyBpID49IDA7IGktLSwgaisrKVxyXG4gICAgICAgIGludmVydGlkbyA9IGludmVydGlkbyArIGR0ZXh0by5jaGFyQXQoaSk7XHJcblxyXG4gICAgLy8kKCdbaWQkPV9ydXRdJykudmFsKGludmVydGlkby50b1VwcGVyQ2FzZSgpKTtcclxuXHJcbiAgICBpZiAocmV2aXNhckRpZ2l0bzIodGV4dG8pKVxyXG4gICAgICAgIHJldHVybiB0cnVlO1xyXG5cclxuICAgIHJldHVybiBmYWxzZTtcclxufVxyXG5cclxuZnVuY3Rpb24gcnV0Rm9ybWF0KHZhbHVlKSB7XHJcbiAgICB2YXIgc1J1dDEgPSB2YWx1ZS50cmltKCk7XHJcbiAgICB2YXIgblBvcyA9IDA7XHJcbiAgICB2YXIgc0ludmVydGlkbyA9IFwiXCI7XHJcbiAgICB2YXIgc1J1dCA9IFwiXCI7XHJcbiAgICBmb3IgKHZhciBpID0gc1J1dDEubGVuZ3RoIC0gMTsgaSA+PSAwOyBpLS0pIHtcclxuICAgICAgICBzSW52ZXJ0aWRvICs9IHNSdXQxLmNoYXJBdChpKTtcclxuICAgICAgICBpZiAoaSA9PSBzUnV0MS5sZW5ndGggLSAxKVxyXG4gICAgICAgICAgICBzSW52ZXJ0aWRvICs9IFwiLVwiO1xyXG4gICAgICAgIGVsc2UgaWYgKG5Qb3MgPT0gMykge1xyXG4gICAgICAgICAgICBzSW52ZXJ0aWRvICs9IFwiLlwiO1xyXG4gICAgICAgICAgICBuUG9zID0gMDtcclxuICAgICAgICB9XHJcbiAgICAgICAgblBvcysrO1xyXG4gICAgfVxyXG4gICAgZm9yICh2YXIgaiA9IHNJbnZlcnRpZG8ubGVuZ3RoIC0gMTsgaiA+PSAwOyBqLS0pIHtcclxuICAgICAgICBpZiAoc0ludmVydGlkby5jaGFyQXQoc0ludmVydGlkby5sZW5ndGggLSAxKSAhPSBcIi5cIilcclxuICAgICAgICAgICAgc1J1dCArPSBzSW52ZXJ0aWRvLmNoYXJBdChqKTtcclxuICAgICAgICBlbHNlIGlmIChqICE9IHNJbnZlcnRpZG8ubGVuZ3RoIC0gMSlcclxuICAgICAgICAgICAgc1J1dCArPSBzSW52ZXJ0aWRvLmNoYXJBdChqKTtcclxuXHJcbiAgICB9XHJcbiAgICByZXR1cm4gc1J1dC50b1VwcGVyQ2FzZSgpO1xyXG59XHJcblxyXG5OdW1iZXIucHJvdG90eXBlLmZvcm1hdE51bWJlciA9IGZ1bmN0aW9uIChjLCBkLCB0KSB7XHJcbiAgICB2YXIgbiA9IHRoaXMsXHJcbiAgICAgICAgYyA9IGlzTmFOKGMgPSBNYXRoLmFicyhjKSkgPyAwIDogYyxcclxuICAgICAgICBkID0gZCA9PSB1bmRlZmluZWQgPyBcIixcIiA6IGQsXHJcbiAgICAgICAgdCA9IHQgPT0gdW5kZWZpbmVkID8gXCIuXCIgOiB0LFxyXG4gICAgICAgIHMgPSBuIDwgMCA/IFwiLVwiIDogXCJcIixcclxuICAgICAgICBpID0gU3RyaW5nKHBhcnNlSW50KG4gPSBNYXRoLmFicyhOdW1iZXIobikgfHwgMCkudG9GaXhlZChjKSkpLFxyXG4gICAgICAgIGogPSAoaiA9IGkubGVuZ3RoKSA+IDMgPyBqICUgMyA6IDA7XHJcbiAgICByZXR1cm4gcyArIChqID8gaS5zdWJzdHIoMCwgaikgKyB0IDogXCJcIikgKyBpLnN1YnN0cihqKS5yZXBsYWNlKC8oXFxkezN9KSg/PVxcZCkvZywgXCIkMVwiICsgdCkgKyAoYyA/IGQgKyBNYXRoLmFicyhuIC0gaSkudG9GaXhlZChjKS5zbGljZSgyKSA6IFwiXCIpO1xyXG59O1xyXG5cclxuJCgnYm9keScpLm9uKCdibHVyJywgJyNydXQnLCBmdW5jdGlvbiAoZSkge1xyXG4gICAgcnV0Rm9ybWF0Qmx1cigkKHRoaXMpKTtcclxuICAgICQodGhpcykua2V5dXAoKTtcclxuXHJcbn0pO1xyXG5cclxuZnVuY3Rpb24gcnV0Rm9ybWF0Qmx1cihlbGVtZW50KVxyXG57XHJcbiAgICB2YXIgdmFsID0gZWxlbWVudC52YWwoKTtcclxuICAgIC8vZWxlbWVudC52YWwocnV0Rm9ybWF0KGVsZW1lbnQudmFsKCkudG9VcHBlckNhc2UoKSkpO1xyXG4gICAgZWxlbWVudC52YWwodmFsLnRvTG93ZXJDYXNlKCkucmVwbGFjZSgvW15cXGRrXS9nLCBcIlwiKS50b1VwcGVyQ2FzZSgpKTtcclxuICAgIHZhbCA9IGVsZW1lbnQudmFsKCk7XHJcbiAgICBpZiAodmFsICE9PSAnJykge1xyXG4gICAgICAgIHZhciBydXQgPSBWYWxpZGFyUnV0KHZhbCk7XHJcbiAgICAgICAgaWYgKHJ1dCkge1xyXG4gICAgICAgICAgICBlbGVtZW50LnZhbChydXRGb3JtYXQodmFsLnRvVXBwZXJDYXNlKCkpKTtcclxuICAgICAgICB9IGVsc2Uge1xyXG4gICAgICAgICAgICBlbGVtZW50LnZhbCgnJyk7XHJcbiAgICAgICAgfVxyXG4gICAgfVxyXG59XHJcblxyXG4kKCcjc3RlcF8yX2J0bicpLmNsaWNrKGZ1bmN0aW9uKCl7XHJcbiAgICAkKCcjdGl0dWxhcicpLmhpZGUoKVxyXG4gICAgJCgnI25ld19iZW5pZmljaWFyaW8nKS5zaG93KClcclxuICAgICQoJy5idG4tc3RlcHMnKS5jc3MoJ2Nzc1RleHQnLCAnZGlzcGxheTpub25lIWltcG9ydGFudCcpO1xyXG59KVxyXG5cclxuJCgnLmJhY2tfdG9fc3RlcHMnKS5jbGljayhmdW5jdGlvbigpe1xyXG4gICAgJCgnI3RpdHVsYXInKS5zaG93KClcclxuICAgICQoJy5idG4tc3RlcHMnKS5jc3MoJ2Nzc1RleHQnLCAnZGlzcGxheTpmbGV4IWltcG9ydGFudCcpO1xyXG4gICAgJCgnI25ld19iZW5pZmljaWFyaW8nKS5oaWRlKClcclxuICAgIFxyXG59KVxyXG5cclxuXHJcbiQoJy5pdGVtcy1jb2xsYXBzZS1wcmltYXJ5JykuY2xpY2soZnVuY3Rpb24oKXtcclxuICAgICQodGhpcykubmV4dCgpLnRvZ2dsZSgpO1xyXG59KTsiXX0=