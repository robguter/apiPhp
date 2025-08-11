//var strDir='';
var cmpo="";
var ActClase="o-No";
var iPieAlto=0;
var iClck = false;
var mnsa = window.location.pathname;
var arrm = mnsa.split('/');
var lrgo = arrm.length-1;
var sPagAct = arrm[lrgo];

var acceso = Acceso();
function muestraEr(campo, msj) {
    $(".error").html(msj);
    campo.val("");
    setTimeout(function() {
        $(".error").fadeIn(2000);
    },300);
    setTimeout(function() {
        $(".error").fadeOut(2500);
    },3000);
    campo.focus();
    if (campo.hasClass("valid"))
        campo.removeClass("valid");
    campo.addClass("invalid");
}
$(document).on("resize", function(){
    var ventana_ancho = $(window).width();
    //alert(ventana_ancho);
});
$(document).ready(function(){
    var ventana_ancho = $(window).width();
    alert(ventana_ancho);
    mainmenu();
    let timeout = setTimeout(IniTmOut, 3000);
    if (sPagAct == "index") {
        Acceso();
    }
    function IniTmOut() {
        var url ='https://miweb.com.ve/comprobante/getAll/';
        $.ajax({
            type: "POST",
            url: url,
            success: function(datos) {
                if (JSON.parse(datos) != "") {
                    var dataString='datos='+datos;
                    $.ajax({
                        type: "POST",
                        url: strDir+"comprobante/aComprobante/",
                        data: dataString,
                        success: function(datas) {
                            if (datas["exito"]=="1") {
                                Elimina();
                            }
                        },
                        complete : function(xhr, status) {
                        }
                    });
                }
            }
        });
    }
    $("#bCrrar").click(function() {
        $(this).blur();
        //$('#'+$(this).parent().attr("id")+' p').html("");
        $(this).parent()
            .fadeOut(1000)
            .css('display','none');
    });
    

    $(".InfoM").click(function() {
        $("footer .CpCntP").toggle("3000");
        var iAlto=$(this).css("height");
        var sAlto = iAlto.substr(0,(iAlto.length)-2);
        $("footer").css("background-color","rgb(241,241,241,.932)");
        //alert(sAlto);
        if (iPieAlto==0) {
            $(".InfoM").html("Menos Información").css("color","#111");
            $("footer").css("background-color","rgb(241,241,241,.932)");
            iPieAlto=1;
        }else{
            $(".InfoM").html("Mas Información").css("color","#777");
            iPieAlto=0;
        }
    });
    $('.account').click(function() {
        $(".dropdown-menu").toggle("1000").css("z-index",1000);
        $(".dropdown-menu li").css("z-index",2000);
    });
});

