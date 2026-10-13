<?php
namespace CinematicInterior\Licensing;

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/WebWizBD_License_Client.php';

/**
 * Cinematic Interior Theme Licensing Controller.
 *
 * Integrates WebWizBD License Client SDK, enforces Site Editor lock when unlicensed,
 * registers the Appearance > Theme License admin page, and gates theme updates.
 *
 * @package CinematicInterior\Licensing
 * @since 1.6.0
 */
class Theme_Licensing {

	const PRODUCT_SLUG = 'cinematic-interior';
	const OPTION_NAME  = 'cinematic_interior_license';
	const LOG_OPTION   = 'cinematic_interior_license_log';

	/**
	 * Singleton instance.
	 *
	 * @var Theme_Licensing|null
	 */
	private static $instance = null;

	/**
	 * WebWizBD License Client.
	 *
	 * @var \WebWizBD_License_Client
	 */
	private $client;

	/**
	 * Get singleton instance.
	 *
	 * @return Theme_Licensing
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		$api_url = defined( 'CINEMATIC_INTERIOR_LICENSE_API_URL' )
			? CINEMATIC_INTERIOR_LICENSE_API_URL
			: ( defined( 'NIOR_LICENSE_API_URL' ) ? NIOR_LICENSE_API_URL : 'https://license.webwizbd.com/wp-json/webwizbd-license/v1' );

		$theme_version = defined( 'CINEMATIC_INTERIOR_VERSION' )
			? CINEMATIC_INTERIOR_VERSION
			: ( defined( 'NIOR_VERSION' ) ? NIOR_VERSION : '1.6.0' );

		$config = apply_filters(
			'cinematic_interior_license_config',
			array(
				'api_url'               => $api_url,
				'product_slug'          => self::PRODUCT_SLUG,
				'item_type'             => 'theme',
				'theme_slug'            => 'cinematic-interior',
				'version'               => $theme_version,
				'verification_interval' => 12,
				'grace_period_hours'    => 72,
				'option_name'           => self::OPTION_NAME,
				'logger'                => array( $this, 'log' ),
			)
		);

		$this->client = new \WebWizBD_License_Client( $config );
	}

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function init() {
		$this->client->init();

		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
			add_action( 'admin_init', array( $this, 'handle_license_actions' ), 5 );
			add_action( 'admin_init', array( $this, 'enforce_editor_lock' ), 10 );
			add_action( 'admin_notices', array( $this, 'render_admin_notices' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
			add_filter( 'theme_action_links_cinematic-interior', array( $this, 'add_theme_action_links' ) );
			add_filter( 'theme_action_links_nioratelier', array( $this, 'add_theme_action_links' ) );
		}
	}

	/**
	 * Access the underlying SDK client.
	 *
	 * @return \WebWizBD_License_Client
	 */
	public function client() {
		return $this->client;
	}

	/**
	 * Whether the theme has an active or grace-period license.
	 *
	 * @return bool
	 */
	public function is_licensed() {
		return $this->client->is_valid();
	}

	/**
	 * Whether the theme can receive updates and downloads.
	 *
	 * @return bool
	 */
	public function can_receive_updates() {
		return $this->client->can_receive_updates();
	}

	/**
	 * Get normalized status.
	 *
	 * @return string
	 */
	public function get_status() {
		return $this->client->get_effective_status();
	}

	/**
	 * Register Appearance > Theme License admin menu item.
	 *
	 * @return void
	 */
	public function register_admin_menu() {
		add_theme_page(
			__( 'Cinematic Interior License', 'cinematic-interior' ),
			__( 'Theme License', 'cinematic-interior' ),
			'manage_options',
			'cinematic-interior-license',
			array( $this, 'render_license_page' )
		);
	}

	/**
	 * Enqueue scoped styles on the Theme License admin page.
	 *
	 * @param string $hook_suffix Admin hook suffix.
	 * @return void
	 */
	public function enqueue_admin_assets( $hook_suffix ) {
		if ( 'appearance_page_cinematic-interior-license' !== $hook_suffix && 'appearance_page_nioratelier-license' !== $hook_suffix ) {
			return;
		}

		$theme_uri     = defined( 'CINEMATIC_INTERIOR_THEME_URI' ) ? CINEMATIC_INTERIOR_THEME_URI : get_template_directory_uri();
		$theme_version = defined( 'CINEMATIC_INTERIOR_VERSION' ) ? CINEMATIC_INTERIOR_VERSION : '1.6.0';

		wp_enqueue_style(
			'cinematic-interior-admin-license',
			$theme_uri . '/assets/css/admin-license.css',
			array(),
			$theme_version
		);
	}

