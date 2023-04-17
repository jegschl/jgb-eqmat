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
 * Admin View: DataTable - Main Content
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

			<table id="eqmnt-dttbl" class="display">
				
				<thead>
					<tr>
						<th>Selección</th>						
						<th>Serie</th>
						<th>Modelo</th>
						<th>Entrega estimada</th>
						<th>Area de competencia</th>
						<th>Estado</th>
						<th>Acciones</th>
					</tr>
				</thead>

				<!--body-->

				<tfoot>
					<tr>
						<th>Selección</th>						
						<th>Serie</th>
						<th>Modelo</th>
						<th>Entrega estimada</th>
						<th>Area de competencia</th>
						<th>Estado</th>
						<th>Acciones</th>
					</tr>
				</tfoot>
				
			</table>