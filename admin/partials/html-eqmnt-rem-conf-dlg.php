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
 * Admin View: Equipment remove confirmation dialog
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
        <div id="confirm-del-dlg" title="Confirmación de eliminiación de mantención(es)">
            Se eliminarán las mantenciones seleccionadas de la sección pública. Por favor confirme.
        </div>
