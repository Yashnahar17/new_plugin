<?php
namespace AstraxAddons\Widgets\AI;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AI Chatbot Widget.
 *
 * @since 1.0.0
 */
class Chatbot extends BaseWidget {

	public function get_name() {
		return 'astrax-ai-chatbot';
	}

	public function get_title() {
		return esc_html__( 'AI Chatbot', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-ai';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'AI', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Chatbot Name', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Astrax Assistant', 'astrax-addons' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'welcome_message',
			[
				'label'   => esc_html__( 'Welcome Message', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Hello! I am your AI assistant. How can I help you today?', 'astrax-addons' ),
				'dynamic' => [ 'active' => true ],
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
				'selector' => '{{WRAPPER}} .astrax-ai-chatbot__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Header Title Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-ai-chatbot__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bubble_bg',
			[
				'label'     => esc_html__( 'Bot Bubble Background', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-ai-bubble--bot' => 'background-color: {{VALUE}};',
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
		$this->add_render_attribute( 'wrapper', 'class', [ 'astrax-ai-chatbot', 'astrax-variant-' . $variant ] );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?> role="region" aria-label="<?php echo esc_attr( $settings['title'] ); ?>">
			<div class="astrax-ai-chatbot__header">
				<h3 class="astrax-ai-chatbot__title"><?php echo esc_html( $settings['title'] ); ?></h3>
				<span class="astrax-ai-status-indicator" aria-label="<?php esc_attr_e( 'Online', 'astrax-addons' ); ?>"></span>
			</div>
			<div class="astrax-ai-chat-history" role="log" aria-live="polite">
				<?php if ( ! empty( $settings['welcome_message'] ) ) : ?>
					<div class="astrax-ai-message astrax-ai-message--bot">
						<div class="astrax-ai-bubble astrax-ai-bubble--bot">
							<?php echo esc_html( $settings['welcome_message'] ); ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<form class="astrax-ai-chat-input-row" onsubmit="return false;">
				<input type="text" class="astrax-ai-chat-input" placeholder="<?php esc_attr_e( 'Type your question...', 'astrax-addons' ); ?>" aria-label="<?php esc_attr_e( 'Chat message', 'astrax-addons' ); ?>">
				<button type="submit" class="astrax-ai-chat-send" aria-label="<?php esc_attr_e( 'Send message', 'astrax-addons' ); ?>">
					<?php esc_html_e( 'Send', 'astrax-addons' ); ?>
				</button>
			</form>
		</div>
		<?php
	}
}