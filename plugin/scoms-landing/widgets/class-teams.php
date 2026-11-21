<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCL_Teams extends SCL_Widget {

	public function get_name() {
		return 'scl_teams';
	}

	public function get_title() {
		return 'Teams Carousel';
	}

	public function get_icon() {
		return 'eicon-slider-3d';
	}

	public function get_style_depends() {
		return array( 'scl-teams', 'scl-modal' );
	}

	public function get_script_depends() {
		return array( 'scl-motion', 'scl-carousel', 'scl-modal' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_content', array( 'label' => 'Content' ) );

		$this->add_anchor_control( 'bo-phan' );
		$this->add_heading_control( '7 Bộ phận/Ekip nhà S' );

		$this->add_control(
			'button_text',
			array(
				'label'   => 'Card button text',
				'type'    => Controls_Manager::TEXT,
				'default' => 'Xem JD',
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'name',
			array(
				'label'   => 'Name',
				'type'    => Controls_Manager::TEXT,
				'default' => 'Tên bộ phận',
			)
		);

		$repeater->add_control(
			'modal_title',
			array(
				'label'       => 'Popup title',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Bộ phận',
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'image',
			array(
				'label'       => 'Image (864 x 1080)',
				'type'        => Controls_Manager::MEDIA,
				'default'     => array( 'url' => '' ),
				'description' => 'Empty = placeholder box.',
			)
		);

		$repeater->add_control(
			'jd',
			array(
				'label'       => 'Job description',
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 16,
				'description' => 'One item per line. "# " = position title, "## " = group heading, "- " = bullet. Other lines become paragraphs. Example: # 1. Designer / ## a. Bạn sẽ làm gì? / - Thiết kế...',
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => 'Teams',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'default'     => self::defaults(),
			)
		);

		$this->end_controls_section();
	}

	private static function defaults() {
		return array(
			array(
				'name'        => 'Creative',
				'modal_title' => 'Bộ phận Creative',
				'jd'          => '# 1. Designer
## a. Bạn sẽ làm gì?
- Đảm nhận thiết kế các hình ảnh truyền thông, hình ảnh in ấn các chương trình sự kiện truyền thông Nhóm.
## b. Điểm cộng cho bạn nếu
- Có kiến thức cơ bản về các phần mềm đồ họa (Photoshop, Illustrator, Canva,...).
- Yêu thích công việc thiết kế hình ảnh và có tinh thần cầu tiến, ham học hỏi.
- Có khả năng research, tự tìm kiếm cảm hứng thiết kế.
- Có sự kiên nhẫn, khả năng thích nghi cao, nền tảng tư duy thẩm mỹ tốt và đa dạng.
- Có kinh nghiệm thiết kế; hiểu biết cơ bản về nhiếp ảnh và biết chụp ảnh là một lợi thế.

# 2. Photographer
## a. Bạn sẽ làm gì?
- Đảm nhận công việc chụp ảnh truyền thông, sự kiện trong và ngoài Nhóm.
- Đảm nhận thiết kế hỗ trợ các hình ảnh truyền thông của Nhóm.
## b. Điểm cộng cho bạn nếu
- Yêu thích công việc nhiếp ảnh, có tinh thần cầu tiến và ham học hỏi.
- Có khả năng research concept, tạo dáng (pose) và góc máy chụp.
- Có sự kiên nhẫn, khả năng thích nghi cao, nền tảng tư duy thẩm mỹ tốt và đa dạng.
- Có kinh nghiệm chụp ảnh sự kiện và chụp ảnh studio là một lợi thế.
- Có máy ảnh là lợi thế, đồng thời có hiểu biết nền tảng về kỹ thuật chụp và hậu kỳ ảnh.
- Có mong muốn học hỏi về thiết kế là một lợi thế.',
			),
			array(
				'name'        => 'ER',
				'modal_title' => 'Bộ phận ER',
				'jd'          => '# 1. Truyền thông
## a. Bạn sẽ làm gì?
- Đảm nhận các vị trí Truyền thông (Online/Offline/PR) của Nhóm.
- Xây dựng kế hoạch truyền thông cho các Chương trình/Dự án Nhóm.
- Quản lý và triển khai thực thi các kế hoạch truyền thông của Chương trình/Dự án Nhóm.
- Lên ý tưởng sơ bộ và chi tiết cho các nội dung truyền thông Nhóm.
- Phối hợp cùng team kỹ thuật để thực thi sản xuất các nội dung truyền thông đa nền tảng, đa phương tiện.
## b. Điểm cộng cho bạn nếu
- Đam mê tìm hiểu về truyền thông và mong muốn thực hiện các hoạt động truyền thông sáng tạo.
- Có trách nhiệm, cẩn thận và chủ động trong công việc.
- Làm việc có kế hoạch và có tư duy chiến lược.
- Năng động, tích cực và đang tìm kiếm một môi trường có thể thỏa sức sáng tạo.
- Không ngại dấn thân trải nghiệm, có tinh thần học hỏi mọi khía cạnh trong truyền thông.
- Sáng tạo và nhạy bén với các xu hướng mới.
- Có tư duy thẩm mỹ về hình ảnh và video, biết thiết kế, quay dựng là điểm cộng.

# 2. Đối ngoại - Vận động Tài trợ
## a. Bạn sẽ làm gì?
- Đảm nhận các vị trí Đối ngoại và Vận động Tài trợ của Nhóm.
- Quản lý hòm mail, Fanpage, Instagram và LinkedIn của Nhóm với vai trò Đối ngoại.
- Liên hệ và làm việc trực tiếp với các CLB/Đội/Nhóm, Đối tác Truyền thông, Doanh nghiệp và Influencers nhằm tạo lập, phát triển và duy trì mối quan hệ tốt đẹp.
- Quản lý và triển khai các công việc liên quan đến Đối ngoại.
- Tìm kiếm Nhà Tài trợ, xây dựng kế hoạch hợp tác, thương lượng và ký kết giấy tờ cho các Chương trình/Dự án Nhóm.
- Làm việc trực tiếp với Nhà Tài trợ để triển khai kế hoạch hợp tác, từ đó duy trì mối quan hệ tốt đẹp với Nhà Tài trợ.
## b. Điểm cộng cho bạn nếu
- Mong muốn phát triển về mảng Đối ngoại, Tài trợ.
- Có khả năng quản trị tốt.
- Tự tin, khéo léo, khả năng giao tiếp tốt.
- Có trách nhiệm, cẩn thận và chủ động trong công việc.
- Quản lý tốt thời gian để hỗ trợ đối tác, nhà tài trợ nếu có vấn đề cần trao đổi.
- Có tư duy nhạy bén và khả năng giải quyết vấn đề.
- Cởi mở, mạnh dạn trình bày quan điểm cá nhân và khả năng thuyết phục tốt.
- Thành thạo các công cụ tin học cơ bản là điểm cộng.',
			),
			array(
				'name'        => 'Event',
				'modal_title' => 'Bộ phận Event',
				'jd'          => '## 1. Bạn sẽ làm gì?
- Tổ chức Sự kiện cho các Chương trình/Dự án cấp Bộ phận, Nhóm ở các mảng: Nội dung sự kiện, Hậu cần và Setup.
- Tham gia lên kế hoạch, tổ chức các Chương trình/Dự án cấp Nhóm.
- Là nhân sự hoạt náo cho các Chương trình cấp Nhóm.
## 2. Điểm cộng cho bạn nếu
- Thái độ lạc quan, tư duy tích cực, lăn xả, không ngại khó.
- Trách nhiệm, hết mình với công việc.
- Có tinh thần ham học hỏi.
- Hòa đồng, biết quan tâm, hỗ trợ mọi người.
- Linh hoạt, khéo léo, có khả năng ứng biến tốt.
- Có niềm yêu thích và định hướng tương lai liên quan đến Sự kiện là một lợi thế.
- Có các kỹ năng, kinh nghiệm về các mảng Nội dung sự kiện/ Setup/ Hậu cần là một lợi thế.',
			),
			array(
				'name'        => 'HR',
				'modal_title' => 'Bộ phận HR',
				'jd'          => '# 1. Truyền thông nội bộ
## a. Bạn sẽ làm gì?
- Quản lý, xây dựng và phát triển nội dung trên các kênh Truyền thông Nội bộ Nhóm.
- Đề ra các ý tưởng để xây dựng, vận hành và phát triển nội dung trên Fanpage Chuyện ở S theo định hướng của Nhóm.
- Thực hiện các bài viết/chuỗi bài viết cho hoạt động ghi nhận, đánh giá lộ trình phát triển nhân sự.
- Thực hiện các hoạt động gắn kết và thúc đẩy tinh thần nhân sự xuyên suốt nhiệm kỳ thông qua mail được gửi vào các dịp lễ, dịp quan trọng.
- Tổ chức thăm khu quân sự cho nhân sự Nhóm.
- Đề xuất các sáng kiến về hoạt động gắn kết nội bộ thông qua các buổi gặp mặt định kỳ hàng tháng của Nhóm.
## b. Điểm cộng cho bạn nếu
- Có hiểu biết cơ bản và yêu thích truyền thông.
- Chủ động, có trách nhiệm, cẩn thận, chỉn chu, tinh thần cầu tiến trong công việc.
- Thái độ lạc quan, tư duy tích cực, lễ phép, ham học hỏi, thích quan tâm đến người khác.
- Có tinh thần lăn xả, hết mình trong công việc.
- Có tư duy sáng tạo và khả năng viết cơ bản.
- Biết thiết kế, edit video, kinh nghiệm tổ chức event nội bộ là một lợi thế.
- Có định hướng phát triển ở mảng Internal Communication và Employer Branding.
- Có mong muốn đóng góp, phát triển nội bộ, tổ chức.

# 2. Quản lý & Phát triển nhân sự
## a. Bạn sẽ làm gì?
- Thực thi và giám sát quá trình ghi nhận, đánh giá lộ trình phát triển nhân sự.
- Nghiên cứu hướng phát triển hoàn thiện công cụ theo dõi, định hướng lộ trình phát triển nhân sự.
- Tổ chức các buổi Training - Sharing cấp Nhóm và cấp Bộ phận.
- Quản lý tình hình và các vật dụng nhân sự Nhóm (áo, dây đeo thẻ, thẻ và các vật dụng khác của Nhóm).
- Thực hiện lưu trữ report và đề xuất hướng phát triển cho các hoạt động nội bộ của Bộ phận HR.
- Chịu trách nhiệm trong việc giữ lửa, cầu nối thông tin giữa Bộ phận HR và Anh Chị cựu HR.
- Đề xuất các sáng kiến về hoạt động gắn kết nội bộ thông qua các buổi gặp mặt định kỳ hàng tháng của Nhóm.
## b. Điểm cộng cho bạn nếu
- Có hiểu biết cơ bản và yêu thích truyền thông.
- Có trách nhiệm, cẩn thận, chỉn chu, tinh thần cầu tiến trong công việc.
- Chủ động, lễ phép, ham học hỏi, thích quan tâm đến người khác.
- Có tinh thần lăn xả, hết mình trong công việc.
- Có kỹ năng sử dụng các công cụ tin học văn phòng.
- Có tư duy phân tích, sắp xếp tài liệu, hoạch định công việc.
- Có kinh nghiệm tổ chức event nội bộ là một lợi thế.
- Có định hướng phát triển ở mảng Learning and Development.
- Có mong muốn đóng góp, phát triển nội bộ, tổ chức.',
			),
			array(
				'name'        => 'Radio',
				'modal_title' => 'Ekip Radio',
				'jd'          => '# 1. MC
## a. Bạn sẽ làm gì?
- Cùng team lên ý tưởng, xây dựng kế hoạch truyền thông cho các sản phẩm và chương trình của Ekip Radio.
- Tham gia thu âm cho các bài chuyên mục, sản phẩm thương hiệu S Radio và S Communications.
- Đảm nhận vị trí MC/Host cho các sản phẩm Podcast, Talk Series và các chương trình, dự án của Ekip và Nhóm.
- Phối hợp với biên tập, kỹ thuật để đảm bảo sản phẩm đạt chất lượng tốt về nội dung và cảm xúc.
- Ngoài chuyên môn MC, được tạo điều kiện để phát triển bản thân và kỹ năng ở các vị trí khác liên quan đến truyền thông thuộc gói công việc của Ekip hoặc Nhóm.
## b. Điểm cộng cho bạn nếu
- Yêu thích và có mong muốn phát triển trong lĩnh vực MC thu âm và MC sân khấu.
- Phát âm chuẩn, lưu loát, khéo léo, có khả năng ứng biến và xử lý tình huống tốt.
- Có hiểu biết cơ bản về podcast, video podcast.
- Có kinh nghiệm thu âm/MC hoặc biết sử dụng cơ bản phần mềm chỉnh sửa âm thanh, video là một lợi thế.
- Có niềm yêu thích với truyền thông.
- Có khả năng teamwork, tinh thần trách nhiệm cao, ham học hỏi và chịu được áp lực.
- Thái độ lạc quan, tư duy tích cực, chủ động trong công việc, có khả năng quản lý công việc và thời gian.

# 2. Biên tập
## a. Bạn sẽ làm gì?
- Cùng team lên ý tưởng, xây dựng kế hoạch truyền thông cho các sản phẩm và chương trình của Ekip Radio.
- Đảm nhận vị trí biên tập, viết kịch bản và xây dựng nội dung truyền thông trên Fanpage, Instagram, TikTok, Spotify, Youtube của S Radio.
- Phối hợp với MC và kỹ thuật để đảm bảo nội dung nhất quán về thông điệp, giọng điệu và cảm xúc.
- Ngoài chuyên môn Biên tập, được tạo điều kiện để phát triển bản thân và kỹ năng ở các vị trí khác liên quan đến truyền thông thuộc gói công việc của Ekip hoặc Nhóm.
## b. Điểm cộng cho bạn nếu
- Yêu thích với việc đọc sách, viết lách và nghe podcast.
- Có tư duy sáng tạo, góc nhìn đa chiều và phong cách hành văn riêng.
- Có khả năng viết đa dạng hình thức, thể loại. Nhạy bén với những xu hướng mới là một lợi thế.
- Có niềm yêu thích với truyền thông.
- Có khả năng teamwork, tinh thần trách nhiệm cao, ham học hỏi và chịu được áp lực.
- Thái độ lạc quan, tư duy tích cực, chủ động trong công việc, có khả năng quản lý công việc và thời gian.

# 3. Kỹ thuật
## a. Bạn sẽ làm gì?
- Cùng team lên ý tưởng, xây dựng kế hoạch truyền thông cho các sản phẩm và chương trình của Ekip Radio.
- Đảm nhận thiết kế, chỉnh sửa hình ảnh, clip, âm thanh cho các sản phẩm, chương trình, sự kiện của Ekip Radio và Nhóm.
- Chịu trách nhiệm chỉnh sửa, hậu kỳ âm thanh của thương hiệu S Radio và S Communications.
- Phối hợp với MC và Biên tập để hoàn thiện sản phẩm đúng tiến độ và chất lượng.
- Ngoài chuyên môn Kỹ thuật, được tạo điều kiện để phát triển bản thân và kỹ năng ở các vị trí khác liên quan đến truyền thông thuộc gói công việc của Ekip hoặc Nhóm.
## b. Điểm cộng cho bạn nếu
- Có kiến thức hoặc sự yêu thích đối với lĩnh vực thiết kế, quay dựng, chỉnh sửa hình ảnh, video và âm thanh.
- Có khả năng sử dụng hoặc sẵn sàng học hỏi các phần mềm chuyên môn như Adobe Photoshop, Illustrator, Premiere Pro, Audition hoặc các công cụ tương đương.
- Có tư duy thẩm mỹ, khả năng sáng tạo và chú ý đến chi tiết trong quá trình sản xuất sản phẩm truyền thông.
- Có khả năng tiếp nhận brief, triển khai ý tưởng và đảm bảo chất lượng sản phẩm theo yêu cầu.
- Có tinh thần chủ động, trách nhiệm, cẩn thận và khả năng phối hợp làm việc nhóm tốt.
- Sẵn sàng học hỏi, cập nhật kỹ năng và tiếp cận các công cụ sản xuất nội dung mới.',
			),
			array(
				'name'        => 'STV',
				'modal_title' => 'Ekip STV',
				'jd'          => '# 1. Sáng tạo nội dung
## a. Bạn sẽ làm gì?
- Xây dựng kế hoạch triển khai các chiến dịch, sản phẩm và hoạt động của Ekip STV.
- Nghiên cứu đề tài, phát triển ý tưởng, concept và kịch bản cho các sản phẩm truyền thông.
- Xây dựng brief nội dung, hình ảnh; phối hợp cùng các vị trí kỹ thuật để hiện thực hóa ý tưởng.
- Lên ý tưởng và triển khai các hoạt động truyền thông online, truyền thông nội bộ, PR và seeding; phối hợp làm việc với các đối tác truyền thông.
- Tham gia tổ chức sản xuất theo phân công: lập lịch, điều phối nhân sự, chuẩn bị các hạng mục và theo dõi tiến độ.
## b. Điểm cộng cho bạn nếu
- Yêu thích sáng tạo nội dung, truyền thông, biên kịch hoặc tổ chức sản xuất.
- Có khả năng tìm kiếm thông tin, phát triển ý tưởng và diễn đạt nội dung rõ ràng.
- Có tư duy lập kế hoạch, kỹ năng giao tiếp, sắp xếp công việc và phối hợp nhóm.
- Chủ động, có trách nhiệm, sẵn sàng học hỏi và tiếp nhận góp ý.
- Có kinh nghiệm viết kịch bản, triển khai truyền thông hoặc tổ chức sản xuất là một lợi thế.

# 2. Kỹ thuật quay dựng
## a. Bạn sẽ làm gì?
- Phối hợp phát triển phương án thể hiện kịch bản bằng hình ảnh, xây dựng danh sách cảnh quay và phương án kỹ thuật.
- Tham gia đạo diễn, hướng dẫn diễn xuất và điều phối cảnh quay theo vai trò được phân công.
- Chuẩn bị thiết bị, thực hiện ghi hình và phối hợp xử lý ánh sáng, âm thanh tại buổi quay.
- Dựng video, lựa chọn và sắp xếp cảnh quay, xử lý nhịp dựng nhằm truyền tải nội dung và cảm xúc.
- Thực hiện chỉnh màu, xử lý âm thanh, phụ đề, hiệu ứng và hoàn thiện sản phẩm hậu kỳ.
- Tham gia hậu cần buổi quay, quản lý thiết bị, lưu trữ tư liệu và các tệp dự án.
## b. Điểm cộng cho bạn nếu
- Yêu thích sản xuất video, mong muốn phát triển trong lĩnh vực quay, dựng, đạo diễn hoặc chỉnh màu.
- Có tư duy kể chuyện bằng hình ảnh, cảm nhận cơ bản về góc máy, nhịp dựng và màu sắc.
- Sẵn sàng học hỏi cách sử dụng thiết bị, phần mềm và phối hợp xử lý tình huống tại buổi quay.
- Kiên nhẫn, có trách nhiệm, biết tiếp nhận góp ý và đảm bảo tiến độ công việc.
- Có kinh nghiệm quay, dựng, chỉnh màu hoặc sử dụng phần mềm hậu kỳ là một lợi thế.

# 3. Kỹ thuật hình ảnh
## a. Bạn sẽ làm gì?
- Thiết kế, chỉnh sửa và hoàn thiện các ấn phẩm hình ảnh phục vụ sản phẩm, chiến dịch và hoạt động của Ekip STV.
- Thực hiện chụp ảnh truyền thông, ảnh hậu trường; lựa chọn, xử lý và hoàn thiện hình ảnh.
- Tham gia xây dựng định hướng hình ảnh, phong cách thiết kế, màu sắc và bố cục phù hợp với concept.
- Lên ý tưởng và thực hiện set design: thiết kế, chuẩn bị bối cảnh, đạo cụ và các hạng mục mỹ thuật phục vụ sản xuất.
- Phối hợp tổ chức sản xuất, chuẩn bị vật dụng và làm việc với các đối tác liên quan theo phân công.
## b. Điểm cộng cho bạn nếu
- Yêu thích thiết kế, nhiếp ảnh, set design hoặc tổ chức sản xuất.
- Có tư duy thẩm mỹ cơ bản về bố cục, màu sắc và cách thể hiện hình ảnh.
- Có khả năng tìm kiếm tư liệu tham khảo, phát triển ý tưởng và phối hợp làm việc nhóm.
- Cẩn thận, chủ động, có trách nhiệm và sẵn sàng tham gia các hoạt động sản xuất.
- Biết sử dụng công cụ thiết kế, chỉnh sửa ảnh hoặc có kinh nghiệm nhiếp ảnh, set design là một lợi thế.',
			),
			array(
				'name'        => 'Writer',
				'modal_title' => 'Ekip Writer',
				'jd'          => '## 1. Bạn sẽ làm gì?
- Quản lý, phát triển nội dung cho Website và Fanpage UEHenter.
- Thực hiện phỏng vấn, PR (làm việc với KOLs, KOCs, các Đối tác truyền thông,...), lên tin nhanh cho các bài đăng, sự kiện.
- Xây dựng nội dung thương hiệu The S Magazine - Trang tạp chí điện tử hàng đầu dành cho sinh viên UEH.
- Biên tập các tạp chí, tuần san, ấn phẩm độc quyền cho UEH, S Communications.
- Thực thi bản mô tả (brief) hình ảnh, video cho các sản phẩm của Fanpage UEHenter và S Communications.
- Hỗ trợ xây dựng nội dung cho website scommunications.org.
- Phụ trách sáng tác các bài viết truyền thông hấp dẫn cho các Chương trình/Dự án đặc sắc trong và ngoài Nhóm.
- Tham gia trực tiếp vào Ban tổ chức các chiến dịch truyền thông đầy sáng tạo và giá trị dành cho sinh viên, tạo nên những tác động tích cực, sâu rộng trong cộng đồng.
## 2. Điểm cộng cho bạn nếu
- Khả năng viết ổn, tư duy nhạy bén, luôn cập nhật và bắt kịp các xu hướng mới nhất trên mạng xã hội và trong giới trẻ.
- Yêu thích sáng tạo, truyền thông.
- Tinh thần trách nhiệm cao, luôn nhiệt tình trong công việc và không ngại thử thách bản thân.
- Tinh thần ham học hỏi, luôn sẵn sàng nâng cao kỹ năng, tìm kiếm cơ hội phát triển, và làm việc nhóm hiệu quả để cùng đạt mục tiêu chung.
- Biết sử dụng Photoshop, Canva, Capcut,... là một lợi thế.',
			),
		);
	}

	private function jd_html( $text ) {
		$lines    = preg_split( '/\R/u', (string) $text );
		$has_role = (bool) preg_grep( '/^\s*#\s/u', $lines );
		$tag      = $has_role ? 'h4' : 'h3';
		$out      = '';
		$role     = false;
		$group    = false;
		$list     = false;

		$close_list  = function () use ( &$out, &$list ) {
			if ( $list ) {
				$out .= '</ul>';
				$list = false;
			}
		};
		$close_group = function () use ( &$out, &$group, $close_list ) {
			$close_list();
			if ( $group ) {
				$out  .= '</div>';
				$group = false;
			}
		};
		$close_role  = function () use ( &$out, &$role, $close_group ) {
			$close_group();
			if ( $role ) {
				$out .= '</div>';
				$role = false;
			}
		};

		foreach ( $lines as $line ) {
			$line = trim( $line );
			if ( '' === $line ) {
				continue;
			}
			if ( preg_match( '/^##\s+(.+)$/u', $line, $m ) ) {
				$close_group();
				$out  .= '<div class="scl-modal__group"><' . $tag . '>' . esc_html( $m[1] ) . '</' . $tag . '>';
				$group = true;
			} elseif ( preg_match( '/^#\s+(.+)$/u', $line, $m ) ) {
				$close_role();
				$out .= '<div class="scl-modal__role"><h3 class="scl-modal__role-title">' . esc_html( $m[1] ) . '</h3>';
				$role = true;
			} elseif ( preg_match( '/^-\s*(.+)$/u', $line, $m ) ) {
				if ( ! $list ) {
					$out .= '<ul>';
					$list = true;
				}
				$out .= '<li>' . scl_inline( $m[1] ) . '</li>';
			} else {
				$close_list();
				$out .= '<p>' . scl_inline( $line ) . '</p>';
			}
		}
		$close_role();
		return $out;
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = is_array( $s['items'] ) ? $s['items'] : array();
		$count = count( $items );
		$label = $count . ' Bộ phận/Ekip';
		?>
		<section class="scl scl-tm scl-defer"<?php echo $this->anchor_attr( $s ); ?> data-scl-motion>
			<div class="scl-container">
				<?php if ( $s['heading'] ) : ?>
					<div class="scl-head">
						<?php echo scl_title( $s['heading'], true ); ?>
					</div>
				<?php endif; ?>
				<div class="scl-tm__carousel" data-scl-carousel data-scl-reveal style="--i:3" role="region" aria-roledescription="carousel" aria-label="<?php echo esc_attr( $label ); ?>">
					<ul class="scl-tm__track" data-scl-track>
						<?php
						foreach ( $items as $i => $item ) :
							$num = str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT );
							$img = scl_image( $item['image'], 'scl-tm__media-in', $item['name'] );
							?>
							<li class="scl-tm__card scl-tone" data-scl-slide data-name="<?php echo esc_attr( $item['name'] ); ?>">
								<div class="scl-tm__media"><span class="scl-tm__num"><?php echo esc_html( $num ); ?></span><?php echo $img ? $img : scl_placeholder( 'scl-tm__media-in', 'Ảnh 864 x 1080 (4:5)', 'role="img" aria-label="' . esc_attr( $item['name'] ) . '"' ); ?></div>
								<div class="scl-tm__body"><h3 class="scl-tm__name"><?php echo esc_html( $item['name'] ); ?></h3></div>
								<?php if ( $s['button_text'] && trim( (string) $item['jd'] ) ) : ?>
									<button class="scl-tm__apply" type="button" data-scl-dialog-open="<?php echo esc_attr( $this->uid( 'team-' . $num ) ); ?>" aria-haspopup="dialog" aria-label="<?php echo esc_attr( $s['button_text'] . ' ' . $item['name'] ); ?>"><?php echo esc_html( $s['button_text'] ); ?> <?php echo scl_icon( 'arrow' ); ?></button>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
					<div class="scl-tm__nav"><button class="scl-tm__arrow scl-tm__arrow--prev" type="button" data-scl-prev aria-label="Bộ phận trước"><?php echo scl_icon( 'arrow' ); ?></button><p class="scl-tm__count" data-scl-count aria-hidden="true"></p><button class="scl-tm__arrow" type="button" data-scl-next aria-label="Bộ phận tiếp theo"><?php echo scl_icon( 'arrow' ); ?></button></div>
					<p class="scl-sr-only" data-scl-live-region aria-live="polite"></p>
				</div>
				<?php
				foreach ( $items as $i => $item ) :
					if ( ! trim( (string) $item['jd'] ) ) {
						continue;
					}
					$id = $this->uid( 'team-' . str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) );
					?>
					<dialog class="scl-modal" id="<?php echo esc_attr( $id ); ?>" aria-labelledby="<?php echo esc_attr( $id ); ?>-title">
						<div class="scl-modal__panel">
							<button class="scl-modal__close" type="button" data-scl-dialog-close aria-label="Đóng"><?php echo scl_icon( 'close' ); ?></button>
							<header class="scl-modal__head"><h2 class="scl-modal__title" id="<?php echo esc_attr( $id ); ?>-title"><?php echo esc_html( $item['modal_title'] ? $item['modal_title'] : $item['name'] ); ?></h2></header>
							<div class="scl-modal__body"><?php echo $this->jd_html( $item['jd'] ); ?></div>
						</div>
					</dialog>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}
}
