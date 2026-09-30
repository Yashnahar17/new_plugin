<?php
namespace AstraxAddons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Image Accordion Widget.
 */
class ImageAccordion extends BaseWidget {

	public function get_name() {
		return 'astrax-image-accordion';
	}

	public function get_title() {
		return esc_html__( 'Image Accordion', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-accordion';
	}

	public function get_style_depends() {
		return [ 'astrax-v3-widgets', 'astrax-image-accordion' ];
	}

	public function get_script_depends() {
		return [ 'astrax-image-accordion' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__( 'Settings', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'direction',
			[
				'label'   => esc_html__( 'Direction', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'astrax-addons' ),
					'vertical'   => esc_html__( 'Vertical', 'astrax-addons' ),
				],
				'default' => 'horizontal',
			]
		);

		$this->add_control(
			'trigger',
			[
				'label'   => esc_html__( 'Action Trigger', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'hover' => esc_html__( 'Hover', 'astrax-addons' ),
					'click' => esc_html__( 'Click', 'astrax-addons' ),
				],
				'default' => 'hover',
			]
		);

		$this->add_control(
			'active_index',
			[
				'label'   => esc_html__( 'Active Item (1-based)', 'astrax-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_items',
			[
				'label' => esc_html__( 'Items', 'astrax-addons' ),
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
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Accordion Item', 'astrax-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'astrax-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'items',
			[
				'label'       => esc_html__( 'Accordion Items', 'astrax-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[ 'title' => esc_html__( 'Item 1', 'astrax-addons' ) ],
					[ 'title' => esc_html__( 'Item 2', 'astrax-addons' ) ],
					[ 'title' => esc_html__( 'Item 3', 'astrax-addons' ) ],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_size',
				'default'   => 'large',
				'separator' => 'none',
			]
		);

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_accordion_style',
			[
				'label' => esc_html__( 'Accordion Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'accordion_height',
			[
				'label'      => esc_html__( 'Height', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 200,
						'max' => 1000,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .astrax-image-accordion' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_typography_control( 'title_typography', '{{WRAPPER}} .astrax-ia-title' );

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-ia-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_typography_control( 'desc_typography', '{{WRAPPER}} .astrax-ia-desc' );

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-ia-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['items'] ) ) {
			return;
		}

		$variant      = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
		$direction    = $settings['direction'] === 'vertical' ? 'astrax-dir-vertical' : 'astrax-dir-horizontal';
		$trigger      = $settings['trigger'] === 'click' ? 'click' : 'hover';
		$active_index = absint( $settings['active_index'] ) - 1;

		$this->add_render_attribute( 'wrapper', [
			'class'          => [ 'astrax-image-accordion', $direction, 'astrax-variant-' . $variant ],
			'data-trigger'   => $trigger,
			'data-active'    => $active_index,
			'role'           => 'tablist',
			'aria-multiselectable' => 'false',
		] );

		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php foreach ( $settings['items'] as $index => $item ) :
				$is_active = ( $index === $active_index );
				$item_key  = 'item_' . $item['_id'];
				$panel_id  = 'astrax-ia-panel-' . $this->get_id() . '-' . $index;
				$tab_id    = 'astrax-ia-tab-' . $this->get_id() . '-' . $index;

				$this->add_render_attribute( $item_key, [
					'class'         => [ 'astrax-ia-item', $is_active ? 'is-active' : '' ],
					'role'          => 'tab',
					'id'            => $tab_id,
					'aria-selected' => $is_active ? 'true' : 'false',
					'aria-controls' => $panel_id,
					'tabindex'      => $is_active ? '0' : '-1',
				] );

				$image_url = Group_Control_Image_Size::get_attachment_image_src( $item['image']['id'], 'image_size', $settings );
				if ( ! $image_url ) {
					$image_url = $item['image']['url'];
				}
				?>
				<div <?php $this->print_render_attribute_string( $item_key ); ?>>
					
					<div class="astrax-ia-bg" style="background-image: url('<?php echo esc_url( $image_url ); ?>');"></div>
					<div class="astrax-ia-overlay"></div>

					<div class="astrax-ia-content" id="<?php echo esc_attr( $panel_id ); ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr( $tab_id ); ?>">
						<?php if ( ! empty( $item['title'] ) ) : ?>
							<h3 class="astrax-ia-title"><?php echo esc_html( $item['title'] ); ?></h3>
						<?php endif; ?>
						
						<?php if ( ! empty( $item['description'] ) ) : ?>
							<div class="astrax-ia-desc">
								<?php echo RenderHelper::esc_rich_text( $item['description'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $item['link']['url'] ) ) :
							$link_key = 'link_' . $item['_id'];
							$this->add_link_attributes( $link_key, $item['link'] );
							$this->add_render_attribute( $link_key, 'class', 'astrax-ia-button elementor-button elementor-size-sm' );
							?>
							<a <?php $this->print_render_attribute_string( $link_key ); ?> tabindex="-1">
								<?php esc_html_e( 'Read More', 'astrax-addons' ); ?>
							</a>
						<?php endif; ?>
					</div>

				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
