<?php
/**
 * Cinematic Interior FSE Theme functions and definitions.
 *
 * @package CinematicInterior
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CINEMATIC_INTERIOR_VERSION', '1.8.35' );
define( 'CINEMATIC_INTERIOR_THEME_DIR', get_template_directory() );
define( 'CINEMATIC_INTERIOR_THEME_URI', get_template_directory_uri() );

// Backward compatibility constant aliases
if ( ! defined( 'NIOR_VERSION' ) ) {
    define( 'NIOR_VERSION', CINEMATIC_INTERIOR_VERSION );
}
if ( ! defined( 'NIOR_THEME_DIR' ) ) {
    define( 'NIOR_THEME_DIR', CINEMATIC_INTERIOR_THEME_DIR );
}
if ( ! defined( 'NIOR_THEME_URI' ) ) {
    define( 'NIOR_THEME_URI', CINEMATIC_INTERIOR_THEME_URI );
}

require_once CINEMATIC_INTERIOR_THEME_DIR . '/inc/projects-data.php';
require_once CINEMATIC_INTERIOR_THEME_DIR . '/inc/licensing/class-theme-licensing.php';

// Initialize Theme Licensing subsystem.
\CinematicInterior\Licensing\Theme_Licensing::get_instance()->init();

/**
 * Check if the theme has an active license.
 *
 * @return bool
 */
function cinematic_interior_is_licensed() {
    return \CinematicInterior\Licensing\Theme_Licensing::get_instance()->is_licensed();
}

/**
 * Backward compatibility alias for license check.
 *
 * @return bool
 */
