<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function scl_icon( $name, $label = '' ) {
	$aria  = $label ? 'aria-label="' . esc_attr( $label ) . '"' : 'aria-hidden="true"';
	$paths = array(
		'arrow' => array( '2.6', 'stroke-linejoin="round" ', '<path d="M5 12h14M13 6l6 6-6 6"/>' ),
		'plus'  => array( '2.6', '', '<path d="M12 5v14M5 12h14"/>' ),
		'close' => array( '2.4', '', '<path d="M6 6l12 12M18 6L6 18"/>' ),
		'up'    => array( '2.4', 'stroke-linejoin="round" ', '<path d="M12 19V5M6 11l6-6 6 6"/>' ),
	);
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}
	list( $width, $join, $path ) = $paths[ $name ];
	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="' . $width . '" stroke-linecap="round" ' . $join . $aria . '>' . $path . '</svg>';
}

function scl_inline( $text, $link_attrs = '' ) {
	$html = esc_html( $text );
	$html = preg_replace( '/\*\*(.+?)\*\*/u', '<strong>$1</strong>', $html );
	$html = preg_replace_callback(
		'/\[(.+?)\]/u',
		function ( $m ) use ( $link_attrs ) {
			return $link_attrs ? '<a ' . $link_attrs . '>' . $m[1] . '</a>' : '<strong>' . $m[1] . '</strong>';
		},
		$html
	);
	return $html;
}

function scl_paragraphs( $text ) {
	$out = '';
	foreach ( preg_split( '/\R+/u', trim( (string) $text ) ) as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$out .= '<p>' . scl_inline( $line ) . '</p>';
		}
	}
	return $out;
}

function scl_title( $text, $red = false ) {
	if ( '' === trim( (string) $text ) ) {
		return '';
	}
	return '<h2 class="scl-title' . ( $red ? ' scl-title--red' : '' ) . '" data-scl-reveal="title"><span class="scl-line"><span>' . esc_html( $text ) . '</span></span></h2>';
}

function scl_btn_inner( $text, $arrow = false ) {
	return '<span class="scl-btn__clip"><span data-text="' . esc_attr( $text ) . '">' . esc_html( $text ) . '</span></span>' . ( $arrow ? scl_icon( 'arrow' ) : '' );
}

function scl_iso( $value ) {
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

function scl_is_editor() {
	return class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->editor && \Elementor\Plugin::$instance->editor->is_edit_mode();
}

function scl_placeholder( $class, $label, $attrs = '' ) {
	$ph = scl_is_editor() ? ' data-ph="' . esc_attr( $label ) . '"' : '';
	return '<div class="' . esc_attr( $class ) . ' scl-ph"' . $ph . ( $attrs ? ' ' . $attrs : '' ) . '></div>';
}

function scl_image( $media, $class, $alt, $args = array() ) {
	$attr = array_merge(
		array(
			'class'    => $class . ' scl-img',
			'alt'      => $alt,
			'loading'  => 'lazy',
			'decoding' => 'async',
		),
		$args
	);
	if ( ! empty( $media['id'] ) ) {
		$html = wp_get_attachment_image( $media['id'], 'full', false, $attr );
		if ( $html ) {
			return $html;
		}
	}
	if ( ! empty( $media['url'] ) && false === strpos( $media['url'], 'elementor/assets/images/placeholder' ) ) {
		$out = '<img src="' . esc_url( $media['url'] ) . '"';
		foreach ( $attr as $key => $value ) {
			$out .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}
		return $out . '>';
	}
	return '';
}

function scl_url_attrs( $url ) {
	if ( empty( $url['url'] ) ) {
		return '';
	}
	$out = 'href="' . esc_url( $url['url'] ) . '"';
	$rel = array();
	if ( ! empty( $url['is_external'] ) ) {
		$out  .= ' target="_blank"';
		$rel[] = 'noopener';
	}
	if ( ! empty( $url['nofollow'] ) ) {
		$rel[] = 'nofollow';
	}
	if ( $rel ) {
		$out .= ' rel="' . implode( ' ', $rel ) . '"';
	}
	return $out;
}
