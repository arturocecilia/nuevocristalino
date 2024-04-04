<?php
/*
Plugin Name: nc-sync
Plugin URI: http://lente-intraocular.com/
Description: Declares a plugin that will add the needed functions to ensure sync among sites.
Version: 1.0
Author: Arturo Cecilia
Author URI: http://www.andomed.com/
License: GPLv2
*/

use App\Models\NcSync;

include('nc-sync-save-post.php');
include('nc-sync-info-action-translation.php');
include('nc-sync-mo-files-generator.php');

add_action('save_post', 'sync_save_postdata', 99);
//add_action('add_attachment', 'sync_save_postdata', 98);
//add_action('edit_attachment', 'sync_save_postdata', 97);
add_action('edit_form_after_title', 'myprefix_edit_form_after_title');
add_action('edit_form_after_editor', 'syncPropaga_form_after_editor');
add_action('add_meta_boxes', 'sync_add_custom_box');

// always find line endings
ini_set('auto_detect_line_endings', true);
add_action('admin_menu', 'ncMOSiteGenerator_Menu');





function sync_add_custom_box()
{
    $screens = array(
                      'post',
                      'page',
                   _x('lente-intraocular', 'CustomPostType Name', 'iol'),
                   _x('fabricante', 'CustomPostType Name', 'fabricante'),
                   _x('opinion-doctor', 'CustomPostType Name', 'opinion-doctor'),
                    );

    foreach ($screens as $screen) {
        add_meta_box(
            'sync_sectionid',
            __('Traducciones', 'addmin_Template'),
            'sync_translation_status',
            $screen,
            'advanced',
            'core'
        );
    }
}
