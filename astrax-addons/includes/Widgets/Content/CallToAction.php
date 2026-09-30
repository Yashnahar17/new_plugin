<?php
namespace AstraxAddons\Widgets\Content;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use AstraxAddons\Widgets\BaseWidget;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Call To Action (CTA) Widget — Full-width banner with heading, text, and button.
 */
class CallToAction extends BaseWidget {

	public function get_name() {
		return 'astrax-cta';
	}

	public function get_title() {
		return esc_html__( 'Call To Action', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_cta',
			[
				'label' => esc_html__( 'Call To Action', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'title', [
			'label'   => esc_html__( 'Title', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'dynamic' => [ 'active' => true ],
			'default' => esc_html__( 'This is the heading', 'astrax-addons' ),
			'label_block' => true,
		] );

		$this->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXTAREA,
			'dynamic' => [ 'active' => true ],
			'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'astrax-addons' ),
		] );

		$this->add_control( 'button_text', [
			'label'   => esc_html__( 'Button Text', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Click Here', 'astrax-addons' ),
		] );

		$this->add_link_control( 'button_link', esc_html__( 'Button Link', 'astrax-addons' ) );
		$this->add_icon_control( 'button_icon', '', esc_html__( 'Button Icon', 'astrax-addons' ) );
		$this->add_html_tag_control( 'title_tag', 'h2' );

		$this->end_controls_section();

		// Background
		$this->start_controls_section(
			'section_background',
			[
				'label' => esc_html__( 'Background', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'bg_image', [
			'label' => esc_html__( 'Background Image', 'astrax-addons' ),
			'type'  => Controls_Manager::MEDIA,
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$wrapper_attrs = [ 'class' => 'astrax-cta-wrapper' ];
		if ( ! empty( $settings['bg_image']['url'] ) ) {
			$wrapper_attrs['style'] = 'background-image: url(' . esc_url( $settings['bg_image']['url'] ) . ');';
		}

		$this->add_render_attribute( 'wrapper', $wrapper_attrs );

		if ( ! empty( $settings['button_link']['url'] ) ) {
			$this->add_link_attributes( 'button', $settings['button_link'] );
		}
		$this->add_render_attribute( 'button', 'class', 'astrax-cta-button' );
		$this->add_render_attribute( 'button', 'role', 'button' );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div class="astrax-cta-content">
				<?php if ( ! empty( $settings['title'] ) ) : ?>
					<?php $this->render_html_tag( $settings['title_tag'], esc_html( $settings['title'] ), [ 'class' => 'astrax-cta-title' ] ); ?>
				<?php endif; ?>

				<?php if ( ! empty( $settings['description'] ) ) : ?>
					<p class="astrax-cta-description"><?php echo RenderHelper::esc_rich_text( $settings['description'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $settings['button_text'] ) ) : ?>
				<div class="astrax-cta-btn-wrapper">
					<a <?php $this->print_render_attribute_string( 'button' ); ?>>
						<?php if ( ! empty( $settings['button_icon']['value'] ) ) : ?>
							<?php Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						<?php endif; ?>
						<?php echo esc_html( $settings['button_text'] ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
