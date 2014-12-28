$(document).ready(init);
function init(){
    //Funciones, Validaciones y Metodos implementados en el Sistema.
    //Definir lenguaje Español al Objeto Calendario.
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '&#x3c;Ant',
        nextText: 'Sig&#x3e;',
        currentText: 'Hoy',
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
        'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
        'Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
        dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
        //weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        changeMonth: true,
        changeYear: true
    };
    $.datepicker.setDefaults($.datepicker.regional["es"]);
	//Definir lenguaje Español al Objeto de Tiempo.
	$.timepicker.regional['es'] = {
			timeOnlyTitle: 'Elegir una hora',
			timeText: 'Hora',
			hourText: 'Horas',
			minuteText: 'Minutos',
			secondText: 'Segundos',
			millisecText: 'Milisegundos',
			timezoneText: 'Huso horario',
			currentText: 'Ahora',
			closeText: 'Cerrar',
			timeFormat: 'hh:mm',
			amNames: ['a.m.', 'AM', 'A'],
			pmNames: ['p.m.', 'PM', 'P'],
			ampm: false
	};
	$.timepicker.setDefaults($.timepicker.regional['es']);
    //Agregar Objeto Calendario al input fecha_inicio.
    $('#fecha_inicio').datepicker({
        showOn: 'both',
        numberOfMonths: 1,
        buttonImage: '../images/calendario.png',
        buttonImageOnly: true,
        onClose: function (selectedDate) {
            $("#fecha_inicio").datepicker("option", "minDate", selectedDate)
        }
    });
    //Agregar Objeto Calendario al input fecha_fin.
    $('#fecha_fin').datepicker({
        showOn: 'both',
        numberOfMonths: 1,
        buttonImage: '../images/calendario.png',
        buttonImageOnly: true,
        onClose: function (selectedDate) {
            $("#fecha_fin").datepicker("option", "maxDate", selectedDate)
        }
    });
    //Agregar Objeto Calendario al input vigencia_desde.
    $('#dvigencia_desde').datepicker({
        showOn: 'both',
        numberOfMonths: 1,
        buttonImage: '../images/calendario.png',
        buttonImageOnly: true,
        onClose: function (selectedDate) {
            $("#dvigencia_hasta").datepicker("option", "minDate", selectedDate)
        }
    });
    //Agregar Objeto Calendario al input vigencia_hasta.
    $('#dvigencia_hasta').datepicker({
        showOn: 'both',
        numberOfMonths: 1,
        buttonImage: '../images/calendario.png',
        buttonImageOnly: true,
        onClose: function (selectedDate) {
            $("#dvigencia_desde").datepicker("option", "maxDate", selectedDate)
        }
    });
    //Agregar Objeto Calendario al input fecha.
    $('#fecha').datepicker({
        maxDate: '-18y',
        showOn: 'both',
        numberOfMonths: 1,
        buttonImageOnly: true
    });
    //Agregar Objeto Calendario al input fecha documento.
    $('#dfecha_documento').datepicker({
        minDate: '-2d',
        maxDate: '0d',
        showOn: 'both',
        numberOfMonths: 1,
        buttonImage: '../images/calendario.png',
        buttonImageOnly: true
    });
    //Agregar Objeto Calendario al input fecha documento.
    $('#dfecha_devolucion').datepicker({
        minDate: '-2d',
        maxDate: '0d',
        showOn: 'both',
        numberOfMonths: 1,
        buttonImage: '../images/calendario.png',
        buttonImageOnly: true
    });
    //Agregar Objeto Calendario al input fecha de entrega o recibo.
    $('#dfecha_recepcion_entrega').datepicker({
        maxDate: '0d',
        showOn: 'both',
        numberOfMonths: 1,
        buttonImage: '../images/calendario.png',
        buttonImageOnly: true
    });
    //Agregar Objeto Calendario al input fecha_nacimiento.
    $('#fecha_nacimiento').datepicker({
        maxDate: '-18y',
        showOn: 'both',
        numberOfMonths: 1,
        buttonImageOnly: true
    });
        //Agregar Objeto Calendario al input fecha_nacimiento.
    $('#fecha_nacimiento_estudiante').datepicker({
        maxDate: '-18y',
        showOn: 'both',
        numberOfMonths: 1,
        buttonImageOnly: true
    });
    //Agregar Objeto Calendario al input fecha_adquisicion.
    $('#fecha_adquisicion').datepicker({
        showOn: 'both',
        numberOfMonths: 1,
        buttonImage: '../images/calendario.png',
        buttonImageOnly: true
    });

	//Agregar Objeto de Horas al input hora_inicio
	$('#hora_inicio').timepicker({
		hourGrid: 4,
		minuteGrid: 10,
		timeFormat: 'hh:mm tt'
	});
	//Agregar Objeto de Horas al input hora_fin
	$('#hora_fin').timepicker({
		hourGrid: 4,
		minuteGrid: 10,
		timeFormat: 'hh:mm tt'
	});
}

