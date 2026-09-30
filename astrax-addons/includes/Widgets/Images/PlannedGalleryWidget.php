<?php
namespace AstraxAddons\Widgets\Images;

use Elementor\Controls_Manager;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class PlannedGalleryWidget extends BaseWidget {
	const KEY = '';
	const LABEL = '';
	const TYPE = '';

	public function get_name() {
		return 'astrax-' . static::KEY;
	}

	public function get_title() {
		return esc_html__( static::LABEL, 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_style_depends() {
		return [ 'astrax-v3-widgets' ];
	}

	public function get_script_depends() {
		return in_array( static::TYPE, [ 'carousel', 'slider' ], true ) ? [ 'astrax-v3-widgets' ] : [];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'gallery_section',
			[
				'label' => esc_html__( static::LABEL, 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'gallery_images', [ 'label' => esc_html__( 'Images', 'astrax-addons' ), 'type' => Controls_Manager::GALLERY, 'default' => [] ] );
		$column_selector = 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));';
		if ( 'masonry' === static::TYPE ) {
			$column_selector = 'column-count: {{VALUE}};';
		} elseif ( 'justified' === static::TYPE ) {
			$column_selector = 'flex-basis: calc(100% / {{VALUE}});';
		}
		$this->add_responsive_control( 'columns', [ 'label' => esc_html__( 'Columns', 'astrax-addons' ), 'type' => Controls_Manager::SELECT, 'default' => '3', 'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6' ], 'selectors' => [ '{{WRAPPER}} .astrax-v3-gallery-items' => $column_selector ] ] );
		$this->add_control( 'gap', [ 'label' => esc_html__( 'Gap', 'astrax-addons' ), 'type' => Controls_Manager::SLIDER, 'default' => [ 'size' => 12 ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ], 'selectors' => [ '{{WRAPPER}} .astrax-v3-gallery-items' => 'gap: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_control( 'image_height', [ 'label' => esc_html__( 'Image height', 'astrax-addons' ), 'type' => Controls_Manager::SLIDER, 'default' => [ 'size' => 220 ], 'range' => [ 'px' => [ 'min' => 80, 'max' => 600 ] ], 'selectors' => [ '{{WRAPPER}} .astrax-v3-gallery-item img' => 'height: {{SIZE}}{{UNIT}};' ] ] );
		$this->add_control( 'enable_lightbox', [ 'label' => esc_html__( 'Open images in lightbox', 'astrax-addons' ), 'type' => Controls_Manager::SWITCHER, 'default' => '' ] );
		if ( in_array( static::TYPE, [ 'carousel', 'slider' ], true ) ) {
			$this->add_control( 'sync_group', [ 'label' => esc_html__( 'Sync group', 'astrax-addons' ), 'type' => Controls_Manager::TEXT, 'description' => esc_html__( 'Use the same group name on another carousel or slider to synchronize its position.', 'astrax-addons' ) ] );
		}

		$this->add_design_variant_control( 'design_variant' );

		$this->end_controls_section();

		$this->start_controls_section(
			'gallery_style_section',
			[
				'label' => esc_html__( 'Gallery Style', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Item Border Radius', 'astrax-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .astrax-v3-gallery-item, {{WRAPPER}} .astrax-v3-gallery-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$images   = isset( $settings['gallery_images'] ) && is_array( $settings['gallery_images'] ) ? $settings['gallery_images'] : [];
		if ( empty( $images ) ) {
			return;
		}

		$type       = static::TYPE;
		$variant    = ! empty( $settings['design_variant'] ) ? sanitize_key( $settings['design_variant'] ) : 'core';
		$lightbox   = 'yes' === ( $settings['enable_lightbox'] ?? '' ) || 'lightbox' === $type;
		$gallery_id = 'astrax-gallery-' . sanitize_html_class( $this->get_id() );
		$classes    = [ 'astrax-v3-gallery', 'astrax-v3-gallery--' . sanitize_html_class( $type ), 'astrax-variant-' . $variant ];
		$role       = in_array( $type, [ 'carousel', 'slider' ], true ) ? 'region' : null;
		$label      = esc_attr( sprintf( __( '%s images', 'astrax-addons' ), static::LABEL ) );
		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" <?php if ( $role ) : ?>role="region" aria-label="<?php echo $label; ?>" data-astrax-v3-carousel="<?php echo esc_attr( $type ); ?>" data-astrax-v3-sync="<?php echo esc_attr( sanitize_html_class( $settings['sync_group'] ?? '' ) ); ?>"<?php endif; ?>>
			<?php if ( in_array( $type, [ 'carousel', 'slider' ], true ) ) : ?>
				<div class="astrax-v3-gallery-controls">
					<button type="button" data-gallery-prev aria-label="<?php esc_attr_e( 'Previous images', 'astrax-addons' ); ?>">&#8592;</button>
					<button type="button" data-gallery-next aria-label="<?php esc_attr_e( 'Next images', 'astrax-addons' ); ?>">&#8594;</button>
				</div>
			<?php endif; ?>
			<div class="astrax-v3-gallery-items">
				<?php foreach ( $images as $image ) :
					$image_id = isset( $image['id'] ) ? absint( $image['id'] ) : 0;
					$image_url = isset( $image['url'] ) ? esc_url( $image['url'] ) : '';
					if ( ! $image_id && ! $image_url ) {
						continue;
					}
					$image_alt = isset( $image['alt'] ) ? $image['alt'] : '';
					$image_html = $image_id ? wp_get_attachment_image( $image_id, 'large', false, [ 'loading' => 'lazy', 'alt' => esc_attr( $image_alt ) ] ) : sprintf( '<img src="%1$s" alt="%2$s" loading="lazy">', $image_url, esc_attr( $image_alt ) );
				?>
					<figure class="astrax-v3-gallery-item">
						<?php if ( $lightbox ) : ?>
							<a href="<?php echo $image_url ? $image_url : esc_url( wp_get_attachment_image_url( $image_id, 'full' ) ); ?>" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="<?php echo esc_attr( $gallery_id ); ?>">
								<?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						<?php else : ?>
							<?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php endif; ?>
					</figure>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
