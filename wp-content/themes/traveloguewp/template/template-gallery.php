<?php 
/**
 * The Template for displaying Gallery items.
 * Template Name: Gallery
 *
 * @package travelogue
 */
get_header(); ?>
		
<?php while ( have_posts() ) : the_post(); ?>

	<?php get_template_part( 'content', 'gallerypage' ); ?>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