function comboDependiente(value,url,object){
        $.ajax({
            url: url,
            type: 'POST',
            data: value,
            dataType: 'JSON',
            success: function(resp){
                var options = '<option value=0>Seleccione</option>'; 
                var campooculto=$('#hide').val();
                for (var i = 0; i < resp.length; i++) { 
                    if(resp[i].id == campooculto){
                        if(resp[i].id == ""){
                            options += '<option value="NULL" selected>' + resp[i].name + '</option>';
                        }
                        else{
                            options += '<option value="' + resp[i].id + '" selected>' + resp[i].name + '</option>';
                        }
                    }
                    else{
                        if(resp[i].id == ""){
                            options += '<option value="NULL">' + resp[i].name + '</option>';
                        }
                        else{
                            options += '<option value="' + resp[i].id + '">' + resp[i].name + '</option>';
                        }
                    }
                }
                object.html(options);
                //object.attr('selected', 'selected'); 
            },
            error: function(){
                alert("¡Error al procesar la petición!");
            }
        });
    }

function salir(){
    noty({
        text: stringUnicode("¿Está seguro que quiere salir?"),
        layout: "center",
        type: "confirm",
        dismissQueue: true,
        animateOpen: {"height": "toggle"},
        animateClose: {"height": "toggle"},
        theme: "defaultTheme",
        closeButton: false,
        closeOnSelfClick: true,
        closeOnSelfOver: false,
        buttons: [
        {
            addClass: 'btn btn-primary', text: 'Aceptar', onClick: function($noty){
                noty({dismissQueue: true, force: true, layout: "center", theme: 'defaultTheme', text: stringUnicode('¡Hasta luego!'), type: 'error'});
                $noty.close();
                setInterval(function(){
                    location.href="../controladores/control_desconectar.php";
                },2000)
            }
        },
        {
            addClass: 'btn btn-danger', text: 'Cancelar', onClick: function($noty){
                $noty.close();
                noty({dismissQueue: true, force: true, layout: "center", theme: 'defaultTheme', text: stringUnicode('¡Gracias por permanecer en la página!'), type: 'success'});
            }
        }
        ]
    })
}

//Asignamos al alert la configuración de noty
window.alert = function (message) {
noty({"text": stringUnicode(message),
 "layout":"center","type":"alert","animateOpen":{"height":"toggle"},
 "animateClose":{"height":"toggle"},"speed":500,
 "timeout":5000,"closeButton":false,"closeButton":true,"closeOnSelfClick":true,
 "closeOnSelfOver":false});
}

function limpiar(){
    Limpiar2();
    habilitarElementos();
    $("input[type=text]").each(function(i){
			$($(this)).val('');
	});
	$("body input[type=radio]").each(function(){	
			$($(this)).attr('checked',false);
	});
	$("input[type=checkbox]").each(function(){	
			$($(this)).attr('checked',false);
	});
   $("textarea").each(function(){	
			$($(this)).html('');
	});
   $("select option[value=''],select option[value='null'],select option[value='0']").attr("selected",true);
   
}

