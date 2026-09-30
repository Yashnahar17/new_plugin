<?php
namespace AstraxAddons\Widgets\Testimonials;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Testimonial Masonry Widget.
 *
 * @since 1.0.0
 */
class TestimonialMasonry extends BaseWidget {

	public function get_name() {
		return 'astrax-testimonial-masonry';
	}

	public function get_title() {
		return esc_html__( 'Testimonial Masonry', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-posts-masonry';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Testimonial', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Testimonial Masonry', 'astrax-addons' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control( 'quote', [
			'label'   => esc_html__( 'Quote', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXTAREA,
			'default' => esc_html__( 'This product changed my life completely.', 'astrax-addons' ),
		] );
		$this->add_control( 'name', [
			'label'   => esc_html__( 'Name', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Jane Doe', 'astrax-addons' ),
		] );
		$this->add_control( 'role', [
			'label'   => esc_html__( 'Role', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'CEO, Acme Corp', 'astrax-addons' ),
		] );
		$this->add_control( 'rating', [
			'label'   => esc_html__( 'Rating (1-5)', 'astrax-addons' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 5,
			'min'     => 1,
			'max'     => 5,
		] );
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
				'selector' => '{{WRAPPER}} .astrax-testimonial-masonry__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-testimonial-masonry__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<figure class="astrax-testimonial">
			<blockquote class="astrax-testimonial__quote">
				<p><?php echo esc_html( $settings['quote'] ); ?></p>
			</blockquote>
			<figcaption class="astrax-testimonial__author">
				<strong><?php echo esc_html( $settings['name'] ); ?></strong>
				<?php if ( ! empty( $settings['role'] ) ) : ?>
					<span class="astrax-testimonial__role"><?php echo esc_html( $settings['role'] ); ?></span>
				<?php endif; ?>
			</figcaption>
		</figure>
		<?php
	}
}