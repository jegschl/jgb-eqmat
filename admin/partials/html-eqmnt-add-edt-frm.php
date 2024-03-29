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

		<div class="eqmnt-item-add-edit hidden">
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
					<label>Fecha de entrega estimada</label>
					<input name="eqmnt-et-delivery" id="eqmnt-et-delivery" type="datetime" />
				</div>
				

				<div class="fld-status"> 
					<label>Estado de la manteción</label>
					<select
						id="eqmnt-status"
						name="eqmnt-status"
					>
						<?php foreach( EqmatHelper::get_job_order_statuses_list() as $k => $jos ): ?>
						<option value="<?= $k ?>"><?= $jos ?></option>
						<?php endforeach; ?>
					</select>
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

				<div class="fld-active">
					<label for="eqmnt-active">Visible en las búsquedas</label>
					<input
						type="checkbox"
						id="eqmnt-active"
						name="eqmnt-active"
					>
				</div>

			</div>
			<div class="actions-wrapper">
				<div class="save"><button>Guardar</button></div>
				<div class="cancel"><button>Cancelar</button></div>
			</div>
			<div class="notice notice-error hidden"></div>
		</div>