function nioratelier_is_licensed() {
    return cinematic_interior_is_licensed();
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function cinematic_interior_setup() {
    // Make theme available for translation.
    load_theme_textdomain( 'cinematic-interior', CINEMATIC_INTERIOR_THEME_DIR . '/languages' );

    // Add support for core block visual styles.
    add_theme_support( 'wp-block-styles' );

    // Enqueue comprehensive editor styles for 1:1 Site Editor fidelity.
    add_theme_support( 'editor-styles' );
    add_editor_style( array(
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap',
        'assets/css/variables.css',
        'assets/css/base.css',
        'assets/css/header-footer.css',
        'assets/css/cinematic-hero.css',
        'assets/css/video-scrub-hero.css',
        'assets/css/cinematic-scenarios.css',
        'assets/css/falling-logos.css',
        'assets/css/walkthrough-zoom.css',
        'assets/css/sections.css',
        'assets/css/pages.css',
        'assets/css/project-gallery.css',
        'assets/css/editor.css',
    ) );

    // Enable post thumbnails.
    add_theme_support( 'post-thumbnails' );

    // Register pattern categories.
    register_block_pattern_category(
        'cinematic-interior-showcase',
        array(
            'label'       => __( 'Cinematic Interior — Showcase', 'cinematic-interior' ),
            'description' => __( 'High-impact scroll-driven kinetic patterns for Cinematic Interior.', 'cinematic-interior' ),
        )
    );

    register_block_pattern_category(
        'cinematic-interior-pages',
        array(
            'label'       => __( 'Cinematic Interior — Full Pages', 'cinematic-interior' ),
            'description' => __( 'Full page starter layouts matching the studio profile.', 'cinematic-interior' ),
        )
    );

    // Backward compatibility categories
    register_block_pattern_category(
        'nior-cinematic',
        array(
            'label'       => __( 'Cinematic Interior — Kinetic', 'cinematic-interior' ),
            'description' => __( 'Kinetic patterns category.', 'cinematic-interior' ),
        )
    );

    register_block_pattern_category(
        'nior-pages',
        array(
            'label'       => __( 'Cinematic Interior — Layouts', 'cinematic-interior' ),
            'description' => __( 'Full page templates category.', 'cinematic-interior' ),
        )
    );
}
add_action( 'after_setup_theme', 'cinematic_interior_setup' );

/**
 * Enqueue front-end stylesheets and scripts.
 */
function cinematic_interior_enqueue_assets() {
    // 1. Google Fonts: Playfair Display + Plus Jakarta Sans
    wp_enqueue_style(
        'nior-google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap',
        array(),
        null
    );

    // 2. Scoped CSS modules
    $css_modules = array(
        'nior-variables'          => 'assets/css/variables.css',
        'nior-base'               => 'assets/css/base.css',
        'nior-preloader'          => 'assets/css/preloader.css',
        'nior-header-footer'      => 'assets/css/header-footer.css',
        'nior-cinematic-hero'     => 'assets/css/cinematic-hero.css',
        'nior-video-scrub-hero'   => 'assets/css/video-scrub-hero.css',
        'nior-cinematic-scenarios'=> 'assets/css/cinematic-scenarios.css',
        'nior-falling-logos'      => 'assets/css/falling-logos.css',
        'nior-walkthrough-zoom'   => 'assets/css/walkthrough-zoom.css',
        'nior-sections'           => 'assets/css/sections.css',
        'nior-pages'              => 'assets/css/pages.css',
        'nior-project-gallery'    => 'assets/css/project-gallery.css',
    );

    $prev_handle = 'nior-google-fonts';
    foreach ( $css_modules as $handle => $rel_path ) {
        wp_enqueue_style(
            $handle,
            CINEMATIC_INTERIOR_THEME_URI . '/' . $rel_path,
            array( $prev_handle ),
            CINEMATIC_INTERIOR_VERSION
        );
        $prev_handle = $handle;
    }

    // 3. Vendor scripts: GSAP, ScrollTrigger, Lenis
    wp_enqueue_script(
        'gsap',
        CINEMATIC_INTERIOR_THEME_URI . '/assets/js/vendor/gsap.min.js',
        array(),
        '3.12.5',
        true
    );

    wp_enqueue_script(
        'gsap-scrolltrigger',
        CINEMATIC_INTERIOR_THEME_URI . '/assets/js/vendor/ScrollTrigger.min.js',
        array( 'gsap' ),
        '3.12.5',
        true
    );

    wp_enqueue_script(
        'lenis',
        CINEMATIC_INTERIOR_THEME_URI . '/assets/js/vendor/lenis.min.js',
        array(),
        '1.1.14',
        true
    );

    // 4. Main ES Module entry
    wp_enqueue_script(
        'nior-main',
        CINEMATIC_INTERIOR_THEME_URI . '/assets/js/main.js',
        array( 'gsap', 'gsap-scrolltrigger', 'lenis' ),
        CINEMATIC_INTERIOR_VERSION,
        true
    );

    // Expose runtime config to client modules
    wp_localize_script(
        'nior-main',
        'niorConfig',
        array(
            'version'         => CINEMATIC_INTERIOR_VERSION,
            'themeUri'        => CINEMATIC_INTERIOR_THEME_URI,
            'sequenceBase'    => CINEMATIC_INTERIOR_THEME_URI . '/assets/img/sequence/frame_',
            'totalFrames'     => 101,
            'walkthroughTotalFrames' => 5,
            'walkthroughVideo'=> CINEMATIC_INTERIOR_THEME_URI . '/assets/img/walkthrough_master.mp4',
            'scrubVideo'      => CINEMATIC_INTERIOR_THEME_URI . '/assets/img/hero-scrub.mp4',
            'posterImage'     => CINEMATIC_INTERIOR_THEME_URI . '/assets/img/hero-poster.webp',
            'walkthroughImages'=> array_map( function( $i ) {
                return CINEMATIC_INTERIOR_THEME_URI . sprintf( '/assets/img/walkthrough/frame-%02d.jpg?v=%s', $i, CINEMATIC_INTERIOR_VERSION );
            }, range( 1, 5 ) ),
            'isFrontPage'     => is_front_page(),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'cinematic_interior_enqueue_assets' );

/**
 * Filter script tags to enable ES Module loading for main.js and internal modules.
 */
function cinematic_interior_script_type_module( $tag, $handle, $src ) {
    if ( 'nior-main' === $handle ) {
        return '<script type="module" src="' . esc_url( $src ) . '" id="' . esc_attr( $handle ) . '-js"></script>';
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'cinematic_interior_script_type_module', 10, 3 );

/**
 * Enqueue editor-specific assets to guarantee Site Editor iframe styling.
 */
function cinematic_interior_enqueue_editor_assets() {
    if ( ! is_admin() ) {
        return;
    }
    wp_enqueue_style(
        'cinematic-interior-editor-overrides',
        CINEMATIC_INTERIOR_THEME_URI . '/assets/css/editor.css',
        array(),
        CINEMATIC_INTERIOR_VERSION
    );
}
add_action( 'enqueue_block_assets', 'cinematic_interior_enqueue_editor_assets' );

/**
 * Automatically provisions core pages if they do not exist yet.
 * Ensures multi-page routing functions out-of-the-box in local and production.
 */
function cinematic_interior_ensure_default_pages() {
    $pages = array(
        'about'    => array(
            'title'   => 'About Us',
            'pattern' => '<!-- wp:pattern {"slug":"cinematic-interior/page-about-content"} /-->',
        ),
        'services' => array(
            'title'   => 'Services',
            'pattern' => '<!-- wp:pattern {"slug":"cinematic-interior/page-services-content"} /-->',
        ),
        'projects' => array(
            'title'   => 'Projects',
            'pattern' => '<!-- wp:pattern {"slug":"cinematic-interior/page-projects-content"} /-->',
        ),
        'contact'  => array(
            'title'   => 'Contact',
            'pattern' => '<!-- wp:pattern {"slug":"cinematic-interior/page-contact-content"} /-->',
        ),
    );

    foreach ( $pages as $slug => $data ) {
        $existing = get_page_by_path( $slug );
        if ( ! $existing ) {
            wp_insert_post( array(
                'post_title'     => $data['title'],
                'post_name'      => $slug,
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'post_content'   => $data['pattern'],
                'comment_status' => 'closed',
            ) );
        } elseif ( empty( trim( $existing->post_content ) ) ) {
            wp_update_post( array(
                'ID'           => $existing->ID,
                'post_content' => $data['pattern'],
            ) );
        }
    }
}
add_action( 'init', 'cinematic_interior_ensure_default_pages', 20 );

/**
 * Ensures newly added patterns are registered immediately without transient delay.
 */
function cinematic_interior_register_patterns() {
    if ( ! WP_Block_Patterns_Registry::get_instance()->is_registered( 'cinematic-interior/cinematic-scenarios' ) ) {
        $file = CINEMATIC_INTERIOR_THEME_DIR . '/patterns/cinematic-scenarios.php';
        if ( file_exists( $file ) ) {
            ob_start();
            include $file;
            $rendered = ob_get_clean();

            register_block_pattern(
                'cinematic-interior/cinematic-scenarios',
                array(
                    'title'       => __( 'Cinematic Scenarios Showcase', 'cinematic-interior' ),
                    'categories'  => array( 'cinematic-interior-showcase', 'nior-cinematic' ),
                    'content'     => $rendered,
                )
            );
        }
    }

    if ( ! WP_Block_Patterns_Registry::get_instance()->is_registered( 'cinematic-interior/hero-walkthrough-zoom' ) ) {
        $file = CINEMATIC_INTERIOR_THEME_DIR . '/patterns/hero-walkthrough-zoom.php';
        if ( file_exists( $file ) ) {
            ob_start();
            include $file;
            $rendered = ob_get_clean();

            register_block_pattern(
                'cinematic-interior/hero-walkthrough-zoom',
                array(
                    'title'       => __( 'Cinematic Walkthrough Zoom Hero', 'cinematic-interior' ),
                    'categories'  => array( 'cinematic-interior-showcase', 'nior-cinematic' ),
                    'content'     => $rendered,
                )
            );
        }
    }

    $projects_file = CINEMATIC_INTERIOR_THEME_DIR . '/patterns/page-projects-content.php';
    if ( file_exists( $projects_file ) ) {
        if ( WP_Block_Patterns_Registry::get_instance()->is_registered( 'cinematic-interior/page-projects-content' ) ) {
            unregister_block_pattern( 'cinematic-interior/page-projects-content' );
        }
        ob_start();
        include $projects_file;
        $projects_rendered = ob_get_clean();

        register_block_pattern(
            'cinematic-interior/page-projects-content',
            array(
                'title'       => __( 'Page Content — Projects Portfolio', 'cinematic-interior' ),
                'categories'  => array( 'cinematic-interior-pages', 'nior-pages' ),
                'content'     => $projects_rendered,
            )
        );
    }

    $services_file = CINEMATIC_INTERIOR_THEME_DIR . '/patterns/page-services-content.php';
    if ( file_exists( $services_file ) ) {
        if ( WP_Block_Patterns_Registry::get_instance()->is_registered( 'cinematic-interior/page-services-content' ) ) {
            unregister_block_pattern( 'cinematic-interior/page-services-content' );
        }
        ob_start();
        include $services_file;
        $services_rendered = ob_get_clean();

        register_block_pattern(
            'cinematic-interior/page-services-content',
            array(
                'title'       => __( 'Page Content — Services', 'cinematic-interior' ),
                'categories'  => array( 'cinematic-interior-pages', 'nior-pages' ),
                'content'     => $services_rendered,
            )
        );
    }
}
add_action( 'init', 'cinematic_interior_register_patterns', 25 );

/**
 * Dynamically resolves theme asset URLs inside template parts (e.g. Header logo)
 * ensuring seamless rendering across different environment directory names
 * (cinematic-interior vs nioratelier vs nioratelier-theme) and across local/production hosts.
 */
function cinematic_interior_filter_template_part_assets( $block_content, $block ) {
    if ( isset( $block['attrs']['slug'] ) && 'header' === $block['attrs']['slug'] ) {
        $theme_uri = esc_url( get_template_directory_uri() );
        $block_content = str_replace(
            array(
                '/wp-content/themes/cinematic-interior/assets/img/logo-cropped.webp',
                '/wp-content/themes/nioratelier/assets/img/logo-cropped.webp',
                '/wp-content/themes/nioratelier-theme/assets/img/logo-cropped.webp',
                'https://nioratelier.com/wp-content/themes/nioratelier/assets/img/logo-cropped.webp',
                'http://nioratelier.local/wp-content/themes/nioratelier-theme/assets/img/logo-cropped.webp',
            ),
            $theme_uri . '/assets/img/logo-cropped.webp',
            $block_content
        );
    }
    return $block_content;
}
add_filter( 'render_block_core_template_part', 'cinematic_interior_filter_template_part_assets', 10, 2 );

// Backward compatibility function aliases
if ( ! function_exists( 'nioratelier_setup' ) ) {
    function nioratelier_setup() {
        cinematic_interior_setup();
    }
}
if ( ! function_exists( 'nioratelier_enqueue_assets' ) ) {
    function nioratelier_enqueue_assets() {
        cinematic_interior_enqueue_assets();
    }
}
