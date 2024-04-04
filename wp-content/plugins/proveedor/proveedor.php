<?php
/*
Plugin Name: proveedor
Plugin URI: http://www.andomed.com/
Description: Declares a plugin that will create a custom post type displaying and working with ofphthalmologic clinics.
Version: 1.0
Author: Arturo Cecilia
Author URI: http://www.andomed.com/
License: GPLv2
*/



/*Registramos el Custom Post Type => En esta ocasión distribuidor*/
    $proveedor = _x('proveedor','CustomPostType Name','proveedor');

function create_proveedor() {

    $proveedor = _x('proveedor','CustomPostType Name','proveedor');
    $slug_proveedor = _x("proveedor-de-lentes-intraoculares",'taxo-slug','proveedor');
    $slug_archive_proveedor = _x('proveedores-lentes-intraoculares-archive','slug','proveedor');


    register_post_type( $proveedor,
        array(
            'labels' => array(
                'name' => $proveedor,
                'singular_name' => _x('proveedor','admin_display','proveedor'),
                'add_new' => _x('Añadir proveedor','admin_display','proveedor'),
                'add_new_item' => _x('Añadir Nuevo proveedor','admin_display','proveedor'),
                'edit' => _x('Editar','admin_display','proveedor'),
                'edit_item' => _x('Editar proveedor','admin_display','proveedor'),
                'new_item' => _x('Nuevo proveedor','admin_display','proveedor'),
                'view' => _x('Ver','admin_display','proveedor'),
                'view_item' => _x('Ver proveedor','admin_display','proveedor'),
                'search_items' => _x('Buscar proveedor','admin_display','proveedor'),
                'not_found' => _x('No se ha encontrado ningun proveedor','admin_display','proveedor'),
                'not_found_in_trash' => _x('No hay proveedores en la papelera','admin_display','proveedor'),
                'parent' => _x('Proveedor padre','admin_display','proveedor'),
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
            'rewrite' => array("slug" => $slug_proveedor), // /%tipo%/%fabricante%/%toricidad%/%adicion%/%filtros% Permalinks format
            'menu_position' => 6,
            'supports' => array( 'title','editor','thumbnail','excerpt' ),
            'taxonomies' => array( '' ),
            'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
            'has_archive' => $slug_archive_proveedor,
            'how_in_nav_menus'=>TRUE
        )
    );
    //flush_rewrite_rules();
}
add_action( 'init', 'create_proveedor' );
/*Para añadir los CUSTOM FIELDS:
Necesitamos registrar una metaBox y añadirla a nuestro custom post type iol*/
function proveedor_admin() {
    $proveedor = _x('proveedor','CustomPostType Name','proveedor');
    add_meta_box( 'cproveedor_meta_box',/*id attribute*/
        'Datos del proveedor',/*Heading visible de la metabox*/
        'display_proveedor_meta_box',/*Callback function q renderiza el metabox*/
        $proveedor, 'normal', 'high'
    );
}
add_action( 'admin_init', 'proveedor_admin' );

/* AÑADIMOS LOS CUSTOM FIELDS
   Función que renderiza el formulario -> Aquí es donde vamos a añadir los Custom Fields¡¡.
   Recordamos que se añaden los custom fields a partir de inputs en un formulario.
*/
?>
<?php
function display_proveedor_meta_box( $proveedor) {
    
    // Datos de interés del Fabricante de Lentes Intraoculares.
    $proveedorD = esc_html( get_post_meta( $proveedor->ID, 'proveedorD', true ) );
    $proveedorDireccionD = esc_html( get_post_meta( $proveedor->ID, 'proveedorDireccionD', true ) );
    $proveedorTelfContactoD = esc_html( get_post_meta( $proveedor->ID, 'proveedorTelfContactoD', true ) );
    $proveedorEmailContactoD = esc_html( get_post_meta( $proveedor->ID, 'proveedorEmailContactoD', true ) );
    $proveedorWebD = esc_html( get_post_meta( $proveedor->ID, 'proveedorWebD', true ) );
    $proveedorFactorOrd = esc_html( get_post_meta( $proveedor->ID, 'proveedorFactOrdD', true ) );
       
    ?>
    <table>
        <!-- Proveedor -->
        <tr>
            <td style="width: 100%"><?php echo _x('Proveedor (D)','admin_display','proveedor')?> </td>
            <td><input type="text" size="80" name="proveedor-proveedorD" value="<?php echo $proveedorD; ?>" /></td>
        </tr>
        <!-- Proveedor Dirección -->
        <tr>
            <td style="width: 100%"><?php echo _x('Dirección Proveedor (D)','admin_display','proveedor')?> </td>
            <td><input type="text" size="80" name="proveedor-DireccionD" value="<?php echo $proveedorDireccionD; ?>" /></td>
        </tr>

        <!-- Teléfono de Contacto -->
        <tr>
            <td style="width: 100%"><?php echo _x('Telf de Contacto (D)','admin_display','proveedor')?>  </td>
            <td><input type="text" size="80" name="proveedor-telfContactoD" value="<?php echo $proveedorTelfContactoD; ?>" /></td>
        </tr>
        <!-- Email de Contacto -->
        <tr>
            <td style="width: 100%"><?php echo _x('Email de Contacto (D)','admin_display','proveedor')?> </td>
            <td><input type="text" size="80" name="proveedor-emailContactoD" value="<?php echo $proveedorEmailContactoD; ?>" /></td>
        </tr>
       <!-- Web -->
        <tr>
            <td style="width: 100%"><?php echo _x('Web (D)','admin_display','proveedor')?> </td>
            <td><input type="text" size="80" name="proveedor-webD" value="<?php echo $proveedorWebD; ?>" /></td>
        </tr>

        <!-- Factor de Ordenación  -->
        <tr>
            <td style="width: 100%"><?php echo _x('Factor Ordenación (D)','admin_display','proveedor')?></td>
            <td><input type="text" size="80" name="proveedor-factorOrd" value="<?php echo $proveedorFactorOrd; ?>" /></td>
        </tr>


    </table>
    <?php
}
//Añadimos las TAXONOMÍAS de fabricante. 
//function create_fabricante_taxonomies() {
// create a new taxonomy
	/*register_taxonomy(
		'categoria-fabricante',
		'fabricante',
		array('labels' => array(
		       'name'=> 'Categoría de Fabricante',
			   'add_new_item' => 'Añadir nueva Categoría de Fabricante',
			   'new_item_name'=>'Nueva Categoría de Fabricante'
			   ),
			   'show_ui'=> true,
			   'show_tagcloud' =>false,
			   'hierarchical'=>true	
		)
	);*/
//}
//add_action( 'init', 'create_fabricante_taxonomies', 0 );

//Función para guardar el post->la que tratará el formulario-Metabox que ha sido renderizado
add_action( 'save_post', 'add_proveedor_fields', 10, 2 );
function add_proveedor_fields( $proveedor_id, $proveedor ) {
    // Check post type for clinica-oftalmológica
    if ( $proveedor->post_type == _x('proveedor','CustomPostType Name','proveedor') ) {
        // Store data in post meta table if present in post data
        
        //Proveedor
        if ( isset( $_POST['proveedor-proveedorD'] ) && $_POST['proveedor-proveedorD'] != '' ) {
            update_post_meta( $proveedor_id, 'proveedorD', $_POST['proveedor-proveedorD'] );
        }
        
        //Dirección Proveedor
        if ( isset( $_POST['proveedor-DireccionD'] ) && $_POST['proveedor-DireccionD'] != '' ) {
            update_post_meta( $proveedor_id, 'proveedorDireccionD', $_POST['proveedor-DireccionD'] );
        }
        //Teléfono de Contacto
          if ( isset( $_POST['proveedor-telfContactoD'] ) && $_POST['proveedor-telfContactoD'] != '' ) {
            update_post_meta( $proveedor_id, 'proveedorTelfContactoD', $_POST['proveedor-telfContactoD'] );
        }
        //Email de Contacto
          if ( isset( $_POST['proveedor-emailContactoD'] ) && $_POST['proveedor-emailContactoD'] != '' ) {
            update_post_meta( $proveedor_id, 'proveedorEmailContactoD', $_POST['proveedor-emailContactoD'] );
        }
        //Web
          if ( isset( $_POST['proveedor-webD'] ) && $_POST['proveedor-webD'] != '' ) {
            update_post_meta( $proveedor_id, 'proveedorWebD', $_POST['proveedor-webD'] );
        }

        //Factor de Ordenación
          if ( isset( $_POST['proveedor-factorOrd'] ) && $_POST['proveedor-factorOrd'] != '' ) {
            update_post_meta( $proveedor_id, 'proveedorFactorOrd', $_POST['proveedor-factorOrd'] );
        }
   }
}
//Señalamos que en nuestro plug in habrá un post type template por si el custom pot type es iol.
function include_proveedor_template_function( $template_path ) {
    

        $proveedor = _x('proveedor','CustomPostType Name','proveedor');
        //echo $fabricante;
        //echo get_post_type();
    //echo '<strong>'.$template_path.'</strong>';
    if ( get_post_type() == $proveedor ) {
       // echo '<strong>'.$template_path.'</strong>';
        if ( is_single() ) {
                      // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-proveedor.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-proveedor.php';
            }
        }
         elseif ( is_archive() ) {
            if ( $theme_file = locate_template( array ( 'archive-proveedor.php' ) ) ) {
                $template_path = $theme_file;
            } 
            else { 
                $template_path = plugin_dir_path( __FILE__ ) . '/archive-proveedor.php';
            }
         }
    }
    //echo '<strong>'.$template_path.'</strong>';
    return $template_path;
}
add_filter( 'template_include', 'include_proveedor_template_function', 1 );


