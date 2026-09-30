<?php
namespace AstraxAddons\Widgets\Creative;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use AstraxAddons\Widgets\BaseWidget;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bento Grid Widget.
 */
class BentoGrid extends BaseWidget {

	public function get_name() {
		return 'astrax-bento-grid';
	}

	public function get_title() {
		return esc_html__( 'Bento Grid', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-apps';
	}

	public function get_style_depends() {
		return [ 'astrax-v3-widgets', 'astrax-bento' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_bento',
			[
				'label' => esc_html__( 'Bento Grid', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control( 'item_title', [
			'label'   => esc_html__( 'Title', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Bento Item', 'astrax-addons' ),
		] );

		$repeater->add_control( 'item_content', [
			'label'   => esc_html__( 'Content', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXTAREA,
			'default' => esc_html__( 'Item content here.', 'astrax-addons' ),
		] );
        
        $repeater->add_responsive_control( 'col_span', [
			'label'   => esc_html__( 'Column Span', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '1',
            'options' => [
                '1' => '1 Column',
                '2' => '2 Columns',
                '3' => '3 Columns',
                '4' => '4 Columns',
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'grid-column: span {{VALUE}};',
            ],
		] );
        
        $repeater->add_responsive_control( 'row_span', [
			'label'   => esc_html__( 'Row Span', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '1',
            'options' => [
                '1' => '1 Row',
                '2' => '2 Rows',
                '3' => '3 Rows',
                '4' => '4 Rows',
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'grid-row: span {{VALUE}};',
            ],
		] );

		$this->add_control( 'items', [
			'label'       => esc_html__( 'Grid Items', 'astrax-addons' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ item_title }}}',
			'default'     => [
				[
					'item_title'   => esc_html__( 'Item 1', 'astrax-addons' ),
				],
				[
					'item_title'   => esc_html__( 'Item 2', 'astrax-addons' ),
				],
			],
		] );

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_bento_style',
			[
				'label' => esc_html__( 'Bento Item Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label'     => esc_html__( 'Grid Gap', 'astrax-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-bento-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_bg_color',
			[
				'label'     => esc_html__( 'Item Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-bento-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-bento-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items = $settings['items'];

		if ( empty( $items ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'astrax-bento-grid' );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php foreach ( $items as $index => $item ) : 
				$item_key = $this->get_repeater_setting_key( 'item_title', 'items', $index );
				$this->add_render_attribute( $item_key, 'class', 'astrax-bento-item elementor-repeater-item-' . $item['_id'] );
				?>
				<div <?php $this->print_render_attribute_string( $item_key ); ?>>
                    <?php if ( ! empty( $item['item_title'] ) ) : ?>
					    <h3 class="astrax-bento-title"><?php echo esc_html( $item['item_title'] ); ?></h3>
                    <?php endif; ?>
                    <?php if ( ! empty( $item['item_content'] ) ) : ?>
					    <div class="astrax-bento-content"><?php echo RenderHelper::esc_rich_text( $item['item_content'] ); ?></div>
                    <?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
