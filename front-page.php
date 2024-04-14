<?php get_header(); ?>

<main class="container" style="overflow: hidden;">

    <div class="hero" style="background-image: url(' <?php echo esc_url(get_header_image()) ?> ');">

        <?php
        
        $hero_title = get_theme_mod( 'hero_title' );
        $hero_sub = get_theme_mod( 'hero_subtitle' );

        if ( !empty($hero_title) ) {
            echo '<h1>' . $hero_title . '</h1>';
        } else {
            echo '<h1>Insert "Hero Title" via admin panel in customize</h1>';
        }

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

    <div style="height: 60px"></div>

    <div class="swiper-container">

        <h4>Testimonials</h4>
        <h2>What Our Customers Say</h2>

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                
            <?php

            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => -1
            );

            $products = new WP_Query( $args );

            $reviewDisplayed = 0;

            if ( $products->have_posts() ) {
                while ( $products->have_posts() && $reviewDisplayed < 6) {
                    $products->the_post();

                    global $product;
                    $product_id = $product->get_id();

                    $reviews = get_comments( array(
                        'post_id' => $product_id,
                        'status'  => 'approve',
                        'type'    => 'review',
                        'meta_query' => array(
                            array(
                                'key'     => 'rating',
                                'value'   => 5,
                                'compare' => '='
                            )
                        )
                    ) );

                    if ($reviews) {
                        foreach ($reviews as $review) {
                            $user_id      = $review->user_id;
                            $user_name    = $review->comment_author;
                            $review_text  = $review->comment_content;
                            $user_avatar  = get_avatar_url($user_id);

                            echo '<div class="swiper-slide">';
                            if (($reviewDisplayed % 2) == 0) {
                                echo '<div class="review-container light">';
                            } else {
                                echo '<div class="review-container dark">';
                            }
                            echo '<div class="review-stars">★★★★★</div>';
                            echo '<div class="review-text">' . $review_text . '</div>';
                            echo '<div class="name-avatar-container">';
                            echo '<img src="' . $user_avatar . '" alt="User Avatar">';
                            echo '<div>' . $user_name . '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';

                            $reviewDisplayed++;

                            if ($reviewDisplayed >= 6) {
                                break 2;
                            }
                        }
                    }
                }
            }

            wp_reset_postdata();

            ?>

            </div>

            <div class="swiper-pagination"></div>
        </div>
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