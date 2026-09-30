<?php
namespace AstraxAddons\Widgets\Typography;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Text Rotator Widget.
 *
 * @since 1.0.0
 */
class TextRotator extends BaseWidget {

	public function get_name() {
		return 'astrax-text-rotator';
	}

	public function get_title() {
		return esc_html__( 'Text Rotator', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-animation-text';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Text Rotator', 'astrax-addons' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control( 'items', [
			'label'   => esc_html__( 'Words (one per line)', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXTAREA,
			'default' => "Word One\nWord Two\nWord Three",
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
				'selector' => '{{WRAPPER}} .astrax-text-rotator__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-text-rotator__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$words    = array_filter( array_map( 'trim', explode( "\n", $settings['items'] ) ) );
		$words_j  = esc_attr( wp_json_encode( array_values( $words ) ) );
		?>
		<span class="astrax-text-rotator" data-words="<?php echo $words_j; ?>"
		      aria-live="polite"><?php echo esc_html( reset( $words ) ); ?></span>
		<?php
	}
}