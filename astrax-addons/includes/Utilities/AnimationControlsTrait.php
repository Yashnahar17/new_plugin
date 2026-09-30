<?php
namespace AstraxAddons\Utilities;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shared animation controls for widgets that provide motion intentionally.
 */
trait AnimationControlsTrait {
	/**
	 * @return void
	 */
	protected function add_astrax_animation_controls() {
		$this->start_controls_section( 'astrax_animation', [ 'label' => esc_html__( 'Animation', 'astrax-addons' ), 'tab' => Controls_Manager::TAB_ADVANCED ] );
		$this->add_control( 'astrax_animation_duration', [ 'label' => esc_html__( 'Duration (ms)', 'astrax-addons' ), 'type' => Controls_Manager::NUMBER, 'default' => 500, 'min' => 0, 'max' => 10000 ] );
		$this->add_control( 'astrax_animation_delay', [ 'label' => esc_html__( 'Delay (ms)', 'astrax-addons' ), 'type' => Controls_Manager::NUMBER, 'default' => 0, 'min' => 0, 'max' => 10000 ] );
		$this->add_control( 'astrax_animation_loop', [ 'label' => esc_html__( 'Loop animation', 'astrax-addons' ), 'type' => Controls_Manager::SWITCHER, 'default' => '' ] );
		$this->end_controls_section();
	}
}
