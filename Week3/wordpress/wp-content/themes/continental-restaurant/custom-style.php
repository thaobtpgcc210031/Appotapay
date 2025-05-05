<?php 
	$continental_restaurant_custom_css ='';

    /*----------------Related Product show/hide -------------------*/

    $continental_restaurant_enable_related_product = get_theme_mod('continental_restaurant_enable_related_product',1);

    if($continental_restaurant_enable_related_product == 0){
        $continental_restaurant_custom_css .='.related.products{';
            $continental_restaurant_custom_css .='display: none;';
        $continental_restaurant_custom_css .='}';
    }

    /*----------------blog post content alignment -------------------*/

    $continental_restaurant_blog_Post_content_layout = get_theme_mod( 'continental_restaurant_blog_Post_content_layout','Left');
    if($continental_restaurant_blog_Post_content_layout == 'Left'){
        $continental_restaurant_custom_css .='.ct-post-wrapper .card-item {';
            $continental_restaurant_custom_css .='text-align:start;';
        $continental_restaurant_custom_css .='}';
    }else if($continental_restaurant_blog_Post_content_layout == 'Center'){
        $continental_restaurant_custom_css .='.ct-post-wrapper .card-item {';
            $continental_restaurant_custom_css .='text-align:center;';
        $continental_restaurant_custom_css .='}';
    }else if($continental_restaurant_blog_Post_content_layout == 'Right'){
        $continental_restaurant_custom_css .='.ct-post-wrapper .card-item {';
            $continental_restaurant_custom_css .='text-align:end;';
        $continental_restaurant_custom_css .='}';
    }

    /*--------------------------- Footer background image -------------------*/

    $continental_restaurant_footer_bg_image = get_theme_mod('continental_restaurant_footer_bg_image');
    if($continental_restaurant_footer_bg_image != false){
        $continental_restaurant_custom_css .='.footer-top{';
            $continental_restaurant_custom_css .='background: url('.esc_attr($continental_restaurant_footer_bg_image).');';
        $continental_restaurant_custom_css .='}';
    }

    /*--------------------------- Go to top positions -------------------*/

    $continental_restaurant_go_to_top_position = get_theme_mod( 'continental_restaurant_go_to_top_position','Right');
    if($continental_restaurant_go_to_top_position == 'Right'){
        $continental_restaurant_custom_css .='.footer-go-to-top{';
            $continental_restaurant_custom_css .='right: 20px;';
        $continental_restaurant_custom_css .='}';
    }else if($continental_restaurant_go_to_top_position == 'Left'){
        $continental_restaurant_custom_css .='.footer-go-to-top{';
            $continental_restaurant_custom_css .='left: 20px;';
        $continental_restaurant_custom_css .='}';
    }else if($continental_restaurant_go_to_top_position == 'Center'){
        $continental_restaurant_custom_css .='.footer-go-to-top{';
            $continental_restaurant_custom_css .='right: 50%;left: 50%;';
        $continental_restaurant_custom_css .='}';
    }

    /*--------------------------- Woocommerce Product Sale Positions -------------------*/

    $continental_restaurant_product_sale = get_theme_mod( 'continental_restaurant_woocommerce_product_sale','Right');
    if($continental_restaurant_product_sale == 'Right'){
        $continental_restaurant_custom_css .='.woocommerce ul.products li.product .onsale{';
            $continental_restaurant_custom_css .='left: auto; ';
        $continental_restaurant_custom_css .='}';
    }else if($continental_restaurant_product_sale == 'Left'){
        $continental_restaurant_custom_css .='.woocommerce ul.products li.product .onsale{';
            $continental_restaurant_custom_css .='right: auto;left:0;';
        $continental_restaurant_custom_css .='}';
    }else if($continental_restaurant_product_sale == 'Center'){
        $continental_restaurant_custom_css .='.woocommerce ul.products li.product .onsale{';
            $continental_restaurant_custom_css .='right: 50%; left: 50%; ';
        $continental_restaurant_custom_css .='}';
    }

    /*-------------------- Primary Color -------------------*/

	$continental_restaurant_primary_color = get_theme_mod('continental_restaurant_primary_color', '#9F2C75'); // Add a fallback if the color isn't set

	if ($continental_restaurant_primary_color) {
		$continental_restaurant_custom_css .= ':root {';
		$continental_restaurant_custom_css .= '--primary-color: ' . esc_attr($continental_restaurant_primary_color) . ';';
		$continental_restaurant_custom_css .= '}';
	}	

    /*-------------------- Secondary Color -------------------*/

	$continental_restaurant_secondary_color = get_theme_mod('continental_restaurant_secondary_color', '#000'); // Add a fallback if the color isn't set

	if ($continental_restaurant_secondary_color) {
		$continental_restaurant_custom_css .= ':root {';
		$continental_restaurant_custom_css .= '--secondary-color: ' . esc_attr($continental_restaurant_secondary_color) . ';';
		$continental_restaurant_custom_css .= '}';
	}	

    /*-------------------- Tertiary Color -------------------*/

	$continental_restaurant_tertiary_color = get_theme_mod('continental_restaurant_tertiary_color', '#EC9C34'); // Add a fallback if the color isn't set

	if ($continental_restaurant_tertiary_color) {
		$continental_restaurant_custom_css .= ':root {';
		$continental_restaurant_custom_css .= '--tertiary-color: ' . esc_attr($continental_restaurant_tertiary_color) . ';';
		$continental_restaurant_custom_css .= '}';
	}	