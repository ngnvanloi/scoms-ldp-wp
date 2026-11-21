<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCL_Notes extends SCL_Widget {

	public function get_name() {
		return 'scl_notes';
	}

	public function get_title() {
		return 'Notes';
	}

	public function get_icon() {
		return 'eicon-bullet-list';
	}

	public function get_style_depends() {
		return array( 'scl-notes' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_content', array( 'label' => 'Content' ) );

		$this->add_anchor_control( 'luu-y' );

		$this->add_control(
			'image',
			array(
				'label'       => 'Background image (1920 x 1080)',
				'type'        => Controls_Manager::MEDIA,
				'default'     => array( 'url' => '' ),
				'description' => 'Empty = soft pink background.',
			)
		);

		$this->add_heading_control( 'Bạn nhớ lưu ý' );

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			array(
				'label'       => 'Text',
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'description' => '**text** = bold.',
			)
		);

		$repeater->add_control(
			'format',
			array(
				'label'       => 'File name format (optional)',
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'example',
			array(
				'label'       => 'Example (optional)',
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'hint',
			array(
				'label' => 'Small note (optional)',
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 2,
			)
		);

		$repeater->add_control(
			'highlight',
			array(
				'label'        => 'Highlight',
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => 'Notes',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ text.substring( 0, 40 ) }}}',
				'default'     => array(
					array(
						'text' => 'Bạn có thể lựa chọn hoàn thành đơn theo form của chúng mình hoặc tự do sáng tạo theo cách riêng của bạn. Nhưng hãy chắc chắn rằng bạn vẫn đảm bảo được thông tin và trả lời đầy đủ các câu hỏi của nội dung đơn (không thiếu câu hỏi, không thay đổi thứ tự câu hỏi).',
					),
					array(
						'text' => '**Nếu bạn có nguyện vọng vào 1 Bộ phận/ Ekip:** Bạn cần hoàn thành 1 đơn đăng ký của Bộ phận/Ekip đó trước khi hết hạn đăng ký.',
					),
					array(
						'text' => '**Nếu bạn có nguyện vọng vào 2 Bộ phận/Ekip:** Bạn cần hoàn thành 2 đơn đăng ký của Bộ phận/Ekip đó trước khi hết hạn đăng ký.',
					),
					array(
						'text'    => 'Đơn đăng ký phải được lưu dưới dạng PDF và đặt tên đúng cú pháp:',
						'format'  => 'Bộ phận/Ekip đăng kí_Vị trí đăng ký_Họ và tên_Khóa',
						'example' => 'HR_Quản lý & Phát triển Nhân sự_Nguyễn Văn A_K52',
						'hint'    => '(Một Bộ phận/Ekip có thể có nhiều vị trí khác nhau, bạn hãy xem thật kĩ JDs để chọn đúng vị trí mong muốn nhé.)',
					),
					array(
						'text'      => '**Lưu ý:** Mỗi bạn chỉ có thể lựa chọn tối đa 02 nguyện vọng ở 02 Bộ phận/Ekip khác nhau.',
						'highlight' => 'yes',
					),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = is_array( $s['items'] ) ? $s['items'] : array();
		$bg    = scl_image( $s['image'], 'scl-nt__backdrop', '', array( 'aria-hidden' => 'true' ) );
		?>
		<section class="scl scl-nt scl-defer"<?php echo $this->anchor_attr( $s ); ?> data-scl-motion>
			<div class="scl-container">
				<div class="scl-nt__stage">
					<?php echo $bg ? $bg : scl_placeholder( 'scl-nt__backdrop scl-ph--warm', 'Ảnh nền 1920 x 1080 (16:9)', 'aria-hidden="true"' ); ?>
					<div class="scl-nt__card" data-scl-reveal>
						<?php if ( $s['heading'] ) : ?>
							<h2 class="scl-nt__title"><?php echo esc_html( $s['heading'] ); ?></h2>
						<?php endif; ?>
						<ol class="scl-nt__list">
							<?php
							foreach ( $items as $i => $item ) :
								$extra = $item['format'] || $item['example'] || $item['hint'];
								?>
								<li class="scl-nt__item<?php echo 'yes' === $item['highlight'] ? ' scl-nt__item--key' : ''; ?>"><span class="scl-nt__num" aria-hidden="true"><?php echo (int) ( $i + 1 ); ?></span>
									<?php if ( $extra ) : ?>
										<div><p><?php echo scl_inline( $item['text'] ); ?></p>
											<div class="scl-nt__format">
												<?php if ( $item['format'] ) : ?>
													<code><?php echo esc_html( $item['format'] ); ?></code>
												<?php endif; ?>
												<?php if ( $item['example'] ) : ?>
													<span>VD: <code><?php echo esc_html( $item['example'] ); ?></code></span>
												<?php endif; ?>
												<?php if ( $item['hint'] ) : ?>
													<small><?php echo esc_html( $item['hint'] ); ?></small>
												<?php endif; ?>
											</div></div>
									<?php else : ?>
										<p><?php echo scl_inline( $item['text'] ); ?></p>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ol>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
