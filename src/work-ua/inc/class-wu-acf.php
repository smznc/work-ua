<?php

class WU_ACF {
	protected $options_page_slug;
	protected $blocks = array();

	public function __construct() {
		if ( ! class_exists( 'ACF' ) ) {
			return;
		}

		$this->hook();
		$this->parse_blocks();
	}

	protected function hook() {
		add_action( 'acf/init', array( $this, 'options_page' ) );
		add_action( 'acf/init', array( $this, 'header_sub_page' ) );
		add_action( 'acf/init', array( $this, 'footer_sub_page' ) );
		add_action( 'acf/init', array( $this, 'liveagent_sub_page' ) );
		add_action( 'acf/init', array( $this, 'register_blocks' ) );
		add_action( 'allowed_block_types_all', array( $this, 'remove_default_blocks' ) );
		add_action( 'block_categories', array( $this, 'acf_blocks_category' ) );
		add_filter( 'acf/load_field/name=footer_social', array( $this, 'footer_social' ) );
	}

	public function options_page() {
		$page = acf_add_options_page( array(
			'page_title' => __( 'Theme General Settings', 'mazaj-landing' ),
			'menu_title' => __( 'Theme Settings', 'mazaj-landing' ),
			'redirect'   => true,
		) );

		$this->options_page_slug = $page[ 'menu_slug' ];
	}

	public function header_sub_page() {
		if ( is_null( $this->options_page_slug ) ) {
			return;
		}

		acf_add_options_sub_page( array(
			'page_title'  => __( 'Header General Settings', 'mazaj-landing' ),
			'menu_title'  => __( 'Header', 'mazaj-landing' ),
			'parent_slug' => $this->options_page_slug,
		) );
	}

	public function footer_sub_page() {
		if ( is_null( $this->options_page_slug ) ) {
			return;
		}

		acf_add_options_sub_page( array(
			'page_title'  => __( 'Footer General Settings', 'mazaj-landing' ),
			'menu_title'  => __( 'Footer', 'mazaj-landing' ),
			'parent_slug' => $this->options_page_slug,
		) );
	}

	protected function add_block( $array ) {
		$this->blocks[] = $array;
	}

	public function register_blocks() {
		if ( empty( $this->blocks ) ) {
			return;
		}

		foreach ( $this->blocks as $block ) {
			acf_register_block_type( $block );
		}
	}

	protected function parse_blocks() {
		$blocks_path = '/template-parts/acf-blocks';
		$path        = get_theme_file_path( $blocks_path );
		$url         = get_template_directory_uri() . $blocks_path;

		if ( ! file_exists( $path ) ) {
			return;
		}

		$iterator = new DirectoryIterator( $path );

		foreach ( $iterator as $item ) {
			if ( $item->isDot() || ! $item->isDir() ) {
				continue;
			}

			$register   = $item->getPathname() . '/register.php';
			$frontend   = $item->getPathname() . '/frontend.php';

			if ( ! file_exists( $register ) || ! file_exists( $frontend ) ) {
				continue;
			}

			$register = include( $register );

			$register[ 'mode' ]                 = 'edit';
			$register[ 'supports' ][ 'mode' ]   = false;
			$register[ 'supports' ][ 'align' ]  = false;
			$register[ 'supports' ][ 'anchor' ] = true;

			$register[ 'render_template' ] = $frontend;

			$this->add_block( $register );
		}
	}

	public function acf_blocks_category( $categories ) {
		$categories[] = array(
			'slug'  => 'wu_acf_blocks',
			'title' => 'WU ACF Blocks',
			'icon'  => null
		);

		return $categories;
	}

	public function remove_default_blocks( $allowed_block_types ) {
		$registered_blocks   = WP_Block_Type_Registry::get_instance()->get_all_registered();
		$allowed_block_types = array();
		$core_exception      = array(
			'core/html',
			'core/paragraph'
		);

		foreach ( $registered_blocks as $name => $registered_block ) {
			if ( 0 !== strpos( $name, 'acf/' ) && ! in_array( $name, $core_exception ) ) {
				continue;
			}
			$allowed_block_types[] = $name;
		}

		return $allowed_block_types;
	}
}

return new WU_ACF();