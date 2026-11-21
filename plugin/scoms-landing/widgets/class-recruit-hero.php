<?php
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCL_Recruit_Hero extends SCL_Widget {

	public function get_name() {
		return 'scl_recruit_hero';
	}

	public function get_title() {
		return 'Recruit Hero';
	}

	public function get_icon() {
		return 'eicon-banner';
	}

	public function get_style_depends() {
		return array( 'scl-recruit-hero', 'scl-flipclock' );
	}

	public function get_script_depends() {
		return array( 'scl-motion', 'scl-flipclock' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_content', array( 'label' => 'Content' ) );

		$this->add_anchor_control( 'top' );

		$this->add_control(
			'image',
			array(
				'label'       => 'Key visual (2048 x 878)',
				'type'        => Controls_Manager::MEDIA,
				'default'     => array( 'url' => '' ),
				'description' => 'Empty = placeholder box.',
			)
		);

		$this->add_control(
			'image_alt',
			array(
				'label'       => 'Key visual alt text',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Bộ nhận diện chương trình Tìm kiếm Cộng tác viên T11/2026',
				'label_block' => true,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => 'Title',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Tìm kiếm CTV',
				'label_block' => true,
			)
		);

		$this->add_control(
			'title_highlight',
			array(
				'label'       => 'Title highlight (red)',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'T11/2026',
				'label_block' => true,
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'   => 'Button text',
				'type'    => Controls_Manager::TEXT,
				'default' => 'Tham gia ngay',
			)
		);

		$this->add_control(
			'button_link',
			array(
				'label'   => 'Button link',
				'type'    => Controls_Manager::URL,
				'default' => array( 'url' => '#ung-tuyen' ),
			)
		);

		$this->add_control(
			'date_label',
			array(
				'label'       => 'Date range label (screen readers)',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Vòng đơn từ',
				'label_block' => true,
			)
		);

		$this->add_control(
			'date_from',
			array(
				'label'   => 'Date from',
				'type'    => Controls_Manager::TEXT,
				'default' => '22/11',
			)
		);

		$this->add_control(
			'date_to',
			array(
				'label'   => 'Date to',
				'type'    => Controls_Manager::TEXT,
				'default' => '30/11',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_clock', array( 'label' => 'Countdown' ) );

		$this->add_control(
			'show_clock',
			array(
				'label'        => 'Show countdown',
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'deadline',
			array(
				'label'       => 'Deadline',
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => '2026-11-30 23:59',
				'description' => 'Uses the site timezone (Settings > General, must be UTC+7).',
			)
		);

		$this->add_control(
			'deadline_extend',
			array(
				'label'       => 'Extended deadline (optional)',
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => '2026-12-01 23:59',
				'description' => 'After the deadline the clock keeps counting to this time, then stops at 00.',
			)
		);

		$this->add_control(
			'caption',
			array(
				'label'       => 'Caption',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Hạn chót nộp đơn',
				'label_block' => true,
				'description' => 'Shown with the deadline time, hidden after the deadline.',
			)
		);

		$this->end_controls_section();
	}

	private function tile( $unit, $label, $value ) {
		return '<div class="scl-flip__group"><div class="scl-flip__tile" data-flip-unit="' . $unit . '"><span class="scl-flip__plate scl-flip__plate--top"></span>'
			. '<span class="scl-flip__plate scl-flip__plate--bottom"></span><span class="scl-flip__digits"><span class="scl-flip__num">' . $value . '</span></span></div>'
			. '<span class="scl-flip__label">' . esc_html( $label ) . '</span></div>';
	}

	private function remaining( $targets ) {
		$now = time();
		foreach ( $targets as $iso ) {
			$ts = strtotime( $iso );
			if ( $ts && $ts > $now ) {
				$left = $ts - $now;
				return array(
					min( 99, (int) floor( $left / 86400 ) ),
					(int) floor( $left % 86400 / 3600 ),
					(int) floor( $left % 3600 / 60 ),
					$left % 60,
				);
			}
		}
		return array( 0, 0, 0, 0 );
	}

	protected function render() {
		$s        = $this->get_settings_for_display();
		$deadline = scl_iso( $s['deadline'] );
		$extend   = scl_iso( $s['deadline_extend'] );
		$link     = scl_url_attrs( $s['button_link'] );
		$kv       = scl_image(
			$s['image'],
			'scl-rh__kv',
			$s['image_alt'],
			array(
				'loading'       => 'eager',
				'fetchpriority' => 'high',
			)
		);
		?>
		<section class="scl scl-rh"<?php echo $this->anchor_attr( $s ); ?> data-scl-motion>
			<div class="scl-container scl-rh__inner">
				<?php echo $kv ? $kv : scl_placeholder( 'scl-rh__kv scl-ph--warm', 'Key visual 2048 x 878', 'role="img" aria-label="' . esc_attr( $s['image_alt'] ) . '"' ); ?>
				<?php if ( $s['title'] || $s['title_highlight'] ) : ?>
					<h1 class="scl-rh__title"><span class="scl-line"><span><?php echo esc_html( $s['title'] ); ?><?php if ( $s['title_highlight'] ) : ?> <em><?php echo esc_html( $s['title_highlight'] ); ?></em><?php endif; ?></span></span></h1>
				<?php endif; ?>
				<div class="scl-rh__cta">
					<?php if ( $s['button_text'] && $link ) : ?>
						<a class="scl-btn" <?php echo $link; ?>><?php echo scl_btn_inner( $s['button_text'] ); ?></a>
					<?php endif; ?>
					<?php if ( $s['date_from'] ) : ?>
						<p class="scl-rh__date"><?php if ( $s['date_label'] ) : ?><span class="scl-sr-only"><?php echo esc_html( $s['date_label'] ); ?></span><?php endif; ?><?php echo esc_html( $s['date_from'] ); ?><?php if ( $s['date_to'] ) : ?> <?php echo scl_icon( 'arrow' ); ?><span class="scl-sr-only">đến</span> <?php echo esc_html( $s['date_to'] ); ?><?php endif; ?></p>
					<?php endif; ?>
				</div>
				<?php
				if ( 'yes' === $s['show_clock'] && $deadline ) :
					$left = $this->remaining( array_filter( array( $deadline, $extend ) ) );
					$pad  = array_map(
						function ( $n ) {
							return str_pad( (string) $n, 2, '0', STR_PAD_LEFT );
						},
						$left
					);
					$time = new DateTimeImmutable( $deadline );
					?>
					<div class="scl-flip scl-rh__clock" data-scl-flipclock="<?php echo esc_attr( $deadline ); ?>"<?php echo $extend ? ' data-scl-flipclock-extend="' . esc_attr( $extend ) . '"' : ''; ?> role="timer" aria-label="Đồng hồ đếm ngược hạn nộp đơn">
						<?php if ( $s['caption'] ) : ?>
							<p class="scl-flip__caption" data-scl-until="<?php echo esc_attr( $deadline ); ?>"><?php echo esc_html( $s['caption'] ); ?> <strong><?php echo esc_html( $time->format( 'H:i, d/m/Y' ) ); ?></strong></p>
						<?php endif; ?>
						<div class="scl-flip__row" aria-hidden="true"><?php echo $this->tile( 'days', 'Ngày', $pad[0] ) . $this->tile( 'hours', 'Giờ', $pad[1] ) . $this->tile( 'minutes', 'Phút', $pad[2] ) . $this->tile( 'seconds', 'Giây', $pad[3] ); ?></div>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
