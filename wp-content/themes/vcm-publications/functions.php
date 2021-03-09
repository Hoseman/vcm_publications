<?php
/**
 * VCM Publications functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package VCM_Publications
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'vcm_publications_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function vcm_publications_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on VCM Publications, use a find and replace
		 * to change 'vcm-publications' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'vcm-publications', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Register Main Menu.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'vcm-publications' ),
			)
		);

		// Register Top Mini Menu
		register_nav_menus(
			array(
				'top-mini-menu' => esc_html__( 'Secondary', 'vcm-publications' ),
			)
		);

		// Register Footer Menu
		register_nav_menus(
			array(
				'footer-menu-1' => esc_html__( 'Footer-1', 'vcm-publications' ),
			)
		);

		// Register Footer Menu
		register_nav_menus(
			array(
				'footer-menu-2' => esc_html__( 'Footer-2', 'vcm-publications' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'vcm_publications_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'vcm_publications_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function vcm_publications_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'vcm_publications_content_width', 640 );
}
add_action( 'after_setup_theme', 'vcm_publications_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function vcm_publications_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'vcm-publications' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'vcm-publications' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'vcm_publications_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function vcm_publications_scripts() {
	wp_enqueue_style( 'vcm-publications-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'vcm-publications-style', 'rtl', 'replace' );

	wp_enqueue_script( 'vcm-publications-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'vcm_publications_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}


/* enqueue custom styles */
function ah_enqueue(){
	$uri = get_template_directory_uri();
	wp_register_style('ah_google_fonts_1', 'https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap');
    wp_register_style('ah_bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css');
    wp_register_style('ah_font_awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css');
    wp_register_style('ah_main', $uri . '/css/main.css?');
	wp_register_style('ah_hamburger', $uri . '/css/hamburgers.css?');
	

	wp_enqueue_style('ah_google_fonts_1');
    wp_enqueue_style('ah_bootstrap');
    wp_enqueue_style('ah_font_awesome');
    wp_enqueue_style('ah_main');
	wp_enqueue_style('ah_hamburger');
	

	//wp_register_script('ah_jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js', [], false, true);
    wp_register_script('ah_popper', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js', [], false, true);
    wp_register_script('ah_mainjs', $uri . '/js/main.js?'.uniqid(), [], false, true);


	//wp_enqueue_script('ah_jquery');
    wp_enqueue_script('ah_popper');
    wp_enqueue_script('ah_mainjs');
}

add_action( 'wp_enqueue_scripts', 'ah_enqueue' );
/* enqueue custom styles */


/* Enable SVG Support */
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
/* Enable SVG Support */


/* Change woocommerce default breadcrumb listing */
add_filter( 'woocommerce_breadcrumb_defaults', 'ah_woocommerce_breadcrumbs' );
function ah_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => '&nbsp;&#47;&nbsp;',
            'wrap_before' => '<section class="breadcrumbs"><div class="container"><nav class="woocommerce-breadcrumbs">',
            'wrap_after'  => '</nav><hr></div></section>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
        );
}
/* Change woocommerce default breadcrumb listing */


/* Add View Product to product category page */
add_action( 'woocommerce_after_shop_loop_item', 'wpt_custom_view_product_button', 10);
	function wpt_custom_view_product_button() {
	global $product;
	$link = $product->get_permalink();
	echo '<a href="' . $link . '" class="button wpt-custom-view-product-button">View Product</a>';
}
/* Add View Product to product category page */


/* Remove category star rating and reposition below title */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

add_action('init', 'add_new_star_rating');

function add_new_star_rating() {
	add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 10 );
}
/* Remove category star rating and reposition below title */


/* Add blue underline under category product title */
add_action( 'woocommerce_shop_loop_item_title', 'ah_add_underline' );
 
function ah_add_underline(){
	echo '<span class="category-results__heading-underline"></span>';
}
/* Add blue underline under category product title */


/* Hide sale flash on caegory page and reposition in blue sliding panel */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

add_action('init', 'add_new_sale_flash');

function add_new_sale_flash() {
	add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
}
/* Hide sale flash on caegory page and reposition in blue sliding panel */


/* Set thumbnail Image size */
add_filter( 'woocommerce_get_image_size_thumbnail', function( $size ) {
	return array(
		'width'  => 500,
		'height' => 500,
		'crop'   => 1,
	);
} );
/* Set thumbnail Image size */

/* Related Products on Product Detail Page - change to 4 columns */
function woo_related_products_limit() {
	global $product;
	  
	  $args['posts_per_page'] = 6;
	  return $args;
  }
  add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
	function jk_related_products_args( $args ) {
	  $args['posts_per_page'] = 4; // 4 related products
	  $args['columns'] = 4; 
	  return $args;
  }
  /* Related Products on Product Detail Page - change to 4 columns */