function habilitarElementos(){
    $('#form').find('input[type=text],input[type=radio],input[type=checkbox],input[type=hidden],textarea,select').removeAttr("disabled");
    $('#form1').find('input[type=text],input[type=radio],input[type=checkbox],input[type=hidden],textarea,select').removeAttr("disabled");
    $('#form2').find('input[type=text],input[type=radio],input[type=checkbox],input[type=hidden],textarea,select').removeAttr("disabled");
}


function Limpiar2(){
    if(document.getElementsByTagName("input"))
        var e=document.getElementsByTagName("input");

	if(document.getElementsByTagName("textarea"))
        var e1=document.getElementsByTagName("textarea");

	if(document.getElementsByTagName("option"))
        var e2=document.getElementsByTagName("option");

	if(document.getElementsByTagName("select"))
        var e3=document.getElementsByTagName("select");

    if(document.getElementsByTagName("select")){
        for(z=0;z<e3.length;z++){
            e3[z].options[0].selected=true;
        }
    }
    
    if(document.getElementsByTagName("textarea")){
        for(z=0;z<e1.length;z++){
            e1[z].innerHTML="";
        }
    }		

    if(document.getElementsByTagName("input")){
        for(i=0;i<e.length;i++){
            if(e[i].type=="text"){
                e[i].value="";
            }else if(e[i].type=="password" && e[i].readOnly!=true){
                var x=1;
                e[i].value="";
            }else if(e[i].type=="radio"){
                e[i].checked="";
            }
        }
    }

    if(document.getElementsByTagName("input")){
        for(i=0;i<e.length;i++){
            if(e[i].type=="button"){
                if(e[i].id=="1" || e[i].id=="5"){
                    e[i].disabled=false;
                }
                if(e[i].id=="2" || e[i].id=="3" || e[i].id=="4"){
                    e[i].disabled=true;
                }
                if(e[1].id="2" && x==1){
                    e[i].disabled=false;
                }
            }
        }
    }
    if(document.getElementById('estatus_registro'))
        document.getElementById('estatus_registro').innerHTML='';
}

//Función para escribir solo números.
function isNumberKey(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
        return false;
     return true;
  }

//Función para escribir solo números de documentos.
function isNumberDocKey(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && charCode != 94)
        return false;
     return true;
  }

//Función para escribir solo Rif o Cédulas.
function isRif(evt,object)
  {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if(object.length<1){
        if (charCode != 103 && charCode != 106 && charCode != 118)
            return false;
        return true;

    }else{
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
            return false;
        return true;
    }
  }

function devuelve_boton(orden){
     if(orden==1)
     return 'Registrar';
     else
     if(orden==2)
     return 'Modificar';	    
     else         
     if(orden==3)
     return 'Desactivar';	    
     else        
     if(orden==4)
     return 'Activar';	    
     else        
     if(orden==5)
     return 'Consultar';	    
      else        
     if(orden==6)
     return 'Cancelar';
     else        
     if(orden==7)
     return 'Listar';	
     else
     return 'Desconocido'          	    
   }

