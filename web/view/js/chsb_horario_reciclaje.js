var HoraAsignado=0;
var HoraTotal=0;
var HoraLibre=0;
var indice=0;
var indice_asignado=0;

$(document).on('ready',Principal);

  		 
		  function Principal(){
		     // $("#cedula").prop('value',$("#ci_p").prop('value'));
			   $("td[id]").on("click",Seleccionar);
		      $("td[class='asignado']").on("dblclick",function(){
		      	
              prompt(8)		      	
		      	});
		      $("td[class='asignado'] img").on("click",mostrar_alt);
		      $("#btaceptar").on("click",Enviar);
		      $("#ok").on("click",celdaID);
			  HoraAsignado=parseInt(document.getElementById("A").value);
			  HoraTotal=parseInt(document.getElementById("T").value);
			  HoraLibre=parseInt(document.getElementById("L").value);
			  $("#tb_horario").on("click",function(){
			  indice_asignado=$("td.seleccionado").size();
			  
            $("td[class=seleccionado]").on("click",function(){
        	 HoraAsignado--;
			 HoraLibre++;
			 $("#celdalibre").html(HoraLibre);
			 $("#celdaasignado").html(HoraAsignado);
			  obj=document.getElementById($(this).attr('id'));
           //obj.removeAttribute("class");			 
			  //obj.setAttribute("class","no_define");
           obj.className="no_define";
          	});			  

			 });
			 }
		
		  function mostrar_alt(){
		   valor=$(this).prop('alt');
		   alert(valor);
		  }
		  

       		
function celdaID(){
	var dataforms=document.getElementById("ventana");
	     //dataforms.style.display='block';
	     div=document.createElement('div');
	     div.innerHTML=dataforms.innerHTML;
        //JNDIV("Horas Administrativas",dataforms.innerHTML,"310",function(){ });
            overlay("block");
        }
        function overlay(p){
        	document.getElementById('fade').style.width=screen.availWidth; // ancho de la pantalla
        	document.getElementById('fade').style.height=screen.availHeight; // ancho de la pantalla
        	document.getElementById('ventana').style.display=p;
         document.getElementById('fade').style.display=p;
        	} 
		  function Seleccionar(){

			 if($(this).attr('class').replace(/^\s+|\s+$/g,'')=="no_define"){
			 if(HoraTotal>HoraAsignado){

			 HoraAsignado++;
			 HoraLibre--;
          document.getElementById($(this).attr('id')).removeAttribute("class");			 
			 $(this).addClass("seleccionado");
			 $("#celdalibre").html(HoraLibre);
			 $("#celdaasignado").html(HoraAsignado);
			 }else{
			 alert("<font style='color:red'>No puede selecciona m&#225;s "+indice_asignado+"/"+document.getElementById("L").value+"</font>");
			 }
		    }
		  }

		   function ExtraerDatos(){ 
		    $(this).removeAttr('title');
		    $(this).removeAttr('class');
		    id=$(this).prop('id')+'_vo';
		    $("#"+id).remove();
			 this.innerHTML="";
			HoraAsignado--;
			HoraLibre++;
			$("#celdalibre").html(HoraLibre);
			$("#celdaasignado").html(HoraAsignado);
		   }
		   
		   function Enviar(){
         //$('#mensagess').dialog("close");
			  var datos;
			  $("td[class=seleccionado]").each(function(i){ 
			      $(this).text("Asignado");
			      $(this).addClass("asignado");
			      $(this).removeClass("seleccionado");
				   datos=$(this).prop("id")+"-"+$("#seccion option:selected").val()+"-"+$("#ambiente option:selected").val();				   
				   datos_img=$("#seccion option:selected").val();
				   anadir_contenido($(this),datos,datos_img);
			  }); 
             // overlay("none");
		  }
		  
		   function anadir_contenido(celda,valor,datos_img){	
				var campo="<input type='hidden' name='contenidos[]' id='"+celda.prop('id')+"_vo'  value='"+valor+"'/>";
				var img="<img src='../images/marca.png' alt='"+datos_img+"'/>";
				celda.append(campo);
				celda.append(img);
				indice++;
		   }
		   function validar(){
		   if(HoraLibre==0 && HoraTotal==HoraAsignado && indice_asignado==0){
			  return true;
			 }else if(HoraLibre==0 && indice_asignado>0){
			 	if(indice_asignado>1){ pl='as';nv=indice_asignado; }else{ pl='a';nv="";}
			 	alert("<font style='color:red'>Debe agregar contenido a l"+pl+" "+nv+" celd"+pl+" seleccionad"+pl+"!</font>");
             return false;			
			}else{
			 alert("<font style='color:red'>Completar todas las horas! "+HoraAsignado+"/"+HoraTotal+"</font>");
			 return false;
			 }
		   }
