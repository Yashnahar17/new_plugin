<?php
namespace AstraxAddons\Widgets\Typography;

use Elementor\Controls_Manager;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Counter Widget — Animated number counter with prefix/suffix.
 */
class Counter extends BaseWidget {

	public function get_name() {
		return 'astrax-counter';
	}

	public function get_title() {
		return esc_html__( 'Counter', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_script_depends() {
		return [ 'astrax-counter' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_counter',
			[
				'label' => esc_html__( 'Counter', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'starting_number', [
			'label'   => esc_html__( 'Starting Number', 'astrax-addons' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 0,
		] );

		$this->add_control( 'ending_number', [
			'label'   => esc_html__( 'Ending Number', 'astrax-addons' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 100,
		] );

		$this->add_control( 'prefix', [
			'label'   => esc_html__( 'Prefix', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '',
		] );

		$this->add_control( 'suffix', [
			'label'   => esc_html__( 'Suffix', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '+',
		] );

		$this->add_control( 'title', [
			'label'   => esc_html__( 'Title', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'dynamic' => [ 'active' => true ],
			'default' => esc_html__( 'Cool Number', 'astrax-addons' ),
		] );

		$this->add_control( 'duration', [
			'label'   => esc_html__( 'Animation Duration (ms)', 'astrax-addons' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 2000,
			'min'     => 100,
			'max'     => 10000,
		] );

		$this->add_control( 'thousand_separator', [
			'label'   => esc_html__( 'Thousand Separator', 'astrax-addons' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'counter', [
			'class'              => 'astrax-counter-number',
			'data-from'          => esc_attr( intval( $settings['starting_number'] ) ),
			'data-to'            => esc_attr( intval( $settings['ending_number'] ) ),
			'data-duration'      => esc_attr( intval( $settings['duration'] ) ),
			'data-separator'     => ( 'yes' === $settings['thousand_separator'] ) ? ',' : '',
		] );
		?>
		<div class="astrax-counter-wrapper">
			<div class="astrax-counter-value">
				<?php if ( ! empty( $settings['prefix'] ) ) : ?>
					<span class="astrax-counter-prefix"><?php echo esc_html( $settings['prefix'] ); ?></span>
				<?php endif; ?>

				<span <?php $this->print_render_attribute_string( 'counter' ); ?>>
					<?php echo esc_html( $settings['starting_number'] ); ?>
				</span>

				<?php if ( ! empty( $settings['suffix'] ) ) : ?>
					<span class="astrax-counter-suffix"><?php echo esc_html( $settings['suffix'] ); ?></span>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $settings['title'] ) ) : ?>
				<span class="astrax-counter-title"><?php echo esc_html( $settings['title'] ); ?></span>
			<?php endif; ?>
		</div>
		<?php
	}
}
