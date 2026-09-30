<?php
namespace AstraxAddons\Widgets;

use Elementor\Controls_Manager;
use AstraxAddons\Utilities\QueryController;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post Grid Widget.
 */
class PostGrid extends BaseWidget {

	/**
	 * Get widget name.
	 */
	public function get_name() {
		return 'astrax-post-grid';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return esc_html__( 'Post Grid', 'astrax-addons' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'astrax-addons' ),
				'tab   '=> Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Posts Per Page', 'astrax-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'  => esc_html__( 'Date', 'astrax-addons' ),
					'title' => esc_html__( 'Title', 'astrax-addons' ),
					'rand'  => esc_html__( 'Random', 'astrax-addons' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'astrax-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC'  => esc_html__( 'Ascending', 'astrax-addons' ),
					'DESC' => esc_html__( 'Descending', 'astrax-addons' ),
				],
			]
		);
		
		$this->add_control(
			'exclude_current',
			[
				'label'        => esc_html__( 'Exclude Current Post', 'astrax-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_grid_style',
			[
				'label' => esc_html__( 'Grid Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'     => esc_html__( 'Columns', 'astrax-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'selectors' => [
					'{{WRAPPER}} .astrax-post-grid__container' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'astrax-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .astrax-post-grid__container' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_typography_control( 'title_typography', '{{WRAPPER}} .astrax-post-grid__title' );

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-post-grid__title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_typography_control( 'excerpt_typography', '{{WRAPPER}} .astrax-post-grid__excerpt' );

		$this->add_control(
			'excerpt_color',
			[
				'label'     => esc_html__( 'Excerpt Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-post-grid__excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$query_args = QueryController::build_query_args( $settings );
		$query = new \WP_Query( $query_args );

		if ( ! $query->have_posts() ) {
			$this->render_empty_state( esc_html__( 'No posts found.', 'astrax-addons' ) );
			return;
		}

		$variant = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
		$wrapper_classes = [
			'astrax-post-grid',
			'astrax-variant-' . $variant,
		];

		$this->render_wrapper_start( $wrapper_classes );
		echo '<div class="astrax-post-grid__container">';
		while ( $query->have_posts() ) {
			$query->the_post();
			?>
			<article <?php post_class( 'astrax-post-grid-item astrax-post-grid__item' ); ?>>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="astrax-post-grid__thumbnail">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'medium_large', [ 'class' => 'astrax-post-grid__image' ] ); ?>
						</a>
					</div>
				<?php endif; ?>
				<div class="astrax-post-grid__content">
					<h3 class="astrax-post-title astrax-post-grid__title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
					<div class="astrax-post-excerpt astrax-post-grid__excerpt">
						<?php the_excerpt(); ?>
					</div>
				</div>
			</article>
			<?php
		}
		echo '</div>';
		$this->render_wrapper_end();

		wp_reset_postdata();
	}
}
