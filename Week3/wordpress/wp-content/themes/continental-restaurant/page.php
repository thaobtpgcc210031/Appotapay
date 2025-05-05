<?php
/**
 * The template for displaying all pages
 *
 * @package Continental Restaurant
 */

get_header();
?>

<div class="container">
	<?php
	$continental_restaurant_page_layout = get_theme_mod( 'continental_restaurant_page_layout', 'layout-1' );

	if ( $continental_restaurant_page_layout == 'layout-1' ) {
		?>
	<div class="site-wrapper">
		<main id="primary" class="site-main lay-width">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'revolution/template-parts/content', 'page' );

				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
		</main>
		<?php if ( is_active_sidebar( 'sidebar-1' )) { ?>
		<aside id="secondary" class="widget-area sidebar-width">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</aside>
		<?php } else { ?>
			<aside id="secondary" class="widget-area sidebar-width">
				<div class="default-sidebar">
					<aside id="search-3" class="widget widget_search">
			            <h2 class="widget-title"><?php esc_html_e('Search', 'continental-restaurant'); ?></h2>
			            <?php get_search_form(); ?>
			        </aside>
			        <aside id="categories-2" class="widget widget_categories">
			            <h2 class="widget-title"><?php esc_html_e('Categories', 'continental-restaurant'); ?></h2>
			            <ul>
			                <?php
								wp_list_categories(array(
									'title_li' => '',
								));
			                ?>
			            </ul>
			        </aside>
			        <aside id="pages-2" class="widget widget_pages">
			            <h2 class="widget-title"><?php esc_html_e('Pages', 'continental-restaurant'); ?></h2>
			            <ul>
			                <?php
								wp_list_pages(array(
									'title_li' => '',
								));
			                ?>
			            </ul>
			        </aside>
			        <aside id="archives-2" class="widget widget_archive">
			            <h2 class="widget-title"><?php esc_html_e('Archives', 'continental-restaurant'); ?></h2>
			            <ul>
							<?php
								wp_get_archives(array(
									'type' => 'postbypost',
									'format' => 'html',
									'before' => '<li>',
									'after' => '</li>',
								));
							?>
			        </ul>
			       </aside>
			   </div>
			</aside>
	<?php } ?>
	</div>
	<?php
	} elseif ( $continental_restaurant_page_layout == 'layout-2' ) {
		?>
	<div class="site-wrapper">
		<?php if ( is_active_sidebar( 'sidebar-1' )) { ?>
		<aside id="secondary" class="widget-area sidebar-width">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</aside>
		<?php } else { ?>
			<aside id="secondary" class="widget-area sidebar-width">
				<div class="default-sidebar">
					<aside id="search-3" class="widget widget_search">
			            <h2 class="widget-title"><?php esc_html_e('Search', 'continental-restaurant'); ?></h2>
			            <?php get_search_form(); ?>
			        </aside>
			        <aside id="categories-2" class="widget widget_categories">
			            <h2 class="widget-title"><?php esc_html_e('Categories', 'continental-restaurant'); ?></h2>
			            <ul>
			                <?php
								wp_list_categories(array(
									'title_li' => '',
								));
			                ?>
			            </ul>
			        </aside>
			        <aside id="pages-2" class="widget widget_pages">
			            <h2 class="widget-title"><?php esc_html_e('Pages', 'continental-restaurant'); ?></h2>
			            <ul>
			                <?php
			                	wp_list_pages(array(
									'title_li' => '',
								));
			                ?>
			            </ul>
			        </aside>
			        <aside id="archives-2" class="widget widget_archive">
			            <h2 class="widget-title"><?php esc_html_e('Archives', 'continental-restaurant'); ?></h2>
			            <ul>
							<?php
								wp_get_archives(array(
									'type' => 'postbypost',
									'format' => 'html',
								));
							?>
			        	</ul>
			       </aside>
			   </div>
			</aside>
	<?php } ?>
		<main id="primary" class="site-main lay-width">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'revolution/template-parts/content', 'page' );

				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
		</main>
	</div>
	<?php 
	} elseif ( $continental_restaurant_page_layout == 'layout-3' ) { // No-sidebar layout ?>
		<div class="site-wrapper full-width">
			<main id="primary" class="site-main lay-width">
				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'revolution/template-parts/content', 'page' );

					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>
			</main>
		</div>
	<?php } ?>
</div>

<?php
get_footer();
				