<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://0e1dev.com
 * @since      1.0.0
 *
 * @package    Wp_Guido_Stepper
 * @subpackage Wp_Guido_Stepper/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Guido_Stepper
 * @subpackage Wp_Guido_Stepper/admin
 * @author     lhas <luizhrqas@gmail.com>
 */
class Wp_Guido_Stepper_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Guido_Stepper_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Guido_Stepper_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-guido-stepper-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Guido_Stepper_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Guido_Stepper_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-guido-stepper-admin.js', array( 'jquery' ), $this->version, false );
		
		wp_localize_script(
			$this->plugin_name,
			'odinAdminParams',
			array(
				'galleryTitle'  => __( 'Add images in gallery', 'odin' ),
				'galleryButton' => __( 'Add in gallery', 'odin' ),
				'galleryRemove' => __( 'Remove image', 'odin' ),
				'uploadTitle'   => __( 'Choose a file', 'odin' ),
				'uploadButton'  => __( 'Add file', 'odin' ),
			)
		);

	}
	
	public function register_post_types() {
		register_post_type('gs_inputs',
			[
				'labels' => [
					'name' => __('Guido Stepper Inputs'),
					'singular_name' => __('Guido Stepper Input'),
				],
				'public' => true,
				'has_archive' => false,
				'rewrite' => ['slug' => 'stepper-inputs'],
				'menu_position' => 1000,
				'supports' => array('title')
			]
		);
		register_post_type('gs_slides',
			[
				'labels' => [
					'name' => __('Guido Stepper Slides'),
					'singular_name' => __('Guido Stepper Slide'),
				],
				'public' => true,
				'has_archive' => false,
				'rewrite' => ['slug' => 'stepper-slides'],
				'menu_position' => 1000,
				'supports' => array('title')
			]
		);
		register_post_type('gs_registrations',
			[
				'labels' => [
					'name' => __('Guido Stepper Registrations'),
					'singular_name' => __('Guido Stepper Registration'),
				],
				'public' => true,
				'has_archive' => false,
				'rewrite' => ['slug' => 'stepper-registration'],
				'menu_position' => 1000,
				'supports' => array('title'),
				'capabilities' => array(
					'create_posts' => 'do_not_allow', // false < WP 4.5, credit @Ewout
				),
				'map_meta_cap' => false,
			]
		);
	}

	public function register_custom_fields() {
		$inputs_metabox = new Odin_Metabox(
				'input_settings',
				'Input Settings',
				'guido_stepper_inputs',
				'normal',
				'high'
		);
		$inputs_metabox->set_fields(
			array(
				array(
					'id'          => 'type',
					'label'       => __( 'Type', 'wp-guido-stepper' ),
					'type'        => 'select',
					'add_column'  => true,
					'options'       => array(
							'text'   => 'Text',
							'textarea'   => 'Textarea',
							'email'   => 'E-mail',
							'tel'   => 'Phone',
							'number'   => 'Number'
					)
				)
			)
		);
		$slides_metabox = new Odin_Metabox(
				'slide_settings',
				'Slide Settings',
				'guido_stepper_slides',
				'normal',
				'high'
		);
		
		$slides_limit = 10;
		$slides_fields = [];

		for($i = 1; $i <= $slides_limit; $i++) {
			$slides_fields[] = array(
				'id'          => 'slide_' . $i, // Obrigatório
				'label'       => 'Slide #' . $i, // Obrigatório
				'type'        => 'image_plupload', // Obrigatório
			);
		}

		$slides_metabox->set_fields($slides_fields);

	}

	public function register_menu_pages() {
    add_menu_page(
        __( 'Guido Stepper', 'wp-guido-stepper' ),
        'Guido Stepper',
        'manage_options',
        'wp-guido-stepper/admin/pages/main.php',
        '',
        'dashicons-chart-pie',
        999
    );
	}

}
