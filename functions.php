<?php

//theme setup

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

}

add_action( 'after_setup_theme', 'nakedpress_setup' );
?>

<?php

//enqueue css

function nakedpress_styles() {

    wp_enqueue_style( 'slug-theme-style', get_template_directory_uri().'/style.css');

}

add_action( 'wp_enqueue_scripts', 'nakedpress_styles' );
?>

<?php

//enqueue javascript


function nakedpress_scripts() {

    wp_enqueue_script( 'slug-theme-script', get_template_directory_uri() . '/js/script.js', array( 'jquery' ),'', true );
    if ( is_singular() && get_option( 'thread_comments' ) )  { wp_enqueue_script( 'comment-reply' ); }

    // Enqueue jQuery
    wp_enqueue_script('jquery');

}

add_action( 'wp_enqueue_scripts', 'nakedpress_scripts' );
?>

<?php

function wpdocs_custom_excerpt_length( $length ) {
	return 15; 
    // excerpt of 20 words
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );   

?>

<?php 

//setup woocommerce theme

function theme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'theme_add_woocommerce_support' );

?>


<?php 

//update cart by ajax call

function get_cart_count() {
    echo WC()->cart->get_cart_contents_count();
    wp_die();
}

add_action('wp_ajax_get_cart_count', 'get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'get_cart_count');

?>

<?php

//change sale text

function change_sale_text($text, $post, $product) {
    return '<span class="onsale">' . esc_html__('Sale', 'woocommerce') . '</span>';
}

add_filter('woocommerce_sale_flash', 'change_sale_text', 10, 3);

?>