<?php
namespace AstraxAddons\Widgets\Navigation;

use Elementor\Controls_Manager;
use AstraxAddons\Widgets\BaseWidget;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Breadcrumbs Widget.
 */
class Breadcrumbs extends BaseWidget {

	public function get_name() {
		return 'astrax-breadcrumbs';
	}

	public function get_title() {
		return esc_html__( 'Breadcrumbs', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-product-breadcrumbs';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_breadcrumbs',
			[
				'label' => esc_html__( 'Breadcrumbs', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'home_label', [
			'label'   => esc_html__( 'Home Label', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Home', 'astrax-addons' ),
		] );

		$this->add_control( 'separator', [
			'label'   => esc_html__( 'Separator', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => '/',
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$separator = wp_kses_post( $settings['separator'] );
		
		echo '<nav class="astrax-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'astrax-addons' ) . '">';
		echo '<ol>';
		
		// Basic naive implementation for demo purposes. Real implementation would use WP core logic.
		echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( $settings['home_label'] ) . '</a></li>';
		echo '<li class="separator" aria-hidden="true">' . $separator . '</li>';
		echo '<li><span aria-current="page">' . esc_html( get_the_title() ) . '</span></li>';
		
		echo '</ol>';
		echo '</nav>';
	}
}
