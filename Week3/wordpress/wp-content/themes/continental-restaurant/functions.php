<?php
/**
 * Continental Restaurant functions and definitions
 *
 * @package Continental Restaurant
 */

if ( ! defined( 'CONTINENTAL_RESTAURANT_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'CONTINENTAL_RESTAURANT_VERSION', '1.0.0' );
}

function continental_restaurant_setup() {

	load_theme_textdomain( 'continental-restaurant', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( "align-wide" );
	add_theme_support( "responsive-embeds" );

	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'continental-restaurant' ),
			'social-menu' => esc_html__('Social Menu', 'continental-restaurant'),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-background',
		apply_filters(
			'continental_restaurant_custom_background_args',
			array(
				'default-color' => '#fafafa',
				'default-image' => '',
			)
		)
	);

	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	add_theme_support( 'post-formats', array(
        'image',
        'video',
        'gallery',
        'audio', 
    ));
	
}
add_action( 'after_setup_theme', 'continental_restaurant_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $continental_restaurant_content_width
 */
function continental_restaurant_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'continental_restaurant_content_width', 640 );
}
add_action( 'after_setup_theme', 'continental_restaurant_content_width', 0 );

add_filter( 'woocommerce_enable_setup_wizard', '__return_false' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function continental_restaurant_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'continental-restaurant' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'continental-restaurant' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 1', 'continental-restaurant' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here.', 'continental-restaurant' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 2', 'continental-restaurant' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here.', 'continental-restaurant' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 3', 'continental-restaurant' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here.', 'continental-restaurant' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'continental_restaurant_widgets_init' );


function continental_restaurant_social_menu()
    {
        if (has_nav_menu('social-menu')) :
            wp_nav_menu(array(
                'theme_location' => 'social-menu',
                'container' => 'ul',
                'menu_class' => 'social-menu menu',
                'menu_id'  => 'menu-social',
            ));
        endif;
    }


/**
 * Enqueue scripts and styles.
 */

