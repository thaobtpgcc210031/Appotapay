<?php
/**
 * The template for displaying archive pages
 *
 * @package Continental Restaurant
 */

get_header();
?>

<?php $continental_restaurant_archive_layout = get_theme_mod( 'continental_restaurant_archive_layout', 'layout-1' ); ?> 

<div class="container">
	<?php
	if ( $continental_restaurant_archive_layout == 'layout-1' ) {
		?>
	<div class="main-wrapper">
		<main id="primary" class="site-main ct-post-wrapper lay-width">

			<?php if ( have_posts() ) : ?>

				<?php continental_restaurant_breadcrumbs(); ?>

				<header class="page-header">
					<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header>

				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'revolution/template-parts/content', get_post_format() );

				endwhile;

				the_posts_navigation();

			else :

				get_template_part( 'revolution/template-parts/content', 'none' );

			endif;
			?>
		</main>
		<?php get_sidebar(); ?>
	</div>
	<?php
	} elseif ( $continental_restaurant_archive_layout == 'layout-2' ) {
		?>
	<div class="main-wrapper">
		<?php get_sidebar(); ?>
		<main id="primary" class="site-main ct-post-wrapper lay-width">

			<?php if ( have_posts() ) : ?>

				<?php continental_restaurant_breadcrumbs(); ?>

				<header class="page-header">
					<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header>

				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'revolution/template-parts/content', get_post_format() );

				endwhile;

				the_posts_navigation();

			else :

				get_template_part( 'revolution/template-parts/content', 'none' );

			endif;
			?>
		</main>
	</div>
	<?php 
	} elseif ( $continental_restaurant_archive_layout == 'layout-3' ) { // No-sidebar layout
	?>
	<div class="main-wrapper full-width">
		<main id="primary" class="site-main ct-post-wrapper lay-width">

			<?php if ( have_posts() ) : ?>

				<?php continental_restaurant_breadcrumbs(); ?>

				<header class="page-header">
					<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header>

				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'revolution/template-parts/content', get_post_format() );

				endwhile;

				the_posts_navigation();

			else :

				get_template_part( 'revolution/template-parts/content', 'none' );

			endif;
			?>
		</main>
	</div>
	<?php } ?>
</div>

<?php
get_footer();
