<?php
/**
 * Plugin Name:       SCOMS Landing
 * Description:       Custom Elementor widgets for the SCOMS event landing page. Independent of the active theme.
 * Version:           0.2.0
 * Requires at least: 6.5
 * Requires PHP:      7.4
 * Requires Plugins:  elementor
 * Text Domain:       scoms-landing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SCL_PATH', plugin_dir_path( __FILE__ ) );
define( 'SCL_URL', plugin_dir_url( __FILE__ ) );

require_once SCL_PATH . 'includes/helpers.php';

function scl_widgets() {
	return array(
		'class-recruit-hero.php' => 'SCL_Recruit_Hero',
		'class-highlights.php'   => 'SCL_Highlights',
		'class-teams.php'        => 'SCL_Teams',
		'class-timeline.php'     => 'SCL_Timeline',
		'class-steps.php'        => 'SCL_Steps',
		'class-notes.php'        => 'SCL_Notes',
		'class-faq.php'          => 'SCL_Faq',
		'class-news.php'         => 'SCL_News',
		'class-site-footer.php'  => 'SCL_Site_Footer',
	);
}

add_action(
	'elementor/elements/categories_registered',
	function ( $elements_manager ) {
		$elements_manager->add_category(
			'scoms-landing',
			array(
				'title' => 'SCOMS Landing',
				'icon'  => 'eicon-calendar',
			)
		);
	}
);

function scl_register_assets() {
	$css_dir = SCL_PATH . 'assets/css/';
	wp_register_style( 'scl-fonts', SCL_URL . 'assets/css/fonts.css', array(), filemtime( $css_dir . 'fonts.css' ) );
	wp_register_style( 'scl-base', SCL_URL . 'assets/css/base.css', array( 'scl-fonts' ), filemtime( $css_dir . 'base.css' ) );

	foreach ( glob( $css_dir . '*.css' ) as $file ) {
		$name = basename( $file, '.css' );
		if ( 'base' === $name || 'fonts' === $name ) {
			continue;
		}
		wp_register_style( 'scl-' . $name, SCL_URL . 'assets/css/' . $name . '.css', array( 'scl-base' ), filemtime( $file ) );
	}

	foreach ( glob( SCL_PATH . 'assets/js/*.js' ) as $file ) {
		$name = basename( $file, '.js' );
		wp_register_script( 'scl-' . $name, SCL_URL . 'assets/js/' . $name . '.js', array(), filemtime( $file ), true );
	}
}
add_action( 'wp_enqueue_scripts', 'scl_register_assets' );

function scl_page_uses_widgets() {
	if ( ! is_singular() ) {
		return false;
	}
	$data = get_post_meta( get_queried_object_id(), '_elementor_data', true );
	return is_string( $data ) && false !== strpos( $data, '"widgetType":"scl_' );
}

add_action(
	'wp_head',
	function () {
		if ( ! scl_page_uses_widgets() ) {
			return;
		}
		foreach ( array( 'latin', 'vietnamese' ) as $subset ) {
			printf(
				'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
				esc_url( SCL_URL . 'assets/fonts/be-vietnam-pro-800-' . $subset . '.woff2' )
			);
		}
	},
	2
);

add_action(
	'elementor/widgets/register',
	function ( $widgets_manager ) {
		require_once SCL_PATH . 'includes/class-scl-widget.php';
		foreach ( scl_widgets() as $file => $class ) {
			require_once SCL_PATH . 'widgets/' . $file;
			$widgets_manager->register( new $class() );
		}
	}
);
