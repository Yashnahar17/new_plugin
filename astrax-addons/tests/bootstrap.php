<?php
/**
 * PHPUnit Test Bootstrap
 */

namespace {
	if ( ! defined( 'ABSPATH' ) ) {
		define( 'ABSPATH', dirname( __DIR__ ) . '/' );
	}

	// Autoload composer
	require_once __DIR__ . '/../vendor/autoload.php';

	// Mock WordPress functions if not defined
	if ( ! function_exists( 'esc_html__' ) ) {
		function esc_html__( $text, $domain = 'default' ) {
			return $text;
		}
	}

	if ( ! function_exists( 'esc_html' ) ) {
		function esc_html( $text ) {
			return htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' );
		}
	}

	if ( ! function_exists( 'esc_attr' ) ) {
		function esc_attr( $text ) {
			return htmlspecialchars( (string) $text, ENT_QUOTES, 'UTF-8' );
		}
	}

	if ( ! function_exists( 'sanitize_key' ) ) {
		function sanitize_key( $key ) {
			return preg_replace( '/[^a-z0-9_\-]/', '', strtolower( (string) $key ) );
		}
	}

	if ( ! function_exists( 'wp_kses' ) ) {
		function wp_kses( $string, $allowed_html ) {
			return strip_tags( (string) $string, '<' . implode( '><', array_keys( $allowed_html ) ) . '>' );
		}
	}

	if ( ! function_exists( 'add_action' ) ) {
		function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
	}

	if ( ! function_exists( 'add_filter' ) ) {
		function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
	}

	if ( ! function_exists( 'apply_filters' ) ) {
		function apply_filters( $hook, $value ) {
			return $value;
		}
	}

	if ( ! function_exists( 'plugins_url' ) ) {
		function plugins_url( $path = '', $plugin = '' ) {
			return 'https://example.com/wp-content/plugins/astrax-addons/' . ltrim( $path, '/' );
		}
	}

	if ( ! function_exists( 'absint' ) ) {
		function absint( $maybeint ) {
			return abs( (int) $maybeint );
		}
	}
}

namespace Elementor {
	if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
		abstract class Widget_Base {
			protected $settings = [];
			protected $render_attributes = [];

			abstract public function get_name();
			abstract public function get_title();
			abstract public function get_icon();

			public function get_categories() {
				return [ 'general' ];
			}

			public function get_style_depends() {
				return [];
			}

			public function get_script_depends() {
				return [];
			}

			public function add_render_attribute( $element, $key = null, $value = null, $overwrite = false ) {
				if ( is_array( $element ) ) {
					foreach ( $element as $el => $data ) {
						foreach ( $data as $attribute => $val ) {
							$this->add_render_attribute( $el, $attribute, $val, $overwrite );
						}
					}
					return $this;
				}
				if ( empty( $this->render_attributes[ $element ][ $key ] ) ) {
					$this->render_attributes[ $element ][ $key ] = [];
				}
				if ( is_array( $value ) ) {
					$this->render_attributes[ $element ][ $key ] = array_merge( $this->render_attributes[ $element ][ $key ], $value );
				} else {
					$this->render_attributes[ $element ][ $key ][] = $value;
				}
				return $this;
			}

			public function get_render_attribute_string( $element ) {
				if ( empty( $this->render_attributes[ $element ] ) ) {
					return '';
				}
				$html = [];
				foreach ( $this->render_attributes[ $element ] as $attr => $values ) {
					$html[] = sprintf( '%s="%s"', $attr, esc_attr( implode( ' ', $values ) ) );
				}
				return implode( ' ', $html );
			}

			public function print_render_attribute_string( $element ) {
				echo $this->get_render_attribute_string( $element );
			}

			public function add_link_attributes( $element, array $url_control, $overwrite = false ) {
				if ( ! empty( $url_control['url'] ) ) {
					$this->add_render_attribute( $element, 'href', $url_control['url'], $overwrite );
				}
				return $this;
			}
		}

		class Controls_Manager {
			const TAB_CONTENT = 'content';
			const TAB_STYLE = 'style';
			const TAB_ADVANCED = 'advanced';
			const TEXT = 'text';
			const TEXTAREA = 'textarea';
			const SELECT = 'select';
			const URL = 'url';
			const COLOR = 'color';
			const CHOOSE = 'choose';
			const ICONS = 'icons';
			const MEDIA = 'media';
			const REPEATER = 'repeater';
			const SLIDER = 'slider';
			const SWITCHER = 'switcher';
		}

		class Group_Control_Typography {
			public static function get_type() {
				return 'typography';
			}
		}

		class Group_Control_Image_Size {
			public static function get_type() {
				return 'image-size';
			}
			public static function get_attachment_image_html( $settings, $image_key = 'image' ) {
				return '<img src="https://example.com/placeholder.jpg" alt="" />';
			}
		}

		class Icons_Manager {
			public static function render_icon( $icon, $attributes = [], $tag = 'i' ) {
				echo '<i class="fa fa-star" aria-hidden="true"></i>';
			}
		}

		class Repeater {
			public function add_control( $id, array $args = [] ) {}
		}

		class Utils {
			public static function get_placeholder_image_src() {
				return 'https://example.com/placeholder.jpg';
			}
		}
	}
}
