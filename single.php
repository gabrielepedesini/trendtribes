<?php get_header(); ?>

<main class="container">

    <?php custom_breadcrumbs(); ?>

    <?php if (have_posts()) :?><?php while(have_posts()) : the_post(); ?>
    
        <article>

            <h1 class="page-title"><?php the_title(); ?></h1>
            
            <p class="post-date"><?php the_time('j M, Y') ?></p>
            <?php the_content(esc_html__('Read More...', 'slug-theme'));?>

            <div class="post-img">
                <?php the_post_thumbnail('large', array('class' => 'img-res','alt' => get_the_title())); ?>
            </div>

        </article>
    
    <?php endwhile; ?>
      
    <?php else : ?>

        <p><?php esc_html_e('Sorry, no posts matched your criteria.', 'slug-theme'); ?></p>
      
    <?php endif; ?>



    <div style="text-align: center" class="prev-post-post">

        <?php
            $previous_post = get_previous_post();
            $next_post = get_next_post();
        ?>
        
        <?php
            if ($previous_post) {
                $previous_link = get_permalink($previous_post);
                echo '<a href="' . esc_url($previous_link) . '">Previous post</a>';
            } else {
                echo '<span>Previous post</span>';
            }
        
            echo ' <span class="divider-post">‒</span> ';

            if ($next_post) {
                $next_link = get_permalink($next_post);
                echo '<a href="' . esc_url($next_link) . '">Next post</a>';
            } else {
                echo '<span>Next post</span>';
            }
        ?>

    </div>

</main>

<?php get_footer(); ?>