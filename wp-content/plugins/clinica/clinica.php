<?php
/*
Plugin Name: Clinica Oftalmologica
Plugin URI: http://www.andomed.com/
Description: Declares a plugin that will create a custom post type displaying and working with ofphthalmologic clinics.
Version: 1.0
Author: Arturo Cecilia
Author URI: http://www.andomed.com/
License: GPLv2
*/



/*Registramos el Custom Post Type => En esta ocasión clinica oftalmológica*/
$clinica = _x('clinica', 'CustomPostType Name', 'clinica');

function create_clinicoftalmologic()
{
    $clinica = _x('clinica', 'CustomPostType Name', 'clinica');
    $slug_clinica =_x("clinica-oftalmologica-lente-intraocular", 'taxo-slug', 'clinica');
    $slug_archive_clinica = _x('clinicas-oftalmologicas-lente-intraocular', 'slug', 'clinica');

    register_post_type(
        $clinica, //$clinica
        array(
            'labels' => array(
                'name' => $clinica,
                'singular_name' => _x('clinica', 'admin_display', 'clinica'),
                'add_new' => _x('Añadir Nueva', 'admin_display', 'clinica'),
                'add_new_item' => _x('Añadir Nueva Clínica Oftalmológica', 'admin_display', 'clinica'),
                'edit' => 'Editar',_x('admin_display', 'clinica'),
                'edit_item' => _x('Editar Clínica Oftalmológica', 'admin_display', 'clinica'),
                'new_item' => _x('Nueva Clínica Oftalmológica', 'admin_display', 'clinica'),
                'view' => 'Ver',_x('admin_display', 'clinica'),
                'view_item' => _x('Ver Clínica Oftamológica', 'admin_display', 'clinica'),
                'search_items' => _x('Buscar Clínica Oftamológica', 'admin_display', 'clinica'),
                'not_found' => _x('No se ha encontrado ninguna Clínica Oftamológica', 'admin_display', 'clinica'),
                'not_found_in_trash' => _x('No hay Clínicas Oftalmológicas en la papelera', 'admin_display', 'clinica'),
                'parent' => _x('Clínica Oftamológica padre', 'admin_display', 'clinica')
            ),
                        'capabilities' => array(
                                                                    'edit_post'          => 'manage_options',
                                                                    'delete_post'        => 'manage_options',
                                                                    'edit_posts'         => 'manage_options',
                                                                    'edit_others_posts'  => 'manage_options',
                                                                    'publish_posts'      => 'manage_options',
                                                                    'create_posts'       => 'manage_options'
                                                                            ),
            'public' => true,
            'rewrite' => array("slug" => $slug_clinica), // /%tipo%/%fabricante%/%toricidad%/%adicion%/%filtros% Permalinks format
            'menu_position' => 6,
            'supports' => array( 'title','editor','thumbnail','excerpt','page-attributes' ),
            'taxonomies' => array( '' ),
            'hierarchical' =>true,
            'menu_icon' => plugins_url('images/image.png', __FILE__),
            'has_archive' => $slug_archive_clinica,
            'how_in_nav_menus'=>true
        )
    );
    //flush_rewrite_rules();
}
add_action('init', 'create_clinicoftalmologic');
/*Para añadir los CUSTOM FIELDS:
Necesitamos registrar una metaBox y añadirla a nuestro custom post type iol*/
function clinica_admin()
{
    $clinica = _x('clinica', 'CustomPostType Name', 'clinica');

    add_meta_box(
        'clinica_meta_box',/*id attribute*/
        'Datos de la Clínica Oftalmológica',/*Heading visible de la metabox*/
        'display_clinica_meta_box',/*Callback function q renderiza el metabox*/
        $clinica,
        'normal',
        'high'
    );
}
add_action('admin_init', 'clinica_admin');

