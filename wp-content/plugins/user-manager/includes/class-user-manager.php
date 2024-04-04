<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class User_Manager {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'user-manager';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-user-manager-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-plugin-name-i18n.php';

		/* Para la generaci�n de mo files */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-user-manager-mo-generator.php';

		/**
		 * The class responsible for defining all actions that affects settings.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-user-manager-settings.php';


		/**
		 * The class responsible for defining custom admin pages with user data
		 */
		// if(current_user_can('manage_options')){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-user-manager-show-user-data.php';
		//}


  	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-user-manager-userdata.php';


		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-user-manager-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-user-manager-public.php';

		/**
		* Vamos a meter en el siguiente file la lógica del ajax para el link generator.
		*
		*/
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/ajax-link-generator.php';

				/**
				* Idem con el cuestionario
				*
				*/
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/ajax-send-questionnaire-link.php';



		/* Class con los shortcodes */



		$this->loader = new User_Manager_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Plugin_Name_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new User_Manager_Admin( $this->get_plugin_name(), $this->get_version() );


		$plugin_settings = new User_Manager_Settings( );

		$moGenerator = new User_Manager_MoGenerator();

		$this->loader->add_action( 'admin_menu', $moGenerator, 'UserManagerMoGenerator_Menu');



		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		//Vamos con el tema de almacenar los inputs de cada test en los settings.
		$this->loader->add_action( 'admin_menu', $plugin_settings, 'add_user_manager_settings_page' );
	  $this->loader->add_action( 'admin_init', $plugin_settings, 'user_manager_settings_page_init' );


		$user_manager_option = get_option( 'user_manager_option_name' );
		//Registro de usuario
		$registerProfileDataFormsData = json_decode($user_manager_option['register_forms_sections_name_json'],true);



//if(in_array(get_current_blog_id(), array(1,2,5,7)){
		$registerProfileData = new User_Manager_UserData($registerProfileDataFormsData);
		//Edici�n de usuario
		$editProfileDataFormsData = json_decode($user_manager_option['profile_forms_sections_name_json'],true);
		$editProfileData = new User_Manager_UserData($editProfileDataFormsData);

//if(get_locale != 'de_DE'){
		$this->loader->add_action('signup_extra_fields',$registerProfileData,'display_user_data_form_this_object');
//}

		//add_signup_meta => apply_filters ( 'add_signup_meta', array $meta )
		$this->loader->add_action('add_signup_meta',$registerProfileData,'save_register_user_data_this_object'); //No los guarda como user meta sino en la tabla de signup...

		$this->loader->add_action('wpmu_activate_user',$registerProfileData,'custom_register_new_user_meta', 10, 3);//if no 10,3 it fails??


		$this->loader->add_action('show_user_profile', $editProfileData,'display_user_data_form_this_object');// $registerProfileData own user profile => WP_USER as param
		$this->loader->add_action('edit_user_profile',$editProfileData,'display_user_data_form_this_object');// $registerProfileData An other user profile=> WP_USER as param

		$this->loader->add_action( 'personal_options_update',$editProfileData,'save_update_user_data_form_this_object');//$registerProfileData
		$this->loader->add_action( 'edit_user_profile_update',$editProfileData,'save_update_user_data_form_this_object'); //$registerProfileData

	//validation
		$this->loader->add_action( 'wpmu_validate_user_signup', $registerProfileData,'user_manager_signup_validation_this_object', 10, 1);//'signup_user_init'=> signup user init was not enough to abort registration.
		$this->loader->add_action('user_profile_update_errors', $editProfileData, 'user_manager_edit_profile_validation_this_object', 10, 3);//$registerProfileData



	  $this->loader->add_action('wp', $registerProfileData, 'save_update_user_data_form_pages');
		$this->loader->add_action('wp', $registerProfileData, 'create_save_update_user_data_form_pages');

	//A�adimos el page custom field para la validaci�n.
	  $this->loader->add_action('add_meta_boxes', $registerProfileData, 'user_manager_add_meta_box' );
		$this->loader->add_action( 'save_post',  $registerProfileData,'user_manager_save_meta_box_data' );




		add_shortcode('get_user_data', array($registerProfileData, 'generate_custom_user_data_form_shortcode'));

		add_shortcode('create_and_get_user_data', array($registerProfileData, 'create_and_generate_custom_user_data_form_shortcode'));

		//ahora vamos con el shortcode para el quick formregister.
		add_shortcode('quick_form_signup', array($registerProfileData, 'create_quick_form_signup'));

		//creamos ahora el shortcode para el generador del link y  mostrador del perfil.
		add_shortcode('link_to_patientform_generator', array($registerProfileData, 'create_link_to_patientform_generator'));//create_link_to_patientform_generator
		add_shortcode('show_sx_defaults', array($registerProfileData, 'only_show_sx_defaults'));
		add_shortcode('change_sx_defaults', array($registerProfileData, 'only_change_sx_defaults'));
    add_shortcode('update_sx_defaults', array($registerProfileData, 'only_update_sx_defaults'));
    add_shortcode('show_available_forms', array($registerProfileData, 'only_show_available_forms'));
		add_shortcode('create_noreg_form_signup', array($registerProfileData, 'create_noreg_form_signup'));


		//A�adimos el page para el display del user data.
		$show_user_data = new User_Manager_Show_User_Data( );
  	$this->loader->add_action( 'admin_menu', $show_user_data, 'add_user_manager_show_user_data_page' );
		$this->loader->add_action( 'admin_menu', $show_user_data, 'add_user_manager_show_users_data_with_form_filled' );
	
	//}
	
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new User_Manager_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
	  $this->loader->add_action( 'wp_register_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
