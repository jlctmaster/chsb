$(document).ready(init);
function init(){
	$('#btnGuardar').click(ValidarCampos);

	function ValidarCampos(){
		var send = true;
		//Comprobamos si el elemento cedula_persona existe para realizar la validaciones correspondientes.
		if(document.getElementById("cedula_persona")){
			arreglo = new Array();
			numero=0;
			for(i=0;i<$('#numero_preguntas').val();i++){
				numero=i+1;
				arreglo.push($('#pregunta_'+i).val());
				if($('#pregunta_'+i).val()==""){
					alert('¡Debe Ingresar la pregunta '+numero+' de seguridad!');
					send = false;
				}
				if($('#respuesta_'+i).val()==""){
					alert('¡Debe Ingresar la respuesta de la pregunta '+numero+' de seguridad!');
					send = false;
				}
			}
			if(contarRepetidos(arreglo)>0){
				alert('¡No pueden haber preguntas repetidas!')
				send = false;
			}
		}
		//Comprobamos si el elemento nueva_contrasena existe para realizar la validaciones correspondientes.
		if(document.getElementById('nueva_contrasena')){
			if(validar_contrasena()==false)
				send = false;
		}

		if(send==true)
			$('#form1').submit();
	}

	function validar_contrasena(){
		var ExpCE=new RegExp("(?=.*[`~!@#$\%\^&\*()_\|:;\"\'<>,\.\?/]{"+document.getElementById('cantidad_caracteresespeciales').value+",})");
		var ExpLMay = new RegExp("(?=.*[A-Z]{"+document.getElementById('cantidad_letrasmayusculas').value+",})");
		var ExpLMin = new RegExp("(?=.*[a-z]{"+document.getElementById('cantidad_letrasminusculas').value+",})");
		var ExpLNum = new RegExp("(?=.*[0-9]{"+document.getElementById('cantidad_numeros').value+",})");
	   	if(document.getElementById('nueva_contrasena').value.replace(/^\s+|\s+$/g, "").length==0){
	    	alert("¡Debe ingresar la contraseña!");
	      	return false;
	    }
		if(document.getElementById('nueva_contrasena').value.replace(/^\s+|\s+$/g, "")!=document.getElementById('confirmar_contrasena').value.replace(/^\s+|\s+$/g,"")){
	        alert("¡Las contrase\u00f1as ingresadas no coeciden!");
	      	return false;
	    }
	    if(!(ExpCE.test(document.getElementById('nueva_contrasena').value))){
	    	alert("<div style='text-align:left;'>La contrase\u00f1a debe tener:</br> "+
				"* Al menos "+document.getElementById('cantidad_letrasmayusculas').value+" letra(s) may\u00fascula(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_letrasminusculas').value+" letra(s) min\u00fascula(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_numeros').value+" n\u00famero(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_caracteresespeciales').value+" car\u00e1cter(es) especial(es). pj: ` ~ ! @ # $ \% \^ & \* ( ) _ \| : ; \" \' < > , \. \? / </br> "+
				"* Una longitud que sea como m\u00ednimo "+document.getElementById('longitud_minclave').value+" car\u00e1cteres. </br> "+
				"* Una longitud que sea como m\u00e1ximo "+document.getElementById('longitud_maxclave').value+" car\u00e1cteres.</div>");
	      	return false;
	    }
		else if(!(ExpLMin.test(document.getElementById('nueva_contrasena').value))){
			alert("<div style='text-align:left;'>La contrase\u00f1a debe tener:</br> "+
				"* Al menos "+document.getElementById('cantidad_letrasmayusculas').value+" letra(s) may\u00fascula(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_letrasminusculas').value+" letra(s) min\u00fascula(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_numeros').value+" n\u00famero(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_caracteresespeciales').value+" car\u00e1cter(es) especial(es). pj: ` ~ ! @ # $ \% \^ & \* ( ) _ \| : ; \" \' < > , \. \? / </br> "+
				"* Una longitud que sea como m\u00ednimo "+document.getElementById('longitud_minclave').value+" car\u00e1cteres. </br> "+
				"* Una longitud que sea como m\u00e1ximo "+document.getElementById('longitud_maxclave').value+" car\u00e1cteres.</div>");
	      	return false;
	    }
		else if(!(ExpLMay.test(document.getElementById('nueva_contrasena').value))){
			alert("<div style='text-align:left;'>La contrase\u00f1a debe tener:</br> "+
				"* Al menos "+document.getElementById('cantidad_letrasmayusculas').value+" letra(s) may\u00fascula(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_letrasminusculas').value+" letra(s) min\u00fascula(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_numeros').value+" n\u00famero(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_caracteresespeciales').value+" car\u00e1cter(es) especial(es). pj: ` ~ ! @ # $ \% \^ & \* ( ) _ \| : ; \" \' < > , \. \? / </br> "+
				"* Una longitud que sea como m\u00ednimo "+document.getElementById('longitud_minclave').value+" car\u00e1cteres. </br> "+
				"* Una longitud que sea como m\u00e1ximo "+document.getElementById('longitud_maxclave').value+" car\u00e1cteres.</div>");
	      	return false;
	    }
		else if(!(ExpLNum.test(document.getElementById('nueva_contrasena').value))){
			alert("<div style='text-align:left;'>La contrase\u00f1a debe tener:</br> "+
				"* Al menos "+document.getElementById('cantidad_letrasmayusculas').value+" letra(s) may\u00fascula(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_letrasminusculas').value+" letra(s) min\u00fascula(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_numeros').value+" n\u00famero(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_caracteresespeciales').value+" car\u00e1cter(es) especial(es). pj: ` ~ ! @ # $ \% \^ & \* ( ) _ \| : ; \" \' < > , \. \? / </br> "+
				"* Una longitud que sea como m\u00ednimo "+document.getElementById('longitud_minclave').value+" car\u00e1cteres. </br> "+
				"* Una longitud que sea como m\u00e1ximo "+document.getElementById('longitud_maxclave').value+" car\u00e1cteres.</div>");
	      	return false;
	    }
	    else if(document.getElementById('nueva_contrasena').value.replace(/^\s+|\s+$/g, "").length<document.getElementById('longitud_minclave').value){
			alert("<div style='text-align:left;'>La contrase\u00f1a debe tener:</br> "+
				"* Al menos "+document.getElementById('cantidad_letrasmayusculas').value+" letra(s) may\u00fascula(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_letrasminusculas').value+" letra(s) min\u00fascula(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_numeros').value+" n\u00famero(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_caracteresespeciales').value+" car\u00e1cter(es) especial(es). pj: ` ~ ! @ # $ \% \^ & \* ( ) _ \| : ; \" \' < > , \. \? / </br> "+
				"* Una longitud que sea como m\u00ednimo "+document.getElementById('longitud_minclave').value+" car\u00e1cteres. </br> "+
				"* Una longitud que sea como m\u00e1ximo "+document.getElementById('longitud_maxclave').value+" car\u00e1cteres.</div>");
	      	return false;
	    }
	    else if(document.getElementById('nueva_contrasena').value.replace(/^\s+|\s+$/g, "").length>document.getElementById('longitud_maxclave').value){
			alert("<div style='text-align:left;'>La contrase\u00f1a debe tener:</br> "+
				"* Al menos "+document.getElementById('cantidad_letrasmayusculas').value+" letra(s) may\u00fascula(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_letrasminusculas').value+" letra(s) min\u00fascula(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_numeros').value+" n\u00famero(s).</br> "+
				"* Al menos "+document.getElementById('cantidad_caracteresespeciales').value+" car\u00e1cter(es) especial(es). pj: ` ~ ! @ # $ \% \^ & \* ( ) _ \| : ; \" \' < > , \. \? / </br> "+
				"* Una longitud que sea como m\u00ednimo "+document.getElementById('longitud_minclave').value+" car\u00e1cteres. </br> "+
				"* Una longitud que sea como m\u00e1ximo "+document.getElementById('longitud_maxclave').value+" car\u00e1cteres.</div>");
	      	return false;
	    }
	    return true;
	}

	function contarRepetidos(arreglo){
	    var arreglo2 = arreglo;
	    var con=0;
	    for (var m=0; m<arreglo2.length; m++)
	    {
	        for (var n=0; n<arreglo2.length; n++)
	        {
	            if(n!=m)
	            {
	                if(arreglo2[m]==arreglo2[n])
	                {
	                	con++;
	                }
	            }
	        }
	    }
	    return con;
	}

	String.prototype.trim = function(){ return this.replace(/^\s+|\s+$/g, ""); };// para cortar espacio en blanco en un cadena similar a trim()  php y mysql
}