/* AÑADIMOS LOS CUSTOM FIELDS
   Función que renderiza el formulario -> Aquí es donde vamos a añadir los Custom Fields¡¡.
   Recordamos que se añaden los custom fields a partir de inputs en un formulario.
*/
?>
<?php
function display_clinica_meta_box($clinica)
{

    // Serán las informaciones Técnicas que no estén incluidas en Taxonomías.

    $direccionD = esc_html(get_post_meta($clinica->ID, 'direccionD', true));
    $latitudD = esc_html(get_post_meta($clinica->ID, 'latitudD', true));
    $longitudD = esc_html(get_post_meta($clinica->ID, 'longitudD', true));

    $telfContactoD = esc_html(get_post_meta($clinica->ID, 'telfContactoD', true));
    $emailContactoD = esc_html(get_post_meta($clinica->ID, 'emailContactoD', true));
    $horarioD = esc_html(get_post_meta($clinica->ID, 'horarioD', true));

    $directorMedicoD = esc_html(get_post_meta($clinica->ID, 'directorMedicoD', true));
    $doctoresD = esc_html(get_post_meta($clinica->ID, 'doctoresD', true));

    $webClinicD = esc_html(get_post_meta($clinica->ID, 'webClinicD', true));

    $nivelPrefClinicaMD = esc_html(get_post_meta($clinica->ID, 'nivelPrefClinicaMD', true));
    $apMapsD = esc_html(get_post_meta($clinica->ID, 'apMapsD', true)); ?>
    <table>
        <!-- Dirección -->
        <tr>
            <td style="width: 100%"><?php echo _x('Dirección (D)', 'admin_display', 'clinica'); ?> </td>
            <td><input type="text" size="80" name="clinica-direccionD" value="<?php echo $direccionD; ?>" /></td>
        </tr>
        <!-- Añadimos las coordenadas de Latitud y Longitud -->
        <tr>
            <td style="width: 100%"><?php echo _x('Latitud', 'admin_display', 'clinica'); ?> </td>
            <td><input type="text" size="80" name="clinica-latitudD" value="<?php echo $latitudD; ?>" /></td>
        </tr>

        <tr>
            <td style="width: 100%"><?php echo _x('Longitud', 'admin_display', 'clinica'); ?> </td>
            <td><input type="text" size="80" name="clinica-longitudD" value="<?php echo $longitudD; ?>" /></td>
        </tr>


        <!-- Teléfono de Contacto -->
        <tr>
            <td style="width: 100%"><?php echo _x('Telf de Contacto (D)', 'admin_display', 'clinica'); ?> </td>
            <td><input type="text" size="80" name="clinica-telfContactoD" value="<?php echo $telfContactoD; ?>" /></td>
        </tr>
        <!-- Email de Contacto -->
        <tr>
            <td style="width: 100%"><?php echo _x('Email de Contacto (D)', 'admin_display', 'clinica'); ?> </td>
            <td><input type="text" size="80" name="clinica-emailContactoD" value="<?php echo $emailContactoD; ?>" /></td>
        </tr>
       <!-- Horario -->
        <tr>
            <td style="width: 100%"><?php echo _x('Horario (D)', 'admin_display', 'clinica'); ?> </td>
            <td><input type="text" size="80" name="clinica-horarioD" value="<?php echo $horarioD; ?>" /></td>
        </tr>
        <!-- Director Médico -->
        <tr>
            <td style="width: 100%"><?php echo _x('Director Médico (D)', 'admin_display', 'clinica'); ?> </td>
            <td><input type="text" size="80" name="clinica-directorMedicoD" value="<?php echo $directorMedicoD; ?>" /></td>
        </tr>

        <!-- Doctores  -->
        <tr>
            <td style="width: 100%"><?php echo _x('Doctores (D)', 'admin_display', 'clinica'); ?> </td>
            <td><input type="text" size="80" name="clinica-doctoresD" value="<?php echo $doctoresD; ?>" /></td>
        </tr>

        <!-- Web de la Clínica  -->
        <tr>
            <td style="width: 100%"><?php echo _x('Website (D)', 'admin_display', 'clinica'); ?> </td>
            <td><input type="text" size="80" name="clinica-webClinicD" value="<?php echo $webClinicD; ?>" /></td>
        </tr>

        <!-- NPrefClinica-->
        <tr>
            <td style="width: 100%"><?php echo _x('Nivel de Preferencia de la clínica (Ascendente)', 'admin_display', 'clinica'); ?> </td>
            <td><input type="text" size="80" name="clinica-nivelPrefClinicaMD" value="<?php echo $nivelPrefClinicaMD; ?>" /></td>
        </tr>

        <!-- APMaps-->
        <tr>
            <td style="width: 100%"><?php echo 'apMaps'; ?> </td>
            <td><input type="text" size="80" name="clinica-apMapsD" value="<?php echo $apMapsD; ?>" /></td>
        </tr>



    </table>
    <?php
}
//Añadimos las TAXONOMÍAS de la Clínica.
//La primera será la 1a Subdivisión Territorial del país (España => Comunidad Autónoma, EEUU=> Estado, Francia => Region).
function create_clinica_taxonomies()
{
    $clinica = _x('clinica', 'CustomPostType Name', 'clinica');
    //Diseño de Óptica.
    $clinica_taxo_ubicacion = _x('ubicacion', 'taxo-name', 'clinica');
    $clinica_taxo_ubicacion_slug =_x('clinica-oftalmologica-lente-intraocular/ubicacion', 'slug', 'clinica');

    register_taxonomy(
        $clinica_taxo_ubicacion,
        $clinica,
        array(
            'labels' => array(
                'name' =>  _x('Ubicación de la clínica', 'admin_display', 'clinica'),
                'add_new_item' =>  _x('Añadir Nueva Ubicacion', 'admin_display', 'clinica'),
                'new_item_name' =>  _x('Nuevo Nombre de Ubicacion', 'admin_display', 'clinica')
            ),
                           'capabilities'=>array(
                                                                    'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                    'edit_terms' => 'manage_options',
                                                                    'delete_terms' => 'manage_options',
                                                                    'assign_terms' =>'manage_options'),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
            ,'rewrite'=> array('slug'=>$clinica_taxo_ubicacion_slug)
        )
    );

    //La tercera son los seguros que admite

    $clinica_taxo_seguros = _x('seguros', 'taxo-name', 'clinica');
    $clinica_taxo_seguros_slug =_x('clinica-oftalmologica-lente-intraocular/seguros', 'slug', 'clinica');

    register_taxonomy(
        $clinica_taxo_seguros,
        $clinica,
        array(
            'labels' => array(
                'name' => _x('Seguros de la Clínica Oftalmológica', 'admin_display', 'clinica'),
                'add_new_item' => _x('Añadir Seguro de Clínica Oftalmológica', 'admin_display', 'clinica'),
                'new_item_name' => _x("Nuevo Nomre de Seguro Médico", 'admin_display', 'clinica')
            ),
                           'capabilities'=>array(
                                                                    'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                    'edit_terms' => 'manage_options',
                                                                    'delete_terms' => 'manage_options',
                                                                    'assign_terms' =>'manage_options'),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
            ,'rewrite' => array( 'slug' => $clinica_taxo_seguros_slug )
        )
    );
    //Ahora creamos las taxonomías que permiten el filtrado.



    //Equipamiento.
    $clinica_taxo_Equipamiento = _x('equipamiento-clinica', 'taxo-name', 'clinica');
    $clinica_taxo_Equipamiento_slug =_x('clinica-oftalmologica-lente-intraocular/tecnologia-equipos', 'slug', 'clinica');

    register_taxonomy(
        $clinica_taxo_Equipamiento,
        $clinica,
        array(
            'labels' => array(
                'name' => _x('Equipamiento de la Clínica Oftalmológica', 'admin_display', 'clinica'),
                'add_new_item' => _x('Añadir equipamientos de la Clínica Oftalmológica', 'admin_display', 'clinica'),
                'new_item_name' => _x("Nuevo nombre  de equipamiento de la clínica.", 'admin_display', 'clinica')
            ),
                           'capabilities'=>array(
                                                                    'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                    'edit_terms' => 'manage_options',
                                                                    'delete_terms' => 'manage_options',
                                                                    'assign_terms' =>'manage_options'),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
            ,'rewrite' => array( 'slug' => $clinica_taxo_Equipamiento_slug)
        )
    );
    //Equipamiento.
    $clinica_taxo_mInf = _x('mas-info-clinica', 'taxo-name', 'clinica');
    $clinica_taxo_mInf_slug =_x('clinica-oftalmologica-lente-intraocular/mas-info-clinica', 'slug', 'clinica');

    register_taxonomy(
        $clinica_taxo_mInf,
        $clinica,
        array(
            'labels' => array(
                'name' => _x('Informacion Adicional de la Clínica Oftalmológica', 'admin_display', 'clinica'),
                'add_new_item' => _x('Añadir Más Info de la Clínica Oftalmológica', 'admin_display', 'clinica'),
                'new_item_name' => _x("Nuevo nombre de información adicional de la clínica.", 'admin_display', 'clinica')
            ),
                           'capabilities'=>array(
                                                                    'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                    'edit_terms' => 'manage_options',
                                                                    'delete_terms' => 'manage_options',
                                                                    'assign_terms' =>'manage_options'),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
            ,'rewrite' => array( 'slug' => $clinica_taxo_mInf_slug)
        )
    );


    //Femto.

    $clinica_taxo_femtoFaco = _x('femto-faco', 'taxo-name', 'clinica');
    $clinica_taxo_femtoFaco_slug = _x('clinica-oftalmologica-lente-intraocular/femto-faco', 'slug', 'clinica');

    register_taxonomy(
        $clinica_taxo_femtoFaco,
        $clinica,
        array(
            'labels' => array(
                'name' => _x('Información sobre el femto faco de la clínica', 'admin_display', 'clinica'),
                'add_new_item' => _x('Añadir Info del femto faco de Clínica Oftalmológica', 'admin_display', 'clinica'),
                'new_item_name' => _x("Nueva Info del femto faco", 'admin_display', 'clinica')
            ),
                           'capabilities'=>array(
                                                                    'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                    'edit_terms' => 'manage_options',
                                                                    'delete_terms' => 'manage_options',
                                                                    'assign_terms' =>'manage_options'),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
            ,'rewrite' => array( 'slug' => $clinica_taxo_femtoFaco_slug)
        )
    );

    //Posibilidad de Financiación

    $clinica_taxo_finance = _x('financiacion', 'taxo-name', 'clinica');
    $clinica_taxo_finance_slug = _x('clinica-oftalmologica-lente-intraocular/financiacion', 'slug', 'clinica');

    register_taxonomy(
        $clinica_taxo_finance,
        $clinica,
        array(
            'labels' => array(
                'name' => _x('Información sobre la financiación de la clínica', 'admin_display', 'clinica'),
                'add_new_item' => _x('Añadir Info de la financiación de la Clínica Oftalmológica', 'admin_display', 'clinica'),
                'new_item_name' => _x("Nueva Info de la financiación", 'admin_display', 'clinica')
            ),
                           'capabilities'=>array(
                                                                    'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                    'edit_terms' => 'manage_options',
                                                                    'delete_terms' => 'manage_options',
                                                                    'assign_terms' =>'manage_options'),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
            ,'rewrite' => array( 'slug' => $clinica_taxo_finance_slug)
        )
    );




    //Nivel de preferencia de la clínica, de cara a su ordenación.

    $clinica_taxo_nPClinica = _x('nivel-pref-clinica', 'taxo-name', 'clinica');
    ;
    $clinica_taxo_nPClinica_slug = _x('clinica-oftalmologica-lente-intraocular/nivel-pref-clinica', 'slug', 'clinica');

    register_taxonomy(
        $clinica_taxo_nPClinica,
        $clinica,
        array(
            'labels' => array(
                'name' => _x('Nivel de Preferencia de la clínica', 'admin_display', 'clinica'),
                'add_new_item' => _x('Añadir Nivel de preferencia de la Clínica', 'admin_display', 'clinica'),
                'new_item_name' => _x("Nuevo Nivel de preferencia", 'admin_display', 'clinica')
            ),
                           'capabilities'=>array(
                                                                    'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                    'edit_terms' => 'manage_options',
                                                                    'delete_terms' => 'manage_options',
                                                                    'assign_terms' =>'manage_options'),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
            ,'rewrite' => array( 'slug' => $clinica_taxo_nPClinica_slug )
        )
    );
}
add_action('init', 'create_clinica_taxonomies', 0);

