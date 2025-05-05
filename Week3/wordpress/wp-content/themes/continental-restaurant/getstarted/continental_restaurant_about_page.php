<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( !class_exists( 'Continental_Restaurant_Welcome' ) ) {

	class Continental_Restaurant_Welcome {
		public $theme_fields;

		public function __construct( $fields = array() ) {
			$this->theme_fields = $fields;
			add_action ('admin_init' , array( $this, 'admin_scripts' ) );
			add_action('admin_menu', array( $this, 'continental_restaurant_getstart_page_menu' ));
		}

		public function admin_scripts() {
			global $pagenow;
			$file_dir = get_template_directory_uri() . '/getstarted/assets/';

			if ( $pagenow === 'themes.php' && isset($_GET['page']) && $_GET['page'] === 'continental-restaurant-getstart-page' ) {

				wp_enqueue_style (
					'continental-restaurant-getstart-page-style',
					$file_dir . 'css/getstart-page.css',
					array(), '1.0.0'
				);

				wp_enqueue_script (
					'continental-restaurant-getstart-page-functions',
					$file_dir . 'js/getstart-page.js',
					array('jquery'),
					'1.0.0',
					true
				);
			}
		}

        public function theme_info($id, $continental_restaurant_screenshot = false) {
            $themedata = wp_get_theme();
            return ($continental_restaurant_screenshot === true) ? esc_url($themedata->get_screenshot()) : esc_html($themedata->get($id));
        }

        public function continental_restaurant_getstart_page_menu() {
            add_theme_page(
                /* translators: 1: Theme Name. */
                sprintf(esc_html__('About %1$s', 'continental-restaurant'), $this->theme_info('Name')),
                sprintf(esc_html__('About %1$s', 'continental-restaurant'), $this->theme_info('Name')),
                'edit_theme_options',
                'continental-restaurant-getstart-page',
                array( $this, 'continental_restaurant_getstart_page' )
            );
		}

        public function continental_restaurant_getstart_page() {
            $continental_restaurant_tabs = array(
                'continental_restaurant_getting_started' => esc_html__('Getting Started', 'continental-restaurant'),
                'continental_restaurant_free_pro' => esc_html__('Free VS Pro', 'continental-restaurant'),
                'changelog' => esc_html__('Changelog', 'continental-restaurant'),
                'support' => esc_html__('Support', 'continental-restaurant'),
                'review' => esc_html__('Rate & Review', 'continental-restaurant'),
            );
            ?>
                <div class="wrap about-wrap access-wrap">

                    <div class="abt-promo-wrap clearfix">
                        <div class="abt-theme-wrap">
                            <h1>
                                <?php
                                printf(
                                    /* translators: 1: Theme Name. */
                                    esc_html__('Welcome to %1$s - Version %2$s', 'continental-restaurant'),
                                    esc_html($this->theme_info('Name')),
                                    esc_html($this->theme_info('Version'))
                                );
                                ?>
                            </h1>
                            <div class="buttons">
                                <a target="_blank" href="<?php echo esc_url('https://www.revolutionwp.com/products/continental-restaurant-wordpress-theme'); ?>"><?php echo esc_html__('Buy Pro Theme', 'continental-restaurant'); ?></a>
                                <a target="_blank" href="<?php echo esc_url('https://demo.revolutionwp.com/continental-restaurant-pro/'); ?>"><?php echo esc_html__('Preview Pro Version', 'continental-restaurant'); ?></a>
                            </div>
                        </div>
                    </div>

                    <div class="nav-tab-wrapper clearfix">
                        <?php
                            $tabHTML = '';

                            foreach ($continental_restaurant_tabs as $id => $continental_restaurant_label) :

                                $continental_restaurant_target = '';
                                $continental_restaurant_nav_class = 'nav-tab';
                                $continental_restaurant_section = isset($_GET['section']) ? sanitize_text_field($_GET['section']) : 'continental_restaurant_getting_started';

                                if ($id === $continental_restaurant_section) {
                                    $continental_restaurant_nav_class .= ' nav-tab-active';
                                }

                                if ($id === 'continental_restaurant_free_pro') {
                                    $continental_restaurant_nav_class .= ' upgrade-button';
                                }

                                switch ($id) {

                                    case 'support':
                                        $continental_restaurant_target = 'target="_blank"';
                                        $continental_restaurant_url = esc_url('https://wordpress.org/support/theme/' . esc_html($this->theme_info('TextDomain')));
                                    break;

                                    case 'review':
                                        $continental_restaurant_target = 'target="_blank"';
                                        $continental_restaurant_url = esc_url('https://wordpress.org/support/theme/' . esc_html($this->theme_info('TextDomain')) . '/reviews/#new-post');
                                    break;
                                    
                                    case 'continental_restaurant_getting_started':
                                        $continental_restaurant_url = esc_url(admin_url('themes.php?page=continental-restaurant-getstart-page'));
                                    break;

                                    default:
                                        $continental_restaurant_url = esc_url(admin_url('themes.php?page=continental-restaurant-getstart-page&section=' . esc_attr($id)));
                                    break;

                                }

                                $tabHTML .= '<a ';
                                $tabHTML .= $continental_restaurant_target;
                                $tabHTML .= ' href="' . $continental_restaurant_url . '"';
                                $tabHTML .= ' class="' . esc_attr($continental_restaurant_nav_class) . '"';
                                $tabHTML .= '>';
                                $tabHTML .= esc_html($continental_restaurant_label);
                                $tabHTML .= '</a>';

                            endforeach;

                            echo $tabHTML;
                        ?>
                    </div>

                    <div class="getstart-section-wrapper">
                        <div class="getstart-section continental_restaurant_getting_started clearfix">
                            <?php
                                $continental_restaurant_section = isset($_GET['section']) ? sanitize_text_field($_GET['section']) : 'continental_restaurant_getting_started';
                                switch ($continental_restaurant_section) {

                                    case 'continental_restaurant_free_pro':
                                        $this->continental_restaurant_free_pro();
                                    break;

                                    case 'changelog':
                                        $this->changelog();
                                    break;

                                    case 'continental_restaurant_getting_started':
                                    default:
                                        $this->continental_restaurant_getting_started();
                                    break;

                                }
                            ?>
                        </div>
                    </div>

                </div>
            <?php
		}

        public function continental_restaurant_getting_started() {
            ?>
            <div class="getting-started-top-wrap clearfix">
                <div class="theme-details">
                    <div class="theme-screenshot">
                        <img src="<?php echo esc_url( $this->theme_info( 'Screenshot', true ) ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'continental-restaurant' ); ?>"/>
                    </div>
                    <div class="about-text"><?php echo esc_html( $this->theme_info( 'Description' ) ); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="theme-steps-list">
                    <div class="theme-steps demo-import">
                        <h3><?php echo esc_html__( 'One Click Demo Import', 'continental-restaurant' ); ?></h3>
                        <p><?php echo esc_html__( 'Easily set up your website with our One Click Demo Import feature. This functionality allows you to replicate our demo site with just a single click, ensuring you have a fully functional layout to start from. Whether you’re a beginner or an experienced developer, this tool simplifies the setup process, saving you time and effort.', 'continental-restaurant' ); ?></p>
                        <a target="_blank" class="button button-primary" href="<?php echo esc_url( admin_url( 'themes.php?page=continentalrestaurant-demoimport' ) ); ?>"><?php echo esc_html__( 'Click Here For Demo Import', 'continental-restaurant' ); ?></a>
                    </div>
                    <div class="getstart">
                        <div class="theme-steps">
                            <h3><?php echo esc_html__( 'Documentation', 'continental-restaurant' ); ?></h3>
                            <p><?php echo esc_html__( 'Need more details? Check our comprehensive documentation for step-by-step guidance on using the Continental Restaurant Theme.', 'continental-restaurant' ); ?></p>
                            <a target="_blank" class="button button-primary" href="<?php echo esc_url( 'https://demo.revolutionwp.com/wpdocs/continental-restaurant-free/' ); ?>"><?php echo esc_html__( 'Go to Free Docs', 'continental-restaurant' ); ?></a>
                        </div>

                        <div class="theme-steps">
                            <h3><?php echo esc_html__( 'Preview Pro Theme', 'continental-restaurant' ); ?></h3>
                            <p><?php echo esc_html__( 'Discover the full potential of our Pro Theme! Click the Live Demo button to experience premium features and beautiful designs.', 'continental-restaurant' ); ?></p>
                            <a target="_blank" class="button button-primary" href="<?php echo esc_url( 'https://demo.revolutionwp.com/continental-restaurant-pro/' ); ?>"><?php echo esc_html__( 'Live Demo', 'continental-restaurant' ); ?></a>
                        </div>

                        <div class="theme-steps highlight">
                            <h3><?php echo esc_html__( 'Buy Continental Restaurant Pro', 'continental-restaurant' ); ?></h3>
                            <p><?php echo esc_html__( 'Unlock unlimited features and enhancements by purchasing the Pro version of Continental Restaurant Theme.', 'continental-restaurant' ); ?></p>
                            <a target="_blank" class="button button-primary" href="<?php echo esc_url( 'https://www.revolutionwp.com/products/continental-restaurant-wordpress-theme' ); ?>"><?php echo esc_html__( 'Buy Pro Version @$39', 'continental-restaurant' ); ?></a>
                        </div>

                        <div class="theme-steps highlight">
                            <h3><?php echo esc_html__( 'Get the Bundle', 'continental-restaurant' ); ?></h3>
                            <p><?php echo esc_html__( 'The WordPress Theme Bundle is a comprehensive collection of 30+ premium themes, offering everything you need to create stunning, professional websites with ease.', 'continental-restaurant' ); ?></p>
                            <a target="_blank" class="button button-primary" href="<?php echo esc_url( 'https://www.revolutionwp.com/products/wordpress-theme-bundle' ); ?>"><?php echo esc_html__( 'Get Bundle', 'continental-restaurant' ); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

		public function continental_restaurant_free_pro() {
            ?>
            <table class="card table free-pro" cellspacing="0" cellpadding="0">
                <tbody class="table-body">
                    <tr class="table-head">
                        <th class="large"><?php echo esc_html__( 'Features', 'continental-restaurant' ); ?></th>
                        <th class="indicator"><?php echo esc_html__( 'Free theme', 'continental-restaurant' ); ?></th>
                        <th class="indicator"><?php echo esc_html__( 'Pro Theme', 'continental-restaurant' ); ?></th>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'One Click Demo Import', 'continental-restaurant' ); ?></h4>
                                <div class="feature-inline-row">
                                    <span class="info-icon dashicon dashicons dashicons-info"></span>
                                    <span class="feature-description">
                                        <?php echo esc_html__( 'After the activation of Continental Restaurant theme, all settings will be imported and Data Import.', 'continental-restaurant' ); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Responsive Design', 'continental-restaurant' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Site Logo upload', 'continental-restaurant' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Footer Copyright text', 'continental-restaurant' ); ?></h4>
                                <div class="feature-inline-row">
                                    <span class="info-icon dashicon dashicons dashicons-info"></span>
                                    <span class="feature-description">
                                        <?php echo esc_html__( 'Remove the copyright text from the Footer.', 'continental-restaurant' ); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Global Color', 'continental-restaurant' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Regular Bug Fixes', 'continental-restaurant' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Theme Sections', 'continental-restaurant' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="abc"><?php echo esc_html__( '2 Sections', 'continental-restaurant' ); ?></span></td>
                        <td class="indicator"><span class="abc"><?php echo esc_html__( '15+ Sections', 'continental-restaurant' ); ?></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Custom colors', 'continental-restaurant' ); ?></h4>
                                <div class="feature-inline-row">
                                    <span class="info-icon dashicon dashicons dashicons-info"></span>
                                    <span class="feature-description">
                                        <?php echo esc_html__( 'Choose a color for links, buttons, icons and so on.', 'continental-restaurant' ); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Google fonts', 'continental-restaurant' ); ?></h4>
                                <div class="feature-inline-row">
                                    <span class="info-icon dashicon dashicons dashicons-info"></span>
                                    <span class="feature-description">
                                        <?php echo esc_html__( 'You can choose and use over 600 different fonts, for the logo, the menu and the titles.', 'continental-restaurant' ); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Enhanced Plugin Integration', 'continental-restaurant' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Fully SEO Optimized', 'continental-restaurant' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Premium Support', 'continental-restaurant' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Extensive Customization', 'continental-restaurant' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Custom Post Types', 'continental-restaurant' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'High-Level Compatibility with Modern Browsers', 'continental-restaurant' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="upsell-row">
                        <td></td>
                        <td><span class="abc"><?php echo esc_html__( 'Try Out Our Premium Version', 'continental-restaurant' ); ?></span></td>
                        <td>
                            <a target="_blank" href="<?php echo esc_url( 'https://www.revolutionwp.com/products/continental-restaurant-wordpress-theme' ); ?>" class="button button-primary"><?php echo esc_html__( 'Buy Pro Theme', 'continental-restaurant' ); ?></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php
        }

		public function changelog() {
            if ( is_file( trailingslashit( get_stylesheet_directory() ) . '/getstarted/continental_restaurant_changelog.php' ) ) {
                require_once( trailingslashit( get_stylesheet_directory() ) . '/getstarted/continental_restaurant_changelog.php' );
            } else {
                require_once( trailingslashit( get_template_directory() ) . '/getstarted/continental_restaurant_changelog.php' );
            }
        }
	}

}
new Continental_Restaurant_Welcome();
?>