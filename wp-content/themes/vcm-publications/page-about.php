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


<div id="myCarousel" class="carousel-small slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                    <img src="<?php bloginfo('stylesheet_directory'); ?>/images/carousel-contact.jpg" alt="xx" class="carousel-item__image">
                    <div class="container">
                        <div class="carousel-caption text-center">
                            <h1>ABOUT US</h1>
                        </div>
                    </div>
            </div>
        </div>
      </div>



    <section class="free-shipping">
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
                <a href="#">Home</a>/<a href="#">About Us</a>
            </nav>
            <hr>
        </div>
    </section>

    <section class="page-heading pb-4">
        <div class="container text-center">
            <h1>Welcome to the VCM Publications Story</h1>
            <span class="page-heading__underline"></span>
        </div>
    </section>



    <section class="content">
        <div class="container">
   
                <div class="row">
            
                        <div class="col-lg-6 col-md-12">
                            <p>We are the leading publishers of VCM Examinations exam sheets, tutor books and syllabuses. All items are delivered post free. </p>
 
                                <p>VCM Publications was incorporated and went into partnership with VCM Exams in 2012.  The aim of this partnership was to provide an extensive catalogue of printed music for students who needed examination material for the VCM Examinations.  </p>
                                 
                        </div>

                        <div class="col-lg-6 col-md-12">
                                 
                                <p>Today VCM Publications is still helping students achieve their music goals by offering exam sheets, tutor books and syllabuses.  In addition, students can now access online tuition from the tutor books by visiting <a href="www.silverwoodmusicschool.uk">www.silverwoodmusicschool.uk</a> </p>
                                 
                                <p>Thanks you for taking the time to find out about VCM Publications. </p>
                        </div>
            
                </div>
  
        </div>
    </section>


    <section class="popular-categories">
        <h1>Popular Products</h1>
        <span class="popular-categories__heading-underline"></span>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 text-center">
                    <a href="#" class="popular-categories__imgbg">
                        <img id="imgcat1" class="popular-categories__img" alt="Piano" src="<?php bloginfo('stylesheet_directory'); ?>/images/popular-categories-1.jpg">
                    </a>
                    <h5 class="popular-categories__title">PIANO</h5>
                    <span class="popular-categories__heading-underline-sml"></span>
                    <a id="cat1" class="btn popular-categories__btn-vcm" href="#">SHOP NOW</a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 text-center">
                    <a href="#" class="popular-categories__imgbg">
                    <img id="imgcat2" class="popular-categories__img" alt="Piano" src="<?php bloginfo('stylesheet_directory'); ?>/images/popular-categories-2.jpg">
                    </a>
                    <h5 class="popular-categories__title">MUSIC THEORY &amp; COMPOSITION</h5>
                    <span class="popular-categories__heading-underline-sml"></span>
                    <a id="cat2" class="btn popular-categories__btn-vcm" href="#">SHOP NOW</a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 text-center">
                    <a href="#" class="popular-categories__imgbg">
                    <img id="imgcat3" class="popular-categories__img" alt="Piano" src="<?php bloginfo('stylesheet_directory'); ?>/images/popular-categories-3.jpg">
                    </a>
                    <h5 class="popular-categories__title">ELECTRONIC KEYBOARD</h5>
                    <span class="popular-categories__heading-underline-sml"></span>
                    <a id="cat3" class="btn popular-categories__btn-vcm" href="#">SHOP NOW</a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 text-center">
                    <a href="#" class="popular-categories__imgbg">
                    <img id="imgcat4" class="popular-categories__img" alt="Piano" src="<?php bloginfo('stylesheet_directory'); ?>/images/popular-categories-4.jpg">
                    </a>
                    <h5 class="popular-categories__title">TUTOR BOOKS</h5>
                    <span class="popular-categories__heading-underline-sml"></span>
                    <a id="cat4" class="btn popular-categories__btn-vcm" href="#">SHOP NOW</a>
                </div>

            </div>
        </div>
    </section>



		<?php
		while ( have_posts() ) :
			the_post();
        ?>    
            
   
        <?php    
		endwhile; // End of the loop.
		?>



<?php
get_sidebar();
get_footer();