//Función para guardar el post->la que tratará el formulario-Metabox que ha sido renderizado
add_action('save_post', 'add_clinica_fields', 10, 2);
function add_clinica_fields($clinica_id, $clinica)
{
    $clinica_name = _x('clinica', 'CustomPostType Name', 'clinica');

    // Check post type for clinica-oftalmológica
    if ($clinica->post_type == $clinica_name) {
        // Store data in post meta table if present in post data
        //Dirección
        if (isset($_POST['clinica-direccionD']) && $_POST['clinica-direccionD'] != '') {
            update_post_meta($clinica_id, 'direccionD', $_POST['clinica-direccionD']);
        }
        //Latitud
        if (isset($_POST['clinica-latitudD']) && $_POST['clinica-latitudD'] != '') {
            update_post_meta($clinica_id, 'latitudD', $_POST['clinica-latitudD']);
        }
        //Longitud
        if (isset($_POST['clinica-longitudD']) && $_POST['clinica-longitudD'] != '') {
            update_post_meta($clinica_id, 'longitudD', $_POST['clinica-longitudD']);
        }
        //Teléfono de Contacto
        if (isset($_POST['clinica-telfContactoD']) && $_POST['clinica-telfContactoD'] != '') {
            update_post_meta($clinica_id, 'telfContactoD', $_POST['clinica-telfContactoD']);
        }
        //Email de Contacto
        if (isset($_POST['clinica-emailContactoD']) && $_POST['clinica-emailContactoD'] != '') {
            update_post_meta($clinica_id, 'emailContactoD', $_POST['clinica-emailContactoD']);
        }
        //Horario
        if (isset($_POST['clinica-horarioD']) && $_POST['clinica-horarioD'] != '') {
            update_post_meta($clinica_id, 'horarioD', $_POST['clinica-horarioD']);
        }
        //Director Médico
        if (isset($_POST['clinica-directorMedicoD']) && $_POST['clinica-directorMedicoD'] != '') {
            update_post_meta($clinica_id, 'directorMedicoD', $_POST['clinica-directorMedicoD']);
        }
        //Doctores
        if (isset($_POST['clinica-doctoresD']) && $_POST['clinica-doctoresD'] != '') {
            update_post_meta($clinica_id, 'doctoresD', $_POST['clinica-doctoresD']);
        }
        //website
        if (isset($_POST['clinica-webClinicD']) && $_POST['clinica-webClinicD'] != '') {
            update_post_meta($clinica_id, 'webClinicD', $_POST['clinica-webClinicD']);
        }

        //nivelPrefClinicaMD
        if (isset($_POST['clinica-nivelPrefClinicaMD']) && $_POST['clinica-nivelPrefClinicaMD'] != '') {
            update_post_meta($clinica_id, 'nivelPrefClinicaMD', $_POST['clinica-nivelPrefClinicaMD']);
        }
        //apMapsD
        if (isset($_POST['clinica-apMapsD']) && $_POST['clinica-apMapsD'] != '') {
            update_post_meta($clinica_id, 'apMapsD', $_POST['clinica-apMapsD']);
        }
    }
}
//Señalamos que en nuestro plug in habrá un post type template por si el custom pot type es iol.
function include_clinica_template_function($template_path)
{
    $clinica = _x('clinica', 'CustomPostType Name', 'clinica');

    //echo '<strong>'.$template_path.'</strong>';
    if (get_post_type() == $clinica) {
        if (is_single()) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ($theme_file = locate_template(array( 'single-clinica.php' ))) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(__FILE__) . '/single-clinica.php';
            }
        } elseif (is_archive()) {
            if ($theme_file = locate_template(array( 'archive-clinica.php' ))) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(__FILE__) . '/archive-clinica.php';
            }
        }
    }
    //echo '<strong>'.$template_path.'</strong>';
    return $template_path;
}
add_filter('template_include', 'include_clinica_template_function', 1);


