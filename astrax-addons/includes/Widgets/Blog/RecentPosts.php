<?php
namespace AstraxAddons\Widgets\Blog;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use AstraxAddons\Widgets\BaseWidget;
use AstraxAddons\Utilities\QueryController;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Recent Posts Widget.
 *
 * @since 1.0.0
 */
class RecentPosts extends BaseWidget {

	public function get_name() {
		return 'astrax-recent-posts';
	}

	public function get_title() {
		return esc_html__( 'Recent Posts', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Query', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Recent Posts', 'astrax-addons' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control( 'posts_per_page', [
			'label'   => esc_html__( 'Posts Per Page', 'astrax-addons' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 6,
			'min'     => 1,
			'max'     => 100,
		] );
		$this->add_control( 'orderby', [
			'label'   => esc_html__( 'Order By', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'date',
			'options' => [
				'date'          => esc_html__( 'Date', 'astrax-addons' ),
				'title'         => esc_html__( 'Title', 'astrax-addons' ),
				'rand'          => esc_html__( 'Random', 'astrax-addons' ),
				'comment_count' => esc_html__( 'Comment Count', 'astrax-addons' ),
			],
		] );
		$this->add_control( 'order', [
			'label'   => esc_html__( 'Order', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'DESC',
			'options' => [ 'DESC' => 'Descending', 'ASC' => 'Ascending' ],
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
				'selector' => '{{WRAPPER}} .astrax-recent-posts__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-recent-posts__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$args  = QueryController::build_query_args( $settings );
		$query = new \WP_Query( $args );
		if ( ! $query->have_posts() ) {
			$this->render_empty_state( esc_html__( 'No posts found.', 'astrax-addons' ) );
			return;
		}

		$this->render_wrapper_start( [ 'astrax-blog-widget', 'astrax-recent-posts' ] );
		echo '<div class="astrax-recent-posts__list">';
		while ( $query->have_posts() ) {
			$query->the_post();
			echo '<article class="astrax-blog-item astrax-recent-posts__item">';
			echo '<h3 class="astrax-recent-posts__title"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3>';
			echo '</article>';
		}
		echo '</div>';
		$this->render_wrapper_end();
		wp_reset_postdata();
	}
}