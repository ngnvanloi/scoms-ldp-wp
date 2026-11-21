<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCL_Faq extends SCL_Widget {

	public function get_name() {
		return 'scl_faq';
	}

	public function get_title() {
		return 'FAQ';
	}

	public function get_icon() {
		return 'eicon-help-o';
	}

	public function get_style_depends() {
		return array( 'scl-faq' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_content', array( 'label' => 'Content' ) );

		$this->add_anchor_control( 'faq' );
		$this->add_heading_control( 'Bạn có thắc mắc gì muốn hỏi chúng mình nè?' );

		$repeater = new Repeater();

		$repeater->add_control(
			'question',
			array(
				'label'       => 'Question',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Câu hỏi?',
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'answer',
			array(
				'label'       => 'Answer',
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'description' => 'One paragraph per line. **text** = bold.',
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => 'Questions',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ question }}}',
				'default'     => array(
					array(
						'question' => 'Em chưa có kinh nghiệm về truyền thông thì có thể ứng tuyển không ạ?',
						'answer'   => "S Communications luôn chào đón những bạn sinh viên nhiệt huyết, có tinh thần học hỏi và đặc biệt là niềm yêu thích đối với lĩnh vực truyền thông. Vì vậy, bạn đừng quá lo lắng nếu chưa có nhiều kinh nghiệm nhé!\nChúng mình tin rằng thái độ cầu tiến và sự chủ động sẽ là những yếu tố quan trọng giúp bạn phát triển khi tham gia Nhóm. Mong sớm gặp bạn tại S Communications!",
					),
					array(
						'question' => 'Sinh viên ngoài UEH có thể apply không ạ?',
						'answer'   => 'Hiện tại, S Communications đang tìm kiếm các bạn sinh viên đang học tập trên địa bàn Thành phố Hồ Chí Minh. Bạn có thể tham khảo thông tin chi tiết về điều kiện tham gia tại bài đăng chương trình nhé!',
					),
					array(
						'question' => 'Em có 02 nguyện vọng là 02 Team thuộc cùng một Bộ phận/Ekip thì cần nộp mấy đơn ạ?',
						'answer'   => 'Nếu bạn chọn 02 Team thuộc cùng một Bộ phận/Ekip thì bạn chỉ cần điền 01 đơn thôi nha. Đừng quên ghi rõ thứ tự nguyện vọng của mình trong form để chúng mình nắm được nhé.',
					),
				),
			)
		);

		$this->add_control(
			'note_heading',
			array(
				'label'     => 'Contact note',
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'note_text',
			array(
				'label'       => 'Note text',
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => 'Nếu cần trao đổi thêm, bạn có thể kết nối với chúng mình qua',
				'description' => 'Empty = hide the note.',
			)
		);

		$this->add_control(
			'facebook_label',
			array(
				'label'   => 'Facebook label',
				'type'    => Controls_Manager::TEXT,
				'default' => 'S Communications',
			)
		);

		$this->add_control(
			'facebook_url',
			array(
				'label'   => 'Facebook link',
				'type'    => Controls_Manager::URL,
				'default' => array(
					'url'         => 'https://www.facebook.com/scoms.ueh',
					'is_external' => 'on',
				),
			)
		);

		$this->add_control(
			'email',
			array(
				'label'   => 'Email',
				'type'    => Controls_Manager::TEXT,
				'default' => 'contact@scommunicationsgroup.com',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = is_array( $s['items'] ) ? $s['items'] : array();
		$name  = $this->uid( 'faq' );
		$fb    = $s['facebook_label'] ? scl_url_attrs( $s['facebook_url'] ) : '';
		$email = sanitize_email( $s['email'] );
		$parts = array();
		if ( $fb ) {
			$parts[] = 'Facebook <a ' . $fb . '>' . esc_html( $s['facebook_label'] ) . '</a>';
		}
		if ( $email ) {
			$parts[] = 'email <a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
		}
		?>
		<section class="scl scl-fq scl-defer"<?php echo $this->anchor_attr( $s ); ?> data-scl-motion>
			<div class="scl-container">
				<div class="scl-fq__panel" data-scl-reveal>
					<?php echo scl_title( $s['heading'] ); ?>
					<div class="scl-fq__list">
						<?php foreach ( $items as $i => $item ) : ?>
							<details class="scl-fq__item" name="<?php echo esc_attr( $name ); ?>"<?php echo 0 === $i ? ' open' : ''; ?>><summary class="scl-fq__q"><span class="scl-fq__mark" aria-hidden="true">?</span><span class="scl-fq__q-text"><?php echo esc_html( $item['question'] ); ?></span><span class="scl-fq__icon" aria-hidden="true"></span></summary><div class="scl-fq__a"><?php echo scl_paragraphs( $item['answer'] ); ?></div></details>
						<?php endforeach; ?>
					</div>
					<?php if ( trim( (string) $s['note_text'] ) ) : ?>
						<p class="scl-fq__note"><?php echo esc_html( $s['note_text'] ); ?><?php echo $parts ? ' ' . implode( ' hoặc ', $parts ) : ''; ?></p>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
