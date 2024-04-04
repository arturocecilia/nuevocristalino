<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */


 /*-- https://codex.wordpress.org/Creating_Options_Pages --*/

class User_Manager_Settings {

   /**
   * Holds the values to be used in the fields callbacks
   */
    private $options;


	public function __construct( ) {

        //add_action( 'admin_menu', array( $this, 'add_user_manager_settings_page' ) ); //add_plugin_page
        //add_action( 'admin_init', array( $this, 'user_manager_settings_page_init' ) ); //page_init

	}


	    /**
     * Add options page
     */
    public function add_user_manager_settings_page() //add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'User Manager Settings Admin', //Settings Admin
            'User Manager Settings', //My Settings
            'manage_options', //manage_options
            'user-manager-setting-admin', //my-setting-admin
            array( $this, 'create_user_manager_settings_admin_page' ) // array( $this, 'create_admin_page' )
        );
    }

	    /**
     * Options page callback
     */
    public function create_user_manager_settings_admin_page() //create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'user_manager_option_name' );//my_option_name
        ?>
        <div class="wrap">
            <h2>User Manager Settings</h2>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'user_manager_option_group' );   //my_option_group
                do_settings_sections( 'user-manager-setting-admin' );		//my-setting-admin
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

	    /**
     * Register and add settings
     */
    public function user_manager_settings_page_init() //page_init
    {
        register_setting(
            'user_manager_option_group', //my_option_group Option group
            'user_manager_option_name', //my_option_name Option name
            array( $this, 'sanitize_user_manager_settings' ) //sanitize Sanitize
        );

        add_settings_section(
            'user_manager_setting_section_id', //setting_section_id ID
            'User Manager Settings', //My Custom Settings Title
            array( $this, 'print_user_manager_section_info' ), //print_section_info Callback
            'user-manager-setting-admin' //my-setting-admin Page
        );

        add_settings_field(
            'ids_pages_profiles', //id_number ID
            'IDs separados por comas de las páginas con forms de datos de usuario', //ID Number Title
            array( $this, 'ids_pages_profiles_id_callback' ), //id_number_callback Callback
            'user-manager-setting-admin', //my-setting-admin Page
            'user_manager_setting_section_id' //setting_section_id Section
        );

        //Estos son para las clínicas.
        add_settings_field(
            'ids_pages_inclinicpostopdata', //id_number ID
            'IDs separados por comas de las páginas con forms postoperatorios de usuario. ANÓNIMOS.', //ID Number Title
            array( $this, 'ids_pages_inclinicpostopdata_callback' ), //id_number_callback Callback
            'user-manager-setting-admin', //my-setting-admin Page
            'user_manager_setting_section_id' //setting_section_id Section
        );
        //Estos son formularios postop all in one, con registro completo de usuario.

        add_settings_field(
            'ids_pages_inclinicpostopdata_regis', //id_number ID
            'IDs separados por comas de las páginas con forms postoperatorios de usuario. CON REGISTRO.', //ID Number Title
            array( $this, 'ids_pages_inclinicpostopdata_regis_callback' ), //id_number_callback Callback
            'user-manager-setting-admin', //my-setting-admin Page
            'user_manager_setting_section_id' //setting_section_id Section
        );






        add_settings_field( /*-- Here will be the forms and sections that will be included in the registration form --*/
            'register_forms_sections_name_json', //title
            'Forms and sections to be included in the register form (in json format). <br />eg:[{"form":"addProfileBasicData","section":""},{"form":"addProfProfileBasicData", "section" :""}]', //Title
            array( $this, 'register_forms_sections_name_json_callback' ), //title_callback
            'user-manager-setting-admin', //my-setting-admin
            'user_manager_setting_section_id' //setting_section_id
        );

        add_settings_field(/*-- Here will be the forms and sections that will be included in the default built-in user profile--*/
            'profile_forms_sections_name_json', //title
            'Forms and sections to be included in the default profile form (in () json format).<br /> eg:[{"form":"addProfileBasicData","section":""},{"form":"addProfProfileBasicData", "section" :""}]', //Title
            array( $this, 'profile_forms_sections_name_json_callback' ), //title_callback
            'user-manager-setting-admin', //my-setting-admin
            'user_manager_setting_section_id' //setting_section_id
        );
        //Vamos a añadir unos settings para ver datos de usuarios por defecto y para poner también visualización por defecto.

        //Todos los User Manager forms que se utilizan en este site
        add_settings_field(/*-- Here will be the forms and sections that will be included in the default built-in user profile--*/
            'all_user_forms_sections_name_json', //title
            'All the forms that are in use in this site (in () json format).<br /> eg:[{"form":"addProfileBasicData","section":""},{"form":"addProfProfileBasicData", "section" :""}]', //Title
            array( $this, 'all_user_forms_sections_name_json_callback' ), //title_callback
            'user-manager-setting-admin', //my-setting-admin
            'user_manager_setting_section_id' //setting_section_id
        );











    }

		  /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize_user_manager_settings( $input ) //sanitize
    {
        $new_input = array();

        if( isset( $input['ids_pages_profiles'] ) )
            $new_input['ids_pages_profiles'] = sanitize_text_field( $input['ids_pages_profiles'] );

        if( isset( $input['ids_pages_inclinicpostopdata'] ) )
                $new_input['ids_pages_inclinicpostopdata'] = sanitize_text_field( $input['ids_pages_inclinicpostopdata'] );

        if( isset( $input['ids_pages_inclinicpostopdata_regis'] ) )
                        $new_input['ids_pages_inclinicpostopdata_regis'] = sanitize_text_field( $input['ids_pages_inclinicpostopdata_regis'] );


        if( isset( $input['register_forms_sections_name_json'] ) )
            $new_input['register_forms_sections_name_json'] = sanitize_text_field( $input['register_forms_sections_name_json'] );

        if( isset( $input['profile_forms_sections_name_json'] ) )
            $new_input['profile_forms_sections_name_json'] = sanitize_text_field( $input['profile_forms_sections_name_json'] );

       if( isset( $input['all_user_forms_sections_name_json'] ) )
            $new_input['all_user_forms_sections_name_json'] = sanitize_text_field( $input['all_user_forms_sections_name_json'] );




        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_user_manager_section_info() //print_section_info
    {
        print 'Enter the user manager settings below:';
    }

        /**
     * Get the settings option array and print one of its values
     */
    public function ids_pages_profiles_id_callback() //id_number_callback
    {
        printf(
            '<input type="text" id="ids_pages_profiles" name="user_manager_option_name[ids_pages_profiles]" value="%s" />',//id="id_number" name="my_option_name[id_number]"
            isset( $this->options['ids_pages_profiles'] ) ? esc_attr( $this->options['ids_pages_profiles']) : ''
        );
    }


    public function ids_pages_inclinicpostopdata_callback() //id_number_callback
    {
        printf(
            '<input type="text" id="ids_pages_inclinicpostopdata" name="user_manager_option_name[ids_pages_inclinicpostopdata]" value="%s" />',//id="id_number" name="my_option_name[id_number]"
            isset( $this->options['ids_pages_inclinicpostopdata'] ) ? esc_attr( $this->options['ids_pages_inclinicpostopdata']) : ''
        );
    }

    public function ids_pages_inclinicpostopdata_regis_callback() //id_number_callback
    {
        printf(
            '<input type="text" id="ids_pages_inclinicpostopdata_regis" name="user_manager_option_name[ids_pages_inclinicpostopdata_regis]" value="%s" />',//id="id_number" name="my_option_name[id_number]"
            isset( $this->options['ids_pages_inclinicpostopdata_regis'] ) ? esc_attr( $this->options['ids_pages_inclinicpostopdata_regis']) : ''
        );
    }


        /**
     * Get the settings option array and print one of its values
     */
    public function register_forms_sections_name_json_callback()//title_callback
    {
        printf(
            '<input type="text" id="register_forms_sections_name_json" name="user_manager_option_name[register_forms_sections_name_json]" value="%s" />', //id="title" name="my_option_name[title]"
            isset( $this->options['register_forms_sections_name_json'] ) ? esc_attr( $this->options['register_forms_sections_name_json']) : ''
        );

    }

    public function profile_forms_sections_name_json_callback()//title_callback
    {
        printf(
            '<input type="text" id="profile_forms_sections_name_json" name="user_manager_option_name[profile_forms_sections_name_json]" value="%s" />', //id="title" name="my_option_name[title]"
            isset( $this->options['profile_forms_sections_name_json'] ) ? esc_attr( $this->options['profile_forms_sections_name_json']) : ''
        );

    }

    public function all_user_forms_sections_name_json_callback()//title_callback
    {
        printf(
            '<input type="text" id="all_user_forms_sections_name_json" name="user_manager_option_name[all_user_forms_sections_name_json]" value="%s" />', //id="title" name="my_option_name[title]"
            isset( $this->options['all_user_forms_sections_name_json'] ) ? esc_attr( $this->options['all_user_forms_sections_name_json']) : ''
        );

    }




}
