<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package VCM_Publications
 */

?>

<div id="myCarousel" class="carousel-small slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                    <img src="<?php bloginfo('stylesheet_directory'); ?>/images/carousel-generic.jpg" alt="Nothing Found" class="carousel-item__image">
                    <div class="container">
                        <div class="carousel-caption text-center">
                            <h1>NOTHING FOUND!</h1>
                        </div>
                    </div>
            </div>
        </div>
</div>

<!-- Free Shipping -->        
<?php include(locate_template ('./includes/free-shipping.php')); ?> 
<!-- End Free Shipping -->


<section class="breadcrumbs">
	<div class="container">
		<nav class="woocommerce-breadcrumbs">
		<a href="<?php echo home_url(); ?>">Home</a>/<a>Nothing Found</a>
		</nav>
		<hr>
	</div>
</section>


<section>
	<div class="container">

	<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'vcm-publications' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<h3 class="text-center nothing-found-heading"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'vcm-publications' ); ?></h3>
			<span class="welcome__heading-underline"></span>
			<?php
			get_search_form();

		else :
			?>

			<h3 class="text-center nothing-found-heading"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'vcm-publications' ); ?></h3>
			<span class="welcome__heading-underline"></span>
			<?php
			get_search_form();

		endif;
		?>

	</div>
</section>