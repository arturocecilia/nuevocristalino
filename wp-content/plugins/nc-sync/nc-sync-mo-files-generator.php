<?php


// Habrá formulario de confirmación previa y luego info sobre la generación.
function moFilesGenerator()
{
    global $wpdb;

    $html_update ="";
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have rights to access this page.'));
    }

    // when form is submitted
    if (isset($_POST['mode'])) {
        $toDo = $_POST['action'];
    } else {
        $toDo = null;
    }

    if ($toDo == "mo-generate") {


        //Para conseguir el path donde hemos de crear el fichero: ej, include(ABSPATH . 'wp-content/plugins/lente-intraocular/archive-patient-form.php');
        $pathToTextDomain = array(

                                'iol'                       =>  ABSPATH .   'wp-content/plugins/nc-sync/languages/',
                                'iol_theme'                 =>  ABSPATH .   'wp-content/plugins/nc-sync/languages/',
                                'iol_cpt_display'           =>  ABSPATH .   'wp-content/plugins/nc-sync/languages/',
                                'iol-scaffold'              =>  ABSPATH .   'wp-content/plugins/nc-sync/languages/',
                                'clinica'                   =>  ABSPATH .   'wp-content/plugins/nc-sync/languages/',
                                'clinica_cpt_display'       =>  ABSPATH .   'wp-content/plugins/nc-sync/languages/',
                                'clinica-scaffold'          =>  ABSPATH .   'wp-content/plugins/nc-sync/languages/',
                                'opinion-doctor'            =>  ABSPATH .   'wp-content/plugins/nc-sync/languages/',
                                'fabricante'                =>  ABSPATH.    'wp-content/plugins/nc-sync/languages/',
                                'proveedor'                 =>  ABSPATH.    'wp-content/plugins/nc-sync/languages/',
                                'miscelaneous_cpt_display'  =>  ABSPATH.    'wp-content/plugins/nc-sync/languages/',

                                'iol_last'                  =>  ABSPATH.    'wp-content/plugins/nc-sync/languages/',
                                'user-analysis-p'           =>  ABSPATH.    'wp-content/plugins/nc-sync/languages/',
                                'user-manager-p'            =>  ABSPATH.    'wp-content/plugins/nc-sync/languages/'

                                );


        $currentLangWP = get_bloginfo('language', 'display');

        $currentLangArray = array('es_ES','es_CO','es_MX','es_CL','en_GB','de_DE','de_AT','en_US','fr_FR'); //str_replace('-','_',$currentLangWP);
        //Para cada lenguaje hay que crear los .mos de arriba en el path indicado. Se incluirá en cada uno tantos términos como
        //se devuelva de la BBDD.
        //require('php-mo.php');

        foreach ($currentLangArray as $currentLang) {
            foreach ($pathToTextDomain as $key=>$value) {
                $domain = $key;
                $path = $value;
                $fullPathToPo = $path.$domain.'-'.$currentLang.'.po';

                $queryGetTrans = "SELECT text as msgid, context as msgctxt, ".$currentLang." as msgstr FROM nc_mu_mo where domain = '".$domain."'";

                echo $queryGetTrans.'<br /><br />';


                $resultTrans = $wpdb->get_results($queryGetTrans);

                $fh = fopen($fullPathToPo, 'w');


                fwrite($fh, "#\n");

                fwrite($fh, "msgid \"\"\n");
                fwrite($fh, "msgstr \"\"\n");
                fwrite($fh, "\"Content-Type: text/plain; charset=utf-8\\n\"");


                foreach ($resultTrans as $poArray) { //$key => $value

                    $key  = addslashes($poArray->msgid); //utf8_decode(
                    //Estoy teniendo problemas con este addslashes en frances -> Como no los he tenido en otros idiomas lo comento.
                    if ($currentLang == 'fr_FR' || $currentLang == 'en_GB' || $currentLang == 'en_US') {
                        $value     = $poArray->msgstr;
                    } else {
                        $value     = addslashes($poArray->msgstr);
                    }

                    $context   = addslashes($poArray->msgctxt);

                    fwrite($fh, "\n");
                    fwrite($fh, "msgctxt \"$context\"\n");
                    fwrite($fh, "msgid \"$key\"\n");
                    fwrite($fh, "msgstr \"$value\"\n");
                }

                fclose($fh);
                //Hacemos el .mo.

         //phpmo_convert( $fullPathToPo  ); //, [ 'output.mo' ]
            }
        }
    } ?>
    <div class="wrap">
        <?php echo $html_update; ?>
        <div id="icon-plugins" class="icon32"><br /></div>
        <h2>Mo Generator for the Site</h2>
        <p>A continucaci&oacute;n se va a generar la localizacion para el site de acuerdo al valor de idioma que tiene en su configuración y a los
        términos correspondientes de la tabla nc_mu_mo.</p>

        <form action="" method="post" enctype="multipart/form-data">
            <!-- Con este input lo que hacemos es controlar que efectivamente se ha enviado el formulario, esto es que estamos en el post-->
            <!-- Habrá que ir aglutinando las distintas funciones en un mismo plugin -->
            <input type="hidden" name="mode" value="submit">
            <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="action" value="mo-generate"> - Proceder con la localización del site.
            <br />

            <input type="submit" value="Generar las Mo files en nc-sync" />
        </form>


        <p style="color: red">Please make sure you back up your database before proceeding!</p>
    </div>
    <?php
}

