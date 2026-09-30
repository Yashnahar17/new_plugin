<?php
namespace AstraxAddons\Widgets\Team;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Team Member Widget.
 *
 * @since 1.0.0
 */
class TeamMember extends BaseWidget {

	public function get_name() {
		return 'astrax-team-member';
	}

	public function get_title() {
		return esc_html__( 'Team Member', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Team Member', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Name', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Sarah Jenkins', 'astrax-addons' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'role',
			[
				'label'   => esc_html__( 'Role / Position', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Principal Architect', 'astrax-addons' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Photo', 'astrax-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_design_variant_control( 'design_variant' );

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
				'selector' => '{{WRAPPER}} .astrax-team-member__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Name Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-team-member__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'role_color',
			[
				'label'     => esc_html__( 'Role Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-team-member__role' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'photo_border_radius',
			[
				'label'      => esc_html__( 'Photo Border Radius', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .astrax-team-member__photo img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( empty( $settings['title'] ) ) {
			return;
		}

		$variant = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
		$this->add_render_attribute( 'wrapper', 'class', [ 'astrax-team-member', 'astrax-variant-' . $variant ] );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( ! empty( $settings['image']['url'] ) ) : ?>
				<div class="astrax-team-member__photo">
					<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>" loading="lazy">
				</div>
			<?php endif; ?>
			<div class="astrax-team-member__content">
				<h3 class="astrax-team-member__title"><?php echo esc_html( $settings['title'] ); ?></h3>
				<?php if ( ! empty( $settings['role'] ) ) : ?>
					<p class="astrax-team-member__role"><?php echo esc_html( $settings['role'] ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}