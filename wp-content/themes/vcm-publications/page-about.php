<?php
/* Template Name: VCM-Publications-AboutPage */
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package VCM_Publications
 */

get_header();
?>

<!-- Small Carousel -->        
<?php include(locate_template ('./includes/small-carousel.php')); ?> 
<!-- End Small Carousel -->



<!-- Free Shipping -->        
<?php include(locate_template ('./includes/free-shipping.php')); ?> 
<!-- End Free Shipping -->


    <section class="breadcrumbs">
        <div class="container">
            <nav class="woocommerce-breadcrumbs">
                <?php the_breadcrumb(); ?>  
            </nav>
            <hr>
        </div>
    </section>

    <section class="page-heading pb-4">
        <div class="container text-center">
            <h1><?php echo get_field('about_title') ?></h1>
            <span class="page-heading__underline"></span>
        </div>
    </section>



    <section class="about-content">
        <div class="container">
   
                <div class="row">
            
                        <div class="col-lg-6 col-md-12">
                            <p><?php echo get_field('about_content_left') ?></p>  
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <p><?php echo get_field('about_content_right') ?></p>     
                        </div>
            
                </div>
  
        </div>
    </section>


<!-- Popular Products -->        
<?php include(locate_template ('./includes/popular-products.php')); ?> 
<!-- End Popular Products -->



		<?php
		while ( have_posts() ) :
			the_post();
        ?>    
            
   
        <?php    
		endwhile; // End of the loop.
		?>



<?php

get_footer();