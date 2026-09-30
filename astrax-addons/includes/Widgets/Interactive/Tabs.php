<?php
namespace AstraxAddons\Widgets\Interactive;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use AstraxAddons\Widgets\BaseWidget;
use AstraxAddons\Utilities\RenderHelper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Tabs Widget.
 */
class Tabs extends BaseWidget {

	public function get_name() {
		return 'astrax-tabs';
	}

	public function get_title() {
		return esc_html__( 'Tabs', 'astrax-addons' );
	}

	public function get_icon() {
		return 'eicon-tabs';
	}
    
    public function get_script_depends() {
		return [ 'astrax-tabs' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_tabs',
			[
				'label' => esc_html__( 'Tabs', 'astrax-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control( 'tab_title', [
			'label'   => esc_html__( 'Title', 'astrax-addons' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Tab Title', 'astrax-addons' ),
		] );

		$repeater->add_control( 'tab_content', [
			'label'   => esc_html__( 'Content', 'astrax-addons' ),
			'type'    => Controls_Manager::WYSIWYG,
			'default' => esc_html__( 'Tab content goes here.', 'astrax-addons' ),
		] );

		$this->add_control( 'tabs', [
			'label'       => esc_html__( 'Tabs Items', 'astrax-addons' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ tab_title }}}',
			'default'     => [
				[
					'tab_title'   => esc_html__( 'Tab 1', 'astrax-addons' ),
					'tab_content' => esc_html__( 'Content for Tab 1', 'astrax-addons' ),
				],
				[
					'tab_title'   => esc_html__( 'Tab 2', 'astrax-addons' ),
					'tab_content' => esc_html__( 'Content for Tab 2', 'astrax-addons' ),
				],
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$tabs = $settings['tabs'];

		if ( empty( $tabs ) ) {
			return;
		}

		$id_int = substr( $this->get_id_int(), 0, 3 );
		?>
		<div class="astrax-tabs" role="tablist">
			<div class="astrax-tabs-nav">
				<?php foreach ( $tabs as $index => $item ) : 
					$tab_count = $index + 1;
					$tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );
					$active_class = ( 0 === $index ) ? ' active' : '';
					$this->add_render_attribute( $tab_title_setting_key, [
						'id'            => 'astrax-tab-title-' . $id_int . $tab_count,
						'class'         => [ 'astrax-tab-title', $active_class ],
						'tabindex'      => ( 0 === $index ) ? '0' : '-1',
						'role'          => 'tab',
						'aria-controls' => 'astrax-tab-content-' . $id_int . $tab_count,
						'aria-selected' => ( 0 === $index ) ? 'true' : 'false',
						'data-tab'      => $tab_count,
					] );
					?>
					<button <?php $this->print_render_attribute_string( $tab_title_setting_key ); ?>><?php echo esc_html( $item['tab_title'] ); ?></button>
				<?php endforeach; ?>
			</div>
			<div class="astrax-tabs-content-wrapper">
				<?php foreach ( $tabs as $index => $item ) : 
					$tab_count = $index + 1;
					$tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );
					$active_class = ( 0 === $index ) ? ' active' : '';
					$this->add_render_attribute( $tab_content_setting_key, [
						'id'              => 'astrax-tab-content-' . $id_int . $tab_count,
						'class'           => [ 'astrax-tab-content', $active_class ],
						'role'            => 'tabpanel',
						'aria-labelledby' => 'astrax-tab-title-' . $id_int . $tab_count,
						'data-tab'        => $tab_count,
						'hidden'          => ( 0 === $index ) ? false : true,
					] );
					?>
					<div <?php $this->print_render_attribute_string( $tab_content_setting_key ); ?>>
						<?php echo RenderHelper::esc_rich_text( $item['tab_content'] ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
