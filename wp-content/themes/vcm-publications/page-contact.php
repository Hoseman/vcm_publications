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


<div id="myCarousel" class="carousel-small slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                    <img src="<?php bloginfo('stylesheet_directory'); ?>/images/carousel-contact.jpg" alt="xx" class="carousel-item__image">
                    <div class="container">
                        <div class="carousel-caption text-center">
                            <h1>CONTACT US..</h1>
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
                <a href="#">Home</a>/<a>Contact US</a>
            </nav>
            <hr>
        </div>
    </section>

   


    <section class="page-heading">
        <div class="container text-center">
            <h1>Got a question? Why not get in touch!</h1>
            <p>Fill in the form below and we will get back to you within 24 hours. Alternatively, why not give us a call?</p>
            <span class="page-heading__underline"></span>
        </div>
    </section>



    <section class="contact-form">
        <div class="container">
            <form class="contact-form__form">
                <div class="row">

                        <?php echo do_shortcode('[contact-form-7 id="143" title="Contact form 1"]'); ?>
            
                        <!-- <div class="col-sm-6">
                            <input class="form-control contact-form__formcontrol" type="text" placeholder="Add your first name">
                            <input class="form-control contact-form__formcontrol" type="text" placeholder="Add your last name">
                            <input class="form-control contact-form__formcontrol" type="text" placeholder="Add your company name">
                            <input class="form-control contact-form__formcontrol" type="text" placeholder="Add your email address">
                            <input class="form-control contact-form__formcontrol" type="text" placeholder="Add your telephone number">
                        </div>

                        <div class="col-sm-6">
                            <textarea class="form-control">Add your message here</textarea>
                        </div> -->

                        <!-- <div class="col-sm-12 text-center">
                            <input type="submit" class="submit" value="submit">
                            <p>VCM Publications, London music Press, 71 Queen Victoria Street, London EC4V 4AY</p>
                            <p>Telephone: <a href="tel:01143032424">0114 3032424</a> | Email: <a href="mailto:vcmpublications@webchambers.co.uk">vcmpublications@webchambers.co.uk</a></p>
                        </div> -->
            
                </div>
            </form>
        </div>
    </section>
    
    
    <section class="map">
        <div class="container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2483.0820150306386!2d-0.09646014823173277!3d51.51171131810824!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487604aa7f1d08af%3A0x7db1d6ad4fb847e6!2s71%20Queen%20Victoria%20St%2C%20London%20EC4V%204AY!5e0!3m2!1sen!2suk!4v1614881540294!5m2!1sen!2suk" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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
