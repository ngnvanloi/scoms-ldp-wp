<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCL_Site_Footer extends SCL_Widget {

	const SOCIAL = array(
		'facebook' => array( 'Facebook', '<path d="M13.5 21v-7.5h2.6l.4-3h-3V8.6c0-.9.3-1.5 1.5-1.5h1.6V4.4c-.3 0-1.2-.1-2.3-.1-2.3 0-3.9 1.4-3.9 4v2.2H7.8v3h2.6V21z"/>' ),
		'linkedin' => array( 'LinkedIn', '<path d="M4.5 9h3.6v11H4.5zM6.3 3.5a2.1 2.1 0 1 1 0 4.2 2.1 2.1 0 0 1 0-4.2zM10.3 9h3.4v1.5h.1c.5-.9 1.7-1.8 3.4-1.8 3.6 0 4.3 2.4 4.3 5.5V20h-3.6v-5.1c0-1.2 0-2.8-1.7-2.8s-2 1.3-2 2.7V20h-3.6z"/>' ),
		'youtube'  => array( 'YouTube', '<path d="M21.6 7.6a2.6 2.6 0 0 0-1.8-1.8C18.2 5.4 12 5.4 12 5.4s-6.2 0-7.8.4a2.6 2.6 0 0 0-1.8 1.8C2 9.2 2 12 2 12s0 2.8.4 4.4a2.6 2.6 0 0 0 1.8 1.8c1.6.4 7.8.4 7.8.4s6.2 0 7.8-.4a2.6 2.6 0 0 0 1.8-1.8c.4-1.6.4-4.4.4-4.4s0-2.8-.4-4.4zM10 15V9l5.2 3z"/>' ),
	);

	public function get_name() {
		return 'scl_site_footer';
	}

	public function get_title() {
		return 'Landing Footer';
	}

	public function get_icon() {
		return 'eicon-footer';
	}

	public function get_style_depends() {
		return array( 'scl-site-footer' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_brand', array( 'label' => 'Brand' ) );

		$this->add_control(
			'logo',
			array(
				'label'   => 'Logo',
				'type'    => Controls_Manager::MEDIA,
				'default' => array( 'url' => SCL_URL . 'assets/images/logo-scoms.png' ),
			)
		);

		$this->add_control(
			'logo_link',
			array(
				'label'   => 'Logo link',
				'type'    => Controls_Manager::URL,
				'default' => array( 'url' => 'https://scommunicationsgroup.com/' ),
			)
		);

		$this->add_control(
			'follow_heading',
			array(
				'label'   => 'Follow heading',
				'type'    => Controls_Manager::TEXT,
				'default' => 'Theo dõi chúng tôi',
			)
		);

		$this->add_control(
			'org_title',
			array(
				'label'       => 'Organization',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Nhóm truyền thông sinh viên',
				'label_block' => true,
			)
		);

		$this->add_control(
			'org_text',
			array(
				'label'       => 'Organization note',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Trực thuộc Hội Sinh viên Đại học UEH',
				'label_block' => true,
			)
		);

		$social = new Repeater();

		$social->add_control(
			'network',
			array(
				'label'   => 'Network',
				'type'    => Controls_Manager::SELECT,
				'default' => 'facebook',
				'options' => array(
					'facebook' => 'Facebook',
					'linkedin' => 'LinkedIn',
					'youtube'  => 'YouTube',
				),
			)
		);

		$social->add_control(
			'url',
			array(
				'label' => 'Link',
				'type'  => Controls_Manager::URL,
			)
		);

		$this->add_control(
			'social',
			array(
				'label'       => 'Social links',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $social->get_controls(),
				'title_field' => '{{{ network }}}',
				'default'     => array(
					array(
						'network' => 'facebook',
						'url'     => array(
							'url'         => 'https://www.facebook.com/scoms.ueh',
							'is_external' => 'on',
						),
					),
					array(
						'network' => 'linkedin',
						'url'     => array(
							'url'         => 'https://www.linkedin.com/company/scommunications',
							'is_external' => 'on',
						),
					),
					array(
						'network' => 'youtube',
						'url'     => array(
							'url'         => 'https://www.youtube.com/@SCommunications',
							'is_external' => 'on',
						),
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_channels', array( 'label' => 'Channels' ) );

		$this->add_control(
			'channels_heading',
			array(
				'label'   => 'Heading',
				'type'    => Controls_Manager::TEXT,
				'default' => 'Kênh truyền thông',
			)
		);

		$channel = new Repeater();

		$channel->add_control(
			'label',
			array(
				'label'   => 'Label',
				'type'    => Controls_Manager::TEXT,
				'default' => 'Kênh',
			)
		);

		$channel->add_control(
			'url',
			array(
				'label' => 'Link',
				'type'  => Controls_Manager::URL,
			)
		);

		$this->add_control(
			'channels',
			array(
				'label'       => 'Channels',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $channel->get_controls(),
				'title_field' => '{{{ label }}}',
				'default'     => array(
					array(
						'label' => 'STV',
						'url'   => array( 'url' => 'https://scommunicationsgroup.com/stv/' ),
					),
					array(
						'label' => 'S Radio',
						'url'   => array( 'url' => 'https://scommunicationsgroup.com/s-radio/' ),
					),
					array(
						'label' => 'UEHenter',
						'url'   => array( 'url' => 'https://scommunicationsgroup.com/uehenter/' ),
					),
					array(
						'label' => 'The S Magazine',
						'url'   => array(
							'url'         => 'https://uehenter.vn/s-communications/the-s-magazine',
							'is_external' => 'on',
						),
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section( 'section_contact', array( 'label' => 'Contact' ) );

		$this->add_control(
			'contact_heading',
			array(
				'label'   => 'Heading',
				'type'    => Controls_Manager::TEXT,
				'default' => 'Liên hệ',
			)
		);

		$contact = new Repeater();

		$contact->add_control(
			'name',
			array(
				'label'       => 'Name',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Họ tên',
				'label_block' => true,
			)
		);

		$contact->add_control(
			'phone',
			array(
				'label' => 'Phone',
				'type'  => Controls_Manager::TEXT,
			)
		);

		$contact->add_control(
			'role',
			array(
				'label'       => 'Role',
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			)
		);

		$this->add_control(
			'contacts',
			array(
				'label'       => 'People',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $contact->get_controls(),
				'title_field' => '{{{ name }}}',
				'default'     => array(
					array(
						'name'  => 'Mr. Thái Thành Tiến',
						'phone' => '0939 403 530',
						'role'  => 'Trưởng Nhóm',
					),
					array(
						'name'  => 'Mrs. Nguyễn Ngọc Mai Phương',
						'phone' => '0934 142 182',
						'role'  => 'Trưởng Bộ phận Đối ngoại',
					),
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

		$this->start_controls_section( 'section_bottom', array( 'label' => 'Bottom bar' ) );

		$this->add_control(
			'copyright',
			array(
				'label'       => 'Copyright',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Copyright 2026 S Communications.',
				'label_block' => true,
			)
		);

		$this->add_control(
			'top_text',
			array(
				'label'   => 'Back to top text',
				'type'    => Controls_Manager::TEXT,
				'default' => 'Lên đầu trang',
			)
		);

		$this->add_control(
			'top_target',
			array(
				'label'   => 'Back to top target',
				'type'    => Controls_Manager::TEXT,
				'default' => '#top',
			)
		);

		$this->end_controls_section();
	}

	private function person_icon() {
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="3"/><circle cx="12" cy="10" r="3"/><path d="M7.5 17.5c1-2 2.6-3 4.5-3s3.5 1 4.5 3"/></svg>';
	}

	private function mail_icon() {
		return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="M4 7l8 6 8-6"/></svg>';
	}

	protected function render() {
		$s        = $this->get_settings_for_display();
		$logo     = scl_image( $s['logo'], 'scl-ft__logo-img', 'S Communications', empty( $s['logo']['id'] ) ? array( 'width' => '400', 'height' => '298' ) : array() );
		$logo_url = scl_url_attrs( $s['logo_link'] );
		$email    = sanitize_email( $s['email'] );
		$social   = is_array( $s['social'] ) ? $s['social'] : array();
		$channels = is_array( $s['channels'] ) ? $s['channels'] : array();
		$contacts = is_array( $s['contacts'] ) ? $s['contacts'] : array();
		$top      = trim( (string) $s['top_target'] );
		?>
		<footer class="scl scl-ft">
			<div class="scl-container">
				<div class="scl-ft__grid">
					<div class="scl-ft__brand">
						<?php if ( $logo ) : ?>
							<?php if ( $logo_url ) : ?>
								<a class="scl-ft__logo" <?php echo $logo_url; ?>><?php echo $logo; ?></a>
							<?php else : ?>
								<span class="scl-ft__logo"><?php echo $logo; ?></span>
							<?php endif; ?>
						<?php endif; ?>
						<?php if ( $s['follow_heading'] ) : ?>
							<p class="scl-ft__heading"><?php echo esc_html( $s['follow_heading'] ); ?></p>
						<?php endif; ?>
						<?php if ( $s['org_title'] || $s['org_text'] ) : ?>
							<p class="scl-ft__org"><?php if ( $s['org_title'] ) : ?><strong><?php echo esc_html( $s['org_title'] ); ?></strong><?php endif; ?><?php if ( $s['org_text'] ) : ?><span><?php echo esc_html( $s['org_text'] ); ?></span><?php endif; ?></p>
						<?php endif; ?>
						<?php if ( $social ) : ?>
							<ul class="scl-ft__social">
								<?php
								foreach ( $social as $item ) :
									$link = scl_url_attrs( $item['url'] );
									if ( ! $link || ! isset( self::SOCIAL[ $item['network'] ] ) ) {
										continue;
									}
									list( $label, $path ) = self::SOCIAL[ $item['network'] ];
									?>
									<li><a class="scl-ft__icon" <?php echo $link; ?> aria-label="<?php echo esc_attr( $label ); ?>"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><?php echo $path; ?></svg></a></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
					<?php if ( $channels ) : ?>
						<div class="scl-ft__col">
							<?php if ( $s['channels_heading'] ) : ?>
								<p class="scl-ft__heading"><?php echo esc_html( $s['channels_heading'] ); ?></p>
							<?php endif; ?>
							<ul class="scl-ft__list">
								<?php
								foreach ( $channels as $item ) :
									$link = scl_url_attrs( $item['url'] );
									?>
									<li><?php if ( $link ) : ?><a class="scl-ft__link" <?php echo $link; ?>><?php echo esc_html( $item['label'] ); ?></a><?php else : ?><?php echo esc_html( $item['label'] ); ?><?php endif; ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
					<?php if ( $contacts || $email ) : ?>
						<div class="scl-ft__col">
							<?php if ( $s['contact_heading'] ) : ?>
								<p class="scl-ft__heading"><?php echo esc_html( $s['contact_heading'] ); ?></p>
							<?php endif; ?>
							<ul class="scl-ft__list scl-ft__contacts">
								<?php
								foreach ( $contacts as $item ) :
									$tel = preg_replace( '/[^0-9+]/', '', (string) $item['phone'] );
									?>
									<li><?php echo $this->person_icon(); ?><span><?php echo esc_html( $item['name'] ); ?><?php if ( $tel ) : ?> <span class="scl-ft__nowrap">(<a class="scl-ft__link" href="tel:<?php echo esc_attr( $tel ); ?>"><?php echo esc_html( $item['phone'] ); ?></a>)</span><?php endif; ?><?php if ( $item['role'] ) : ?><small><?php echo esc_html( $item['role'] ); ?></small><?php endif; ?></span></li>
								<?php endforeach; ?>
								<?php if ( $email ) : ?>
									<li><?php echo $this->mail_icon(); ?><span><a class="scl-ft__link" href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></span></li>
								<?php endif; ?>
							</ul>
						</div>
					<?php endif; ?>
				</div>
				<div class="scl-ft__bottom">
					<?php if ( $s['copyright'] ) : ?>
						<p><?php echo esc_html( $s['copyright'] ); ?></p>
					<?php endif; ?>
					<?php if ( $s['top_text'] && $top ) : ?>
						<a class="scl-ft__top" href="<?php echo esc_attr( $top ); ?>"><?php echo esc_html( $s['top_text'] ); ?> <?php echo scl_icon( 'up' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</footer>
		<?php
	}
}
