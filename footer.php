    <footer class="footer">

        <div class="container">

            <div class="footer-menu">

                <div>
                    <h3>Sitemap</h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container' => false,
                        'items_wrap' => '<ul>%3$s</ul>'
                    ));
                    ?> 
                </div>
                
                <div>
                    <h3>Policies</h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'policies',
                        'container' => false,
                        'items_wrap' => '<ul>%3$s</ul>'
                    ));
                    ?> 
                </div>

                <div>
                    <h3>Socials</h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'socials',
                        'container' => false,
                        'items_wrap' => '<ul>%3$s</ul>'
                    ));
                    ?> 
                </div>

                <div>
                    <h3>Language</h3>
                    <div class="language"></div>
                </div>
            </div>

            <div class="footer-company">
                
                <div class="info">
                    © <?php echo date('Y'); ?> <?php bloginfo('title'); ?> <span class="divider"></span> <span class="date"></span> 
                </div>  

                <div class="payments">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/payments/amex.svg" alt="">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/payments/applepay.svg" alt="">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/payments/googlepay.svg" alt="">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/payments/maestro.svg" alt="">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/payments/mastercard.svg" alt="">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/payments/paypal.svg" alt="">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/payments/visa.svg" alt="">
                </div>
            </div>   

        </div>
    
    </footer>

    <?php wp_footer(); ?>

</body>
</html>
