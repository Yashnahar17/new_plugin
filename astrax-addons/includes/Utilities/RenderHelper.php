<?php
namespace AstraxAddons\Utilities;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render Helper for safe escaping and structural HTML logic.
 */
class RenderHelper {

	/**
	 * Allows standard typography tags for rich text inputs.
	 *
	 * @param string $text Unsafe text.
	 * @return string Safe text.
	 */
	public static function esc_rich_text( $text ) {
		$allowed = [
			'b'      => [],
			'strong' => [],
			'i'      => [],
			'em'     => [],
			'u'      => [],
			'br'     => [],
			'span'   => [
				'class' => [],
				'style' => [],
			],
			'a'      => [
				'href'   => [],
				'title'  => [],
				'target' => [],
				'rel'    => [],
			],
		];
		return wp_kses( $text, $allowed );
	}

	/**
	 * Safely generates inline style strings from arrays.
	 *
	 * @param array $styles Associative array of CSS properties and values.
	 * @return string Safe style string.
	 */
	public static function generate_inline_styles( array $styles ) {
		$output = '';
		foreach ( $styles as $prop => $value ) {
			if ( '' !== $value && null !== $value ) {
				// Sanitize the property and escape the attribute value.
				$output .= sanitize_key( $prop ) . ':' . esc_attr( $value ) . ';';
			}
		}
		return $output;
	}
}