//add_action('get_template_part_content','control_template_call');

/*
function control_template_call(){
    
    echo '<strong>Template llamada</strong>';
    apply_filters('template_include','template_path');

}*/


//De momento no Vamos a incluir las hojas de estilos y los scripts cuando sea single o archive => Lo suyo será que hagamos un filtrado análogo de clínicas en función del equipamiento...
function proveedor_styles()  
{  
    //Css de JQuery para los controladores de la derecha.
    //wp_enqueue_style('iol-ui-css','http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
    // Register the style like this for a plugin:  
    wp_register_style( 'proveedor-styles', plugins_url( '/css/proveedor.css', __FILE__ ) );  
    // For either a plugin or a theme, you can then enqueue the style:  
    wp_enqueue_style( 'proveedor-styles' );  
}  
add_action( 'wp_enqueue_scripts', 'proveedor_styles' );  


/*-- Vamos a añadir lo Necesario para Localización */
function proveedor_setup() {
    
    /*
     /*-- Vamos a centralizar la ubicación de los mo files --*/
        //load_plugin_textdomain('clinica', false, dirname(plugin_basename(__FILE__)). '/languages/');//
        //load_plugin_textdomain('clinica_display', false, dirname(plugin_basename(__FILE__)). '/languages/');//
        load_plugin_textdomain('proveedor', false, 'nc-sync/languages');
        load_plugin_textdomain('miscelaneous_cpt_display', false, 'nc-sync/languages');
            
            //echo 'fabricante domain being loaded';
       // if(){}
       /* load_plugin_textdomain('clinica_cpt_display', false, 'nc-sync/languages');
        load_plugin_textdomain('clinica-scaffold', false, 'nc-sync/languages'); */
       /* load_plugin_textdomain('clinica', false,    ABSPATH .'wp-content/plugins/nc-sync/languages/');//
            load_plugin_textdomain('clinica_cpt_display', false, ABSPATH .'wp-content/plugins/nc-sync/languages/');//
        */
} // end custom_theme_setup
add_action('plugins_loaded', 'proveedor_setup');



//Por el momento no incluyo nada relacionado con Ajax.

 ?>
