<?php
namespace AstraxAddons\Utilities;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shared Controls Utility Trait.
 * Eliminates proven duplication across widgets for typography, links, tags, and accessibility.
 */
trait SharedControlsTrait {

	/**
	 * Get standard supported HTML tags for headings and text.
	 *
	 * @return array<string, string> Tag key-value pairs.
	 */
	public static function get_allowed_html_tags() {
		return [
			'h1'   => 'H1',
			'h2'   => 'H2',
			'h3'   => 'H3',
			'h4'   => 'H4',
			'h5'   => 'H5',
			'h6'   => 'H6',
			'div'  => 'div',
			'span' => 'span',
			'p'    => 'p',
		];
	}

	/**
	 * Add standardized HTML Tag control.
	 *
	 * @param string $id       Control ID.
	 * @param string $default  Default HTML tag.
	 * @param string $label    Control label.
	 */
	public function add_html_tag_control( $id = 'html_tag', $default = 'h2', $label = '' ) {
		if ( empty( $label ) ) {
			$label = esc_html__( 'HTML Tag', 'astrax-addons' );
		}

		$this->add_control(
			$id,
			[
				'label'   => $label,
				'type'    => Controls_Manager::SELECT,
				'options' => self::get_allowed_html_tags(),
				'default' => $default,
			]
		);
	}

	/**
	 * Add standardized Link control.
	 *
	 * @param string $id          Control ID.
	 * @param string $label       Control label.
	 * @param string $placeholder Placeholder URL.
	 */
	public function add_link_control( $id = 'link', $label = '', $placeholder = '' ) {
		if ( empty( $label ) ) {
			$label = esc_html__( 'Link', 'astrax-addons' );
		}
		if ( empty( $placeholder ) ) {
			$placeholder = esc_html__( 'https://your-link.com', 'astrax-addons' );
		}

		$this->add_control(
			$id,
			[
				'label'       => $label,
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => $placeholder,
			]
		);
	}

	/**
	 * Add standardized Typography group control.
	 *
	 * @param string $id       Control ID.
	 * @param string $selector CSS Selector.
	 * @param string $label    Section label.
	 */
	public function add_typography_control( $id, $selector, $label = '' ) {
		$args = [
			'name'     => $id,
			'selector' => $selector,
		];
		if ( ! empty( $label ) ) {
			$args['label'] = $label;
		}

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			$args
		);
	}

	/**
	 * Add standardized Icon control.
	 *
	 * @param string $id      Control ID.
	 * @param string $default Default icon class.
	 * @param string $label   Control label.
	 */
	public function add_icon_control( $id = 'icon', $default = 'fas fa-star', $label = '' ) {
		if ( empty( $label ) ) {
			$label = esc_html__( 'Icon', 'astrax-addons' );
		}

		$this->add_control(
			$id,
			[
				'label'   => $label,
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => $default,
					'library' => 'solid',
				],
			]
		);
	}

	/**
	 * Add standardized responsive alignment control.
	 *
	 * @param string $id       Control ID.
	 * @param string $selector Target CSS selector.
	 * @param string $default  Default alignment (left, center, right, justify).
	 */
	public function add_alignment_control( $id = 'align', $selector = '{{WRAPPER}}', $default = 'left' ) {
		$this->add_responsive_control(
			$id,
			[
				'label'     => esc_html__( 'Alignment', 'astrax-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__( 'Left', 'astrax-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'astrax-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'astrax-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'astrax-addons' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'   => $default,
				'selectors' => [
					$selector => 'text-align: {{VALUE}};',
				],
			]
		);
	}

	/**
	 * Add standardized 3-variant design preset control.
	 *
	 * @param string $id      Control ID.
	 * @param array  $custom  Custom options array if non-standard variants are used.
	 */
	public function add_design_variant_control( $id = 'design_variant', $custom = [] ) {
		$options = ! empty( $custom ) ? $custom : [
			'core'      => esc_html__( 'Core (Refined Default)', 'astrax-addons' ),
			'editorial' => esc_html__( 'Editorial (Asymmetric & Bold)', 'astrax-addons' ),
			'cyber'     => esc_html__( 'Cyber (Modern Glass & High Contrast)', 'astrax-addons' ),
		];

		$this->add_control(
			$id,
			[
				'label'   => esc_html__( 'Design Variant', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $options,
				'default' => 'core',
			]
		);
	}
}
