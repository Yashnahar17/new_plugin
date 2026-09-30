<?php
namespace AstraxAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the Astrax category and enabled widget definitions.
 */
class WidgetManager {
	public function __construct() {
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_category' ] );
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
	}

	/**
	 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
	 * @return void
	 */
	public function register_category( $elements_manager ) {
		$elements_manager->add_category(
			'astrax-addons',
			[
				'title' => esc_html__( 'Astrax Addons', 'astrax-addons' ),
				'icon'  => 'eicon-plugin',
			]
		);
	}

	/**
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 * @return void
	 */
	public function register_widgets( $widgets_manager ) {
		foreach ( WidgetRegistry::enabled() as $definition ) {
			require_once ASTRAX_ADDONS_DIR . 'includes/' . $definition['file'];
			$widgets_manager->register( new $definition['class']() );
		}
	}
}
