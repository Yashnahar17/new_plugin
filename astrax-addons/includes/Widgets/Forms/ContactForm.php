<?php
namespace AstraxAddons\Widgets\Forms;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contact Form Widget.
 *
 * @since 1.0.0
 */
class ContactForm extends BaseWidget {

	public function get_name() {
		return 'astrax-contact-form';
	}

	public function get_title() {
		return esc_html__( 'Contact Form', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-form';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Form', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Contact Us', 'astrax-addons' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Send us a message and our team will respond within 24 hours.', 'astrax-addons' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'submit_text',
			[
				'label'   => esc_html__( 'Submit Button Text', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Send Message', 'astrax-addons' ),
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
				'selector' => '{{WRAPPER}} .astrax-contact-form__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-contact-form__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_border_color',
			[
				'label'     => esc_html__( 'Input Border Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-form-input, {{WRAPPER}} .astrax-form-textarea' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'submit_bg_color',
			[
				'label'     => esc_html__( 'Submit Button Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-form-submit' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$variant  = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
		$widget_id = $this->get_id();
		?>
		<div class="astrax-form-widget astrax-contact-form astrax-variant-<?php echo esc_attr( $variant ); ?>">
			<?php if ( ! empty( $settings['title'] ) ) : ?>
				<h3 class="astrax-contact-form__title"><?php echo esc_html( $settings['title'] ); ?></h3>
			<?php endif; ?>

			<?php if ( ! empty( $settings['description'] ) ) : ?>
				<p class="astrax-contact-form__desc"><?php echo esc_html( $settings['description'] ); ?></p>
			<?php endif; ?>

			<form method="post" action="" class="astrax-form-fields" novalidate>
				<?php wp_nonce_field( 'astrax_contact_form_' . $widget_id, '_astrax_nonce' ); ?>
				<input type="hidden" name="action" value="astrax_submit_contact_form">
				<input type="hidden" name="widget_id" value="<?php echo esc_attr( $widget_id ); ?>">

				<div class="astrax-form-group">
					<label for="astrax-name-<?php echo esc_attr( $widget_id ); ?>" class="astrax-form-label">
						<?php esc_html_e( 'Your Name', 'astrax-addons' ); ?> <span class="astrax-required">*</span>
					</label>
					<input type="text" id="astrax-name-<?php echo esc_attr( $widget_id ); ?>" name="sender_name" class="astrax-form-input" required autocomplete="name">
				</div>

				<div class="astrax-form-group">
					<label for="astrax-email-<?php echo esc_attr( $widget_id ); ?>" class="astrax-form-label">
						<?php esc_html_e( 'Email Address', 'astrax-addons' ); ?> <span class="astrax-required">*</span>
					</label>
					<input type="email" id="astrax-email-<?php echo esc_attr( $widget_id ); ?>" name="sender_email" class="astrax-form-input" required autocomplete="email">
				</div>

				<div class="astrax-form-group">
					<label for="astrax-message-<?php echo esc_attr( $widget_id ); ?>" class="astrax-form-label">
						<?php esc_html_e( 'Message', 'astrax-addons' ); ?> <span class="astrax-required">*</span>
					</label>
					<textarea id="astrax-message-<?php echo esc_attr( $widget_id ); ?>" name="sender_message" rows="5" class="astrax-form-textarea" required></textarea>
				</div>

				<div class="astrax-form-actions">
					<button type="submit" class="astrax-form-submit elementor-button">
						<?php echo esc_html( $settings['submit_text'] ); ?>
					</button>
				</div>
			</form>
		</div>
		<?php
	}
}