	/**
	 * Strict Lock: Enforces restriction on the Site Editor and Template screens
	 * when the theme is unlicensed or expired.
	 *
	 * @return void
	 */
	public function enforce_editor_lock() {
		if ( ! is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
			return;
		}

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		if ( $this->is_licensed() ) {
			return;
		}

		global $pagenow;

		$is_site_editor = 'site-editor.php' === $pagenow
			|| ( isset( $_GET['page'] ) && 'site-editor' === sanitize_key( wp_unslash( $_GET['page'] ) ) );

		$is_template_editor = ( 'edit.php' === $pagenow || 'post.php' === $pagenow || 'post-new.php' === $pagenow )
			&& isset( $_GET['post_type'] )
			&& in_array( sanitize_key( wp_unslash( $_GET['post_type'] ) ), array( 'wp_template', 'wp_template_part', 'wp_navigation' ), true );

		if ( $is_site_editor || $is_template_editor ) {
			wp_safe_redirect(
				add_query_arg(
					array(
						'page'           => 'cinematic-interior-license',
						'license_notice' => 'editor_locked',
					),
					admin_url( 'themes.php' )
				)
			);
			exit;
		}
	}

	/**
	 * Render contextual admin notice across WP Admin when unlicensed.
	 *
	 * @return void
	 */
	public function render_admin_notices() {
		if ( ! current_user_can( 'manage_options' ) || ! is_admin() ) {
			return;
		}

		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( $screen && in_array( $screen->id, array( 'appearance_page_cinematic-interior-license', 'appearance_page_nioratelier-license' ), true ) ) {
			return;
		}

		$status = $this->get_status();
		if ( 'active' === $status ) {
			return;
		}

		$license_url  = admin_url( 'themes.php?page=cinematic-interior-license' );
		$contact_base = apply_filters( 'cinematic_interior_contact_url', 'https://webwizbd.com/contact' );
		$contact_url  = add_query_arg(
			array(
				'theme'  => 'cinematic-interior',
				'domain' => $this->client->get_domain(),
				'ref'    => 'admin_notice',
			),
			$contact_base
		);

		if ( 'unlicensed' === $status ) {
			$title   = __( 'Cinematic Interior — License Required', 'cinematic-interior' );
			$message = __( 'Please activate your license to unlock the Full Site Editor, architectural block patterns, and automatic updates.', 'cinematic-interior' );
			$class   = 'notice notice-warning is-dismissible';
		} elseif ( 'expired' === $status ) {
			$title   = __( 'Cinematic Interior — License Expired', 'cinematic-interior' );
			$message = __( 'Your license has expired. Site Editor customization and automatic updates are restricted until renewed.', 'cinematic-interior' );
			$class   = 'notice notice-error';
		} elseif ( 'offline_grace' === $status ) {
			$title   = __( 'Cinematic Interior — Offline Grace Mode', 'cinematic-interior' );
			$message = __( 'Unable to reach the license server. Running in offline grace period.', 'cinematic-interior' );
			$class   = 'notice notice-info';
		} else {
			$title   = __( 'Cinematic Interior — License Inactive', 'cinematic-interior' );
			$message = __( 'Your license status requires attention. Site Editor customization and automatic updates are paused.', 'cinematic-interior' );
			$class   = 'notice notice-warning';
		}

		printf(
			'<div class="%1$s"><p><strong>%2$s:</strong> %3$s <a href="%4$s" class="button button-small" style="margin-left: 8px;">%5$s</a> <a href="%6$s" target="_blank" rel="noopener noreferrer" class="button button-small" style="margin-left: 4px;">%7$s &rarr;</a></p></div>',
			esc_attr( $class ),
			esc_html( $title ),
			esc_html( $message ),
			esc_url( $license_url ),
			esc_html__( 'Manage License', 'cinematic-interior' ),
			esc_url( $contact_url ),
			esc_html__( 'Get License Key', 'cinematic-interior' )
		);
	}

