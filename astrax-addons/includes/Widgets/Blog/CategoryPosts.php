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
 * Category Posts Widget.
 *
 * @since 1.0.0
 */
class CategoryPosts extends BaseWidget {

	public function get_name() {
		return 'astrax-category-posts';
	}

	public function get_title() {
		return esc_html__( 'Category Posts', 'astrax-addons' );
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
				'default' => esc_html__( 'Category Posts', 'astrax-addons' ),
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
				'selector' => '{{WRAPPER}} .astrax-category-posts__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-category-posts__title' => 'color: {{VALUE}};',
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
			echo '<p>' . esc_html__( 'No posts found.', 'astrax-addons' ) . '</p>';
			return;
		}
		echo '<div class="astrax-blog-widget">';
		while ( $query->have_posts() ) {
			$query->the_post();
			echo '<article class="astrax-blog-item"><h3><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3></article>';
		}
		echo '</div>';
		wp_reset_postdata();
	}
}