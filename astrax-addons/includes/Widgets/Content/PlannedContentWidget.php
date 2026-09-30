<?php
namespace AstraxAddons\Widgets\Content;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use AstraxAddons\Utilities\RenderHelper;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class PlannedContentWidget extends BaseWidget {
	const KEY = '';
	const LABEL = '';
	const ICON = 'eicon-text';
	const TYPE = '';

	public function get_name() {
		return 'astrax-' . static::KEY;
	}

	public function get_title() {
		return esc_html__( static::LABEL, 'astrax-addons' );
	}

	public function get_icon() {
		return static::ICON;
	}

	public function get_style_depends() {
		return [ 'astrax-v3-widgets' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( static::LABEL, 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		switch ( static::TYPE ) {
			case 'heading':
				$this->add_control( 'text', [ 'label' => esc_html__( 'Heading', 'astrax-addons' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Your heading', 'astrax-addons' ), 'dynamic' => [ 'active' => true ] ] );
				$this->add_html_tag_control( 'html_tag', 'h2' );
				break;
			case 'rich_text':
				$this->add_control( 'text', [ 'label' => esc_html__( 'Content', 'astrax-addons' ), 'type' => Controls_Manager::WYSIWYG, 'default' => esc_html__( 'Add your text here.', 'astrax-addons' ) ] );
				break;
			case 'icon':
				$this->add_control( 'icon', [ 'label' => esc_html__( 'Icon', 'astrax-addons' ), 'type' => Controls_Manager::ICONS, 'default' => [ 'value' => 'fas fa-star', 'library' => 'solid' ] ] );
				$this->add_control( 'label', [ 'label' => esc_html__( 'Accessible label', 'astrax-addons' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Icon', 'astrax-addons' ) ] );
				break;
			case 'image':
				$this->add_control( 'image', [ 'label' => esc_html__( 'Image', 'astrax-addons' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ] ] );
				$this->add_control( 'alt', [ 'label' => esc_html__( 'Alternative text', 'astrax-addons' ), 'type' => Controls_Manager::TEXT, 'dynamic' => [ 'active' => true ] ] );
				break;
			case 'image_text':
				$this->add_control( 'image', [ 'label' => esc_html__( 'Image', 'astrax-addons' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ] ] );
				$this->add_control( 'title', [ 'label' => esc_html__( 'Title', 'astrax-addons' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Image and text', 'astrax-addons' ) ] );
				$this->add_control( 'text', [ 'label' => esc_html__( 'Text', 'astrax-addons' ), 'type' => Controls_Manager::TEXTAREA, 'default' => '' ] );
				break;
			case 'button':
				$this->add_control( 'text', [ 'label' => esc_html__( 'Text', 'astrax-addons' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Learn more', 'astrax-addons' ) ] );
				$this->add_link_control( 'link' );
				break;
			case 'label':
				$this->add_control( 'text', [ 'label' => esc_html__( 'Label', 'astrax-addons' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'New', 'astrax-addons' ) ] );
				break;
			case 'divider':
				$this->add_responsive_control( 'width', [ 'label' => esc_html__( 'Width', 'astrax-addons' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ '%', 'px' ], 'default' => [ 'unit' => '%', 'size' => 100 ], 'range' => [ '%' => [ 'min' => 1, 'max' => 100 ], 'px' => [ 'min' => 1, 'max' => 1200 ] ], 'selectors' => [ '{{WRAPPER}} .astrax-v3-divider' => 'width: {{SIZE}}{{UNIT}};' ] ] );
				$this->add_control( 'thickness', [ 'label' => esc_html__( 'Thickness', 'astrax-addons' ), 'type' => Controls_Manager::SLIDER, 'default' => [ 'size' => 1 ], 'range' => [ 'px' => [ 'min' => 1, 'max' => 20 ] ], 'selectors' => [ '{{WRAPPER}} .astrax-v3-divider' => 'border-width: {{SIZE}}{{UNIT}} 0 0;' ] ] );
				break;
			case 'spacer':
				$this->add_responsive_control( 'height', [ 'label' => esc_html__( 'Space', 'astrax-addons' ), 'type' => Controls_Manager::SLIDER, 'default' => [ 'size' => 40 ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 500 ] ], 'selectors' => [ '{{WRAPPER}} .astrax-v3-spacer' => 'height: {{SIZE}}{{UNIT}};' ] ] );
				break;
			case 'drop_cap':
				$this->add_control( 'text', [ 'label' => esc_html__( 'Text', 'astrax-addons' ), 'type' => Controls_Manager::TEXTAREA, 'default' => esc_html__( 'Drop cap text starts here.', 'astrax-addons' ) ] );
				break;
			case 'highlight':
				$this->add_control( 'text', [ 'label' => esc_html__( 'Text', 'astrax-addons' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Highlighted text', 'astrax-addons' ) ] );
				$this->add_control( 'highlight_color', [ 'label' => esc_html__( 'Highlight color', 'astrax-addons' ), 'type' => Controls_Manager::COLOR, 'default' => '#fff2a8', 'selectors' => [ '{{WRAPPER}} .astrax-v3-highlight' => 'background-color: {{VALUE}};' ] ] );
				break;
			case 'read_more':
				$this->add_control( 'summary', [ 'label' => esc_html__( 'Visible text', 'astrax-addons' ), 'type' => Controls_Manager::TEXTAREA, 'default' => esc_html__( 'Read the full story', 'astrax-addons' ) ] );
				$this->add_control( 'details', [ 'label' => esc_html__( 'Expandable content', 'astrax-addons' ), 'type' => Controls_Manager::WYSIWYG, 'default' => '' ] );
				$this->add_control( 'more_label', [ 'label' => esc_html__( 'Expand label', 'astrax-addons' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Read more', 'astrax-addons' ) ] );
				$this->add_control( 'less_label', [ 'label' => esc_html__( 'Collapse label', 'astrax-addons' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Read less', 'astrax-addons' ) ] );
				break;
		}

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'content_style_section',
			[
				'label' => esc_html__( 'Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_typography_control( 'content_typography', '{{WRAPPER}} .astrax-v3-heading, {{WRAPPER}} .astrax-v3-rich-text, {{WRAPPER}} .astrax-v3-button, {{WRAPPER}} .astrax-v3-label' );

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Color', 'astrax-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .astrax-v3-heading, {{WRAPPER}} .astrax-v3-rich-text, {{WRAPPER}} .astrax-v3-button, {{WRAPPER}} .astrax-v3-label' => 'color: {{VALUE}};',
					'{{WRAPPER}} .astrax-v3-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .astrax-v3-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_alignment_control( 'content_alignment', '{{WRAPPER}}' );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$type     = static::TYPE;
		$variant  = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';

		$this->render_wrapper_start( [ 'astrax-content-widget', 'astrax-content-' . $type, 'astrax-variant-' . $variant ] );

		if ( 'heading' === $type && ! empty( $settings['text'] ) ) {
			$this->render_html_tag( $settings['html_tag'], esc_html( $settings['text'] ), [ 'class' => 'astrax-v3-heading' ] );
		} elseif ( 'rich_text' === $type && ! empty( $settings['text'] ) ) {
			echo '<div class="astrax-v3-rich-text">' . RenderHelper::esc_rich_text( $settings['text'] ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} elseif ( 'icon' === $type && ! empty( $settings['icon']['value'] ) ) {
			printf( '<span class="astrax-v3-icon" role="img" aria-label="%1$s">', esc_attr( $settings['label'] ) );
			Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
			echo '</span>';
		} elseif ( 'image' === $type && ! empty( $settings['image']['url'] ) ) {
			$this->render_image( $settings['image'], $settings['alt'] ?? '' );
		} elseif ( 'image_text' === $type ) {
			echo '<div class="astrax-v3-image-text">';
			if ( ! empty( $settings['image']['url'] ) ) {
				$this->render_image( $settings['image'], '' );
			}
			printf( '<div><h3>%1$s</h3><p>%2$s</p></div>', esc_html( $settings['title'] ), esc_html( $settings['text'] ) );
			echo '</div>';
		} elseif ( 'button' === $type && ! empty( $settings['text'] ) ) {
			if ( ! empty( $settings['link']['url'] ) ) {
				$this->add_link_attributes( 'planned_button', $settings['link'] );
				printf( '<a class="astrax-v3-button" %1$s>%2$s</a>', $this->get_render_attribute_string( 'planned_button' ), esc_html( $settings['text'] ) );
			} else {
				printf( '<span class="astrax-v3-button">%s</span>', esc_html( $settings['text'] ) );
			}
		} elseif ( 'label' === $type ) {
			printf( '<span class="astrax-v3-label">%s</span>', esc_html( $settings['text'] ) );
		} elseif ( 'divider' === $type ) {
			echo '<hr class="astrax-v3-divider">';
		} elseif ( 'spacer' === $type ) {
			echo '<div class="astrax-v3-spacer" aria-hidden="true"></div>';
		} elseif ( 'drop_cap' === $type && ! empty( $settings['text'] ) ) {
			printf( '<p class="astrax-v3-drop-cap">%s</p>', esc_html( $settings['text'] ) );
		} elseif ( 'highlight' === $type && ! empty( $settings['text'] ) ) {
			printf( '<mark class="astrax-v3-highlight">%s</mark>', esc_html( $settings['text'] ) );
		} elseif ( 'read_more' === $type ) {
			printf( '<details class="astrax-v3-read-more"><summary><span class="astrax-v3-more">%1$s</span><span class="astrax-v3-less">%2$s</span></summary><div class="astrax-v3-read-more-content">%3$s%4$s</div></details>', esc_html( $settings['more_label'] ), esc_html( $settings['less_label'] ), ! empty( $settings['summary'] ) ? '<p>' . esc_html( $settings['summary'] ) . '</p>' : '', ! empty( $settings['details'] ) ? RenderHelper::esc_rich_text( $settings['details'] ) : '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		$this->render_wrapper_end();
	}

	private function render_image( $image, $alt ) {
		$image_id = isset( $image['id'] ) ? absint( $image['id'] ) : 0;
		if ( $image_id ) {
			echo wp_get_attachment_image( $image_id, 'full', false, [ 'alt' => esc_attr( $alt ), 'loading' => 'lazy' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			printf( '<img src="%1$s" alt="%2$s" loading="lazy">', esc_url( $image['url'] ), esc_attr( $alt ) );
		}
	}
}