//add_action('get_template_part_content','control_template_call');

/*
function control_template_call(){

    echo '<strong>Template llamada</strong>';
    apply_filters('template_include','template_path');

}*/


//De momento no Vamos a incluir las hojas de estilos y los scripts cuando sea single o archive => Lo suyo será que hagamos un filtrado análogo de clínicas en función del equipamiento...
function clinica_styles()
{
    //Css de JQuery para los controladores de la derecha.
    //wp_enqueue_style('iol-ui-css','http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
    // Register the style like this for a plugin:
    wp_register_style('clinica-style', plugins_url('/css/clinica.css', __FILE__));
    // For either a plugin or a theme, you can then enqueue the style:
    wp_enqueue_style('clinica-style');
}
add_action('wp_enqueue_scripts', 'clinica_styles');

//Ahora incluimos los scripts javascript
function clinica_scripts()
{
    $clinica = _x('clinica', 'CustomPostType Name', 'clinica');

    // Register the script like this for a plugin:
    // if(is_post_type_archive($clinica) or is_single() or get_post_type() == 'clinica')
    //{
    //echo 'INCLUSIÓN DEL JAVASCRIPT DE CLÍNICAS';
    //wp_register_script('jquery-ui', ("http://code.jquery.com/ui/1.10.3/jquery-ui.js"), false, '');
    //wp_register_script( 'clinica-js', plugins_url( '/js/clinica.js', __FILE__ ),array('jquery','jquery-ui') );
    //Registramos el script con la json variable con las provincias-ubicaciones

    $lCountry = get_locale();

    wp_register_script('ubicacion-js', plugins_url('/js/ubicationValues-'.$lCountry.'.js', __FILE__), array(), false, true);

    wp_register_script('clinica-js', plugins_url('/js/clinica.js', __FILE__), array('jquery','ubicacion-js','jquery-ui-core','jquery-ui-widget','jquery-ui-position','jquery-ui-menu','jquery-ui-autocomplete','jquery-ui-tooltip','jquery-ui-button','jquery-ui-slider','jquery-ui-accordion','jquery-ui-tabs'), false, true);

    wp_register_script('ajax-clinica-js', plugins_url('/js/ajax-clinica.js', __FILE__), array(), false, true);

    wp_register_script('gmaps', "https://maps.google.com/maps/api/js?key=AIzaSyDJ3FwVMCRgviEBGXzFmVP5JblEEyieqz8", array(), false, true);//&sensor=false
    wp_register_script('clinica-maps-js', plugins_url('/js/clinica-maps.js', __FILE__), array('gmaps'), false, true);//'gmaps'
    //'gmaps'
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script('clinica-js');
    wp_enqueue_script('ajax-clinica-js');

    // if(is_singular(_x('clinica','CustomPostType Name','clinica')) || is_page( 404 )  ){
    //Sólo vamos a utilizarlo en las páginas que estén relacionadas con las clínicas.


    if (is_page(404)|| is_page(9810) || is_singular(_x('clinica', 'CustomPostType Name', 'clinica')) || is_post_type_archive(_x('clinica', 'CustomPostType Name', 'clinica'))) {
        //Clínica archive, single clinicas,
        wp_enqueue_script('gmaps');
        wp_enqueue_script('clinica-maps-js');
        //Manadamos al gmaps js la versión del site
        wp_localize_script('clinica-maps-js', 'site', array('Country' => $lCountry)) ;
    }

    /*if(current_user_can('manage_options')){
            if(is_page(412) ){
                echo 'Es la página de id 412';
            }else{}

            if(is_singular(_x('clinica','CustomPostType Name','clinica'))){
                echo 'Es un single post de tipo clínica';
            }else{}

            if(is_post_type_archive(_x('clinica','CustomPostType Name','clinica'))){
                echo 'Es el archive  de clínica';
            }else{}

            }
    */
}
add_action('wp_enqueue_scripts', 'clinica_scripts');


