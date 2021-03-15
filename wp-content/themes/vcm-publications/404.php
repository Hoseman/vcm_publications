<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package VCM_Publications
 */

get_header();
?>


<div id="myCarousel" class="carousel-small slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                    <img src="<?php bloginfo('stylesheet_directory'); ?>/images/carousel-generic.jpg" alt="xx" class="carousel-item__image">
                    <div class="container">
                        <div class="carousel-caption text-center">
                            <h1>404 PAGE NOT FOUND</h1>
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
                <a href="<?php echo home_url(); ?>">Home</a>/<a>404</a>
            </nav>
            <hr>
        </div>
    </section>

    <section class="welcome pt-5 pb-1">
        <div class="container">
			<h1><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'vcm-publications' ); ?></h1>
            <span class="welcome__heading-underline"></span>
        </div>
    </section>

	<section>
	<div class="container">

		<p class="text-center"><?php esc_html_e( 'It looks like nothing was found at this location.. Maybe try one of the links below or a search?', 'vcm-publications' ); ?></p>

		<?php get_search_form(); ?>

	</div>
	</section>




<?php
get_footer();
