<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package VCM_Publications
 */

get_header();
?>

<?php if ( have_posts() ) : ?>

<div id="myCarousel" class="carousel-small slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                    <img src="<?php bloginfo('stylesheet_directory'); ?>/images/carousel-generic.jpg" alt="Search" class="carousel-item__image">
                    <div class="container">
                        <div class="carousel-caption text-center">
                            <h1><?php printf( esc_html__( 'Search Results for: %s', 'vcm-publications' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
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
			
                <a href="<?php echo home_url(); ?>">Home</a>/<a> Search Results for: <?php echo get_search_query() ?></a>
            </nav>
            <hr>
        </div>
    </section>






	<section class="search-results-content">
	<div class="container">
		<div class="row">



		
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );
					?>	

					<?php
					endwhile;

					//the_posts_navigation();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</div>		
		</div>
	</section>	

	<div class="clear:both;"></div>

<?php

get_footer();
