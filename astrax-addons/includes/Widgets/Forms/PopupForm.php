<?php
namespace AstraxAddons\Widgets\Forms;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Popup Form Widget.
 *
 * @since 1.0.0
 */
class PopupForm extends BaseWidget {

	public function get_name() {
		return 'astrax-popup-form';
	}

	public function get_title() {
		return esc_html__( 'Popup Form', 'astrax-addons' );
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
				'default' => esc_html__( 'Popup Form', 'astrax-addons' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control( 'submit_text', [
			'label'   => esc_html__( 'Submit Button Text', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Submit', 'astrax-addons' ),
		] );
		$this->add_link_control( 'redirect_url', esc_html__( 'Redirect URL', 'astrax-addons' ) );
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
				'selector' => '{{WRAPPER}} .astrax-popup-form__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-popup-form__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="astrax-form-widget">
			<p class="astrax-form-placeholder"><?php echo esc_html( $settings['title'] ); ?></p>
			<button class="astrax-form-submit"><?php echo esc_html( $settings['submit_text'] ); ?></button>
		</div>
		<?php
	}
}