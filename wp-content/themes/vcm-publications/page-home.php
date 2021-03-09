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


<div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            
            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/carousel-1.jpg" alt="xx" class="carousel-item__image">
    
            <div class="container">
              <div class="carousel-caption text-center">
                <h1>EXAM SHEETS</h1>
                <p>Large selection of Victoria College exam sheets available to order</p>
                <p><a class="btn btn-vcm" href="/product-category/default-category/exam-sheets/">SHOP NOW</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            
            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/carousel-2.jpg" alt="xx" class="carousel-item__image">

            <div class="container">
              <div class="carousel-caption text-center">
                <h1>TUTOR BOOKS</h1>
                <p>All of our books are carefully designed to support individual learning needs</p>
                <p><a class="btn btn-vcm" href="/product-category/default-category/tutor-books/">SHOP NOW</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">

            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/carousel-3.jpg" alt="xx" class="carousel-item__image">

            <div class="container">
              <div class="carousel-caption text-center">
                <h1>SYLLABUSES</h1>
                <p>Browse our large selection of Victoria College syllabuses</p>
                <p><a class="btn btn-vcm" href="/product-category/default-category/syllabuses/">SHOP NOW</a></p>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true">
            <i class="fas fa-chevron-left"></i>
          </span>
          <!-- <span class="sr-only">Previous</span> -->
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true">
            <i class="fas fa-chevron-right"></i>
          </span>
          <!-- <span class="sr-only">Next</span> -->
        </a>
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


    <section class="welcome">
        <h1>Welcome To VCM Publications</h1>
        <span class="welcome__heading-underline"></span>
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-md-12">
                  <p>VCM Publications are partners with Victoria College Examinations. We provide an inexpensive method for candidates to obtain set pieces for examinations at economical prices. We are proud to offer the highest quality, most unique merchandise on the market today. From our family to yours, we put lots of love and careful attention into each item. We hope you enjoy our work as much as we enjoy bringing it to you.</p>
                </div> 
                <div class="col-lg-6 col-md-12">
                  <p>Please choose from the category links above to view the full menu where you will find exam sheets, tutor books and syllabuses for the Victoria College Examinations. Victoria College has been offering examinations, held at local centres continually since 1890.</p>
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
