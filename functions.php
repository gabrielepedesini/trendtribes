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
    
    wp_enqueue_script( 'slug-theme-script', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '', true );
    if ( is_singular() && get_option( 'thread_comments' ) )  { wp_enqueue_script( 'comment-reply' ); }
    
    // Enqueue jQuery
    wp_enqueue_script('jquery');

    if ( is_page( 'shop' ) ) {
        wp_enqueue_script( 'shop-script', get_template_directory_uri() . '/js/shop.js', array(), '', true );
    };
    
    wp_enqueue_script( 'shop-script', get_template_directory_uri() . '/js/shop.js', array(), '', true );
    wp_enqueue_script( 'product-script', get_template_directory_uri() . '/js/product.js', array(), '', true );
    wp_enqueue_script( 'myaccount-script', get_template_directory_uri() . '/js/myaccount.js', array(), '', true );
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

// change sale text to display percentage off

function change_sale_text_to_percentage_off($text, $post, $product) {
    // check if the product is variable
    if ( $product->is_type('variable') ) {
        
        $variations = $product->get_available_variations();

        $regular_prices = array();
        $sale_prices = array();

        foreach ( $variations as $variation ) {
            $regular_price = $variation['display_regular_price'];

            $sale_price = $variation['display_price'];

            if ( $regular_price && $sale_price && $regular_price > $sale_price ) {
                $regular_prices[] = $regular_price;
                $sale_prices[] = $sale_price;
            }
        }

        if ( !empty( $regular_prices ) && !empty( $sale_prices ) ) {
            $percentage = round( ( ( array_sum( $regular_prices ) - array_sum( $sale_prices ) ) / array_sum( $regular_prices ) ) * 100 );

            return '<span class="onsale">' . sprintf( '-%d%%', $percentage ) . '</span>';
        } else {
            return $text;
        }
    } else {
        // for non-variable products, use the regular method
        $regular_price = $product->get_regular_price();

        $sale_price = $product->get_sale_price();

        if ( $regular_price && $sale_price && $regular_price > $sale_price ) {
            $percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );

            return '<span class="onsale">' . sprintf( '-%d%%', $percentage ) . '</span>';
        } else {

            return 'Sale';
        }
    }
}

add_filter('woocommerce_sale_flash', 'change_sale_text_to_percentage_off', 10, 3);
?>

<?php

// custom price slider selector
function custom_filter_shortcode() {
    global $wpdb;

    $max_price = $wpdb->get_var( "
        SELECT MAX(meta_value + 0) 
        FROM {$wpdb->postmeta} 
        WHERE meta_key = '_price'
    " );

    $max_price = ceil($max_price / 10) * 10;

    echo '<div class="max-price">' . $max_price . '</div>';

    $current_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';
    
    if($current_price == null) {
        $current_price = $max_price;
    }

    // Retrieve the current URL
    $current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    // Parse the URL to get existing query parameters
    $parsed_url = parse_url($current_url);
    $query_params = isset($parsed_url['query']) ? $parsed_url['query'] : '';

    ob_start();
    ?>

    <form method="get" id="price-type-filter-form" action="<?php echo esc_url($current_url); ?>">

        <?php generate_type_filters(); ?>

        <div style="height: 15px;"></div>

        <input type="range" id="max_price" name="max_price" min="0" max="<?php echo $max_price; ?>" value="<?php echo $current_price; ?>" step="1" />
        <div class="price-range-numbers">
            <span>0 <?php echo get_woocommerce_currency_symbol() ?></span>
            <output for="max_price"><span id="price-output"><?php echo $current_price ?></span> <?php echo get_woocommerce_currency_symbol() ?></output>
        </div>

        <div style="height: 25px;"></div>

        <input type="hidden" name="orderby" value="<?php echo isset($_GET['orderby']) ? $_GET['orderby'] : ''; ?>" />

        <div class="price-range-btn-container">
            <button type="submit" value="Apply Filter">Apply</button>
            <a class="remove-filters">Remove All</a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var priceRangeInput = document.getElementById('max_price');
            var priceOutput = document.getElementById('price-output');
            var priceTypeFilterForm = document.getElementById('price-type-filter-form');

            // Update output value when range input changes
            priceRangeInput.addEventListener('input', function() {
                priceOutput.textContent = priceRangeInput.value;
            });
        });
    </script>

    <?php
    return ob_get_clean();
}

