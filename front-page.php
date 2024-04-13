<?php get_header(); ?>

<main class="container">

    <div class="hero" style="background-image: url(' <?php echo esc_url(get_header_image()) ?> ');">
        <h1><?php echo get_theme_mod( 'hero_title' ) ?></h1>

        <?php

        // $discount_show = get_theme_mod( 'discount_show_button' );
        // $discount_date = get_theme_mod( 'discount_date' );
        

        // if ( $discount_show && empty($discount_date) ) {
        //     echo '<p class="hero-subtitle hero-counter">Sales end in <span class="display-counter"></span></p>';
        // } else if ( !$discount_show && !empty($discount_date) ) {
        //     echo '<p class="hero-subtitle hero-counter date">Sales end in <span class="display-counter">' . $discount_date . '</span></p>';
        // }

        $hero_sub = get_theme_mod( 'hero_subtitle' );

        if ( !empty($hero_sub) ) {
            echo '<p class="hero-subtitle">' . $hero_sub . '</p>';
        }

        ?>


        <a href="<?php echo esc_url(get_permalink(wc_get_page_id("shop"))); ?>">Shop Now</a>
    </div>

    <div class="home-products">
        <h2>Popular Products</h2>
        <a href="<?php echo esc_url(get_permalink(wc_get_page_id("shop"))); ?>">View All</a>
    </div>

    <?php
        echo do_shortcode('[products limit="4" orderby="popularity" columns="4"]');
    ?>

    <div class="mobile-shop-btn">
        <a href="<?php echo esc_url(get_permalink(wc_get_page_id("shop"))); ?>">View All</a>
    </div>

    <?php if (have_posts()) :?><?php while(have_posts()) : the_post(); ?>
    
      <article>

        <a href="<?php the_permalink(); ?>">

          <div class="post-img">
            <?php the_post_thumbnail('large', array('class' => 'img-res','alt' => get_the_title())); ?>
          </div>
             
          <h3><?php the_title(); ?></h3>
          <?php the_excerpt();?>    

        </a>

      </article>
    
    <?php endwhile; ?>
      
    <?php else : ?>
      <p><?php esc_html_e('Sorry, no posts matched your criteria.', 'slug-theme'); ?></p>
    <?php endif; ?>

</main>

<?php get_footer(); ?>