/**
*	Use latest jQuery release
*/
//if( !is_admin() ){
    //wp_deregister_script('jquery');
    //wp_register_script('jquery', ("http://code.jquery.com/jquery-1.9.1.js"), false, '');
//	wp_register_script('jquery-ui', ("http://code.jquery.com/ui/1.10.3/jquery-ui.js"), false, '');
    //wp_enqueue_script('jquery-ui');
//}


//Aquí añadiremos las TAXONOMÍAS que queramos como COLUMNAS en el Back-End.
add_filter('manage_taxonomies_for_clinica_columns', 'clinica_oftalmologica_columns_Taxonomies');
function clinica_oftalmologica_columns_Taxonomies($taxonomies)
{
    $clinica_taxo_seguros = _x('seguros', 'taxo-name', 'clinica');
    $clinica_taxo_ubicacion = _x('ubicacion', 'taxo-name', 'clinica');

    $taxonomies[$clinica_taxo_ubicacion] = $clinica_taxo_ubicacion;
    $taxonomies[$clinica_taxo_seguros] = $clinica_taxo_seguros;

    return $taxonomies;
}

/* Función para realizar un filtrado en función de las taxonomías*/
add_action('restrict_manage_posts', 'my_filter_list_clinica');
function my_filter_list_clinica()
{
    $clinica = _x('clinica', 'CustomPostType Name', 'clinica');

    $clinica_taxo_ubicacion = _x('ubicacion', 'taxo-name', 'clinica');
    $clinica_taxo_seguros = _x('seguros', 'taxo-name', 'clinica');


    $screen = get_current_screen();
    global $wp_query;
    if ($screen->post_type == $clinica) {
        wp_dropdown_categories(array(
            'show_option_all' => 'Mostrar las clínicas de todas las regiones',
            'taxonomy' => $clinica_taxo_ubicacion,
            'name' => 'Región de la Clínica',
            'orderby' => 'name',
            'selected' => (isset($wp_query->query['region']) ? $wp_query->query['region'] : ''),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => false,
            'hide_empty' => true,
        ));
        wp_dropdown_categories(array(
            'show_option_all' => 'Mostrar Clínicas de todos los seguros',
            'taxonomy' => $clinica_taxo_seguros,
            'name' => 'Seguros de la clínica',
            'orderby' => 'name',
            'selected' => (isset($wp_query->query['seguros']) ? $wp_query->query['seguros'] : ''),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => false,
            'hide_empty' => true,
        ));
    }
}

