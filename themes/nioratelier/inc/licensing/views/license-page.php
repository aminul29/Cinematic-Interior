<?php
/**
 * Nior Atelier License Admin View.
 *
 * @package NiorAtelier\Licensing
 * @var \WebWizBD_License_Client $client
 * @var array                    $data
 * @var array                    $debug
 * @var string                   $status
 * @var bool                     $is_valid
 * @var string                   $domain
 * @var array                    $logs
 */

defined( 'ABSPATH' ) || exit;

// Mask stored key for secure display
$stored_key = ! empty( $data['license_key'] ) ? $data['license_key'] : '';
$masked_key = '';
if ( ! empty( $stored_key ) ) {
	$len = strlen( $stored_key );
	if ( $len > 8 ) {
		$masked_key = substr( $stored_key, 0, 4 ) . '-' . str_repeat( '•', max( 4, $len - 10 ) ) . '-' . substr( $stored_key, -4 );
	} else {
		$masked_key = '••••-••••';
	}
}

// Notice handling from query params
$notice_code    = isset( $_GET['license_notice'] ) ? sanitize_key( wp_unslash( $_GET['license_notice'] ) ) : '';
$notice_message = isset( $_GET['license_message'] ) ? sanitize_text_field( wp_unslash( rawurldecode( $_GET['license_message'] ) ) ) : '';
$notice_type    = isset( $_GET['license_type'] ) && 'success' === $_GET['license_type'] ? 'success' : 'error';
?>

