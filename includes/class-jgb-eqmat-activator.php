<?php
/**
 * Fired during plugin activation
 *
 * @link       https://empdigital.cl
 * @since      1.0.0
 *
 * @package    Jgb_EqMat
 * @subpackage Jgb_EqMat/includes
 */

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Jgb_EqMat
 * @subpackage Jgb_EqMat/includes
 * @author     Jorge Garrido <jegschl@gmail.com>
 */
class Jgb_EqMat_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		/* $tables_initializeds = get_option('jgb-eqmat_tables_initialized',false);
		if(!$tables_initializeds){
			Jgb_EqMat_Activator::initialize_tables();
			$tables_initializeds = true;
			update_option('jgb-eqmat_tables_initialized',$tables_initializeds,true);
		} */
	}

	public static function initialize_tables(){
		global $wpdb;

		$isql_initialize_tables = "CREATE TABLE IF NOT EXISTS `wp_eqmat_processes` (
			`id` bigint unsigned NOT NULL AUTO_INCREMENT,
			`serie` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
			`et_delivery` date NOT NULL,
			`status` enum('EPM','LPE','REC','EIL','PMT','EVL','EOC') NOT NULL DEFAULT 'REC' COMMENT 'EPM: en proceso de reparación/mantención. LPE: Lista para entrega. REC: Recepcionado. EIL: En espera de ingreso a línea. PMT: En proceso de montaje. EVL: En proceso de evaluación. EOC: En espera orden de compra.',
			`emails` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
			`model` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
			`deleted` tinyint(1) NOT NULL DEFAULT '0',
			`active` tinyint(1) NOT NULL DEFAULT '1',
			UNIQUE KEY `wp_eqmat_processes_id_IDX` (`id`) USING BTREE
		  );";
		
		$wpdb->query( $isql_initialize_tables );

	}

}
