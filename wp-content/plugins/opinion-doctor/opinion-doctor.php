<?php
/*
Plugin Name: opiniones-doctor
Plugin URI: http://www.andomed.com/
Description: Declares a plugin that will create a custom post type displaying and working with ofphthalmologic clinics.
Version: 1.0
Author: Arturo Cecilia
Author URI: http://www.andomed.com/
License: GPLv2
*/



/*Registramos el Custom Post Type => En esta ocasión opinion-doctor*/
function create_opinion_doctor() {

    $opinion_doctor = _x('opinion-doctor','CustomPostType Name','opinion-doctor');
    $slug_opinion_doctor = _x("opinion-oftalmologo",'taxo-slug','opinion-doctor');
    $slug_archive_opinion_doctor = _x('opiniones-oftalmologos','slug','opinion-doctor');


    register_post_type( $opinion_doctor,
        array(
            'labels' => array(
                'name' => $opinion_doctor,
                'singular_name' => _x('Testimonio de Doctor','admin_display','opinion-doctor'),
                'add_new' => _x('Añadir Testimonio de Doctor','admin_display','opinion-doctor'),
                'add_new_item' => _x('Añadir Nuevo Testimonio de Doctor','admin_display','opinion-doctor'),
                'edit' => _x('Editar','admin_display','opinion-doctor'),
                'edit_item' => _x('Editar Testimonio de doctor','admin_display','opinion-doctor'),
                'new_item' => _x('Nuevo Testimonio de Doctor','admin_display','opinion-doctor'),
                'view' => _x('Ver','admin_display','opinion-doctor'),
                'view_item' => _x('Ver testimonio de Doctor','admin_display','opinion-doctor'),
                'search_items' => _x('Buscar testimonio de doctor','admin_display','opinion-doctor'),
                'not_found' => _x('No se ha encontrado ningun testimonio de doctor','admin_display','opinion-doctor'),
                'not_found_in_trash' => _x('No hay testimonios de doctores en la papelera','admin_display','opinion-doctor'),
                'parent' => _x('Testimonio de Doctor padre','admin_display','opinion-doctor')
            ),
            'public' => TRUE,
            'yarpp_support' => TRUE, //para YARPP
            'taxonomies' => array('post_tag'), //para YARPP
            'rewrite' => array("slug" => $slug_opinion_doctor), // /%tipo%/%fabricante%/%toricidad%/%adicion%/%filtros% Permalinks format
            'menu_position' => 6,
            'supports' => array( 'title','editor','thumbnail','excerpt' ),
            'taxonomies' => array( '' ),
            'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
            'has_archive' => $slug_archive_opinion_doctor,
            'how_in_nav_menus'=>TRUE
        )
    );
    //flush_rewrite_rules();
}
add_action( 'init', 'create_opinion_doctor' );

/*Para añadir los CUSTOM FIELDS:
Necesitamos registrar una metaBox y añadirla a nuestro custom post type iol*/
function opinion_doctor_admin() {
    add_meta_box( 'cOpinion_doctor_meta_box',/*id attribute*/
        _x('Información adicional sobre el doctor que aporta su opinión','admin_display','opinion-doctor'),/*Heading visible de la metabox*/
        'display_opinion_doctor_meta_box',/*Callback function q renderiza el metabox*/
        'opinion-doctor', 'normal', 'high'
    );
}
add_action( 'admin_init', 'opinion_doctor_admin' );



//Añadimos dos metadatos.
function display_opinion_doctor_meta_box( $opinion_doctor ) {
    
    // Datos de interés del Fabricante de Lentes Intraoculares. 
    $clinica1D = esc_html( get_post_meta( $opinion_doctor->ID, 'clinica1D', true ) );
    $ciudad1D = esc_html( get_post_meta( $opinion_doctor->ID, 'ciudad1D', true ) );
    $webClinica1D = esc_html( get_post_meta( $opinion_doctor->ID, 'webClinica1D', true ) );

    $clinica2D = esc_html( get_post_meta( $opinion_doctor->ID, 'clinica2D', true ) );
    $ciudad2D = esc_html( get_post_meta( $opinion_doctor->ID, 'ciudad2D', true ) );       
    $webClinica2D = esc_html( get_post_meta( $opinion_doctor->ID, 'webClinica2D', true ) );    

    ?>
    <table>
        <!-- Clínica1 Donde Opera el Doctor -->
        <tr>
            <td style="width: 100%"><?php echo _x('Clínica 1 donde opera el doctor (D)','admin_display','opinion-doctor')?> </td>
            <td><input type="text" size="80" name="opinion-doctor-clinica1D" value="<?php echo $clinica1D; ?>" /></td>
        </tr>
        <!-- Ciudad donde está la clínica 1 -->
        <tr>
            <td style="width: 100%"><?php echo _x('Ciudad-dirección donde está la clínica 1 (D)','admin_display','opinion-doctor')?>  </td>
            <td><input type="text" size="80" name="opinion-doctor-ciudad1D" value="<?php echo $ciudad1D; ?>" /></td>
        </tr>
        <!-- Web de la Clínica1 Donde Opera el Doctor -->
        <tr>
            <td style="width: 100%"><?php echo _x('Web de la clínica 1 donde opera el doctor (D)','admin_display','opinion-doctor')?> </td>
            <td><input type="text" size="80" name="opinion-doctor-webClinica1D" value="<?php echo $webClinica1D; ?>" /></td>
        </tr>

        <!-- Clínica2 Donde Opera el Doctor -->
        <tr>
            <td style="width: 100%"><?php echo _x('Clínicas 2 opera el doctor (D)','admin_display','opinion-doctor')?> </td>
            <td><input type="text" size="80" name="opinion-doctor-clinica2D" value="<?php echo $clinica2D; ?>" /></td>
        </tr>

        <!-- Ciudad donde está la clínica 2 -->
        <tr>
            <td style="width: 100%"><?php echo _x('Ciudad-dirección donde está la clínica 2 (D)','admin_display','opinion-doctor')?>  </td>
            <td><input type="text" size="80" name="opinion-doctor-ciudad2D" value="<?php echo $ciudad2D; ?>" /></td>
        </tr>

        <!-- Web de la Clínica1 Donde Opera el Doctor -->
        <tr>
            <td style="width: 100%"><?php echo _x('Web de la clínica 2 donde opera el doctor (D)','admin_display','opinion-doctor')?> </td>
            <td><input type="text" size="80" name="opinion-doctor-webClinica2D" value="<?php echo $webClinica2D; ?>" /></td>
        </tr>

    </table>
    <?php
}


