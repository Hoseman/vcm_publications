<?php
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

<section class="free-shipping shipping-v2">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 display-flex free-shipping__column">
                        <i class="fas fa-shipping-fast"></i>
                        <span class="free-shipping__container">
                        <h5>FREE SHIPPING</h5>
                        <p>All our products include FREE delivery</p>
                    </span>
                </div>
                <div class="col-sm-4 display-flex free-shipping__column">
                        <i class="far fa-handshake"></i>
                        <span class="free-shipping__container">
                        <h5>MONEY BACK GUARANTEE</h5>
                        <p>Our goal is 100% customer satisfaction</p>
                        </span>
                </div>
                <div class="col-sm-4 display-flex free-shipping__column">
                        <i class="far fa-gem"></i>
                        <span class="free-shipping__container">
                        <h5>QUALITY OF SERVICE</h5>
                        <p>We stand by the quality of the products we sell</p>
                        </span>
                </div>
            </div>
        </div>
</section>


<section class="breadcrumbs">
	<div class="container">
		<nav class="woocommerce-breadcrumbs">
			<?php the_breadcrumb(); ?>
		</nav>
		<hr>
	</div>
</section>







<?php
while ( have_posts() ) :
	the_post();
?>	

<section class="page-heading pb-4">
	<div class="container text-center">
		<h1><?php the_title(); ?></h1>
		<span class="page-heading__underline"></span>
	</div>
</section>			



<section class="content">
	<div class="container">				

			<?php	
				the_content();


			endwhile; 
			?>

	</div>
</section>


<?php
//get_sidebar();
get_footer();
