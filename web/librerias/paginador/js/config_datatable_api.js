/* Modificación de la clase predeterminada */
$.extend( $.fn.dataTableExt.oStdClasses, {
	"sSortAsc": "header headerSortDown",
	"sSortDesc": "header headerSortUp",
	"sSortable": "header"
} );

/* Método de la API para obtener información de paginación */
$.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
{
	return {
		"iStart":         oSettings._iDisplayStart,
		"iEnd":           oSettings.fnDisplayEnd(),
		"iLength":        oSettings._iDisplayLength,
		"iTotal":         oSettings.fnRecordsTotal(),
		"iFilteredTotal": oSettings.fnRecordsDisplay(),
		"iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
		"iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
	};
}

/* Control de la paginación del estilo Bootstrap */
$.extend( $.fn.dataTableExt.oPagination, {
	"bootstrap": {

		"fnInit": function( oSettings, nPaging, fnDraw ) {
			var oLang = oSettings.oLanguage.oPaginate;
			var fnClickHandler = function ( e ) {
				e.preventDefault();
				if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
					fnDraw( oSettings );
				}
			};

			$(nPaging).addClass('pagination').append(
				'<ul>'+
				'<li><a href="#">&laquo;'+oLang.sPrevious+'</a></li>'+
				'<li><a href="#">'+oLang.sNext+'&raquo;</a></li>'+
				'</ul>'
			);

			var els = $('a', nPaging);
			$(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
			$(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
		},

		"fnUpdate": function ( oSettings, fnDraw ) {
			var iListLength = 5;
			var oPaging = oSettings.oInstance.fnPagingInfo();
			var an = oSettings.aanFeatures.p;
			var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

			if ( oPaging.iTotalPages < iListLength) {
				iStart = 1;
				iEnd = oPaging.iTotalPages;
			}
			else if ( oPaging.iPage <= iHalf ) {
				iStart = 1;
				iEnd = iListLength;
			} else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
				iStart = oPaging.iTotalPages - iListLength + 1;
				iEnd = oPaging.iTotalPages;
			} else {
				iStart = oPaging.iPage - iHalf + 1;
				iEnd = iStart + iListLength - 1;
			}

			for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
				// Remover los elementos intermedios
				$('li:gt(0)', an[i]).filter(':not(:last)').remove();

				// Añadir los nuevos elementos de la lista y sus controladores de eventos
				for ( j=iStart ; j<=iEnd ; j++ ) {
					sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
					$('<li '+sClass+'><a href="#">'+j+'</a></li>')
					.insertBefore( $('li:last', an[i])[0] )
					.bind('click', function (e) {
						e.preventDefault();
						oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
						fnDraw( oSettings );
					});
				}

				// agregar/quitar clases desabilitadas a partir de los elementos estáticos
				if ( oPaging.iPage === 0 ) {
					$('li:first', an[i]).addClass('disabled');
				} else {
					$('li:first', an[i]).removeClass('disabled');
				}

				if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
					$('li:last', an[i]).addClass('disabled');
				} else {
					$('li:last', an[i]).removeClass('disabled');
				}
			}
		}
	}
});

/* Configuración del dataTable */

$(document).ready(function(){
$('#registro').dataTable({
		// sDom: hace un espacio entre la tabla y los controles 
		"sDom": "<'row'<'span8'l><'span8'f>r>t<'row'<'span8'i><'span8'p>>",

		"sPaginationType": "bootstrap",
		
		"oLanguage": {

		    "sInfo": "Total registros: _TOTAL_ / Mostrados: _START_ de _END_",

		    "sInfoEmpty": "Mostrando 0 hasta 0 de 0 registros",

			"sZeroRecords": "No se encontr&oacute; el registro",

			"sLengthMenu": "_MENU_ Registros por página",

			"sSearch": "Buscar: ",

			"sInfoFiltered": "( Filtrado de _MAX_ registros )",

			"oPaginate": {
			    "sPrevious": " ",
				"sNext": " ",
				"sFirst": "Primero",
				"sLast": "Último",
			}
		}
	});
});