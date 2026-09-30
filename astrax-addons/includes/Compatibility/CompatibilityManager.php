<?php
namespace AstraxAddons\Compatibility;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Validates dependencies before allowing the plugin to run.
 */
class CompatibilityManager {
	const MIN_PHP_VERSION       = '7.4';
	const MIN_WP_VERSION        = '6.0';
	const MIN_ELEMENTOR_VERSION = '3.16';

	/**
	 * Run checks.
	 *
	 * @return bool True if compatible, false otherwise.
	 */
	public function is_compatible() {
		$errors = [];

		// Check PHP Version
		if ( version_compare( PHP_VERSION, self::MIN_PHP_VERSION, '<' ) ) {
			$errors[] = sprintf(
				/* translators: %s: Minimum PHP version. */
				esc_html__( 'Astrax Addons requires PHP version %s or greater.', 'astrax-addons' ),
				self::MIN_PHP_VERSION
			);
		}

		// Check WordPress Version
		if ( version_compare( get_bloginfo( 'version' ), self::MIN_WP_VERSION, '<' ) ) {
			$errors[] = sprintf(
				/* translators: %s: Minimum WordPress version. */
				esc_html__( 'Astrax Addons requires WordPress version %s or greater.', 'astrax-addons' ),
				self::MIN_WP_VERSION
			);
		}

		// Check if Elementor is installed and active
		if ( ! did_action( 'elementor/loaded' ) ) {
			$errors[] = esc_html__( 'Astrax Addons requires Elementor to be installed and activated.', 'astrax-addons' );
		} elseif ( ! defined( 'ELEMENTOR_VERSION' ) || version_compare( ELEMENTOR_VERSION, self::MIN_ELEMENTOR_VERSION, '<' ) ) {
			$errors[] = sprintf(
				/* translators: %s: Minimum Elementor version. */
				esc_html__( 'Astrax Addons requires Elementor version %s or greater.', 'astrax-addons' ),
				self::MIN_ELEMENTOR_VERSION
			);
		}

		if ( ! empty( $errors ) ) {
			$this->add_admin_notices( $errors );
			return false;
		}

		return true;
	}

	/**
	 * Add admin notices for compatibility failures.
	 *
	 * @param array $errors Array of error strings.
	 */
	private function add_admin_notices( array $errors ) {
		add_action( 'admin_notices', function() use ( $errors ) {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}
			$message = implode( '<br>', $errors );
			echo '<div class="notice notice-error"><p><strong>' . esc_html__( 'Astrax Addons:', 'astrax-addons' ) . '</strong><br>' . wp_kses_post( $message ) . '</p></div>';
		} );
	}
}
