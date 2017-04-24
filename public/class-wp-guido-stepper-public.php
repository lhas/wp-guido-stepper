<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://0e1dev.com
 * @since      1.0.0
 *
 * @package    Wp_Guido_Stepper
 * @subpackage Wp_Guido_Stepper/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Guido_Stepper
 * @subpackage Wp_Guido_Stepper/public
 * @author     lhas <luizhrqas@gmail.com>
 */
class Wp_Guido_Stepper_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-guido-stepper-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '_slick', plugin_dir_url( __FILE__ ) . '../vendors/slick-1.6.0/slick/slick.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-guido-stepper-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '_slick', plugin_dir_url( __FILE__ ) . '../vendors/slick-1.6.0/slick/slick.min.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), ) );
	}

	public function register_shortcodes() {
		function stepper_func($atts) {
			ob_start();
			$slide_name = $atts['name'];
			include('shortcodes/stepper.php');
			$output = ob_get_clean();
			return $output;
		}

		add_shortcode('stepper', 'stepper_func');
	}

	public function ajax_stepper_submit() {
		$slide = $_POST['slide'];
		$values = $_POST['values'];
		$form = $_POST['form'];
		$admin_email = $_POST['to'];

		$post_id = wp_insert_post(array (
				'post_type' => 'gs_registrations',
				'post_title' => date('d/m/Y H:i:s'),
				'post_status' => 'publish',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
		));

		if ($post_id) {
			add_post_meta($post_id, 'belongs_to_slide', $slide);

			foreach($form as $input) {
				add_post_meta($post_id, 'input_' . $input['name'], $input['value']);
			}

			add_post_meta($post_id, 'slide_values', json_encode($values, JSON_UNESCAPED_UNICODE));
		}
		
		$message = '';

		$message .= '<strong>Slide</strong>';
		$message .= '<p>' . $slide . '</p>';

		foreach($form as $input) {
			$tmp = new WP_Query(['post_type' => 'gs_inputs', 'p' => $input['name'] ]);

			$message .= '<strong>' . $tmp->posts[0]->post_title . '</strong>';
			$message .= '<p>' . $input['value'] .'</p>';
		}

		foreach($values as $value) {
			$message .= '<strong>' . $value['headline'] . '</strong>';
			$message .= '<p>' . $value['value'] . '</p>';
		}

		$headers = array('Content-Type: text/html; charset=UTF-8');

		wp_mail($admin_email,  '[' . $slide . '] Submit', $message, $headers);

		wp_die();
	}

}
