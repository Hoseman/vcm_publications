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

<body id="top" <?php body_class(); ?>>
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
  
            <div class="header__email-tel">
                <?php if( get_theme_mod( 'ah_email_handle' ) ){ ?><a href="mailto:<?php echo get_theme_mod( 'ah_email_handle' ); ?>"><i class="far fa-envelope-open"></i> <span class="header__email-text">EMAIL</span></a><?php } ?>
                <?php 
                    $telephone = get_theme_mod( 'ah_telephone_handle' );
                    $telephone_link = str_replace(' ', '', $telephone);
                ?>
                <?php if( get_theme_mod( 'ah_telephone_handle' ) ){ ?> <a href="tel:<?php echo $telephone_link; ?>"><i class="fas fa-phone-volume"></i> <span class="header__email-text"><?php echo get_theme_mod( 'ah_telephone_handle' ); ?></span></a> <?php } ?>
                
            </div>
        </div>
        <hr>
        <div class="header__logocontainer">
            <?php echo the_custom_logo(); ?>
            <!-- <a href="<?php //echo home_url(); ?>"><img src="<?php //bloginfo('stylesheet_directory'); ?>/images/logo.png" class="header__logo" alt="VCM Publications"></a> -->
            <div class="header__search-wrapper text-right">

			<?php echo do_shortcode('[yith_woocommerce_ajax_search]');?>


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