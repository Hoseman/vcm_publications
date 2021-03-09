<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package VCM_Publications
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="googlebot" content="noindex">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    
    <link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/ico/favicon.ico">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>



<header class="header">
        <div class="header__top-menu-container">
         

                <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'top-mini-menu',
                            'menu_id'        => 'secondary-menu',
                            'menu_class'=> 'header__top-menu',
                        )
                    );
                ?>
                <!-- <a href="contact-page.html">CONTACT US</a>
                <a href="#">CHECKOUT</a>
                <a href="#">VIEW ACCOUNT</a> -->
  
            <div class="header__email-tel">
                <a href="mailto:vcmpublications@webchambers.co.uk"><i class="far fa-envelope-open"></i> <span class="header__email-text">E-MAIL</span></a>
                <a href="tel:01143032424"><i class="fas fa-phone-volume"></i> <span class="header__email-text">0114 3032424</span></a>
            </div>
        </div>
        <hr>
        <div class="header__logocontainer">
            <a href="<?php echo home_url(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" class="header__logo" alt="VCM Publications"></a>
            <div class="header__search-wrapper">
            <!-- <button type="submit"><i class="fa fa-search"></i></button> -->

            <!-- <input class="header__search" type="text" name="search" placeholder="Search..."> -->
			<?php echo do_shortcode('[yith_woocommerce_ajax_search]');?>

                <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"> -->
                    <!-- <span class="navbar-toggler-icon"></span> -->
                    <!-- <a class="hamburger hamburger--elastic">
                        <div class="hamburger-box">
                          <div class="hamburger-inner"></div>
                        </div>
                    </a>
                </button> -->
            </div>
        </div>

    </header>





			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>