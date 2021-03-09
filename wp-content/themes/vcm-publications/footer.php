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

<section class="need-some-advice">
        <h4 class="need-some-advice__heading">NEED SOME ADVICE? CALL US ON <a href="tel:01143032424">0114 303 2424</a></h4>
    </section>


    <footer class="footer">
        <div class="container footer__wrapper">
            <span class="footer__links">
                <p>COMPANY ADDRESS</p>
                <ul>
                    <li>VCM Publications</li>
                    <li>London Music Press</li>
                    <li>71 Queen Victoria Street</li>
                    <li>London</li>
                    <li>EC4V 4AY</li>
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
                <!-- <ul>
                    <li><a href="#">Returns Policy</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Shipping</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul> -->
            </span>

            <span class="footer__links">
                <p>CATEGORIES</p>
                <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer-menu-2',
                            'menu_id'        => 'footer-2',
                        )
                    );
                ?>
                <!-- <ul>
                    <li><a href="#">Piano's & Keyboard</a></li>
                    <li><a href="#">Woodwind</a></li>
                    <li><a href="#">Stringed Instruments</a></li>
                    <li><a href="#">Singing</a></li>
                    <li><a href="#">Music Theory</a></li>
                    <li><a href="#">Other</a></li>
                </ul> -->
            </span>
            <div class="scroll-to-top"><i class="fas fa-chevron-up"></i></div>
        </div>



        <div class="container"><hr></div>
        
        <div class="container footer__signoff">
            <p>Copyright Design 2021 VCM Publications</p>
            <p>Telephone: <a href="tel:01143032424">0114 303 2424</a> | Email: <a href="mailto:vcmpublications@webchambers.co.uk">vcmpublications@webchambers.co.uk</a></p>
        </div>
    </footer>



<?php wp_footer(); ?>

</body>
</html>
