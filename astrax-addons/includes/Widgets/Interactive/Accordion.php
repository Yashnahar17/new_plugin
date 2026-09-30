<?php
namespace AstraxAddons\Widgets\Interactive;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Accordion Widget.
 *
 * @since 1.0.0
 */
class Accordion extends BaseWidget {

	public function get_name() {
		return 'astrax-accordion';
	}

	public function get_title() {
		return esc_html__( 'Accordion', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-accordion';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Accordion Items', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'item_title',
			[
				'label'       => esc_html__( 'Title', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Accordion Item Title', 'astrax-addons' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_content',
			[
				'label'       => esc_html__( 'Content', 'astrax-addons' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => esc_html__( 'Detailed accordion content explaining features, documentation, or answers.', 'astrax-addons' ),
				'show_label'  => false,
			]
		);

		$this->add_control(
			'tabs',
			[
				'label'       => esc_html__( 'Accordion Items', 'astrax-addons' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'item_title'   => esc_html__( 'How does Astrax Addons ensure zero performance bloat?', 'astrax-addons' ),
						'item_content' => esc_html__( 'Astrax loads conditional CSS and JavaScript files only when a given widget is active on the current page.', 'astrax-addons' ),
					],
					[
						'item_title'   => esc_html__( 'Are all style controls mapped to real semantic markup?', 'astrax-addons' ),
						'item_content' => esc_html__( 'Yes, every Elementor style control targets verified CSS classes with zero ghost selectors.', 'astrax-addons' ),
					],
				],
				'title_field' => '{{{ item_title }}}',
			]
		);

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Accordion Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .astrax-accordion__header-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Header Title Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-accordion__header-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Body Text Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-accordion__panel' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( empty( $settings['tabs'] ) ) {
			return;
		}

		$variant   = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
		$widget_id = $this->get_id();
		$this->add_render_attribute( 'wrapper', 'class', [ 'astrax-accordion', 'astrax-variant-' . $variant ] );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?> role="region" aria-label="<?php esc_attr_e( 'Accordion', 'astrax-addons' ); ?>">
			<?php foreach ( $settings['tabs'] as $index => $item ) :
				$header_id = 'astrax-acc-hdr-' . $widget_id . '-' . $index;
				$panel_id  = 'astrax-acc-pnl-' . $widget_id . '-' . $index;
				$is_open   = ( 0 === $index );
			?>
				<div class="astrax-accordion__item <?php echo $is_open ? 'is-open' : ''; ?>">
					<h4 class="astrax-accordion__header">
						<button
							type="button"
							class="astrax-accordion__trigger"
							id="<?php echo esc_attr( $header_id ); ?>"
							aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>"
							aria-controls="<?php echo esc_attr( $panel_id ); ?>"
						>
							<span class="astrax-accordion__header-title"><?php echo esc_html( $item['item_title'] ); ?></span>
							<span class="astrax-accordion__icon" aria-hidden="true"></span>
						</button>
					</h4>
					<div
						id="<?php echo esc_attr( $panel_id ); ?>"
						class="astrax-accordion__panel"
						role="region"
						aria-labelledby="<?php echo esc_attr( $header_id ); ?>"
						<?php echo $is_open ? '' : 'hidden'; ?>
					>
						<div class="astrax-accordion__content">
							<?php echo \AstraxAddons\Utilities\RenderHelper::esc_rich_text( $item['item_content'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}