<?php
use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class SCL_Widget extends Widget_Base {

	public function get_categories() {
		return array( 'scoms-landing' );
	}

	public function get_script_depends() {
		return array( 'scl-motion' );
	}

	protected function add_anchor_control( $default ) {
		$this->add_control(
			'anchor',
			array(
				'label'       => 'Section ID',
				'type'        => Controls_Manager::TEXT,
				'default'     => $default,
				'description' => 'Used by links such as #' . $default . '. Letters, numbers and dashes only.',
			)
		);
	}

	protected function add_heading_control( $default ) {
		$this->add_control(
			'heading',
			array(
				'label'       => 'Heading',
				'type'        => Controls_Manager::TEXT,
				'default'     => $default,
				'label_block' => true,
			)
		);
	}

	protected function anchor_attr( $s ) {
		$id = isset( $s['anchor'] ) ? sanitize_title( $s['anchor'] ) : '';
		return $id ? ' id="' . esc_attr( $id ) . '"' : '';
	}

	protected function uid( $suffix = '' ) {
		return 'scl-' . $this->get_id() . ( '' !== $suffix ? '-' . $suffix : '' );
	}
}
