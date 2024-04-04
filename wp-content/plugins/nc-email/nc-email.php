<?php
/*
Plugin Name: NC Email
Plugin URI: http://www.andomed.com/
Description: Declares a plugin that will contain code for the emails.
Version: 1.0
Author: Arturo Cecilia
Author URI: http://www.andomed.com/
License: GPLv2
*/



function create_email_content()
{
    register_post_type(
        'email-content',
        array(
            'labels' => array(
                'name' => 'Contenido Email',
                'singular_name' => _x('Contenido Email', 'admin_display', 'nc-email-content'),
                'add_new' => _x('Añadir Contenido Email', 'admin_display', 'nc-email-content'),
                'add_new_item' => _x('Añadir Nuevo Contenido Email', 'admin_display', 'nc-email-content'),
                'edit' => _x('Editar', 'admin_display', 'nc-email-content'),
                'edit_item' => _x('Editar Contenido Email', 'admin_display', 'nc-email-content'),
                'new_item' => _x('Nuevo Contenido Email', 'admin_display', 'nc-email-content'),
                'view' => _x('Ver', 'admin_display', 'nc-email-content'),
                'view_item' => _x('Ver Contenido Email', 'admin_display', 'nc-email-content'),
                'search_items' => _x('Buscar Contenido Email', 'admin_display', 'nc-email-content'),
                'not_found' => _x('No se ha encontrado ningún Contenido Email', 'admin_display', 'nc-email-content'),
                'not_found_in_trash' => _x('No hay Contenidos Email en la papelera', 'admin_display', 'nc-email-content'),
                'parent' => _x('Contenido Email Padre', 'admin_display', 'nc-email-content'),
                'has_archive'=> false
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
            'rewrite' => array("slug" => 'email-content'), // /%tipo%/%fabricante%/%toricidad%/%adicion%/%filtros% Permalinks format
            'menu_position' => 6,
            'supports' => array( 'title','editor','thumbnail','excerpt' ),
            'taxonomies' => array( '' ),
            'menu_icon' => plugins_url('images/image.png', __FILE__),
            'how_in_nav_menus'=>true
        )
    );
    //flush_rewrite_rules();
}
add_action('init', 'create_email_content');
