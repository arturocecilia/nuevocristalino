<?php
/*
Plugin Name: fabricante
Plugin URI: http://www.andomed.com/
Description: Declares a plugin that will create a custom post type displaying and working with ofphthalmologic clinics.
Version: 1.0
Author: Arturo Cecilia
Author URI: http://www.andomed.com/
License: GPLv2
*/



/*Registramos el Custom Post Type => En esta ocasi�n fabricante*/
    $fabricante = _x('fabricante','CustomPostType Name','fabricante');

function create_fabricante() {

    $fabricante = _x('fabricante','CustomPostType Name','fabricante');
    $slug_fabricante = _x("fabricante-de-lentes-intraoculares",'taxo-slug','fabricante');
    $slug_archive_fabricante = _x('fabricantes-lentes-intraoculares-archive','slug','fabricante');


    register_post_type( $fabricante,
        array(
            'labels' => array(
                'name' => $fabricante,
                'singular_name' => _x('fabricante','admin_display','fabricante'),
                'add_new' => _x('A�adir fabricante','admin_display','fabricante'),
                'add_new_item' => _x('A�adir Nuevo fabricante','admin_display','fabricante'),
                'edit' => _x('Editar','admin_display','fabricante'),
                'edit_item' => _x('Editar fabricante','admin_display','fabricante'),
                'new_item' => _x('Nuevo fabricante','admin_display','fabricante'),
                'view' => _x('Ver','admin_display','fabricante'),
                'view_item' => _x('Ver fabricante','admin_display','fabricante'),
                'search_items' => _x('Buscar fabricante','admin_display','fabricante'),
                'not_found' => _x('No se ha encontrado ningun fabricante','admin_display','fabricante'),
                'not_found_in_trash' => _x('No hay fabricantes en la papelera','admin_display','fabricante'),
                'parent' => _x('Fabricante padre','admin_display','fabricante'),
                'has_archive'=> FALSE
            ),
                'capabilities' => array(
  																	'edit_post'          => 'manage_options', 
  																	'delete_post'        => 'manage_options', 
  																	'edit_posts'         => 'manage_options', 
  																	'edit_others_posts'  => 'manage_options', 
  																	'publish_posts'      => 'manage_options',       
  																	'create_posts'       => 'manage_options' 
																			),
            'public' => TRUE,
            'yarpp_support' => TRUE, //para YARPP
            'taxonomies' => array('post_tag'), //para YARPP
            'rewrite' => array("slug" => $slug_fabricante), // /%tipo%/%fabricante%/%toricidad%/%adicion%/%filtros% Permalinks format
            'menu_position' => 6,
            'supports' => array( 'title','editor','thumbnail','excerpt' ),
            'taxonomies' => array( '' ),
            'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
            'has_archive' => $slug_archive_fabricante,
            'how_in_nav_menus'=>TRUE
        )
    );
    //flush_rewrite_rules();
}
add_action( 'init', 'create_fabricante' );
/*Para a�adir los CUSTOM FIELDS:
Necesitamos registrar una metaBox y a�adirla a nuestro custom post type iol*/
function fabricante_admin() {
    $fabricante = _x('fabricante','CustomPostType Name','fabricante');
    add_meta_box( 'cfabricante_meta_box',/*id attribute*/
        'Datos del fabricante',/*Heading visible de la metabox*/
        'display_fabricante_meta_box',/*Callback function q renderiza el metabox*/
        $fabricante, 'normal', 'high'
    );
}
add_action( 'admin_init', 'fabricante_admin' );

