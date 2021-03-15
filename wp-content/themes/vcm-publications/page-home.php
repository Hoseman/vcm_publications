<?php
/* Template Name: VCM-Publications-HomePage */
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


<!-- Home Carousel -->        
<?php include(locate_template ('./includes/home-carousel.php')); ?> 
<!-- End Home Carousel -->







<!-- Free Shipping -->        
<?php include(locate_template ('./includes/free-shipping.php')); ?> 
<!-- End Free Shipping -->


<section class="welcome">
<h1><?php the_field('intro_title') ?></h1>

    
    <span class="welcome__heading-underline"></span>
    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-md-12">
              <p><?php echo get_field('intro_content_left') ?></p>
            </div> 
            <div class="col-lg-6 col-md-12">
              <p><?php echo get_field('intro_content_right') ?></p>
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