var Elimina = function() {
    url ='https://miweb.com.ve/comprobante/elimina/';
    $.ajax({
        type: "POST",
        url: url,
        success: function(dats) {
            console.log(dats);
        },
        error : function(xhr, status) {
            console.log("Datos: "+status);
        },
        // código a ejecutar sin importar si la petición falló o no
        complete : function(xhr, status) {
            console.log("dataString");
        }
    });
}
var Vrific = function(Campo) {
    cmpo = Campo.attr("name").toString();
    var Largo = Campo.val().length;
    var mnLargo = Campo.attr("minLength");
    var mxLargo = Campo.attr("maxLength");
    var dtsCmp = Campo.val();
    $("#o-"+cmpo).removeClass(ActClase);
    if (dtsCmp === "") {
        $("#o-"+cmpo).addClass("o-No");
        ActClase="o-No";
        return;
    }
    if (cmpo==="Email") {
        if (mnLargo && mnLargo > Largo) {
            $("#o-"+cmpo).addClass("o-No");
            ActClase="o-No";
            return;
        }
        var sino = vlds(dtsCmp);
        if (sino == false) {
            $("#o-"+cmpo).addClass("o-No");
            ActClase="o-No";
        }else{
            $("#o-"+cmpo).addClass("o-Ok");
            ActClase="o-Ok";
        }
    }else if (cmpo==="CEmail") {
        var confrm = $("input[name='Email']");
        var cnfrmVlr = confrm.val();
        if (dtsCmp !== cnfrmVlr) {
            $("#o-"+cmpo).addClass("o-No");
            ActClase="o-No";
            Campo.parent().next().children('input').attr("readonly",true);
        }else{
            $("#o-"+cmpo).addClass("o-Ok");
            ActClase="o-Ok";
            Campo.parent().next().children('input').attr("readonly",false);
        }
    }else if (cmpo==="CClave") {
        var confrm = $("input[name='Clave']");
        var cnfrmVlr = confrm.val();
        if (dtsCmp !== cnfrmVlr) {
            $("#o-"+cmpo).addClass("o-No");
            ActClase="o-No";
            Campo.parent().next().children('input').attr("readonly",true);
        }else{
            $("#o-"+cmpo).addClass("o-Ok");
            ActClase="o-Ok";
            Campo.parent().next().children('input').attr("readonly",false);
        }
    }else{
        if (mnLargo && mnLargo > Largo) {
            $("#o-"+cmpo).addClass("o-No");
            ActClase="o-No";
            Campo.parent().next().children('input').attr("readonly",true);
            return;
        }
        if (mxLargo && mxLargo < Largo) {
            $("#o-"+cmpo).addClass("o-No");
            ActClase="o-No";
            Campo.parent().next().children('input').attr("readonly",true);
            return;
        }
        $("#o-"+cmpo).addClass("o-Ok");
        ActClase="o-Ok";
        Campo.parent().next().children('input').attr("readonly",false);
    }
};
var Valida = function(Campo) {
    cmpo=Campo.attr("name").toString();
    var dtsCmp = Campo.val();
    var Largo = Campo.val().length;
    var mnLargo = Campo.attr("minLength");
    var mxLargo = Campo.attr("maxLength");
    if (cmpo==="Email") {
        if (mnLargo && mnLargo > Largo) {
            alert('El correo electrónico introducido es muy corto.');
            return;
        }
        var sino = vlds(dtsCmp);
        if (sino == false) {
            alert('El correo electrónico introducido no es correcto.');
            return;
        }
        var dataString='Email='+dtsCmp;
        $.ajax({
            type: "POST",
            url: strDir+"php/VrfcEmail/",
            data: dataString,
            success: function(datos) {
                if ( datos == "true") {
                    alert('Este correo electrónico, ya existe en nuestro sistema.');
                    Campo.parent().next().children('input').attr("readonly",true);
                    Campo.focus();
                    var qSigue = Campo.parent().next().children('input').attr("name");
                    $("#o-"+qSigue).removeClass(ActClase);
                    $("#o-"+cmpo).removeClass(ActClase);
                    $("#o-"+cmpo).addClass("o-No");
                    ActClase="o-No";
                    return;
                }else{
                Campo.parent().next().children('input').attr("readonly",false);
                    $("#o-"+cmpo).removeClass(ActClase);
                }
            }
        });
    }else if (cmpo==="CEmail") {
        var confrm = $("input[name='Email']");
        var cnfrmVlr = confrm.val();
        if (dtsCmp !== cnfrmVlr) {
            alert("El campo "+cmpo+" no coincide con la confirmación");
            Campo.focus();
            return;
        }
        $("#o-"+cmpo).removeClass(ActClase);
        Campo.parent().next().children('input').attr("readonly",false);
        return;
    }else if (cmpo==="CClave") {
        var confrm = $("input[name='Clave']");
        var cnfrmVlr = confrm.val();
        if (dtsCmp !== cnfrmVlr) {
            alert("El campo " + cmpo + " no coincide con la confirmación");
            Campo.focus();
            return;
        }
        $("#o-"+cmpo).removeClass(ActClase);
        Campo.parent().next().children('input').attr("readonly",false);
        return;
    }else{
        if (mnLargo && mnLargo > Largo) {
            alert("El campo " + cmpo + " introducido es muy corto.");
            return;
        }
        if (mxLargo && mxLargo < Largo) {
            alert("El campo "+cmpo+" introducido es muy largo.");
            return;
        }
        if (cmpo==="Usuario") {
            var dataString='Usuario='+dtsCmp;
            $.ajax({
                type: "POST",
                url: strDir+"php/VrfcUsr/",
                data: dataString,
                success: function(datos) {
                    var item = JSON.parse(datos);
                    if ( item && (item.Usuario == dtsCmp) ) {
                        alert('Este Usuario, ya existe en nuestro sistema.');
                        Campo.parent().next().children('input').attr("readonly",true);
                        Campo.focus();
                        var qSigue = Campo.parent().next().children('input').attr("name");
                        $("#o-"+qSigue).removeClass(ActClase);
                        $("#o-"+cmpo).removeClass(ActClase);
                        $("#o-"+cmpo).addClass("o-No");
                        ActClase="o-No";
                        return;
                    }else{
                        Campo.parent().next().children('input').attr("readonly",false);
                        $("#o-"+cmpo).removeClass(ActClase);
                    }
                }
            });
        }
        $("#o-"+cmpo).removeClass(ActClase);
        Campo.parent().next().children('input').attr("readonly",false);
        return;
    }
};
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
var vlds = function(sEmail) {
    if (!isEmail(sEmail)) {
        return false;
    }
    if(sEmail.indexOf('@', 0) === -1) {
        return false;
    }
    var mPartes = sEmail.split("@");
    if (mPartes[0].length < 4) {
        return false;
    }
    if (mPartes[1].indexOf('.', 0) === -1) {
        return false;
    }
    return true;
}
function mainmenu(){
    $(" #nav ul ").css({display: "none"});
    $(" #nav li").hover(function(){
        $(this).find('ul:first:hidden').css({visibility: "visible",display: "none"}).slideDown(400);
    },function(){
        $(this).find('ul:first').slideUp(400);
    });
}

function Acceso() {
    $.ajax({
        type: "POST",
        url: strDir+"index/obtAcceso/",
        success: function(datos) {
            if (datos) {
                acceso = datos;
                return acceso;
            }
        }
    });
}