/* A�ADIMOS LOS CUSTOM FIELDS
   Funci�n que renderiza el formulario -> Aqu� es donde vamos a a�adir los Custom Fields��.
   Recordamos que se a�aden los custom fields a partir de inputs en un formulario.
*/
?>
<?php
function display_fabricante_meta_box( $fabricante ) {
    
    // Datos de inter�s del Fabricante de Lentes Intraoculares.
    $fabricanteD = esc_html( get_post_meta( $fabricante->ID, 'fabricanteD', true ) );
    $fabricanteDireccionD = esc_html( get_post_meta( $fabricante->ID, 'fabricanteDireccionD', true ) );
    $distribNameD = esc_html( get_post_meta( $fabricante->ID, 'distribNameD', true ) );
    $direccionD = esc_html( get_post_meta( $fabricante->ID, 'direccionD', true ) );
    $telfContactoD = esc_html( get_post_meta( $fabricante->ID, 'telfContactoD', true ) );
    $emailContactoD = esc_html( get_post_meta( $fabricante->ID, 'emailContactoD', true ) );
    $webD = esc_html( get_post_meta( $fabricante->ID, 'webD', true ) );
    $webDistD = esc_html( get_post_meta( $fabricante->ID, 'webDistD', true ) );
    $factorOrd = esc_html( get_post_meta( $fabricante->ID, 'factOrdD', true ) );
       
    ?>
    <table>
        <!-- Fabricante -->
        <tr>
            <td style="width: 100%"><?php echo _x('Fabricante (D)','admin_display','fabricante')?> </td>
            <td><input type="text" size="80" name="fabricante-fabricanteD" value="<?php echo $fabricanteD; ?>" /></td>
        </tr>
        <!-- Fabricante Direcci�n -->
        <tr>
            <td style="width: 100%"><?php echo _x('Direcci�n Fabricante (D)','admin_display','fabricante')?> </td>
            <td><input type="text" size="80" name="fabricante-fabricanteDireccionD" value="<?php echo $fabricanteDireccionD; ?>" /></td>
        </tr>
                <!-- Distribuidor en el Pa�s -->
        <tr>
            <td style="width: 100%"><?php echo _x('Distribuidor en el Pa�s (D)','admin_display','fabricante')?> </td>
            <td><input type="text" size="80" name="fabricante-distribNameD" value="<?php echo $distribNameD; ?>" /></td>
        </tr>

        <!-- Direcci�n -->
        <tr>
            <td style="width: 100%"><?php echo _x('Direcci�n (D)','admin_display','fabricante')?>  </td>
            <td><input type="text" size="80" name="fabricante-direccionD" value="<?php echo $direccionD; ?>" /></td>
        </tr>
        <!-- Tel�fono de Contacto -->
        <tr>
            <td style="width: 100%"><?php echo _x('Telf de Contacto (D)','admin_display','fabricante')?>  </td>
            <td><input type="text" size="80" name="fabricante-telfContactoD" value="<?php echo $telfContactoD; ?>" /></td>
        </tr>
        <!-- Email de Contacto -->
        <tr>
            <td style="width: 100%"><?php echo _x('Email de Contacto (D)','admin_display','fabricante')?> </td>
            <td><input type="text" size="80" name="fabricante-emailContactoD" value="<?php echo $emailContactoD; ?>" /></td>
        </tr>
       <!-- Web -->
        <tr>
            <td style="width: 100%"><?php echo _x('Web (D)','admin_display','fabricante')?> </td>
            <td><input type="text" size="80" name="fabricante-webD" value="<?php echo $webD; ?>" /></td>
        </tr>
        <!-- Web Distribuidor D -->
        <tr>
            <td style="width: 100%"><?php echo _x('Web Distribuidor (D)','admin_display','fabricante')?></td>
            <td><input type="text" size="80" name="fabricante-webDistD" value="<?php echo $webDistD; ?>" /></td>
        </tr>
        <!-- Factor de Ordenaci�n  -->
        <tr>
            <td style="width: 100%"><?php echo _x('Factor Ordenaci�n (D)','admin_display','fabricante')?></td>
            <td><input type="text" size="80" name="fabricante-factorOrd" value="<?php echo $factorOrd; ?>" /></td>
        </tr>


    </table>
    <?php
}
//A�adimos las TAXONOM�AS de fabricante. 
function create_fabricante_taxonomies() {
// create a new taxonomy
	/*register_taxonomy(
		'categoria-fabricante',
		'fabricante',
		array('labels' => array(
		       'name'=> 'Categor�a de Fabricante',
			   'add_new_item' => 'A�adir nueva Categor�a de Fabricante',
			   'new_item_name'=>'Nueva Categor�a de Fabricante'
			   ),
			   'show_ui'=> true,
			   'show_tagcloud' =>false,
			   'hierarchical'=>true	
		)
	);*/
}
//add_action( 'init', 'create_fabricante_taxonomies', 0 );

