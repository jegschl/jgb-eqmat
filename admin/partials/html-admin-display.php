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
 * Admin View: Mantención de quipos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

    <?= apply_filters('jgb-eqmat-admin/admin-content-title','<h2>Mantención de equipos</h2>'); ?>
    <?= do_action('jgb-eqmat-admin/before-content'); ?>
    <div id="jgb-eqmat-admin" class="main-container">
        <div class="header">
            <?= do_action('jgb-eqmat-admin/content-header'); ?>
        </div>
        
        <div class="main-content">
            <?= do_action('jgb-eqmat-admin/main-content'); ?>
        </div>

        <div class="footer">
            <?= do_action('jgb-eqmat-admin/content-footer'); ?>
        </div>
    </div>
    <?= do_action('jgb-eqmat-admin/after-content'); ?>