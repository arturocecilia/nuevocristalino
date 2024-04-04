<?php

use App\Models\NcSync;
use App\Models\NcMuMo;

//Función para sacar los key ids de los terms desde donde se encuentren
function keyWPTermsIolScaffold(&$elemento1, $clave, $context)
{
    global $wpdb;
    $langKey = get_locale();

    $ncmumo = NcMuMo::where(get_locale(), $elemento1)
                    ->where('domain', 'iol-scaffold')
                    ->where('context', $context)
                    ->first();

    if (is_null($ncmumo)) {
        $elemento1 = null;
    } else {
        $elemento1 = $ncmumo->text;
    }
}



function syncTranslationStatusFromPost($locale, $post_id, $POST)
{
    global $ncWPSites;

    $ncsync = NcSync::where($locale, $post_id)->first();
    if (!is_null($ncsync)) {
        foreach ($ncWPSites as $site_key => $site_id) {
            $ncsync->{$site_key.'_status'} = $POST[$site_key.'_status'];
        }
        $post_type = get_post_type($post_id);

        $ncsync->save();
    } else {
        $ncsync = new NcSync();
        $ncsync->{$locale} = $post_id;
        $ncsync->post_type = get_post_type($post_id);

        $ncsync->save();
    }
    return $ncsync->id;
}



function getCptKey($post)
{
    $unstranslatedSynchedPostTypes = ['page','post','email-content'];

    if (!in_array($post->post_type, $unstranslatedSynchedPostTypes)) {
        $ncmumoOfPostType = NcMuMo::where(get_locale(), $post->post_type)
                                  ->where('context', 'CustomPostType Name')
                                  ->first();

        if (!is_null($ncmumoOfPostType)) {
            return $ncmumoOfPostType->text;
        } else {
            return null;
        }
    } else {
        return $post->post_type ;
    }
}



function loadArrayIolPostTaxonomyTermsKeys($post)
{
    $arrayIolPostTaxoTermKeys = [];
    $iolTaxonomies =   [
                    'tipo-lente-intraocular',
                    'diseno-optica',
                    'fabricante-lente',
                    'toricidad' ,
                    'adicion-cerca',
                    'filtros',
                    'material',
                    'diseno',
                    'principio-optico',
                    'asfericidad',
                    'bordes-cuadrados',
                    'inyector',
                    'precargada',
                    'plegable',
                    'diseno-hapticos',
                    'estatus-comercial',
                    'nivel-pref-lente',
                    'iolTest',
                    'implantada-en-clinicas',
                    'translation-iol'
                  ];

    foreach ($iolTaxonomies as $taxonomy) {
        $arrayIolPostTaxoTermKeys[] = array($taxonomy,wp_list_pluck(get_the_terms($post->ID, _x($taxonomy, 'taxo-name', 'iol')), 'name'));
    }


    $length = count($arrayIolPostTaxoTermKeys);
    for ($x=0; $x<$length; $x++) {
        //Comprobamos que es un array. si no es array fuera.
        if (count($arrayIolPostTaxoTermKeys[$x][1])>0) {
            //Esta función sólo te va funcionar cuando los valores de las $arrayIolPostTaxoTermKeys sean los ids de los .mos esto es cuando sea esp (por el momneto...).
            //Este array_walk con esa función coge los valores y obtiene el correspondiente id.
            array_walk($arrayIolPostTaxoTermKeys[$x][1], 'keyWPTermsIolScaffold', 'taxo-value-name');
        }
    }

    return $arrayIolPostTaxoTermKeys;
}

function loadArrayMetadata($post)
{
    $arrayMetadata =[];
    $iolMetas = [
              'distribuidorD',
              'diamOpticD',
              'diamTotD',
              'formOpticD',
              'matHapticD',
              'angulaHapticD',
              'asfericiD',
              'tamaInciD',
              'cteAD',
              'acdD',
              'surgeonFactorD',
              'inyectorD',
              'esfDesdeD',
              'esfHastaD',
              'esf05DesdeD',
              'esf05HastaD',
              'stepEsf',
              'cilDesdeD',
              'cilHastaD',
              'stepCil',
              'dateIniD',
              'dateFinD',
              'nivelPrefLenteMD',
              'docSourceD',
              'webSourceD'
            ];

    foreach ($iolMetas as $iolMeta) {
        $arrayMetadata[] = array($iolMeta ,		get_post_meta($post->ID, $iolMeta, true));
    }

    return $arrayMetadata;
}

/*
17392,13823,13593,14993,2869,14668,13724,21048
,21047,14300,15375,13732,13743,13214,10854,13213
,13169,15210,12644,8796,233,14915,2881,13157
,14943,13887,13674,13886,14304
*/

function ncdeletepost($post)
{
    global $ncWPSites;

    $ncsyncPost = NcSync::where(get_locale(), $post->ID)
                        ->first();

    foreach ($ncWPSites as $key=>$value) {
        switch_to_blog($value);

        wp_delete_post($ncsyncPost->{get_blog_option($value, 'WPLANG')}, true);//$post->ID

        if ($post->post_type == 'attachment') {
            wp_delete_attachment($ncsyncPost->{get_blog_option($value, 'WPLANG')}, true);//$post->ID
        }
        restore_current_blog();
    }


    $ncsyncPost->delete();
}


