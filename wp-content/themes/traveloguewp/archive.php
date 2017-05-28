<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package travelogue
 */

get_header(); 

// search only posts
global $wp_query;
$args = array_merge( $wp_query->query, array( 'post_type' => 'post' ) );
query_posts( $args ); 
?>

<article class="content">
    <div class="">
        <div class="grid">

			<?php if ( have_posts() ) : ?>

			<?php // Start the Loop.
					while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

					endwhile;

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
			?>

        </div>
    </div>
</article>

<?php get_footer(); ?>