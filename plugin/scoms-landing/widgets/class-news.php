<?php
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCL_News extends SCL_Widget {

	public function get_name() {
		return 'scl_news';
	}

	public function get_title() {
		return 'News (Posts)';
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_style_depends() {
		return array( 'scl-news' );
	}

	private function category_options() {
		$options = array( '' => 'Select a category' );
		foreach ( get_categories( array( 'hide_empty' => false ) ) as $cat ) {
			$options[ $cat->slug ] = $cat->name . ' (' . $cat->count . ')';
		}
		return $options;
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_content', array( 'label' => 'Content' ) );

		$this->add_anchor_control( 'bang-tin' );
		$this->add_heading_control( 'Bảng tin' );

		$this->add_control(
			'source',
			array(
				'label'   => 'Posts from',
				'type'    => Controls_Manager::SELECT,
				'default' => 'ids',
				'options' => array(
					'ids'      => 'Chosen post IDs',
					'category' => 'Latest in a category',
				),
			)
		);

		$this->add_control(
			'post_ids',
			array(
				'label'       => 'Post IDs',
				'type'        => Controls_Manager::TEXT,
				'default'     => '8533, 9753, 6552, 9699, 5753, 5453',
				'label_block' => true,
				'description' => 'Comma separated, shown in this order. Find the ID in Posts > hover a post > "post=123" in the link.',
				'condition'   => array( 'source' => 'ids' ),
			)
		);

		$this->add_control(
			'category',
			array(
				'label'     => 'Category',
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->category_options(),
				'default'   => '',
				'condition' => array( 'source' => 'category' ),
			)
		);

		$this->add_control(
			'count',
			array(
				'label'   => 'Number of posts',
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 12,
				'default' => 6,
			)
		);

		$this->add_control(
			'tag',
			array(
				'label'       => 'Tag on cards',
				'type'        => Controls_Manager::TEXT,
				'default'     => 'S_Search',
				'description' => 'Empty = the first category of each post.',
			)
		);

		$this->end_controls_section();
	}

	private function query( $s ) {
		$count = max( 1, min( 12, (int) $s['count'] ) );
		$args  = array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => $count,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		);
		if ( 'category' === $s['source'] ) {
			if ( empty( $s['category'] ) ) {
				return null;
			}
			$args['category_name'] = $s['category'];
		} else {
			$ids = array_filter( array_map( 'absint', explode( ',', (string) $s['post_ids'] ) ) );
			if ( ! $ids ) {
				return null;
			}
			$args['post__in'] = $ids;
			$args['orderby']  = 'post__in';
		}
		return new WP_Query( $args );
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$query = $this->query( $s );
		$has   = $query && $query->have_posts();
		if ( ! $has && ! scl_is_editor() ) {
			return;
		}
		?>
		<section class="scl scl-nw scl-defer"<?php echo $this->anchor_attr( $s ); ?> data-scl-motion>
			<div class="scl-container">
				<?php if ( $s['heading'] ) : ?>
					<div class="scl-head">
						<?php echo scl_title( $s['heading'] ); ?>
					</div>
				<?php endif; ?>
				<?php if ( ! $has ) : ?>
					<p class="scl-nw__empty">No posts found. Check the post IDs or the category.</p>
				<?php else : ?>
					<ul class="scl-nw__grid">
						<?php
						$i = 0;
						while ( $query->have_posts() ) :
							$query->the_post();
							$post_id = get_the_ID();
							$tag     = $s['tag'];
							if ( ! $tag ) {
								$cats = get_the_category( $post_id );
								$tag  = $cats ? $cats[0]->name : '';
							}
							$thumb = get_the_post_thumbnail(
								$post_id,
								'large',
								array(
									'class'    => 'scl-nw__thumb',
									'alt'      => '',
									'loading'  => 'lazy',
									'decoding' => 'async',
								)
							);
							?>
							<li class="scl-nw__card" data-scl-reveal style="--i:<?php echo (int) $i; ?>"><?php echo $thumb ? $thumb : '<div class="scl-nw__thumb scl-ph"></div>'; ?><?php if ( $tag ) : ?><div class="scl-nw__tags"><span class="scl-nw__tag"><?php echo esc_html( $tag ); ?></span></div><?php endif; ?><div class="scl-nw__bottom"><span class="scl-nw__date"><?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?></span><h3 class="scl-nw__title"><a class="scl-nw__link" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h3></div></li>
							<?php
							$i++;
						endwhile;
						wp_reset_postdata();
						?>
					</ul>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
