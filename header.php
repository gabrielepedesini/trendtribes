<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

    <header class="header">

        <div class="header-wrapper container">

            <a class="hamburger">
                <img src="<?php echo get_template_directory_uri(); ?>/img/menu.svg" alt="">
            </a>

            <nav class="menu">

                <div class="cross">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/cross.svg" alt="">
                </div>

                <?php
                wp_nav_menu(array(
                'theme_location' => 'header',
                'container' => false,
                'items_wrap' => '<ul>%3$s</ul>'
                ));
                ?>    

            </nav>

            <?php echo get_custom_logo(); ?>

            <div class="utilities">
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/cart.svg" alt="cart">
                    <span class="cart-item-count hidden"></span>
                </a>
            </div>

        </div>

        <div class="cover"></div>

    </header>

    <div style="height: 100px"></div>

    <?php if (is_home()) { ?>
    
        <?php
            // // Get the ID of the page set as the posts page
            // $blog_page_id = get_option('page_for_posts');

            // // Get the title of the posts page
            // $blog_page_title = get_the_title($blog_page_id);

            // // Output the title
            // if ($blog_page_title) {
            //     echo '<h1>' . $blog_page_title . '</h1>';
            // }
        ?>

    <?php } ?>

    <?php if (is_page()) { ?>
    
        <!-- <h1><?php the_title(); ?></h1> -->
    
    <?php } ?>

    <?php if(is_archive()) { ?>

        <!-- <h1><?php single_cat_title(); ?></h1> -->

    <?php } ?>