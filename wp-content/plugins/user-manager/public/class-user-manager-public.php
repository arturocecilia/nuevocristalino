<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 * @author     Your Name <email@example.com>
 */
class User_Manager_Public {

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/user-manager-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/smart_wizard.css', array(), $this->version, 'all' );
		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rating.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );
		//wp_enqueue_style( 'radios-to-slider', plugin_dir_url( __FILE__ ) . 'css/radios-to-slider.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

	public function register_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_script('circle-progress-js', plugin_dir_url( __FILE__ ) . 'js/circle-progress.js', array( 'jquery' ), $this->version, false );// $this->plugin_name
    wp_register_script('form-gamifying-js', plugin_dir_url( __FILE__ ) . 'js/form-gamifying-v2.js', array( 'jquery','circle-progress-js','jquery-ui-progressbar' ), $this->version, false );// $this->plugin_name
		wp_register_script('user-manager-js', plugin_dir_url( __FILE__ ) . 'js/user-manager-public.js', array( 'jquery','circle-progress-js','form-gamifying-js','jquery-ui-autocomplete' ), $this->version, false );// $this->plugin_name
		wp_register_script('wizard-js', plugin_dir_url( __FILE__ ) . 'js/jquery.smartWizard.js', array( 'jquery' ), $this->version, false );// $this->plugin_name
	//  wp_register_script('rating-js', plugin_dir_url( __FILE__ ) . 'js/rating.js', array( 'jquery' ), $this->version, false );// $this->plugin_name
		wp_register_script('radios-to-slider-js', plugin_dir_url( __FILE__ ) . 'js/jquery.radios-to-slider.js', array( 'jquery' ), $this->version, false );// $this->plugin_name
	  wp_register_script('barrating-js', plugin_dir_url( __FILE__ ) . 'js/jquery.barrating.js', array( 'jquery' ), $this->version, false );// $this->plugin_name
	}



	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
    wp_enqueue_script( 'circle-progress-js', plugin_dir_url( __FILE__ ) . 'js/circle-progress.js', array( 'jquery' ), $this->version, false ); //$this->plugin_name
    wp_enqueue_script( 'form-gamifying-js', plugin_dir_url( __FILE__ ) . 'js/form-gamifying-v2.js', array( 'jquery', 'circle-progress-js','jquery-ui-progressbar' ), $this->version, false ); //$this->plugin_name
		wp_enqueue_script( 'user-manager-js', plugin_dir_url( __FILE__ ) . 'js/user-manager-public.js', array( 'jquery', 'circle-progress-js','jquery-ui-autocomplete' ), $this->version, false ); //$this->plugin_name
		wp_enqueue_script( 'wizard-js', plugin_dir_url( __FILE__ ) . 'js/jquery.smartWizard.js', array( 'jquery'), $this->version, false ); //$this->plugin_na
  //  wp_enqueue_script( 'rating-js', plugin_dir_url( __FILE__ ) . 'js/rating.js', array( 'jquery'), $this->version, false ); //$this->plugin_na
		wp_enqueue_script( 'radios-to-slider-js', plugin_dir_url( __FILE__ ) . 'js/jquery.radios-to-slider.js', array( 'jquery'), $this->version, false );
		wp_enqueue_script( 'barrating-js', plugin_dir_url( __FILE__ ) . 'js/jquery.barrating.js', array( 'jquery'), $this->version, false );
	}

}