//Función para guardar el post->la que tratará el formulario-Metabox que ha sido renderizado
add_action( 'save_post', 'add_opinion_doctor_fields', 10, 2 );
function add_opinion_doctor_fields( $opinion_doctor_id, $opinion_doctor ) {
    // Check post type for clinica-oftalmológica
    if ( $opinion_doctor->post_type == 'opinion-doctor' ) {
       
        //Nombre Clínica 1.
          if ( isset( $_POST['opinion-doctor-clinica1D'] ) && $_POST['opinion-doctor-clinica1D'] != '' ) {
            update_post_meta( $opinion_doctor_id, 'clinica1D', $_POST['opinion-doctor-clinica1D'] );
        }
        //Ciudad-Dirección Clínica 1.
          if ( isset( $_POST['opinion-doctor-ciudad1D'] ) && $_POST['opinion-doctor-ciudad1D'] != '' ) {
            update_post_meta( $opinion_doctor_id, 'ciudad1D', $_POST['opinion-doctor-ciudad1D'] );
        }
        //Web Clínica 1.
          if ( isset( $_POST['opinion-doctor-webClinica1D'] ) && $_POST['opinion-doctor-webClinica1D'] != '' ) {
            update_post_meta( $opinion_doctor_id, 'webClinica1D', $_POST['opinion-doctor-webClinica1D'] );
        }

        //Nombre Clínica 2.
          if ( isset( $_POST['opinion-doctor-clinica2D'] ) && $_POST['opinion-doctor-clinica2D'] != '' ) {
            update_post_meta( $opinion_doctor_id, 'clinica2D', $_POST['opinion-doctor-clinica2D'] );
        }
        //Ciudad-Dirección Clínica 2.
          if ( isset( $_POST['opinion-doctor-ciudad2D'] ) && $_POST['opinion-doctor-ciudad2D'] != '' ) {
            update_post_meta( $opinion_doctor_id, 'ciudad2D', $_POST['opinion-doctor-ciudad2D'] );
        }
        //Web Clínica 2.
          if ( isset( $_POST['opinion-doctor-webClinica2D'] ) && $_POST['opinion-doctor-webClinica2D'] != '' ) {
            update_post_meta( $opinion_doctor_id, 'webClinica2D', $_POST['opinion-doctor-webClinica2D'] );
        }
   }
}



//Señalamos que en nuestro plug in habrá un post type template por si el custom pot type es iol.
function include_opinion_doctor_template_function( $template_path ) {
    //echo '<strong>'.$template_path.'</strong>';

    $opinion_doctor = _x('opinion-doctor','CustomPostType Name','opinion-doctor');

    if ( get_post_type() == $opinion_doctor ) {

        if ( is_single() ) {
                      // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-opinion-doctor.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-opinion-doctor.php';
            }
        }
         elseif ( is_archive() ) {
            if ( $theme_file = locate_template( array ( 'archive-opinion-doctor.php' ) ) ) {
                $template_path = $theme_file;
            } 
            else { 
                $template_path = plugin_dir_path( __FILE__ ) . '/archive-opinion-doctor.php';
            }
         }
    }
    //echo '<strong>'.$template_path.'</strong>';
    return $template_path;
}
add_filter( 'template_include', 'include_opinion_doctor_template_function', 1 );


//De momento no Vamos a incluir las hojas de estilos y los scripts cuando sea single o archive => Lo suyo será que hagamos un filtrado análogo de clínicas en función del equipamiento...
function opinion_doctor_styles()  
{  

    // Register the style like this for a plugin:  
    wp_register_style( 'opinion-doctor-styles', plugins_url( '/css/opinion-doctor.css', __FILE__ ) );  
    // For either a plugin or a theme, you can then enqueue the style:  
    wp_enqueue_style( 'opinion-doctor-styles' );  
}  
add_action( 'wp_enqueue_scripts', 'opinion_doctor_styles' );  



 function opinion_doctor_setup() {
    
 //if(load_textdomain('opinion-doctor',  ABSPATH .'wp-content/plugins/nc-sync/languages/opinion-doctor-'.get_locale().'.mo'))
 if(load_plugin_textdomain('opinion-doctor', false, 'nc-sync/languages'))
 {
    // load_plugin_textdomain('opinion-doctor', false, 'nc-sync/languages');
     //echo ABSPATH .'wp-content/plugins/nc-sync/languages/opinion-doctor-'.get_locale().'.mo';
    //echo __('opinion-doctor','opinion-doctor');
    //echo _x('opinion-doctor','CustomPostType Name','opinion-doctor');
 }else{
      //  echo 'no compilado correctamente'; 
     }
} // end custom_theme_setup
add_action('after_setup_theme', 'opinion_doctor_setup');
 ?>
