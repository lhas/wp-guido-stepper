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
		wp_enqueue_style( $this->plugin_name . '_slick', plugin_dir_url( __FILE__ ) . '../vendors/slick-1.6.0/slick/slick.css', array(), $this->version, 'all' );

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

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_media();
		wp_enqueue_script( 'jquery-ui-sortable' );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-guido-stepper-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '_slick', plugin_dir_url( __FILE__ ) . '../vendors/slick-1.6.0/slick/slick.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '_public', plugin_dir_url( __FILE__ ) . '../public/js/wp-guido-stepper-public.js', array( 'jquery' ), $this->version, false );
		
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
			]
		);
	}

	public function remove_post_type_menu() {
		remove_menu_page( 'edit.php?post_type=gs_inputs' );
		remove_menu_page( 'edit.php?post_type=gs_slides' );
		remove_menu_page( 'edit.php?post_type=gs_registrations' );
	}

	public function register_custom_fields() {
		$this->input_fields();
		$this->slide_fields();
		$this->registration_fields();
	}

	public function input_fields() {
		$inputs_metabox = new Odin_Metabox(
				'input_settings',
				'Input Settings',
				'gs_inputs',
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
				),
				array(
					'id'          => 'belongs_to',
					'label'       => __( 'Belongs To', 'wp-guido-stepper' ),
					'type'        => 'select',
					'add_column'  => true,
					'options'       => array(
							'1st_slide'   => '1st Form Slide',
							'2nd_slide'   => '2nd Form Slide',
					)
				),
			)
		);
	}

	public function slide_fields() {
		$slides_metabox = new Odin_Metabox(
				'slides',
				'Slides',
				'gs_slides',
				'normal',
				'high'
		);
		$settings_metabox = new Odin_Metabox(
				'settings',
				'Settings',
				'gs_slides',
				'normal',
				'high'
		);
		
		$slides_limit = 10;
		$slides_fields = [];
		$settings_fields = [];

		for($i = 1; $i <= $slides_limit; $i++) {
			$slides_fields[] = array(
				'id'          => 'background_' . $i, // Obrigatório
				'label'       => 'Background #' . $i, // Obrigatório
				'type'        => 'color', // Obrigatório
			);
			$slides_fields[] = array(
				'id'          => 'title_' . $i, // Obrigatório
				'label'       => 'Headline #' . $i, // Obrigatório
				'type'        => 'text', // Obrigatório
			);
			$slides_fields[] = array(
				'id'          => 'subtitle_' . $i, // Obrigatório
				'label'       => 'Subtitle #' . $i, // Obrigatório
				'type'        => 'text', // Obrigatório
			);
			$slides_fields[] = array(
				'id'          => 'slide_' . $i, // Obrigatório
				'label'       => 'Slide #' . $i, // Obrigatório
				'type'        => 'image_plupload', // Obrigatório
			);
		}
	
		$settings_fields[] = array(
			'id'          => 'to', // Obrigatório
			'label'       => 'To', // Obrigatório
			'type'        => 'text', // Obrigatório
		);
	
		$settings_fields[] = array(
			'id'          => 'submit_button_background', // Obrigatório
			'label'       => 'Submit Button - Background Color', // Obrigatório
			'type'        => 'color', // Obrigatório
		);
	
		$settings_fields[] = array(
			'id'          => 'submit_button_color', // Obrigatório
			'label'       => 'Submit Button - Text Color', // Obrigatório
			'type'        => 'color', // Obrigatório
		);
	
		$settings_fields[] = array(
			'id'          => '1st_form_headline', // Obrigatório
			'label'       => '1st Form - Headline', // Obrigatório
			'type'        => 'text', // Obrigatório
		);
	
		$settings_fields[] = array(
			'id'          => '1st_form_subtitle', // Obrigatório
			'label'       => '1st Form - Subtitle', // Obrigatório
			'type'        => 'text', // Obrigatório
		);
	
		$settings_fields[] = array(
			'id'          => '1st_form_submit', // Obrigatório
			'label'       => '1st Form - Submit Text', // Obrigatório
			'type'        => 'text', // Obrigatório
		);
	
		$settings_fields[] = array(
			'id'          => '2nd_form_headline', // Obrigatório
			'label'       => '2nd Form - Headline', // Obrigatório
			'type'        => 'text', // Obrigatório
		);
	
		$settings_fields[] = array(
			'id'          => '2nd_form_subtitle', // Obrigatório
			'label'       => '2nd Form - Subtitle', // Obrigatório
			'type'        => 'text', // Obrigatório
		);
	
		$settings_fields[] = array(
			'id'          => '2nd_form_submit', // Obrigatório
			'label'       => '2nd Form - Submit Text', // Obrigatório
			'type'        => 'text', // Obrigatório
		);

		$slides_metabox->set_fields($slides_fields);
		$settings_metabox->set_fields($settings_fields);
	}

	public function registration_fields() {
		// 0) Initialize registration metabox
		$registration_metabox = new Odin_Metabox(
				'registration_settings',
				'Registration Settings',
				'gs_registrations',
				'normal',
				'high'
		);
		$registration_fields = [];

		// 1) Get all slides
		$slides = new WP_Query([
			'post_type' => 'gs_slides',
			'limit' => 9999
		]);

		// 2) Get all inputs
		$inputs = new WP_Query([
			'post_type' => 'gs_inputs',
			'limit' => 9999
		]);

		// 3) Registrate one field to set relationship between registration and slide
		$options = [];

		foreach($slides->posts as $slide) {
			$options[$slide->ID] = $slide->post_title;
		}

		$registration_fields[] = [
			'id' => 'belongs_to_slide',
			'label' => 'Belongs to Slide',
			'type' => 'select',
			'options' => $options,
			'add_column'  => true,
		];

		// 4) Iterate over inputs and set one display field for each
		foreach($inputs->posts as $input) {
			$registration_fields[] = [
				'id' => 'input_' . $input->ID,
				'label' => $input->post_title,
				'type' => 'text',
				'add_column'  => false,
			];
		}

		// 5) Set fields for registration metabox
		$registration_metabox->set_fields($registration_fields);
	}

	public function register_menu_pages() {
    add_menu_page(
        __( 'Guido Stepper', 'wp-guido-stepper' ),
        'Guido Stepper',
        'manage_options',
        dirname(__FILE__) . '/pages/main.php',
        '',
        'dashicons-chart-pie',
        999
    );
    add_submenu_page(
        dirname(__FILE__) . '/pages/main.php',
        'Inputs',
        'Inputs',
        'manage_options',
        'edit.php?post_type=gs_inputs',
        ''
    );
    add_submenu_page(
        dirname(__FILE__) . '/pages/main.php',
        'Slides',
        'Slides',
        'manage_options',
        'edit.php?post_type=gs_slides',
        ''
    );
    add_submenu_page(
        dirname(__FILE__) . '/pages/main.php',
        'Registrations',
        'Registrations',
        'manage_options',
        'edit.php?post_type=gs_registrations',
        ''
    );
	}

}
