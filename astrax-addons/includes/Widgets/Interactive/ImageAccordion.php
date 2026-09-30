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
 * Image Accordion Widget.
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
			'cards',
			'hover',
			'images',
		];
	}

	/**
	 * Get widget style dependencies.
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return [ 'astrax-image-accordion' ];
	}

	/**
	 * Get widget script dependencies.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'astrax-image-accordion' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @return void
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
				'label' => esc_html__( 'Content', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		/*
		 * IMAGE
		 */

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

		/*
		 * ALT TEXT
		 */

		$repeater->add_control(
			'image_alt',
			[
				'label'       => esc_html__( 'Image Alt Text', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Describe the image', 'astrax-addons' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		/*
		 * TITLE
		 */

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Creative Design', 'astrax-addons' ),
				'placeholder' => esc_html__( 'Enter title', 'astrax-addons' ),
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		/*
		 * DESCRIPTION
		 */

		$repeater->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__(
					'Create engaging digital experiences with modern design.',
					'astrax-addons'
				),
				'placeholder' => esc_html__( 'Enter description', 'astrax-addons' ),
				'rows'        => 4,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		/*
		 * BUTTON TEXT
		 */

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

		/*
		 * BUTTON LINK
		 */

		$repeater->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Button Link', 'astrax-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'dynamic'     => [
					'active' => true,
				],
				'default' => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		/*
		 * REPEATER
		 */

		$this->add_control(
			'items',
			[
				'label'       => esc_html__( 'Accordion Items', 'astrax-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'title'       => esc_html__( 'Creative Design', 'astrax-addons' ),
						'description' => esc_html__(
							'Create engaging digital experiences with modern design.',
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
					[
						'title'       => esc_html__( 'Brand Experience', 'astrax-addons' ),
						'description' => esc_html__(
							'Build memorable and consistent brand experiences.',
							'astrax-addons'
						),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		/*
		 * DESIGN
		 */

		$this->add_control(
			'design',
			[
				'label'   => esc_html__( 'Design', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'design-1',
				'options' => [
					'design-1' => esc_html__( 'Classic Split', 'astrax-addons' ),
					'design-2' => esc_html__( 'Editorial Reveal', 'astrax-addons' ),
					'design-3' => esc_html__( 'Cinematic Cards', 'astrax-addons' ),
					'design-4' => esc_html__( 'Minimal Vertical', 'astrax-addons' ),
				],
			]
		);

		/*
		 * INTERACTION
		 */

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

		/*
		 * ACTIVE ITEM
		 */

		$this->add_control(
			'active_item',
			[
				'label'       => esc_html__( 'Active Item', 'astrax-addons' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1,
				'min'         => 0,
				'step'        => 1,
				'description' => esc_html__(
					'Set to 0 to start with no active item.',
					'astrax-addons'
				),
			]
		);

		/*
		 * ANIMATION
		 */

		$this->add_control(
			'animation_duration',
			[
				'label'      => esc_html__( 'Animation Duration', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'ms' ],
				'range'      => [
					'ms' => [
						'min'  => 100,
						'max'  => 1500,
						'step' => 50,
					],
				],
				'default' => [
					'unit' => 'ms',
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}}' =>
						'--astrax-accordion-duration: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		 * =========================================================
		 * IMAGE STYLE
		 * =========================================================
		 */

		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Image', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_height',
			[
				'label'      => esc_html__( 'Height', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [
						'min'  => 250,
						'max'  => 1000,
						'step' => 10,
					],
					'vh' => [
						'min'  => 20,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 580,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion' =>
						'--astrax-accordion-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_fit',
			[
				'label'   => esc_html__( 'Image Fit', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'cover'   => esc_html__( 'Cover', 'astrax-addons' ),
					'contain' => esc_html__( 'Contain', 'astrax-addons' ),
					'fill'    => esc_html__( 'Fill', 'astrax-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__image img' =>
						'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_zoom',
			[
				'label'      => esc_html__( 'Active Image Zoom', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '' ],
				'range'      => [
					'' => [
						'min'  => 1,
						'max'  => 1.2,
						'step' => 0.01,
					],
				],
				'default' => [
					'size' => 1.06,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__item.is-active img' =>
						'transform: scale({{SIZE}});',
				],
			]
		);

		$this->add_control(
			'image_overlay',
			[
				'label'     => esc_html__( 'Overlay Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.25)',
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__overlay' =>
						'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/*
		 * =========================================================
		 * CONTENT STYLE
		 * =========================================================
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
		 * =========================================================
		 * ITEM STYLE
		 * =========================================================
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
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'default' => [
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
		 * =========================================================
		 * BUTTON STYLE
		 * =========================================================
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
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__button' =>
						'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background',
			[
				'label'     => esc_html__( 'Background Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.15)',
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
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'%' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-image-accordion__button' =>
						'border-radius: {{SIZE}}{{UNIT}};',
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

		if (
			empty( $settings['items'] ) ||
			! is_array( $settings['items'] )
		) {
			return;
		}

		$widget_id = $this->get_id();

		$design = ! empty( $settings['design'] )
			? sanitize_html_class( $settings['design'] )
			: 'design-1';

		$trigger = ! empty( $settings['trigger'] )
			? sanitize_html_class( $settings['trigger'] )
			: 'hover';

		$active_item = isset( $settings['active_item'] )
			? absint( $settings['active_item'] )
			: 1;

		$total_items = count( $settings['items'] );

		/*
		 * Prevent invalid active item numbers.
		 */
		if ( $active_item > $total_items ) {
			$active_item = 1;
		}

		/*
		 * Wrapper attributes.
		 */
		$this->add_render_attribute(
			'wrapper',
			[
				'class' => [
					'astrax-image-accordion',
					'astrax-image-accordion--' . $design,
				],
				'data-trigger'     => $trigger,
				'data-active-item' => $active_item,
				'data-widget-id'   => $widget_id,
				'role'             => 'list',
			]
		);
		?>

		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>

			<?php foreach ( $settings['items'] as $index => $item ) : ?>

				<?php
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

				$image_alt = ! empty( $item['image_alt'] )
					? $item['image_alt']
					: $title;

				$is_active = $active_item === $item_number;

				$content_id =
					'astrax-accordion-content-' .
					$widget_id .
					'-' .
					$item_number;

				$button_id =
					'astrax-accordion-button-' .
					$widget_id .
					'-' .
					$item_number;

				$item_class = [
					'astrax-image-accordion__item',
				];

				if ( $is_active ) {
					$item_class[] = 'is-active';
				}

				/*
				 * Item render attributes.
				 */
				$this->add_render_attribute(
					'item-' . $item_number,
					[
						'class'      => $item_class,
						'data-index' => $item_number,
						'role'       => 'listitem',
					]
				);

				/*
				 * Button link.
				 */
				$has_button_link = ! empty(
					$item['button_link']['url']
				);

				if ( $has_button_link ) {
					$this->add_link_attributes(
						'button-' . $item_number,
						$item['button_link']
					);
				}
				?>

				<article
					<?php
					$this->print_render_attribute_string(
						'item-' . $item_number
					);
					?>
				>

					<!-- IMAGE -->

					<div class="astrax-image-accordion__image">

						<img
							src="<?php echo esc_url( $image_url ); ?>"
							alt="<?php echo esc_attr( $image_alt ); ?>"
							loading="<?php echo 0 === $index ? 'eager' : 'lazy'; ?>"
							decoding="async"
						/>

						<span
							class="astrax-image-accordion__overlay"
							aria-hidden="true"
						></span>

					</div>


					<!-- CONTENT -->

					<div
						id="<?php echo esc_attr( $content_id ); ?>"
						class="astrax-image-accordion__content"
					>

						<span
							class="astrax-image-accordion__number"
							aria-hidden="true"
						>
							<?php
							echo esc_html(
								sprintf(
									'%02d',
									$item_number
								)
							);
							?>
						</span>


						<h3 class="astrax-image-accordion__title">

							<?php
							echo esc_html( $title );
							?>

						</h3>


						<?php if ( $description ) : ?>

							<div class="astrax-image-accordion__description">

								<?php
								echo esc_html( $description );
								?>

							</div>

						<?php endif; ?>


						<?php if ( $has_button_link && ! empty( $item['button_text'] ) ) : ?>

							<a
								id="<?php echo esc_attr( $button_id ); ?>"
								class="astrax-image-accordion__button"
								<?php
								$this->print_render_attribute_string(
									'button-' . $item_number
								);
								?>
							>

								<span class="astrax-image-accordion__button-text">
									<?php
									echo esc_html(
										$item['button_text']
									);
									?>
								</span>

								<span
									class="astrax-image-accordion__button-icon"
									aria-hidden="true"
								>
									→
								</span>

							</a>

						<?php endif; ?>

					</div>


					<!-- INTERACTION TRIGGER -->

					<button
						type="button"
						class="astrax-image-accordion__trigger"
						aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
						aria-controls="<?php echo esc_attr( $content_id ); ?>"
						aria-label="<?php echo esc_attr(
							sprintf(
								__(
									'Open %s',
									'astrax-addons'
								),
								$title
							)
						); ?>"
					>

						<span
							class="astrax-image-accordion__trigger-icon"
							aria-hidden="true"
						>
							<span></span>
							<span></span>
						</span>

					</button>

				</article>

			<?php endforeach; ?>

		</div>

		<?php
	}
}