add_filter('parse_query', 'perform_filtering_clinica');
function perform_filtering_clinica($query)
{
    $clinica_taxo_ubicacion = _x('ubicacion', 'taxo-name', 'clinica');
    $clinica_taxo_seguros = _x('seguros', 'taxo-name', 'clinica');

    $qv = &$query->query_vars;
    if (isset($qv[$clinica_taxo_ubicacion])) {
        if (($qv[$clinica_taxo_ubicacion]) && is_numeric($qv[$clinica_taxo_ubicacion])) {
            $term = get_term_by('id', $qv[$clinica_taxo_ubicacion], $clinica_taxo_ubicacion);
            $qv[$clinica_taxo_ubicacion] = $term->slug;
        }
    } else {
    }

    if (isset($qv[$clinica_taxo_seguros])) {
        if (($qv[$clinica_taxo_seguros]) && is_numeric($qv[$clinica_taxo_seguros])) {
            $term = get_term_by('id', $qv[$clinica_taxo_seguros], $clinica_taxo_seguros);
            $qv[$clinica_taxo_seguros] = $term->slug;
        }
    } else {
    }
}
//Por el momento no incluyo nada relacionado con Ajax.

//La lógica de las queries bien en archive bien en query a la hora de coger generar el wp_Query la vamos a poner aquí.

