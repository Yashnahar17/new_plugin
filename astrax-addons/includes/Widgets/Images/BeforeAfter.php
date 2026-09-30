<?php
namespace AstraxAddons\Widgets\Images;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Before/After Image Comparison Widget — Slider to compare two images.
 */
class BeforeAfter extends BaseWidget {

	public function get_name() {
		return 'astrax-before-after';
	}

	public function get_title() {
		return esc_html__( 'Before / After', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-image-before-after';
	}

	public function get_script_depends() {
		return [ 'astrax-before-after' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_images',
			[
				'label' => esc_html__( 'Images', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'before_image', [
			'label'   => esc_html__( 'Before Image', 'astrax-addons' ),
			'type'    => Controls_Manager::MEDIA,
			'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
		] );

		$this->add_control( 'after_image', [
			'label'   => esc_html__( 'After Image', 'astrax-addons' ),
			'type'    => Controls_Manager::MEDIA,
			'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
		] );

		$this->add_control( 'before_label', [
			'label'   => esc_html__( 'Before Label', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Before', 'astrax-addons' ),
		] );

		$this->add_control( 'after_label', [
			'label'   => esc_html__( 'After Label', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'After', 'astrax-addons' ),
		] );

		$this->add_control( 'orientation', [
			'label'   => esc_html__( 'Orientation', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'horizontal',
			'options' => [
				'horizontal' => esc_html__( 'Horizontal', 'astrax-addons' ),
				'vertical'   => esc_html__( 'Vertical', 'astrax-addons' ),
			],
		] );

		$this->add_control( 'initial_offset', [
			'label'   => esc_html__( 'Initial Offset (%)', 'astrax-addons' ),
			'type'    => Controls_Manager::SLIDER,
			'default' => [ 'size' => 50 ],
			'range'   => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', [
			'class'            => 'astrax-before-after',
			'data-orientation' => esc_attr( $settings['orientation'] ),
			'data-offset'      => esc_attr( $settings['initial_offset']['size'] ),
		] );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div class="astrax-ba-before" aria-label="<?php echo esc_attr( $settings['before_label'] ); ?>">
				<img src="<?php echo esc_url( $settings['before_image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['before_label'] ); ?>" loading="lazy">
				<?php if ( ! empty( $settings['before_label'] ) ) : ?>
					<span class="astrax-ba-label astrax-ba-label--before"><?php echo esc_html( $settings['before_label'] ); ?></span>
				<?php endif; ?>
			</div>
			<div class="astrax-ba-after" aria-label="<?php echo esc_attr( $settings['after_label'] ); ?>">
				<img src="<?php echo esc_url( $settings['after_image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['after_label'] ); ?>" loading="lazy">
				<?php if ( ! empty( $settings['after_label'] ) ) : ?>
					<span class="astrax-ba-label astrax-ba-label--after"><?php echo esc_html( $settings['after_label'] ); ?></span>
				<?php endif; ?>
			</div>
			<div class="astrax-ba-handle" role="slider" aria-valuenow="<?php echo esc_attr( $settings['initial_offset']['size'] ); ?>" aria-valuemin="0" aria-valuemax="100" aria-label="<?php esc_attr_e( 'Image comparison slider', 'astrax-addons' ); ?>" tabindex="0">
				<span class="astrax-ba-handle-icon" aria-hidden="true"></span>
			</div>
		</div>
		<?php
	}
}
