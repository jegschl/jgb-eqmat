<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://empdigital.cl
 * @since      1.0.0
 *
 * @package    Jgb_EqMat
 * @subpackage Jgb_EqMat/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Jgb_EqMat
 * @subpackage Jgb_EqMat/public
 * @author     Jorge Garrido <jegschl@gmail.com>
 */

class Jgb_EqMat_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $plus_options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jgb_EqMat_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jgb_EqMat_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jgb-eqmat-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Jgb_EqMat_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Jgb_EqMat_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jgb-eqmat-public.js', array( 'jquery' ), $this->version, false );
		
	}

	public function emmp_browser(){
		
		$no_results_label = 'No hay resultados para el número de serie ingresado.';
		$urlGetParamNm = 'emmp-search-serial';
		$browse_input_label = 'Ingrese número de serie';
		
		$valueToSearch = filter_input(INPUT_GET, $urlGetParamNm );
		if( $valueToSearch !== false && !is_null($valueToSearch)){
			global $wpdb;
			$tbl_nm_eqmt_mp = $wpdb->prefix . 'eqmat_processes';

			$wropr = '=';

				
			$select = "SELECT * 
					FROM $tbl_nm_eqmt_mp 
					WHERE serie $wropr \"{valueToSearch}\"
						  AND deleted = 0 
						  AND active = 1 ";
			

			$sql = str_replace("{valueToSearch}",$valueToSearch,$select);
			$res = $wpdb->get_row($sql);
			?>
			
			<div id="emmp-browser-wrapper">
				<form method="get">
					<div class="input-text">
						<label><?= $browse_input_label?></label>
						<input type="text" name="<?= $urlGetParamNm  ?>" value="<?=$valueToSearch?>">
					</div>
					<input type="submit" value="Volver a buscar">
				</form>
			</div>
			<?php
			if(!is_null($res) && !empty($res)){
				
				$status = EqmatHelper::job_order_status( $res->status );
				
				$fdee = (new DateTime($res->et_delivery))->format('d-m-Y');
				?>
				<div class="emmp-search-res-wrapper">
				
					<div class="emmp-search-res-row">
						<div class="msg-indicator">El estado de mantención para la grúa con número de serie <?= $valueToSearch ?> es el siguiente: <span class="status <?= $res->status ?>"><?= $status ?>.</span></div>
						<div class="details">
							<div class="detail-item">
								<label>Modelo</label>
								<span class="value"><?= $res->model  ?></span>
							</div>

							<div class="detail-item">
								<label>Fecha de entrega estimada</label>
								<span class="value"><?= $fdee  ?></span>
							</div>
						</div>
					</div>
					
				</div>
				<?php
			} else {
				?>
				<div class="emmp-search-no-res-wrapper">
					<?= $no_results_label ?>
				</div>
				<?php
			}
			?>
			<div id="emmp-browser-wrapper">
				<form method="get">
					<div class="input-text">
						<label><?= $browse_input_label?></label>
						<input type="text" name="<?= $urlGetParamNm  ?>" value="<?=$valueToSearch?>">
					</div>
					<input type="submit" value="Volver a buscar">
				</form>
			</div>
			<?php
		} else {
			?>
			<div id="emmp-browser-wrapper">
				<form method="get">
					<div class="input-text">
						<label><?= $browse_input_label?></label>
						<input type="text" name="<?= $urlGetParamNm  ?>">
					</div>
					<input type="submit">
				</form>
			</div>
			<?php
		}
	}

}