function continental_restaurant_scripts() {
    // Google Fonts
    $query_args = array(
        'family' => 'Inter:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900|Amatic SC:wght@400;700',
        'display' => 'swap',
    );
    wp_enqueue_style('continental-restaurant-google-fonts', add_query_arg($query_args, 'https://fonts.googleapis.com/css'), array(), null);

    // Font Awesome CSS
    wp_enqueue_style('font-awesome-5', get_template_directory_uri() . '/revolution/assets/vendors/font-awesome-5/css/all.min.css', array(), '5.15.3');

    // Owl Carousel CSS
    wp_enqueue_style('owl.carousel.style', get_template_directory_uri() . '/revolution/assets/css/owl.carousel.css', array(), '2.3.4');
    
    // Main stylesheet
    wp_enqueue_style('continental-restaurant-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));

	// Add custom inline styles
	require get_parent_theme_file_path('/custom-style.php');
	wp_add_inline_style('continental-restaurant-style', $continental_restaurant_custom_css);

    // RTL styles if needed
    wp_style_add_data('continental-restaurant-style', 'rtl', 'replace');

    // Navigation script
    wp_enqueue_script('continental-restaurant-navigation', get_template_directory_uri() . '/js/navigation.js', array(), wp_get_theme()->get('Version'), true);

    // Owl Carousel script
    wp_enqueue_script('owl.carousel.jquery', get_template_directory_uri() . '/revolution/assets/js/owl.carousel.js', array('jquery'), '2.3.4', true);

    // Custom script
    wp_enqueue_script('continental-restaurant-custom-js', get_template_directory_uri() . '/revolution/assets/js/custom.js', array('jquery'), wp_get_theme()->get('Version'), true);

    // Comments reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'continental_restaurant_scripts');

if (!function_exists('continental_restaurant_related_post')) :
    /**
     * Display related posts from same category
     *
     */

    function continental_restaurant_related_post($post_id){        
        $continental_restaurant_categories = get_the_category($post_id);
        if ($continental_restaurant_categories) {
            $continental_restaurant_category_ids = array();
            $continental_restaurant_category = get_category($continental_restaurant_category_ids);
            $continental_restaurant_categories = get_the_category($post_id);
            foreach ($continental_restaurant_categories as $continental_restaurant_category) {
                $continental_restaurant_category_ids[] = $continental_restaurant_category->term_id;
            }
            $continental_restaurant_count = $continental_restaurant_category->category_count;
            if ($continental_restaurant_count > 1) { ?>

         	<?php
		$continental_restaurant_related_post_wrap = absint(get_theme_mod('continental_restaurant_enable_related_post', 1));
		if($continental_restaurant_related_post_wrap == 1){ ?>
                <div class="related-post">
                    
                    <h2 class="post-title"><?php esc_html_e(get_theme_mod('continental_restaurant_related_post_text', __('Related Post', 'continental-restaurant'))); ?></h2>
                    <?php
                    $continental_restaurant_cat_post_args = array(
                        'category__in' => $continental_restaurant_category_ids,
                        'post__not_in' => array($post_id),
                        'post_type' => 'post',
                        'posts_per_page' =>  get_theme_mod( 'continental_restaurant_related_post_count', '3' ),
                        'post_status' => 'publish',
						'orderby'           => 'rand',
                        'ignore_sticky_posts' => true
                    );
                    $continental_restaurant_featured_query = new WP_Query($continental_restaurant_cat_post_args);
                    ?>
                    <div class="rel-post-wrap">
                        <?php
                        if ($continental_restaurant_featured_query->have_posts()) :

                        while ($continental_restaurant_featured_query->have_posts()) : $continental_restaurant_featured_query->the_post();
                            ?>

							<div class="card-item rel-card-item">
								<div class="card-content">
                                    <?php if ( has_post_thumbnail() ) { ?>
                                        <div class="card-media">
                                            <?php continental_restaurant_post_thumbnail(); ?>
                                        </div>
                                    <?php } else {
                                        // Fallback default image
                                        $continental_restaurant_default_post_thumbnail = get_template_directory_uri() . '/revolution/assets/images/PRODUCT-TITLE-3.png';
                                        echo '<img class="default-post-img" src="' . esc_url( $continental_restaurant_default_post_thumbnail ) . '" alt="' . esc_attr( get_the_title() ) . '">';
                                    } ?>
									<div class="entry-title">
										<h3>
											<a href="<?php the_permalink() ?>">
												<?php the_title(); ?>
											</a>
										</h3>
									</div>
									<div class="entry-meta">
                                        <?php
                                        continental_restaurant_posted_on();
                                        continental_restaurant_posted_by();
                                        ?>
                                    </div>
								</div>
							</div>
                        <?php
                        endwhile;
                        ?>
                <?php
                endif;
                wp_reset_postdata();
                ?>
                </div>
                <?php } ?>
                <?php
            }
        }
    }
endif;
add_action('continental_restaurant_related_posts', 'continental_restaurant_related_post', 10, 1);

function continental_restaurant_sanitize_choices( $continental_restaurant_input, $continental_restaurant_setting ) {
    global $wp_customize; 
    $continental_restaurant_control = $wp_customize->get_control( $continental_restaurant_setting->id ); 
    if ( array_key_exists( $continental_restaurant_input, $continental_restaurant_control->choices ) ) {
        return $continental_restaurant_input;
    } else {
        return $continental_restaurant_setting->default;
    }
}

//Excerpt 
function continental_restaurant_excerpt_function($continental_restaurant_excerpt_count = 35) {
    $continental_restaurant_excerpt = get_the_excerpt();
    $continental_restaurant_text_excerpt = wp_strip_all_tags($continental_restaurant_excerpt);
    $continental_restaurant_excerpt_limit = (int) get_theme_mod('continental_restaurant_excerpt_limit', $continental_restaurant_excerpt_count);
    $continental_restaurant_words = preg_split('/\s+/', $continental_restaurant_text_excerpt); 
    $continental_restaurant_trimmed_words = array_slice($continental_restaurant_words, 0, $continental_restaurant_excerpt_limit);
    $continental_restaurant_theme_excerpt = implode(' ', $continental_restaurant_trimmed_words);

    return $continental_restaurant_theme_excerpt;
}

// Add admin notice
function continental_restaurant_admin_notice() { 
    global $pagenow;
    $continental_restaurant_theme_args      = wp_get_theme();
    $continental_restaurant_meta            = get_option( 'continental_restaurant_admin_notice' );
    $name            = $continental_restaurant_theme_args->__get( 'Name' );
    $continental_restaurant_current_screen  = get_current_screen();

    if( !$continental_restaurant_meta ){
	    if( is_network_admin() ){
	        return;
	    }

	    if( ! current_user_can( 'manage_options' ) ){
	        return;
	    } 
		
		if($continental_restaurant_current_screen->base != 'appearance_page_continental_restaurant_guide' ) { ?>
			<div class="notice notice-success">
				<h2><?php esc_html_e('Hey, Thank you for installing Continental Restaurant Theme!', 'continental-restaurant'); ?><span><a class="info-link" href="<?php echo esc_url( admin_url( 'themes.php?page=continental-restaurant-getstart-page' ) ); ?>"><?php esc_html_e('Click Here for more Details', 'continental-restaurant'); ?></a></span></h2>
				<p class="dismiss-link"><strong><a href="?continental_restaurant_admin_notice=1"><?php esc_html_e( 'Dismiss', 'continental-restaurant' ); ?></a></strong></p>
			</div>
			<?php
		}
	}
}

add_action( 'admin_notices', 'continental_restaurant_admin_notice' );

if( ! function_exists( 'continental_restaurant_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function continental_restaurant_update_admin_notice(){
    if ( isset( $_GET['continental_restaurant_admin_notice'] ) && $_GET['continental_restaurant_admin_notice'] = '1' ) {
        update_option( 'continental_restaurant_admin_notice', true );
    }
}
endif;
add_action( 'admin_init', 'continental_restaurant_update_admin_notice' );


add_action('after_switch_theme', 'continental_restaurant_setup_options');
function continental_restaurant_setup_options () {
    update_option('continental_restaurant_admin_notice', FALSE );
}


/**
 * Checkbox sanitization callback example.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 */
function continental_restaurant_sanitize_checkbox($checked)
{
    // Boolean check.
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/revolution/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/revolution/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/revolution/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/revolution/inc/customizer.php';

/**
* GET START.
*/
require get_template_directory() . '/getstarted/continental_restaurant_about_page.php';

/**
* DEMO IMPORT.
*/
require get_template_directory() . '/demo-import/continental_restaurant_config_file.php';

/**
 * Breadcrumb File.
 */
require get_template_directory() . '/revolution/inc/breadcrumbs.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/revolution/inc/jetpack.php';

}

function continental_restaurant_remove_customize_register() {
    global $wp_customize;

    $wp_customize->remove_setting( 'display_header_text' );
    $wp_customize->remove_control( 'display_header_text' );

}

add_action( 'customize_register', 'continental_restaurant_remove_customize_register', 11 );

/************************************************************************************/
// //////////////////////////////////////////////

/**
 * WooCommerce custom filters
 */
add_filter('loop_shop_columns', 'continental_restaurant_loop_columns');

if (!function_exists('continental_restaurant_loop_columns')) {

	function continental_restaurant_loop_columns() {

		$continental_restaurant_columns = get_theme_mod( 'continental_restaurant_per_columns', 3 );

		return $continental_restaurant_columns;
	}
}

/************************************************************************************/

add_filter( 'loop_shop_per_page', 'continental_restaurant_per_page', 20 );

function continental_restaurant_per_page( $continental_restaurant_cols ) {

  	$continental_restaurant_cols = get_theme_mod( 'continental_restaurant_product_per_page', 9 );

	return $continental_restaurant_cols;
}

/************************************************************************************/

add_filter( 'woocommerce_output_related_products_args', 'continental_restaurant_products_args' );

function continental_restaurant_products_args( $continental_restaurant_args ) {

    $continental_restaurant_args['posts_per_page'] = get_theme_mod( 'custom_related_products_number', 6 );

    $continental_restaurant_args['columns'] = get_theme_mod( 'custom_related_products_number_per_row', 3 );

    return $continental_restaurant_args;
}

/************************************************************************************/

/**
 * Custom logo
 */

function continental_restaurant_custom_css() {
?>
	<style type="text/css" id="custom-theme-colors" >
        :root {
           
            --continental_restaurant_logo_width: <?php echo absint(get_theme_mod('continental_restaurant_logo_width')); ?> ;   
        }
        .site-branding img {
            max-width:<?php echo esc_html(get_theme_mod('continental_restaurant_logo_width')); ?>px ;    
        }         
	</style>
<?php
}
add_action( 'wp_head', 'continental_restaurant_custom_css' );

define('CONTINENTAL_RESTAURANT_FREE_SUPPORT',__('https://www.revolutionwp.com/products/free-restaurant-wordpress-theme','continental-restaurant'));
define('CONTINENTAL_RESTAURANT_PRO_SUPPORT',__('https://www.revolutionwp.com/pages/community/','continental-restaurant'));
define('CONTINENTAL_RESTAURANT_REVIEW',__('https://wordpress.org/support/theme/continental-restaurant/reviews/#new-post','continental-restaurant'));
define('CONTINENTAL_RESTAURANT_BUY_NOW',__('https://www.revolutionwp.com/products/continental-restaurant-wordpress-theme','continental-restaurant'));
define('CONTINENTAL_RESTAURANT_LIVE_DEMO',__('https://demo.revolutionwp.com/continental-restaurant-pro/','continental-restaurant'));
define('CONTINENTAL_RESTAURANT_PRO_DOC',__('https://demo.revolutionwp.com/wpdocs/continental-restaurant-pro/','continental-restaurant'));
define('CONTINENTAL_RESTAURANT_LITE_DOC',__('https://demo.revolutionwp.com/wpdocs/continental-restaurant-free/','continental-restaurant'));

function get_changelog_from_readme() {
    $continental_restaurant_file_path = get_template_directory() . '/readme.txt'; // Adjust path if necessary

    if (file_exists($continental_restaurant_file_path)) {
        $continental_restaurant_content = file_get_contents($continental_restaurant_file_path);

        // Extract changelog section
        $continental_restaurant_changelog_start = strpos($continental_restaurant_content, "== Changelog ==");
        $continental_restaurant_changelog = substr($continental_restaurant_content, $continental_restaurant_changelog_start);

        // Split changelog into versions
        preg_match_all('/\*\s([\d\.]+)\s-\s(.+?)\n((?:\t-\s.+?\n)+)/', $continental_restaurant_changelog, $continental_restaurant_matches, PREG_SET_ORDER);
        
        return $continental_restaurant_matches;
    }
    return [];
}