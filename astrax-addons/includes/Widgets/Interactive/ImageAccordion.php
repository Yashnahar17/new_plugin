<?php
namespace AstraxAddons\Widgets\Interactive;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Image Accordion Widget.
 *
 * @since 1.0.0
 */
class ImageAccordion extends BaseWidget {

	/**
	 * Widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'astrax-interactive-image-accordion';
	}

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Image Accordion', 'astrax-addons' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-image-rollover';
	}

	/**
	 * Widget categories.
	 *
	 * @return array
	 */
	public function get_categories() {
		return [ 'astrax-addons' ];
	}

	/**
	 * Widget keywords.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [
			'image',
			'accordion',
			'image accordion',
			'gallery',
			'portfolio',
			'gallery accordion',
			'cards',
			'interactive',
		];
	}

	/**
	 * Style dependencies.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return [ 'astrax-image-accordion' ];
	}

	/**
	 * Script dependencies.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'astrax-image-accordion' ];
	}

	/**
	 * Register controls.
	 */
	protected function register_controls() {

		/*
		 * =========================================================
		 * CONTENT
		 * =========================================================
		 */

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Accordion Items', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'astrax-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Accordion Item', 'astrax-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__(
					'Add a short description for this accordion item.',
					'astrax-addons'
				),
				'rows'        => 4,
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Explore', 'astrax-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Button Link', 'astrax-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'default'     => [
					'url' => '',
				],
			]
		);

		$repeater->add_control(
			'button_icon',
			[
				'label'   => esc_html__( 'Button Icon', 'astrax-addons' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'alt_text',
			[
				'label'       => esc_html__( 'Image Alt Text', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Describe the image', 'astrax-addons' ),
			]
		);

		$this->add_control(
			'items',
			[
				'label'       => esc_html__( 'Items', 'astrax-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'title'       => esc_html__( 'Mountain', 'astrax-addons' ),
						'description' => esc_html__(
							'Discover breathtaking mountain landscapes.',
							'astrax-addons'
						),
					],
					[
						'title'       => esc_html__( 'Architecture', 'astrax-addons' ),
						'description' => esc_html__(
							'Explore modern architectural experiences.',
							'astrax-addons'
						),
					],
					[
						'title'       => esc_html__( 'Nature', 'astrax-addons' ),
						'description' => esc_html__(
							'Experience beautiful natural environments.',
							'astrax-addons'
						),
					],
					[
						'title'       => esc_html__( 'Travel', 'astrax-addons' ),
						'description' => esc_html__(
							'Create memorable travel experiences.',
							'astrax-addons'
						),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		/*
		 * =========================================================
		 * DESIGN
		 * =========================================================
		 */

		$this->start_controls_section(
			'section_design',
			[
				'label' => esc_html__( 'Design', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'design',
			[
				'label'   => esc_html__( 'Design Preset', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Classic Split', 'astrax-addons' ),
					'2' => esc_html__( 'Editorial Reveal', 'astrax-addons' ),
					'3' => esc_html__( 'Cinematic Cards', 'astrax-addons' ),
					'4' => esc_html__( 'Minimal Vertical', 'astrax-addons' ),
				],
			]
		);

		$this->add_control(
			'interaction',
			[
				'label'   => esc_html__( 'Interaction', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => [
					'hover' => esc_html__( 'Hover', 'astrax-addons' ),
					'click' => esc_html__( 'Click', 'astrax-addons' ),
				],
			]
		);

		$this->add_control(
			'active_item',
			[
				'label'     => esc_html__( 'Active Item', 'astrax-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'max'       => 20,
				'condition' => [
					'interaction' => 'click',
				],
			]
		);

		$this->add_control(
			'open_first',
			[
				'label'        => esc_html__( 'Open First Item', 'astrax-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'astrax-addons' ),
				'label_off'    => esc_html__( 'No', 'astrax-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		/*
		 * =========================================================
		 * STYLE — LAYOUT
		 * =========================================================
		 */

		$this->start_controls_section(
			'style_layout',
			[
				'label' => esc_html__( 'Layout', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'layout_height',
			[
				'label'      => esc_html__( 'Height', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [
						'min' => 200,
						'max' => 1200,
					],
					'vh' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 580,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' => '--astrax-accordion-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'layout_gap',
			[
				'label'      => esc_html__( 'Gap', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'layout_max_width',
			[
				'label'      => esc_html__( 'Maximum Width', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 300,
						'max' => 2000,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'layout_overflow',
			[
				'label'   => esc_html__( 'Overflow', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hidden',
				'options' => [
					'hidden' => esc_html__( 'Hidden', 'astrax-addons' ),
					'visible' => esc_html__( 'Visible', 'astrax-addons' ),
					'clip' => esc_html__( 'Clip', 'astrax-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' => 'overflow: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		 * =========================================================
		 * STYLE — ITEM
		 * =========================================================
		 */

		$this->start_controls_section(
			'style_item',
			[
				'label' => esc_html__( 'Item', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_default_width',
			[
				'label'      => esc_html__( 'Default Width', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '' ],
				'range'      => [
					'' => [
						'min' => 0.1,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item' => '--astrax-item-flex: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_active_width',
			[
				'label'      => esc_html__( 'Active Width', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '' ],
				'range'      => [
					'' => [
						'min' => 1,
						'max' => 8,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item.is-active' => '--astrax-active-flex: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_min_height',
			[
				'label'      => esc_html__( 'Minimum Height', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1200,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .astrax-image-accordion__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'item_border',
				'selector' => '{{WRAPPER}} .astrax-image-accordion__item',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .astrax-image-accordion__item',
			]
		);

		$this->add_control(
			'item_background',
			[
				'label'     => esc_html__( 'Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_active_background',
			[
				'label'     => esc_html__( 'Active Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item.is-active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		 * =========================================================
		 * STYLE — IMAGE
		 * =========================================================
		 */

		$this->start_controls_section(
			'style_image',
			[
				'label' => esc_html__( 'Image', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_fit',
			[
				'label'   => esc_html__( 'Object Fit', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'cover'   => esc_html__( 'Cover', 'astrax-addons' ),
					'contain' => esc_html__( 'Contain', 'astrax-addons' ),
					'fill'    => esc_html__( 'Fill', 'astrax-addons' ),
					'none'    => esc_html__( 'None', 'astrax-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__image img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_position',
			[
				'label'   => esc_html__( 'Object Position', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => [
					'center center' => esc_html__( 'Center', 'astrax-addons' ),
					'center top'    => esc_html__( 'Top', 'astrax-addons' ),
					'center bottom' => esc_html__( 'Bottom', 'astrax-addons' ),
					'left center'   => esc_html__( 'Left', 'astrax-addons' ),
					'right center'  => esc_html__( 'Right', 'astrax-addons' ),
					'left top'      => esc_html__( 'Left Top', 'astrax-addons' ),
					'right top'     => esc_html__( 'Right Top', 'astrax-addons' ),
					'left bottom'   => esc_html__( 'Left Bottom', 'astrax-addons' ),
					'right bottom'  => esc_html__( 'Right Bottom', 'astrax-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__image img' => 'object-position: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_zoom',
			[
				'label'      => esc_html__( 'Image Zoom', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '' ],
				'range'      => [
					'' => [
						'min'  => 1,
						'max'  => 1.5,
						'step' => 0.01,
					],
				],
				'default' => [
					'size' => 1.08,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item' => '--astrax-image-zoom: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_brightness',
			[
				'label'      => esc_html__( 'Brightness', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '' ],
				'range'      => [
					'' => [
						'min'  => 0,
						'max'  => 2,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' => '--astrax-image-brightness: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_contrast',
			[
				'label'      => esc_html__( 'Contrast', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '' ],
				'range'      => [
					'' => [
						'min'  => 0,
						'max'  => 2,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' => '--astrax-image-contrast: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_saturation',
			[
				'label'      => esc_html__( 'Saturation', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '' ],
				'range'      => [
					'' => [
						'min'  => 0,
						'max'  => 2,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' => '--astrax-image-saturation: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_grayscale',
			[
				'label'      => esc_html__( 'Grayscale', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' => '--astrax-image-grayscale: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'image_blur',
			[
				'label'      => esc_html__( 'Blur', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' => '--astrax-image-blur: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		 * =========================================================
		 * STYLE — OVERLAY
		 * =========================================================
		 */

		$this->start_controls_section(
			'style_overlay',
			[
				'label' => esc_html__( 'Overlay', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_enable',
			[
				'label'        => esc_html__( 'Enable Overlay', 'astrax-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'astrax-addons' ),
				'label_off'    => esc_html__( 'No', 'astrax-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'overlay_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .astrax-image-accordion__overlay',
				'condition' => [
					'overlay_enable' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'overlay_opacity',
			[
				'label'      => esc_html__( 'Opacity', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '' ],
				'range'      => [
					'' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 0.35,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' => '--astrax-overlay-opacity: {{SIZE}};',
				],
				'condition' => [
					'overlay_enable' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'overlay_active_opacity',
			[
				'label'      => esc_html__( 'Active Opacity', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '' ],
				'range'      => [
					'' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 0.55,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item.is-active .astrax-image-accordion__overlay' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'overlay_enable' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		/*
		 * =========================================================
		 * STYLE — CONTENT
		 * =========================================================
		 */

		$this->start_controls_section(
			'style_content',
			[
				'label' => esc_html__( 'Content', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label'      => esc_html__( 'Maximum Width', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 900,
					],
					'%' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .astrax-image-accordion__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_horizontal',
			[
				'label'   => esc_html__( 'Horizontal Alignment', 'astrax-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'astrax-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'astrax-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'astrax-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_background',
			[
				'label'     => esc_html__( 'Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .astrax-image-accordion__content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_backdrop_blur',
			[
				'label'      => esc_html__( 'Backdrop Blur', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__content' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->end_controls_section();

		/*
		 * =========================================================
		 * STYLE — NUMBER
		 * =========================================================
		 */

		$this->start_controls_section(
			'style_number',
			[
				'label' => esc_html__( 'Number', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'show_number',
			[
				'label'        => esc_html__( 'Show Number', 'astrax-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'astrax-addons' ),
				'label_off'    => esc_html__( 'Hide', 'astrax-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'selectors'    => [
					'{{WRAPPER}} .astrax-image-accordion__number' => 'display: block;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'number_typography',
				'selector' => '{{WRAPPER}} .astrax-image-accordion__number',
			]
		);

		$this->add_control(
			'number_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'number_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item.is-active .astrax-image-accordion__number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'number_background',
			[
				'label'     => esc_html__( 'Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__number' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'number_active_background',
			[
				'label'     => esc_html__( 'Active Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item.is-active .astrax-image-accordion__number' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'number_size',
			[
				'label'      => esc_html__( 'Size', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 20,
						'max' => 120,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__number' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'number_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .astrax-image-accordion__number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'number_border',
				'selector' => '{{WRAPPER}} .astrax-image-accordion__number',
			]
		);

		$this->end_controls_section();

		/*
		 * =========================================================
		 * STYLE — TITLE
		 * =========================================================
		 */

		$this->start_controls_section(
			'style_title',
			[
				'label' => esc_html__( 'Title', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .astrax-image-accordion__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item.is-active .astrax-image-accordion__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_max_width',
			[
				'label'      => esc_html__( 'Maximum Width', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 900,
					],
					'%' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__title' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .astrax-image-accordion__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		 * =========================================================
		 * STYLE — DESCRIPTION
		 * =========================================================
		 */

		$this->start_controls_section(
			'style_description',
			[
				'label' => esc_html__( 'Description', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .astrax-image-accordion__description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'description_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item.is-active .astrax-image-accordion__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'description_max_width',
			[
				'label'      => esc_html__( 'Maximum Width', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 800,
					],
					'%' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__description' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'description_margin',
			[
				'label'      => esc_html__( 'Margin', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .astrax-image-accordion__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		 * =========================================================
		 * STYLE — BUTTON
		 * =========================================================
		 */

		$this->start_controls_section(
			'style_button',
			[
				'label' => esc_html__( 'Button', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .astrax-image-accordion__button',
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background',
			[
				'label'     => esc_html__( 'Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background',
			[
				'label'     => esc_html__( 'Hover Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .astrax-image-accordion__button',
			]
		);

		$this->add_responsive_control(
			'button_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .astrax-image-accordion__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .astrax-image-accordion__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 8,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__button svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .astrax-image-accordion__button i'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_gap',
			[
				'label'      => esc_html__( 'Icon Gap', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 40,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__button' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		 * =========================================================
		 * STYLE — TRIGGER
		 * =========================================================
		 */

		$this->start_controls_section(
			'style_trigger',
			[
				'label' => esc_html__( 'Trigger', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'trigger_size',
			[
				'label'      => esc_html__( 'Size', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__trigger' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'trigger_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 8,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__trigger span' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'trigger_background',
			[
				'label'     => esc_html__( 'Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__trigger' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'trigger_hover_background',
			[
				'label'     => esc_html__( 'Hover Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__trigger:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'trigger_active_background',
			[
				'label'     => esc_html__( 'Active Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item.is-active .astrax-image-accordion__trigger' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'trigger_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__trigger span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'trigger_hover_icon_color',
			[
				'label'     => esc_html__( 'Hover Icon Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__trigger:hover span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'trigger_active_icon_color',
			[
				'label'     => esc_html__( 'Active Icon Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item.is-active .astrax-image-accordion__trigger span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'trigger_border',
				'selector' => '{{WRAPPER}} .astrax-image-accordion__trigger',
			]
		);

		$this->add_responsive_control(
			'trigger_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .astrax-image-accordion__trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		 * =========================================================
		 * STYLE — ANIMATION
		 * =========================================================
		 */

		$this->start_controls_section(
			'style_animation',
			[
				'label' => esc_html__( 'Animation', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'animation_duration',
			[
				'label'      => esc_html__( 'Duration', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'ms' ],
				'range'      => [
					'ms' => [
						'min'  => 100,
						'max'  => 2000,
						'step' => 50,
					],
				],
				'default' => [
					'unit' => 'ms',
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' => '--astrax-accordion-duration: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'animation_easing',
			[
				'label'   => esc_html__( 'Easing', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cubic-bezier(.22,1,.36,1)',
				'options' => [
					'ease' => esc_html__( 'Ease', 'astrax-addons' ),
					'ease-in' => esc_html__( 'Ease In', 'astrax-addons' ),
					'ease-out' => esc_html__( 'Ease Out', 'astrax-addons' ),
					'ease-in-out' => esc_html__( 'Ease In Out', 'astrax-addons' ),
					'linear' => esc_html__( 'Linear', 'astrax-addons' ),
					'cubic-bezier(.22,1,.36,1)' => esc_html__( 'Premium Smooth', 'astrax-addons' ),
					'cubic-bezier(.16,1,.3,1)' => esc_html__( 'Expo Smooth', 'astrax-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' => '--astrax-accordion-easing: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_reveal',
			[
				'label'   => esc_html__( 'Content Reveal', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fade-up',
				'options' => [
					'none' => esc_html__( 'None', 'astrax-addons' ),
					'fade' => esc_html__( 'Fade', 'astrax-addons' ),
					'fade-up' => esc_html__( 'Fade Up', 'astrax-addons' ),
					'fade-down' => esc_html__( 'Fade Down', 'astrax-addons' ),
					'slide-left' => esc_html__( 'Slide Left', 'astrax-addons' ),
					'slide-right' => esc_html__( 'Slide Right', 'astrax-addons' ),
					'scale' => esc_html__( 'Scale', 'astrax-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' => '--astrax-content-reveal: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_transform',
			[
				'label'      => esc_html__( 'Hover Transform', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item:hover' => '--astrax-hover-transform: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output.
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$items = ! empty( $settings['items'] ) && is_array( $settings['items'] )
			? $settings['items']
			: [];

		if ( empty( $items ) ) {
			return;
		}

		$design       = ! empty( $settings['design'] ) ? $settings['design'] : '1';
		$interaction  = ! empty( $settings['interaction'] ) ? $settings['interaction'] : 'hover';
		$active_item  = ! empty( $settings['active_item'] ) ? absint( $settings['active_item'] ) : 1;
		$open_first   = ! empty( $settings['open_first'] ) && 'yes' === $settings['open_first'];

		$classes = [
			'astrax-image-accordion',
			'astrax-image-accordion--design-' . sanitize_html_class( $design ),
		];

		$data = [
			'design'      => $design,
			'interaction' => $interaction,
			'activeItem'  => $active_item,
		];

		?>
		<div
			class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
			data-astrax-image-accordion="<?php echo esc_attr( wp_json_encode( $data ) ); ?>"
			role="region"
			aria-label="<?php echo esc_attr__( 'Image Accordion', 'astrax-addons' ); ?>"
		>

			<?php foreach ( $items as $index => $item ) : ?>

				<?php
				$item_number = $index + 1;

				$is_active = false;

				if ( 'click' === $interaction ) {
					$is_active = ( $item_number === $active_item );
				} elseif ( $open_first && 0 === $index ) {
					$is_active = true;
				}

				$item_classes = [
					'astrax-image-accordion__item',
				];

				if ( $is_active ) {
					$item_classes[] = 'is-active';
				}

				$image_url = ! empty( $item['image']['url'] )
					? $item['image']['url']
					: Utils::get_placeholder_image_src();

				$alt_text = ! empty( $item['alt_text'] )
					? $item['alt_text']
					: (
						! empty( $item['title'] )
							? $item['title']
							: esc_html__( 'Accordion image', 'astrax-addons' )
					);

				$button_link = ! empty( $item['button_link']['url'] )
					? $item['button_link']['url']
					: '';

				$target = ! empty( $item['button_link']['is_external'] )
					? ' target="_blank"'
					: '';

				$nofollow = ! empty( $item['button_link']['nofollow'] )
					? ' rel="nofollow"'
					: '';
				?>

				<article
					class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>"
					data-index="<?php echo esc_attr( $item_number ); ?>"
					tabindex="0"
					aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
				>

					<div class="astrax-image-accordion__image">
						<img
							src="<?php echo esc_url( $image_url ); ?>"
							alt="<?php echo esc_attr( $alt_text ); ?>"
							loading="<?php echo 0 === $index ? 'eager' : 'lazy'; ?>"
						/>
					</div>

					<div class="astrax-image-accordion__overlay" aria-hidden="true"></div>

					<div class="astrax-image-accordion__content">

						<div class="astrax-image-accordion__number">
							<?php echo esc_html( str_pad( $item_number, 2, '0', STR_PAD_LEFT ) ); ?>
						</div>

						<?php if ( ! empty( $item['title'] ) ) : ?>
							<h3 class="astrax-image-accordion__title">
								<?php echo esc_html( $item['title'] ); ?>
							</h3>
						<?php endif; ?>

						<?php if ( ! empty( $item['description'] ) ) : ?>
							<div class="astrax-image-accordion__description">
								<?php echo wp_kses_post( $item['description'] ); ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $item['button_text'] ) && $button_link ) : ?>
							<a
								class="astrax-image-accordion__button"
								href="<?php echo esc_url( $button_link ); ?>"
								<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php echo $nofollow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							>
								<span class="astrax-image-accordion__button-text">
									<?php echo esc_html( $item['button_text'] ); ?>
								</span>

								<?php
								if ( ! empty( $item['button_icon']['value'] ) ) {
									Icons_Manager::render_icon(
										$item['button_icon'],
										[
											'aria-hidden' => 'true',
										]
									);
								}
								?>
							</a>
						<?php endif; ?>

					</div>

					<button
						class="astrax-image-accordion__trigger"
						type="button"
						aria-label="<?php echo esc_attr(
							sprintf(
								/* translators: %s: item title */
								__( 'Open %s', 'astrax-addons' ),
								! empty( $item['title'] )
									? $item['title']
									: sprintf( __( 'item %d', 'astrax-addons' ), $item_number )
							)
						); ?>"
						aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
					>
						<span aria-hidden="true"></span>
					</button>

				</article>

			<?php endforeach; ?>

		</div>
		<?php
	}
}
