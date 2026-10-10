<?php
/**
 * Nior Atelier FSE Theme functions and definitions.
 *
 * @package NiorAtelier
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'NIOR_VERSION', '1.0.0' );
define( 'NIOR_THEME_DIR', get_template_directory() );
define( 'NIOR_THEME_URI', get_template_directory_uri() );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function nioratelier_setup() {
    // Make theme available for translation.
    load_theme_textdomain( 'nioratelier', NIOR_THEME_DIR . '/languages' );

    // Add support for core block visual styles.
    add_theme_support( 'wp-block-styles' );

    // Enqueue editor styles.
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/base.css' );

    // Enable post thumbnails.
    add_theme_support( 'post-thumbnails' );

    // Register pattern categories.
    register_block_pattern_category(
        'nior-cinematic',
        array(
            'label'       => __( 'Nior Atelier — Cinematic', 'nioratelier' ),
            'description' => __( 'High-impact scroll-driven kinetic patterns for Nior Atelier.', 'nioratelier' ),
        )
    );

    register_block_pattern_category(
        'nior-pages',
        array(
            'label'       => __( 'Nior Atelier — Full Pages', 'nioratelier' ),
            'description' => __( 'Full page starter layouts matching the company profile.', 'nioratelier' ),
        )
    );
}
add_action( 'after_setup_theme', 'nioratelier_setup' );

/**
 * Enqueue front-end stylesheets and scripts.
 */
function nioratelier_enqueue_assets() {
    // 1. Google Fonts: Playfair Display + Plus Jakarta Sans
    wp_enqueue_style(
        'nior-google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap',
        array(),
        null
    );

    // 2. Scoped CSS modules
    $css_modules = array(
        'nior-variables'      => 'assets/css/variables.css',
        'nior-base'           => 'assets/css/base.css',
        'nior-preloader'      => 'assets/css/preloader.css',
        'nior-header-footer'  => 'assets/css/header-footer.css',
        'nior-cinematic-hero' => 'assets/css/cinematic-hero.css',
        'nior-falling-logos'  => 'assets/css/falling-logos.css',
        'nior-sections'       => 'assets/css/sections.css',
        'nior-pages'          => 'assets/css/pages.css',
    );

    $prev_handle = 'nior-google-fonts';
    foreach ( $css_modules as $handle => $rel_path ) {
        wp_enqueue_style(
            $handle,
            NIOR_THEME_URI . '/' . $rel_path,
            array( $prev_handle ),
            NIOR_VERSION
        );
        $prev_handle = $handle;
    }

    // 3. Vendor scripts: GSAP, ScrollTrigger, Lenis
    wp_enqueue_script(
        'gsap',
        NIOR_THEME_URI . '/assets/js/vendor/gsap.min.js',
        array(),
        '3.12.5',
        true
    );

    wp_enqueue_script(
        'gsap-scrolltrigger',
        NIOR_THEME_URI . '/assets/js/vendor/ScrollTrigger.min.js',
        array( 'gsap' ),
        '3.12.5',
        true
    );

    wp_enqueue_script(
        'lenis',
        NIOR_THEME_URI . '/assets/js/vendor/lenis.min.js',
        array(),
        '1.1.14',
        true
    );

    // 4. Main ES Module entry
    wp_enqueue_script(
        'nior-main',
        NIOR_THEME_URI . '/assets/js/main.js',
        array( 'gsap', 'gsap-scrolltrigger', 'lenis' ),
        NIOR_VERSION,
        true
    );

    // Expose runtime config to client modules
    wp_localize_script(
        'nior-main',
        'niorConfig',
        array(
            'themeUri'        => NIOR_THEME_URI,
            'sequenceBase'    => NIOR_THEME_URI . '/assets/img/sequence/frame_',
            'totalFrames'     => 101,
            'walkthroughVideo'=> NIOR_THEME_URI . '/assets/img/walkthrough_master.mp4',
            'isFrontPage'     => is_front_page(),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'nioratelier_enqueue_assets' );

/**
 * Filter script tags to enable ES Module loading for main.js and internal modules.
 */
function nioratelier_script_type_module( $tag, $handle, $src ) {
    if ( 'nior-main' === $handle ) {
        return '<script type="module" src="' . esc_url( $src ) . '" id="' . esc_attr( $handle ) . '-js"></script>';
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'nioratelier_script_type_module', 10, 3 );
