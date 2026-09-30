<?php
namespace AstraxAddons\Widgets\Images;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class PlannedImageEffectWidget extends BaseWidget {
	const KEY = '';
	const LABEL = '';
	const TYPE = '';

	public function get_name() {
		return 'astrax-' . static::KEY;
	}

	public function get_title() {
		return esc_html__( static::LABEL, 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-image';
	}

	public function get_style_depends() {
		return [ 'astrax-v3-widgets' ];
	}

	public function get_script_depends() {
		return in_array( static::TYPE, [ 'reveal', 'interactive' ], true ) ? [ 'astrax-v3-widgets' ] : [];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'image_section',
			[
				'label' => esc_html__( static::LABEL, 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'image', [ 'label' => esc_html__( 'Image', 'astrax-addons' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ] ] );
		$this->add_control( 'alt', [ 'label' => esc_html__( 'Alternative text', 'astrax-addons' ), 'type' => Controls_Manager::TEXT, 'dynamic' => [ 'active' => true ] ] );

		switch ( static::TYPE ) {
			case 'mask':
				$this->add_control( 'shape', [ 'label' => esc_html__( 'Mask shape', 'astrax-addons' ), 'type' => Controls_Manager::SELECT, 'default' => 'circle', 'options' => [ 'circle' => esc_html__( 'Circle', 'astrax-addons' ), 'arch' => esc_html__( 'Arch', 'astrax-addons' ), 'diamond' => esc_html__( 'Diamond', 'astrax-addons' ) ] ] );
				break;
			case 'hover':
				$this->add_control( 'effect', [ 'label' => esc_html__( 'Hover effect', 'astrax-addons' ), 'type' => Controls_Manager::SELECT, 'default' => 'zoom', 'options' => [ 'zoom' => esc_html__( 'Zoom', 'astrax-addons' ), 'grayscale' => esc_html__( 'Grayscale to color', 'astrax-addons' ), 'lift' => esc_html__( 'Lift', 'astrax-addons' ) ] ] );
				break;
			case 'floating':
				$this->add_control( 'duration', [ 'label' => esc_html__( 'Animation duration (seconds)', 'astrax-addons' ), 'type' => Controls_Manager::SLIDER, 'default' => [ 'size' => 4 ], 'range' => [ 'px' => [ 'min' => 1, 'max' => 20 ] ], 'selectors' => [ '{{WRAPPER}} .astrax-v3-image-effect img' => 'animation-duration: {{SIZE}}s;' ] ] );
				break;
			case 'scrolling':
				$this->add_control( 'direction', [ 'label' => esc_html__( 'Direction', 'astrax-addons' ), 'type' => Controls_Manager::SELECT, 'default' => 'left', 'options' => [ 'left' => esc_html__( 'Left', 'astrax-addons' ), 'right' => esc_html__( 'Right', 'astrax-addons' ) ] ] );
				$this->add_control( 'duration', [ 'label' => esc_html__( 'Animation duration (seconds)', 'astrax-addons' ), 'type' => Controls_Manager::SLIDER, 'default' => [ 'size' => 12 ], 'range' => [ 'px' => [ 'min' => 2, 'max' => 60 ] ], 'selectors' => [ '{{WRAPPER}} .astrax-v3-image-effect img' => 'animation-duration: {{SIZE}}s;' ] ] );
				break;
			case 'magnifier':
				$this->add_control( 'zoom', [ 'label' => esc_html__( 'Zoom factor', 'astrax-addons' ), 'type' => Controls_Manager::SLIDER, 'default' => [ 'size' => 1.8 ], 'range' => [ 'px' => [ 'min' => 1.1, 'max' => 4, 'step' => 0.1 ] ], 'selectors' => [ '{{WRAPPER}} .astrax-v3-image-effect img' => '--astrax-v3-zoom: {{SIZE}};' ] ] );
				break;
			case 'interactive':
				$repeater = new Repeater();
				$repeater->add_control( 'label', [ 'label' => esc_html__( 'Marker label', 'astrax-addons' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Image detail', 'astrax-addons' ) ] );
				$repeater->add_control( 'content', [ 'label' => esc_html__( 'Tooltip content', 'astrax-addons' ), 'type' => Controls_Manager::TEXTAREA, 'default' => '' ] );
				$repeater->add_responsive_control( 'x', [ 'label' => esc_html__( 'Horizontal position (%)', 'astrax-addons' ), 'type' => Controls_Manager::SLIDER, 'default' => [ 'size' => 50 ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 100 ] ] ] );
				$repeater->add_responsive_control( 'y', [ 'label' => esc_html__( 'Vertical position (%)', 'astrax-addons' ), 'type' => Controls_Manager::SLIDER, 'default' => [ 'size' => 50 ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 100 ] ] ] );
				$this->add_control( 'hotspots', [ 'label' => esc_html__( 'Image markers', 'astrax-addons' ), 'type' => Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'title_field' => '{{{ label }}}', 'default' => [] ] );
				break;
		}

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'image_effect_style_section',
			[
				'label' => esc_html__( 'Image Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .astrax-v3-image-effect, {{WRAPPER}} .astrax-v3-image-effect img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$image    = isset( $settings['image'] ) && is_array( $settings['image'] ) ? $settings['image'] : [];
		if ( empty( $image['url'] ) ) {
			return;
		}

		$type      = static::TYPE;
		$variant   = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
		$modifier  = 'astrax-v3-image-effect--' . sanitize_html_class( $type ) . ' astrax-variant-' . $variant;
		if ( 'mask' === $type ) {
			$modifier .= ' astrax-v3-mask--' . sanitize_html_class( $settings['shape'] ?? 'circle' );
		} elseif ( 'hover' === $type ) {
			$modifier .= ' astrax-v3-hover--' . sanitize_html_class( $settings['effect'] ?? 'zoom' );
		} elseif ( 'scrolling' === $type ) {
			$modifier .= ' astrax-v3-scroll--' . sanitize_html_class( $settings['direction'] ?? 'left' );
		}
		$image_id = isset( $image['id'] ) ? absint( $image['id'] ) : 0;
		$image_html = $image_id ? wp_get_attachment_image( $image_id, 'full', false, [ 'alt' => esc_attr( $settings['alt'] ?? '' ), 'loading' => 'lazy' ] ) : sprintf( '<img src="%1$s" alt="%2$s" loading="lazy">', esc_url( $image['url'] ), esc_attr( $settings['alt'] ?? '' ) );
		?>
		<div class="astrax-v3-image-effect <?php echo esc_attr( $modifier ); ?>" <?php if ( 'interactive' === $type ) : ?>data-astrax-v3-hotspots<?php endif; ?> <?php if ( 'reveal' === $type ) : ?>data-astrax-v3-reveal<?php endif; ?>>
			<?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php if ( 'interactive' === $type && ! empty( $settings['hotspots'] ) ) : ?>
				<?php foreach ( $settings['hotspots'] as $hotspot ) :
					$x = isset( $hotspot['x']['size'] ) ? (float) $hotspot['x']['size'] : 50;
					$y = isset( $hotspot['y']['size'] ) ? (float) $hotspot['y']['size'] : 50;
				?>
					<button type="button" class="astrax-v3-hotspot" style="left: <?php echo esc_attr( $x ); ?>%; top: <?php echo esc_attr( $y ); ?>%;" aria-label="<?php echo esc_attr( $hotspot['label'] ); ?>" aria-expanded="false">
						<span aria-hidden="true">+</span><span class="astrax-v3-hotspot-content" hidden><?php echo esc_html( $hotspot['content'] ); ?></span>
					</button>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<?php
	}
}
