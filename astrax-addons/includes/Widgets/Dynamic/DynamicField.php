<?php
namespace AstraxAddons\Widgets\Dynamic;

use Elementor\Controls_Manager;
use AstraxAddons\Widgets\BaseWidget;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dynamic Field Widget.
 */
class DynamicField extends BaseWidget {

	public function get_name() {
		return 'astrax-dynamic-field';
	}

	public function get_title() {
		return esc_html__( 'Dynamic Field', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-text';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_dynamic',
			[
				'label' => esc_html__( 'Dynamic Field', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'field_source', [
			'label'   => esc_html__( 'Source', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'post_title',
			'options' => [
				'post_title'   => esc_html__( 'Post Title', 'astrax-addons' ),
				'post_excerpt' => esc_html__( 'Post Excerpt', 'astrax-addons' ),
				'post_content' => esc_html__( 'Post Content', 'astrax-addons' ),
				'post_date'    => esc_html__( 'Post Date', 'astrax-addons' ),
				'author_name'  => esc_html__( 'Author Name', 'astrax-addons' ),
				'custom_meta'  => esc_html__( 'Custom Meta (ACF/Post Meta)', 'astrax-addons' ),
			],
		] );

		$this->add_control( 'meta_key', [
			'label'     => esc_html__( 'Meta Key', 'astrax-addons' ),
			'type'      => Controls_Manager::TEXT,
			'condition' => [
				'field_source' => 'custom_meta',
			],
		] );

		$this->add_control( 'before_text', [
			'label'   => esc_html__( 'Before', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '',
		] );

		$this->add_control( 'after_text', [
			'label'   => esc_html__( 'After', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '',
		] );

		$this->add_control( 'fallback_text', [
			'label'   => esc_html__( 'Fallback', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '',
		] );

		$this->add_html_tag_control( 'html_tag', 'div' );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$source = $settings['field_source'];
		$value = '';

		global $post;

		if ( ! $post ) {
			$value = esc_html__( 'No post found.', 'astrax-addons' );
		} else {
			switch ( $source ) {
				case 'post_title':
					$value = get_the_title( $post );
					break;
				case 'post_excerpt':
					$value = has_excerpt( $post->ID ) ? get_the_excerpt( $post ) : wp_trim_words( $post->post_content, 55 );
					break;
				case 'post_content':
					$value = apply_filters( 'the_content', $post->post_content );
					break;
				case 'post_date':
					$value = get_the_date( '', $post );
					break;
				case 'author_name':
					$value = get_the_author_meta( 'display_name', $post->post_author );
					break;
				case 'custom_meta':
					if ( ! empty( $settings['meta_key'] ) ) {
						// Check ACF first if available, otherwise get_post_meta
						if ( function_exists( 'get_field' ) ) {
							$value = get_field( $settings['meta_key'], $post->ID );
						}
						
						if ( empty( $value ) ) {
							$value = get_post_meta( $post->ID, $settings['meta_key'], true );
						}
					}
					break;
			}
		}

		if ( empty( $value ) && ! empty( $settings['fallback_text'] ) ) {
			$value = $settings['fallback_text'];
		}

		if ( empty( $value ) ) {
			return;
		}

		$output = '';
		if ( ! empty( $settings['before_text'] ) ) {
			$output .= '<span class="astrax-dynamic-field-before">' . esc_html( $settings['before_text'] ) . '</span> ';
		}

		// Security: Output depends on source type
		if ( 'post_content' === $source ) {
			$output .= '<span class="astrax-dynamic-field-value">' . wp_kses_post( $value ) . '</span>';
		} else {
			$output .= '<span class="astrax-dynamic-field-value">' . esc_html( $value ) . '</span>';
		}

		if ( ! empty( $settings['after_text'] ) ) {
			$output .= ' <span class="astrax-dynamic-field-after">' . esc_html( $settings['after_text'] ) . '</span>';
		}

		$this->render_html_tag(
			$settings['html_tag'],
			$output,
			[ 'class' => 'astrax-dynamic-field' ]
		);
	}
}
