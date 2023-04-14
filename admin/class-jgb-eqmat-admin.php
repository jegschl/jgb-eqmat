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

 define('JGB_EQMAT_URI_ID_SEND_CUR_STATUS','send-download-code');

 define('JGB_EQMAT_NONCE_ACTION_PLUS_OPTS_UPDATE','update-plus-options');
 
 define('JGB_EQMAT_PLUS_OPTS_UPDATE_ERR_INVALID_NONCE'	,1);
 define('JGB_EQMAT_PLUS_OPTS_UPDATE_ERR_DB'				,2);
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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name 				 = $plugin_name;
		$this->version 					 = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/jgb-eqmat-admin.css', array(), $this->version, 'all' );
		
		/* wp_enqueue_style( 
			'dosf_jquery_dtp_css', 
			plugin_dir_url( __FILE__ ) . 'js/libs/datetimepicker-master/build/jquery.datetimepicker.min.css', 
			array(),
			null,
			'all'
		); */

		/* wp_enqueue_style( 
			'dosf_choices_base_css', 
			plugin_dir_url( __FILE__ ) . 'js/libs/choices-master/public/assets/styles/base.min.css', 
			array(),
			null,
			'all'
		); */

		/* wp_enqueue_style( 
			'dosf_choices_css', 
			plugin_dir_url( __FILE__ ) . 'js/libs/choices-master/public/assets/styles/choices.min.css', 
			array(),
			null,
			'all'
		); */

		/* wp_enqueue_style(
			'dosf_font_awesome',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css',
			[],
			null,
			'all'
		); */

		/* wp_enqueue_style(
			'dosf_jquery_ui_css',
			'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css',
			[],
			null,
			'all'
		); */

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
				'urlEquipments'		 => rest_url( '/'. JGB_EQMAT_APIREST_BASE_ROUTE . JGB_EQMAT_URI_ID_EQUIPMENTS . '/' )
			) 
		);
		
		/* $script_fl = 'https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js';
		wp_enqueue_script(
			'dosf_jquery_datatable', 
			$script_fl,
			array('jquery'),
			null,
			false
		); */

		/* $script_fl = 'https://code.jquery.com/ui/1.12.1/jquery-ui.js';
		wp_enqueue_script(
			'dosf_jquery_ui_js', 
			$script_fl,
			array('jquery'),
			null,
			false
		); */

		/* $script_fl = plugin_dir_url( __FILE__ ) . 'js/libs/datetimepicker-master/build/jquery.datetimepicker.full.js';
		wp_enqueue_script(
			'dosf_jquery_datatimepicker', 
			$script_fl,
			array('jquery'),
			null,
			false
		); */

		/* $script_fl = plugin_dir_url( __FILE__ ) . 'js/libs/choices-master/public/assets/scripts/choices.min.js';
		wp_enqueue_script(
			'dosf_js_choice', 
			$script_fl,
			array(),
			null,
			false
		); */

		/* $script_fl = plugin_dir_url( __FILE__ ) . 'js/libs/blockui-2.70.0/jquery-blockUI.js';
		wp_enqueue_script(
			'dosf_jq_blockUI', 
			$script_fl,
			array('jquery'),
			null,
			false
		); */
	}

	public function menu() {
		add_menu_page( 
			apply_filters('jgb-eqmat-admin/admin-page-title','Mantención de equipos'), 
			apply_filters('jgb-eqmat-admin/admin-menu-title','Mantención de equipos'), 
			'manage_options', 
			'jgb-eqmat-admin', 
			array($this,'admin_page'), 
			'dashicons-forms', 
			11
		);
	}

	public function admin_page(){
		?>


			<h2><?= apply_filters('jgb-eqmat-admin/admin-content-title','Mantención de equipos'); ?></h2>
			<div id="jgb-eqmat-admin-main-container">

			</div>

		<?php
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
				// Eliminando ruts.
				$ta['del-rut-res'] = $wpdb->delete('jgb-eqmat_so_ruts_links',['so_id' => $id]);
				if( $ta['del-rut-res'] === false ){
					$ta['del-rut-res-err'] = $wpdb->last_error;
				}
				$ta['del-dosf-res'] = $wpdb->delete('jgb-eqmat_shared_objs',['id' => $id]);
				if( $ta['del-dosf-res'] === false ){
					$ta['del-dosf-res-err'] = $wpdb->last_error;
				}
				$res['details'][$id] = $ta;
			}
		}

		return new WP_REST_Response( $res );
		
	}

	

	public function send_eqpmt_data($r){
		global $wpdb;
		
		$limit = '';
		if(isset($_GET['length']) && $_GET['length']>0)
            $limit = ' LIMIT ' . $_GET['start'] . ',' . $_GET['length'];
        
		$where = '';
        if(isset($_GET['search']['value']) && !empty($_GET['search']['value'])){
            $sv = $_GET['search']['value'];
            $where  = ' WHERE file_name LIKE "%'. $sv . '%"';
            $where .= ' OR wdsrl.rut LIKE "%' . $sv . '%"';
            $where .= ' OR title LIKE "%' . $sv . '%"';
        }

		$isql = "SELECT SQL_CALC_FOUND_ROWS
					wdso.id,
					title,
					file_name,
					wp_file_obj_id,
					GROUP_CONCAT(wdsrl.rut) AS linked_ruts,
					email,
					email2,
					emision
				FROM jgb-eqmat_shared_objs wdso 
				JOIN jgb-eqmat_so_ruts_links wdsrl 
					ON wdso.id = wdsrl.so_id 
				$where 
				GROUP BY wdso.id
				$limit";
		$qry = 'SELECT FOUND_ROWS() AS total_rcds';
		
		$sos = $wpdb->get_results($isql, OBJECT);
		$frs = $wpdb->get_row($qry, OBJECT);
        
		$rc = array();

        $row_data = [];

        foreach($sos as $c){
            $row_data['attachment-id'] = $c->wp_file_obj_id;
            $rc[] = array(
				'DT_RowId'	  => $c->id,
				'DT_RowData'  => $row_data,
				'id'		  => $c->id,
                'title'       => $c->title,
                'file_name'   => $c->file_name,
                'linked_ruts' => $c->linked_ruts,
				'email'		  => $c->email,
				'email2'	  => $c->email2,
				'emision'	  => $c->emision,
				'status'	  => self::get_dosf_status($c->emision),
				'selection'	  => '',
				'actions'	  => ''
            );
        }

        if($sos && empty($wpdb->last_error) ){
            $res = array(
                'draw' => $_GET['draw'],
                "recordsTotal" =>  intval($frs->total_rcds),
                "recordsFiltered" => intval($frs->total_rcds),
                'data' => $rc
            );
            $response = new WP_REST_Response( $res );
            $response->set_status( 200 );
            
        } else {
			$res = array(
                'draw' => $_GET['draw'],
                "recordsTotal" =>  intval($frs->total_rcds),
                "recordsFiltered" => intval($frs->total_rcds),
                'data' => array(),
				//'error' => new WP_Error( 'cant-read-dosf-sos', __( 'Can\'t get shared objects', 'jgb-eqmat' ), array( 'status' => 500 ) )
            );
            $response = new WP_REST_Response( $res );
            $response->set_status( 200 );
        }
        return $response;
	}

	

	public function receive_eqpmt_creation_request($r){
		$data = $r->get_json_params();
		// validaciones del lado del server.
		global $wpdb;
		$tbl_nm_shared_objs = $wpdb->prefix . 'dosf_shared_objs';
		$tbl_nm_so_ruts_links = $wpdb->prefix . 'dosf_so_ruts_links'; 

		$mail_sent_res = null;

		if( isset( $data['updateId'] ) && !is_null( $data['updateId'] ) ){

			$dowld_code = $this->generate_download_code();
			$upd_res = $wpdb->update(
				$tbl_nm_shared_objs,
				array(
					'title' 		 => $data['title'],
					'file_name' 	 => $data['file_name'],
					'wp_file_obj_id' => $data['wp_obj_file_id'],
					'email'			 => implode(',',$data['email']),
					'email2'		 => implode(',',$data['email2']),
					'download_code'  => $dowld_code,
					'emision'		 => $data['emision']
				),
				[ 'id' => $data['updateId'] ]
			);

			$wpdb->delete(
				$tbl_nm_so_ruts_links,
				['so_id' => intval( $data['updateId'] ) ]
			);

			foreach($data["linked_ruts"] as $rut){
				$wpdb->insert(
					$tbl_nm_so_ruts_links,
					array(
						'so_id' => intval( $data['updateId'] ),
						'rut' 	=> $rut
					)
				);
			}

			return [
				'dosf_operation'		 => 'UPDATE',
				'dosfUpdate_post_status' => 'ok',
				'dosfAddNew_email_sent'	 => $mail_sent_res
			];

		} else {

			$options = get_option(JGB_EQMAT_OPT_NM_PLUS_OPTIONS);
			if( isset( $options['use-serial-number'] ) && $options['use-serial-number'] ){
				// Chequeo de existencia por número de serie:
				if( $this->checkStoredMatchBySerialNumber( $data['title'] ) ){
					return [
						'dosf_operation'		 => 'INSERT',
						'dosfAddNew_post_status' => 'error',
						'err_code'				 => '403',
						'err_msg'				 => 'Try duplicated serial'
					];
				}
			}
		
			$dowld_code = $this->generate_download_code();
			$wpdb->insert(
				$tbl_nm_shared_objs,
				array(
					'title' 		 => $data['title'],
					'file_name' 	 => $data['file_name'],
					'wp_file_obj_id' => $data['wp_obj_file_id'],
					'email'			 => implode(',',$data['email']),
					'email2'		 => implode(',',$data['email2']),
					'download_code'  => $dowld_code,
					'emision'		 => $data['emision']
				)
			);
			$so_id = $wpdb->insert_id;
			if( $so_id !== false ){
				foreach($data["linked_ruts"] as $rut){
					$wpdb->insert(
						$tbl_nm_so_ruts_links,
						array(
							'so_id' => intval($so_id),
							'rut' 	=> $rut
						)
					);
				}
			} 
			$wp_upload_dir_info = wp_upload_dir(); 
			$attachment_id = intval($data['wp_obj_file_id']);
			$file_path = get_attached_file($attachment_id);
			$dce_args = array(
							'email' => $data['email'],
							'download_code' => $dowld_code,
							'file' => $file_path
						);


			$mail_sent_res = $this->send_download_code_email($dce_args);

			return [
				'dosf_operation'		 => 'INSERT',
				'dosfAddNew_post_status' => 'ok',
				'dosfAddNew_email_sent'	 => $mail_sent_res
			];

		}

		
	}

	public function checkStoredMatchBySerialNumber( $serial ){
		global $wpdb;
		$tbl_nm_shared_objs = $wpdb->prefix . 'dosf_shared_objs';
		$match_count = $wpdb->get_var("
			SELECT COUNT(*)
			FROM `$tbl_nm_shared_objs` 
			WHERE `id` = \"$serial\"" );
		return $match_count > 0 ? true : false;
	}

	public function receive_send_cur_status_req($args){
		if(!isset($args['email']) || !isset($args['download_code']) )
			return false;

		if( empty($args['email']) || empty($args['download_code']) )
			return false;

		$header_template_path = apply_filters(
									'dosf_eml_tpl_new_obj_header',
									JGB_EQMAT_PLUGIN_PATH . '/templates/emails/email_header.tpl'
								);
		
		$content_template_path = apply_filters(
									'dosf_eml_tpl_new_obj_content_path',
									JGB_EQMAT_PLUGIN_PATH . '/templates/emails/email_new_dosf_content.tpl'
								);

		$footer_template_path = apply_filters(
									'dosf_eml_tpl_new_obj_footer',
									JGB_EQMAT_PLUGIN_PATH . '/templates/emails/email_footer.tpl'
								);

		$mail_sent_res = false;
		if(file_exists($content_template_path)){
			$email = $args['email'];
			$content = '';
			if(file_exists($header_template_path)){
				$content  .= file_get_contents($header_template_path);
			}
			$content .= file_get_contents($content_template_path);
			if(file_exists($footer_template_path)){
				$content .= file_get_contents($footer_template_path);
			}
			$content = str_replace(
							'{download_code}',
							$args['download_code'],
							$content
						);
			$subject = apply_filters(
							'dosf_eml_new_obj_eml_subject',
							'Grua PM :: Código de descarga de certificado de mantención'
						);

			$header = array('Content-Type: text/html; charset=UTF-8');
			$header = apply_filters(
						'dosf_eml_new_obj_eml_header',
						$header
					);
			
			$attachments = array();
			if(isset($args['file']) && !empty($args['file'])){
				$attachments[] = $args['file'];
			}
			//$mail_sent_res = wp_mail($email,$subject,$content,$header,$attachments);
			$mail_sent_res = wp_mail($email,$subject,$content,$header);
		}

		return $mail_sent_res;
	}

}
