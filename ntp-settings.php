<?php
namespace BZ_NTP;

define('BZNTP_BASE_DIR', 	dirname(__FILE__) . '/');
define('BZNTP_PRODUCT_ID',   'RNTP');
define('BZNTP_VERSION',   	'1.0');
define('BZNTP_DIR_PATH', plugin_dir_path( __DIR__ ));
define('BZ_NTP_NS','BZ_NTP');
define('BZNTP_PLUGIN_FILE', 'rebrand-ninjatables/rebrand-ninjatables.php');   //Main base file
define('BZNTP_NINJAPRO_PLUGIN_FILE', 'ninja-tables-pro/ninja-tables-pro.php');   //Main Ninja tables Pro base file

class BZRebrandNinjaTableSettings {
		
		public $pageslug 	   = 'ninja_tables_rebrand';
	
		static public $rebranding = array();
		static public $redefaultData = array();
	
	
	
		public function init() { 
		
			$blog_id = get_current_blog_id();
			
			self::$redefaultData = array(
				'plugin_name'       	=> '',
				'plugin_desc'       	=> '',
				'plugin_author'     	=> '',
				'plugin_uri'        	=> '',
				
			);
        
			
			if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
			} 

	if ( is_plugin_active( 'blitz-rebrand-ninjatables-pro/blitz-rebrand-ninjatables-pro.php' ) ) {
			
			deactivate_plugins( plugin_basename(__FILE__) );
			$error_message = '<p style="font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Oxygen-Sans,Ubuntu,Cantarell,\'Helvetica Neue\',sans-serif;font-size: 13px;line-height: 1.5;color:#444;">' . esc_html__( 'Plugin could not be activated, either deactivate the Lite version or Pro version', 'simplewlv' ). '</p>';
			die($error_message); 
		 
			return;
		}
			$this->bzntp_activation_hooks();	
		}
		
	
		
		/**
		 * Init Hooks
		*/
		public function bzntp_activation_hooks() {
		
			global $blog_id;
	
			add_filter( 'gettext', 					array($this, 'bzntp_update_label'), 20, 3 );
			add_filter( 'all_plugins', 				array($this, 'bzntp_plugin_branding'), 10, 1 );
			add_action( 'admin_menu',				array($this, 'bzntp_menu'), 100 );
			add_action( 'admin_enqueue_scripts', 	array($this, 'bzntp_adminloadStyles'));
			add_action( 'admin_init',				array($this, 'bzntp_save_settings'));			
	        add_action( 'admin_head', 				array($this, 'bzntp_branding_scripts_styles') );
	        if(is_multisite()){
				if( $blog_id == 1 ) {
					switch_to_blog($blog_id);
						add_filter('screen_settings',			array($this, 'bzntp_hide_rebrand_from_menu'), 20, 2);	
					restore_current_blog();
				}
			} else {
				add_filter('screen_settings',			array($this, 'bzntp_hide_rebrand_from_menu'), 20, 2);
			}
			
			if(is_plugin_active(BZNTP_NINJAPRO_PLUGIN_FILE)){
				add_filter( 'admin_title', array($this, 'bzntp_ninjapage_title'),10,2);
			}
		}
		
	
	
	
			
		/**
		 * Add screen option to hide/show rebrand options
		*/
		public function bzntp_hide_rebrand_from_menu($ninjacurrent, $screen) {

			$rebranding = $this->bzntp_get_rebranding();

			$ninjacurrent .= '<fieldset class="admin_ui_menu"> <legend> '.__('Rebrand. -','bzntp').$rebranding['plugin_name'].' </legend><p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>';

			if($this->bzntp_getOption( 'rebrand_ninjatables_screen_option','' )){
				
				$cartflows_screen_option = $this->bzntp_getOption( 'rebrand_ninjatables_screen_option',''); 
				
				if($cartflows_screen_option=='show'){
					//$current .='It is showing now. ';
					$ninjacurrent .= __('Hide the "','bzntp').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzntp') .$hide;
					$ninjacurrent .= '<style>#adminmenu .toplevel_page_ninja_tables a[href="admin.php?page=ninja_rebrand"]{display:block;}</style>';
				} else {
					//$current .='It is disabling now. ';
					$ninjacurrent .= __('Show the "','bzntp').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzntp') .$show;
					$ninjacurrent .= '<style>#adminmenu .toplevel_page_ninja_tables a[href="admin.php?page=ninja_rebrand"]{display:none;}</style>';
				}		
				
			} else {
					//$current .='It is showing now. ';
					$ninjacurrent .= __('Hide the "','bzntp').$rebranding['plugin_name'].__(' - Rebrand" menu item?','bzntp') .$hide;
					$ninjacurrent .= '<style>#adminmenu .toplevel_page_ninja_tables a[href="admin.php?page=ninja_rebrand"]{display:block;}</style>';
			}	

			$ninjacurrent .=' <br/><br/> </fieldset>' ;
			
			return $ninjacurrent;
		}
		
		
		
				
		/**
		* Loads ninja main page title
		*/
		public function bzntp_ninjapage_title($admin_title, $title) {
			
			$rebranding = $this->bzntp_get_rebranding();
			$new_title = str_replace( array( 'Ninja Tables','NinjaTables Pro' ), $rebranding['plugin_name'], $title );
			return $new_title;

		}
		
		
		
		
		/**
		* Loads admin styles & scripts
		*/
		public function bzntp_adminloadStyles(){
			
			if(isset($_REQUEST['page'])){
				
				if($_REQUEST['page'] == $this->pageslug){
				
				    wp_register_style( 'bzntp_css', plugins_url('assets/css/bzntp-main.css', __FILE__) );
					wp_enqueue_style( 'bzntp_css' );
					
					wp_register_script( 'bzntp_js', plugins_url('assets/js/bzntp-main-settings.js', __FILE__ ), '', '', true );
					wp_enqueue_script( 'bzntp_js' );
				}
			}
		}	
		
		
		
		
	   public function bzntp_get_rebranding() {
			
			if ( ! is_array( self::$rebranding ) || empty( self::$rebranding ) ) {
				if(is_multisite()){
					switch_to_blog(1);
						self::$rebranding = get_option( 'ninjatables_rebrand');
					restore_current_blog();
				} else {
					self::$rebranding = get_option( 'ninjatables_rebrand');	
				}
			}

			return self::$rebranding;
		}
		
		
		
	    /**
		 * Render branding fields.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function bzntp_render_fields() {
			
			$branding = get_option( 'ninjatables_rebrand');
			include BZNTP_BASE_DIR . 'admin/bzntp-settings-rebranding.php';
		}
		
		
		
		/**
		 * Admin Menu
		*/
		public function bzntp_menu() {
			
			global $menu, $blog_id;
			global $submenu;	
			
		    $admin_label = __('Rebrand', 'bzntp');
			$rebranding = $this->bzntp_get_rebranding();
			
			if ( current_user_can( 'manage_options' ) ) {

				$title = $admin_label;
				$cap   = 'manage_options';
				$slug  = $this->pageslug;
				$func  = array($this, 'bzntp_render');

				if( is_multisite() ) {
					if( $blog_id == 1 ) { 
						add_submenu_page( 'ninja_tables', $title, $title, $cap, $slug, $func );
					}
				} else {
					add_submenu_page( 'ninja_tables', $title, $title, $cap, $slug, $func );
				}
			}	

				
			foreach($menu as $custommenusK => $custommenusv ) {
				if( $custommenusK == '25.28862' ) {
					if( isset($rebranding['plugin_name']) && $rebranding['plugin_name'] != '') {
						$menu[$custommenusK][0] = $rebranding['plugin_name']; //change menu Label
					}
					
				}
			}
			return $menu;
		}
		  
			
		
		/**
		 * Renders to fields
		*/
		public function bzntp_render() {
			$this->bzntp_render_fields();
		}
		
	
		
		/**
		 * Save the field settings
		*/
		public function bzntp_save_settings() {
			
			if ( ! isset( $_POST['ntp_wl_nonce'] ) || ! wp_verify_nonce( $_POST['ntp_wl_nonce'], 'ntp_wl_nonce' ) ) {
				return;
			}

			if ( ! isset( $_POST['ntp_submit'] ) ) {
				return;
			}
			$this->bzntp_update_branding();
		}
		
		
		
		
		/**
		 * Include scripts & styles
		*/
		public function bzntp_branding_scripts_styles() {
			
			global $blog_id;
			
			if ( ! is_user_logged_in() ) {
				return; 
			}
			$rebranding = $this->bzntp_get_rebranding();
			
			echo '<style id="ntp-wl-admin-style">';
			include BZNTP_BASE_DIR . 'admin/bzntp-style.css.php';
			echo '</style>';
			
			echo '<script id="ntp-wl-admin-script">';
			include BZNTP_BASE_DIR . 'admin/bzntp-script.js.php';
			echo '</script>';
			
		}	  
	
	

		/**
		 * Update branding
		*/
	    public function bzntp_update_branding() {
			
			if ( ! isset($_POST['ntp_wl_nonce']) ) {
				return;
			}
			

			$data = array(
				'plugin_name'       => isset( $_POST['ntp_wl_plugin_name'] ) ? sanitize_text_field( $_POST['ntp_wl_plugin_name'] ) : '',
				
				'plugin_desc'       => isset( $_POST['ntp_wl_plugin_desc'] ) ? sanitize_text_field( $_POST['ntp_wl_plugin_desc'] ) : '',
				
				'plugin_author'     => isset( $_POST['ntp_wl_plugin_author'] ) ? sanitize_text_field( $_POST['ntp_wl_plugin_author'] ) : '',
				
				'plugin_uri'        => isset( $_POST['ntp_wl_plugin_uri'] ) ? sanitize_text_field( $_POST['ntp_wl_plugin_uri'] ) : '',
				
				
								
			);

			update_option( 'ninjatables_rebrand', $data );
		}
    
    
     
  
  
		
		/**
		 * change plugin meta
		*/  
        public function bzntp_plugin_branding( $all_plugins ) {
			
			
			if (  ! isset( $all_plugins['ninja-tables/ninja-tables.php'] ) ) {
				return $all_plugins;
			}
		   
			$rebranding = $this->bzntp_get_rebranding();
			
			$all_plugins['ninja-tables/ninja-tables.php']['Name']           = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['ninja-tables/ninja-tables.php']['Name'];
			
			$all_plugins['ninja-tables/ninja-tables.php']['PluginURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['ninja-tables/ninja-tables.php']['PluginURI'];
			
			$all_plugins['ninja-tables/ninja-tables.php']['Description']    = ! empty( $rebranding['plugin_desc'] )     ? $rebranding['plugin_desc']      : $all_plugins['ninja-tables/ninja-tables.php']['Description'];
			
			$all_plugins['ninja-tables/ninja-tables.php']['Author']         = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['ninja-tables/ninja-tables.php']['Author'];
			
			$all_plugins['ninja-tables/ninja-tables.php']['AuthorURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['ninja-tables/ninja-tables.php']['AuthorURI'];
			
			$all_plugins['ninja-tables/ninja-tables.php']['Title']          = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['ninja-tables/ninja-tables.php']['Title'];
			
			$all_plugins['ninja-tables/ninja-tables.php']['AuthorName']     = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['ninja-tables/ninja-tables.php']['AuthorName'];
			
			if( is_plugin_active(BZNTP_NINJAPRO_PLUGIN_FILE) ) {
	
				$all_plugins['ninja-tables-pro/ninja-tables-pro.php']['Name']           = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['ninja-tables-pro/ninja-tables-pro.php']['Name'];
				
				$all_plugins['ninja-tables-pro/ninja-tables-pro.php']['PluginURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['ninja-tables-pro/ninja-tables-pro.php']['PluginURI'];
				
				$all_plugins['ninja-tables-pro/ninja-tables-pro.php']['Description']    = ! empty( $rebranding['plugin_desc'] )     ? $rebranding['plugin_desc']      : $all_plugins['ninja-tables-pro/ninja-tables-pro.php']['Description'];
				
				$all_plugins['ninja-tables-pro/ninja-tables-pro.php']['Author']         = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['ninja-tables-pro/ninja-tables-pro.php']['Author'];
				
				$all_plugins['ninja-tables-pro/ninja-tables-pro.php']['AuthorURI']      = ! empty( $rebranding['plugin_uri'] )      ? $rebranding['plugin_uri']       : $all_plugins['ninja-tables-pro/ninja-tables-pro.php']['AuthorURI'];
				
				$all_plugins['ninja-tables-pro/ninja-tables-pro.php']['Title']          = ! empty( $rebranding['plugin_name'] )     ? $rebranding['plugin_name']      : $all_plugins['ninja-tables-pro/ninja-tables-pro.php']['Title'];
				
				$all_plugins['ninja-tables-pro/ninja-tables-pro.php']['AuthorName']     = ! empty( $rebranding['plugin_author'] )   ? $rebranding['plugin_author']    : $all_plugins['ninja-tables-pro/ninja-tables-pro.php']['AuthorName'];
			
			}
			
			return $all_plugins;
			
		}
	
    	
		
		/**
		 * update plugin label
		*/
		public function bzntp_update_label( $translated_text, $untranslated_text, $domain ) {
			
			$rebranding = $this->bzntp_get_rebranding();
			
			$bzntp_new_text = $translated_text;
			$bzntp_name = isset( $rebranding['plugin_name'] ) && ! empty( $rebranding['plugin_name'] ) ? $rebranding['plugin_name'] : '';
			
			if ( ! empty( $bzntp_name ) ) {

				if( is_plugin_active(BZNTP_NINJAPRO_PLUGIN_FILE) ) {
					
					$bzntp_new_text = str_replace( array( 'Ninja Tables','NinjaTables Pro' ), $bzntp_name, $bzntp_new_text );
					
				} else {
					
					$bzntp_new_text = str_replace( array('Ninja Tables','NinjaTables'), $bzntp_name, $bzntp_new_text );
				}
			}
			
			return $bzntp_new_text;
		}
	
	 
	
		/**
		 * update options
		*/
		public function bzntp_updateOption($key,$value) {
			if(is_multisite()){
				return  update_site_option($key,$value);
			}else{
				return update_option($key,$value);
			}
		}
		
		
	
		/**
		 * get options
		*/	
		public function bzntp_getOption($key,$default=False) {
			if(is_multisite()){
				switch_to_blog(1);
				$value = get_site_option($key,$default);
				restore_current_blog();
			}else{
				$value = get_option($key,$default);
			}
			return $value;
		}
		
	
} //end Class
