<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package travelogue
 */
?>

<article <?php post_class('content-area content '); ?> id="post-<?php the_ID(); ?>">
	<div id="main" class="site-main" role="main">
		<!-- Article content -->
		<?php the_content(); ?>
	</div>
</article>
<div class="clearfix"></div>

