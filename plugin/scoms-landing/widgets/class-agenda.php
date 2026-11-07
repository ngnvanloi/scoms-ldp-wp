<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCL_Agenda extends Widget_Base {

	public function get_name() {
		return 'scl_agenda';
	}

	public function get_title() {
		return 'Agenda';
	}

	public function get_icon() {
		return 'eicon-time-line';
	}

	public function get_categories() {
		return array( 'scoms-landing' );
	}

	public function get_style_depends() {
		return array( 'scl-agenda' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_content', array( 'label' => 'Content' ) );

		$this->add_control(
			'heading',
			array(
				'label'   => 'Heading',
				'type'    => Controls_Manager::TEXT,
				'default' => 'Chương trình',
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'time',
			array(
				'label'   => 'Time',
				'type'    => Controls_Manager::TEXT,
				'default' => '09:00',
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'       => 'Title',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Tên phiên',
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'speaker',
			array(
				'label'       => 'Speaker (optional)',
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => 'Items',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ time }}} - {{{ title }}}',
				'default'     => array(
					array( 'time' => '08:30', 'title' => 'Đón khách và check-in' ),
					array( 'time' => '09:00', 'title' => 'Khai mạc', 'speaker' => 'Ban tổ chức' ),
					array( 'time' => '09:30', 'title' => 'Keynote: Thương hiệu trong kỷ nguyên AI', 'speaker' => 'Diễn giả khách mời' ),
					array( 'time' => '11:00', 'title' => 'Thảo luận nhóm' ),
					array( 'time' => '12:00', 'title' => 'Networking lunch' ),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		if ( empty( $s['items'] ) ) {
			return;
		}
		?>
		<section class="scl scl-agenda">
			<div class="scl-container scl-container--narrow">
				<?php if ( $s['heading'] ) : ?>
					<h2 class="scl-agenda__heading"><?php echo esc_html( $s['heading'] ); ?></h2>
				<?php endif; ?>

				<ol class="scl-agenda__list">
					<?php foreach ( $s['items'] as $item ) : ?>
						<li class="scl-agenda__item">
							<span class="scl-agenda__time"><?php echo esc_html( $item['time'] ); ?></span>
							<div>
								<p class="scl-agenda__title"><?php echo esc_html( $item['title'] ); ?></p>
								<?php if ( ! empty( $item['speaker'] ) ) : ?>
									<p class="scl-agenda__speaker"><?php echo esc_html( $item['speaker'] ); ?></p>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
		</section>
		<?php
	}
}
