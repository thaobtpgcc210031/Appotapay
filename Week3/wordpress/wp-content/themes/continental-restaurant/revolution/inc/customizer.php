<?php
/**
 * Continental Restaurant Theme Customizer
 *
 * @package Continental Restaurant
 */

function Continental_Restaurant_Customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'Continental_Restaurant_Customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'Continental_Restaurant_Customize_partial_blogdescription',
			)
		);
	}

	/*
    * Theme Options Panel
    */
	$wp_customize->add_panel('continental_restaurant_panel', array(
		'priority' => 25,
		'capability' => 'edit_theme_options',
		'title' => __('Restaurant Theme Options', 'continental-restaurant'),
	));

	/*
	* Customizer main header section
	*/

	$wp_customize->add_setting(
		'continental_restaurant_site_title_text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_site_title_text',
		array(
			'label'       => __('Enable Title', 'continental-restaurant'),
			'description' => __('Enable or Disable Title from the site', 'continental-restaurant'),
			'section'     => 'title_tagline',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'continental_restaurant_site_tagline_text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 0,
			'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_site_tagline_text',
		array(
			'label'       => __('Enable Tagline', 'continental-restaurant'),
			'description' => __('Enable or Disable Tagline from the site', 'continental-restaurant'),
			'section'     => 'title_tagline',
			'type'        => 'checkbox',
		)
	);

		$wp_customize->add_setting(
		'continental_restaurant_logo_width',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '150',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_logo_width',
		array(
			'label'       => __('Logo Width in PX', 'continental-restaurant'),
			'section'     => 'title_tagline',
			'type'        => 'number',
			'input_attrs' => array(
	            'min' => 100,
	             'max' => 300,
	             'step' => 1,
	         ),
		)
	);

	/* WooCommerce custom settings */

	$wp_customize->add_section('woocommerce_custom_settings', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('WooCommerce Custom Settings', 'continental-restaurant'),
		'panel'       => 'woocommerce',
	));

	$wp_customize->add_setting(
		'continental_restaurant_per_columns',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '3',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_per_columns',
		array(
			'label'       => __('Product Per Single Row', 'continental-restaurant'),
			'section'     => 'woocommerce_custom_settings',
			'type'        => 'number',
			'input_attrs' => array(
	            'min' => 1,
	             'max' => 4,
	             'step' => 1,
	         ),
		)
	);

	$wp_customize->add_setting(
		'continental_restaurant_product_per_page',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '6',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_product_per_page',
		array(
			'label'       => __('Product Per One Page', 'continental-restaurant'),
			'section'     => 'woocommerce_custom_settings',
			'type'        => 'number',
			'input_attrs' => array(
	            'min' => 1,
	             'max' => 12,
	             'step' => 1,
	         ),
		)
	);

	/*Related Products Enable Option*/
	$wp_customize->add_setting(
		'continental_restaurant_enable_related_product',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_enable_related_product',
		array(
			'label'       => __('Enable Related Product', 'continental-restaurant'),
			'description' => __('Checked to show Related Product', 'continental-restaurant'),
			'section'     => 'woocommerce_custom_settings',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'custom_related_products_number',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '3',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'custom_related_products_number',
		array(
			'label'       => __('Related Product Count', 'continental-restaurant'),
			'section'     => 'woocommerce_custom_settings',
			'type'        => 'number',
			'input_attrs' => array(
	            'min' => 1,
	             'max' => 20,
	             'step' => 1,
	         ),
		)
	);

	$wp_customize->add_setting(
		'custom_related_products_number_per_row',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '3',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'custom_related_products_number_per_row',
		array(
			'label'       => __('Related Product Per Row', 'continental-restaurant'),
			'section'     => 'woocommerce_custom_settings',
			'type'        => 'number',
			'input_attrs' => array(
	            'min' => 1,
	             'max' => 4,
	             'step' => 1,
	         ),
		)
	);

	/*Archive Product layout*/
	$wp_customize->add_setting('continental_restaurant_archive_product_layout',array(
        'default' => 'layout-1',
        'sanitize_callback' => 'continental_restaurant_sanitize_choices'
	));
	$wp_customize->add_control('continental_restaurant_archive_product_layout',array(
        'type' => 'select',
        'label' => esc_html__('Archive Product Layout','continental-restaurant'),
        'section' => 'woocommerce_custom_settings',
        'choices' => array(
            'layout-1' => esc_html__('Sidebar On Right','continental-restaurant'),
            'layout-2' => esc_html__('Sidebar On Left','continental-restaurant'),
			'layout-3' => esc_html__('Full Width Layout','continental-restaurant')
        ),
	) );

	/*Single Product layout*/
	$wp_customize->add_setting('continental_restaurant_single_product_layout',array(
        'default' => 'layout-1',
        'sanitize_callback' => 'continental_restaurant_sanitize_choices'
	));
	$wp_customize->add_control('continental_restaurant_single_product_layout',array(
        'type' => 'select',
        'label' => esc_html__('Single Product Layout','continental-restaurant'),
        'section' => 'woocommerce_custom_settings',
        'choices' => array(
            'layout-1' => esc_html__('Sidebar On Right','continental-restaurant'),
            'layout-2' => esc_html__('Sidebar On Left','continental-restaurant'),
			'layout-3' => esc_html__('Full Width Layout','continental-restaurant')
        ),
	) );

	$wp_customize->add_setting('continental_restaurant_woocommerce_product_sale',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
        'default'           => 'Right',
        'sanitize_callback' => 'continental_restaurant_sanitize_choices'
    ));
    $wp_customize->add_control('continental_restaurant_woocommerce_product_sale',array(
        'label'       => esc_html__( 'Woocommerce Product Sale Positions','continental-restaurant' ),
        'type' => 'select',
        'section' => 'woocommerce_custom_settings',
        'choices' => array(
            'Right' => __('Right','continental-restaurant'),
            'Left' => __('Left','continental-restaurant'),
            'Center' => __('Center','continental-restaurant')
        ),
    ) );

	/*Additional Options*/
	$wp_customize->add_section('continental_restaurant_additional_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Additional Options', 'continental-restaurant'),
		'panel'       => 'continental_restaurant_panel',
	));

	/*Main Slider Enable Option*/
	$wp_customize->add_setting(
		'continental_restaurant_enable_sticky_header',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => false,
			'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_enable_sticky_header',
		array(
			'label'       => __('Enable Sticky Header', 'continental-restaurant'),
			'description' => __('Checked to enable sticky header', 'continental-restaurant'),
			'section'     => 'continental_restaurant_additional_section',
			'type'        => 'checkbox',
		)
	);

	/*Main Slider Enable Option*/
	$wp_customize->add_setting(
		'continental_restaurant_enable_preloader',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 0,
			'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_enable_preloader',
		array(
			'label'       => __('Enable Preloader', 'continental-restaurant'),
			'description' => __('Checked to show preloader', 'continental-restaurant'),
			'section'     => 'continental_restaurant_additional_section',
			'type'        => 'checkbox',
		)
	);
	

	/*Post layout*/
	$wp_customize->add_setting('continental_restaurant_archive_layout',array(
		'default' => 'layout-1',
		'sanitize_callback' => 'continental_restaurant_sanitize_choices'
	));
	$wp_customize->add_control('continental_restaurant_archive_layout',array(
		'type' => 'select',
		'label' => esc_html__('Posts Layout','continental-restaurant'),
		'section' => 'continental_restaurant_additional_section',
		'choices' => array(
			'layout-1' => esc_html__('Sidebar On Right','continental-restaurant'),
			'layout-2' => esc_html__('Sidebar On Left','continental-restaurant'),
			'layout-3' => esc_html__('Full Width Layout','continental-restaurant')
		),
	) );

	/*single post layout*/
	$wp_customize->add_setting('continental_restaurant_post_layout',array(
		'default' => 'layout-1',
		'sanitize_callback' => 'continental_restaurant_sanitize_choices'
	));
	$wp_customize->add_control('continental_restaurant_post_layout',array(
		'type' => 'select',
		'label' => esc_html__('Single Post Layout','continental-restaurant'),
		'section' => 'continental_restaurant_additional_section',
		'choices' => array(
			'layout-1' => esc_html__('Sidebar On Right','continental-restaurant'),
			'layout-2' => esc_html__('Sidebar On Left','continental-restaurant'),
			'layout-3' => esc_html__('Full Width Layout','continental-restaurant')
		),
	) );

	/*single page layout*/
	$wp_customize->add_setting('continental_restaurant_page_layout',array(
		'default' => 'layout-1',
		'sanitize_callback' => 'continental_restaurant_sanitize_choices'
	));
	$wp_customize->add_control('continental_restaurant_page_layout',array(
		'type' => 'select',
		'label' => esc_html__('Single Page Layout','continental-restaurant'),
		'section' => 'continental_restaurant_additional_section',
		'choices' => array(
			'layout-1' => esc_html__('Sidebar On Right','continental-restaurant'),
			'layout-2' => esc_html__('Sidebar On Left','continental-restaurant'),
			'layout-3' => esc_html__('Full Width Layout','continental-restaurant')
		),
	) );

	/*Archive Post Options*/
	$wp_customize->add_section('continental_restaurant_blog_post_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Blog Page Options', 'continental-restaurant'),
		'panel'       => 'continental_restaurant_panel',
	));

	$wp_customize->add_setting('continental_restaurant_enable_blog_post_title',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
	));
	$wp_customize->add_control('continental_restaurant_enable_blog_post_title',array(
		'label'       => __('Enable Blog Post Title', 'continental-restaurant'),
		'description' => __('Checked To Show Blog Post Title', 'continental-restaurant'),
		'section'     => 'continental_restaurant_blog_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('continental_restaurant_enable_blog_post_meta',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
	));
	$wp_customize->add_control('continental_restaurant_enable_blog_post_meta',array(
		'label'       => __('Enable Blog Post Meta', 'continental-restaurant'),
		'description' => __('Checked To Show Blog Post Meta Feilds', 'continental-restaurant'),
		'section'     => 'continental_restaurant_blog_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('continental_restaurant_enable_blog_post_tags',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
	));
	$wp_customize->add_control('continental_restaurant_enable_blog_post_tags',array(
		'label'       => __('Enable Blog Post Tags', 'continental-restaurant'),
		'description' => __('Checked To Show Blog Post Tags', 'continental-restaurant'),
		'section'     => 'continental_restaurant_blog_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('continental_restaurant_enable_blog_post_image',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
	));
	$wp_customize->add_control('continental_restaurant_enable_blog_post_image',array(
		'label'       => __('Enable Blog Post Image', 'continental-restaurant'),
		'description' => __('Checked To Show Blog Post Image', 'continental-restaurant'),
		'section'     => 'continental_restaurant_blog_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('continental_restaurant_enable_blog_post_content',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
	));
	$wp_customize->add_control('continental_restaurant_enable_blog_post_content',array(
		'label'       => __('Enable Blog Post Content', 'continental-restaurant'),
		'description' => __('Checked To Show Blog Post Content', 'continental-restaurant'),
		'section'     => 'continental_restaurant_blog_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('continental_restaurant_enable_blog_post_button',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
	));
	$wp_customize->add_control('continental_restaurant_enable_blog_post_button',array(
		'label'       => __('Enable Blog Post Read More Button', 'continental-restaurant'),
		'description' => __('Checked To Show Blog Post Read More Button', 'continental-restaurant'),
		'section'     => 'continental_restaurant_blog_post_section',
		'type'        => 'checkbox',
	));

	/*Blog post Content layout*/
	$wp_customize->add_setting('continental_restaurant_blog_Post_content_layout',array(
		'default' => 'Left',
		'sanitize_callback' => 'continental_restaurant_sanitize_choices'
	));
	$wp_customize->add_control('continental_restaurant_blog_Post_content_layout',array(
		'type' => 'select',
		'label' => esc_html__('Blog Post Content Layout','continental-restaurant'),
		'section' => 'continental_restaurant_blog_post_section',
		'choices' => array(
			'Left' => esc_html__('Left','continental-restaurant'),
			'Center' => esc_html__('Center','continental-restaurant'),
			'Right' => esc_html__('Right','continental-restaurant')
		),
	) );

	/*Excerpt*/
	$wp_customize->add_setting(
		'continental_restaurant_excerpt_limit',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '25',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_excerpt_limit',
		array(
			'label'       => __('Excerpt Limit', 'continental-restaurant'),
			'section'     => 'continental_restaurant_blog_post_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min' => 2,
				'max' => 50,
				'step' => 2,
			),
		)
	);

	/*Archive Button Text*/
	$wp_customize->add_setting(
		'continental_restaurant_read_more_text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 'Continue Reading....',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_read_more_text',
		array(
			'label'       => __('Edit Button Text ', 'continental-restaurant'),
			'section'     => 'continental_restaurant_blog_post_section',
			'type'        => 'text',
		)
	);

	/*Single Post Options*/
	$wp_customize->add_section('continental_restaurant_single_post_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Single Post Options', 'continental-restaurant'),
		'panel'       => 'continental_restaurant_panel',
	));

	$wp_customize->add_setting('continental_restaurant_enable_single_blog_post_title',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
	));
	$wp_customize->add_control('continental_restaurant_enable_single_blog_post_title',array(
		'label'       => __('Enable Single Post Title', 'continental-restaurant'),
		'description' => __('Checked To Show Single Blog Post Title', 'continental-restaurant'),
		'section'     => 'continental_restaurant_single_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('continental_restaurant_enable_single_blog_post_meta',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
	));
	$wp_customize->add_control('continental_restaurant_enable_single_blog_post_meta',array(
		'label'       => __('Enable Single Post Meta', 'continental-restaurant'),
		'description' => __('Checked To Show Single Blog Post Meta Feilds', 'continental-restaurant'),
		'section'     => 'continental_restaurant_single_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('continental_restaurant_enable_single_blog_post_tags',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
	));
	$wp_customize->add_control('continental_restaurant_enable_single_blog_post_tags',array(
		'label'       => __('Enable Single Post Tags', 'continental-restaurant'),
		'description' => __('Checked To Show Single Blog Post Tags', 'continental-restaurant'),
		'section'     => 'continental_restaurant_single_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('continental_restaurant_enable_single_post_image',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
	));
	$wp_customize->add_control('continental_restaurant_enable_single_post_image',array(
		'label'       => __('Enable Single Post Image', 'continental-restaurant'),
		'description' => __('Checked To Show Single Post Image', 'continental-restaurant'),
		'section'     => 'continental_restaurant_single_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('continental_restaurant_enable_single_blog_post_content',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
	));
	$wp_customize->add_control('continental_restaurant_enable_single_blog_post_content',array(
		'label'       => __('Enable Single Post Content', 'continental-restaurant'),
		'description' => __('Checked To Show Single Blog Post Content', 'continental-restaurant'),
		'section'     => 'continental_restaurant_single_post_section',
		'type'        => 'checkbox',
	));

	/*Related Post Enable Option*/
	$wp_customize->add_setting(
		'continental_restaurant_enable_related_post',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_enable_related_post',
		array(
			'label'       => __('Enable Related Post', 'continental-restaurant'),
			'description' => __('Checked to show Related Post', 'continental-restaurant'),
			'section'     => 'continental_restaurant_single_post_section',
			'type'        => 'checkbox',
		)
	);

	/*Related post Edit Text*/
	$wp_customize->add_setting(
		'continental_restaurant_related_post_text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 'Related Post',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_related_post_text',
		array(
			'label'       => __('Edit Related Post Text ', 'continental-restaurant'),
			'section'     => 'continental_restaurant_single_post_section',
			'type'        => 'text',
		)
	);	

	/*Related Post Per Page*/
	$wp_customize->add_setting(
		'continental_restaurant_related_post_count',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '3',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_related_post_count',
		array(
			'label'       => __('Related Post Count', 'continental-restaurant'),
			'section'     => 'continental_restaurant_single_post_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min' => 1,
				'max' => 9,
				'step' => 1,
			),
		)
	);

		/*
	* Customizer Global COlor
	*/

	/*Global Color Options*/
	$wp_customize->add_section('continental_restaurant_global_color_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Global Color Options', 'continental-restaurant'),
		'panel'       => 'continental_restaurant_panel',
	));

	$wp_customize->add_setting( 'continental_restaurant_primary_color',
		array(
		'default'           => '#9F2C75',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'continental_restaurant_primary_color',
		array(
			'label'      => esc_html__( 'Primary Color', 'continental-restaurant' ),
			'section'    => 'continental_restaurant_global_color_section',
			'settings'   => 'continental_restaurant_primary_color',
		) ) 
	);
	
	$wp_customize->add_setting( 'continental_restaurant_tertiary_color',
	array(
	'default'           => '#EC9C34',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control( 
	new WP_Customize_Color_Control( 
	$wp_customize, 
	'continental_restaurant_tertiary_color',
	array(
		'label'      => esc_html__( 'Secondary Color', 'continental-restaurant' ),
		'section'    => 'continental_restaurant_global_color_section',
		'settings'   => 'continental_restaurant_tertiary_color',
	) ) 
);

	$wp_customize->add_setting( 'continental_restaurant_secondary_color',
		array(
		'default'           => '#000',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'continental_restaurant_secondary_color',
		array(
			'label'      => esc_html__( 'Secondary Color', 'continental-restaurant' ),
			'section'    => 'continental_restaurant_global_color_section',
			'settings'   => 'continental_restaurant_secondary_color',
		) ) 
	);


	/*
	* Customizer main header section
	*/

	/*Main Header Options*/
	$wp_customize->add_section('continental_restaurant_header_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Main Header Options', 'continental-restaurant'),
		'panel'       => 'continental_restaurant_panel',
	));

	/*Main Header Phone Text*/
	$wp_customize->add_setting(
		'continental_restaurant_header_info_email',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'continental_restaurant_header_info_email',
		array(
			'label'       => __('Edit Email Address ', 'continental-restaurant'),
			'section'     => 'continental_restaurant_header_section',
			'type'        => 'text',
		)
	);

	/*Main Header Phone Text*/
	$wp_customize->add_setting(
		'continental_restaurant_header_info_phone',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'continental_restaurant_header_info_phone',
		array(
			'label'       => __('Edit Phone Number ', 'continental-restaurant'),
			'section'     => 'continental_restaurant_header_section',
			'type'        => 'text',
		)
	);

	/*Facebook Link*/
	$wp_customize->add_setting(
		'continental_restaurant_facebook_link_option',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_facebook_link_option',
		array(
			'label'       => __('Edit Facebook Link', 'continental-restaurant'),
			'section'     => 'continental_restaurant_header_section',
			'type'        => 'url',
		)
	);

	/*Twitter Link*/
	$wp_customize->add_setting(
		'continental_restaurant_twitter_link_option',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_twitter_link_option',
		array(
			'label'       => __('Edit Twitter Link', 'continental-restaurant'),
			'section'     => 'continental_restaurant_header_section',
			'type'        => 'url',
		)
	);

	/*Youtube Link*/
	$wp_customize->add_setting(
		'continental_restaurant_google_plus_link_option',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'continental_restaurant_google_plus_link_option',
		array(
			'label'       => __('Edit Google Plus Link', 'continental-restaurant'),
			'section'     => 'continental_restaurant_header_section',
			'type'        => 'url',
		)
	);

	/*Instagram Link*/
	$wp_customize->add_setting(
		'continental_restaurant_instagram_link_option',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_instagram_link_option',
		array(
			'label'       => __('Edit Instagram Link', 'continental-restaurant'),
			'section'     => 'continental_restaurant_header_section',
			'type'        => 'url',
		)
	);

	/*
	* Customizer main slider section
	*/
	/*Main Slider Options*/
	$wp_customize->add_section('continental_restaurant_slider_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Main Slider Options', 'continental-restaurant'),
		'panel'       => 'continental_restaurant_panel',
	));

	/*Main Slider Enable Option*/
	$wp_customize->add_setting(
		'continental_restaurant_enable_slider',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_enable_slider',
		array(
			'label'       => __('Enable Main Slider', 'continental-restaurant'),
			'description' => __('Checked to show the main slider', 'continental-restaurant'),
			'section'     => 'continental_restaurant_slider_section',
			'type'        => 'checkbox',
		)
	);

	for ($i=1; $i <= 3; $i++) { 

		/*Main Slider Image*/
		$wp_customize->add_setting(
			'continental_restaurant_slider_image'.$i,
			array(
				'capability'    => 'edit_theme_options',
		        'default'       => '',
		        'transport'     => 'postMessage',
		        'sanitize_callback' => 'esc_url_raw',
	    	)
	    );

		$wp_customize->add_control( 
			new WP_Customize_Image_Control( $wp_customize, 
				'continental_restaurant_slider_image'.$i, 
				array(
			        'label' => __('Edit Slider Image ', 'continental-restaurant') .$i,
			        'description' => __('Edit the slider image.', 'continental-restaurant'),
			        'section' => 'continental_restaurant_slider_section',
				)
			)
		);

		/*Main Slider Heading*/
		$wp_customize->add_setting(
			'continental_restaurant_slider_top_text'.$i,
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'continental_restaurant_slider_top_text'.$i,
			array(
				'label'       => __('Edit Slider Top Text ', 'continental-restaurant') .$i,
				'description' => __('Edit the slider Top text.', 'continental-restaurant'),
				'section'     => 'continental_restaurant_slider_section',
				'type'        => 'text',
			)
		);

		/*Main Slider Heading*/
		$wp_customize->add_setting(
			'continental_restaurant_slider_heading'.$i,
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'continental_restaurant_slider_heading'.$i,
			array(
				'label'       => __('Edit Heading Text ', 'continental-restaurant') .$i,
				'description' => __('Edit the slider heading text.', 'continental-restaurant'),
				'section'     => 'continental_restaurant_slider_section',
				'type'        => 'text',
			)
		);

		/*Main Slider Content*/
		$wp_customize->add_setting(
			'continental_restaurant_slider_text'.$i,
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'continental_restaurant_slider_text'.$i,
			array(
				'label'       => __('Edit Content Text ', 'continental-restaurant') .$i,
				'description' => __('Edit the slider content text.', 'continental-restaurant'),
				'section'     => 'continental_restaurant_slider_section',
				'type'        => 'text',
			)
		);

		/*Main Slider Button1 Text*/
		$wp_customize->add_setting(
			'continental_restaurant_slider_button1_text'.$i,
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'continental_restaurant_slider_button1_text'.$i,
			array(
				'label'       => __('Edit Button #1 Text ', 'continental-restaurant') .$i,
				'description' => __('Edit the slider button text.', 'continental-restaurant'),
				'section'     => 'continental_restaurant_slider_section',
				'type'        => 'text',
			)
		);

		/*Main Slider Button1 URL*/
		$wp_customize->add_setting(
			'continental_restaurant_slider_button1_link'.$i,
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			'continental_restaurant_slider_button1_link'.$i,
			array(
				'label'       => __('Edit Button #1 URL ', 'continental-restaurant') .$i,
				'description' => __('Edit the slider button url.', 'continental-restaurant'),
				'section'     => 'continental_restaurant_slider_section',
				'type'        => 'url',
			)
		);
	}

	/*
	* Customizer Our Special Products section
	*/
	/*New Arrivals Options*/
	$wp_customize->add_section('continental_restaurant_arrivals_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Our Products Option', 'continental-restaurant'),
		'panel'       => 'continental_restaurant_panel',
	));

	/*New Arrivals Enable Option*/
	$wp_customize->add_setting(
		'continental_restaurant_enable_new_arrivals',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_enable_new_arrivals',
		array(
			'label'       => __('Enable Our Special Products Section', 'continental-restaurant'),
			'description' => __('Checked to show the category', 'continental-restaurant'),
			'section'     => 'continental_restaurant_arrivals_section',
			'type'        => 'checkbox',
		)
	);

	/*Our Special Products Heading 2*/
	$wp_customize->add_setting(
		'continental_restaurant_new_arrivals_top_heading',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_new_arrivals_top_heading',
		array(
			'label'       => __('Edit Section Top Heading', 'continental-restaurant'),
			'description' => __('Edit section top heading', 'continental-restaurant'),
			'section'     => 'continental_restaurant_arrivals_section',
			'type'        => 'text',
		)
	);

	/*Our Special Products Heading*/
	$wp_customize->add_setting(
		'continental_restaurant_new_arrivals_heading',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_new_arrivals_heading',
		array(
			'label'       => __('Edit Section Heading', 'continental-restaurant'),
			'description' => __('Edit section main heading', 'continental-restaurant'),
			'section'     => 'continental_restaurant_arrivals_section',
			'type'        => 'text',
		)
	);

	/*Our Special Products Products*/
	$args = array(
       'type'      => 'product',
        'taxonomy' => 'product_cat'
    );
	$categories = get_categories($args);
		$cat_posts = array();
			$i = 0;
			$cat_posts[]='Select';
		foreach($categories as $category){
			if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_posts[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('continental_restaurant_product_category',array(
		'sanitize_callback' => 'continental_restaurant_sanitize_choices',
	));
	$wp_customize->add_control('continental_restaurant_product_category',array(
		'type'    => 'select',
		'choices' => $cat_posts,
		'label' => __('Select Product Category','continental-restaurant'),
		'section' => 'continental_restaurant_arrivals_section',
	));

	/*
	* Customizer Footer Section
	*/
	/*Footer Options*/
	$wp_customize->add_section('continental_restaurant_footer_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Footer Options', 'continental-restaurant'),
		'panel'       => 'continental_restaurant_panel',
	));

	/*Footer Enable Option*/
	$wp_customize->add_setting(
		'continental_restaurant_enable_footer',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'continental_restaurant_enable_footer',
		array(
			'label'       => __('Enable Footer', 'continental-restaurant'),
			'description' => __('Checked to show Footer', 'continental-restaurant'),
			'section'     => 'continental_restaurant_footer_section',
			'type'        => 'checkbox',
		)
	);

	/*Footer bg image Option*/
	$wp_customize->add_setting('continental_restaurant_footer_bg_image',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'continental_restaurant_footer_bg_image',array(
        'label' => __('Footer Background Image','continental-restaurant'),
        'section' => 'continental_restaurant_footer_section',
        'priority' => 1,
    )));

	/*Footer Social Menu Option*/
	$wp_customize->add_setting(
		'continental_restaurant_footer_social_menu',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_footer_social_menu',
		array(
			'label'       => __('Enable Footer Social Menu', 'continental-restaurant'),
			'description' => __('Checked to show the footer social menu. Go to Dashboard >> Appearance >> Menus >> Create New Menu >> Add Custom Link >> Add Social Menu >> Checked Social Menu >> Save Menu.', 'continental-restaurant'),
			'section'     => 'continental_restaurant_footer_section',
			'type'        => 'checkbox',
		)
	);	

	/*Go To Top Option*/
	$wp_customize->add_setting(
		'continental_restaurant_enable_go_to_top_option',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'continental_restaurant_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_enable_go_to_top_option',
		array(
			'label'       => __('Enable Go To Top', 'continental-restaurant'),
			'description' => __('Checked to enable Go To Top option.', 'continental-restaurant'),
			'section'     => 'continental_restaurant_footer_section',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting('continental_restaurant_go_to_top_position',array(
        'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 'Right',
        'sanitize_callback' => 'continental_restaurant_sanitize_choices'
    ));
    $wp_customize->add_control('continental_restaurant_go_to_top_position',array(
        'type' => 'select',
        'section' => 'continental_restaurant_footer_section',
        'label' => esc_html__('Go To Top Positions','continental-restaurant'),
        'choices' => array(
            'Right' => __('Right','continental-restaurant'),
            'Left' => __('Left','continental-restaurant'),
            'Center' => __('Center','continental-restaurant')
        ),
    ) );

	/*Footer Copyright Text Enable*/
	$wp_customize->add_setting(
		'continental_restaurant_copyright_option',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'continental_restaurant_copyright_option',
		array(
			'label'       => __('Edit Copyright Text', 'continental-restaurant'),
			'description' => __('Edit the Footer Copyright Section.', 'continental-restaurant'),
			'section'     => 'continental_restaurant_footer_section',
			'type'        => 'text',
		)
	);
}
add_action( 'customize_register', 'Continental_Restaurant_Customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function Continental_Restaurant_Customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function Continental_Restaurant_Customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function Continental_Restaurant_Customize_preview_js() {
	wp_enqueue_script( 'continental-restaurant-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), CONTINENTAL_RESTAURANT_VERSION, true );
}
add_action( 'customize_preview_init', 'Continental_Restaurant_Customize_preview_js' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Continental_Restaurant_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $continental_restaurant_instance = null;

		if ( is_null( $continental_restaurant_instance ) ) {
			$continental_restaurant_instance = new self;
			$continental_restaurant_instance->setup_actions();
		}

		return $continental_restaurant_instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $continental_restaurant_manager
	 * @return void
	*/
	public function sections( $continental_restaurant_manager ) {
		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/revolution/inc/section-pro.php' );

		// Register custom section types.
		$continental_restaurant_manager->register_section_type( 'continental_restaurant_Customize_Section_Pro' );

		// Register sections.
		$continental_restaurant_manager->add_section( new Continental_Restaurant_Customize_Section_Pro( $continental_restaurant_manager,'continental_restaurant_go_pro', array(
			'priority'   => 1,
			'title'    => esc_html__( 'Continental Restaurant Pro', 'continental-restaurant' ),
			'pro_text' => esc_html__( 'Buy Pro', 'continental-restaurant' ),
			'pro_url'    => esc_url( CONTINENTAL_RESTAURANT_BUY_NOW ),
		) )	);

		// Register sections.
		$continental_restaurant_manager->add_section( new Continental_Restaurant_Customize_Section_Pro( $continental_restaurant_manager,'continental_restaurant_lite_documentation', array(
			'priority'   => 1,
			'title'    => esc_html__( 'Lite Documentation', 'continental-restaurant' ),
			'pro_text' => esc_html__( 'Instruction', 'continental-restaurant' ),
			'pro_url'    => esc_url( CONTINENTAL_RESTAURANT_LITE_DOC ),
		) )	);

		$continental_restaurant_manager->add_section( new Continental_Restaurant_Customize_Section_Pro( $continental_restaurant_manager, 'continental_restaurant_live_demo', array(
		    'priority'   => 1,
		    'title'      => esc_html__( 'Pro Theme Demo', 'continental-restaurant' ),
		    'pro_text'   => esc_html__( 'Live Preview', 'continental-restaurant' ),
		    'pro_url'    => esc_url( CONTINENTAL_RESTAURANT_LIVE_DEMO ),
		) ) );	
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'continental-restaurant-customize-controls', trailingslashit( get_template_directory_uri() ) . '/revolution/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'continental-restaurant-customize-controls', trailingslashit( get_template_directory_uri() ) . '/revolution/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Continental_Restaurant_Customize::get_instance();