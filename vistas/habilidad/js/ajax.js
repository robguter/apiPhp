var WnHgt;
var iEntr=1;
var bOclt = false;
let aDepto = [];

$(document).ready(function() {
    $("#btnCmbClave").attr('disabled', true);
    $("input[type='password']").on("change", function() {
        if ( $(this).val() != null && $(this).val() != "" )
            $("#btnCmbClave").attr('disabled', false);
        else
            $("#btnCmbClave").attr('disabled', true);
    });
    $('input').each(function (index) {
        var element = $(this);
        var largo = element.val().length;
        var mxlen = Number(element.attr('maxlength'));
        var mnlen = Number(element.attr('minlength'));
        element.on("keyup", function(){
            largo = element.val().length;
            
            if (largo < mnlen || largo > mxlen) {
                if (element.hasClass("valid"))
                    element.removeClass("valid");
                element.addClass("invalid");
            }else{
                if (element.hasClass("invalid"))
                    element.removeClass("invalid");
                element.addClass('valid');
            }
        });
        element.on("change", function(){
            largo = element.val().length;
            
            if (largo < mnlen || largo > mxlen) {
                muestraEr(element, "<b>El largo debe ser entre " + mnlen.toString() + " y " + mxlen.toString() + "</b>");
            }
        });
    });
    $("#idpto").on("change", function() {
        let id = $(this).closest("form[id]").attr('id');
        if (id=="frmedi") return;
        var sText = $(this).children("option:selected").text();
        var iValu = $(this).val();
        let bVal = false;
        $.each(aDepto, function( index, value ) {
            if( value==iValu ) {
                bVal = true;
                aDepto.splice(index, 1);
            }
        });
        if (bVal == false) {
            aDepto.push(iValu);
        }
        $("#departamentos").val(aDepto);
    });
    $('#sUser img').on('click', function() {
        var valor = $(this).attr("id");
        var categ = $("input#"+valor).val();
        var dataString = 'valor=' + valor;
        //alert(valor);
        var url = strDir+"usuario/obtUsuario/";
        $.ajax({
            type: "POST",
            url: url,
            data: dataString,
            success: function(datos) {
                var html = "";
                //$('.mtraUsr > div').html("");
                value = JSON.parse(datos);
                var idusr = value.idusr;
                var clnte = value.cliente;
                var nomrs = value.nombres;
                var apell = value.apellidos;
                var usuar = value.usuario;
                var nivel = value.nivel;
                var estat = value.estatus;
                html += "<div class='row col-4'>";
                html += "<div class='col-6'>ID:</div>";
                html += "<div class='col'>" + idusr + "</div>";
                html += "</div>";
                html += "<div class='row col-4'>";
                html += "<div class='col-6'>Cliente:</div>";
                html += "<div class='col'>" + clnte + "</div>";
                html += "</div>";
                html += "<div class='row col-4'>";
                html += "<div class='col-6'>Nombres:</div>";
                html += "<div class='col'>" + nomrs + "</div>";
                html += "</div>";
                html += "<div class='row col-4'>";
                html += "<div class='col-6'>Apellidos:</div>";
                html += "<div class='col'>" + apell + "</div>";
                html += "</div>";
                html += "<div class='row col-4'>";
                html += "<div class='col-6'>Usuario:</div>";
                html += "<div class='col'>" + usuar + "</div>";
                html += "</div>";
                html += "<div class='row col-4'>";
                html += "<div class='col-6'>Nivel:</div>";
                html += "<div class='col'>" + nivel + "</div>";
                html += "</div>";
                html += "<div class='row col-4'>";
                html += "<div class='col-6'>Estatus:</div>";
                html += "<div class='col'>" + estat + "</div>";
                html += "</div>";
                $('.mtraUsr').fadeIn(600);
                $('.mtraUsr > div').append(html);
            },
            error : function(xhr, status) {
                console.log("Datos: "+status);
            }
        });
    });
    $("#categoria").on("change", function() {
        var cate = $(this).val();
        $('#tipo').empty();
        var html = "<option value='-1'></option>";
        if (cate == '1') {
            html += "<option value='1'>Empleado</option>";
            html += "<option value='2'>Gerente</option>";
            html += "<option value='3'>Director</option>";
            html += "<option value='4'>Propietario</option>";
        }else if (cate == '2') {
            html += "<option value='1'>Cliente</option>";
            html += "<option value='2'>Proveedor</option>";
            html += "<option value='3'>Gobierno</option>";
            html += "<option value='4'>Organismo sin fines de lucro</option>";
        }
        $('#tipo').html(html);
    });
    $("button[type='button']").on("click", function() {
        $('.mtraUsr .row div')
        .fadeOut(500)
        .remove();
        $('.mtraUsr .row')
        .fadeOut(500)
        .remove();
        $('.mtraUsr').fadeOut(500);
    });
    $('input[name="usuario"]').on("change", function() {
        var campo = $(this);
        var dataString='usuario='+campo.val();
        var url = strDir+"usuario/vrfUsuario/";
        $.ajax({
            type: "POST",
            url: url,
            data: dataString,
            success: function(datos) {
                if (datos>0){
                    muestraEr(campo, "<b>Este USUARIO ya está registrado</b>");
                }
            }
        });
    });
    $(".table tbody").on("click", "tr", function() {
        let sDto = $(this).children().eq(0).prop("className");
        let sCod = $(this).children().eq(1).html();
        let sCte = $(this).children().eq(2).html();
        let sNmb = $(this).children().eq(3).html();
        let sApl = $(this).children().eq(4).html();
        let sUsr = $(this).children().eq(5).html();
        let sNvl = $(this).children().eq(6).html();

        $("#iddtoa").val(sDto);
        $("#idpto").val(sDto);
        $("#idusr").val(sCod);
        $("#cliente").val(sCte);
        $("#nombres").val(sNmb);
        $("#apellidos").val(sApl);
        $("#usuario").val(sUsr);
        $("#nivel").val(sNvl);
    });
    $('.solo-numero').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
    });
    $('.solo-letraa').keyup(function (e){
        var reg = /^([a-z ñáéíóú])$/i;
        if(reg.test(e)) return true;
        else return false;
    });
    $('.solo-letra-a').keyup(function (e){
        //this.value = (this.value + '').replace(/[^a-zA-Záéíóú ]/g, '');
        var key = e.keyCode || e.which;
        var teclado = String.fromCharCode(key).toLowerCase();
        var letras = "qwertyuiopasdfghjklñzxcvbnm ";
        var especiales = "8-37-38-46-164-46";
        var teclado_especial = false;
        for (var i in especiales) {
            if (key == especiales[i]) {
                teclado_especial = true;
                break;
            }
        }
        if (letras.indexOf(teclado) == -1 && !teclado_especial) {
            return false;
        }
    });
    $('.solo-numlet').keyup(function (){
        this.value = (this.value + '').replace(/[^a-zA-Záéíóú0-9]/g, '');
    });
    $('.solo-numero').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
    });
    $('.solo-letra').keyup(function (){
        this.value = (this.value + '').replace(/[^a-zA-Z ñáéíóú]/g, ' ');
    });
    $('.solo-numlet').keyup(function (){
        this.value = (this.value + '').replace(/[^a-zA-Z0-9]/g, '');
    });
    
    $('#pregseg1').on("change",function(){
        if ($(this).val()) {
            ObtPregSeg2();
        }
    });
    var ObtPregSeg2 = function() {
        var dataString='pregseguno='+$('#pregseg1').val();
        var url = strDir+"usuario/obtPregSegDos/";
        $.ajax({
            type: "POST",
            url: url,
            data: dataString,
            success: function(datos) {
                var html = "<option value=''>Seleccione</option>";
                $.each(JSON.parse(datos), function(index, value) {
                    html += "<option value='"+value.id+"'>"+value.pregunta+"</option>";
                });
                $('#pregseg2').html(html);
            }
        });
    }
    var Limpiar = function(sMensaje) {
        $("input[name='Email']").val("");
        $("input[name='CEmail']").val("");
        $("input[name='Nombre']").val("");
        $("input[name='Usuario']").val("");
        $("input[name='Clave']").val("");
        $("input[name='CClave']").val("");
        $("select[name='Role']").val("");
        $('#mensaje p').html(sMensaje);
        $('#mensaje').fadeOut()
            .css('display','block')
            .fadeIn('slow');
    };
});