<?php
/* Template Name: VCM-Publications-ContactPage */
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

   


    <section class="page-heading pb-0">
        <div class="container text-center">
            <h1><?php echo get_field('contact_us_title') ?></h1>
            <p><?php echo get_field('contact_us_subtitle') ?></p>
            <span class="page-heading__underline"></span>
        </div>
    </section>



    <section class="contact-form">
        <div class="container">
            
                <div class="row">


            <?php while ( have_posts() ) :
			the_post(); ?>    
            
                <?php the_content(); ?>

            <?php endwhile; ?>
                        <?php $form = get_field('contact_us_form') ?>
                        
                        <?php if(!empty(get_field('contact_us_form'))){
                            echo do_shortcode($form);
                        } ?>


                        <div class="col-sm-12 text-center mb-5">
                        
                            <p>
                            <?php if( get_theme_mod( 'ah_address_1_handle' ) ){ ?><?php echo get_theme_mod( 'ah_address_1_handle' ) ?>, <?php } ?> 
                            <?php if( get_theme_mod( 'ah_address_2_handle' ) ){ ?><?php echo get_theme_mod( 'ah_address_2_handle' ) ?>, <?php } ?>
                            <?php if( get_theme_mod( 'ah_address_3_handle' ) ){ ?><?php echo get_theme_mod( 'ah_address_3_handle' ) ?>, <?php } ?>
                            <?php if( get_theme_mod( 'ah_address_4_handle' ) ){ ?><?php echo get_theme_mod( 'ah_address_4_handle' ) ?>, <?php } ?>
                            <?php if( get_theme_mod( 'ah_address_5_handle' ) ){ ?><?php echo get_theme_mod( 'ah_address_5_handle' ) ?> <?php } ?>
                            </p>
                            <?php 
                                $telephone = get_theme_mod( 'ah_telephone_handle' );
                                $telephone_link = str_replace(' ', '', $telephone);
                            ?>
                            <p><?php if( get_theme_mod( 'ah_telephone_handle' ) ){?> Telephone: <a href="tel:<?php echo $telephone_link; ?>"><?php echo get_theme_mod( 'ah_telephone_handle' ) ?></a> <?php } ?> | <?php if( get_theme_mod( 'ah_email_handle' ) ){ ?>Email: <a href="mailto:<?php echo get_theme_mod( 'ah_email_handle' ); ?>"><?php echo get_theme_mod( 'ah_email_handle' ); ?></a><?php } ?></p>

                            
                            
                        </div>
            
                </div>
      
        </div>
    </section>
    
    
    <section class="map">
        <div class="container">
        <?php $display_map = get_field('display_map'); ?>
        <?php $map_width =  get_field('map_width'); ?>
        <?php $map_height = get_field('map_height'); ?>
        <?php if($display_map == 'yes'){ ?>
            <iframe class="map__vcm-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2483.0820150306386!2d-0.09646014823173277!3d51.51171131810824!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487604aa7f1d08af%3A0x7db1d6ad4fb847e6!2s71%20Queen%20Victoria%20St%2C%20London%20EC4V%204AY!5e0!3m2!1sen!2suk!4v1614881540294!5m2!1sen!2suk" width="<?php echo $map_width; ?>" height="<?php echo $map_height; ?>" style="border:0;" allowfullscreen="" loading="lazy"></iframe>       
        <?php } ?>                 
        </div>
    </section>


<!-- Popular Products -->        
<?php include(locate_template ('./includes/popular-products.php')); ?> 
<!-- End Popular Products -->



<?php

get_footer();