function getDomainFromCptKey($cptKey)
{
    $domainCPT= '';
    switch ($cptKey) { //$postBasic['post_type']
                case   'lente-intraocular':
                    $domainCPT = 'iol';
                break;
                case    'clinica':
                    $domainCPT = 'clinica';
                break;
                case    'fabricante':
                    $domainCPT = 'fabricante';
                break;
                case    'opinion-doctor':
                    $domainCPT = 'opinion-doctor';
                break;
            }
    return $domainCPT;
}



function getncWPSitesCopy()
{
    global $ncWPSites;

    $ncWPSitesCopy = [];

    foreach ($ncWPSites as $key => $value) {
        $ncWPSitesCopy[$key] = $value;
    }
    return $ncWPSitesCopy;
}


function insertPostInSyncSave($postBasicData, $ncsyncid, $locale, $wperror)
{
    remove_action('save_post', 'sync_save_postdata', 99);
    $insertedPostId = wp_insert_post($postBasicData, $wperror);
    //cambio nuevo nc_sync
    ob_start();

    $result = ob_get_clean();
    add_action('save_post', 'sync_save_postdata', 99);


    $ncsync = NcSync::find($ncsyncid);
    $ncsync->{$locale} = $insertedPostId;
    $ncsync->save();

    return $insertedPostId;
}


function updatePostInSyncSave($ContentPostUpdate)
{
    $onlyContentPropsPost = array(
    'post_content'  =>     $ContentPostUpdate['post_content'],
    'post_excerpt'  =>     $ContentPostUpdate['post_excerpt']
                                  );


    remove_action('save_post', 'sync_save_postdata', 99);
    wp_update_post($ContentPostUpdate);
    add_action('save_post', 'sync_save_postdata', 99);
}

function updateIolPostTaxonomiesFromTaxoTermKeys($arrayIolPostTaxoTermKeys, $post_id)
{
    $length = count($arrayIolPostTaxoTermKeys);
    for ($x=0; $x<$length; $x++) {
        //Comprobamos que es un array. si no es array fuera.
        if (count($arrayIolPostTaxoTermKeys[$x][1])>0) {
            array_walk($arrayIolPostTaxoTermKeys[$x][0], 'translatedWPTermsIOL', 'taxo-name');
            array_walk($arrayIolPostTaxoTermKeys[$x][1], 'translatedWPTermsIOLScaffold', 'taxo-value-name');
            $arrayIolPostTaxoTermKeys[$x] = array(_x($arrayIolPostTaxoTermKeys[$x][0], 'taxo-name', 'iol'), $arrayIolPostTaxoTermKeys[$x][1]);

            wp_set_object_terms($post_id, $arrayIolPostTaxoTermKeys[$x][1], $arrayIolPostTaxoTermKeys[$x][0]);
        }
    }
}


function updatePostMetadataFromArrayMetadata($arrayMetadata, $post_id)
{
    $lengthMeta =  count($arrayMetadata);
    for ($x=0; $x<$lengthMeta; $x++) {
        update_post_meta($post_id, $arrayMetadata[$x][0], $arrayMetadata[$x][1]);
    }
}




function addAttachMentToPostInSyncSave($attachement_id, $image_url, $post_id_destino)
{
    $postAttached = get_post($attachement_id);

    if ($postAttached->post_type == 'dumb-cpt') {
        wp_delete_post($attachement_id, true);
    }

    if ($postAttached->post_type == 'attachment') {
        wp_delete_attachment($attachement_id, true);
    }


    /*...... BEGIN FILE DETECT .......*/
    $upload_dir = wp_upload_dir(); // Set upload folder
    $arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);
    $image_data = file_get_contents($image_url, false, stream_context_create($arrContextOptions)); // Get image data
       $filename   = basename($image_url); // Create image file name

       // Check folder permission and define file location
    if (wp_mkdir_p($upload_dir['path'])) {
        $file = $upload_dir['path'] . '/' . $filename;
    } else {
        $file = $upload_dir['basedir'] . '/' . $filename;
    }

    // Create the image  file on the server
    file_put_contents($file, $image_data);

    // Check image file type
    $wp_filetype = wp_check_filetype($filename, null);

    // Set attachment data
    $attachment = array(
                            'post_mime_type' => $wp_filetype['type'],
                            'post_title'     => sanitize_file_name($filename),
                            'post_content'   => '',
                            'post_status'    => 'inherit',
                            'import_id'      => $attachement_id
                            );

    // Create the attachment
    //Creo que he creado una referencia recursiva.
    //////
    remove_action('add_attachment', 'sync_save_postdata', 98);
    remove_action('edit_attachment', 'sync_save_postdata', 97);
    //////
    $attach_id = wp_insert_attachment($attachment, $file, $post_id_destino);//$post_id


    // Include image.php
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    // Define attachment metadata
    $attach_data = wp_generate_attachment_metadata($attach_id, $file);

    // Assign metadata to attachment
    wp_update_attachment_metadata($attach_id, $attach_data);

    // And finally assign featured image to post
    set_post_thumbnail($post_id_destino, $attach_id); /*$post_id $inserted_post_id*/
    ////////////////////
    add_action('add_attachment', 'sync_save_postdata', 98);
    add_action('edit_attachment', 'sync_save_postdata', 97);
    ///////////////////

        /*...... END FILE DETECT .......*/
}
