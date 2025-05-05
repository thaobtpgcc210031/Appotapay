<?php
/**
 * The template for displaying all single posts
 *
 * @package Continental Restaurant
 */

get_header();
?>

<div class="container">
	<?php
	$continental_restaurant_post_layout = get_theme_mod( 'continental_restaurant_post_layout', 'layout-1' );

	if ( $continental_restaurant_post_layout == 'layout-1' ) {
		?>
	<div class="main-wrapper">
		<main id="primary" class="site-main lay-width">
		
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'revolution/template-parts/content', get_post_format() );

				the_post_navigation(
					array(
						'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'continental-restaurant' ) . '</span> <span class="nav-title">%title</span>',
						'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'continental-restaurant' ) . '</span> <span class="nav-title">%title</span>',
					)
				);
				?>

				<?php 
				do_action('continental_restaurant_related_posts');
				?>
				
				<?php
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile;
			?>
		</main>

		<?php get_sidebar(); ?>
	</div>

	<?php
	} elseif ( $continental_restaurant_post_layout == 'layout-2' ) {
		?>
	<div class="main-wrapper">
		<?php get_sidebar(); ?>

		<main id="primary" class="site-main lay-width">
		
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'revolution/template-parts/content', get_post_format() );

				the_post_navigation(
					array(
						'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'continental-restaurant' ) . '</span> <span class="nav-title">%title</span>',
						'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'continental-restaurant' ) . '</span> <span class="nav-title">%title</span>',
					)
				);
				?>

				<?php 
				do_action('continental_restaurant_related_posts');
				?>
				
				<?php
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile;
			?>
		</main>
	</div>
	<?php 
	} elseif ( $continental_restaurant_post_layout == 'layout-3' ) { // No-sidebar layout
	?>
	<div class="main-wrapper full-width">
		<main id="primary" class="site-main lay-width">
		
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'revolution/template-parts/content', get_post_format() );

				the_post_navigation(
					array(
						'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'continental-restaurant' ) . '</span> <span class="nav-title">%title</span>',
						'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'continental-restaurant' ) . '</span> <span class="nav-title">%title</span>',
					)
				);
				?>

				<?php 
				do_action('continental_restaurant_related_posts');
				?>
				
				<?php
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile;
			?>
		</main>
	</div>
	<?php } ?>
</div>

<?php get_footer(); ?>