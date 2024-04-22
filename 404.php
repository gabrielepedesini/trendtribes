<?php get_header(); ?>

<main class="container">

    <!-- <h1 class="page-title" style="margin-bottom: 30px">Page not found</h1> -->
    <!-- <p class="text">Page not found! But you're not lost, just off the beaten path. Explore a bit and you might stumble upon something unexpected.</p> -->
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 

    <dotlottie-player src="https://lottie.host/ab29fa36-12fd-4c88-95cc-8dbe2e7bc28d/ALnF6MwsmQ.json" background="transparent" speed="1" style="width: 270px; height: 270px; margin: 0 auto;" loop autoplay></dotlottie-player>

    <div class="return-home-container">
        <h1 class="page-title">Ooops!</h1>
        <p>The page you're looking for is not available.<br>Please try searching again or use the back button below.</p>
        <a href="<?php echo home_url(); ?>" class="return-home">Return Home</a>
    </div>
    
    <h2 class="may-like">You may like...</h2>

    <?php
        echo do_shortcode('[products limit="4" orderby="popularity" columns="4"]');
    ?>

</main>

<?php get_footer(); ?>