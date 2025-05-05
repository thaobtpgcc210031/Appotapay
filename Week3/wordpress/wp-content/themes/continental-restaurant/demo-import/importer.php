<?php
/**
 * @package Demo Import
 * @since 1.0.0
 */

class ThemeWhizzie {

	protected $version = '1.1.0';

	/** @var string Current theme name, used as namespace in actions. */
	protected $theme_name = '';
	protected $theme_title = '';

	/** @var string Demo Import page slug and title. */
	protected $page_slug = '';
	protected $page_title = '';

	/** @var array Demo Import steps set by user. */
	protected $config_steps = array();
	public $parent_slug;
	/**
	 * Relative plugin url for this plugin folder
	 * @since 1.0.0
	 * @var string
	*/
	protected $plugin_url = '';
	protected $plugin_path = '';

	/**
	 * TGMPA instance storage
	 *
	 * @var object
	*/
	protected $tgmpa_instance;

	/**
	 * TGMPA Menu slug
	 *
	 * @var string
	*/
	protected $tgmpa_menu_slug = 'tgmpa-install-plugins';

	/**
	 * TGMPA Menu url
	 *
	 * @var string
	*/
	protected $tgmpa_url = 'themes.php?page=tgmpa-install-plugins';

	/**
	 * Constructor
	 *
	 * @param $continental_restaurant_config	Our config parameters
	*/
	public function __construct( $continental_restaurant_config ) {
		$this->set_vars( $continental_restaurant_config );
		$this->init();

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	/**
	 * Set some settings
	 * @since 1.0.0
	 * @param $continental_restaurant_config	Our config parameters
	*/
	public function set_vars( $continental_restaurant_config ) {

		require_once trailingslashit( WHIZZIE_DIR ) . 'tgm/tgm.php';

		if( isset( $continental_restaurant_config['page_slug'] ) ) {
			$this->page_slug = esc_attr( $continental_restaurant_config['page_slug'] );
		}
		if( isset( $continental_restaurant_config['page_title'] ) ) {
			$this->page_title = esc_attr( $continental_restaurant_config['page_title'] );
		}
		if( isset( $continental_restaurant_config['steps'] ) ) {
			$this->config_steps = $continental_restaurant_config['steps'];
		}

		$this->plugin_path = trailingslashit( dirname( __FILE__ ) );
		$relative_url = str_replace( get_template_directory(), '', $this->plugin_path );
		$this->plugin_url = trailingslashit( get_template_directory_uri() . $relative_url );
		$current_theme = wp_get_theme();
		$this->theme_title = $current_theme->get( 'Name' );
		$this->theme_name = strtolower( preg_replace( '#[^a-zA-Z]#', '', $current_theme->get( 'Name' ) ) );
		$this->page_slug = apply_filters( $this->theme_name . '_theme_setup_wizard_page_slug', $this->theme_name . '-demoimport' );
		$this->parent_slug = apply_filters( $this->theme_name . '_theme_setup_wizard_parent_slug', '' );
	}

	/**
	 * Hooks and filters
	 * @since 1.0.0
	*/
	public function init() {

		if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
			add_action( 'init', array( $this, 'get_tgmpa_instance' ), 30 );
			add_action( 'init', array( $this, 'set_tgmpa_url' ), 40 );
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_menu', array( $this, 'menu_page' ) );
		add_action( 'admin_init', array( $this, 'get_plugins' ), 30 );
		add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10, 1 );
		add_action( 'wp_ajax_setup_plugins', array( $this, 'setup_plugins' ) );
		add_action( 'wp_ajax_setup_widgets', array( $this, 'setup_widgets' ) );
	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'demo-import-style', get_template_directory_uri() . '/demo-import/assets/css/demo-import-style.css');
		wp_register_script( 'demo-import-script', get_template_directory_uri() . '/demo-import/assets/js/demo-import-script.js', array( 'jquery' ), time() );
		wp_localize_script(
			'demo-import-script',
			'continental_restaurant_whizzie_params',
			array(
				'ajaxurl' 		=> admin_url( 'admin-ajax.php' ),
				'wpnonce' 		=> wp_create_nonce( 'whizzie_nonce' ),
				'verify_text'	=> esc_html( 'verifying', 'continental-restaurant' )
			)
		);
		wp_enqueue_script( 'demo-import-script' );
	}

	public function tgmpa_load( $status ) {
		return is_admin() || current_user_can( 'install_themes' );
	}

	/**
	 * Get configured TGMPA instance
	 *
	 * @access public
	 * @since 1.1.2
	*/
	public function get_tgmpa_instance() {
		$this->tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
	}

	/**
	 * Update $tgmpa_menu_slug and $tgmpa_parent_slug from TGMPA instance
	 *
	 * @access public
	 * @since 1.1.2
	*/
	public function set_tgmpa_url() {
		$this->tgmpa_menu_slug = ( property_exists( $this->tgmpa_instance, 'menu' ) ) ? $this->tgmpa_instance->menu : $this->tgmpa_menu_slug;
		$this->tgmpa_menu_slug = apply_filters( $this->theme_name . '_theme_setup_wizard_tgmpa_menu_slug', $this->tgmpa_menu_slug );
		$tgmpa_parent_slug = ( property_exists( $this->tgmpa_instance, 'parent_slug' ) && $this->tgmpa_instance->parent_slug !== 'themes.php' ) ? 'admin.php' : 'themes.php';
		$this->tgmpa_url = apply_filters( $this->theme_name . '_theme_setup_wizard_tgmpa_url', $tgmpa_parent_slug . '?page=' . $this->tgmpa_menu_slug );
	}


	/**  Make a modal screen for the wizard **/
	public function menu_page() {
		add_menu_page( esc_html( $this->page_title ), esc_html( $this->page_title ), 'manage_options', $this->page_slug, array( $this, 'continental_restaurant_guide' ) ,'',40);
	}

	/*** Make an interface for the wizard ***/
	public function wizard_page() {

		tgmpa_load_bulk_installer();

		// install plugins with TGM.
		if ( ! class_exists( 'TGM_Plugin_Activation' ) || ! isset( $GLOBALS['tgmpa'] ) ) {
			die( 'Failed to find TGM' );
		}
		$url = wp_nonce_url( add_query_arg( array( 'plugins' => 'go' ) ), 'whizzie-setup' );

		// copied from TGM
		$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
		$fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.
		if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
			return true; // Stop the normal page form from displaying, credential request form will be shown.
		}
		// Now we have some credentials, setup WP_Filesystem.
		if ( ! WP_Filesystem( $creds ) ) {
			// Our credentials were no good, ask the user for them again.
			request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );
			return true;
		}

		/* If we arrive here, we have the filesystem */ ?>
		<div class="wrap">
			<?php echo '<div class="whizzie-wrap">';
				// The wizard is a list with only one item visible at a time
				$steps = $this->get_steps();
				echo '<ul class="whizzie-nav wizard-icon-nav">';?>

				<?php
					$stepI=1;
					foreach( $steps as $step ) {
						$stepAct=($stepI ==1)? 1 : 0;
						if( isset( $step['icon_text'] ) && $step['icon_text'] ) {
							echo '<li class="commom-cls nav-step-' . esc_attr( $step['id'] ) . '" wizard-steps="step-'.esc_attr( $step['id'] ).'" data-enable="'.$stepAct.'">
							<p>'.esc_attr( $step['icon_text'] ).'</p>
							</li>';
						}
					$stepI++;}
			 	echo '</ul>';
				echo '<ul class="whizzie-menu wizard-menu-page">';
				foreach( $steps as $step ) {
					$class = 'step step-' . esc_attr( $step['id'] );
					echo '<li data-step="' . esc_attr( $step['id'] ) . '" class="' . esc_attr( $class ) . '" >';

						$content = call_user_func( array( $this, $step['view'] ) );
						if( isset( $content['summary'] ) ) {
							printf(
								'<div class="summary">%s</div>',
								wp_kses_post( $content['summary'] )
							);
						}
						if( isset( $content['detail'] ) ) {
							// Add a link to see more detail
							printf( '<div class="wz-require-plugins">');
							printf(
								'<div class="detail">%s</div>',
								$content['detail'] // Need to escape this
							);
							printf('</div>');
						}
						printf('<div class="wizard-button-wrapper">');
							// The next button
							if( isset( $step['button_text'] ) && $step['button_text'] ) {
								printf(
									'<div class="button-wrap"><a href="#" class="button button-primary do-it" data-callback="%s" data-step="%s">%s</a></div>',
									esc_attr( $step['callback'] ),
									esc_attr( $step['id'] ),
									esc_html( $step['button_text'] )
								);
							}

							if( isset( $step['button_text_one'] )) {
								printf(
									'<div class="button-wrap button-wrap-one">
										<a href="#" class="button button-primary do-it" data-callback="install_widgets" data-step="widgets"><p class="demo-type-text">%s</p></a>
									</div>',
									esc_html( $step['button_text_one'] )
								);
							}
						printf('</div>');
					echo '</li>';
				}
				echo '</ul>';
				?>
				<div class="step-loading"><span class="spinner">
					<img src="<?php echo esc_url(get_template_directory_uri().'/demo-import/assets/images/Spinner-Animaion.gif'); ?>">
				</span></div>
			<?php echo '</div>';?>
		</div>
	<?php }

	/**
	 * Set options for the steps
	 * @return Array
	*/
	public function get_steps() {
		$dev_steps = $this->config_steps;
		$steps = array(
			'plugins' => array(
				'id'			=> 'plugins',
				'title'			=> __( 'Plugins', 'continental-restaurant' ),
				'icon'			=> 'admin-plugins',
				'view'			=> 'get_step_plugins',
				'callback'		=> 'install_plugins',
				'button_text'	=> __( 'Install Plugins', 'continental-restaurant' ),
				'can_skip'		=> true,
				'icon_text'      => 'Plugins'
			),
			'widgets' => array(
				'id'			=> 'widgets',
				'title'			=> __( 'Customizer', 'continental-restaurant' ),
				'icon'			=> 'welcome-widgets-menus',
				'view'			=> 'get_step_widgets',
				'callback'		=> 'install_widgets',
				'button_text_one'	=> __( 'Import Demo', 'continental-restaurant' ),

				'can_skip'		=> true,
				'icon_text'      => 'Import Demo'
			),
			'done' => array(
				'id'			=> 'done',
				'title'			=> __( 'All Done', 'continental-restaurant' ),
				'icon'			=> 'yes',
				'view'			=> 'get_step_done',
				'callback'		=> '',
				'icon_text'      => 'Done'
			)
		);

		// Iterate through each step and replace with dev config values
		if( $dev_steps ) {
			// Configurable elements - these are the only ones the dev can update from config.php
			$can_config = array( 'title', 'icon', 'button_text', 'can_skip' );
			foreach( $dev_steps as $dev_step ) {
				// We can only proceed if an ID exists and matches one of our IDs
				if( isset( $dev_step['id'] ) ) {
					$id = $dev_step['id'];
					if( isset( $steps[$id] ) ) {
						foreach( $can_config as $element ) {
							if( isset( $dev_step[$element] ) ) {
								$steps[$id][$element] = $dev_step[$element];
							}
						}
					}
				}
			}
		}
		return $steps;
	}

	/*** Print the content for the intro step ***/
		public function get_step_importer() { ?>
		<div class="summary">
			<p>
				<?php esc_html_e('Thank you for choosing this Continental Restaurant Theme. Using this quick setup wizard, you will be able to configure your new website and get it running in just a few minutes. Just follow these simple steps mentioned in the wizard and get started with your website.','continental-restaurant'); ?>
			</p>
		</div>
	<?php }

	/**
	 * Get the content for the plugins step
	 * @return $content Array
	*/
	public function get_step_plugins() {
		$plugins = $this->get_plugins();
		$content = array(); ?>
			<div class="summary">
				<p>
					<?php esc_html_e('Install Recommended Plugins:	','continental-restaurant') ?>
				</p>
			</div>
		<?php // The detail element is initially hidden from the user
		$content['detail'] = '<span class="wizard-plugin-count">'.count($plugins['all']).'</span><ul class="whizzie-do-plugins">';
		// Add each plugin into a list
		foreach( $plugins['all'] as $slug=>$plugin ) {
			$content['detail'] .= '<li data-slug="' . esc_attr( $slug ) . '">' . esc_html( $plugin['name'] ) . '<div class="wizard-plugin-title">';

			$content['detail'] .= '<span class="wizard-plugin-status">Installation Required</span><i class="spinner"></i></div></li>';
		}
		$content['detail'] .= '</ul>';

		return $content;
	}

	/**    Print the content for the intro step     **/
	public function get_step_widgets() { ?>
		<div class="summary">
			<p>
				<?php esc_html_e('This theme allows you to import demo content and add widgets. Install them using the button below. You can also update or deactivate them using the Customizer.','continental-restaurant'); ?>
			</p>
		</div>
	<?php }

	/***  Print the content for the final step  ***/
	public function get_step_done() { ?>

		<div class="setup-finish">
			<p>
				<?php echo esc_html('Your demo content has been imported successfully. Click the finish button for more information.'); ?>
			</p>
			<div class="finish-buttons">
				<a href="<?php echo esc_url( admin_url( 'themes.php?page=continental-restaurant-getstart-page' ) ); ?>" class="wz-btn-customizer" target="_blank"><?php esc_html_e('About Continental Restaurant','continental-restaurant') ?></a>
				<a href="<?php echo esc_url(admin_url('/customize.php')); ?>" class="wz-btn-customizer" target="_blank"><?php esc_html_e('Customize Your Demo','continental-restaurant') ?></a>
				<a href="" class="wz-btn-builder" target="_blank"><?php esc_html_e('Customize Your Demo','continental-restaurant'); ?></a>
				<a href="<?php echo esc_url(site_url()); ?>" class="wz-btn-visit-site" target="_blank"><?php esc_html_e('Visit Your Site','continental-restaurant'); ?></a>
			</div>
			<div class="finish-buttons">
				<a href="<?php echo esc_url(admin_url()); ?>" class="button button-primary"><?php esc_html_e('Finish','continental-restaurant'); ?></a>
			</div>
		</div>

	<?php }

	/***  Get the plugins registered with TGMPA  ***/
	public function get_plugins() {
		$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		$plugins = array(
			'all' 		=> array(),
			'install'	=> array(),
			'update'	=> array(),
			'activate'	=> array()
		);
		foreach( $instance->plugins as $slug=>$plugin ) {
			if( $instance->is_plugin_active( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
				// Plugin is installed and up to date
				continue;
			} else {
				$plugins['all'][$slug] = $plugin;
				if( ! $instance->is_plugin_installed( $slug ) ) {
					$plugins['install'][$slug] = $plugin;
				} else {
					if( false !== $instance->does_plugin_have_update( $slug ) ) {
						$plugins['update'][$slug] = $plugin;
					}
					if( $instance->can_plugin_activate( $slug ) ) {
						$plugins['activate'][$slug] = $plugin;
					}
				}
			}
		}
		return $plugins;
	}

	public function setup_plugins() {
		if ( ! check_ajax_referer( 'whizzie_nonce', 'wpnonce' ) || empty( $_POST['slug'] ) ) {
			wp_send_json_error( array( 'error' => 1, 'message' => esc_html__( 'No Slug Found','continental-restaurant' ) ) );
		}
		$json = array();
		// send back some json we use to hit up TGM
		$plugins = $this->get_plugins();

		// what are we doing with this plugin?
		foreach ( $plugins['activate'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-activate',
					'action2'       => - 1,
					'message'       => esc_html__( 'Activating Plugin','continental-restaurant' ),
				);
				break;
			}
		}
		foreach ( $plugins['update'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-update',
					'action2'       => - 1,
					'message'       => esc_html__( 'Updating Plugin','continental-restaurant' ),
				);
				break;
			}
		}
		foreach ( $plugins['install'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-install',
					'action2'       => - 1,
					'message'       => esc_html__( 'Installing Plugin','continental-restaurant' ),
				);
				break;
			}
		}
		if ( $json ) {
			$json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
			wp_send_json( $json );
		} else {
			wp_send_json( array( 'done' => 1, 'message' => esc_html__( 'Success','continental-restaurant' ) ) );
		}
		exit;
	}


	//................................................. MENUS .................................................//
	
	public function continental_restaurant_customizer_nav_menu() {
		// ------- Create Primary Menu --------
		$continental_restaurant_themename = 'Continental Restaurant'; // Ensure the theme name is set
		$continental_restaurant_menuname = $continental_restaurant_themename . ' Primary Menu';
		$continental_restaurant_menulocation = 'menu-1';
		$continental_restaurant_menu_exists = wp_get_nav_menu_object($continental_restaurant_menuname);

		if (!$continental_restaurant_menu_exists) {
			$continental_restaurant_menu_id = wp_create_nav_menu($continental_restaurant_menuname);

			// Home
			wp_update_nav_menu_item($continental_restaurant_menu_id, 0, array(
				'menu-item-title' => __('Home', 'continental-restaurant'),
				'menu-item-classes' => 'home',
				'menu-item-url' => home_url('/'),
				'menu-item-status' => 'publish'
			));

			// About
			$continental_restaurant_page_about = get_page_by_path('about');
			if($continental_restaurant_page_about){
				wp_update_nav_menu_item($continental_restaurant_menu_id, 0, array(
					'menu-item-title' => __('About', 'continental-restaurant'),
					'menu-item-classes' => 'about',
					'menu-item-url' => get_permalink($continental_restaurant_page_about),
					'menu-item-status' => 'publish'
				));
			}

			// Services
			$continental_restaurant_page_services = get_page_by_path('services');
			if($continental_restaurant_page_services){
				wp_update_nav_menu_item($continental_restaurant_menu_id, 0, array(
					'menu-item-title' => __('Services', 'continental-restaurant'),
					'menu-item-classes' => 'services',
					'menu-item-url' => get_permalink($continental_restaurant_page_services),
					'menu-item-status' => 'publish'
				));
			}

			// Blog
			$continental_restaurant_page_blog = get_page_by_path('blog');
			if($continental_restaurant_page_blog){
				wp_update_nav_menu_item($continental_restaurant_menu_id, 0, array(
					'menu-item-title' => __('Blog', 'continental-restaurant'),
					'menu-item-classes' => 'blog',
					'menu-item-url' => get_permalink($continental_restaurant_page_blog),
					'menu-item-status' => 'publish'
				));
			}

			// Contact Us
			$continental_restaurant_page_contact = get_page_by_path('contact');
			if($continental_restaurant_page_contact){
				wp_update_nav_menu_item($continental_restaurant_menu_id, 0, array(
					'menu-item-title' => __('Contact Us', 'continental-restaurant'),
					'menu-item-classes' => 'contact',
					'menu-item-url' => get_permalink($continental_restaurant_page_contact),
					'menu-item-status' => 'publish'
				));
			}

			// Assign menu to location if not set
			if (!has_nav_menu($continental_restaurant_menulocation)) {
				$continental_restaurant_locations = get_theme_mod('nav_menu_locations');
				$continental_restaurant_locations[$continental_restaurant_menulocation] = $continental_restaurant_menu_id; // Use $continental_restaurant_menu_id here
				set_theme_mod('nav_menu_locations', $continental_restaurant_locations);
			}
		}
	}

	public function continental_restaurant_customizer_nav_social_menu() {

		// ------- Create Social Menu --------
		$continental_restaurant_menuname = $continental_restaurant_themename . 'Social Menu';
		$continental_restaurant_menulocation = 'social-menu';
		$continental_restaurant_menu_exists = wp_get_nav_menu_object( $continental_restaurant_menuname );

		if( !$continental_restaurant_menu_exists){
			$continental_restaurant_menu_id = wp_create_nav_menu($continental_restaurant_menuname);

			wp_update_nav_menu_item( $continental_restaurant_menu_id, 0, array(
				'menu-item-title'  => __( 'Facebook', 'continental-restaurant' ),
				'menu-item-url'    => 'https://www.facebook.com',
				'menu-item-status' => 'publish',
			) );

			wp_update_nav_menu_item( $continental_restaurant_menu_id, 0, array(
				'menu-item-title'  => __( 'Pinterest', 'continental-restaurant' ),
				'menu-item-url'    => 'https://www.pinterest.com',
				'menu-item-status' => 'publish',
			) );
	
			wp_update_nav_menu_item( $continental_restaurant_menu_id, 0, array(
				'menu-item-title'  => __( 'Twitter', 'continental-restaurant' ),
				'menu-item-url'    => 'https://www.twitter.com',
				'menu-item-status' => 'publish',
			) );
	
			wp_update_nav_menu_item( $continental_restaurant_menu_id, 0, array(
				'menu-item-title'  => __( 'Youtube', 'continental-restaurant' ),
				'menu-item-url'    => 'https://www.youtube.com',
				'menu-item-status' => 'publish',
			) );

			wp_update_nav_menu_item( $continental_restaurant_menu_id, 0, array(
				'menu-item-title'  => __( 'Instagram', 'continental-restaurant' ),
				'menu-item-url'    => 'https://www.instagram.com',
				'menu-item-status' => 'publish',
			) );

			if( !has_nav_menu( $continental_restaurant_menulocation ) ){
					$locations = get_theme_mod('nav_menu_locations');
					$locations[$continental_restaurant_menulocation] = $continental_restaurant_menu_id;
					set_theme_mod( 'nav_menu_locations', $locations );
			}
		}
	}

	/**
	* Imports the Demo Content
	* @since 1.1.0
	*/
	public function setup_widgets() {

		//................................................. MENU PAGES .................................................//
		
			$continental_restaurant_home_id='';
			$continental_restaurant_home_content = '';

			$continental_restaurant_home_title = 'Home';
			$continental_restaurant_home = array(
					'post_type' => 'page',
					'post_title' => $continental_restaurant_home_title,
					'post_content'  => $continental_restaurant_home_content,
					'post_status' => 'publish',
					'post_author' => 1,
					'post_slug' => 'home'
			);
			$continental_restaurant_home_id = wp_insert_post($continental_restaurant_home);

			//Set the home page template
			add_post_meta( $continental_restaurant_home_id, '_wp_page_template', 'revolution-home.php' );

			//Set the static front page
			$continental_restaurant_home = get_page_by_title( 'Home' );
			update_option( 'page_on_front', $continental_restaurant_home->ID );
			update_option( 'show_on_front', 'page' );


			// Create a posts page and assign the template
			$continental_restaurant_blog_title = 'Blog';
			$continental_restaurant_blog_check = get_page_by_path('blog');
			if (!$continental_restaurant_blog_check) {
				$continental_restaurant_blog = array(
					'post_type'    => 'page',
					'post_title'   => $continental_restaurant_blog_title,
					'post_status'  => 'publish',
					'post_author'  => 1,
					'post_name'    => 'blog' // Unique slug for the blog page
				);
				$continental_restaurant_blog_id = wp_insert_post($continental_restaurant_blog);

				// Set the posts page
				if (!is_wp_error($continental_restaurant_blog_id)) {
					update_option('page_for_posts', $continental_restaurant_blog_id);
				}
			}

			// Create a Contact Us page and assign the template
			$continental_restaurant_contact_title = 'Contact Us';
			$continental_restaurant_contact_check = get_page_by_path('contact');
			if (!$continental_restaurant_contact_check) {
				$continental_restaurant_contact = array(
					'post_type'    => 'page',
					'post_title'   => $continental_restaurant_contact_title,
					'post_status'  => 'publish',
					'post_author'  => 1,
					'post_name'    => 'contact' // Unique slug for the Contact Us page
				);
				wp_insert_post($continental_restaurant_contact);
			}

			// Create a About page and assign the template
			$continental_restaurant_about_title = 'About';
			$continental_restaurant_about_check = get_page_by_path('about');
			if (!$continental_restaurant_about_check) {
				$continental_restaurant_about = array(
					'post_type'    => 'page',
					'post_title'   => $continental_restaurant_about_title,
					'post_status'  => 'publish',
					'post_author'  => 1,
					'post_name'    => 'about' // Unique slug for the About page
				);
				wp_insert_post($continental_restaurant_about);
			}

			// Create a Services page and assign the template
			$continental_restaurant_services_title = 'Services';
			$continental_restaurant_services_check = get_page_by_path('services');
			if (!$continental_restaurant_services_check) {
				$continental_restaurant_services = array(
					'post_type'    => 'page',
					'post_title'   => $continental_restaurant_services_title,
					'post_status'  => 'publish',
					'post_author'  => 1,
					'post_name'    => 'services' // Unique slug for the Services page
				);
				wp_insert_post($continental_restaurant_services);
			}


		//................................................. HEADER .................................................//

			set_theme_mod('continental_restaurant_header_info_email','support@example.com');
			set_theme_mod('continental_restaurant_header_info_phone','+123 456 7890');

			set_theme_mod('continental_restaurant_facebook_link_option','#');
			set_theme_mod('continental_restaurant_twitter_link_option','#');
			set_theme_mod('continental_restaurant_google_plus_link_option','#');
			set_theme_mod('continental_restaurant_instagram_link_option','#');

		//................................................. SLIDER SECTION .................................................//

			for($i=1;$i<=3;$i++){
				set_theme_mod( 'continental_restaurant_slider_image'.$i,get_template_directory_uri().'/revolution/assets/images/slider'.$i.'.png' );
				set_theme_mod( 'continental_restaurant_slider_top_text'.$i, 'The best organic products!' );
				set_theme_mod( 'continental_restaurant_slider_heading'.$i, 'WELCOME TO RESTAURANT!' );
				set_theme_mod( 'continental_restaurant_slider_text'.$i, 'Te obtinuit ut adepto satis somno. Aliisque institoribus iter deliciae vivet vita. Te obtinuit ut adepto satis somno,' );
				set_theme_mod( 'continental_restaurant_slider_button1_text'.$i, 'Discover More' );
				set_theme_mod( 'continental_restaurant_slider_button1_link'.$i, '#' );
			}

		//................................................. PRODUCT SECTION .................................................//

			set_theme_mod('continental_restaurant_new_arrivals_top_heading','HAVE A LOOK AT');
			set_theme_mod('continental_restaurant_new_arrivals_heading','OUR PRODUCTS');

			$product_category= array(
				'Restaurant' => array(
							'PRODUCT TITLE 1',
							'PRODUCT TITLE 2',
							'PRODUCT TITLE 3',
							'PRODUCT TITLE 4',
				),
			);
			$k = 1;
			foreach ( $product_category as $product_cats => $products_name ) {

				// Insert porduct cats Start
				$content = 'Lorem ipsum dolor sit amet';
				$parent_category	=	wp_insert_term(
				$product_cats, // the term
				'product_cat', // the taxonomy
				array(
					'description'=> $content,
					'slug' => 'product_cat'.$k
				));

				$image_url = get_template_directory_uri().'/revolution/assets/images/restaurant'.$k.'.png';

				$image_name= 'img'.$k.'.png';
				$upload_dir       = wp_upload_dir();
				// Set upload folder
				$image_data= file_get_contents($image_url);
				// Get image data
				$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name );
				// Generate unique name
				$filename= basename( $unique_file_name );
				// Create image file name

				// Check folder permission and define file location
				if( wp_mkdir_p( $upload_dir['path'] ) ) {
				$file = $upload_dir['path'] . '/' . $filename;
				} else {
				$file = $upload_dir['basedir'] . '/' . $filename;
				}

				// Create the image  file on the server
				if ( ! function_exists( 'WP_Filesystem' ) ) {
					require_once( ABSPATH . 'wp-admin/includes/file.php' );
				}
				
				WP_Filesystem();
				global $wp_filesystem;
				
				if ( ! $wp_filesystem->put_contents( $file, $image_data, FS_CHMOD_FILE ) ) {
					wp_die( 'Error saving file!' );
				}
				
				// Check image file type
				$wp_filetype = wp_check_filetype( $filename, null );

				// Set attachment data
				$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title'     => sanitize_file_name( $filename ),
				'post_content'   => '',
				'post_type'     => 'product',
				'post_status'    => 'inherit'
				);

				// Create the attachment
				$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

				// Include image.php
				require_once(ABSPATH . 'wp-admin/includes/image.php');

				// Define attachment metadata
				$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

				// Assign metadata to attachment
				wp_update_attachment_metadata( $attach_id, $attach_data );

				update_woocommerce_term_meta( $parent_category['term_id'], 'thumbnail_id', $attach_id );

				// create Product START
				foreach ( $products_name as $key => $product_title ) {

					$content = 'Te obtinuit ut adepto satis somno.';
					// Create post object
					$my_post = array(
						'post_title'    => wp_strip_all_tags( $product_title ),
						'post_content'  => $content,
						'post_status'   => 'publish',
						'post_type'     => 'product',
					);

					// Insert the post into the database
					$post_id    = wp_insert_post($my_post);

					wp_set_object_terms( $post_id, 'product_cat' . $k, 'product_cat', true );

					update_post_meta( $post_id, '_price', "$30.00" );

					// Now replace meta w/ new updated value array
					$image_url = get_template_directory_uri().'/revolution/assets/images/'.str_replace( " ", "-", $product_title).'.png';

					echo $image_url . "<br>";

					$image_name       = $product_title.'.png';
					$upload_dir = wp_upload_dir();
					// Set upload folder
					$image_data = file_get_contents(esc_url($image_url));

					// Get image data
					$unique_file_name = wp_unique_filename($upload_dir['path'], $image_name);
					// Generate unique name
					$filename = basename($unique_file_name);
					// Create image file name

					// Check folder permission and define file location
					if (wp_mkdir_p($upload_dir['path'])) {
						$file = $upload_dir['path'].'/'.$filename;
					} else {
						$file = $upload_dir['basedir'].'/'.$filename;
					}

					// Create the image  file on the server
					if ( ! function_exists( 'WP_Filesystem' ) ) {
						require_once( ABSPATH . 'wp-admin/includes/file.php' );
					}
					
					WP_Filesystem();
					global $wp_filesystem;
					
					if ( ! $wp_filesystem->put_contents( $file, $image_data, FS_CHMOD_FILE ) ) {
						wp_die( 'Error saving file!' );
					}

					// Check image file type
					$wp_filetype = wp_check_filetype($filename, null);

					// Set attachment data
					$attachment = array(
						'post_mime_type' => $wp_filetype['type'],
						'post_title'     => sanitize_file_name($filename),
						'post_type'      => 'product',
						'post_status'    => 'inherit',
					);

					// Create the attachment
					$attach_id = wp_insert_attachment($attachment, $file, $post_id);

					// Include image.php
					require_once (ABSPATH.'wp-admin/includes/image.php');

					// Define attachment metadata
					$attach_data = wp_generate_attachment_metadata($attach_id, $file);

					// Assign metadata to attachment
					wp_update_attachment_metadata($attach_id, $attach_data);

					// And finally assign featured image to post
					set_post_thumbnail($post_id, $attach_id);
				}
				// Create product END
				++$k;
			}
	
		$this->continental_restaurant_customizer_nav_menu();
		$this->continental_restaurant_customizer_nav_social_menu();
	}

	//guidline for about theme
	public function continental_restaurant_guide() {
		$display_string = '';
		//custom function about theme customizer
		$return = add_query_arg( array()) ;
		$theme = wp_get_theme( 'continental-restaurant' );
		?>
		<div class="wrapper-info get-stared-page-wrap">
			<div class="wrapper-info-content">
				<div class="buynow__">
					<h2><?php esc_html_e( 'Welcome to Continental Restaurant', 'continental-restaurant' ); ?> <span class="version">Version: <?php echo esc_html($theme['Version']);?></span></h2>
					<p><?php esc_html_e('The quick setup wizard will assist you in configuring your new website. This wizard will import the demo content.', 'continental-restaurant'); ?></p>
				</div>
				<div class="buynow_">
					<a target="_blank" class="buynow_themepage" href="<?php echo esc_url('https://www.revolutionwp.com/products/continental-restaurant-wordpress-theme'); ?>"><?php echo esc_html__('Go Premium Now', 'continental-restaurant'); ?></a>
				</div>
			</div>
			<div class="tab-sec theme-option-tab">
				<div id="demo_offer" class="tabcontent open">
					<?php $this->wizard_page(); ?>
				</div>
			</div>
		</div>
	<?php }
}