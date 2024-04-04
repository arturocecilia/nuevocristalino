<?php

use App\Models\NcSync;

include('nc-utils-sync-functions.php');


function sync_save_postdata($post_id)
{
    global $ncWPSites;
    global $locale;
    global $switched;
    global $wpdb;


    $currentLanguage = get_locale();
    $post = get_post($post_id);


    //Sólo hacemos sync en los siguientes custom post types.
    $cptKey =   getCptKey($post);



    if (!in_array($cptKey, ['lente-intraocular','fabricante','opinion-doctor','page','post','email-content'])) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    //Cambio para evitar deficiencias de sincronizcación.
    if ($post->post_status == 'trash' or $post->post_status == 'auto-draft') {
        return $post_id;
    }

    // Check the user's permissions.
    if ('page' == $_POST['post_type']) {
        if (! current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } else {
        if (! current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }




    $ncsyncid = syncTranslationStatusFromPost($locale, $post_id, $_POST);
    $attachement_id = get_post_thumbnail_id($post_id);
    $image_url = wp_get_attachment_image_src($attachement_id, 'full')[0];

    $postBasicData = array(
                                        'import_id'     =>     $post->ID,
                                        'post_title'    =>     $post->post_title,
                                        'post_content'  =>     $post->post_content,
                                        'post_excerpt'  =>     $post->post_excerpt
                                      );

    if ($cptKey == 'lente-intraocular') {
        $arrayIolPostTaxoTermKeys = loadArrayIolPostTaxonomyTermsKeys($post);
        $arrayMetadata = loadArrayMetadata($post);
    }

    //$ncWPSitesCopy = $ncWPSites;
    $ncWPSitesCopy = getncWPSitesCopy();
    //Antes de nada si la casilla de delete tiene un 111 se borra el post.

    if ($_POST['delete'] == '111') {
        ncdeletepost($post);
        return;
    }

    unset($ncWPSitesCopy[$currentLanguage]);


    foreach ($ncWPSitesCopy as $key=>$value) {
        switch_to_blog($value);

        $locale = $key;
        $textDomains = ['iol','iol-scaffold','opinion-doctor','fabricante' ];

        foreach ($textDomains as $textDomain) {
            unload_textdomain($textDomain);
            load_plugin_textdomain($textDomain, false, 'nc-sync/languages');
        }

        $postBasicData['post_type'] = _x($cptKey, 'CustomPostType Name', getDomainFromCptKey($cptKey));

        //echo $locale.' : '._x($cptKey, 'CustomPostType Name', getDomainFromCptKey($cptKey)).'<BR />';

        $ncsyncsaved =   NcSync::where($currentLanguage, $post_id)
                                           ->first()->{$locale};

        if (is_null($ncsyncsaved)) {
            $post_id_destino = insertPostInSyncSave($postBasicData, $ncsyncid, $locale, true);
        } else {
            $post_id_destino = $ncsyncsaved;
        }

        //Cargamos los "contenidos" [4,7], Carga sin localización.
        if (in_array($_POST[$value.'_'.$key], [4,7])) {
            updatePostInSyncSave($postBasicData);
        }
        //Cargamos las taxonomías [1,3,6,7]
        if (in_array($_POST[$value.'_'.$key], [1,3,6,7])) {
            if ($cptKey == 'lente-intraocular') {
                create_iol_taxonomies();
                updateIolPostTaxonomiesFromTaxoTermKeys($arrayIolPostTaxoTermKeys, $post_id_destino);
            }
        }

        //Cargamos los metadatos [2,3,6,7]--> Esta carga es directa: Sin pasar por localización.
        if (in_array($_POST[$value.'_'.$key], [2,3,6,7])) {
            if ($cptKey == 'lente-intraocular') {
                updatePostMetadataFromArrayMetadata($arrayMetadata, $post_id_destino)  ;
            }
        }
        //Cargamos la featured image si se requiere [5,6,7]
        if (in_array($_POST[$value.'_'.$key], [5, 6, 7])) {
            addAttachMentToPostInSyncSave($attachement_id, $image_url, $post_id_destino);
        }



        restore_current_blog();
    }





    unload_textdomain('iol');
    unload_textdomain('iol-scaffold');
    $locale = 'es_ES';//?? será el que toque no ?? DUDA//$currentLanguage;
    load_plugin_textdomain('iol', false, 'nc-sync/languages');
    load_plugin_textdomain('iol-scaffold', false, 'nc-sync/languages');

    //echo 'Todo restituido: '._x('lente-intraocular','CustomPostType Name','iol')._x('fabricante','CustomPostType Name','fabricante');



    /* FIN LÓGICA DE PROPAGACIÓN */
}
