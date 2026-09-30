<?php
namespace AstraxAddons\Widgets\Developer;

use Elementor\Controls_Manager;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Code Block Widget — Safe display of formatted code.
 */
class CodeBlock extends BaseWidget {

	public function get_name() {
		return 'astrax-code-block';
	}

	public function get_title() {
		return esc_html__( 'Code Block', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_code',
			[
				'label' => esc_html__( 'Code Block', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'language', [
			'label'   => esc_html__( 'Language', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'html',
			'options' => [
				'html'       => esc_html__( 'HTML', 'astrax-addons' ),
				'css'        => esc_html__( 'CSS', 'astrax-addons' ),
				'javascript' => esc_html__( 'JavaScript', 'astrax-addons' ),
				'php'        => esc_html__( 'PHP', 'astrax-addons' ),
				'python'     => esc_html__( 'Python', 'astrax-addons' ),
				'bash'       => esc_html__( 'Bash', 'astrax-addons' ),
				'json'       => esc_html__( 'JSON', 'astrax-addons' ),
			],
		] );

		$this->add_control( 'code_content', [
			'label'   => esc_html__( 'Code', 'astrax-addons' ),
			'type'    => Controls_Manager::CODE,
			'default' => "<!-- Example HTML -->\n<div class=\"example\">\n  <p>Hello World</p>\n</div>",
			'language'=> 'html',
		] );

		$this->add_control( 'show_copy', [
			'label'   => esc_html__( 'Show Copy Button', 'astrax-addons' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['code_content'] ) ) {
			return;
		}

		$language_class = 'language-' . sanitize_html_class( $settings['language'] );
		
		$this->add_render_attribute( 'wrapper', 'class', 'astrax-code-block-wrapper' );
		$this->add_render_attribute( 'code', 'class', $language_class );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( 'yes' === $settings['show_copy'] ) : ?>
				<div class="astrax-code-block-header">
					<span class="astrax-code-language"><?php echo esc_html( strtoupper( $settings['language'] ) ); ?></span>
					<button class="astrax-code-copy-btn" aria-label="<?php esc_attr_e( 'Copy code to clipboard', 'astrax-addons' ); ?>">
						<?php esc_html_e( 'Copy', 'astrax-addons' ); ?>
					</button>
				</div>
			<?php endif; ?>
			<pre><code <?php $this->print_render_attribute_string( 'code' ); ?>><?php echo esc_html( $settings['code_content'] ); ?></code></pre>
		</div>
		<?php
	}
}
