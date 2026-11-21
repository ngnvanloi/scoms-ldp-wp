<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCL_Timeline extends SCL_Widget {

	public function get_name() {
		return 'scl_timeline';
	}

	public function get_title() {
		return 'Timeline';
	}

	public function get_icon() {
		return 'eicon-time-line';
	}

	public function get_style_depends() {
		return array( 'scl-timeline' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_content', array( 'label' => 'Content' ) );

		$this->add_anchor_control( 'timeline' );
		$this->add_heading_control( 'Timeline chương trình' );

		$repeater = new Repeater();

		$repeater->add_control(
			'label',
			array(
				'label'       => 'Label',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Tên vòng',
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'date_from',
			array(
				'label'   => 'Date',
				'type'    => Controls_Manager::TEXT,
				'default' => '01/12',
			)
		);

		$repeater->add_control(
			'date_to',
			array(
				'label'       => 'Date to (optional)',
				'type'        => Controls_Manager::TEXT,
				'description' => 'Shows an arrow between the two dates.',
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => 'Milestones',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ label }}}',
				'default'     => array(
					array(
						'label'     => 'Vòng đơn',
						'date_from' => '22/11',
						'date_to'   => '30/11',
					),
					array(
						'label'     => 'Introduction Day',
						'date_from' => '28/11',
					),
					array(
						'label'     => 'Teamwork',
						'date_from' => '06/12',
					),
					array(
						'label'     => 'Phỏng vấn',
						'date_from' => '13/12',
					),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = is_array( $s['items'] ) ? $s['items'] : array();
		?>
		<section class="scl scl-tl scl-defer"<?php echo $this->anchor_attr( $s ); ?> data-scl-motion>
			<div class="scl-container">
				<?php if ( $s['heading'] ) : ?>
					<div class="scl-head">
						<?php echo scl_title( $s['heading'] ); ?>
					</div>
				<?php endif; ?>
				<ol class="scl-tl__list" data-scl-progress>
					<?php foreach ( $items as $item ) : ?>
						<li class="scl-tl__item" data-scl-step data-scl-reveal><span class="scl-tl__dot" aria-hidden="true"></span><div class="scl-tl__card"><p class="scl-tl__label"><?php echo esc_html( $item['label'] ); ?></p><div class="scl-tl__body"><p class="scl-tl__date"><?php echo esc_html( $item['date_from'] ); ?><?php if ( ! empty( $item['date_to'] ) ) : ?> <?php echo scl_icon( 'arrow', 'đến' ); ?> <?php echo esc_html( $item['date_to'] ); ?><?php endif; ?></p></div></div></li>
					<?php endforeach; ?>
				</ol>
			</div>
		</section>
		<?php
	}
}
