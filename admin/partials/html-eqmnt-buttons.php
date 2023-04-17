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
 * Admin View: Buttos before DataTable
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

		<div class="eqmnt-buttos">
			
			<div id="add-eqmnt" class="action-wrapper"><span class="dashicons dashicons-plus-alt"></span>Agregar nueva Grúa en mantención</div>
			<div id="rem-eqmnt" class="action-wrapper disabled"><span class="dashicons dashicons-dismiss"></span>Remover seleccionadas</div>
					
		</div>