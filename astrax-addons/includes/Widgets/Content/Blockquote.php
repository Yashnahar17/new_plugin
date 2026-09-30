<?php
namespace AstraxAddons\Widgets\Content;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Blockquote Widget — Styled quote/testimonial block.
 */
class Blockquote extends BaseWidget {

	public function get_name() {
		return 'astrax-blockquote';
	}

	public function get_title() {
		return esc_html__( 'Blockquote', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-blockquote';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_quote',
			[
				'label' => esc_html__( 'Blockquote', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'quote_text', [
			'label'   => esc_html__( 'Quote', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXTAREA,
			'dynamic' => [ 'active' => true ],
			'default' => esc_html__( 'The only way to do great work is to love what you do.', 'astrax-addons' ),
			'rows'    => 6,
		] );

		$this->add_control( 'author_name', [
			'label'   => esc_html__( 'Author', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'dynamic' => [ 'active' => true ],
			'default' => esc_html__( 'Steve Jobs', 'astrax-addons' ),
		] );

		$this->add_control( 'quote_style', [
			'label'   => esc_html__( 'Style', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'border',
			'options' => [
				'border'  => esc_html__( 'Border', 'astrax-addons' ),
				'icon'    => esc_html__( 'Quote Icon', 'astrax-addons' ),
				'clean'   => esc_html__( 'Clean', 'astrax-addons' ),
			],
		] );

		$this->end_controls_section();

		// Style
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Quote', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'quote_typography',
				'selector' => '{{WRAPPER}} .astrax-blockquote-text',
			]
		);

		$this->add_control( 'quote_color', [
			'label'     => esc_html__( 'Text Color', 'astrax-addons' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .astrax-blockquote-text' => 'color: {{VALUE}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['quote_text'] ) ) {
			return;
		}

		$style = sanitize_html_class( $settings['quote_style'] );
		$this->add_render_attribute( 'wrapper', 'class', [ 'astrax-blockquote', 'astrax-blockquote--' . $style ] );
		?>
		<blockquote <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( 'icon' === $style ) : ?>
				<span class="astrax-blockquote-icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" width="48" height="48" fill="currentColor"><path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/></svg>
				</span>
			<?php endif; ?>
			<p class="astrax-blockquote-text"><?php echo RenderHelper::esc_rich_text( $settings['quote_text'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php if ( ! empty( $settings['author_name'] ) ) : ?>
				<cite class="astrax-blockquote-author"><?php echo esc_html( $settings['author_name'] ); ?></cite>
			<?php endif; ?>
		</blockquote>
		<?php
	}
}
