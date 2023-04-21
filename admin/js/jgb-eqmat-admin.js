
	

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	var dttbl = null;

	function selection_data_render(data, type) {
        if (type === 'display') {
            let selection = '';
            if(data == true){
                selection = 'checked';
            }

            return '<input type="checkbox" ' + selection + ' class="em-mp-checker"/>' ;
        }
         
        return data;
    }

	function actions_data_status(data, type){
		if (type === 'display') {
            let selection = '';
            if(data == true){
                selection = 'checked';
            }

            return '<input type="checkbox" ' + selection + ' class="em-mp-status-checker"/>' ;
        }
         
        return data;
	}

	function actions_data_render(data, type){
		if (type === 'display') {
			var output = '';
			output += '<div class="actions">';

			output += '<div class="action edit-em-mp">';
			output += '<i class="fas fa-edit"></i>';
			output += '</div>';

			output += '<div class="action send-em-mp-status">';
			output += '<i class="fas fa-paper-plane"></i>';
			output += '</div>';

			output += '<div class="action remove-em-mp">';
			output += '<i class="fas fa-minus-circle"></i>';
			output += '</div>';

			output += '</div>';
            return output ;
        }
         
        return data;
	}

	(function( $ ) {
	'use strict';
		const bluckUICOnfig = { css: { backgroundColor: '#f00', color: '#fff', 'border-radius': '10px', padding: '10px 0px' }, message: 'Procesando la solicitud...' };

		let currentEditionEmmpId;
		let currentEditionDosfTR;
		let emmpAddNewSentTryErrorCondMsg = '';
		let delConfirmtnDlg;
		let istr; // Ids to remove.
		let choiceEmls;
		let dtColumns = [];
		

		dtColumns.push(
			{
				data: null,
				render: selection_data_render
			}
		);

		dtColumns.push(
			{
				data: 'serie'
			}
		);

		dtColumns.push(
			{
				data: 'model'
			}
		);

		
		dtColumns.push(
			{
				data: 'et_delivery'
			}
		);
		
		dtColumns.push(
			{
				data: 'emails'
			}
		);

		dtColumns.push(
			{
				data: 'status',
				render: actions_data_status
			}
		);

		dtColumns.push(
			{
				data: 'active'
			}
		);
		
		dtColumns.push(
			{
				data: null,
				render: actions_data_render
			}
		);

		function onDttblCreatedRow( row, data, dataIndex, cells ){
			const atid = data['DT_RowData']['attachment-id'];
			$(row).data('attachment-id',atid);
		}

		$(document).ready(function ($) {

			dttbl = $('#eqmnt-dttbl').DataTable( {
				processing: true,
				serverSide: true,
				ajax: JGB_EQMAT.urlEquipments,
				language: {
					url: 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/es-cl.json'
				},
				columns: dtColumns,
				drawCallback: onDttblDraw,
				createdRow: onDttblCreatedRow
			} );	

			delConfirmtnDlg = $('#confirm-del-dlg').dialog({
				modal: true,
				autoOpen: false,
				draggable: false,
				resizable: false,
				closeText: "Cancelar",
				buttons:[
					{
						text: 'Si, eliminar',
						click: function(){
							$.blockUI(bluckUICOnfig); 
							sendDosfRemovRequest();
							$( this ).dialog( "close" );
							
						}
					}
				]
			});

			function onDttblDraw(){
				const itemActionReqSendDwldCodeSelector = '.action.send-dosf-download-code';
				$(itemActionReqSendDwldCodeSelector).off('click');
				$(itemActionReqSendDwldCodeSelector).on('click',dttblItemActionReqSendSttsEmail);

				const itemActionEditionCodeSelector = '.action.edit-dosf';
				$(itemActionEditionCodeSelector).off('click');
				$(itemActionEditionCodeSelector).on('click',setWidgetsForEmmpEdition);

				const itemActionReqRemoveCodeSelector = '.action.remove-dosf';
				$(itemActionReqRemoveCodeSelector).off('click');
				$(itemActionReqRemoveCodeSelector).on('click',dttblItemActionReqRemoveDosf);

				const itemDosfCheckerSelector = '.dosf-checker';
				$(itemDosfCheckerSelector).off('click');
				$(itemDosfCheckerSelector).on('click',dttblItemDosfChecker);
			}

			function dttblItemDosfChecker(){
				let i;
				istr = [];
				let dcdAr = $('.dosf-checker');
				if( dcdAr.length > 0 ){
					for( i = 0; i < dcdAr.length; i++ ){
						if( $( dcdAr[i] ).is(":checked") )
							istr.push(  $( dcdAr[i] ).closest('tr').attr('id') );
					}
					if( istr.length > 0 ){
						if( $('#rem-dosf').hasClass('disabled') ){
							$('#rem-dosf').removeClass('disabled');
						}
						
					} else {
						if( !$('#rem-dosf').hasClass('disabled') ){
							$('#rem-dosf').addClass('disabled');
						}
					}
				}else{
					if( !$('#rem-dosf').hasClass('disabled') ){
						$('#rem-dosf').addClass('disabled');
					}
				}
			}

			function sendDosfRemovRequest(){
				const ac = {
					method: 'DELETE',
					url: JGB_EQMAT.urlEquipments,
					data: JSON.stringify({istr: istr}),
					accepts: 'application/json; charset=UTF-8',
					contentType: 'application/json; charset=UTF-8',
					complete: function(jqXHR, textStatus){
						
						$.unblockUI();
						dttbl.ajax.reload();
					}
				}

				$.ajax(ac);
			}

			function dttblItemActionReqRemoveDosf(){
				istr = [ $(this).closest('tr').attr('id') ];
				delConfirmtnDlg.dialog('open');
			}

			function dttblItemActionReqSendSttsEmail(){
				$.blockUI(bluckUICOnfig);
				const dosf_id = $(this).parent().parent().parent().attr('id');
				const ajxSettings = {
					method: 'GET',
					url: JGB_EQMAT.urlSndStts + dosf_id,
					accepts: 'application/json; charset=UTF-8',
					contentType: 'application/json; charset=UTF-8',
					complete: onDosfReqSendDwldCdComplete,
					success: onDosfReqSendDwldCdSuccess,
					error: onDosfReqSendDwldCdError
				}
				
				$.ajax(ajxSettings);
			}

			function onDosfReqSendDwldCdComplete( jqXHR, textStatus ){
				// Desactivar icono de progreso.
				$.unblockUI();
			}

			function onDosfReqSendDwldCdSuccess( data,  textStatus,  jqXHR ){
				console.log('Solicitud enviada al servidor exitosamente');
				console.log('Respuesta del servidor:');
				console.log(data);
			}

			function onDosfReqSendDwldCdError( jqXHR, textStatus, errorThrown ){
				console.log('Error al enviar la Solicitud de envío de email de código de descarga');
				console.log('Respuesta del servidor:');
				console.log(jqXHR);
			}

			function resetEmmpAddFields(){
				$( '#eqmnt-serie' ).val('');
				$( '#eqmnt-model').val(''),
				$( '#eqmnt-et-delivery' ).val('');
				$( '#eqmnt-ruts' ).text(''),
				choiceEmls.clearStore();

				
				if( !$('.dosf-admin-add-so .notice.notice-error').hasClass('hidden') ){
					$('.dosf-admin-add-so .notice.notice-error').addClass('hidden')
				}
			}

			function dumpDataToDosfAddFields(){
				let cell = $(currentEditionDosfTR).children()[1];
				let vl 	 = $(cell).text();
				$( '#dosf_so_title' ).val(vl);

				cell = $(currentEditionDosfTR).children()[2];
				vl 	 = $(cell).text();
				$( '#dosf_so_emision' ).val(vl);

				cell = $(currentEditionDosfTR).children()[4];
				vl 	 = $(cell).text();
				$( '#dosf_so_ruts_linked' ).val(vl);

				cell = $(currentEditionDosfTR).children()[5];
				vl 	 = $(cell).text().split(',');
				choiceEmls.clearStore();
				choiceEmls.setValue(vl);


				$( '#dosf_attachment_id').val( $(currentEditionDosfTR).data('attachment-id') );

				cell = $(currentEditionDosfTR).children()[3];
				vl 	 = $(cell).text();
				$( '#dosf-file-selectd' ).text(vl);
				
				if( !$('.dosf-admin-add-so .notice.notice-error').hasClass('hidden') ){
					$('.dosf-admin-add-so .notice.notice-error').addClass('hidden')
				}
				
			}

			function setWidgetsForEmmpAddNew(){
				currentEditionEmmpId = null;
				$('.eqmnt-item-add-edit > .title').text('Agregando nuevo mantención de equipo.');
				$('#jgb-eqmat-admin .eqmnt-buttons').hide();
				$('#jgb-eqmat-admin .main-content').hide();
				resetEmmpAddFields();
				$('.eqmnt-item-add-edit').show();
			}

			function setWidgetsForEmmpEdition(){

				currentEditionDosfTR = $(this).closest('tr');
				currentEditionEmmpId = $(currentEditionDosfTR).attr('id');
				$('.eqmnt-item-add-edit > .title').text('Modificando certificado con ID interno ' + currentEditionEmmpId + '.');
				$('#jgb-eqmat-admin .eqmnt-buttons').hide();
				$('#jgb-eqmat-admin .main-content').hide();
				dumpDataToDosfAddFields();
				$('.eqmnt-item-add-edit').show();
			}

			function setWidgetsForEmmpAddedOrCanceled(){
				if( emmpAddNewSentTryErrorCondMsg == '' ){
					$('.eqmnt-item-add-edit').hide();
					$('#jgb-eqmat-admin .eqmnt-buttons').show();
					$('#jgb-eqmat-admin .main-content').show();
				} else {
					$('eqmnt-item-add-edit .notice.notice-error').text(emmpAddNewSentTryErrorCondMsg);
					if( $('eqmnt-item-add-edit .notice.notice-error').hasClass('hidden') ){
						$('eqmnt-item-add-edit .notice.notice-error').removeClass('hidden')
					}
				}
			}

			$( '#jgb-eqmat-admin #add-eqmnt' ).on('click',function(event){
				setWidgetsForEmmpAddNew();
			});

			$( '.actions-wrapper .cancel' ).on('click',function(event){
				event.preventDefault();
				emmpAddNewSentTryErrorCondMsg = '';
				setWidgetsForEmmpAddedOrCanceled();
			});

			

			

			

			function setWidgetsForDosfSendingToServer(){
				if( !$('.eqmnt-item-add-edit .notice.notice-error').hasClass('hidden') ){
					$('.eqmnt-item-add-edit .notice.notice-error').addClass('hidden')
				}
			}

			$('#rem-dosf').click(function(evn){
				evn.preventDefault();

				if( !$(this).hasClass('disabled') ){
					delConfirmtnDlg.dialog('open');
				}

			});

			$( '.eqmnt-item-add-edit .actions-wrapper .save' ).on('click',function(event){
				event.preventDefault();

				$.blockUI(bluckUICOnfig); 

				setWidgetsForDosfSendingToServer();

				// crear datos para enviar.
				var emmpData = {
					'serie'		 :		$('#eqmnt-serie').val(),
					'model'		 :		$('#eqmnt-model').val(),
					'et-delivery':		$('#eqmnt-et-delivery').val(),
					'status'	 : 		$('#eqmnt-status').val(),
					'emails'	 : 		choiceEmls.getValue(true),
					'updateId'	 : 		currentEditionEmmpId 
				};

				// pendiente agregar validaciones.

				// preparando la configuración de la llamada a endpoint para crear nuevo dosf.
				var ajxSettings = {
					url: JGB_EQMAT.urlEquipments,
					method:'POST',
					accepts: 'application/json; charset=UTF-8',
					contentType: 'application/json; charset=UTF-8',
					data: JSON.stringify(emmpData),
					complete: function( jqXHR, textStatus ){
						setWidgetsForEmmpAddedOrCanceled();
						$.unblockUI();
					},
					success: function(  data,  textStatus,  jqXHR ){

						if( data['emmpAddNew_post_status'] == 'ok' ^ data['dosfUpdate_post_status'] == 'ok'){
							emmpAddNewSentTryErrorCondMsg = '';
							dttbl.ajax.reload();
						}
		
						if( data['emmpAddNew_post_status'] == 'error' && data['err_code'] == '403' ){
							emmpAddNewSentTryErrorCondMsg = 'Ya existe un proceso de mantención con el mismo número de serie.'
						}
						
					},
					error: function( jqXHR, textStatus, errorThrown ){
						emmpAddNewSentTryErrorCondMsg = 'Error al intentar enviar los datos de un nuevo proceso de mantención al server.';
						console.log('Error al intentar enviar los datos de un nuevo proceso de mantención al server.');
						console.log(jqXHR);
					}
				}

				// Activando animación de proceso.

				// ejecutando AJAX.
				$.ajax(ajxSettings);

			});
			
			$('.eqmnt-item-add-edit .fields-wrapper #eqmnt-et-delivery').datetimepicker(
				{	
					format: 'Y-m-d H:i',
					lang: 'es',
					i18n: {
						'es': { // Spanish
							months: [
								"Enero",
								"Febrero",
								"Marzo", 
								"Abril", 
								"Mayo", 
								"Junio", 
								"Julio", 
								"Agosto", 
								"Septiembre", 
								"Octubre", 
								"Noviembre", 
								"Diciembre"
							],
			
							dayOfWeekShort: [
								"Dom", 
								"Lun", 
								"Mar", 
								"Mié", 
								"Jue", 
								"Vie", 
								"Sáb"
							],
			
							dayOfWeek: [
								"Domingo", 
								"Lunes", 
								"Martes", 
								"Miércoles", 
								"Jueves", 
								"Viernes", 
								"Sábado"
							]
						}
					}
				}
			);

			const choicesEmlsCfg = {
				allowHTML: true,
				delimiter: ',',
				editItems: true,
				maxItemCount: 5,
				removeItemButton: true,
				duplicateItemsAllowed: false,
				addItemFilter: function(value) {
					if (!value) {
					  return false;
					}
		
					const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					const expression = new RegExp(regex.source, 'i');
					return expression.test(value);
				},
				addItemText: (value) => {
					return `Presiona ENTER para agregar <b>"${value}"</b>`;
				},
				customAddItemText: 'Solo se permite agregar emails'
			};

			choiceEmls = new Choices($('#eqmnt-email')[0],choicesEmlsCfg);


		});

	})( jQuery );


