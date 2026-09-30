<?php
namespace AstraxAddons\Widgets\Content;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use AstraxAddons\Widgets\BaseWidget;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Image Box Widget — Image + Title + Description layout.
 */
class ImageBox extends BaseWidget {

	public function get_name() {
		return 'astrax-image-box';
	}

	public function get_title() {
		return esc_html__( 'Image Box', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-image-box';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_image_box',
			[
				'label' => esc_html__( 'Image Box', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Choose Image', 'astrax-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image',
				'default' => 'full',
			]
		);

		$this->add_control(
			'title_text',
			[
				'label'       => esc_html__( 'Title', 'astrax-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'This is the heading', 'astrax-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'description_text',
			[
				'label'   => esc_html__( 'Description', 'astrax-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'astrax-addons' ),
			]
		);

		$this->add_html_tag_control( 'title_tag', 'h3', esc_html__( 'Title HTML Tag', 'astrax-addons' ) );
		$this->add_link_control( 'link' );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'astrax-image-box-wrapper' );

		$has_link = ! empty( $settings['link']['url'] );
		if ( $has_link ) {
			$this->add_link_attributes( 'link', $settings['link'] );
		}
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( ! empty( $settings['image']['url'] ) ) : ?>
				<figure class="astrax-image-box-img">
					<?php if ( $has_link ) : ?>
						<a <?php $this->print_render_attribute_string( 'link' ); ?>>
					<?php endif; ?>
					<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php if ( $has_link ) : ?>
						</a>
					<?php endif; ?>
				</figure>
			<?php endif; ?>

			<div class="astrax-image-box-content">
				<?php if ( ! empty( $settings['title_text'] ) ) : ?>
					<?php
					$title_html = esc_html( $settings['title_text'] );
					if ( $has_link ) {
						$title_html = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'link' ), $title_html );
					}
					$this->render_html_tag( $settings['title_tag'], $title_html, [ 'class' => 'astrax-image-box-title' ] );
					?>
				<?php endif; ?>

				<?php if ( ! empty( $settings['description_text'] ) ) : ?>
					<p class="astrax-image-box-description"><?php echo RenderHelper::esc_rich_text( $settings['description_text'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
