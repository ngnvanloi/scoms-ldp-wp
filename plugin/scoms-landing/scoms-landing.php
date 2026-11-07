<?php
/**
 * Plugin Name:       SCOMS Landing
 * Description:       Custom Elementor widgets for the SCOMS event landing page. Independent of the active theme.
 * Version:           0.1.0
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

function scl_widgets() {
	return array(
		'class-hero.php'   => 'SCL_Hero',
		'class-agenda.php' => 'SCL_Agenda',
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
	wp_register_style(
		'scl-fonts',
		'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;600;700;800&display=swap',
		array(),
		null
	);

	$css_dir = SCL_PATH . 'assets/css/';
	wp_register_style( 'scl-base', SCL_URL . 'assets/css/base.css', array( 'scl-fonts' ), filemtime( $css_dir . 'base.css' ) );

	foreach ( glob( $css_dir . '*.css' ) as $file ) {
		$name = basename( $file, '.css' );
		if ( 'base' === $name ) {
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

add_action(
	'elementor/widgets/register',
	function ( $widgets_manager ) {
		foreach ( scl_widgets() as $file => $class ) {
			require_once SCL_PATH . 'widgets/' . $file;
			$widgets_manager->register( new $class() );
		}
	}
);