//Funci�n para guardar el post->la que tratar� el formulario-Metabox que ha sido renderizado
add_action( 'save_post', 'add_fabricante_fields', 10, 2 );
function add_fabricante_fields( $fabricante_id, $fabricante ) {
    // Check post type for clinica-oftalmol�gica
    if ( $fabricante->post_type == _x('fabricante','CustomPostType Name','fabricante') ) {
        // Store data in post meta table if present in post data
        
        //Fabricante
        if ( isset( $_POST['fabricante-fabricanteD'] ) && $_POST['fabricante-fabricanteD'] != '' ) {
            update_post_meta( $fabricante_id, 'fabricanteD', $_POST['fabricante-fabricanteD'] );
        }
        
        //Direcci�n Fabricante
        if ( isset( $_POST['fabricante-fabricanteDireccionD'] ) && $_POST['fabricante-fabricanteDireccionD'] != '' ) {
            update_post_meta( $fabricante_id, 'fabricanteDireccionD', $_POST['fabricante-fabricanteDireccionD'] );
        }
        //Distribuidor en el Pa�s
          if ( isset( $_POST['fabricante-distribNameD'] ) && $_POST['fabricante-distribNameD'] != '' ) {
            update_post_meta( $fabricante_id, 'distribNameD', $_POST['fabricante-distribNameD'] );
        }
        //Direcci�n
          if ( isset( $_POST['fabricante-direccionD'] ) && $_POST['fabricante-direccionD'] != '' ) {
            update_post_meta( $fabricante_id, 'direccionD', $_POST['fabricante-direccionD'] );
        }
        //Tel�fono de Contacto
          if ( isset( $_POST['fabricante-telfContactoD'] ) && $_POST['fabricante-telfContactoD'] != '' ) {
            update_post_meta( $fabricante_id, 'telfContactoD', $_POST['fabricante-telfContactoD'] );
        }
        //Email de Contacto
          if ( isset( $_POST['fabricante-emailContactoD'] ) && $_POST['fabricante-emailContactoD'] != '' ) {
            update_post_meta( $fabricante_id, 'emailContactoD', $_POST['fabricante-emailContactoD'] );
        }
        //Web
          if ( isset( $_POST['fabricante-webD'] ) && $_POST['fabricante-webD'] != '' ) {
            update_post_meta( $fabricante_id, 'webD', $_POST['fabricante-webD'] );
        }
        //Web Distribuidor
          if ( isset( $_POST['fabricante-webDistD'] ) && $_POST['fabricante-webDistD'] != '' ) {
            update_post_meta( $fabricante_id, 'webDistD', $_POST['fabricante-webDistD'] );
        }

        //Factor de Ordenaci�n
          if ( isset( $_POST['fabricante-factorOrd'] ) && $_POST['fabricante-factorOrd'] != '' ) {
            update_post_meta( $fabricante_id, 'factorOrd', $_POST['fabricante-factorOrd'] );
        }
   }
}
//Se�alamos que en nuestro plug in habr� un post type template por si el custom pot type es iol.
function include_fabricante_template_function( $template_path ) {
    

        $fabricante = _x('fabricante','CustomPostType Name','fabricante');
        //echo $fabricante;
        //echo get_post_type();
    //echo '<strong>'.$template_path.'</strong>';
    if ( get_post_type() == $fabricante ) {
       // echo '<strong>'.$template_path.'</strong>';
        if ( is_single() ) {
                      // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-fabricante.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-fabricante.php';
            }
        }
         elseif ( is_archive() ) {
            if ( $theme_file = locate_template( array ( 'archive-fabricante.php' ) ) ) {
                $template_path = $theme_file;
            } 
            else { 
                $template_path = plugin_dir_path( __FILE__ ) . '/archive-fabricante.php';
            }
         }
    }
    //echo '<strong>'.$template_path.'</strong>';
    return $template_path;
}
add_filter( 'template_include', 'include_fabricante_template_function', 1 );


//add_action('get_template_part_content','control_template_call');

/*
function control_template_call(){
    
    echo '<strong>Template llamada</strong>';
    apply_filters('template_include','template_path');

}*/


//De momento no Vamos a incluir las hojas de estilos y los scripts cuando sea single o archive => Lo suyo ser� que hagamos un filtrado an�logo de cl�nicas en funci�n del equipamiento...
function fabricante_styles()  
{  
    //Css de JQuery para los controladores de la derecha.
    //wp_enqueue_style('iol-ui-css','http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
    // Register the style like this for a plugin:  
    wp_register_style( 'fabricante-styles', plugins_url( '/css/fabricante.css', __FILE__ ) );  
    // For either a plugin or a theme, you can then enqueue the style:  
    wp_enqueue_style( 'fabricante-styles' );  
}  
add_action( 'wp_enqueue_scripts', 'fabricante_styles' );  

//Ahora incluimos los scripts javascript
function fabricante_scripts()  
{  
    // Register the script like this for a plugin: 
    if(is_post_type_archive( array('lente-intraocular')) or is_single())
    { 
        //wp_enqueue_script('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js', array('jquery'), '1.8.6');
        
  	  wp_register_script('jquery-ui', ("https://code.jquery.com/ui/1.10.3/jquery-ui.js"), false, '');
      wp_register_script( 'lente-intraocular-js', plugins_url( '/js/iol.js', __FILE__ ),array('jquery','jquery-ui') );  
    }
    // For either a plugin or a theme, you can then enqueue the script:  
    wp_enqueue_script( 'lente-intraocular-js' );  
}  
//add_action( 'wp_enqueue_scripts', 'iol_scripts');

/*-- Vamos a a�adir lo Necesario para Localizaci�n */
function fabricante_setup() {
    
    /*
     /*-- Vamos a centralizar la ubicaci�n de los mo files --*/
        //load_plugin_textdomain('clinica', false, dirname(plugin_basename(__FILE__)). '/languages/');//
        //load_plugin_textdomain('clinica_display', false, dirname(plugin_basename(__FILE__)). '/languages/');//
        load_plugin_textdomain('fabricante', false, 'nc-sync/languages');
        load_plugin_textdomain('miscelaneous_cpt_display', false, 'nc-sync/languages');
            
            //echo 'fabricante domain being loaded';
       // if(){}
       /* load_plugin_textdomain('clinica_cpt_display', false, 'nc-sync/languages');
        load_plugin_textdomain('clinica-scaffold', false, 'nc-sync/languages'); */
       /* load_plugin_textdomain('clinica', false,    ABSPATH .'wp-content/plugins/nc-sync/languages/');//
            load_plugin_textdomain('clinica_cpt_display', false, ABSPATH .'wp-content/plugins/nc-sync/languages/');//
        */
} // end custom_theme_setup
add_action('plugins_loaded', 'fabricante_setup');



//Por el momento no incluyo nada relacionado con Ajax.

 ?>
