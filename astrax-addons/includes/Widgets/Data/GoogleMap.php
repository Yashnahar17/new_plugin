<?php
namespace AstraxAddons\Widgets\Data;

use Elementor\Controls_Manager;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Google Map Widget.
 */
class GoogleMap extends BaseWidget {

	public function get_name() {
		return 'astrax-google-map';
	}

	public function get_title() {
		return esc_html__( 'Google Map', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_map',
			[
				'label' => esc_html__( 'Map', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'address', [
			'label'       => esc_html__( 'Address', 'astrax-addons' ),
			'type'        => Controls_Manager::TEXT,
			'placeholder' => esc_html__( 'Enter your address', 'astrax-addons' ),
			'default'     => 'London Eye, London, United Kingdom',
			'label_block' => true,
		] );

		$this->add_control( 'zoom', [
			'label'   => esc_html__( 'Zoom Level', 'astrax-addons' ),
			'type'    => Controls_Manager::SLIDER,
			'default' => [
				'size' => 14,
			],
			'range' => [
				'px' => [
					'min' => 1,
					'max' => 20,
				],
			],
		] );

		$this->add_responsive_control( 'height', [
			'label' => esc_html__( 'Height', 'astrax-addons' ),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'size' => 300,
			],
			'range' => [
				'px' => [
					'min' => 100,
					'max' => 1000,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .astrax-google-map iframe' => 'height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['address'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'astrax-google-map' );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<iframe 
				frameborder="0" 
				scrolling="no" 
				marginheight="0" 
				marginwidth="0" 
				src="https://maps.google.com/maps?q=<?php echo rawurlencode( $settings['address'] ); ?>&amp;t=m&amp;z=<?php echo absint( $settings['zoom']['size'] ); ?>&amp;output=embed&amp;iwloc=near" 
				title="<?php echo esc_attr( $settings['address'] ); ?>"
				aria-label="<?php echo esc_attr( $settings['address'] ); ?>"
			></iframe>
		</div>
		<?php
	}
}