function stringUnicode(str){
    str = str.replace(' ','\u00a0');//espacio sin separación.
    str = str.replace('¡','\u00a1');//signo de apertura de exclamación.
    str = str.replace('¢','\u00a2');//signo de centavo.
    str = str.replace('£','\u00a3');//signo de Libra Esterlina.
    str = str.replace('¤','\u00a4');//signo de divisa general.
    str = str.replace('¥','\u00a5');//signo de yen.
    str = str.replace('¦','\u00a6');//barra vertical partida.
    str = str.replace('§','\u00a7');//signo de sección.
    str = str.replace('¨','\u00a8');//diéresis - umlaut.
    str = str.replace('©','\u00a9');//signo de derechos de autor - copyright.
    str = str.replace('ª','\u00aa');//género feminino - indicador ordinal f.
    str = str.replace('«','\u00ab');//comillas anguladas de apertura.
    str = str.replace('¬','\u00ac');//signo de no - símbolo lógico.
    str = str.replace('®','\u00ae');//signo de marca registrada.
    str = str.replace('¯','\u00af');//macrón - raya alta.
    str = str.replace('°','\u00b0');//signo de grado.
    str = str.replace('±','\u00b1');//signo de más o menos.
    str = str.replace('²','\u00b2');//superíndice dos - cuadrado.
    str = str.replace('³','\u00b3');//superíndice tres - cúbico.
    str = str.replace('´','\u00b4');//acento agudo - agudo espaciado.
    str = str.replace('µ','\u00b5');//signo de micro.
    str = str.replace('¶','\u00b6');//signo de fin de párrafo.
    str = str.replace('·','\u00b7');//punto medio - coma Georgiana.
    str = str.replace('¸','\u00b8');//cedilla.
    str = str.replace('¹','\u00b9');//superíndice uno.
    str = str.replace('º','\u00ba');//género masculino - indicador ordinal m.
    str = str.replace('»','\u00bb');//comillas anguladas de cierre.
    str = str.replace('¼','\u00bc');//fracción un cuarto.
    str = str.replace('½','\u00bd');//fracción medio - mitad.
    str = str.replace('¾','\u00be');//fracción tres cuartos.
    str = str.replace('¿','\u00bf');//signo de interrogación - apertura.
    str = str.replace('À','\u00c0');//A mayúscula con acento grave.
    str = str.replace('Á','\u00c1');//A mayúscula con acento agudo.
    str = str.replace('Â','\u00c2');//A mayúscula con acento circunflejo.
    str = str.replace('Ã','\u00c3');//A mayúscula con tilde.
    str = str.replace('Ä','\u00c4');//A mayúscula con diéresis.
    str = str.replace('Å','\u00c5');//A mayúscula con anillo.
    str = str.replace('Æ','\u00c6');//diptongo AE mayúscula (ligadura).
    str = str.replace('Ç','\u00c7');//C cedilla mayúscula.
    str = str.replace('È','\u00c8');//E mayúscula con acento grave.
    str = str.replace('É','\u00c9');//E mayúscula con acento agudo.
    str = str.replace('Ê','\u00ca');//E mayúscula con acento circunflejo.
    str = str.replace('Ë','\u00cb');//E mayúscula con diéresis.
    str = str.replace('Ì','\u00cc');//I mayúscula con acento grave.
    str = str.replace('Í','\u00cd');//I mayúscula con acento agudo.
    str = str.replace('Î','\u00ce');//I mayúscula con acento circunflejo.
    str = str.replace('Ï','\u00cf');//I mayúscula con diéresis.
    str = str.replace('Ð','\u00d0');//ETH islandesa mayúscula.
    str = str.replace('Ñ','\u00d1');//N mayúscula con tilde - eñe.
    str = str.replace('Ò','\u00d2');//O mayúscula con acento grave.
    str = str.replace('Ó','\u00d3');//O mayúscula con acento agudo.
    str = str.replace('Ô','\u00d4');//O mayúscula con acento circunflejo.
    str = str.replace('Õ','\u00d5');//O mayúscula con tilde.
    str = str.replace('Ö','\u00d6');//O mayúscula con diéresis.
    str = str.replace('×','\u00d7');//signo de multiplicación.
    str = str.replace('Ø','\u00d8');//O mayúscula with slash.
    str = str.replace('Ù','\u00d9');//U mayúscula con acento grave.
    str = str.replace('Ú','\u00da');//U mayúscula con acento agudo.
    str = str.replace('Û','\u00db');//U mayúscula con acento circunflejo.
    str = str.replace('Ü','\u00dc');//U mayúscula con diéresis.
    str = str.replace('Ý','\u00dd');//Y mayúscula con acento agudo.
    str = str.replace('Þ','\u00de');//THORN islandesa mayúscula.
    str = str.replace('ß','\u00df');//s minúscula (alemán) - Beta minúscula.
    str = str.replace('à','\u00e0');//a minúscula con acento grave.
    str = str.replace('á','\u00e1');//a minúscula con acento agudo.
    str = str.replace('â','\u00e2');//a minúscula con acento circunflejo.
    str = str.replace('ã','\u00e3');//a minúscula con tilde.
    str = str.replace('ä','\u00e4');//a minúscula con diéresis.
    str = str.replace('å','\u00e5');//a minúscula con anillo.
    str = str.replace('æ','\u00e6');//diptongo ae minúscula (ligadura).
    str = str.replace('ç','\u00e7');//c cedilla minúscula.
    str = str.replace('è','\u00e8');//e minúscula con acento grave.
    str = str.replace('é','\u00e9');//e minúscula con acento agudo.
    str = str.replace('ê','\u00ea');//e minúscula con acento circunflejo.
    str = str.replace('ë','\u00eb');//e minúscula con diéresis.
    str = str.replace('ì','\u00ec');//i minúscula con acento grave.
    str = str.replace('í','\u00ed');//i minúscula con acento agudo.
    str = str.replace('î','\u00ee');//i minúscula con acento circunflejo.
    str = str.replace('ï','\u00ef');//i minúscula con diéresis.
    str = str.replace('ð','\u00f0');//eth islandesa minúscula.
    str = str.replace('ñ','\u00f1');//eñe minúscula - n minúscula con tilde.
    str = str.replace('ò','\u00f2');//o minúscula con acento grave.
    str = str.replace('ó','\u00f3');//o minúscula con acento agudo.
    str = str.replace('ô','\u00f4');//o minúscula con acento circunflejo.
    str = str.replace('õ','\u00f5');//o minúscula con tilde.
    str = str.replace('ö','\u00f6');//o minúscula con diéresis.
    str = str.replace('÷','\u00f7');//signo de división.
    str = str.replace('ø','\u00f8');//o barrada minúscula.
    str = str.replace('ù','\u00f9');//u minúscula con acento grave.
    str = str.replace('ú','\u00fa');//u minúscula con acento agudo.
    str = str.replace('û','\u00fb');//u minúscula con acento circunflejo.
    str = str.replace('ü','\u00fc');//u minúscula con diéresis.
    str = str.replace('ý','\u00fd');//y minúscula con acento agudo.
    str = str.replace('þ','\u00fe');//thorn islandesa minúscula.
    str = str.replace('ÿ','\u00ff');//y minúscula con diéresis.
    str = str.replace('Œ','\u0152');//OE mayúscula (ligadura).
    str = str.replace('œ','\u0153');//oe minúscula (ligadura).
    str = str.replace('Š','\u0160');//S mayúscula con caron.
    str = str.replace('š','\u0161');//s minúscula con caron - acento hacek.
    str = str.replace('Ÿ','\u0178');//Y mayúscula con diéresis.
    str = str.replace('ƒ','\u0192');//f minúscula itálica - signo de función.
    str = str.replace('–','\u2013');//raya corta.
    str = str.replace('——','\u2014');//raya larga.
    str = str.replace('‘','\u2018');//comilla izquierda - citación.
    str = str.replace('’','\u2019');//comilla derecha - citación.
    str = str.replace('‚','\u201a');//comilla de citación - baja.
    str = str.replace('“','\u201c');//comillas de citación - arriba izquierda.
    str = str.replace('”','\u201d');//comillas de citación - arriba derecha.
    str = str.replace('„','\u201e');//comillas de citación - abajo.
    str = str.replace('†','\u2020');//cruz.
    str = str.replace('‡','\u2021');//doble cruz.
    str = str.replace('•','\u2022');//viñeta - bullet.
    str = str.replace('…','\u2026');//puntos suspensivos.
    str = str.replace('‰','\u2030');//signo de pro mil.
    str = str.replace('€','\u20ac');//signo de euro.
    str = str.replace('™','\u2122');//signo de marca registrada - trade mark.

    return str;//Regresa la cadena codificada con unicode.
}