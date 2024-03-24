<?php get_header(); ?>

<main class="container">

    <?php if (have_posts()) :?><?php while(have_posts()) : the_post(); ?>
    
      <!-- loop content -->
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