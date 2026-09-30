<?php
namespace AstraxAddons\Widgets\Interactive;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Astrax Image Accordion Widget.
 *
 * @since 1.0.0
 */
class ImageAccordion extends BaseWidget {

	/**
	 * Get widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'astrax-interactive-image-accordion';
	}

	/**
	 * Get widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Image Accordion', 'astrax-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-image-rollover';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array
	 */
	public function get_categories() {
		return [ 'astrax-addons' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [
			'image',
			'accordion',
			'gallery',
			'interactive',
			'portfolio',
			'hover',
			'slider',
		];
	}

	/**
	 * Register widget controls.
	 *
	 * @return void
	 */
	protected function register_controls() {

		/*
		 * ---------------------------------------------------------
		 * CONTENT
		 * ---------------------------------------------------------
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
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Accordion Item', 'astrax-addons' ),
				'placeholder' => esc_html__( 'Enter title', 'astrax-addons' ),
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
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
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Explore', 'astrax-addons' ),
				'placeholder' => esc_html__( 'Explore', 'astrax-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Button Link', 'astrax-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'dynamic'     => [
					'active' => true,
				],
				'default'     => [
					'url' => '',
				],
			]
		);

		$repeater->add_control(
			'item_id',
			[
				'label'       => esc_html__( 'Item ID', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'unique-item-id', 'astrax-addons' ),
				'description' => esc_html__(
					'Optional unique ID for this accordion item.',
					'astrax-addons'
				),
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
						'title'       => esc_html__( 'Creative Design', 'astrax-addons' ),
						'description' => esc_html__(
							'Create visually engaging experiences with modern design.',
							'astrax-addons'
						),
					],
					[
						'title'       => esc_html__( 'Development', 'astrax-addons' ),
						'description' => esc_html__(
							'Build fast, accessible and scalable digital products.',
							'astrax-addons'
						),
					],
					[
						'title'       => esc_html__( 'Digital Strategy', 'astrax-addons' ),
						'description' => esc_html__(
							'Turn ideas into measurable digital experiences.',
							'astrax-addons'
						),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'astrax-addons' ),
					'vertical'   => esc_html__( 'Vertical', 'astrax-addons' ),
				],
			]
		);

		$this->add_control(
			'trigger',
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
				'label'       => esc_html__( 'Active Item', 'astrax-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1,
				'min'         => 0,
				'description' => esc_html__(
					'Set to 0 to have no active item.',
					'astrax-addons'
				),
			]
		);

		$this->add_control(
			'animation_duration',
			[
				'label'      => esc_html__( 'Animation Duration', 'astrax-addons' ),
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
					'{{WRAPPER}} .astrax-image-accordion__item' =>
						'--astrax-accordion-duration: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		 * ---------------------------------------------------------
		 * IMAGE
		 * ---------------------------------------------------------
		 */

		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_position',
			[
				'label'   => esc_html__( 'Image Position', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'cover'   => esc_html__( 'Cover', 'astrax-addons' ),
					'contain' => esc_html__( 'Contain', 'astrax-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__image img' =>
						'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_height',
			[
				'label'      => esc_html__( 'Height', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', 'em' ],
				'range'      => [
					'px' => [
						'min' => 150,
						'max' => 900,
					],
					'vh' => [
						'min' => 20,
						'max' => 100,
					],
					'em' => [
						'min' => 10,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item' =>
						'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_overlay',
			[
				'label'     => esc_html__( 'Overlay Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.25)',
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__overlay' =>
						'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		 * ---------------------------------------------------------
		 * CONTENT STYLE
		 * ---------------------------------------------------------
		 */

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'astrax-addons' ),
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
					'{{WRAPPER}} .astrax-image-accordion__content' =>
						'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Title Typography', 'astrax-addons' ),
				'selector' => '{{WRAPPER}} .astrax-image-accordion__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__title' =>
						'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'label'    => esc_html__( 'Description Typography', 'astrax-addons' ),
				'selector' => '{{WRAPPER}} .astrax-image-accordion__description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__description' =>
						'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		 * ---------------------------------------------------------
		 * ITEM STYLE
		 * ---------------------------------------------------------
		 */

		$this->start_controls_section(
			'section_item_style',
			[
				'label' => esc_html__( 'Items', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'item_gap',
			[
				'label'      => esc_html__( 'Gap', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' =>
						'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item' =>
						'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$this->end_controls_section();

		/*
		 * ---------------------------------------------------------
		 * BUTTON
		 * ---------------------------------------------------------
		 */

		$this->start_controls_section(
			'section_button_style',
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
			'button_color',
			[
				'label'     => esc_html__( 'Text Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__button' =>
						'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background',
			[
				'label'     => esc_html__( 'Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__button' =>
						'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__button' =>
						'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output.
	 *
	 * @return void
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( empty( $settings['items'] ) || ! is_array( $settings['items'] ) ) {
			return;
		}

		$widget_id = $this->get_id();

		$layout = ! empty( $settings['layout'] )
			? sanitize_html_class( $settings['layout'] )
			: 'horizontal';

		$trigger = ! empty( $settings['trigger'] )
			? sanitize_html_class( $settings['trigger'] )
			: 'hover';

		$active_item = isset( $settings['active_item'] )
			? absint( $settings['active_item'] )
			: 1;

		$this->add_render_attribute(
			'wrapper',
			[
				'class'                 => 'astrax-image-accordion',
				'data-layout'           => $layout,
				'data-trigger'          => $trigger,
				'data-active-item'      => $active_item,
				'data-widget-id'        => $widget_id,
				'role'                  => 'list',
			]
		);

		?>

		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>

			<?php foreach ( $settings['items'] as $index => $item ) :

				$item_number = $index + 1;

				$title = ! empty( $item['title'] )
					? $item['title']
					: esc_html__( 'Accordion Item', 'astrax-addons' );

				$description = ! empty( $item['description'] )
					? $item['description']
					: '';

				$image_url = ! empty( $item['image']['url'] )
					? $item['image']['url']
					: Utils::get_placeholder_image_src();

				$item_id = ! empty( $item['item_id'] )
					? sanitize_title( $item['item_id'] )
					: 'item-' . $item_number;

				$is_active = $active_item === $item_number;

				$unique_id = 'astrax-accordion-' . $widget_id . '-' . $item_number;

				$this->add_render_attribute(
					'item-' . $item_number,
					[
						'class'        => 'astrax-image-accordion__item',
						'data-index'   => $item_number,
						'data-item-id' => $item_id,
						'role'         => 'listitem',
					]
				);

				if ( $is_active ) {
					$this->add_render_attribute(
						'item-' . $item_number,
						'class',
						'is-active'
					);
				}
				?>

				<article <?php $this->print_render_attribute_string( 'item-' . $item_number ); ?>>

					<div class="astrax-image-accordion__image">

						<img
							src="<?php echo esc_url( $image_url ); ?>"
							alt="<?php echo esc_attr( $title ); ?>"
							loading="<?php echo 0 === $index ? 'eager' : 'lazy'; ?>"
						/>

						<div
							class="astrax-image-accordion__overlay"
							aria-hidden="true"
						></div>

					</div>

					<div class="astrax-image-accordion__content">

						<span class="astrax-image-accordion__number" aria-hidden="true">
							<?php echo esc_html( sprintf( '%02d', $item_number ) ); ?>
						</span>

						<h3
							id="<?php echo esc_attr( $unique_id ); ?>"
							class="astrax-image-accordion__title"
						>
							<?php echo esc_html( $title ); ?>
						</h3>

						<?php if ( $description ) : ?>

							<div class="astrax-image-accordion__description">
								<?php echo esc_html( $description ); ?>
							</div>

						<?php endif; ?>

						<?php if ( ! empty( $item['button_text'] ) ) : ?>

							<?php
							$button_link = ! empty( $item['button_link']['url'] )
								? $item['button_link']['url']
								: '';

							$this->add_link_attributes(
								'button-' . $item_number,
								$item['button_link']
							);
							?>

							<?php if ( $button_link ) : ?>

								<a
									class="astrax-image-accordion__button"
									<?php $this->print_render_attribute_string( 'button-' . $item_number ); ?>
								>
									<?php echo esc_html( $item['button_text'] ); ?>
									<span aria-hidden="true">→</span>
								</a>

							<?php endif; ?>

						<?php endif; ?>

					</div>

					<button
						type="button"
						class="astrax-image-accordion__trigger"
						aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
						aria-controls="<?php echo esc_attr( $unique_id ); ?>"
						aria-label="<?php echo esc_attr( sprintf( __( 'Open %s', 'astrax-addons' ), $title ) ); ?>"
					>
						<span aria-hidden="true"></span>
					</button>

				</article>

			<?php endforeach; ?>

		</div>

		<?php
	}
}
