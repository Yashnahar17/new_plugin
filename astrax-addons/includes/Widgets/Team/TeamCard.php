<?php
namespace AstraxAddons\Widgets\Team;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use AstraxAddons\Widgets\BaseWidget;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Team Card Widget.
 */
class TeamCard extends BaseWidget {

	public function get_name() {
		return 'astrax-team-card';
	}

	public function get_title() {
		return esc_html__( 'Team Card', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_team',
			[
				'label' => esc_html__( 'Team Member', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'image', [
			'label'   => esc_html__( 'Image', 'astrax-addons' ),
			'type'    => Controls_Manager::MEDIA,
			'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
		] );

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image',
				'default' => 'medium',
			]
		);

		$this->add_control( 'name', [
			'label'   => esc_html__( 'Name', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'John Doe', 'astrax-addons' ),
		] );

		$this->add_control( 'role', [
			'label'   => esc_html__( 'Role/Position', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'CEO & Founder', 'astrax-addons' ),
		] );

		$this->add_control( 'bio', [
			'label'   => esc_html__( 'Biography', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXTAREA,
			'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'astrax-addons' ),
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'astrax-team-card' );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( ! empty( $settings['image']['url'] ) ) : ?>
				<div class="astrax-team-card-image">
					<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image' ); // phpcs:ignore ?>
				</div>
			<?php endif; ?>
			<div class="astrax-team-card-content">
				<?php if ( ! empty( $settings['name'] ) ) : ?>
					<h3 class="astrax-team-card-name"><?php echo esc_html( $settings['name'] ); ?></h3>
				<?php endif; ?>
				<?php if ( ! empty( $settings['role'] ) ) : ?>
					<h4 class="astrax-team-card-role"><?php echo esc_html( $settings['role'] ); ?></h4>
				<?php endif; ?>
				<?php if ( ! empty( $settings['bio'] ) ) : ?>
					<p class="astrax-team-card-bio"><?php echo RenderHelper::esc_rich_text( $settings['bio'] ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
