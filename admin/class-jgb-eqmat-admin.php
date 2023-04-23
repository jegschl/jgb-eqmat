<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://empdigital.cl
 * @since      1.0.0
 *
 * @package    Jgb_EqMat
 * @subpackage Jgb_EqMat/admin
 */


 define('JGB_EQMAT_APIREST_BASE_ROUTE','jgb-eqmat/');
 define('JGB_EQMAT_URI_ID_EQUIPMENTS','equipments');
 define('JGB_EQMAT_URI_ID_SEND_CUR_STATUS','snd-stts');

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Jgb_EqMat
 * @subpackage Jgb_EqMat/admin
 * @author     Jorge Garrido <jegschl@gmail.com>
 */
class Jgb_EqMat_Admin {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	protected $tbl_nm_emmp;

	public function __construct( $plugin_name, $version ) {
		global $wpdb;
		$this->plugin_name 				 = $plugin_name;
		$this->version 					 = $version;

		$this->tbl_nm_emmp = $wpdb->prefix . 'eqmat_processes';

		add_action('jgb-eqmat-admin/main-content',[$this,'hrd_main_content']);
		add_action('jgb-eqmat-admin/content-header',[$this,'hrd_header_buttons']);
		add_action('jgb-eqmat-admin/before-content',[$this,'hrd_add_edt_frm']);
		add_Action('jgb-eqmat-admin/content-header',[$this,'hrd_del_confirm_dlg']);
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {

		if( $hook != "toplevel_page_jgb-eqmat-admin" )
			return;

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jgb-eqmat-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-header', plugin_dir_url( __FILE__ ) . 'css/jgb-eqmat-header.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-ae-frm', plugin_dir_url( __FILE__ ) . 'css/jgb-eqmat-ae-frm.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-dttbl', plugin_dir_url( __FILE__ ) . 'css/jgb-eqmat-dttbl.css', array(), $this->version, 'all' );
		
		wp_enqueue_style( 
			'JGB_EQMAT_jquery_dtp_css', 
			plugin_dir_url( __FILE__ ) . 'js/libs/datetimepicker-master/build/jquery.datetimepicker.min.css', 
			array(),
			null,
			'all'
		);

		/* wp_enqueue_style( 
			'dosf_choices_base_css', 
			plugin_dir_url( __FILE__ ) . 'js/libs/choices-master/public/assets/styles/base.min.css', 
			array(),
			null,
			'all'
		); */

		wp_enqueue_style( 
			'JGB_EQMAT_choices_css', 
			plugin_dir_url( __FILE__ ) . 'js/libs/choices-master/public/assets/styles/choices.min.css', 
			array(),
			null,
			'all'
		);

		wp_enqueue_style(
			'JGB_EQMAT_font_awesome',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css',
			[],
			null,
			'all'
		);

		wp_enqueue_style(
			'JGB_EQMAT_jquery_ui_css',
			'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css',
			[],
			null,
			'all'
		);

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {

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

		if( $hook != "toplevel_page_jgb-eqmat-admin" )
			return;

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jgb-eqmat-admin.js', array(), $this->version, false );

		wp_localize_script( 
			$this->plugin_name, 
			'JGB_EQMAT',
			array(
				'urlEquipments'		 => rest_url( '/'. JGB_EQMAT_APIREST_BASE_ROUTE . JGB_EQMAT_URI_ID_EQUIPMENTS . '/' ),
				'baseUrlSendStatus'	 => rest_url( '/'. JGB_EQMAT_APIREST_BASE_ROUTE . JGB_EQMAT_URI_ID_SEND_CUR_STATUS . '/')
			) 
		);
		
		$script_fl = 'https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js';
		wp_enqueue_script(
			'JGB_EQMAT_jquery_datatable', 
			$script_fl,
			array('jquery'),
			null,
			false
		);

		$script_fl = 'https://code.jquery.com/ui/1.12.1/jquery-ui.js';
		wp_enqueue_script(
			'JGB_EQMAT_jquery_ui_js', 
			$script_fl,
			array('jquery'),
			null,
			false
		);

		$script_fl = plugin_dir_url( __FILE__ ) . 'js/libs/datetimepicker-master/build/jquery.datetimepicker.full.js';
		wp_enqueue_script(
			'JGB_EQMAT_jquery_datatimepicker', 
			$script_fl,
			array('jquery'),
			null,
			false
		);

		$script_fl = plugin_dir_url( __FILE__ ) . 'js/libs/choices-master/public/assets/scripts/choices.min.js';
		wp_enqueue_script(
			'JGB_EQMAT_js_choice', 
			$script_fl,
			array(),
			null,
			false
		);

		$script_fl = plugin_dir_url( __FILE__ ) . 'js/libs/blockui-2.70.0/jquery-blockUI.js';
		wp_enqueue_script(
			'JGB_EQMAT_jq_blockUI', 
			$script_fl,
			array('jquery'),
			null,
			false
		);
	}

	public function menu() {
		add_menu_page( 
			apply_filters('jgb-eqmat-admin/admin-page-title','Mantención de grúas'), 
			apply_filters('jgb-eqmat-admin/admin-menu-title','Mantención de grúas'), 
			'manage_options', 
			'jgb-eqmat-admin', 
			array($this,'hrd_admin'), 
			'dashicons-forms', 
			11
		);
	}

	public function hrd_admin(){

		$path = __DIR__ . '/partials/html-admin-display.php';

        include $path;
	}

	public function hrd_main_content(){

		$path = __DIR__ . '/partials/html-eqmnt-dttbl.php';

        include $path;
	}

	public function hrd_header_buttons(){

		$path = __DIR__ . '/partials/html-eqmnt-buttons.php';

        include $path;

	}

	public function hrd_add_edt_frm(){

		$path = __DIR__ . '/partials/html-eqmnt-add-edt-frm.php';

        include $path;
	}

	public function hrd_del_confirm_dlg(){

		$path = __DIR__ . '/partials/html-eqmnt-rem-conf-dlg.php';

		include $path;
	}

    public function set_endpoints(){
        register_rest_route(
            JGB_EQMAT_APIREST_BASE_ROUTE,
            JGB_EQMAT_URI_ID_EQUIPMENTS . '/',
            array(
                'methods'  => 'GET',
                'callback' => array(
                    $this,
                    'send_eqpmt_data'
                ),
                'permission_callback' => '__return_true'
            )
        );

        register_rest_route(
            JGB_EQMAT_APIREST_BASE_ROUTE,
            JGB_EQMAT_URI_ID_EQUIPMENTS . '/',
            array(
                'methods'  => 'POST',
                'callback' => array(
                    $this,
                    'receive_eqpmt_creation_request'
                ),
                'permission_callback' => '__return_true',
            )
        );

		register_rest_route(
            JGB_EQMAT_APIREST_BASE_ROUTE,
            JGB_EQMAT_URI_ID_EQUIPMENTS . '/(?P<eqpmt_id>\d+)',
            array(
                'methods'  => 'PUT',
                'callback' => array(
                    $this,
                    'receive_eqpmt_update_request'
                ),
                'permission_callback' => '__return_true',
            )
        );

		register_rest_route(
            JGB_EQMAT_APIREST_BASE_ROUTE,
            JGB_EQMAT_URI_ID_EQUIPMENTS,
            array(
                'methods'  => 'DELETE',
                'callback' => array(
                    $this,
                    'receive_eqpmt_remove_request'
                ),
                'permission_callback' => '__return_true',
            )
        );

		register_rest_route(
            JGB_EQMAT_APIREST_BASE_ROUTE,
            '/'.JGB_EQMAT_URI_ID_SEND_CUR_STATUS.'/(?P<eqpmt_id>\d+)',
            array(
                'methods'  => 'GET',
                'callback' => array(
                    $this,
                    'receive_send_cur_status_req'
                ),
                'permission_callback' => '__return_true',
            )
        );

    }

	public function receive_eqpmt_remove_request( WP_REST_Request $r ){
		global $wpdb;
		$ids_to_remove = $r->get_json_params()['istr'];
		$res = [];
		$res['details'] = [];
		$ta = [];
		if( count( $ids_to_remove ) ){
			foreach( $ids_to_remove as $id ){
				$upd_res = $wpdb->update(
					$this->tbl_nm_emmp,
					array(
						'deleted' 		 => 1			
					),
					[ 'id' => $id ]
				);
	
				
				if( $upd_res > 0 ){
					$ta['del-emmp-res'] = true;
				} else {
					$ta['del-emmp-res'] = false;
					$ta['del-emmp-res-err'] = $wpdb->last_error;
				}

				
				$res['details'][$id] = $ta;
			}
		}

		return new WP_REST_Response( $res );
		
	}

	public function get_eqpmnt_mp_where($search_value = null){
		if(isset($search_value) && !empty($search_value)){
            $where  = ' WHERE deleted != 0 AND ( serie LIKE "%'. $search_value . '%"';
            $where .= ' OR model LIKE "%' . $search_value . '%"';
            $where .= ' OR emails LIKE "%' . $search_value . '%" )';
        } else {
			$where  = ' WHERE deleted = 0';
		}
		return $where;
	}

	public function get_maintenance_processes_count( $prmtrs = null){
		global $wpdb;

		$where = $this->get_eqpmnt_mp_where( $prmtrs['search']['value'] );

		$isql = "SELECT SQL_CALC_FOUND_ROWS
					*
				FROM wp_eqmat_processes wep 
				
				$where";

		$qry = 'SELECT FOUND_ROWS() AS total_records';

		$wpdb->get_results($isql);
		$row = $wpdb->get_row($qry, OBJECT);

		if( isset($row->total_records) ){
			return $row->total_records;
		}

		return 0;

	}

	public function get_eqpmnt_mp_orderby( $colsOrder = null ){
		$orderBy = 'ORDER BY id';
		if( !isset( $colsOrder ) ){
			$orderBy = 'ORDER BY ';
			$i = 0;
			foreach( $colsOrder as $co ){
				$orderBy .= $i > 0 ? ',':'';
				$orderBy .= $co['column'] . ' ' . $co['sort'];
			}
		}

		return $orderBy;
	}

	public function get_maintenance_processes( $prmtrs ){
		global $wpdb;
		$res = [];
		$rows = [];
		$limit = '';
		if(isset($prmtrs['length']) && $prmtrs['length']>0)
            $limit = ' LIMIT ' . $prmtrs['start'] . ',' . $prmtrs['length'];
		
		$where = $this->get_eqpmnt_mp_where($prmtrs['search']['value']);

		$order = $this->get_eqpmnt_mp_orderby($prmtrs['order']);

		$isql = "SELECT *
				 FROM wp_eqmat_processes wep 
				 $where
				 $order
				 $limit";

		$rows = $wpdb->get_results( $isql );
		if ( $wpdb->last_error ) {
			$res['error'] = true;
			$res['error_msg'] = $wpdb->last_error;
		} else {
			$res['error'] = false;
			$res['data'] = $rows;
		}

		return $res;
	}

	public function send_eqpmt_data(){
		
		$eqmp = $this->get_maintenance_processes( $_GET );
        
		$rc = array();

        $row_data = [];

		if($eqmp['error']){
			$res = array(
                'draw' 				=> $_GET['draw'],
                "recordsTotal" 		=> 0,
                "recordsFiltered" 	=> 0,
                'data' 				=> array(),
            );
            
		} else {
			foreach($eqmp['data'] as $c){
				$row_data['emmp-raw-status'] = $c->status;
				$rc[] = array(
					'DT_RowId'	  => $c->id,
					'DT_RowData'  => $row_data,
					'id'		  => $c->id,
					'serie'       => $c->serie,
					'et_delivery' => $c->et_delivery,
					'status' 	  => $c->status,
					'model'		  => $c->model,
					'emails'	  => $c->emails,
					'active'	  => $c->active,
					'selection'	  => '',
					'actions'	  => ''
				);
			}
			$res = array(
                'draw' => $_GET['draw'],
                "recordsTotal" =>  $this->get_maintenance_processes_count(),
                "recordsFiltered" => $this->get_maintenance_processes_count($_GET['search']['value']),
                'data' => $rc
            );
		}

		$response = new WP_REST_Response( $res );
        $response->set_status( 200 );

        return $response;
	}

	public function get_current_emmp_status( int $emmp_id ){
		global $wpdb;
		$res = [];
		$res['error'] = true;

		$tbl_nm_emmp = $wpdb->prefix . 'eqmat_processes';

		$isql = "SELECT `status` FROM $tbl_nm_emmp WHERE id=$emmp_id";

		$r = $wpdb->get_row($isql);

		if( !is_null($r) ){
			$res['error'] = false;
			$res['equipment_maintenance_status'] = $r->status;
		} else {
			$res['error_msg'] = $wpdb->last_error;
		}

		return $res;
	}

	public function receive_eqpmt_creation_request($r){
		$data = $r->get_json_params();
		// validaciones del lado del server.
		global $wpdb;
		

		if( isset( $data['updateId'] ) && !is_null( $data['updateId'] ) ){

			$beforeUpdStts = $this->get_current_emmp_status($data['updateId']);
			$upd_res = $wpdb->update(
				$this->tbl_nm_emmp,
				array(
					'serie' 		 => $data['serie'],
					'model' 		 => $data['model'],
					'et_delivery' 	 => $data['et-delivery'],
					'emails'		 => implode(',',$data['emails']),
					'status'		 => $data['status'],
		
				),
				[ 'id' => $data['updateId'] ]
			);

			$mail_sent_res = '';
			if( $upd_res > 0 && ($beforeUpdStts['equipment_maintenance_status'] != $data['status'])){
				$mail_sent_res = $this->send_current_status_email($data['updateId']);
			}
			

			return [
				'emmp_operation'		   		=> 'UPDATE',
				'emmp_update_status' 	   		=> $upd_res > 0 ? 'ok' : 'error',
				'emmp_change_status_email_sent'	=> $mail_sent_res
			];

		} else {

			
			// Chequeo de existencia por número de serie:
			if( $this->checkStoredMatchBySerialNumber( $data['serie'] ) ){
				return [
					'emmp_operation'		 => 'INSERT',
					'emmp_post_status' 		 => 'error',
					'err_code'				 => '403',
					'err_msg'				 => 'Try duplicated serial'
				];
			}
			
		
			$wpdb->insert(
				$this->tbl_nm_emmp,
				array(
					'serie' 		 => $data['serie'],
					'model' 		 => $data['model'],
					'et_delivery' 	 => $data['et-delivery'],
					'emails'		 => implode(',',$data['emails']),
					'status'		 => $data['status']
				)
			);
			$emmp_id = $wpdb->insert_id;
			
			$mail_sent_res = $this->send_current_status_email($emmp_id);

			return [
				'emmp_operation'		 => 'INSERT',
				'emmp_post_status' => 'ok',
				'emmp_email_sent'	 => $mail_sent_res
			];

		}

		
	}

	public function checkStoredMatchBySerialNumber( $serial ){
		global $wpdb;
		$match_count = $wpdb->get_var("
			SELECT COUNT(*)
			FROM `".$this->tbl_nm_emmp."` 
			WHERE `serie` = \"$serial\"" );
		if(!is_null($match_count)){
			$match_count = intval( $match_count );
		}
		return $match_count > 0 ? true : false;
	}

	public function send_current_status_email($emmp_id){
		global $wpdb;
		$data = [];
		$isql  = 'SELECT * FROM ' . $this->tbl_nm_emmp .' ';
		$isql .= "WHERE id=$emmp_id";

		$emmp = $wpdb->get_row($isql);
		if( !is_null($emmp) ){
			if(    !isset( $emmp->serie ) 
				&& !isset( $emmp->et_delivery )
				&& !isset( $emmp->status )
				&& !isset( $emmp->model )
				&& !isset( $emmp->emails )
			){
				return false;
			}
		}

		$header_template_path = apply_filters(
									'eqmat_eml_tpl_cur_status_header',
									JGB_EQMAT_PLUGIN_PATH . '/templates/emails/email_header.tpl'
								);
		
		$content_template_path = apply_filters(
									'eqmat_eml_tpl_cur_status_content_path',
									JGB_EQMAT_PLUGIN_PATH . '/templates/emails/email_emmp_status_content.tpl'
								);

		$footer_template_path = apply_filters(
									'eqmat_eml_tpl_cur_status_footer',
									JGB_EQMAT_PLUGIN_PATH . '/templates/emails/email_footer.tpl'
								);

		$mail_sent_res = false;
		if(file_exists($content_template_path)){
			$email = $emmp->emails;
			$content = '';
			if(file_exists($header_template_path)){
				$content  .= file_get_contents($header_template_path);
			}
			$content .= file_get_contents($content_template_path);
			if(file_exists($footer_template_path)){
				$content .= file_get_contents($footer_template_path);
			}
			$content = str_replace(
							'{serie}',
							$emmp->serie,
							$content
						);

			switch ($emmp->status) {
				case 'LPE':
					$vtr = 'Listo para entrega';
					break;
				
				default:
					$vtr = 'En proceso';
					break;
			}
			
			$content = str_replace(
							'{status}',
							$vtr,
							$content
						);

			$vtr = (new DateTime($emmp->et_delivery))->format('d-m-Y');
			$content = str_replace(
				'{et_delivery}',
				$vtr,
				$content
			);

			$content = str_replace(
				'{model}',
				$emmp->model,
				$content
			);

			$subject = apply_filters(
							'eqmat_eml_cur_status_subject',
							'Grua PM :: Estado de mantención de equipo o vehículo'
						);

			$header = array('Content-Type: text/html; charset=UTF-8');
			$header = apply_filters(
						'eqmat_eml_cur_status_header',
						$header
					);
			
			/* $attachments = array();
			if(isset($args['file']) && !empty($args['file'])){
				$attachments[] = $args['file'];
			} */
			//$mail_sent_res = wp_mail($email,$subject,$content,$header,$attachments);
			$mail_sent_res = wp_mail($email,$subject,$content,$header);
		}

		return $mail_sent_res;

	}

	public function receive_send_cur_status_req(WP_REST_Request $r){
		$res = [];
		
		$res['error'] = true;
		$res['sent_cur_status'] = false;
		$res['eqpmt_id'] = $r->get_url_params()['eqpmt_id'];
		if( !is_null ($res['eqpmt_id']) ){
			$res['sent_cur_status'] = $this->send_current_status_email( $res['eqpmt_id'] );
			if( $res['sent_cur_status'] ){
				$res['error'] = false;
			} else {
				$res['error'] = true;
				$res['error_msg'] = 'Ocurrió un error mientras se intentaba hacer el envío de email';
			}
		}
		return new WP_REST_Response( $res );
	}

}
