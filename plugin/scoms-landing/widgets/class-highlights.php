<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCL_Highlights extends SCL_Widget {

	public function get_name() {
		return 'scl_highlights';
	}

	public function get_title() {
		return 'Highlights (Intro)';
	}

	public function get_icon() {
		return 'eicon-accordion';
	}

	public function get_style_depends() {
		return array( 'scl-highlights' );
	}

	public function get_script_depends() {
		return array( 'scl-motion', 'scl-panels' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_content', array( 'label' => 'Content' ) );

		$this->add_anchor_control( 'gioi-thieu' );
		$this->add_heading_control( 'Giới thiệu chung' );

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			array(
				'label'       => 'Tab title',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Tiêu đề',
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'image',
			array(
				'label'       => 'Image (1080 x 720, text inside the image)',
				'type'        => Controls_Manager::MEDIA,
				'default'     => array( 'url' => '' ),
				'description' => 'Empty = placeholder box.',
			)
		);

		$repeater->add_control(
			'text',
			array(
				'label'       => 'Image text (screen readers and SEO)',
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'description' => 'Not shown on screen. Copy the text that appears in the image. One paragraph per line.',
			)
		);

		$repeater->add_control(
			'show_button',
			array(
				'label'        => 'Show button',
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			)
		);

		$repeater->add_control(
			'button_text',
			array(
				'label'     => 'Button text',
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Tham gia ngay',
				'condition' => array( 'show_button' => 'yes' ),
			)
		);

		$repeater->add_control(
			'button_link',
			array(
				'label'     => 'Button link',
				'type'      => Controls_Manager::URL,
				'default'   => array( 'url' => '#ung-tuyen' ),
				'condition' => array( 'show_button' => 'yes' ),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => 'Panels',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'title' => 'Tổng quan',
						'text'  => 'Tìm kiếm Cộng tác viên là chương trình thường niên nhằm tìm kiếm những bạn trẻ yêu thích truyền thông, đồng thời tạo cơ hội trải nghiệm trong môi trường chuyên nghiệp và cùng lan tỏa những giá trị tích cực.',
					),
					array(
						'title' => 'S-Search 2026',
						'text'  => "Chương trình Tìm kiếm Cộng tác viên của Scoms đã chính thức trở lại, mang đến cơ hội để bạn gặp gỡ những người đồng hành mới, thử sức trong những trải nghiệm mới và khám phá những khía cạnh khác của bản thân.\nCùng Scoms bước qua từng chặng đường, tự tin thể hiện màu sắc riêng và viết nên hành trình của chính bạn nhé!",
					),
					array(
						'title' => 'Introduction Day',
						'text'  => "Introduction Day là hoạt động thuộc khuôn khổ Chương trình Tìm kiếm Cộng tác viên Tháng 11/2026, giúp sinh viên khám phá về Scoms, từ hoạt động, giá trị đến văn hóa của Nhóm.\nĐây cũng là dịp để bạn khám phá những \xE2\x80\x9Cbí mật\xE2\x80\x9D tại ngôi nhà S Đỏ qua chia sẻ từ các Scoms-ers kỳ cựu, đồng thời được giải đáp mọi thắc mắc trực tiếp cùng Ban Điều hành nhiệm kỳ XXV!",
					),
					array(
						'title'       => 'Tham gia ngay cùng Scoms nhé!',
						'text'        => "Chúng mình đã sẵn sàng chào đón và đồng hành cùng bạn trên hành trình đầy trải nghiệm này rồi đó!\nNhanh tay đăng ký thôi, tụi mình rất mong chờ được gặp mấy bạn đó!",
						'show_button' => 'yes',
						'button_text' => 'Tham gia ngay',
						'button_link' => array( 'url' => '#ung-tuyen' ),
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
		<section class="scl scl-hl scl-defer"<?php echo $this->anchor_attr( $s ); ?> data-scl-motion>
			<div class="scl-container">
				<?php if ( $s['heading'] ) : ?>
					<div class="scl-head">
						<?php echo scl_title( $s['heading'] ); ?>
					</div>
				<?php endif; ?>
				<div class="scl-hl__panels" data-scl-panels data-scl-reveal>
					<?php
					foreach ( $items as $i => $item ) :
						$n      = $i + 1;
						$body   = $this->uid( 'panel-' . $n );
						$active = 0 === $i;
						$img    = scl_image( $item['image'], 'scl-hl__media', '', array( 'aria-hidden' => 'true' ) );
						$link   = ( 'yes' === $item['show_button'] && $item['button_text'] ) ? scl_url_attrs( $item['button_link'] ) : '';
						?>
						<article class="scl-hl__panel<?php echo $active ? ' is-active' : ''; ?>" data-scl-panel>
							<button class="scl-hl__tab" type="button" data-scl-panel-tab aria-expanded="<?php echo $active ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $body ); ?>"><span class="scl-hl__num"><?php echo esc_html( str_pad( (string) $n, 2, '0', STR_PAD_LEFT ) ); ?></span><span class="scl-hl__label"><?php echo esc_html( $item['title'] ); ?></span><span class="scl-hl__icon" aria-hidden="true"><?php echo scl_icon( 'plus' ); ?></span></button>
							<div class="scl-hl__body" id="<?php echo esc_attr( $body ); ?>" tabindex="-1">
								<div class="scl-hl__inner">
									<div class="scl-sr-only"><h3><?php echo esc_html( $item['title'] ); ?></h3><?php echo scl_paragraphs( $item['text'] ); ?></div>
									<?php echo $img ? $img : scl_placeholder( 'scl-hl__media scl-ph--warm', 'Ảnh 1080 x 720 (3:2) - chữ nằm trong ảnh', 'aria-hidden="true"' ); ?>
									<?php if ( $link ) : ?>
										<div class="scl-hl__actions"><a class="scl-btn" <?php echo $link; ?>><?php echo scl_btn_inner( $item['button_text'], true ); ?></a></div>
									<?php endif; ?>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