function ncMOSiteGenerator_Menu()
{
    add_submenu_page('tools.php', 'Mo Files Generator', 'Mo Files Generator', 'add_users', 'mo-files-generator', 'moFilesGenerator');
}






/*
//En función del text-domain irán en un sitio u otro.
/*  0 - load_child_theme_textdomain('theme_iol_display', get_stylesheet_directory() . '/languages/') --> Este no tiene nada hay que borrarlo*/

/* ----------- Estos son los que hay por el momento, habrá que añadir uno específico del theme  ------------- */
/*  Habrá que mapearlos a su ruta para generarlos */
/*          LENTES              */
/*  1 - load_plugin_textdomain('iol', false, dirname(plugin_basename(__FILE__)). '/languages/');                            */
//after_setup_theme hook en ABSPATH . 'wp-content/plugins/lente-intraocular/lente-intraocular.php
/*  2 - load_plugin_textdomain('iol_display', false, dirname(plugin_basename(__FILE__)). '/languages/');                    */
//after_setup_theme hook en ABSPATH . 'wp-content/plugins/lente-intraocular/lente-intraocular.php
/*  3 - load_plugin_textdomain('iol-scaffold', false, dirname(plugin_basename(__FILE__)).'/languages/');                    */
//after_setup_theme hook en ABSPATH . 'wp-content/plugins/iolTranslator/iolTranslator.php               */

/*          CLÍNICAS            */
/*  load_plugin_textdomain('clinica', false, dirname(plugin_basename(__FILE__)). '/languages/');                            */
//after_setup_theme hook en ABSPATH . 'wp-content/plugins/clinica/clinica.php
/*  load_plugin_textdomain('clinica_display', false, dirname(plugin_basename(__FILE__)). '/languages/');                    */
//after_setup_theme hook en ABSPATH . 'wp-content/plugins/clinica/clinica.php
/*  load_plugin_textdomain('clinica-scaffold', false, dirname(plugin_basename(__FILE__)). '/languages/');                   */
//after_setup_theme hook en ABSPATH . 'wp-content/plugins/clinicaTranslator/clinicaTranslator.php               */

/*  Nota Info:    el nombre del .mo file es textdomain-lang_LANG.mo, se descarga con la función de turno

                dando el textDomain y la ruta donde está, el Lang lo coge desde configuración.
*/
