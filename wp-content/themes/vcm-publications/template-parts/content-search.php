<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package VCM_Publications
 */

?>

<div class="col-sm-4">

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php vcm_publications_post_thumbnail(); ?>
	

		<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

		<span class="search-results-content__heading-underline"></span>

		<?php if ( 'post' === get_post_type() ) : ?>
		<!-- <div class="entry-meta">
			<?php
			//vcm_publications_posted_on();
			//vcm_publications_posted_by();
			?>
		</div> -->
		<?php endif; ?>


	

	<!-- <div class="entry-summary"> -->
		<?php //the_excerpt(); ?>
	<!-- </div> -->

	<!-- <footer class="entry-footer"> -->
		<?php //vcm_publications_entry_footer(); ?>
	<!-- </footer> -->
</article><!-- #post-<?php the_ID(); ?> -->

</div>