	/**
	 * Process form actions (activate, deactivate, refresh, clear diagnostics).
	 *
	 * @return void
	 */
	public function handle_license_actions() {
		$action_key = ! empty( $_POST['cinematic_interior_license_action'] )
			? 'cinematic_interior_license_action'
			: ( ! empty( $_POST['nioratelier_license_action'] ) ? 'nioratelier_license_action' : '' );

		if ( empty( $action_key ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Unauthorized access.', 'cinematic-interior' ) );
		}

		if ( 'cinematic_interior_license_action' === $action_key ) {
			check_admin_referer( 'cinematic_interior_license_action', 'cinematic_interior_license_nonce' );
		} else {
			check_admin_referer( 'nioratelier_license_action', 'nioratelier_license_nonce' );
		}

		$action   = sanitize_key( wp_unslash( $_POST[ $action_key ] ) );
		$response = array(
			'success' => false,
			'message' => __( 'Unknown license action.', 'cinematic-interior' ),
		);

		if ( 'activate' === $action ) {
			$key      = isset( $_POST['license_key'] ) ? sanitize_text_field( wp_unslash( $_POST['license_key'] ) ) : '';
			$response = $this->client->activate( $key );
		} elseif ( 'reactivate_stored' === $action ) {
			$data     = $this->client->get_license_data();
			$key      = isset( $data['license_key'] ) ? sanitize_text_field( $data['license_key'] ) : '';
			$response = $this->client->activate( $key );
		} elseif ( 'deactivate' === $action ) {
			$response = $this->client->deactivate();
		} elseif ( 'refresh' === $action ) {
			$response = $this->client->verify_license( true );
		} elseif ( 'clear_debug' === $action ) {
			$this->client->clear_debug_data();
			$response = array(
				'success' => true,
				'message' => __( 'License diagnostics cleared.', 'cinematic-interior' ),
			);
		} elseif ( 'download_latest' === $action ) {
			$response = $this->client->get_latest_download_url();
			if ( ! empty( $response['success'] ) && ! empty( $response['data']['download_url'] ) ) {
				$this->log( 'Direct theme package download requested.' );
				wp_safe_redirect( esc_url_raw( $response['data']['download_url'] ) );
				exit;
			}
		}

		$type = ! empty( $response['success'] ) ? 'success' : 'error';

		wp_safe_redirect(
			add_query_arg(
				array(
					'page'            => 'cinematic-interior-license',
					'license_message' => rawurlencode( $response['message'] ?? __( 'License action completed.', 'cinematic-interior' ) ),
					'license_type'    => $type,
				),
				admin_url( 'themes.php' )
			)
		);
		exit;
	}

	/**
	 * Add "License" action link to theme list.
	 *
	 * @param array $links Action links.
	 * @return array
	 */
	public function add_theme_action_links( $links ) {
		$links['license'] = '<a href="' . esc_url( admin_url( 'themes.php?page=cinematic-interior-license' ) ) . '">' . esc_html__( 'License', 'cinematic-interior' ) . '</a>';
		return $links;
	}

	/**
	 * Render the Theme License view.
	 *
	 * @return void
	 */
	public function render_license_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'cinematic-interior' ) );
		}

		$client     = $this->client;
		$data       = $client->get_license_data();
		$debug      = $client->get_debug_data();
		$status     = $client->get_effective_status();
		$is_valid   = $client->is_valid();
		$domain     = $client->get_domain();
		$logs       = $this->get_logs();

		require __DIR__ . '/views/license-page.php';
	}

	/**
	 * Add an event to the local log buffer.
	 *
	 * @param string $message Log message.
	 * @return void
	 */
	public function log( $message ) {
		$logs = $this->get_logs();
		array_unshift(
			$logs,
			array(
				'time'    => time(),
				'message' => sanitize_text_field( $message ),
			)
		);
		$logs = array_slice( $logs, 0, 50 );
		update_option( self::LOG_OPTION, $logs, false );
	}

	/**
	 * Retrieve recent log entries.
	 *
	 * @return array
	 */
	public function get_logs() {
		$logs = get_option( self::LOG_OPTION, array() );
		return is_array( $logs ) ? $logs : array();
	}
}

// Backward compatibility alias
if ( ! class_exists( 'NiorAtelier\Licensing\Theme_Licensing' ) ) {
	class_alias( __NAMESPACE__ . '\Theme_Licensing', 'NiorAtelier\Licensing\Theme_Licensing' );
}
