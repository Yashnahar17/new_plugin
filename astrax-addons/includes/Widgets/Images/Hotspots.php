<?php
namespace AstraxAddons\Widgets\Images;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Image Hotspots Widget — Image with positioned tooltip markers.
 */
class Hotspots extends BaseWidget {

	public function get_name() {
		return 'astrax-hotspots';
	}

	public function get_title() {
		return esc_html__( 'Image Hotspots', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-image-hotspot';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'image', [
			'label'   => esc_html__( 'Image', 'astrax-addons' ),
			'type'    => Controls_Manager::MEDIA,
			'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
		] );

		$this->end_controls_section();

		// Hotspots
		$this->start_controls_section(
			'section_hotspots',
			[
				'label' => esc_html__( 'Hotspots', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control( 'hotspot_label', [
			'label'   => esc_html__( 'Label', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Hotspot', 'astrax-addons' ),
		] );

		$repeater->add_control( 'hotspot_content', [
			'label'   => esc_html__( 'Content', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXTAREA,
			'default' => esc_html__( 'Hotspot description text.', 'astrax-addons' ),
		] );

		$repeater->add_responsive_control( 'hotspot_x', [
			'label'      => esc_html__( 'X Position (%)', 'astrax-addons' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [ 'size' => 50 ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
		] );

		$repeater->add_responsive_control( 'hotspot_y', [
			'label'      => esc_html__( 'Y Position (%)', 'astrax-addons' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [ 'size' => 50 ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
		] );

		$repeater->add_control( 'hotspot_icon', [
			'label'   => esc_html__( 'Icon', 'astrax-addons' ),
			'type'    => Controls_Manager::ICONS,
			'default' => [ 'value' => 'fas fa-plus', 'library' => 'solid' ],
		] );

		$this->add_control( 'hotspots', [
			'label'       => esc_html__( 'Hotspots', 'astrax-addons' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ hotspot_label }}}',
			'default'     => [
				[ 'hotspot_label' => esc_html__( 'Feature 1', 'astrax-addons' ), 'hotspot_x' => [ 'size' => 30 ], 'hotspot_y' => [ 'size' => 40 ] ],
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'astrax-hotspots-wrapper' );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="" class="astrax-hotspots-image" loading="lazy">

			<?php foreach ( $settings['hotspots'] as $index => $hotspot ) :
				$x = isset( $hotspot['hotspot_x']['size'] ) ? floatval( $hotspot['hotspot_x']['size'] ) : 50;
				$y = isset( $hotspot['hotspot_y']['size'] ) ? floatval( $hotspot['hotspot_y']['size'] ) : 50;
			?>
				<button type="button"
					class="astrax-hotspot-marker"
					style="left: <?php echo esc_attr( $x ); ?>%; top: <?php echo esc_attr( $y ); ?>%;"
					aria-label="<?php echo esc_attr( $hotspot['hotspot_label'] ); ?>"
					aria-expanded="false"
					data-hotspot-index="<?php echo esc_attr( $index ); ?>">
					<?php if ( ! empty( $hotspot['hotspot_icon']['value'] ) ) : ?>
						<?php Icons_Manager::render_icon( $hotspot['hotspot_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					<?php else : ?>
						<span aria-hidden="true">+</span>
					<?php endif; ?>

					<span class="astrax-hotspot-tooltip" role="tooltip">
						<?php if ( ! empty( $hotspot['hotspot_label'] ) ) : ?>
							<strong><?php echo esc_html( $hotspot['hotspot_label'] ); ?></strong>
						<?php endif; ?>
						<?php if ( ! empty( $hotspot['hotspot_content'] ) ) : ?>
							<span><?php echo esc_html( $hotspot['hotspot_content'] ); ?></span>
						<?php endif; ?>
					</span>
				</button>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
