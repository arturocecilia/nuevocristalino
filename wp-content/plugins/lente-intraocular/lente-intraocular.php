<?php
/*
Plugin Name: lente-intraocular
Plugin URI: http://lente-intraocular.com/
Description: Declares a plugin that will create a custom post type displaying iols.
Version: 1.0
Author: Arturo Cecilia
Author URI: http://www.andomed.com/
License: GPLv2
*/







//load_plugin_textdomain('iol', false, dirname(plugin_basename(__FILE__)). '/languages/');
//$iol = _x('lente-intraocular','admin_display','iol');


/*Registramos el Custom Post Type => En nuestro caso iol*/
/*Mal => Vamos a cambiar el nombre por lente-intraocular => Pensando en SEO desde el inicio.*/
$iol=_x('lente-intraocular', 'CustomPostType Name', 'iol');

function create_iol()
{
    $iol=_x('lente-intraocular', 'CustomPostType Name', 'iol');

    $slug_iol =_x("lente-intraocular", 'slug', 'iol');
    $slug_archive_iol = _x('lentes-intraoculares', 'slug', 'iol');

    register_post_type(
        $iol,
        array(
            'labels' => array(
                'name' => _x('lente-intraocular', 'admin_display', 'iol'),
                'singular_name' => _x('lente-intraocular', 'admin_display', 'iol'),
                'add_new' => _x('Añadir Nueva', 'admin_display', 'iol'),
                'add_new_item' => _x('Añadir Nueva Lente intraocular', 'admin_display', 'iol'),
                'edit' => _x('Editar', 'admin_display', 'iol'),
                'edit_item' => _x('Editar lente intraocular', 'admin_display', 'iol'),
                'new_item' => _x('Nueva lente intraocular', 'admin_display', 'iol'),
                'view' => _x('Ver', 'admin_display', 'iol'),
                'view_item' => _x('Ver lente intraocular', 'admin_display', 'iol'),
                'search_items' => _x('Buscar lente intraocular', 'admin_display', 'iol'),
                'not_found' => _x('No se ha encontrado ninguna lente intraocular', 'admin_display', 'iol'),
                'not_found_in_trash' => _x('No hay lentes intraoculares en la papelera', 'admin_display', 'iol'),
                'parent' => _x('lente intraocular padre', 'admin_display', 'iol')
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
            'yarpp_support' => true, //para YARPP
            'taxonomies' => array('post_tag'), //para YARPP
            'rewrite' => array("slug" => $slug_iol), // /%tipo%/%fabricante%/%toricidad%/%adicion%/%filtros% Permalinks format
            'menu_position' => 5,
            'supports' => array( 'title','editor','thumbnail','excerpt' ),
            'taxonomies' => array( '' ),
            'menu_icon' => plugins_url('images/image.png', __FILE__),
            'has_archive' => $slug_archive_iol,
            'show_in_nav_menus'=>true,
            'show_in_menu'=> true,
            'show_ui'=> true
        )
    );

    // echo _x('lente-intraocular','admin_display','iol');
    //echo _x('lente-intraocular','CustomPostType Name','iol');
    if (get_locale()== 'es_CL' || get_locale() == 'de_AT') {
        //flush_rewrite_rules();
    }
}
add_action('init', 'create_iol');
/*Para añadir los CUSTOM FIELDS:
Necesitamos registrar una metaBox y añadirla a nuestro custom post type iol*/
function iol_admin()
{
    $iol=_x('lente-intraocular', 'CustomPostType Name', 'iol');

    add_meta_box(
        'iol_meta_box',/*id attribute*/
        'iol Details',/*Heading visible de la metabox*/
        'display_iol_meta_box',/*Callback function q renderiza el metabox*/
         $iol,
        'normal',
        'high'
    );
}
add_action('admin_init', 'iol_admin');

/* AÑADIMOS LOS CUSTOM FIELDS
   Función que renderiza el formulario -> Aquí es donde vamos a añadir los Custom Fields¡¡.
   Recordamos que se añaden los custom fields a partir de inputs en un formulario.
*/

function display_iol_meta_box($iol)
{



    // Serán las informaciones Técnicas que no estén incluidas en Taxonomías.

    $distribuidorD = esc_html(get_post_meta($iol->ID, 'distribuidorD', true));

    //Los campos simplificados para pacientes.
    $simpleLensName = esc_html(get_post_meta($iol->ID, 'simpleLensName', true));
    $simpleLensDesc = esc_html(get_post_meta($iol->ID, 'simpleLensDesc', true));


    // Aquí podremos decir algo para complementar las magnitudes que no queden perfectamente descritas por las taxonomías.

    $diamOpticD =  get_post_meta($iol->ID, 'diamOpticD', false) ;
    $diamTotD =  get_post_meta($iol->ID, 'diamTotD', false) ;

    //Añadimos forma de la óptica.
    $formOpticD = esc_html(get_post_meta($iol->ID, 'formOpticD', true));


    $matHapticD = esc_html(get_post_meta($iol->ID, 'matHapticD', true));
    $angulaHapticD = esc_html(get_post_meta($iol->ID, 'angulaHapticD', true));

    $asfericiD = esc_html(get_post_meta($iol->ID, 'asfericiD', true));
    $tamaInciD = esc_html(get_post_meta($iol->ID, 'tamaInciD', true));

    $cteAD = esc_html(get_post_meta($iol->ID, 'cteAD', true));
    $acdD = esc_html(get_post_meta($iol->ID, 'acdD', true));
    $surgeonFactorD = esc_html(get_post_meta($iol->ID, 'surgeonFactorD', true));

    $inyectorD = esc_html(get_post_meta($iol->ID, 'inyectorD', true));

    $esfDesdeD = esc_html(get_post_meta($iol->ID, 'esfDesdeD', true));
    $esfHastaD = esc_html(get_post_meta($iol->ID, 'esfHastaD', true));
    $stepEsf = esc_html(get_post_meta($iol->ID, 'stepEsf', true));

    //Las anteriores dioptrías esféricas eran de 1 en 1 ahora creamos las esféricas de 0.5 en 0.5.
    $esf05DesdeD = esc_html(get_post_meta($iol->ID, 'esf05DesdeD', true));
    $esf05HastaD = esc_html(get_post_meta($iol->ID, 'esf05HastaD', true));

    $cilDesdeD = esc_html(get_post_meta($iol->ID, 'cilDesdeD', true));
    $cilHastaD = esc_html(get_post_meta($iol->ID, 'cilHastaD', true));
    $stepCil = esc_html(get_post_meta($iol->ID, 'stepCil', true));


    //Añadimos las Fechas del lanzamiento y retirada del mercado.
    $dateIni = esc_html(get_post_meta($iol->ID, 'dateIniD', true));
    $dateFin = esc_html(get_post_meta($iol->ID, 'dateFinD', true));

    //Añadimos la Fuente de los datos.
    $webSourceD = esc_html(get_post_meta($iol->ID, 'webSourceD', true));
    $docSourceD = esc_html(get_post_meta($iol->ID, 'docSourceD', true));

    $nivelPrefLenteMD =  esc_html(get_post_meta($iol->ID, 'nivelPrefLenteMD', true));
    //Añadimos los metadatos correspondientes a las traducciones.
    /*
        $es_ES =  esc_html( get_post_meta( $iol->ID, 'es_ES', true ) );
        $es_MX =  esc_html( get_post_meta( $iol->ID, 'es_MX', true ) );
        $es_CO =  esc_html( get_post_meta( $iol->ID, 'es_CO', true ) );
        $en_UK =  esc_html( get_post_meta( $iol->ID, 'en_UK', true ) );
        $en_US =  esc_html( get_post_meta( $iol->ID, 'en_US', true ) );
        $de_DE =  esc_html( get_post_meta( $iol->ID, 'de_DE', true ) );
        $fr_FR =  esc_html( get_post_meta( $iol->ID, 'fr_FR', true ) );*/ ?>
    <table>
        <!-- Fabricante -->
    <!--    <tr>
            <td style="width: 100%"><?php echo _x('Fabricante (D)', 'admin_display', 'iol'); ?> </td>
            <td><input type="text" size="80" name="lente-intraocular-fabricanteD" value="<?php echo $fabricanteD; ?>" /></td>
        </tr>
    -->

    	<!-- Ponemos los campos que saldrán en la descripción para pacientes: SimpleLensName, SimpleLensDesc -->
    	<tr>
            <td style="width: 100%">SimpleLensName</td>
            <td><input type="text" size="80" name="lente-intraocular-simpleLensName" value="<?php echo $simpleLensName; ?>" /></td>
    	</tr>
		<!-- -->
    	<tr>
            <td style="width: 100%">SimpleLensDesc</td>
            <td><input type="text" size="80" name="lente-intraocular-simpleLensDesc" value="<?php echo $simpleLensDesc; ?>" /></td>
    	</tr>

    	<!-- Fin Campos simplificadores -->


        <!-- Distribuidor -->
        <tr>
            <td style="width: 100%"><?php echo _x('Distribuidor (D)', 'admin_display', 'iol'); ?> </td>
            <td><input type="text" size="80" name="lente-intraocular-distribuidorD" value="<?php echo $distribuidorD; ?>" /></td>
        </tr>

        <!-- Descripción de la lente -->
    <!--
         <tr>
            <td style="width: 100%"><?php echo _x('Descripción (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-descriLenteD" value="<?php echo $descriLenteD; ?>" /></td>
        </tr>
    -->
        <!-- Diámetro Óptica -->
            <!--
                 <tr>
                    <td style="width: 100%"><?php echo _x('Diámetro Óptica (D)', 'admin_display', 'iol'); ?></td>
                    <td><input type="text" size="80" name="lente-intraocular-diamOpticD" value="<?php echo $diamOpticD; ?>" /></td>
                 </tr>
              -->
        <!-- Diametro Total Lente -->
            <!--
                 <tr>
                     <td style="width: 100%"><?php echo _x('Diámetro Total (D)', 'admin_display', 'iol'); ?></td>
                     <td><input type="text" size="80" name="lente-intraocular-diamTotD" value="<?php echo $diamTotD; ?>" /></td>
                  </tr>
               -->
       <?php
            echo '<tr>';
    echo '<td style="width: 100%">'._x('Diámetro Óptica (D)', 'admin_display', 'iol').'</td>';
    echo "<td>";
    for ($i=0; $i<=count($diamOpticD);$i++) {
        echo "<input type=\"text\" name=\"lente-intraocular-diamOpticD[".$i."]\" value=\"".$diamOpticD[$i]."\" />";
    }
    echo "</td>";
    echo '</tr>';

    echo '<tr>';
    echo '<td style="width: 100%">'._x('Diámetro Total (D)', 'admin_display', 'iol').'</td>';
    echo "<td>";
    for ($i=0; $i<=count($diamTotD);$i++) {
        echo "<input type=\"text\" name=\"lente-intraocular-diamTotD[".$i."]\" value=\"".$diamTotD[$i]."\" />";
    }
    echo "</td>";
    echo '</tr>'; ?>


        <!-- Forma de la Optica -->
        <tr>
            <td style="width: 100%"><?php echo _x('Forma de la óptica (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-formOpticD" value="<?php echo $formOpticD; ?>" /></td>
        </tr>


        <!-- Material Háptico -->
        <tr>
            <td style="width: 100%"><?php echo _x('Material Hápticos (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-matHapticD" value="<?php echo $matHapticD; ?>" /></td>
        </tr>

        <!-- Angulación Hápticos -->
        <tr>
            <td style="width: 100%"><?php echo _x('Angulación Hápticos (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-angulaHapticD" value="<?php echo $angulaHapticD; ?>" /></td>
        </tr>
        <!-- Asfericidad -->
        <tr>
            <td style="width: 100%"><?php echo _x('Asfericidad (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-asfericiD" value="<?php echo $asfericiD; ?>" /></td>
        </tr>

        <!-- Tamaño de la Inicisión Lente -->
        <tr>
            <td style="width: 100%"><?php echo _x('Tamaño de la Inicisión (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-tamaInciD" value="<?php echo $tamaInciD; ?>" /></td>
        </tr>
        <!-- CTe A -->
        <tr>
            <td style="width: 100%"><?php echo _x('Constante A (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-cteAD" value="<?php echo $cteAD; ?>" /></td>
        </tr>
        <!-- ACD D -->
        <tr>
            <td style="width: 100%"><?php echo _x('ACD (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-acdD" value="<?php echo $acdD; ?>" /></td>
        </tr>
        <!-- Surgeon Factor -->
        <tr>
            <td style="width: 100%"><?php echo _x('Surgeon Factor (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-surgeonFactorD" value="<?php echo $surgeonFactorD; ?>" /></td>
        </tr>
        <!-- Inyector D -->
        <tr>
            <td style="width: 100%"><?php echo _x('Inyector (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-inyectorD" value="<?php echo $inyectorD; ?>" /></td>
        </tr>

        <!-- Esfera Desde -->
        <tr>
            <td style="width: 100%"><?php echo _x('Esfera Desde (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-esfDesdeD" value="<?php echo $esfDesdeD; ?>" /></td>
        </tr>
        <!-- Esfera Hasta -->
        <tr>
            <td style="width: 100%"><?php echo _x('Esfera Hasta (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-esfHastaD" value="<?php echo $esfHastaD; ?>" /></td>
        </tr>
        <!-- Step Esfera -->

        <tr>
            <td style="width: 100%"><?php echo _x('Intervalos Esfera', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-stepEsf" value="<?php echo $stepEsf; ?>" /></td>
        </tr>

        <!-- Esfera O5 Desde -->
        <tr>
            <td style="width: 100%"><?php echo _x('Esfera Intervalos 0,5 diopt Desde (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-esf05DesdeD" value="<?php echo $esf05DesdeD; ?>" /></td>
        </tr>
        <!-- Esfera 05 Hasta -->
        <tr>
            <td style="width: 100%"><?php echo _x('Esfera Intervalos 0,5 diopt Hasta (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-esf05HastaD" value="<?php echo $esf05HastaD; ?>" /></td>
        </tr>

        <!-- Cil Desde -->
        <tr>
            <td style="width: 100%"><?php echo _x('Cil Desde (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-cilDesdeD" value="<?php echo $cilDesdeD; ?>" /></td>
        </tr>
        <!-- Cil  Hasta -->
        <tr>
            <td style="width: 100%"><?php echo _x('Cil  Hasta (D)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-cilHastaD" value="<?php echo $cilHastaD; ?>" /></td>
        </tr>
        <!-- Step Cilindro -->
        <tr>
            <td style="width: 100%"><?php echo _x('Intervalos Cilindro', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-stepCil" value="<?php echo $stepCil; ?>" /></td>
        </tr>
        <!-- Fecha de Lanzamiento -->
        <tr>
            <td style="width: 100%"><?php echo _x('Fecha de lanzamiento de la lente al mercado', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-dateIniD" value="<?php echo $dateIniD; ?>" /></td>
        </tr>
        <!-- Fecha de Retirada de la lentes -->
        <tr>
            <td style="width: 100%"><?php echo _x('Fecha de retirarda de la lente del mercado', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-dateFinD" value="<?php echo $dateFinD; ?>" /></td>
        </tr>
        <!-- Fuentes de la información -->
        <tr>
            <td style="width: 100%"><?php echo _x('Website Fuente de la Información', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-webSourceD" value="<?php echo $webSourceD; ?>" /></td>
        </tr>

        <tr>
            <td style="width: 100%"><?php echo _x('Documento Fuente de la Información', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-docSourceD" value="<?php echo $docSourceD; ?>" /></td>
        </tr>

        <!-- NivelPreferenciaLente-->
        <tr>
            <td style="width: 100%"><?php echo _x('Nivel de Preferencia de la lente (Ascendente)', 'admin_display', 'iol'); ?></td>
            <td><input type="text" size="80" name="lente-intraocular-nivelPrefLenteMD" value="<?php echo $nivelPrefLenteMD; ?>" /></td>
        </tr>




    </table>
    <?php
}
//Añadimos las TAXONOMÍAS de lente intraocular.


function create_iol_taxonomies()
{
    $iol = _x('lente-intraocular', 'CustomPostType Name', 'iol');

    //La 0 será el tipo de lente .
    $iol_taxo_tipoLente = _x('tipo-lente-intraocular', 'taxo-name', 'iol');//'tipo-lente-intraocular';
    $iol_taxo_tipoLente_slug =_x('lente-intraocular/tipo-lente', 'slug', 'iol');

    register_taxonomy(
        $iol_taxo_tipoLente,
        $iol,
        array(
            'labels' => array(
                'name' => _x('Tipo de lente Intraocular', 'admin_display', 'iol'),
                'add_new_item' => _x('Añadir Nuevo Tipo de lente intraocular', 'admin_display', 'iol'),
                'new_item_name' => _x('Nuevo Tipo de lente intraocular', 'admin_display', 'iol')
            ),
               'capabilities'=>array(
                                                                    'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                    'edit_terms' => 'manage_options',
                                                                    'delete_terms' => 'manage_options',
                                                                    'assign_terms' =>'manage_options'),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
            ,'rewrite'=> array('slug'=> $iol_taxo_tipoLente_slug)

        )
    );


    //La 1 será el diseño de la óptica.
    $iol_taxo_diseOptic = _x('diseno-optica', 'taxo-name', 'iol');//'diseno-optica'
    $iol_taxo_diseOptic_slug =_x('lente-intraocular/diseño-optica', 'slug', 'iol');

    register_taxonomy(
        $iol_taxo_diseOptic,
        $iol,
        array(
            'labels' => array(
                'name' => _x('Diseño de Óptica', 'admin_display', 'iol'),
                'add_new_item' => _x('Añadir Nuevo Diseño de Óptica', 'admin_display', 'iol'),
                'new_item_name' => _x('Nuevo Diseño de Óptica', 'admin_display', 'iol')
            ),
            'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
            ,'rewrite'=> array('slug'=> $iol_taxo_diseOptic_slug)

        )
    );
    //La 2 será el fabricante.
    $iol_taxo_fabricante = _x('fabricante-lente', 'taxo-name', 'iol');//'fabricante-lente'
    $iol_taxo_fabricante_slug =_x('lente-intraocular/fabricante-lente', 'slug', 'iol');

    register_taxonomy(
        $iol_taxo_fabricante,
        $iol,
        array(
            'labels' => array(
                'name' => _x('Fabricante', 'admin_display', 'iol'),
                'add_new_item' => _x('Añadir Nuevo Fabricante', 'admin_display', 'iol'),
                'new_item_name' => _x('Nombre del Nuevo Fabricante', 'admin_display', 'iol')
            ),
             'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
            ,'rewrite' => array( 'slug' => $iol_taxo_fabricante_slug )///%tipo%
        )
    );
    //La 3 es la toricidad de la lente: si es o no, tórica.

    $iol_taxo_toricidad = _x('toricidad', 'taxo-name', 'iol');//'toricidad'
    $iol_taxo_fabricante_slug =_x('lente-intraocular/toricidad', 'slug', 'iol');
    register_taxonomy(
        $iol_taxo_toricidad,
        $iol,
        array(
            'labels' => array(
                'name' => _x('Toricidad', 'admin_display', 'iol'),
                'add_new_item' => _x('Añadir tipo de Toricidad', 'admin_display', 'iol'),
                'new_item_name' => _x('Nuevo Nombre de Tipo de Toricidad', 'admin_display', 'iol')
            ),
             'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
            ,'rewrite' => array( 'slug' => $iol_taxo_fabricante_slug )
        )
    );
    //La 4 es el tipo de adición que tiene la lente.

    $iol_taxo_adCerca = _x('adicion-cerca', 'taxo-name', 'iol');//'adicion-cerca'
    $iol_taxo_adCerca_slug = _x('lente-intraocular/adicion-cerca', 'slug', 'iol');

    register_taxonomy(
         $iol_taxo_adCerca,
         $iol,
        array(
              'labels' => array(
               'name' => _x('Adición', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir adición de cerca', 'admin_display', 'iol'),
               'new_item_name' => _x('Nueva adición de cerca', 'admin_display', 'iol')
               ),
                'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_adCerca_slug )
                 )
    );

    //La 5 es el tipo de filtros que tiene.
    $iol_taxo_filtros = _x('filtros', 'taxo-name', 'iol');
    $iol_taxo_filtros_slug = _x('lente-intraocular/filtros', 'slug', 'iol');
    register_taxonomy(
         $iol_taxo_filtros,
         $iol,
        array(
            'labels' => array(
                'name' => _x('Filtros', 'admin_display', 'iol'),
                'add_new_item' => _x('Añadir tipo de Filtro', 'admin_display', 'iol'),
                'new_item_name' => _x('Nuevo Nombre de Filtro de Toricidad', 'admin_display', 'iol')
            ),
             'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
            ,'rewrite' => array( 'slug' => $iol_taxo_filtros_slug ) //
        )
    );
    //La 6 es el material del que está compuesta//Silicona, Acrílico, PMMA
    $iol_taxo_material = _x('material', 'taxo-name', 'iol');//'material'
    $iol_taxo_material_slug = _x('lente-intraocular/material', 'slug', 'iol');
    register_taxonomy(
         $iol_taxo_material,
         $iol,
        array(
              'labels' => array(
               'name' => _x('Material', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir material de la lente', 'admin_display', 'iol'),
               'new_item_name' => _x('Nuevo nombre de material de lente', 'admin_display', 'iol')
               ),
                'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_material_slug )
                 )
    );
    //La 7 es el diseño de la lente// 1pieza, 3 piezas...
    $iol_taxo_diseño = _x('diseno', 'taxo-name', 'iol');//'diseno'
    $iol_taxo_diseño_slug = _x('lente-intraocular/diseño', 'slug', 'iol');
    register_taxonomy(
         $iol_taxo_diseño,
         $iol,
        array(
              'labels' => array(
               'name' => _x('Estructura', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir diseño de lente', 'admin_display', 'iol'),
               'new_item_name' => _x('Nuevo nombre de diseño de lente', 'admin_display', 'iol')
               ),
              'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_diseño_slug )
                 )
    );
    //La 8 es principio óptico.
    $iol_taxo_pOptico = _x('principio-optico', 'taxo-name', 'iol');//'principio-optico'
    $iol_taxo_pOptico_slug = _x('lente-intraocular/principio-optico', 'slug', 'iol');
    register_taxonomy(
         $iol_taxo_pOptico,
         $iol,
        array(
              'labels' => array(
               'name' => _x('Principio óptico', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir principio óptico de la lente', 'admin_display', 'iol'),
               'new_item_name' => _x('Nuevo nombre principio óptico de lente', 'admin_display', 'iol')
               ),
               'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_pOptico_slug )
                 )
    );
    //La 9 es asfericidad.
    $iol_taxo_asfericidad = _x('asfericidad', 'taxo-name', 'iol');//'asfericidad'
    $iol_taxo_asfericidad_slug = _x('lente-intraocular/asfericidad', 'slug', 'iol');
    register_taxonomy(
         $iol_taxo_asfericidad,
         $iol,
        array(
              'labels' => array(
               'name' => _x('Asfericidad', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir asfericidad de la lente', 'admin_display', 'iol'),
               'new_item_name' => _x('Nuevo nombre de asfericidad de lente', 'admin_display', 'iol')
               ),
              'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_asfericidad_slug )
                 )
    );


    //La 10 es el Borde Cuadrado
    $iol_taxo_bCuad = _x('bordes-cuadrados', 'taxo-name', 'iol');
    $iol_taxo_bCuad_slug = _x('lente-intraocular/bordes-cuadrados', 'slug', 'iol');
    register_taxonomy(
        $iol_taxo_bCuad,
        $iol,
        array(
              'labels' => array(
               'name' => _x('Bordes Cuadrados', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir Característica de Bordes Cuadrados', 'admin_display', 'iol'),
               'new_item_name' => _x('Nuevo nombre de característica de Bordes Cuadrados', 'admin_display', 'iol')
               ),
            'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_bCuad_slug )
                 )
    );

    //La 11 es el Inyector
    $iol_taxo_inyect = _x('inyector', 'taxo-name', 'iol');
    $iol_taxo_inyect_slug = _x('lente-intraocular/inyector', 'slug', 'iol');

    register_taxonomy(
        $iol_taxo_inyect,
        $iol,
        array(
              'labels' => array(
               'name' => _x('inyector', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir Característica sobre inyector', 'admin_display', 'iol'),
               'new_item_name' => _x('Nuevo nombre de característica de inyector', 'admin_display', 'iol')
               ),
             'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_inyect_slug )
                 )
    );

    //La 12 es si es Precargada
    $iol_taxo_precarga = _x('precargada', 'taxo-name', 'iol');
    $iol_taxo_precarga_slug = _x('lente-intraocular/precargada', 'slug', 'iol');
    register_taxonomy(
        $iol_taxo_precarga,
        $iol,
        array(
              'labels' => array(
               'name' => _x('precargada', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir Característica sobre Precargada', 'admin_display', 'iol'),
               'new_item_name' =>_x('Nuevo nombre de característica de Precargada', 'admin_display', 'iol')
               ),
               'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_precarga_slug )
                 )
    );
    //La 12 Bis si es Plegable.
    $iol_taxo_plegable = _x('plegable', 'taxo-name', 'iol');
    $iol_taxo_plegable_slug = _x('lente-intraocular/plegable', 'slug', 'iol');
    register_taxonomy(
        $iol_taxo_plegable,
        $iol,
        array(
              'labels' => array(
               'name' => _x('plegable', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir Característica sobre Plegable', 'admin_display', 'iol'),
               'new_item_name' =>_x('Nuevo nombre de característica de Plegable', 'admin_display', 'iol')
               ),
             'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_plegable_slug )
                 )
    );


    //La 13 es el diseño de los Hapticos.
    $iol_taxo_diseHaptic = _x('diseno-hapticos', 'taxo-name', 'iol');
    $iol_taxo_diseHaptic_slug = _x('lente-intraocular/diseño-hapticos', 'slug', 'iol');
    register_taxonomy(
        $iol_taxo_diseHaptic,
        $iol,
        array(
              'labels' => array(
               'name' => _x('Diseño de Hápticos', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir tipo de diseño de hápticos', 'admin_display', 'iol'),
               'new_item_name' => _x('Nuevo nombre de característica de Diseño de Hápticos', 'admin_display', 'iol')
               ),
              'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_diseHaptic_slug )
                 )
    );

    /*-- Añadimos Taxonomía con la información sobre el status comercial de la lentes --*/

    $iol_taxo_statusCom = _x('estatus-comercial', 'taxo-name', 'iol');
    $iol_taxo_statusCom_slug = _x('lente-intraocular/estatus-comercial', 'slug', 'iol');

    register_taxonomy(
        $iol_taxo_statusCom,
        $iol,
        array(
              'labels' => array(
               'name' => _x('Estatus Comercial de la lente', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir nuevo estatus comercial de la lente', 'admin_display', 'iol'),
               'new_item_name' => _x('Nuevo nombre de estatus comercial para la lente', 'admin_display', 'iol')
               ),
              'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_statusCom_slug )
                 )
    );



    /*-- Añadimos Taxonomía con el Ordinal de preferencia de la clínica --*/

    $iol_taxo_nPLente = 'nivel-pref-lente';
    $iol_taxo_nPLente_slug = _x('lente-intraocular/nivel-pref-lente', 'slug', 'iol');

    register_taxonomy(
        $iol_taxo_nPLente,
        $iol,
        array(
              'labels' => array(
               'name' => _x('Nivel de Preferencia de la lente', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir tipo de nivel de preferencia para la lente', 'admin_display', 'iol'),
               'new_item_name' => _x('Nuevo nombre de nivel de preferencia para la lente', 'admin_display', 'iol')
               ),
               'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_nPLente_slug )
                 )
    );


    /*-- Añadimos Taxonomía la información de si está o no linkada a una clínica --*/

    $iol_taxo_impClinicas = _x('implantada-en-clinicas', 'taxo-name', 'iol');
    $iol_taxo_impClinicas_slug = _x('lente-intraocular/implantada-en-clinicas', 'slug', 'iol');

    register_taxonomy(
        $iol_taxo_impClinicas,
        $iol,
        array(
              'labels' => array(
               'name' => _x('Implantada en clinicas ', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir valor de implantada en clinicas', 'admin_display', 'iol'),
               'new_item_name' => _x('Nuevo nombre de valor de implantada en clinicas', 'admin_display', 'iol')
               ),
             'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_impClinicas_slug )
                 )
    );


    /*-- Añadimos las inclusiones-exclusiones de las preguntas del Test en una sola taxonomía -- */

    $iol_taxo_nTest_slug = _x('lente-intraocular/iol-test', 'slug', 'iol');

    register_taxonomy(
        'iolTest',
        $iol,
        array(
               'labels' => array(
               'name' => _x('Exclusiones de las restricciones Test de IOL', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir nueva inclusión-exclusión de lentes en Test', 'admin_display', 'iol'),
               'new_item_name' => _x('Nuevo nombre de inclusión-exclusión de lentes en Test', 'admin_display', 'iol')
               ),
               'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_nTest_slug )
                 )
    );

    /*-- Añadimos las inclusiones-exclusiones de las preguntas del Test en una sola taxonomía -- */

    $iol_taxo_nTradIol_slug = 'lente-intraocular/translation-iol';

    register_taxonomy(
        'translation-iol',
        $iol,
        array(
               'labels' => array(
               'name' => _x('Estado de la traducción de IOL', 'admin_display', 'iol'),
               'add_new_item' => _x('Añadir nuevo estado de la traducción de IOL', 'admin_display', 'iol'),
               'new_item_name' => _x('Nuevo nombre de estado de traducción de IOL', 'admin_display', 'iol')
               ),
              'capabilities'=>array(
                                                                 'manage_terms' => 'manage_options',//or some other capability your clients don't have
                                                                 'edit_terms' => 'manage_options',
                                                                 'delete_terms' => 'manage_options',
                                                                'assign_terms' =>'manage_options'),
                'show_ui' =>true,
                 'show_tagcloud' => false,
                 'hierarchical' => true
                 ,'rewrite' => array( 'slug' => $iol_taxo_nTradIol_slug )
                 )
    );
}
add_action('init', 'create_iol_taxonomies', 0);


//Función para guardar el post->la que tratará el formulario-Metabox que ha sido renderizado
add_action('save_post', 'add_iol_fields', 10, 2);
function add_iol_fields($iol_id, $iol)
{
    $iol_name = _x('lente-intraocular', 'CustomPostType Name', 'iol');


    // Check post type for movie reviews
    if ($iol->post_type == $iol_name) {
        // Store data in post meta table if present in post data
        //Fabricante
        /*
              if ( isset( $_POST['lente-intraocular-fabricanteD'] ) && $_POST['lente-intraocular-fabricanteD'] != '' ) {
                update_post_meta( $iol_id, 'fabricanteD', $_POST['lente-intraocular-fabricanteD'] );
            }
        */
        //Distribuidor
        if (isset($_POST['lente-intraocular-distribuidorD']) && $_POST['lente-intraocular-distribuidorD'] != '') {
            update_post_meta($iol_id, 'distribuidorD', $_POST['lente-intraocular-distribuidorD']);
        }

        /*	Campos personalizados para pacientes    */
        if (isset($_POST['lente-intraocular-simpleLensName']) && $_POST['lente-intraocular-simpleLensName'] != '') {
            update_post_meta($iol_id, 'simpleLensName', $_POST['lente-intraocular-simpleLensName']);
        }

        if (isset($_POST['lente-intraocular-simpleLensDesc']) && $_POST['lente-intraocular-simpleLensDesc'] != '') {
            update_post_meta($iol_id, 'simpleLensDesc', $_POST['lente-intraocular-simpleLensDesc']);
        }


        /*
             //Descripción de la Lente
               if ( isset( $_POST['lente-intraocular-descriLenteD'] ) && $_POST['lente-intraocular-descriLenteD'] != '' ) {
                 update_post_meta( $iol_id, 'descriLenteD', $_POST['lente-intraocular-descriLenteD'] );
             }
        */
        //Diámetro Óptica
        /*  if ( isset( $_POST['lente-intraocular-diamOpticD'] ) && $_POST['lente-intraocular-diamOpticD'] != '' ) {
            update_post_meta( $iol_id, 'diamOpticD', $_POST['lente-intraocular-diamOpticD'] );
        }*/
        //Diámetro Total Lente
        /*  if ( isset( $_POST['lente-intraocular-diamTotD'] ) && $_POST['lente-intraocular-diamTotD'] != '' ) {
            update_post_meta( $iol_id, 'diamTotD', $_POST['lente-intraocular-diamTotD'] );
        }*/

        //El proceder ahora será borrar y cargar todos los metas cada vez que haya más de un valor.

        delete_post_meta($iol_id, 'diamOpticD');
        foreach ($_POST['lente-intraocular-diamOpticD'] as $diamOpticD) {
            if ($diamOpticD !='') {
                add_post_meta($iol_id, 'diamOpticD', $diamOpticD);
            }
        }

        delete_post_meta($iol_id, 'diamTotD');
        foreach ($_POST['lente-intraocular-diamTotD'] as $diamTotD) {
            if ($diamTotD !='') {
                add_post_meta($iol_id, 'diamTotD', $diamTotD);
            }
        }

        //Forma de la óptica
        if (isset($_POST['lente-intraocular-formOpticD']) && $_POST['lente-intraocular-formOpticD'] != '') {
            update_post_meta($iol_id, 'formOpticD', $_POST['lente-intraocular-formOpticD']);
        }
        //Material Hápticos
        if (isset($_POST['lente-intraocular-matHapticD']) && $_POST['lente-intraocular-matHapticD'] != '') {
            update_post_meta($iol_id, 'matHapticD', $_POST['lente-intraocular-matHapticD']);
        }
        //Angulación Hápticos
        if (isset($_POST['lente-intraocular-angulaHapticD']) && $_POST['lente-intraocular-angulaHapticD'] != '') {
            update_post_meta($iol_id, 'angulaHapticD', $_POST['lente-intraocular-angulaHapticD']);
        }

        //Asfericidad
        if (isset($_POST['lente-intraocular-asfericiD']) && $_POST['lente-intraocular-asfericiD'] != '') {
            update_post_meta($iol_id, 'asfericiD', $_POST['lente-intraocular-asfericiD']);
        }
        //Tamaño de Inicisión de la lente
        if (isset($_POST['lente-intraocular-tamaInciD']) && $_POST['lente-intraocular-tamaInciD'] != '') {
            update_post_meta($iol_id, 'tamaInciD', $_POST['lente-intraocular-tamaInciD']);
        }
        //Constante A
        if (isset($_POST['lente-intraocular-cteAD']) && $_POST['lente-intraocular-cteAD'] != '') {
            update_post_meta($iol_id, 'cteAD', $_POST['lente-intraocular-cteAD']);
        }
        //ACD D
        if (isset($_POST['lente-intraocular-acdD']) && $_POST['lente-intraocular-acdD'] != '') {
            update_post_meta($iol_id, 'acdD', $_POST['lente-intraocular-acdD']);
        }
        //Surgeon Factor
        if (isset($_POST['lente-intraocular-surgeonFactorD']) && $_POST['lente-intraocular-surgeonFactorD'] != '') {
            update_post_meta($iol_id, 'surgeonFactorD', $_POST['lente-intraocular-surgeonFactorD']);
        }
        //Inyector
        if (isset($_POST['lente-intraocular-inyectorD']) && $_POST['lente-intraocular-inyectorD'] != '') {
            update_post_meta($iol_id, 'inyectorD', $_POST['lente-intraocular-inyectorD']);
        }

        //Esfera Desde
        if (isset($_POST['lente-intraocular-esfDesdeD']) && $_POST['lente-intraocular-esfDesdeD'] != '') {
            update_post_meta($iol_id, 'esfDesdeD', $_POST['lente-intraocular-esfDesdeD']);
        }
        //Esfera Hasta
        if (isset($_POST['lente-intraocular-esfHastaD']) && $_POST['lente-intraocular-esfHastaD'] != '') {
            update_post_meta($iol_id, 'esfHastaD', $_POST['lente-intraocular-esfHastaD']);
        }
        //Esfera05 Desde
        if (isset($_POST['lente-intraocular-esf05DesdeD']) && $_POST['lente-intraocular-esf05DesdeD'] != '') {
            update_post_meta($iol_id, 'esf05DesdeD', $_POST['lente-intraocular-esf05DesdeD']);
        }
        //Esfera05 Hasta
        if (isset($_POST['lente-intraocular-esf05HastaD']) && $_POST['lente-intraocular-esf05HastaD'] != '') {
            update_post_meta($iol_id, 'esf05HastaD', $_POST['lente-intraocular-esf05HastaD']);
        }
        //Step Esfera
        if (isset($_POST['lente-intraocular-stepEsf']) && $_POST['lente-intraocular-stepEsf'] != '') {
            update_post_meta($iol_id, 'stepEsf', $_POST['lente-intraocular-stepEsf']);
        }

        //Cil 1D Desde
        if (isset($_POST['lente-intraocular-cilDesdeD']) && $_POST['lente-intraocular-cilDesdeD'] != '') {
            update_post_meta($iol_id, 'cilDesdeD', $_POST['lente-intraocular-cilDesdeD']);
        }
        //Cil 1D Hasta
        if (isset($_POST['lente-intraocular-cilHastaD']) && $_POST['lente-intraocular-cilHastaD'] != '') {
            update_post_meta($iol_id, 'cilHastaD', $_POST['lente-intraocular-cilHastaD']);
        }
        //Step Cilindro
        if (isset($_POST['lente-intraocular-stepCil']) && $_POST['lente-intraocular-stepCil'] != '') {
            update_post_meta($iol_id, 'stepCil', $_POST['lente-intraocular-stepCil']);
        }

        //Fecha de lanzamiento al mercado de la lente
        if (isset($_POST['lente-intraocular-dateIniD']) && $_POST['lente-intraocular-dateIniD'] != '') {
            update_post_meta($iol_id, 'dateIniD', $_POST['lente-intraocular-dateIniD']);
        }
        //Fecha de retirada de la lente del mercado
        if (isset($_POST['lente-intraocular-dateFinD']) && $_POST['lente-intraocular-dateFinD'] != '') {
            update_post_meta($iol_id, 'dateFinD', $_POST['lente-intraocular-dateFinD']);
        }

        //Fuentes de la información
        if (isset($_POST['lente-intraocular-webSourceD']) && $_POST['lente-intraocular-webSourceD'] != '') {
            update_post_meta($iol_id, 'webSourceD', $_POST['lente-intraocular-webSourceD']);
        }

        if (isset($_POST['lente-intraocular-docSourceD']) && $_POST['lente-intraocular-docSourceD'] != '') {
            update_post_meta($iol_id, 'docSourceD', $_POST['lente-intraocular-docSourceD']);
        }

        //nivelPrefLenteMD
        if (isset($_POST['lente-intraocular-nivelPrefLenteMD']) && $_POST['lente-intraocular-nivelPrefLenteMD'] != '') {
            update_post_meta($iol_id, 'nivelPrefLenteMD', $_POST['lente-intraocular-nivelPrefLenteMD']);
        }
        //Ahora con la difusión de las traducciones.
        /*
        //es_ES
          if ( isset( $_POST['lente-intraocular-es_ES'] ) && $_POST['lente-intraocular-es_ES'] != '' ) {
            update_post_meta( $iol_id, 'es_ES', $_POST['lente-intraocular-es_ES'] );
        }
        //es_MX
          if ( isset( $_POST['lente-intraocular-es_MX'] ) && $_POST['lente-intraocular-es_MX'] != '' ) {
            update_post_meta( $iol_id, 'es_MX', $_POST['lente-intraocular-es_MX'] );
        }
        //es_CO
          if ( isset( $_POST['lente-intraocular-es_CO'] ) && $_POST['lente-intraocular-es_CO'] != '' ) {
            update_post_meta( $iol_id, 'es_CO', $_POST['lente-intraocular-es_CO'] );
        }
        //en_GB
          if ( isset( $_POST['lente-intraocular-en_UK'] ) && $_POST['lente-intraocular-en_UK'] != '' ) {
            update_post_meta( $iol_id, 'en_UK', $_POST['lente-intraocular-en_UK'] );
        }
        //en_US
          if ( isset( $_POST['lente-intraocular-en_US'] ) && $_POST['lente-intraocular-en_US'] != '' ) {
            update_post_meta( $iol_id, 'en_US', $_POST['lente-intraocular-en_US'] );
        }
        //de_DE
          if ( isset( $_POST['lente-intraocular-de_DE'] ) && $_POST['lente-intraocular-de_DE'] != '' ) {
            update_post_meta( $iol_id, 'de_DE', $_POST['lente-intraocular-de_DE'] );
        }
        //es_ES
          if ( isset( $_POST['lente-intraocular-fr_FR'] ) && $_POST['lente-intraocular-fr_FR'] != '' ) {
            update_post_meta( $iol_id, 'fr_FR', $_POST['lente-intraocular-fr_FR'] );
        }        */
    }
}
//Señalamos que en nuestro plug in habrá un post type template por si el custom pot type es iol.
function include_iol_template_function($template_path)
{
    $iol = _x('lente-intraocular', 'CustomPostType Name', 'iol');

    //echo get_post_type();
    if (get_post_type() == $iol) {
        if (is_single()) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ($theme_file = locate_template(array( 'single-lente-intraocular.php' ))) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(__FILE__) . '/single-lente-intraocular.php';
            }
        } elseif (is_archive()) {
            if ($theme_file = locate_template(array( 'archive-lente-intraocular.php' ))) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(__FILE__) . '/archive-lente-intraocular.php';
            }
        }
    }
    return $template_path;
}
add_filter('template_include', 'include_iol_template_function', 1);


//add_action('get_template_part_content','control_template_call');

function control_template_call()
{

   // echo '<strong>Template llamada</strong>';
    //apply_filters('template_include','template_path');
}


//Vamos a incluir las hojas de estilos y los scripts cuando sea single o archive.
function iol_styles()
{
    //Css de JQuery para los controladores de la derecha.
    //wp_enqueue_style('iol-ui-css','http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
    //wp_register_style( 'iol-ui-css','http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
    wp_register_style('iol-ui-css', 'https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.min.css');
    // Register the style like this for a plugin:
    wp_register_style('lente-intraocular-style', plugins_url('/css/iol.css', __FILE__));
    wp_register_style('test', plugins_url('/css/test.css', __FILE__));
    //Ahora el específico para iol
    wp_register_style('buscador-iol', plugins_url('/css/buscador-iol.css', __FILE__));
    // For either a plugin or a theme, you can then enqueue the style:
    wp_enqueue_style('iol-ui-css');
    wp_enqueue_style('lente-intraocular-style');
    wp_enqueue_style('test');
    wp_enqueue_style('buscador-iol');
}
add_action('wp_footer', 'iol_styles', 0); //wp_enqueue_scripts

//Ahora incluimos los scripts javascript en cada una de las páginas que lo requieran.
function iol_scripts()
{
    $iol = _x('lente-intraocular', 'admin_display', 'iol');

    // Register the script like this for a plugin:
    // if(is_archive() or is_single() or is_page('test-de-lentes-intraoculares'))
    // {
    // echo 'SE ESTÁN BAJANDO TODOS LOS SCRIPTS¡¡';
    //wp_enqueue_script('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js', array('jquery'), '1.8.6');
    wp_register_script('google-chart', 'https://www.google.com/jsapi', array(), false, true);
    wp_register_script('libValidator', plugins_url('/js/jquery.validate.min.js', __FILE__), false, true);
    wp_register_script('surgeryPostOpFormValidation', plugins_url('/js/surgeryPostOpFormValidation.js', __FILE__), array('libValidator'), false, true);
    wp_register_script('iol-simulator', plugins_url('/js/symlens-min.js', __FILE__), array('lente-intraocular-js'), false, true);
    //wp_register_script('jquery-ui', ("http://code.jquery.com/ui/1.10.3/jquery-ui.js"), false, '');
      wp_register_script('lente-intraocular-js', plugins_url('/js/iol.js', __FILE__), array('jquery','theme-load-js','jquery-ui-core','jquery-ui-widget','jquery-ui-position','jquery-ui-menu','jquery-ui-autocomplete','jquery-ui-tooltip','jquery-ui-button','jquery-ui-slider','jquery-ui-accordion','jquery-ui-tabs','jquery-ui-draggable','jquery-ui-resizable','surgeryPostOpFormValidation','jquery-effects-core','jquery-ui-progressbar','jquery-cookie'), '1', true); //,'SurgeryPostOpValidation'
      wp_register_script('iol-simulator', plugins_url('/js/symlens-min.js', __FILE__), array('jquery','theme-load-js','jquery-ui-core','jquery-ui-widget','jquery-ui-position','jquery-ui-menu','jquery-ui-autocomplete','jquery-ui-tooltip','jquery-ui-button','jquery-ui-slider','jquery-ui-accordion','jquery-ui-tabs','jquery-ui-draggable','jquery-ui-resizable','surgeryPostOpFormValidation','jquery-effects-core','jquery-ui-progressbar','jquery-cookie'), false, true); //,'jquery-effects-transfer'
      wp_register_script('test-js', plugins_url('/js/test.js', __FILE__), array('jquery','theme-load-js'), false, true);
    // }
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script('lente-intraocular-js');


    wp_localize_script('lente-intraocular-js', 'the_ajax_script', array( 'ajaxurl' => admin_url('admin-ajax.php') ));

    wp_enqueue_script('test-js');
    wp_enqueue_script('iol-simulator');
    //echo 'scripts de lente intraocular en cola';
}
add_action('wp_enqueue_scripts', 'iol_scripts');


//Aquí añadiremos las TAXONOMÍAS que queramos como COLUMNAS en el Back-End.
$filter_columns = 'manage_taxonomies_for_'.$iol.'_columns';

add_filter($filter_columns, 'lente_intraocular_columns_Taxonomies');
function lente_intraocular_columns_Taxonomies($taxonomies)
{
    $iol_taxo_diseOptic = _x('diseno-optica', 'taxo-name', 'iol');
    $iol_taxo_fabricante = _x('fabricante-lente', 'taxo-name', 'iol');
    $iol_taxo_toricidad = _x('toricidad', 'taxo-name', 'iol');
    $iol_taxo_adCerca = _x('adicion-cerca', 'taxo-name', 'iol');

    $taxonomies[$iol_taxo_diseOptic] = $iol_taxo_diseOptic;
    $taxonomies[$iol_taxo_fabricante] = $iol_taxo_fabricante;
    $taxonomies[$iol_taxo_toricidad] = $iol_taxo_toricidad;
    $taxonomies[$iol_taxo_adCerca] = $iol_taxo_adCerca;

    return $taxonomies;
}

/* Función para crear el select list que hace el filtrado en función de las taxonomías en la parte de administración */
add_action('restrict_manage_posts', 'my_filter_list');
function my_filter_list()
{
    $iol = _x('lente-intraocular', 'CustomPostType Name', 'iol');
    $iol_taxo_diseOptic         = _x('diseno-optica', 'taxo-name', 'iol');
    $iol_taxo_fabricante        = _x('fabricante-lente', 'taxo-name', 'iol');
    $iol_taxo_estatusComercial  = _x('estatus-comercial', 'taxo-name', 'iol');
    $iol_taxo_transIol          = 'translation-iol';

    $screen = get_current_screen();
    global $wp_query;
    if ($screen->post_type == $iol) {
        wp_dropdown_categories(array(
            'show_option_all' => _x('Todos los diseños', 'admin_display', 'iol'),
            'taxonomy' => $iol_taxo_diseOptic,
            'name' => $iol_taxo_diseOptic,
            'orderby' => 'name',
            'selected' => (isset($wp_query->query[$iol_taxo_diseOptic]) ? $wp_query->query[$iol_taxo_diseOptic] : ''),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => true,
            'hide_empty' => true,
        ));
        wp_dropdown_categories(array(
            'show_option_all' => _x('Todos los fabricantes', 'admin_display', 'iol'),
            'taxonomy' => $iol_taxo_fabricante,
            'name' => $iol_taxo_fabricante,
            'orderby' => 'name',
            'selected' => (isset($wp_query->query[$iol_taxo_fabricante]) ? $wp_query->query[$iol_taxo_fabricante] : ''),// '1013', //hoy sólo trabajo con Oculentis -> su id es 1013( isset( $wp_query->query[$iol_taxo_fabricante] ) ? $wp_query->query[$iol_taxo_fabricante] : '' ),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => true,
            'hide_empty' => true,
        ));

        wp_dropdown_categories(array(
            'show_option_all' => _x('Todos los estatus comerciales', 'admin_display', 'iol'),
            'taxonomy' => $iol_taxo_estatusComercial,
            'name' => $iol_taxo_estatusComercial,
            'orderby' => 'name',
            'selected' => (isset($wp_query->query[$iol_taxo_estatusComercial]) ? $wp_query->query[$iol_taxo_estatusComercial] : ''),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => true,
            'hide_empty' => true,
        ));

        wp_dropdown_categories(array(
            'show_option_all' => 'All translation status',
            'taxonomy' => $iol_taxo_transIol,
            'name' => $iol_taxo_transIol,
            'orderby' => 'name',
            'selected' => (isset($wp_query->query[$iol_taxo_transIol]) ? $wp_query->query[$iol_taxo_transIol] : ''),
            'hierarchical' => false,
            'depth' => 3,
            'show_count' => true,
            'hide_empty' => true,
        ));
    }
}

/*Ésta es la función que lleva a cabo el filtrado*/
add_filter('parse_query', 'perform_filtering');
function perform_filtering($query)
{
    global $pagenow;
    $post_type = _x('lente-intraocular', 'CustomPostType Name', 'iol'); // change HERE
    $iol_taxo_diseOptic = _x('diseno-optica', 'taxo-name', 'iol');
    $iol_taxo_fabricante = _x('fabricante-lente', 'taxo-name', 'iol');
    $iol_taxo_estatus = _x('estatus-comercial', 'taxo-name', 'iol');
    $iol_taxo_transIol = 'translation-iol';

    $iol_retirada = _x('retirada', 'taxo-value-slug', 'iol-scaffold');

    $qv = &$query->query_vars;

    if ($pagenow == 'edit.php' && isset($qv['post_type']) && $qv['post_type'] == $post_type && isset($qv[$iol_taxo_diseOptic]) && is_numeric($qv[$iol_taxo_diseOptic]) && $qv[$iol_taxo_diseOptic] != 0) {
        /* if(current_user_can('manage_options')){
             echo 'filtering performed';
         }*/
        $term = get_term_by('id', $qv[$iol_taxo_diseOptic], $iol_taxo_diseOptic);
        $qv[$iol_taxo_diseOptic] = $term->slug;
    }

    if ($pagenow == 'edit.php' && isset($qv['post_type']) && $qv['post_type'] == $post_type && isset($qv[$iol_taxo_fabricante]) && is_numeric($qv[$iol_taxo_fabricante]) && $qv[$iol_taxo_fabricante] != 0) {
        //echo 'Filtrado realizado en edit.php';

        $term = get_term_by('id', $qv[$iol_taxo_fabricante], $iol_taxo_fabricante);
        $qv[$iol_taxo_fabricante] = $term->slug;
        //prueba con que sólo aparezcan las que están retiradas
        $term = get_term_by('id', $qv[$iol_taxo_estatus], $iol_taxo_estatus);
        //$qv[$iol_taxo_estatus] =  $iol_retirada;//$term->slug;
    }


    if ($pagenow == 'edit.php' && isset($qv['post_type']) && $qv['post_type'] == $post_type && isset($qv[$iol_taxo_estatus]) && is_numeric($qv[$iol_taxo_estatus]) && $qv[$iol_taxo_estatus] != 0) {
        $term = get_term_by('id', $qv[$iol_taxo_estatus], $iol_taxo_estatus);
        $qv[$iol_taxo_estatus] = $term->slug;
    }

    //Añadimos un selector para la traducción.
    if ($pagenow == 'edit.php' && isset($qv['post_type']) && $qv['post_type'] == $post_type && isset($qv[$iol_taxo_transIol]) && is_numeric($qv[$iol_taxo_transIol]) && $qv[$iol_taxo_transIol] != 0) {
        $term = get_term_by('id', $qv[$iol_taxo_transIol], $iol_taxo_transIol);
        $qv[$iol_taxo_transIol] = $term->slug;
    }
}

//Vamos ahora con la parte del AJAX y las queries. Veremos si una vez hecho cumplimos con todo las prácticas que aparecen en los artículos.
 // Incluimos nuestro script que va a tener la lógica de Ajax -> la petición ajax y la respuesta.
     //wp_enqueue_script( 'my-ajax-handle', plugin_dir_url( __FILE__ ) . 'js/ajax.js', array( 'jquery' ) );
 // declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
     //wp_localize_script( 'my-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
 /* Aparentemente lo que hacemos de esta manera es poder pasarle al handle el valor de una variable: ajaxurl -> url que procesará en el servidor la petición
 ajax.*/

 function loadAjaxScripts()
 {

 //AÑADIMOS EL ESPECIFICADOR DE PAÍS.
     $Country = get_locale();

     //Registramos el user-manager aquí para no obligar a activarlo.

     wp_register_script('user-manager-js', plugins_url('user-manager/public/js/user-manager-public.js'), array('jquery')); //,'user-manager-js','user-manager'

     //echo 'INCLUSIÓN DEL JAVASCRIPT DE Lente-Intraocular';
 wp_register_script('ajax-lente-intraocular-js', plugins_url('/js/ajax.js', __FILE__), array('theme-load-js','jquery','lente-intraocular-js','user-manager-js')); //,'user-manager-js','user-manager'
 //wp_enqueue_script( 'my-ajax-handle', plugin_dir_url( __FILE__ ) . 'js/ajax.js', array( 'jquery','lente-intraocular-js' ) );
 wp_enqueue_script('ajax-lente-intraocular-js');


     wp_localize_script('ajax-lente-intraocular-js', 'ncSITE', array('Country' => $Country)) ;

     // declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
     wp_localize_script('ajax-lente-intraocular-js', 'the_ajax_script', array( 'ajaxurl' => admin_url('admin-ajax.php') ));
 }
 add_action('wp_enqueue_scripts', 'loadAjaxScripts');

 //Ya hemos "cargado" el fichero javascript que va a hacer la petición Ajax, además le hemos pasado
 //dirección .php que va a procesar la petición ajax: admin-ajax.php.
 //Esa admin-ajax.php lo que va a hacer es fire-trigger un action hook en función del parámetro action que le llega.
 //Esto implica que no tenemos que tocar nada de admin-ajax.php sino sencillamente suscribir nuestras funciones respuesta a esos hooks que al hacer la petición ajax se llevarán a cabo.


 /*There is a required parameter for a request sent to admin-ajax: It's called action. This parameter is necessary because when
 admin-ajax process the request, it will fire one of these hooks, depending on whether the current viewer is logged in or not:
 // this hook is fired if the current viewer is not logged in
    do_action( 'wp_ajax_nopriv_' . $_REQUEST['action'] );
 // if logged in:
    do_action( 'wp_ajax_' . $_POST['action'] );
 */
// THE AJAX ADD ACTIONS. The La función de JQUERY a aja-admin con un parámetro action -> ajax-admin.php genera un action hook -> suscribimos una función al action hook ->
// esta función devuelve algo -> lo procesamos de vuelta.

add_action('wp_ajax_filter_result', 'iol_show_posted_values');
add_action('wp_ajax_nopriv_filter_result', 'iol_show_posted_values'); // need this to serve non logged in users

add_action('wp_ajax_getPatientForm', 'getPatientForm');
add_action('wp_ajax_nopriv_getPatientForm', 'getPatientForm'); // need this to serve non logged in users

add_action('wp_ajax_getAdvForm', 'getAdvForm');
add_action('wp_ajax_nopriv_getAdvForm', 'getAdvForm'); // need this to serve non logged in users

add_action('wp_ajax_getSinglePatientForm', 'getSinglePatientForm');
add_action('wp_ajax_nopriv_getSinglePatientForm', 'getSinglePatientForm'); // need this to serve non logged in users

add_action('wp_ajax_getSingleAdvForm', 'getSingleAdvForm');
add_action('wp_ajax_nopriv_getSingleAdvForm', 'getSingleAdvForm'); // need this to serve non logged in users

//Función ajax para obtener las IOLs por nombre.
add_action('wp_ajax_getIol', 'getIol');
add_action('wp_ajax_nopriv_getIol', 'getIol'); // need this to serve non logged in users

//Función ajax para obtener los resultados de las encuestas.
add_action('wp_ajax_getPostOpTestResults', 'getPostOpTestResults');
add_action('wp_ajax_nopriv_getPostOpTestResults', 'getPostOpTestResults'); // need this to serve non logged in users

add_action('wp_ajax_getSingleIolPatientInfo', 'getSingleIolPatientInfo');
add_action('wp_ajax_nopriv_getSingleIolPatientInfo', 'getSingleIolPatientInfo');

//Función ajax para rellenar el contenido del changeModeBloq

add_action('wp_ajax_addChangeModeBloqContent', 'addChangeModeBloqContent');
add_action('wp_ajax_nopriv_addChangeModeBloqContent', 'addChangeModeBloqContent');

//El call to question.
add_action('wp_ajax_addCallToQuestion', 'addCallToQuestion');
add_action('wp_ajax_nopriv_addCallToQuestion', 'addCallToQuestion');

 // THE FUNCTION -> Esta es la función que será ejecutada ya que es la que hemos hookeado en el action hook que admin-ajax.php disparará.
 function iol_filter_result()
 {
     /* this area is very simple but being serverside it affords the possibility of retreiving data from the server and passing it back to the javascript function */
     $name = $_POST['amount'];
     echo "Hello World, " . $name;// this is passed back to the javascript function
 die();// wordpress may print out a spurious zero without this - can be particularly bad if using json
 }

  // ADD EG A FORM TO THE PAGE
 function hello_world_ajax_frontend()
 {
     $the_form = '
 <form id="theForm">
 <input id="name" name="name" value = "name" type="text" />
 <input name="action" type="hidden" value="the_ajax_hook" />&nbsp; <!-- this puts the action the_ajax_hook into the serialized form -->
 <input id="submit_button" value = "Click This" type="button" onClick="submit_me();" />
 </form>
 <div id="response_area">
 This is where we\'ll get the response
 </div>';
     return $the_form;
 }
 add_shortcode("hw_ajax_frontend", "hello_world_ajax_frontend");

//Include AJAX Handlers
include(plugin_dir_path(__FILE__) . 'ajax/ajax-handler.php');
include(plugin_dir_path(__FILE__) . 'ajax/ajax-change-filters.php');
include(plugin_dir_path(__FILE__) . 'ajax/ajax-getIol.php');
include(plugin_dir_path(__FILE__) . 'ajax/ajax-getPostOpTestResults.php');
include(plugin_dir_path(__FILE__) . 'ajax/ajax-getSingleIolPatientInfo.php');
include(plugin_dir_path(__FILE__) . 'ajax/ajax-addChangeModeBloqContent.php');
include(plugin_dir_path(__FILE__) . 'ajax/ajax-addCallToQuestion.php');

/*-- Vamos a añadir lo Necesario para Localización */
function lente_intraocular_setup()
{

    /*-- Centralizamos archivos .mo --*/
    //load_plugin_textdomain('iol', false, dirname(plugin_basename(__FILE__)). '/languages/');//
    //load_plugin_textdomain('iol_display', false, dirname(plugin_basename(__FILE__)). '/languages/');//
    load_plugin_textdomain('iol', false, 'nc-sync/languages');
    load_plugin_textdomain('iol-scaffold', false, 'nc-sync/languages');
    load_plugin_textdomain('iol_cpt_display', false, 'nc-sync/languages');

    /*
    if( load_textdomain('iol',  ABSPATH .'wp-content/plugins/nc-sync/languages/iol-'.get_locale().'.mo') ){
     echo ABSPATH .'wp-content/plugins/nc-sync/languages/iol-'.get_locale().'.mo';
    echo __('lente-intraocular','iol');
    }
    else{
        echo 'mo not readable';
    }

     load_textdomain('iol_cpt_display', false, ABSPATH .'wp-content/plugins/nc-sync/languages/');//
     */
} // end custom_theme_setup
add_action('plugins_loaded', 'lente_intraocular_setup');//Necesitamos cargar el text domain antes after_setup_theme


/*-- Vamos a Añadir una función con términos localizados para ser añadidos a las taxonomías pero localizadas */
register_activation_hook(__FILE__, 'iolCPT_activate');

/* En esta función vamos a insertar los términos */
function iolCPT_activate()
{
    flush_rewrite_rules();
}

/* Vamos a añadir un filtro para aumentar la precisión del DECIMAL en las queries */
/* Recordar que esto generaba el 0=1 aqué en la query¡¡¡¡*/
add_filter('get_meta_sql', 'cast_decimal_precision');

function cast_decimal_precision($array)
{
    $array['where'] = str_replace('DECIMAL', 'DECIMAL(6,3)', $array['where']);

    return $array;
}

/*Añadir los parámetros a utilizar a las urls*/

add_filter('query_vars', 'parameter_queryvars');

function parameter_queryvars($qvars)
{

//    diseOptic=monofocal-asferica&toricidad=si&laSI=luz-azul&addCerca=3.25+diopt+-+3.75+diopt&fabricante=Hoya
//$qvars[] = 'tipo-lente-intraocular';
$qvars[] = 'diseno-optica'; //Slug del taxo-name diseno-optica:: (single-taxo-value=single option) => Combobox
$qvars[] = 'toricidad';//Slug del taxo-name Toricidad:: (single-taxo-value = single-option) => Input Radio

$qvars[] = 'luz-ultravioleta'; //Slug del taxo-value-name filtro ultravioleta:: (multiple-taxo-value=multiple-option) => check box, taxo-value-slug
$qvars[] = 'luz-azul';//Slug del taxo-value-name filtro de luz azul :: (multiple-taxo-value=multiple-option) => check box ,taxo-value-slug
$qvars[] = 'filtros-se'; //Slug de filtros sin especificar => (multiple-taxo-value=multiple-option) => check box, taxo-value-(slug-se)

$qvars[] = 'adicion-cercaTV'; //Se traslada un Valor para posterior Proceso.

    $qvars[] = 'bordes-cuadrados';//Slug del taxo-name: bordes cuadrados: (single-taxo-value = single-option) => input-radio
$qvars[] = 'fabricante-lente';//slug del taxo-name fabricante de lente:(single-taxo-value = single-option)=> select list.

$qvars[] = 'refractiva';//slug del taxo-value-name: refractiva:: (multiple-taxo-value=multiple-options) => check box, taxo-valule-slug
$qvars[] = 'difractiva';//slug del taxo-value-name: difractiva:: (multiple-taxo-value=multiple-options) => check box, taxo-valule-slug
$qvars[] = 'mixta';//slug del taxo-value-name: mixta:: (multiple-taxo-value=multiple-options) => check box, taxo-valule-slug
$qvars[] = 'principio-optico-se';//slug del taxo-value-name: principio-optico-se:: (multiple-taxo-value=multiple-options) => check box, taxo-valule-(slug-se)

$qvars[] = 'material';//slug del taxo-name: material:: (single-taxo value=single option) => combobox
$qvars[] = 'inyector';//input radio
$qvars[] = 'precargada';//
$qvars[] = 'diseno-hapticos';

    $qvars[] = 'diamOpticD';
    $qvars[] = 'diamTotD';
    $qvars[] = 'asfericiD';
    $qvars[] = 'diseno';

    $qvars[] = 'tamaInciD';

    $qvars[] = 'dioptEsfD';
    $qvars[] = 'dioptCilD';

    //Para detectar si la query es Ajax.
    $qvars[] = 'ajax';
    //la variable para hacer el trackeo del usuario
    //$qvars[] = 'pt';

    //Las variables propias del test.
$qvars[] = 'iolTest';//ESTA VARIABLE NO VEO CUANDO SE VA A PASAR...

$qvars[] = 'tQ1';
    $qvars[] = 'tQ2';
    $qvars[] = 'tQ3';
    $qvars[] = 'tQ4';
    $qvars[] = 'tQ5';
    $qvars[] = 'tQ6';
    $qvars[] = 'tQ7';
    $qvars[] = 'tQ8';
    $qvars[] = 'tQ9';
    $qvars[] = 'tQ10';

    return $qvars;
}

//Vamos a ver si podemos utilizar el pre_get_posts en el archive de lente intraocular y procesar los parámetros de la url


function filter_iol($query)
{
    global $iolAudit;
    global $NotEspecified;
    global $UndefinedMetaDataSelector;
    global $UndefinedTaxonomyDataSelector;


    //Queremos ser capaces de hacer que haya lentes que no salgan en las búsquedas en función de la taxonomía: Estatus Comercial de la Lente.
    //Si tienen un valor de estatus-comercial -> retirada que no salgan en ninguna consulta salvo que sea la propia query de Lentes Retiradas.

    /*-- Aquí metemos nuestra condición de exclusión de las lentes retiradas --*/
    /* => Salvo que sea la Query Principal y se requiera específicamente las lios retiradas NO SE MUESTRA NINGUNA lente con el término retirada*/
    if (($query->is_main_query() && (($query->is_tax(_x('estatus-comercial', 'taxo-name', 'iol'), _x('retirada', 'taxo-value-slug', 'iol-scaffold'))) ||($query->is_tax(_x('estatus-comercial', 'taxo-name', 'iol'), _x('en-estudio', 'taxo-value-slug', 'iol-scaffold')))))) {




        /*-- Comprobamos el estatus de tax_query => si está definido lo "cogemos y modificamos", si no lo asignamos --*/
        // if ( current_user_can('manage_options') ) {
        //if(isset($query->tax_query)){
        //  var_dump($query);
        // }else{
        //    echo 'Tax query no está definido¡¡¡¡¡¡¡';
        //}
        //}

        //metemos también la ordenación:
            $query->set('orderby', 'meta_value_num');//nivelPrefLenteMD
            $query->set('meta_key', 'nivelPrefLenteMD');
        $query->set('order', 'DESC');

        return $query;
    }




    //var_dump($query);

    //Si la solicitud des de taxonomía
    if ($query->is_main_query() && $query->is_tax()) {
        //echo 'pasando por el filtro';
        //Queremos que pase por filterIOLEngine para que:
        //1 Asigne en el panel la info lo que corresopnda.
        //2 podamos asignar manualmente la query_var correspondiente para que se seleccione el input correpondiente del filtro.





        //Cojemos los valores de taxonomía y de término.
       $taxonomia = $query->tax_query->queries[0]['taxonomy'];//

       $taxonomias = array(_x('tipo-lente-intraocular', 'taxo-name', 'iol'),  _x('diseno-optica', 'taxo-name', 'iol'),
                           _x('fabricante-lente', 'taxo-name', 'iol'),        _x('fabricante-lente', 'taxo-name', 'iol'),
                           _x('toricidad', 'taxo-name', 'iol'),               _x('adicion-cerca', 'taxo-name', 'iol'),
                           _x('filtros', 'taxo-name', 'iol'),                 _x('material', 'taxo-name', 'iol'),
                           _x('diseno', 'taxo-name', 'iol'),                  _x('principio-optico', 'taxo-name', 'iol'),
                           _x('asfericidad', 'taxo-name', 'iol'),             _x('bordes-cuadrados', 'taxo-name', 'iol'),
                           _x('inyector', 'taxo-name', 'iol'),                _x('precargada', 'taxo-name', 'iol'),
                           _x('plegable', 'taxo-name', 'iol'),                _x('diseno-hapticos', 'taxo-name', 'iol'),
                           _x('estatus-comercial', 'taxo-name', 'iol'));


        $termsValue = $query->tax_query->queries[0]['terms'][0];
        //var_dump($terms);
        //$valorTaxonomia =





        if (in_array($taxonomia, $taxonomias)) {



           //var_dump($_GET);
            if (array_key_exists($taxonomia, $_GET)) {



              //echo 'Dice que  existe....';
             //$_GET[$taxonomia] = $termsValue;
            } else {

               //Hacemos esto aunque no sea muy ortodoxo para que funcionen los forms.

                $_GET[$taxonomia] = $termsValue;

                include('filterIolEngine.php');
                // Con el filterIolEngine hemos metido la info pero falta meter la condicion de estatus comercial.
                $query->set('tax_query', $tax_query);
            }
            //echo get_query_var('toricidad');
            //Aunque no haga falta para la selección de las lentes sí que es necesaria pra el panel de info

            //Vamos a ordenar siempre por orden de preferencia ascendente.
            $query->set('orderby', 'meta_value_num');//nivelPrefLenteMD
            $query->set('meta_key', 'nivelPrefLenteMD');
            $query->set('order', 'DESC');
        }
    }

    if ($query->is_archive(_x('lente-intraocular', 'admin_display', 'iol')) && $query->is_main_query() && $query->query_vars['post_type'] == _x('lente-intraocular', 'CustomPostType Name', 'iol') && (!is_admin())) { // && $query->query_vars['post_type'] == 'lente-intraocular' // && $query->is_main_query()   and is_archive() // == 'lente-intraocular' and get_query_var( 'posts_per_page' )== '2'




        //if($query->is_archive('lente-intraocular')){
        //Vamos a añadir como args del WP_Query los parámetros GET que no coincidan exactamente como valor asociativo taxonomy-name=valor.
        //Son los inputs que se han definido como checkboxes:
        //luz-ultravioleta;luz-azul;refractiva;
        //echo 'Esta petición pasa nuestro condicional de pre_get_posts => la del ajax no la pasaba';


        if (isset($_GET['viewType'])) {
            $viewType = $_GET['viewType'];
        } else {
            $viewType = 4;
        }


        if ($viewType!= 'Grid') {
            $viewTypeNumber = $viewType;
        } else {
            $viewTypeNumber = 12;
        }
        $query->set('posts_per_page', $viewTypeNumber);

        //Vamos a ordenar siempre por orden de preferencia ascendente.
    $query->set('orderby', 'meta_value_num');//nivelPrefLenteMD
    $query->set('meta_key', 'nivelPrefLenteMD');
        $query->set('order', 'DESC');
        //echo 'PASANDO POR EL FILTRADO';
        //Vamos a meter la lógica del filterIolEngine

        include('filterIolEngine.php');

        //Vamos a poner directamente aquí la condición de que el estatus comercial de la clínica no sea "retirada", esto lo vamos a añadrid


        $query->set('tax_query', $tax_query);
        $query->set('meta_query', $meta_query);
        //var_dump($query);
    }




    return $query;
}
add_action('pre_get_posts', 'filter_iol');

//Vamos a registrar las conexiones.
//Estamos dudando si conectar con lente o con fabricante... En principio creo que lo suyo será con fabricante...

/*function fabricanteToClinicaConnection() {
    p2p_register_connection_type( array(
        'name'  => 'fabricante_to_clinica',
        'from'  => _x('fabricante','CustomPostType Name','fabricante'),
        'to'    => _x('clinica','CustomPostType Name','clinica')
    ) );
}*/

//Vamos a registrar  también la de lente intraocular con clínica.
function lenteToClinicaConnection()
{
    p2p_register_connection_type(array(
        'name' => 'lente_to_clinica',
        'from' => _x('lente-intraocular', 'CustomPostType Name', 'iol'),
        'to' => _x('clinica', 'CustomPostType Name', 'clinica')
    ));
}

//add_action( 'p2p_init', 'fabricanteToClinicaConnection' );
add_action('p2p_init', 'lenteToClinicaConnection');


//Definimos variables Globales.
function my_audit_variables()
{
    global $iolAudit;   // = array();
    global $NotEspecified;

    global $UndefinedMetaDataSelector;
    global $UndefinedTaxonomyDataSelector;

    global $iolPluginDirectory;

    $iolPluginDirectory = plugin_dir_path(__FILE__);
}
add_action('init', 'my_audit_variables');




 /*   if($query->query_vars['post_type'] == 'nav_menu_item'){

        echo 'está pasando por la condició nav_menu_item';
    }
    */
    /*if(is_tag( 'monofocal-esferica' )){
        echo 'Página de archivo del tag monofocal-asférica';
    }*/

    //echo 'Está pasndo por el pre_get_posts';
//    if($query->query_vars['ajax']== 'AJAX'){

             /*Lógica del filtrado AJAX*/
  //               }


   /* if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'cat', '-1,-1347' );
    }

    */
    //$postPer =get_query_var( 'paged' );
    //echo 'Esto es un escándaloooo';
    //echo '<br /><br />'.strval($postPer).'<br /><br />';
    //echo '<br />'.$query->query_vars['posts_per_page'].'<br />';
    //echo '<br /><br />'.var_dump($query->query_vars).'<br /><br />';
    //echo '<br /><br />'.var_dump($query).'<br /><br /><br /><br /><br /><br /><br /><br />';
   //var_dump($query);


/*Filtro para el autoselect con el nombre de la lente */

add_filter('posts_where', 'iolTextName', 10, 2);
function iolTextName($where, $wp_query)
{
    global $wpdb;
    if ($iolTextName = $wp_query->get('iolTextName')) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql(like_escape($iolTextName)) . '%\'';
    }
    return $where;
}


/* Vamos a crear ahora la funcion para el proceso del post op test */

function iolSurgeryForm($postValues)
{
    global $wpdb;

    $wpdb->show_errors();
    //Tenemos que hacer el proceso del formulario.
    //para los valores de los inputs radio se hace una validación por comparación.
    //Los valores de texto libre se validan para evitar ataques.

    // define variables and initialize with empty values
    $surgeryTime = $surgeryEye = $surgeryIol = $dDriving = $nDriving = $iVision = $newspaper = "";
    $prices = $needle = $dGlasses = $nGlasses = $currentVision = $satIol = $age =$name = $provincia = "";
    $clinic = $comments = $ip = "";

    $postIolSurgeryArrayResult = array();


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //surgeryTime
        if (empty($_POST["surgeryTime"])) {
            $surgeryTime = "";
        } else {
            $surgeryTime = $_POST["surgeryTime"];
        }
        $postIolSurgeryArrayResult["surgeryTime"] = $surgeryTime;

        //surgeryEye
        if (empty($_POST["surgeryEye"])) {
            $surgeryEye = "";
        } else {
            $surgeryEye = $_POST["surgeryEye"];
        }
        $postIolSurgeryArrayResult["surgeryEye"] = $surgeryEye;

        //surgeryIol
        if (empty($_POST["surgeryIol"])) {
            $surgeryIol = "";
        } else {
            $surgeryIol = $_POST["surgeryIol"];
        }
        $postIolSurgeryArrayResult["surgeryIol"] = $surgeryIol;

        //dDriving
        if (empty($_POST["dDriving"])) {
            $dDriving = "";
        } else {
            $dDriving = $_POST["dDriving"];
        }
        $postIolSurgeryArrayResult["dDriving"] = $dDriving;
        //nDriving
        if (empty($_POST["nDriving"])) {
            $nDriving = "";
        } else {
            $nDriving = $_POST["nDriving"];
        }
        $postIolSurgeryArrayResult["nDriving"] = $nDriving;
        //iVision
        if (empty($_POST["iVision"])) {
            $iVision = "";
        } else {
            $iVision = $_POST["iVision"];
        }
        $postIolSurgeryArrayResult["iVision"] = $iVision;

        //newspaper
        if (empty($_POST["newspaper"])) {
            $newspaper = "";
        } else {
            $newspaper = $_POST["newspaper"];
        }
        $postIolSurgeryArrayResult["newspaper"] = $newspaper;

        //prices
        if (!isset($_POST["prices"])) {
            $prices = "";
        } else {
            $prices = $_POST["prices"];
        }
        $postIolSurgeryArrayResult["prices"] = $prices;

        //needle
        if (empty($_POST["needle"])) {
            $needle = "";
        } else {
            $needle = $_POST["needle"];
        }
        $postIolSurgeryArrayResult["needle"] = $needle;

        //dGlasses
        if (empty($_POST["dGlasses"])) {
            $dGlasses = "";
        } else {
            $dGlasses = $_POST["dGlasses"];
        }
        $postIolSurgeryArrayResult["dGlasses"] = $dGlasses;

        //nGlasses
        if (empty($_POST["nGlasses"])) {
            $nGlasses = "";
        } else {
            $nGlasses = $_POST["nGlasses"];
        }
        $postIolSurgeryArrayResult["nGlasses"] = $nGlasses;

        //currentVision
        if (empty($_POST["currentVision"])) {
            $currentVision = "";
        } else {
            $currentVision = $_POST["currentVision"];
        }
        $postIolSurgeryArrayResult["currentVision"] = $currentVision;

        //satIol
        if (empty($_POST["satIol"])) {
            $satIol = "";
        } else {
            $satIol = $_POST["satIol"];
        }
        $postIolSurgeryArrayResult["satIol"] = $satIol;

        //age
        if (empty($_POST["age"])) {
            $age = "";
        } else {
            $age = $_POST["age"];
        }
        $postIolSurgeryArrayResult["age"] = $age;

        //uName
        if (empty($_POST["uName"])) {
            $uName = "";
        } else {
            $uName = $_POST["uName"];
        }
        $postIolSurgeryArrayResult["uName"] = $uName;

        //provincia
        if (empty($_POST["provincia"])) {
            $provincia = "";
        } else {
            $provincia = $_POST["provincia"];
        }
        $postIolSurgeryArrayResult["provincia"] = $provincia;

        //clinic
        if (empty($_POST["clinic"])) {
            $clinic = "";
        } else {
            $clinic = $_POST["clinic"];
        }
        $postIolSurgeryArrayResult["clinic"] = $clinic;

        //comments
        if (empty($_POST["comments"])) {
            $comments = "";
        } else {
            $comments = $_POST["comments"];
        }
        $postIolSurgeryArrayResult["comments"] = $comments;

        //email
        if (empty($_POST["email"])) {
            $email = "";
        } else {
            $email = $_POST["email"];
        }
        $postIolSurgeryArrayResult["email"] = $email;

        //phone
        if (empty($_POST["phone"])) {
            $phone = "";
        } else {
            $phone = $_POST["phone"];
        }
        $postIolSurgeryArrayResult["phone"] = $phone;
        //ip
        if (empty($_SERVER['REMOTE_ADDR'])) {
            $ip = "";
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $postIolSurgeryArrayResult["ip"] = $phone;
    }
    // Llevamos a cabo la inserción del formulario.
    //var_dump($postIolSurgeryArrayResult);
    //echo 'la inserción de lo anterior se ha llevado a cabo';
    //$wpdb->insert( $table, $data, $format );
    $wpdb->insert('result_iol_surgery', $postIolSurgeryArrayResult);


    echo 'esta función se está ejecutando';

    return 1;
}




















 ?>