add_shortcode('custom_filter', 'custom_filter_shortcode');

// Function to generate dynamic checkboxes for product types
function generate_type_filters() {
    // Get products within the current category or main shop page
    if (is_product_category() || is_shop()) {
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );

        // For product category pages, add tax query to filter products by category
        if (is_product_category()) {
            $category_id = get_queried_object_id();
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $category_id,
                ),
            );
        }

        $products = new WP_Query($args);

        // Array to store unique product types
        $product_types = array();

        // Extract unique product types
        if ($products->have_posts()) {
            while ($products->have_posts()) {
                $products->the_post();
                $product = wc_get_product(get_the_ID());
                $types = $product->get_attribute('pa_product_type');
                if ($types) {
                    $types = explode(', ', $types);
                    foreach ($types as $type) {
                        $product_types[] = $type;
                    }
                }
            }
        }

        // Display checkboxes for each unique product type
        $product_types = array_unique($product_types);
        if (!empty($product_types)) {
            echo '<div>';
            foreach ($product_types as $type) {
                $checked = isset($_GET['type_filter']) && in_array($type, $_GET['type_filter']) ? 'checked' : '';
                echo '<label class="type-input-box"><input type="checkbox" name="type_filter[]" value="' . esc_attr($type) . '" ' . $checked . '> ' . esc_html($type) . '</label><br>';
            }
            echo '</div>';
        }

        // Reset post data
        wp_reset_postdata();
    }
}

// Function to filter products based on selected checkboxes and price range
function filter_products() {
    if (isset($_GET['type_filter']) && is_array($_GET['type_filter'])) {
        $type_filters = array_map('sanitize_text_field', $_GET['type_filter']);

        // Array to store terms
        $terms = array();

        // Loop through selected types to construct terms array
        foreach ($type_filters as $type) {
            $terms[] = $type;
        }

        // Set the taxonomy query for product type
        $tax_query[] = array(
            'taxonomy' => 'pa_product_type',
            'field'    => 'name',
            'terms'    => $terms,
            'operator' => 'IN',
        );
    }

    // Price range filter
    if (isset($_GET['max_price'])) {
        $max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 0;
        if ($max_price > 0) {
            $meta_query[] = array(
                'key'     => '_price',
                'value'   => $max_price,
                'compare' => '<=',
                'type'    => 'NUMERIC',
            );
        }
    }

    // Combine tax and meta queries
    $tax_meta_query = array('relation' => 'AND');
    if (!empty($tax_query)) {
        $tax_meta_query[] = $tax_query;
    }
    if (!empty($meta_query)) {
        $tax_meta_query[] = $meta_query;
    }

    // Apply combined query
    set_query_var('tax_query', $tax_meta_query);
}

// Hook to apply the filter when the shop page is queried
add_action('pre_get_posts', 'filter_products');

?>


<?php

// custom text in 'added to cart' message

// function quadlayers_add_to_cart_message_html( $message, $products ) {

//     $count = 0;
//     $titles = array();
//     foreach ( $products as $product_id => $qty ) {
//     $titles[] = ( $qty > 1 ? absint( $qty ) . ' &times; ' : '' ) . sprintf( _x( '&ldquo;%s&rdquo;', 'Item name in quotes', 'woocommerce' ), strip_tags( get_the_title( $product_id ) ) );
//     $count += $qty;
//     }
    
//     $titles     = array_filter( $titles );
//     $added_text = sprintf( _n(
//     '%s has been added to your cart. Thank you for shopping!', // Singular
//     '%s have been added to your cart. Thank you for shopping!', // Plural
//     $count, // Number of products added
//     'woocommerce' // Textdomain
//     ), wc_format_list_of_items( $titles ) );
//     $message    = sprintf( '<a href="%s" class="button wc-forward">%s</a> %s', esc_url( wc_get_page_permalink( 'cart' ) ), esc_html__( 'View cart', 'woocommerce' ), esc_html( $added_text ) );
    
