<?php
/**
 * @package travelogue
 */
?>

<div id="main" class="site-main" role="main">
	<!-- Article content -->
	<?php the_content(); ?>
</div>

<!-- Article footer -->
<div class="article-footer">
	<p>
		<?php echo __('by ', 'travelogue'); ?>
		<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="hover-effect"><strong><?php the_author(); ?></strong></a> &mdash; 
		<?php echo __('Posted on ', 'travelogue') . get_the_date() .  __(' in', 'travelogue'); ?>, 
		<span class="taxonomy_list">
		<?php
		if (get_the_category()) {
			foreach((get_the_category()) as $category) {
                $category_link = get_term_link( $category );
				echo "<a class='single_category' data-href='" . $category->cat_name . "' href='". esc_url( $category_link ) ."'>" . $category->cat_name . "</a> "; 
			}
		}
 		?>
 		</span>
 		<span class="taxonomy_list">
		<?php 
		if (get_the_tags()) {
			echo __('and tagged ', 'travelogue');
			foreach( ( get_the_tags() ) as $tag) {
                $tag_link = get_term_link( $tag );
				echo "<a class='single_tag' href='". esc_url( $tag_link ) ."' data-href='" . $tag->name . "'>" . $tag->name . "</a> "; 
			}
		}
		?>
		</span>	
	</p>

	<div class="divider"></div>

	<div class="fullwidth">
		<h3 class="black"><?php echo __('Share this article on:', 'travelogue'); ?></h3>
		<div class="float-left">
			<div class="social facebook float-left">
				<a href="http://www.facebook.com/share.php?u=<?php echo get_permalink(); ?>&amp;title=<?php echo get_the_title(); ?>">
					<i class="fa fa-facebook"></i>
				</a>
			</div>
			<div class="social twitter float-left">
				<a href="http://twitter.com/home?status=<?php echo get_the_title(); ?>+<?php echo get_permalink(); ?>">
					<i class="fa fa-twitter"></i>
				</a>
			</div>
			<div class="social googleplus float-left">
				<a href="https://plus.google.com/share?url=<?php echo get_permalink(); ?>">
					<i class="fa fa-google-plus"></i>
				</a>
			</div>
			<div class="social linkedin float-left">
				<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo get_permalink(); ?>&amp;title=<?php echo get_the_title(); ?>&amp;source=<?php echo get_permalink(); ?>">
					<i class="fa fa-linkedin"></i>
				</a>
			</div>
			<div class="social reddit float-left">
				<a href="http://www.reddit.com/submit?url=<?php echo get_permalink(); ?>&amp;title=<?php echo get_the_title(); ?>">
					<i class="fa fa-reddit"></i>
				</a>
			</div>
			<div class="social tumblr float-left">
				<a href="http://www.tumblr.com/share?v=3&amp;u=<?php echo get_permalink(); ?>&amp;t=<?php echo get_the_title(); ?>">
					<i class="fa fa-tumblr"></i>
				</a>
			</div>
		</div> 
	</div>
	<div class="clearfix"></div>
</div>