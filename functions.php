<?php

// theme setup

function nakedpress_setup() {

    // Enable title in header
    add_theme_support( 'title-tag' );

    // Modify the title tag separator
    function custom_title_separator($sep) {
        return '|';
    }
    add_filter('document_title_separator', 'custom_title_separator');

    // Enable custom header
    add_theme_support( 'custom-header' );

    // Enable custom logo
    add_theme_support( 'custom-logo' );

    // Enable automatic feed links
    add_theme_support( 'automatic-feed-links' );

    // Enable featured image
    add_theme_support( 'post-thumbnails' );

    // Thumbnail sizes
    add_image_size( 'nakedpress_single', 800, 999, false );
    add_image_size( 'nakedpress_big', 1400, 928, true );   //(cropped)

    // Custom menu areas
    register_nav_menus( array(
        'header' => esc_html__( 'Header', 'slug-theme' )
    ) );

    // Load theme languages
    load_theme_textdomain( 'slug-theme', get_template_directory().'/languages' );

    // WooCommerce
    add_theme_support('woocommerce');

    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    add_filter( 'woocommerce_single_product_zoom_options', 'custom_single_product_zoom_options' );
    
    function custom_single_product_zoom_options( $zoom_options ) {
        // Changing the magnification level:
        $zoom_options['magnify'] = 0.4;
        return $zoom_options;
    }

}

add_action( 'after_setup_theme', 'nakedpress_setup' );
?>


<?php

// enqueue css

function nakedpress_styles() {
    
    wp_enqueue_style( 'slug-theme-style', get_template_directory_uri().'/style.css');
    
}

add_action( 'wp_enqueue_scripts', 'nakedpress_styles' );
?>

<?php

// enqueue javascript


function nakedpress_scripts() {
    
    wp_enqueue_script( 'slug-theme-script', get_template_directory_uri() . '/js/script.js', array( 'jquery' ),'', true );
    if ( is_singular() && get_option( 'thread_comments' ) )  { wp_enqueue_script( 'comment-reply' ); }
    
    // Enqueue jQuery
    wp_enqueue_script('jquery');
    
}

add_action( 'wp_enqueue_scripts', 'nakedpress_scripts' );
?>

<?php

// lazy loading images

function enable_lazy_loading() {
    add_filter( 'wp_lazy_loading_enabled', '__return_true' );
}
add_action( 'after_setup_theme', 'enable_lazy_loading' );

?>

<?php

// bredcrumb cathegory fix



?>

<?php

// excerpt of 15 words

function wpdocs_custom_excerpt_length( $length ) {
    return 15; 
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );   

?>

<?php 

// update cart by ajax call

function get_cart_count() {
    echo WC()->cart->get_cart_contents_count();
    wp_die();
}

add_action('wp_ajax_get_cart_count', 'get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'get_cart_count');

?>

<?php

// change sale text

function change_sale_text($text, $post, $product) {
    return '<span class="onsale">' . esc_html__('Sale', 'woocommerce') . '</span>';
}

add_filter('woocommerce_sale_flash', 'change_sale_text', 10, 3);

?>

<?php

// custom price slider selector

function custom_price_filter_shortcode() {
    global $wpdb;

    // Get the maximum price of products in the shop
    $max_price = $wpdb->get_var( "
        SELECT MAX(meta_value + 0) 
        FROM {$wpdb->postmeta} 
        WHERE meta_key = '_price'
    " );

    $max_price = ceil($max_price / 10) * 10;

    // Get the current selected price if available
    $current_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';
    
    if($current_price == null) {
        $current_price = $max_price;
    }

    ob_start(); // Start output buffering
    ?>

    <form method="get" id="price-filter-form">
        <input type="range" id="max_price" name="max_price" min="0" max="<?php echo $max_price; ?>" value="<?php echo $current_price; ?>" step="1" />
        <div>
            <span>0 <?php echo get_woocommerce_currency_symbol() ?></span>
            <output for="max_price"><span id="price-output"><?php echo $current_price ?></span> <?php echo get_woocommerce_currency_symbol() ?></output>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var priceRangeInput = document.getElementById('max_price');
            var priceOutput = document.getElementById('price-output');
            var priceFilterForm = document.getElementById('price-filter-form');

            // Update output value when range input changes
            priceRangeInput.addEventListener('input', function() {
                priceOutput.textContent = priceRangeInput.value;
            });

            // Auto submit form when range selection changes
            priceRangeInput.addEventListener('change', function() {
                priceFilterForm.submit();
            });
        });
    </script>

    <?php
    return ob_get_clean();
}

add_shortcode('custom_price_filter', 'custom_price_filter_shortcode'); 

?>