function filter_clinics($query)
{
    $clinica = _x('clinica', 'CustomPostType Name', 'clinica');

    global $clinicaAudit;
    global $clinicaNotEspecified;
    global $clinicaUndefinedMetaDataSelector;
    global $clinicaUndefinedTaxonomyDataSelector;

    //echo 'Pasando por pre_Get_posts';


    //A continuación vamos a añadir un tweak para que cuando la query sea de taxonomía también se salga la info y se puedan hacer filtrados.

    if ($query->is_main_query() && $query->is_tax()) {
        //echo 'pasando por el filtro';
        //Queremos que pase por filterIOLEngine para que:
        //1 Asigne en el panel la info lo que corresopnda.
        //2 podamos asignar manualmente la query_var correspondiente para que se seleccione el input correpondiente del filtro.

        //Cojemos los valores de taxonomía y de término.
       $taxonomia = $query->tax_query->queries[0]['taxonomy'];//


       $taxonomias = array(	_x('ubicacion', 'taxo-name', 'clinica'),
                               _x('seguros', 'taxo-name', 'clinica'),
                               _x('numero-cirugias-intraoculares', 'taxo-name', 'clinica'),
                               _x('tipo-operaciones-intraoculares', 'taxo-name', 'clinica'),
                               _x('tipo-de-implante', 'taxo-name', 'clinica'),
                               _x('equipamiento-clinica', 'taxo-name', 'clinica'),
                               _x('femto-faco', 'taxo-name', 'clinica'));


        $termsValue = $query->tax_query->queries[0]['terms'][0];
        //var_dump($terms);
        //$valorTaxonomia =

        if (in_array($taxonomia, $taxonomias)) {
            //echo 'Taxonomía de lente intraocular detectadasss';
            //var_dump($_GET);
            if (array_key_exists($taxonomia, $_GET)) {
                //echo 'Dice que  existe....';
             //$_GET[$taxonomia] = $termsValue;
            } else {
                $_GET[$taxonomia] = $termsValue;
                include('filterClinicaEngine.php');
            }
            //echo get_query_var('toricidad');
            //Aunque no haga falta para la selección de las lentes sí que es necesaria pra el panel de info

            //Vamos a ordenar siempre por orden de preferencia ascendente.
            $query->set('orderby', 'meta_value_num');//nivelPrefLenteMD
            $query->set('meta_key', 'nivelPrefClinicaMD');
            $query->set('order', 'DESC');
            //Metemos a continuación que sólo se seleccionen clinicas Parent como resultado de las búsquedas por taxonomías.
            $query->set('post_parent', 0);
        }
    }




    //----------------------- //

    if ($query->is_archive('clinica') && $query->is_main_query() && $query->query_vars['post_type'] == 'clinica' && (!is_admin())) {


    //echo 'Pasando por pre_get_post con post_type = clinica';

        $viewType = $_GET['viewType'] ? $_GET['viewType'] : 4;
        if ($viewType!= 'Grid') {
            $viewTypeNumber = $viewType;
        } else {
            $viewTypeNumber = 12;
        }
        $query->set('posts_per_page', $viewTypeNumber);
        //Vamos a ordenar siempre por orden de preferencia ascendente.
        //$query->set('orderby','nivel-pref-lente');
        $query->set('orderby', 'meta_value_num');
        $query->set('meta_key', 'nivelPrefClinicaMD');
        $query->set('order', 'DESC');
        $query->set('post_parent', 0);

        //echo 'SE ha ejecutado el filterClinicaEngine en filterPosts';

        //echo 'pasando por pre_get_posts de clinica.php';
        //var_dump($args);
        include('filterClinicaEngine.php');
        //echo 'Y ahora <br />';
        //var_dump($args);

        //var_dump($args);
        //add_query_arg($args);
        $query->set('tax_query', $tax_query_clinica);

        //var_dump($query);

        //echo 'pasó por el pre_get_posts de Clínica'
        return $query;
    }
    return $query;
}