//     return $message;
// }

// add_filter( 'wc_add_to_cart_message_html', 'quadlayers_add_to_cart_message_html', 10, 2 );

?>

<?php

// custom quantity selector

defined( 'ABSPATH' ) || exit(); 

if ( ! class_exists( 'Rk_Plus_Minus' ) ) {

    class Rk_Plus_Minus {

        /**
         * The instance variable of the class.
         *
         * @var $instance.
         */
        protected static $instance = null;

        /**
         * Constructor of this class.
         */
        public function __construct() {
            add_action( 'woocommerce_after_quantity_input_field', array( $this, 'rk_display_quantity_plus' ) );
            add_action( 'woocommerce_before_quantity_input_field', array( $this, 'rk_display_quantity_minus' ) );
            add_action( 'wp_footer', array( $this, 'rk_add_cart_quantity_plus_minus' ) );
        }

        /**
         * Display plus button after Add to Cart button.
         */
        public function rk_display_quantity_plus() {
            echo '<button type="button" class="plus">+</button>';
        }

        /**
         * Display minus button before Add to Cart button.
         */
        public function rk_display_quantity_minus() {
            echo '<button type="button" class="minus">-</button>';
        }

        /**
         * Enqueue script.
         */
        public function rk_add_cart_quantity_plus_minus() {

            if ( ! is_product() && ! is_cart() ) {
                return;
            }

            wc_enqueue_js(
                "$(document).on( 'click', 'button.plus, button.minus', function() {

                    var qty = $( this ).parent( '.quantity' ).find( '.qty' );
                    var val = parseFloat(qty.val());
                    var max = parseFloat(qty.attr( 'max' ));
                    var min = parseFloat(qty.attr( 'min' ));
                    var step = parseFloat(qty.attr( 'step' ));

                    if ( $( this ).is( '.plus' ) ) {
                        if ( max && ( max <= val ) ) {
                        qty.val( max ).change();
                        } else {
                        qty.val( val + step ).change();
                        }
                    } else {
                        if ( min && ( min >= val ) ) {
                        qty.val( min ).change();
                        } else if ( val > 1 ) {
                        qty.val( val - step ).change();
                        }
                    }

                });"
            );
        }

        /**
         * Instance of this class.
         *
         * @return object.
         */
        public static function get_instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }

            return self::$instance;
        }
    }
}

Rk_Plus_Minus::get_instance();

?>

<?php

// create 'Type' attribute by default

function custom_theme_add_custom_attribute() {
    global $wpdb;

    $attribute_name = 'Type';
    $attribute_label = 'Type';
    $attribute_type = 'text';
    $attribute_default_value = ''; 

    $attribute_id = wc_attribute_taxonomy_id_by_name('product_type');

    if (!$attribute_id) {
        
        $attribute_id = wc_create_attribute([
            'name' => $attribute_name,
            'slug' => 'product_type',
            'label' => $attribute_label,
            'type' => $attribute_type,
            'order_by' => 'menu_order',
            'has_archives' => true,
        ]);
    }
}

add_action('after_setup_theme', 'custom_theme_add_custom_attribute');

?>

<?php

// add custom meta box for sizing image upload in products

