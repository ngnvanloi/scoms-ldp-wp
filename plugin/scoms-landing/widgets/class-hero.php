<?php
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCL_Hero extends Widget_Base {

	public function get_name() {
		return 'scl_hero';
	}

	public function get_title() {
		return 'Hero';
	}

	public function get_icon() {
		return 'eicon-banner';
	}

	public function get_categories() {
		return array( 'scoms-landing' );
	}

	public function get_style_depends() {
		return array( 'scl-hero' );
	}

	public function get_script_depends() {
		return array( 'scl-countdown' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_content', array( 'label' => 'Content' ) );

		$this->add_control(
			'image',
			array(
				'label' => 'Background image',
				'type'  => Controls_Manager::MEDIA,
			)
		);

		$this->add_control(
			'meta',
			array(
				'label'       => 'Date / location',
				'type'        => Controls_Manager::TEXT,
				'default'     => '20.12.2026 - GEM Center, TP.HCM',
				'label_block' => true,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'   => 'Title',
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 2,
				'default' => 'Brand Experience Day 2026',
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => 'Description',
				'type'    => Controls_Manager::TEXTAREA,
				'default' => 'Một ngày gặp gỡ các thương hiệu, agency và nhà sáng tạo nội dung hàng đầu.',
			)
		);

		$this->add_control(
			'countdown',
			array(
				'label'       => 'Countdown to (empty = hide)',
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => '2026-12-20 09:00',
				'description' => 'Uses the site timezone (Settings > General).',
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'   => 'Button text',
				'type'    => Controls_Manager::TEXT,
				'default' => 'Xem chương trình',
			)
		);

		$this->add_control(
			'button_link',
			array(
				'label'       => 'Button link',
				'type'        => Controls_Manager::URL,
				'default'     => array( 'url' => '#chuong-trinh' ),
				'description' => 'Link to another section: set its CSS ID (Advanced tab), then use #that-id here.',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => 'Colors',
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'accent',
			array(
				'label'     => 'Accent color',
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .scl-hero' => '--scl-accent: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'overlay',
			array(
				'label'     => 'Image darkness (%)',
				'type'      => Controls_Manager::SLIDER,
				'range'     => array( 'px' => array( 'min' => 0, 'max' => 90 ) ),
				'default'   => array( 'size' => 55 ),
				'selectors' => array( '{{WRAPPER}} .scl-hero' => '--scl-overlay: {{SIZE}}%;' ),
			)
		);

		$this->end_controls_section();
	}

	private function countdown_iso( $value ) {
		if ( empty( $value ) ) {
			return '';
		}
		try {
			$date = new DateTimeImmutable( $value, wp_timezone() );
			return $date->format( 'c' );
		} catch ( Exception $e ) {
			return '';
		}
	}

	protected function render() {
		$s         = $this->get_settings_for_display();
		$countdown = $this->countdown_iso( $s['countdown'] );

		if ( ! empty( $s['button_link']['url'] ) ) {
			$this->add_link_attributes( 'button', $s['button_link'] );
		}
		?>
		<section class="scl scl-hero">
			<?php
			if ( ! empty( $s['image']['id'] ) ) {
				echo wp_get_attachment_image(
					$s['image']['id'],
					'full',
					false,
					array(
						'class'         => 'scl-hero__bg',
						'alt'           => '',
						'loading'       => 'eager',
						'fetchpriority' => 'high',
					)
				);
			}
			?>
			<div class="scl-container">
				<div class="scl-hero__content">
					<?php if ( $s['meta'] ) : ?>
						<p class="scl-hero__meta"><?php echo esc_html( $s['meta'] ); ?></p>
					<?php endif; ?>

					<?php if ( $s['title'] ) : ?>
						<h1 class="scl-hero__title"><?php echo nl2br( esc_html( $s['title'] ) ); ?></h1>
					<?php endif; ?>

					<?php if ( $s['description'] ) : ?>
						<p class="scl-hero__desc"><?php echo nl2br( esc_html( $s['description'] ) ); ?></p>
					<?php endif; ?>

					<?php if ( $countdown ) : ?>
						<div class="scl-countdown" data-scl-countdown="<?php echo esc_attr( $countdown ); ?>" role="timer" aria-label="Thời gian còn lại đến sự kiện">
							<div class="scl-countdown__units">
								<div class="scl-countdown__unit"><span class="scl-countdown__num" data-unit="days">00</span><span class="scl-countdown__label">Ngày</span></div>
								<div class="scl-countdown__unit"><span class="scl-countdown__num" data-unit="hours">00</span><span class="scl-countdown__label">Giờ</span></div>
								<div class="scl-countdown__unit"><span class="scl-countdown__num" data-unit="minutes">00</span><span class="scl-countdown__label">Phút</span></div>
								<div class="scl-countdown__unit"><span class="scl-countdown__num" data-unit="seconds">00</span><span class="scl-countdown__label">Giây</span></div>
							</div>
							<p class="scl-countdown__done" hidden>Sự kiện đã bắt đầu</p>
						</div>
					<?php endif; ?>

					<?php if ( $s['button_text'] && ! empty( $s['button_link']['url'] ) ) : ?>
						<a class="scl-hero__btn" <?php $this->print_render_attribute_string( 'button' ); ?>><?php echo esc_html( $s['button_text'] ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
