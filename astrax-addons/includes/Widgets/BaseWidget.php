<?php
namespace AstraxAddons\Widgets;

use Elementor\Widget_Base;
use AstraxAddons\Utilities\SharedControlsTrait;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Abstract Base Widget class for all Astrax widgets.
 * Handles shared configuration, common categories, and standardized help URLs.
 */
abstract class BaseWidget extends Widget_Base {
	use SharedControlsTrait;

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'astrax-addons' ];
	}

	/**
	 * Load the shared Astrax component styles only when this widget is present.
	 *
	 * @return array<int, string>
	 */
	public function get_style_depends() {
		return [ 'astrax-v3-widgets' ];
	}

	/**
	 * Get widget help URL.
	 *
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://astrax.example.com/docs/widgets/' . $this->get_name();
	}

	/**
	 * Get normalized widget slug.
	 *
	 * @return string
	 */
	public function get_widget_slug() {
		return $this->get_name();
	}

	/**
	 * Get widget semantic version.
	 *
	 * @return string
	 */
	public function get_widget_version() {
		return defined( 'ASTRAX_ADDONS_VERSION' ) ? ASTRAX_ADDONS_VERSION : '1.0.0';
	}

	/**
	 * Get widget category identifier.
	 *
	 * @return string
	 */
	public function get_widget_category() {
		$cats = $this->get_categories();
		return ! empty( $cats[0] ) ? $cats[0] : 'astrax-addons';
	}

	/**
	 * Get unique widget instance ID.
	 *
	 * @return string
	 */
	public function get_unique_id() {
		return $this->get_id();
	}

	/**
	 * Helper function to safely output an HTML tag with attributes.
	 * Avoids XSS via esc_html and attribute escaping.
	 *
	 * @param string $tag           The HTML tag (e.g., 'div', 'h2').
	 * @param string $content       The inner content (already escaped or safe).
	 * @param array  $attributes    Array of key-value attributes.
	 */
	protected function render_html_tag( $tag, $content, $attributes = [] ) {
		// Ensure only safe tags are used.
		$safe_tags = [ 'div', 'span', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'a', 'img', 'section', 'article', 'ul', 'ol', 'li' ];
		if ( ! in_array( strtolower( $tag ), $safe_tags, true ) ) {
			$tag = 'div';
		}

		$attr_string = '';
		foreach ( $attributes as $key => $value ) {
			if ( is_array( $value ) ) {
				$value = implode( ' ', $value );
			}
			$attr_string .= sprintf( ' %s="%s"', sanitize_key( $key ), esc_attr( $value ) );
		}

		printf( '<%1$s%2$s>%3$s</%1$s>', esc_html( $tag ), $attr_string, $content );
	}

	/**
	 * Render standard wrapper element start.
	 *
	 * @param array $extra_classes Additional CSS classes.
	 */
	protected function render_wrapper_start( $extra_classes = [] ) {
		$classes = array_merge( [ 'astrax-widget', $this->get_name() ], (array) $extra_classes );
		$classes = array_map( 'sanitize_html_class', array_filter( $classes ) );
		$this->add_render_attribute( '_wrapper_container', 'class', implode( ' ', $classes ) );
		$this->add_render_attribute( '_wrapper_container', 'data-astrax-widget', $this->get_name() );
		printf( '<div %s>', $this->get_render_attribute_string( '_wrapper_container' ) );
	}

	/**
	 * Render standard wrapper element end.
	 */
	protected function render_wrapper_end() {
		echo '</div>';
	}

	/**
	 * Render accessible empty state when query or dynamic data produces zero items.
	 *
	 * @param string $message Notice message.
	 * @param string $icon    Elementor icon class.
	 */
	protected function render_empty_state( $message = '', $icon = 'eicon-alert' ) {
		if ( empty( $message ) ) {
			$message = esc_html__( 'No items found matching the current criteria.', 'astrax-addons' );
		}
		?>
		<div class="astrax-empty-state" role="status" aria-live="polite">
			<?php if ( ! empty( $icon ) ) : ?>
				<i class="<?php echo esc_attr( $icon ); ?> astrax-empty-state__icon" aria-hidden="true"></i>
			<?php endif; ?>
			<p class="astrax-empty-state__message"><?php echo esc_html( $message ); ?></p>
		</div>
		<?php
	}

	/**
	 * Render a link control safely with target and rel attributes.
	 *
	 * @param array  $link_settings Control value from URL control.
	 * @param string $content       Inner link HTML or text.
	 * @param string $class         CSS class name.
	 */
	protected function render_link( $link_settings, $content, $class = '' ) {
		if ( empty( $link_settings['url'] ) ) {
			echo $content;
			return;
		}

		$this->add_link_attributes( '_custom_link', $link_settings );
		if ( ! empty( $class ) ) {
			$this->add_render_attribute( '_custom_link', 'class', sanitize_html_class( $class ) );
		}

		printf( '<a %s>%s</a>', $this->get_render_attribute_string( '_custom_link' ), $content );
	}
}