function add_sizing_image_meta_box() {
    add_meta_box(
        'sizing_image_meta_box',
        'Sizing image',
        'render_sizing_image_meta_box',
        'product',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_sizing_image_meta_box');

// Render the content of the sizing image meta box
// Render the content of the sizing image meta box
function render_sizing_image_meta_box($post) {
    wp_nonce_field(basename(__FILE__), 'sizing_image_meta_box_nonce');
    $sizing_image_url = get_post_meta($post->ID, '_sizing_image', true);
    ?>
    <p>
        <label for="sizing_image">Upload Size image:</label>
        <input type="button" id="upload_sizing_image_button" class="button" value="Upload Image">
        <input type="hidden" name="sizing_image" id="sizing_image" value="<?php echo $sizing_image_url; ?>">    
        <br>
        <br>
        <img id="sizing_image_preview" src="<?php echo $sizing_image_url; ?>" style="max-width: 100%;" />
        <br>
        <br>
        <p><span style="text-decoration: underline">To display this image in product page</span>: create an attribute called "Size Chart" and give it some text that will introduce the sizing image.</p>
        <a id="delete_sizing_image_button" style="text-decoration: underline; color: #b32d2e; cursor: pointer">Delete Image</a>
    </p>
    <script>
        jQuery(document).ready(function($) {
            $('#upload_sizing_image_button').click(function(e) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Upload Sizing Image',
                    multiple: false
                }).open().on('select', function(e) {
                    var uploaded_image = image.state().get('selection').first();
                    var image_url = uploaded_image.toJSON().url;
                    $('#sizing_image').val(image_url);
                    $('#sizing_image_preview').attr('src', image_url).show();
                    $('#delete_sizing_image_button').show();
                });
            });

            $('#delete_sizing_image_button').click(function(e) {
                e.preventDefault();
                $('#sizing_image').val('');
                $('#sizing_image_preview').attr('src', '').hide();
                $(this).hide();
            });
        });
    </script>
    <?php
}

// Save the sizing image URL when the product is saved
function save_sizing_image_meta_box($post_id) {
    if (!isset($_POST['sizing_image_meta_box_nonce']) || !wp_verify_nonce($_POST['sizing_image_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if ('product' === $_POST['post_type'] && current_user_can('edit_post', $post_id)) {
        if (isset($_POST['sizing_image'])) {
            update_post_meta($post_id, '_sizing_image', sanitize_text_field($_POST['sizing_image']));
        }
    }
}
add_action('save_post', 'save_sizing_image_meta_box');

?>

<?php

// change review title for 'no reviews'

add_filter('woocommerce_product_review_comment_form_args', 'change_review_title');

function change_review_title($args) {
    $args['title_reply'] = 'Add a review';
    return $args;
}

?>

<?php

// separated login and register page

// add_shortcode( 'wc_reg_form_bbloomer', 'bbloomer_separate_registration_form' );
     
// function bbloomer_separate_registration_form() {
//    if ( is_user_logged_in() ) return '<p>You are already registered</p>';
//    ob_start();
//    do_action( 'woocommerce_before_customer_login_form' );
//    $html = wc_get_template_html( 'myaccount/form-login.php' );
//    $dom = new DOMDocument();
//    $dom->encoding = 'utf-8';
//    $dom->loadHTML( utf8_decode( $html ) );
//    $xpath = new DOMXPath( $dom );
//    $form = $xpath->query( '//form[contains(@class,"register")]' );
//    $form = $form->item( 0 );
//    echo $dom->saveXML( $form );
//    return ob_get_clean();
// }

// add_shortcode( 'wc_login_form_bbloomer', 'bbloomer_separate_login_form' );
  
// function bbloomer_separate_login_form() {
//    if ( is_user_logged_in() ) return '<p>You are already logged in</p>'; 
//    ob_start();
//    do_action( 'woocommerce_before_customer_login_form' );
//    woocommerce_login_form( array( 'redirect' => wc_get_page_permalink( 'myaccount' ) ) );
//    return ob_get_clean();
// }

// add_action( 'template_redirect', 'bbloomer_redirect_login_registration_if_logged_in' );
 
// function bbloomer_redirect_login_registration_if_logged_in() {
//     if ( is_page() && is_user_logged_in() && ( has_shortcode( get_the_content(), 'wc_login_form_bbloomer' ) || has_shortcode( get_the_content(), 'wc_reg_form_bbloomer' ) ) ) {
//         wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
//         exit;
//     }
// }

// add_action( 'template_redirect', 'bbloomer_redirect_to_login_if_myaccount' );

// function bbloomer_redirect_to_login_if_myaccount() {

//     $current_url_path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
    
//     $myaccount_page_slug = basename( get_permalink( wc_get_page_id( 'myaccount' ) ) );

//     if ( trim( $current_url_path, '/' ) === $myaccount_page_slug && ! is_user_logged_in() ) {
//         wp_safe_redirect( home_url( '/login' ) );
//         exit;
//     }
// }

?>