<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCL_Steps extends SCL_Widget {

	public function get_name() {
		return 'scl_steps';
	}

	public function get_title() {
		return 'Apply Steps';
	}

	public function get_icon() {
		return 'eicon-number-field';
	}

	public function get_style_depends() {
		return array( 'scl-steps' );
	}

	public function get_script_depends() {
		return array( 'scl-motion', 'scl-flipclock' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_content', array( 'label' => 'Content' ) );

		$this->add_anchor_control( 'ung-tuyen' );
		$this->add_heading_control( 'Các bước đến gần hơn với Scoms' );

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			array(
				'label'   => 'Title',
				'type'    => Controls_Manager::TEXT,
				'default' => 'Bước',
			)
		);

		$repeater->add_control(
			'text',
			array(
				'label'       => 'Text',
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'description' => '**text** = bold. [text] = link to the URL below (bold text when the URL is empty).',
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => 'Link for [text]',
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://drive.google.com/...',
			)
		);

		$repeater->add_control(
			'note',
			array(
				'label'       => 'Deadline note (optional)',
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'note_until',
			array(
				'label'       => 'Hide note after',
				'type'        => Controls_Manager::DATE_TIME,
				'description' => 'Empty = always shown.',
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => 'Steps',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'title' => 'Bước 1',
						'text'  => 'Đầu tiên bạn nhấn vào đường link [TẠI ĐÂY] để truy cập vào bộ đề của các Bộ phận/Ekip. (Đừng quên để ý vào đúng bộ đề của Bộ phận/Ekip mà mình apply nha)',
						'link'  => array(
							'url'         => '',
							'is_external' => 'on',
						),
					),
					array(
						'title' => 'Bước 2',
						'text'  => 'Tiếp đến bạn ấn chuột phải và chọn **"Tải xuống/Download"** hoặc chọn **"Tệp"** và **"Tạo bản sao/Duplicate"** vào Google Drive của mình.',
					),
					array(
						'title' => 'Bước 3',
						'text'  => 'Xuất file theo định dạng **pdf** và nếu có dẫn link Google Drive trong bài làm thì đừng quên cấp quyền truy cập ở chế độ **"Người xem/Viewer"** nhé!',
					),
					array(
						'title'      => 'Bước 4',
						'text'       => 'Cuối cùng, truy cập [TẠI ĐÂY] để nộp đơn và cùng bắt đầu hành trình trở thành Scoms-ers ngay.',
						'link'       => array(
							'url'         => '',
							'is_external' => 'on',
						),
						'note'       => 'Hạn chót nộp đơn: 23:59, 30/11/2026',
						'note_until' => '2026-11-30 23:59',
					),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = is_array( $s['items'] ) ? $s['items'] : array();
		$last  = count( $items ) - 1;
		$arrow = '<span class="scl-st__arrow" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>';
		?>
		<section class="scl scl-st scl-defer"<?php echo $this->anchor_attr( $s ); ?> data-scl-motion>
			<div class="scl-container">
				<?php if ( $s['heading'] ) : ?>
					<div class="scl-head">
						<?php echo scl_title( $s['heading'], true ); ?>
					</div>
				<?php endif; ?>
				<ol class="scl-st__list">
					<?php
					foreach ( $items as $i => $item ) :
						$until = scl_iso( $item['note_until'] );
						$note  = $item['note'] ? ' <span class="scl-st__deadline"' . ( $until ? ' data-scl-until="' . esc_attr( $until ) . '"' : '' ) . '>' . esc_html( $item['note'] ) . '</span>' : '';
						?>
						<li class="scl-st__item scl-tone" data-scl-reveal style="--i:<?php echo (int) ( $i * 2 ); ?>"><h3 class="scl-st__step"><?php echo esc_html( $item['title'] ); ?></h3><p class="scl-st__text"><?php echo scl_inline( $item['text'], scl_url_attrs( $item['link'] ) ) . $note; ?></p><?php echo $i < $last ? $arrow : ''; ?></li>
					<?php endforeach; ?>
				</ol>
			</div>
		</section>
		<?php
	}
}
