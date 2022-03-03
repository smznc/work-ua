<?php

class WU_Assets {
	public function __construct() {
		$this->hook();
	}

	protected function hook() {
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
	}

	public function styles() {
		wp_enqueue_style( 'mzj-main', get_template_directory_uri() . '/assets/dist/styles/main.min.css', array(), filemtime( get_template_directory() . '/assets/dist/styles/main.min.css' ) );
	}

	public function scripts() {
		wp_enqueue_script( 'mzj-main', get_template_directory_uri() . '/assets/dist/scripts/main.min.js', array(), filemtime( get_template_directory() . '/assets/dist/scripts/main.min.js' ), true );
	}
}

return new WU_Assets();
