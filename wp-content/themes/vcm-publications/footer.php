<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package VCM_Publications
 */

?>

<?php 
        $telephone = get_theme_mod( 'ah_telephone_handle' );
        $telephone_link = str_replace(' ', '', $telephone);
?>

<!-- Need Some Advice Panel -->
<?php include(locate_template ('./includes/need-some-advice.php')); ?> 
<!-- Need Some Advice Panel -->


    <footer class="footer">
        <div class="container footer__wrapper">
            <span class="footer__links">
                <p>COMPANY ADDRESS</p>
                <ul>
                    <?php if( get_theme_mod( 'ah_address_1_handle' ) ){ ?><li><?php echo get_theme_mod( 'ah_address_1_handle' ) ?></li><?php } ?>
                    <?php if( get_theme_mod( 'ah_address_2_handle' ) ){ ?><li><?php echo get_theme_mod( 'ah_address_2_handle' ) ?></li><?php } ?>
                    <?php if( get_theme_mod( 'ah_address_3_handle' ) ){ ?><li><?php echo get_theme_mod( 'ah_address_3_handle' ) ?></li><?php } ?>
                    <?php if( get_theme_mod( 'ah_address_4_handle' ) ){ ?><li><?php echo get_theme_mod( 'ah_address_4_handle' ) ?></li><?php } ?>
                    <?php if( get_theme_mod( 'ah_address_5_handle' ) ){ ?><li><?php echo get_theme_mod( 'ah_address_5_handle' ) ?></li><?php } ?>
                </ul>
            </span>
            <span class="footer__links">
                <p>IMPORTANT LINKS</p>
                <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer-menu-1',
                            'menu_id'        => 'footer-1',
                        )
                    );
                ?>
            </span>

            <span class="footer__links">
                <p>POPULAR CATEGORIES</p>
                <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer-menu-2',
                            'menu_id'        => 'footer-2',
                        )
                    );
                ?>
            </span>
            <a href="#top" class="scroll-to-top"><i class="fas fa-chevron-up"></i></a>
        </div>



        <div class="container"><hr></div>
        
        <div class="container footer__signoff">
            <p>Copyright Design <?php echo date("Y"); ?> VCM Publications</p>
            <p><?php if( get_theme_mod( 'ah_telephone_handle' ) ){?> Telephone: <a href="tel:<?php echo $telephone_link; ?>"><?php echo get_theme_mod( 'ah_telephone_handle' ) ?></a> <?php } ?> | <?php if( get_theme_mod( 'ah_email_handle' ) ){?> Email: <a href="mailto:<?php echo get_theme_mod( 'ah_email_handle' ) ?>"><?php echo get_theme_mod( 'ah_email_handle' ) ?></a> <?php } ?></p>
            
        </div>

        
                    

    </footer>



<?php wp_footer(); ?>

</body>
</html>
