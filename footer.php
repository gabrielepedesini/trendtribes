    <footer class="footer">

    <div style="margin-bottom: 15px">
        <?php bloginfo('title'); ?> - <a href="/privacy-policy">Privacy Policy</a>
    </div>

    <div>
        <form class="search-form" role="search" method="get" action="<?php echo home_url(); ?>">
        <input  type="text" placeholder="<?php esc_html_e('Search', 'slug-theme'); ?>" name="s">
        <button type="submit">Search</button>
        </form>
    </div>
    </footer>

    <?php wp_footer(); ?>

</body>
</html>
