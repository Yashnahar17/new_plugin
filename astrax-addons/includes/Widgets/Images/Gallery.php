<?php
namespace AstraxAddons\Widgets\Images;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use AstraxAddons\Widgets\BaseWidget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gallery Widget — Grid/Masonry gallery with lightbox support.
 */
class Gallery extends BaseWidget {

	public function get_name() {
		return 'astrax-gallery';
	}

	public function get_title() {
		return esc_html__( 'Gallery', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_gallery',
			[
				'label' => esc_html__( 'Gallery', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'gallery_images', [
			'label'   => esc_html__( 'Images', 'astrax-addons' ),
			'type'    => Controls_Manager::GALLERY,
			'default' => [],
		] );

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'thumbnail',
				'default' => 'medium',
			]
		);

		$this->add_control( 'layout', [
			'label'   => esc_html__( 'Layout', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'grid',
			'options' => [
				'grid'    => esc_html__( 'Grid', 'astrax-addons' ),
				'masonry' => esc_html__( 'Masonry', 'astrax-addons' ),
			],
		] );

		$this->add_responsive_control( 'columns', [
			'label'   => esc_html__( 'Columns', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '3',
			'options' => [
				'1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6',
			],
			'selectors' => [
				'{{WRAPPER}} .astrax-gallery-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
			],
		] );

		$this->add_control( 'enable_lightbox', [
			'label'   => esc_html__( 'Lightbox', 'astrax-addons' ),
			'type'    => Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$this->add_control( 'gap', [
			'label'      => esc_html__( 'Gap', 'astrax-addons' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [ 'size' => 10 ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'selectors'  => [
				'{{WRAPPER}} .astrax-gallery-grid' => 'gap: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$images    = $settings['gallery_images'];
		$lightbox  = 'yes' === $settings['enable_lightbox'];
		$layout    = sanitize_html_class( $settings['layout'] );

		if ( empty( $images ) ) {
			return;
		}

		$this->add_render_attribute( 'gallery', 'class', [ 'astrax-gallery-grid', 'astrax-gallery--' . $layout ] );
		?>
		<div <?php $this->print_render_attribute_string( 'gallery' ); ?>>
			<?php foreach ( $images as $image ) :
				$img_url  = esc_url( $image['url'] );
				$img_id   = absint( $image['id'] );
				$img_html = wp_get_attachment_image( $img_id, $settings['thumbnail_size'], false, [ 'class' => 'astrax-gallery-img', 'loading' => 'lazy' ] );

				if ( empty( $img_html ) ) {
					$img_html = '<img src="' . $img_url . '" class="astrax-gallery-img" loading="lazy" alt="">';
				}
			?>
				<figure class="astrax-gallery-item">
					<?php if ( $lightbox ) : ?>
						<a href="<?php echo $img_url; ?>" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="astrax-gallery-<?php echo esc_attr( $this->get_id() ); ?>">
							<?php echo $img_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
					<?php else : ?>
						<?php echo $img_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php endif; ?>
				</figure>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
