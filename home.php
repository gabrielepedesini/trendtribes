<?php get_header(); ?>

<main class="container">

    <?php 
    
    $blog_page_title = get_the_title(get_option('page_for_posts')); 
    ?>

    <h1 class="page-title"><?php echo esc_html($blog_page_title); ?></h1>

    <?php if (have_posts()) :?><?php while(have_posts()) : the_post(); ?>
    
        <article>

            <a href="<?php the_permalink(); ?>">

                <div class="post-img">
                    <?php the_post_thumbnail('large', array('class' => 'img-res','alt' => get_the_title())); ?>
                </div>

                <div class="post-text">
                    <h2><?php the_title(); ?></h2>
                    <p class="post-date"><?php the_time('j M, Y') ?></p>
                    <?php the_excerpt();?> 
                </div>
                  
            </a>

        </article>
    
    <?php endwhile; ?>
      
    <?php else : ?>

        <p><?php esc_html_e('Sorry, no posts found', 'slug-theme'); ?></p>

    <?php endif; ?>

    <?php echo '<div class="pagination" style="text-align: center">' . paginate_links(array('prev_text' => '←', 'next_text' => '→')) . '</div>'; ?>

</main>

<?php get_footer(); ?>