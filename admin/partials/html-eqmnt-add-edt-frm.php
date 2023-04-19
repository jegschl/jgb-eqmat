<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://empdigital.cl
 * @since      1.0.0
 *
 * @package    Jgb_EqMat
 * @subpackage Jgb_EqMat/admin/partials
 */

/**
 * Admin View: Equipment add/edit form
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

		<div class="eqmnt-item-add-edit" style="display: none;">
			<div class="title"></div>
			<div class="fields-wrapper">
				<div class="fld-serie">
					<label>Serie</label>
					<input name="eqmnt-serie" id="eqmnt-serie" type="text" />
				</div>

				<div class="fld-model">
					<label>Modelo</label>
					<input name="eqmnt-model" id="eqmnt-model" type="text" />
				</div>
				
				<div class="fld-et-delivery">
					<label>Emisión</label>
					<input name="eqmnt-et-delivery" id="eqmnt-et-delivery" type="datetime" />
				</div>
				

				<div class="fld-ruts"> 
					<label>RUTs asociados</label>
					<input 
						type="text" 
						id="eqmnt-ruts"
						name="eqmnt-ruts"
						placeholder="Separar RUTs con comas y sin puntos ni guiones"
					>
				</div>
				<div class="fld-email"> 
					<label>Emails</label>
					<input 
						type="text" 
						id="eqmnt-email"
						name="eqmnt-email"
						placeholder="Ingrese emails para enviar notificaciones de cambio de estado"
					>
				</div>

			</div>
			<div class="actions-wrapper">
				<div class="save"><button>Guardar</button></div>
				<div class="cancel"><button>Cancelar</button></div>
			</div>
			<div class="notice notice-error hidden"></div>
		</div>