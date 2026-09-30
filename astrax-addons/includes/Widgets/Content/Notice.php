<?php
namespace AstraxAddons\Widgets\Content;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use AstraxAddons\Widgets\BaseWidget;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Notice Widget — Alert/notification bar with type variants.
 */
class Notice extends BaseWidget {

	public function get_name() {
		return 'astrax-notice';
	}

	public function get_title() {
		return esc_html__( 'Notice', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-info-circle';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_notice',
			[
				'label' => esc_html__( 'Notice', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'notice_type', [
			'label'   => esc_html__( 'Type', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'info',
			'options' => [
				'info'    => esc_html__( 'Info', 'astrax-addons' ),
				'success' => esc_html__( 'Success', 'astrax-addons' ),
				'warning' => esc_html__( 'Warning', 'astrax-addons' ),
				'error'   => esc_html__( 'Error', 'astrax-addons' ),
			],
		] );

		$this->add_control( 'notice_title', [
			'label'   => esc_html__( 'Title', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'dynamic' => [ 'active' => true ],
			'default' => esc_html__( 'Important Notice', 'astrax-addons' ),
		] );

		$this->add_control( 'notice_content', [
			'label'   => esc_html__( 'Content', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXTAREA,
			'dynamic' => [ 'active' => true ],
			'default' => esc_html__( 'This is an important notice for your visitors.', 'astrax-addons' ),
		] );

		$this->add_control( 'show_dismiss', [
			'label'        => esc_html__( 'Dismissible', 'astrax-addons' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => '',
		] );

		$this->add_icon_control( 'notice_icon', 'fas fa-info-circle', esc_html__( 'Icon', 'astrax-addons' ) );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$type = sanitize_html_class( $settings['notice_type'] );
		$this->add_render_attribute( 'wrapper', [
			'class' => [ 'astrax-notice', 'astrax-notice--' . $type ],
			'role'  => 'alert',
		] );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( ! empty( $settings['notice_icon']['value'] ) ) : ?>
				<span class="astrax-notice-icon" aria-hidden="true">
					<?php Icons_Manager::render_icon( $settings['notice_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</span>
			<?php endif; ?>

			<div class="astrax-notice-content">
				<?php if ( ! empty( $settings['notice_title'] ) ) : ?>
					<strong class="astrax-notice-title"><?php echo esc_html( $settings['notice_title'] ); ?></strong>
				<?php endif; ?>
				<?php if ( ! empty( $settings['notice_content'] ) ) : ?>
					<p class="astrax-notice-text"><?php echo RenderHelper::esc_rich_text( $settings['notice_content'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif; ?>
			</div>

			<?php if ( 'yes' === $settings['show_dismiss'] ) : ?>
				<button type="button" class="astrax-notice-dismiss" aria-label="<?php esc_attr_e( 'Dismiss notice', 'astrax-addons' ); ?>">&times;</button>
			<?php endif; ?>
		</div>
		<?php
	}
}
