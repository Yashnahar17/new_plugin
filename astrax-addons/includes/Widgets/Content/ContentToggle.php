<?php
namespace AstraxAddons\Widgets\Content;

use Elementor\Controls_Manager;
use AstraxAddons\Widgets\BaseWidget;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Content Toggle Widget — Switch between two content areas.
 */
class ContentToggle extends BaseWidget {

	public function get_name() {
		return 'astrax-content-toggle';
	}

	public function get_title() {
		return esc_html__( 'Content Toggle', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-dual-button';
	}

	public function get_script_depends() {
		return [ 'astrax-content-toggle' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_toggle',
			[
				'label' => esc_html__( 'Content Toggle', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control( 'label_primary', [
			'label'   => esc_html__( 'Primary Label', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Monthly', 'astrax-addons' ),
		] );

		$this->add_control( 'content_primary', [
			'label'   => esc_html__( 'Primary Content', 'astrax-addons' ),
			'type'    => Controls_Manager::WYSIWYG,
			'default' => esc_html__( 'Primary content goes here.', 'astrax-addons' ),
		] );

		$this->add_control( 'label_secondary', [
			'label'   => esc_html__( 'Secondary Label', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Yearly', 'astrax-addons' ),
		] );

		$this->add_control( 'content_secondary', [
			'label'   => esc_html__( 'Secondary Content', 'astrax-addons' ),
			'type'    => Controls_Manager::WYSIWYG,
			'default' => esc_html__( 'Secondary content goes here.', 'astrax-addons' ),
		] );

		$this->add_control( 'default_active', [
			'label'   => esc_html__( 'Default Active', 'astrax-addons' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'primary',
			'options' => [
				'primary'   => esc_html__( 'Primary', 'astrax-addons' ),
				'secondary' => esc_html__( 'Secondary', 'astrax-addons' ),
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings        = $this->get_settings_for_display();
		$default_active  = $settings['default_active'];
		$primary_active  = ( 'primary' === $default_active ) ? 'active' : '';
		$secondary_active = ( 'secondary' === $default_active ) ? 'active' : '';

		$this->add_render_attribute( 'wrapper', [
			'class'                        => 'astrax-content-toggle',
			'data-default'                 => esc_attr( $default_active ),
		] );
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div class="astrax-toggle-switch" role="tablist">
				<button type="button" class="astrax-toggle-btn <?php echo esc_attr( $primary_active ); ?>" role="tab" aria-selected="<?php echo ( 'primary' === $default_active ) ? 'true' : 'false'; ?>" aria-controls="astrax-toggle-panel-primary-<?php echo esc_attr( $this->get_id() ); ?>" data-toggle="primary">
					<?php echo esc_html( $settings['label_primary'] ); ?>
				</button>
				<button type="button" class="astrax-toggle-btn <?php echo esc_attr( $secondary_active ); ?>" role="tab" aria-selected="<?php echo ( 'secondary' === $default_active ) ? 'true' : 'false'; ?>" aria-controls="astrax-toggle-panel-secondary-<?php echo esc_attr( $this->get_id() ); ?>" data-toggle="secondary">
					<?php echo esc_html( $settings['label_secondary'] ); ?>
				</button>
			</div>
			<div id="astrax-toggle-panel-primary-<?php echo esc_attr( $this->get_id() ); ?>" class="astrax-toggle-content <?php echo esc_attr( $primary_active ); ?>" role="tabpanel">
				<?php echo RenderHelper::esc_rich_text( $settings['content_primary'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<div id="astrax-toggle-panel-secondary-<?php echo esc_attr( $this->get_id() ); ?>" class="astrax-toggle-content <?php echo esc_attr( $secondary_active ); ?>" role="tabpanel">
				<?php echo RenderHelper::esc_rich_text( $settings['content_secondary'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
		<?php
	}
}
