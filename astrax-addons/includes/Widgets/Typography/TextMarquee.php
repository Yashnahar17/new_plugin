<?php
namespace AstraxAddons\Widgets\Typography;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Text Marquee Widget.
 *
 * @since 1.0.0
 */
class TextMarquee extends BaseWidget {

	public function get_name() {
		return 'astrax-text-marquee';
	}

	public function get_title() {
		return esc_html__( 'Text Marquee', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Marquee', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Text Marquee', 'astrax-addons' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control( 'speed', [
			'label'   => esc_html__( 'Speed (px/s)', 'astrax-addons' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 80,
			'min'     => 10,
			'max'     => 500,
		] );
		$this->add_control( 'direction', [
			'label'   => esc_html__( 'Direction', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'left',
			'options' => [ 'left' => esc_html__( 'Left', 'astrax-addons' ), 'right' => esc_html__( 'Right', 'astrax-addons' ) ],
		] );
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .astrax-text-marquee__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-text-marquee__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$speed    = absint( $settings['speed'] );
		$dir      = 'right' === $settings['direction'] ? 'reverse' : 'normal';
		?>
		<div class="astrax-text-marquee" style="overflow:hidden;white-space:nowrap;">
			<span class="astrax-text-marquee__inner" style="display:inline-block;animation:astrax-marquee <?php echo esc_attr($speed); ?>s linear infinite <?php echo esc_attr($dir); ?>;">
				<?php echo esc_html( $settings['title'] ); ?> &nbsp;&nbsp;&nbsp;&nbsp;
				<?php echo esc_html( $settings['title'] ); ?>
			</span>
		</div>
		<?php
	}
}