add_action('pre_get_posts', 'filter_clinics');

//Todavía no sé la utilidad del get_query_vars.
add_filter('query_vars', 'parameter_clinica_queryvars');

function parameter_clinica_queryvars($qvars)
{
    $qvars[] = 'ubicacion-parent';
    $qvars[] = 'ubicacion-child';
    $qvars[] = 'ubicacion-child-se';

    return $qvars;
}

//Include AJAX Handlers
include(plugin_dir_path(__FILE__) . 'ajax/ajax-ClinicaHandler.php');
include(plugin_dir_path(__FILE__) . 'ajax/ajax-Clinic-Maps-Handler.php');
include(plugin_dir_path(__FILE__) . 'ajax/ajax-getClinica.php');



//cargamos las funciones de ajax para clínicas.
add_action('wp_ajax_clinica_filter_result', 'clinica_show_posted_values');
add_action('wp_ajax_nopriv_clinica_filter_result', 'clinica_show_posted_values'); // need this to serve non logged in

//hookeamos las siguientes funciones para obtener las clínicas cargadas.
add_action('wp_ajax_getClinicsCoords', 'getClinicsCoords');
add_action('wp_ajax_nopriv_getClinicsCoords', 'getClinicsCoords'); // need this to serve non logged in

//Hookeamos las siguientes funciones para obtener las clínicas cargadas dentro de la distancia.
add_action('wp_ajax_getClinicsCoordsWithinDistance', 'getClinicsCoordsWithinDistance');
add_action('wp_ajax_nopriv_getClinicsCoordsWithinDistance', 'getClinicsCoordsWithinDistance');

//Hokeamos las de las condiciones.
add_action('wp_ajax_getClinicsWithConds', 'getClinicsWithConds');
add_action('wp_ajax_nopriv_getClinicsWithConds', 'getClinicsWithConds');




//Función ajax para obtener las clinicas por nombre.
add_action('wp_ajax_getClinica', 'getClinica');
add_action('wp_ajax_nopriv_getClinica', 'getClinica'); // need this to serve non logged in users

//Función ajax para obtener las clínicas asociadas a una lente según la comunidad autónoma y la provincia.
add_action('wp_ajax_getLensClinics', 'getLensClinics');
add_action('wp_ajax_nopriv_getLensClinics', 'getLensClinics'); // need this to serve non logged in users



//Definimos variables Globales.
function my_clinica_audit_variables()
{
    global $clinicaAudit;   // = array();
    global $clinicaNotEspecified;

    global $clinicaUndefinedTaxonomyDataSelector;

    global $clinicaPluginDirectory;

    $clinicaPluginDirectory = plugin_dir_path(__FILE__);
}
add_action('init', 'my_clinica_audit_variables');



/*Filtro para el autoselect con el nombre de la clinica */

add_filter('posts_where', 'clinicaTextName', 10, 2);
function clinicaTextName($where, $wp_query)
{
    global $wpdb;
    if ($clinicaTextName = $wp_query->get('clinicaTextName')) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql(like_escape($clinicaTextName)) . '%\'';
    }
    return $where;
}


/*-- Vamos a añadir lo Necesario para Localización */
function clinica_setup()
{

    /*
     /*-- Vamos a centralizar la ubicación de los mo files --*/
    //load_plugin_textdomain('clinica', false, dirname(plugin_basename(__FILE__)). '/languages/');//
    //load_plugin_textdomain('clinica_display', false, dirname(plugin_basename(__FILE__)). '/languages/');//
    load_plugin_textdomain('clinica', false, 'nc-sync/languages');
    load_plugin_textdomain('clinica_cpt_display', false, 'nc-sync/languages');
    load_plugin_textdomain('clinica-scaffold', false, 'nc-sync/languages');
    /* load_plugin_textdomain('clinica', false,    ABSPATH .'wp-content/plugins/nc-sync/languages/');//
         load_plugin_textdomain('clinica_cpt_display', false, ABSPATH .'wp-content/plugins/nc-sync/languages/');//
     */
} // end custom_theme_setup
add_action('plugins_loaded', 'clinica_setup');



//Vamos a añadir las funciones para extraer las clínicas.

//Función ajax para obtener las IOLs por nombre.
add_action('wp_ajax_getAllClinics', 'getAllClinics');
add_action('wp_ajax_nopriv_getAllClinics', 'getAllClinics'); // need this to serve non logged in users


include(plugin_dir_path(__FILE__) . 'ajax/ajax-getAllClinics.php');

 ?>