<div class="wrap nior-license-wrap">
	<div class="nior-license-header">
		<div class="nior-license-brand">
			<span class="nior-license-eyebrow"><?php esc_html_e( 'Nior Atelier Studio', 'nioratelier' ); ?></span>
			<h1><?php esc_html_e( 'Theme License & Entitlements', 'nioratelier' ); ?></h1>
		</div>
		<div class="nior-license-badge-version">
			<?php esc_html_e( 'v', 'nioratelier' ); ?><?php echo esc_html( defined( 'NIOR_VERSION' ) ? NIOR_VERSION : '1.6.0' ); ?>
		</div>
	</div>

	<?php if ( 'editor_locked' === $notice_code ) : ?>
		<div class="notice notice-error nior-notice-locked">
			<p>
				<strong><?php esc_html_e( 'Site Editor Access Restricted:', 'nioratelier' ); ?></strong>
				<?php esc_html_e( 'The Full Site Editor and architectural template controls require an active Nior Atelier license. Please activate your key below to unlock customization.', 'nioratelier' ); ?>
			</p>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $notice_message ) ) : ?>
		<div class="notice notice-<?php echo esc_attr( $notice_type ); ?> is-dismissible">
			<p><?php echo esc_html( $notice_message ); ?></p>
		</div>
	<?php endif; ?>

	<div class="nior-license-grid">
		<!-- Left Card: License Activation / Management -->
		<div class="nior-card nior-card-primary">
			<div class="nior-card-header">
				<h2><?php esc_html_e( 'License Activation', 'nioratelier' ); ?></h2>
				<span class="nior-status-pill nior-status-<?php echo esc_attr( $status ); ?>">
					<?php
					switch ( $status ) {
						case 'active':
							esc_html_e( 'Active & Verified', 'nioratelier' );
							break;
						case 'grace':
						case 'offline_grace':
							esc_html_e( 'Grace Period', 'nioratelier' );
							break;
						case 'expired':
							esc_html_e( 'License Expired', 'nioratelier' );
							break;
						case 'wrong_domain':
							esc_html_e( 'Unregistered Domain', 'nioratelier' );
							break;
						case 'activation_limit':
							esc_html_e( 'Activation Limit Reached', 'nioratelier' );
							break;
						default:
							esc_html_e( 'Unlicensed', 'nioratelier' );
							break;
					}
					?>
				</span>
			</div>

			<div class="nior-card-body">
				<?php if ( ! $is_valid || empty( $stored_key ) ) : ?>
					<p class="nior-card-lead">
						<?php esc_html_e( 'Enter your license key below to unlock automatic updates, Full Site Editor customization, and premium design patterns.', 'nioratelier' ); ?>
					</p>

					<form method="post" action="<?php echo esc_url( admin_url( 'themes.php?page=nioratelier-license' ) ); ?>" class="nior-license-form">
						<?php wp_nonce_field( 'nioratelier_license_action', 'nioratelier_license_nonce' ); ?>
						<input type="hidden" name="nioratelier_license_action" value="activate" />

						<div class="nior-form-field">
							<label for="nior-license-key"><?php esc_html_e( 'License Key', 'nioratelier' ); ?></label>
							<input
								type="text"
								id="nior-license-key"
								name="license_key"
								class="regular-text code"
								placeholder="WWBD-XXXX-XXXX-XXXX-XXXX"
								value="<?php echo esc_attr( $stored_key ); ?>"
								required
								autocomplete="off"
								spellcheck="false"
							/>
							<span class="description">
								<?php esc_html_e( 'Format: WWBD-XXXX-XXXX-XXXX-XXXX. Found in your purchase receipt or WebWizBD account.', 'nioratelier' ); ?>
							</span>
						</div>

						<div class="nior-form-actions">
							<button type="submit" class="button button-primary button-hero">
								<?php esc_html_e( 'Activate License', 'nioratelier' ); ?>
							</button>
						</div>
					</form>
				<?php else : ?>
					<div class="nior-active-state">
						<div class="nior-key-display">
							<span class="nior-key-label"><?php esc_html_e( 'Activated Key:', 'nioratelier' ); ?></span>
							<code class="nior-key-code"><?php echo esc_html( $masked_key ); ?></code>
						</div>

						<p class="nior-active-desc">
							<?php esc_html_e( 'Your license is currently linked to this domain. Full Site Editor access and automated theme updates are enabled.', 'nioratelier' ); ?>
						</p>

						<div class="nior-actions-toolbar">
							<!-- Refresh / Verify Action -->
							<form method="post" action="<?php echo esc_url( admin_url( 'themes.php?page=nioratelier-license' ) ); ?>" class="inline-form">
								<?php wp_nonce_field( 'nioratelier_license_action', 'nioratelier_license_nonce' ); ?>
								<input type="hidden" name="nioratelier_license_action" value="refresh" />
								<button type="submit" class="button button-secondary">
									<?php esc_html_e( 'Check Now', 'nioratelier' ); ?>
								</button>
							</form>

							<!-- Direct Latest Download -->
							<form method="post" action="<?php echo esc_url( admin_url( 'themes.php?page=nioratelier-license' ) ); ?>" class="inline-form">
								<?php wp_nonce_field( 'nioratelier_license_action', 'nioratelier_license_nonce' ); ?>
								<input type="hidden" name="nioratelier_license_action" value="download_latest" />
								<button type="submit" class="button button-secondary">
									<?php esc_html_e( 'Download Latest ZIP', 'nioratelier' ); ?>
								</button>
							</form>

							<!-- Deactivate Action -->
							<form method="post" action="<?php echo esc_url( admin_url( 'themes.php?page=nioratelier-license' ) ); ?>" class="inline-form" onsubmit="return confirm('<?php echo esc_js( __( 'Are you sure you want to deactivate this license? Site Editor access will be locked.', 'nioratelier' ) ); ?>');">
								<?php wp_nonce_field( 'nioratelier_license_action', 'nioratelier_license_nonce' ); ?>
								<input type="hidden" name="nioratelier_license_action" value="deactivate" />
								<button type="submit" class="button button-link-delete">
									<?php esc_html_e( 'Deactivate', 'nioratelier' ); ?>
								</button>
							</form>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<!-- Right Card: Entitlement & Domain Details -->
		<div class="nior-card nior-card-secondary">
			<div class="nior-card-header">
				<h2><?php esc_html_e( 'Installation Details', 'nioratelier' ); ?></h2>
			</div>

			<div class="nior-card-body">
				<table class="nior-details-table">
					<tr>
						<th><?php esc_html_e( 'Active Domain', 'nioratelier' ); ?></th>
						<td><code><?php echo esc_html( $domain ); ?></code></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Site Editor Access', 'nioratelier' ); ?></th>
						<td>
							<?php if ( $is_valid ) : ?>
								<span class="nior-pill-success"><?php esc_html_e( 'Unlocked', 'nioratelier' ); ?></span>
							<?php else : ?>
								<span class="nior-pill-danger"><?php esc_html_e( 'Restricted', 'nioratelier' ); ?></span>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Automatic Updates', 'nioratelier' ); ?></th>
						<td>
							<?php if ( $client->can_receive_updates() ) : ?>
								<span class="nior-pill-success"><?php esc_html_e( 'Active', 'nioratelier' ); ?></span>
							<?php else : ?>
								<span class="nior-pill-warning"><?php esc_html_e( 'Disabled', 'nioratelier' ); ?></span>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'License Expiration', 'nioratelier' ); ?></th>
						<td>
							<?php
							if ( ! empty( $data['expires_at'] ) ) {
								echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $data['expires_at'] ) ) );
							} else {
								esc_html_e( 'Lifetime / No Expiry', 'nioratelier' );
							}
							?>
						</td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Activations', 'nioratelier' ); ?></th>
						<td>
							<?php
							if ( isset( $data['activations'] ) && isset( $data['activation_limit'] ) ) {
								echo esc_html( sprintf( '%d / %s', $data['activations'], $data['activation_limit'] ?: __( 'Unlimited', 'nioratelier' ) ) );
							} else {
								echo esc_html( '1 / 1' );
							}
							?>
						</td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Last Verification', 'nioratelier' ); ?></th>
						<td>
							<?php
							if ( ! empty( $data['verified_at'] ) ) {
								echo esc_html( human_time_diff( (int) $data['verified_at'], time() ) . ' ' . __( 'ago', 'nioratelier' ) );
							} else {
								esc_html_e( 'Never', 'nioratelier' );
							}
							?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<!-- Diagnostics & Logs Collapsible -->
	<div class="nior-diagnostics-box">
		<details>
			<summary><?php esc_html_e( 'Technical Diagnostics & Sync History', 'nioratelier' ); ?></summary>
			<div class="nior-diagnostics-inner">
				<div class="nior-diagnostics-meta">
					<p><strong><?php esc_html_e( 'Server Endpoint:', 'nioratelier' ); ?></strong> <code>https://license.webwizbd.com/wp-json/webwizbd-license/v1</code></p>
					<?php if ( ! empty( $debug['client_request_id'] ) ) : ?>
						<p><strong><?php esc_html_e( 'Last Request ID:', 'nioratelier' ); ?></strong> <code><?php echo esc_html( $debug['client_request_id'] ); ?></code></p>
					<?php endif; ?>
					<?php if ( ! empty( $data['last_error'] ) ) : ?>
						<p class="nior-text-danger"><strong><?php esc_html_e( 'Last Reported Error:', 'nioratelier' ); ?></strong> <?php echo esc_html( $data['last_error'] ); ?> (<code><?php echo esc_html( $data['last_code'] ?? 'error' ); ?></code>)</p>
					<?php endif; ?>
				</div>

				<?php if ( ! empty( $logs ) ) : ?>
					<h4><?php esc_html_e( 'Recent Activity Logs', 'nioratelier' ); ?></h4>
					<ul class="nior-logs-list">
						<?php foreach ( array_slice( $logs, 0, 10 ) as $log ) : ?>
							<li>
								<span class="nior-log-time"><?php echo esc_html( date_i18n( 'Y-m-d H:i:s', $log['time'] ?? time() ) ); ?></span>
								<span class="nior-log-msg"><?php echo esc_html( $log['message'] ?? '' ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<form method="post" action="<?php echo esc_url( admin_url( 'themes.php?page=nioratelier-license' ) ); ?>" style="margin-top: 15px;">
					<?php wp_nonce_field( 'nioratelier_license_action', 'nioratelier_license_nonce' ); ?>
					<input type="hidden" name="nioratelier_license_action" value="clear_debug" />
					<button type="submit" class="button button-small">
						<?php esc_html_e( 'Clear Diagnostic Cache', 'nioratelier' ); ?>
					</button>
				</form>
			</div>
		</details>
	</div>
</div>
