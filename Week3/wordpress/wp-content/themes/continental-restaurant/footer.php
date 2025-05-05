<?php
/**
 * The template for displaying the footer
 *
 * @package Continental Restaurant
 */

?>

<?php 
  $continental_restaurant_main_slider_wrap = absint(get_theme_mod('continental_restaurant_enable_footer', 1));
  if($continental_restaurant_main_slider_wrap == 1){ 
  ?>
   
<footer id="colophon" class="site-footer">
    <?php 
        if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) {
    ?>
        <section class="footer-top">
            <div class="container">
                <div class="flex-row">
                    <?php
                        if (is_active_sidebar('footer-1')) {
                    ?>
                            <div class="footer-col">
                                <?php dynamic_sidebar('footer-1'); ?>
                            </div>
                    <?php
                        }
                        if (is_active_sidebar('footer-2')) {
                    ?>  
                            <div class="footer-col">
                                <?php dynamic_sidebar('footer-2'); ?>
                            </div>
                    <?php
                        }
                        if (is_active_sidebar('footer-3')) {
                    ?>
                            <div class="footer-col">
                                <?php dynamic_sidebar('footer-3'); ?>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </section>
    <?php
        } else { ?>
            <section class="footer-top default_footer_widgets">
                <div class="container">
                    <div class="flex-row">
						<aside id="search-2" class="widget widget_search default_footer_search">
                            <h2 class="widget-title"><?php esc_html_e('Search', 'continental-restaurant'); ?></h2>
                            <?php get_search_form(); ?>
                        </aside>
                        <aside id="categories-2" class="widget widget_categories">
							<h2 class="widget-title"><?php esc_html_e('Tags', 'continental-restaurant'); ?></h2>
							<div class="tagcloud">
								<?php
								$tags = get_tags();
								if ($tags) {
									wp_tag_cloud(array(
										'smallest' => 8,
										'largest'  => 22,
										'unit'     => 'px',
										'number'   => 20,
										'orderby'  => 'count',
										'order'    => 'DESC',
									));
								} else {
									echo '<p>' . esc_html__('No tags available. Add some tags to display here.', 'continental-restaurant') . '</p>';
								}
								?>
							</div>
						</aside>
				         <aside id="archives-2" class="widget widget_archive">
				            <h2 class="widget-title"><?php esc_html_e('Archives', 'continental-restaurant'); ?></h2>
				            <?php get_calendar(); ?>
				       </aside>
                    </div>
                </div>
            </section>
    <?php } ?>

		<div class="footer-bottom">
			<div class="container">
				<?php 
				$continental_restaurant_footer_social = absint(get_theme_mod('continental_restaurant_footer_social_menu', 1));
				if($continental_restaurant_footer_social == 1){ 
				?>
				<div class="social-links">
					<?php
						continental_restaurant_social_menu();
					?>
				</div>
				<?php 
				} 
				?>
				<div class="site-info">
					<div>
					<?php
			            if (!get_theme_mod('continental_restaurant_copyright_option') ) { ?>
			            	<a href="<?php echo esc_url('https://www.revolutionwp.com/products/free-restaurant-wordpress-theme'); ?>" target="_blank">
			              <?php esc_html_e('Continental Restaurant WordPress Theme By Revolution WP','continental-restaurant'); ?></a>
			            <?php } else {
			              echo esc_html(get_theme_mod('continental_restaurant_copyright_option'));
			            }
			          ?>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<?php } ?>
</div>

<?php 
	$continental_restaurant_footer_go_to_top = absint(get_theme_mod('continental_restaurant_enable_go_to_top_option', 1));
	if($continental_restaurant_footer_go_to_top == 1){ 
		?>
		<a href="javascript:void(0);" class="footer-go-to-top go-to-top"><i class="fas fa-chevron-up"></i></a>
<?php } ?>

<?php wp_footer(); ?>

</body>
</html>