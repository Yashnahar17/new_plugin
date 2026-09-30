<?php
namespace AstraxAddons\Widgets\Content;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dual Button Widget — Two side-by-side buttons with optional divider.
 */
class DualButton extends BaseWidget {

	public function get_name() {
		return 'astrax-dual-button';
	}

	public function get_title() {
		return esc_html__( 'Dual Button', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-dual-button';
	}

	protected function register_controls() {
		// Primary Button
		$this->start_controls_section(
			'section_primary',
			[
				'label' => esc_html__( 'Primary Button', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'primary_text', [
			'label'   => esc_html__( 'Text', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Get Started', 'astrax-addons' ),
		] );

		$this->add_link_control( 'primary_link', esc_html__( 'Link', 'astrax-addons' ) );

		$this->add_icon_control( 'primary_icon', 'fas fa-arrow-right', esc_html__( 'Icon', 'astrax-addons' ) );

		$this->end_controls_section();

		// Secondary Button
		$this->start_controls_section(
			'section_secondary',
			[
				'label' => esc_html__( 'Secondary Button', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'secondary_text', [
			'label'   => esc_html__( 'Text', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Learn More', 'astrax-addons' ),
		] );

		$this->add_link_control( 'secondary_link', esc_html__( 'Link', 'astrax-addons' ) );

		$this->add_icon_control( 'secondary_icon', 'fas fa-info-circle', esc_html__( 'Icon', 'astrax-addons' ) );

		$this->end_controls_section();

		// Divider
		$this->start_controls_section(
			'section_divider',
			[
				'label' => esc_html__( 'Divider', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'show_divider', [
			'label'        => esc_html__( 'Show Divider', 'astrax-addons' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
		] );

		$this->add_control( 'divider_text', [
			'label'     => esc_html__( 'Divider Text', 'astrax-addons' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => esc_html__( 'OR', 'astrax-addons' ),
			'condition' => [ 'show_divider' => 'yes' ],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'astrax-dual-button-wrapper' );

		if ( ! empty( $settings['primary_link']['url'] ) ) {
			$this->add_link_attributes( 'primary_link', $settings['primary_link'] );
		}
		if ( ! empty( $settings['secondary_link']['url'] ) ) {
			$this->add_link_attributes( 'secondary_link', $settings['secondary_link'] );
		}
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<a class="astrax-dual-btn astrax-dual-btn--primary" <?php $this->print_render_attribute_string( 'primary_link' ); ?>>
				<?php if ( ! empty( $settings['primary_icon']['value'] ) ) : ?>
					<span class="astrax-dual-btn-icon"><?php Icons_Manager::render_icon( $settings['primary_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
				<?php endif; ?>
				<span class="astrax-dual-btn-text"><?php echo esc_html( $settings['primary_text'] ); ?></span>
			</a>

			<?php if ( 'yes' === $settings['show_divider'] && ! empty( $settings['divider_text'] ) ) : ?>
				<span class="astrax-dual-btn-divider" aria-hidden="true"><?php echo esc_html( $settings['divider_text'] ); ?></span>
			<?php endif; ?>

			<a class="astrax-dual-btn astrax-dual-btn--secondary" <?php $this->print_render_attribute_string( 'secondary_link' ); ?>>
				<?php if ( ! empty( $settings['secondary_icon']['value'] ) ) : ?>
					<span class="astrax-dual-btn-icon"><?php Icons_Manager::render_icon( $settings['secondary_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
				<?php endif; ?>
				<span class="astrax-dual-btn-text"><?php echo esc_html( $settings['secondary_text'] ); ?></span>
			</a>
		</div>
		<?php
	}
}
