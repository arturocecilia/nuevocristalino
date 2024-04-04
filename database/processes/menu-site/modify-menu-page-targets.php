<?php

global $wpdb;

$sites = get_sites();


$oldPagesToNewPagesIds = array(
                            '13725' => 12644
                              );

foreach ($sites as $site) {
    switch_to_blog($site->blog_id);

    foreach ($oldPagesToNewPagesIds as $oldPageId => $newPageId) {
        $oldPageId = (int)$oldPageId;
        $sql = 'UPDATE '.$wpdb->postmeta.' SET meta_value='.$newPageId.' WHERE key_col='.$oldPageId;
        $wpdb->query($sql);
    }
}

$OldPagesToNewPagesMenuTitles = array(
      'es_ES' => array('3 - Tu Área Personal' => 'Tus Datos de Perfil'),
      'es_MX' => array('3 - Tu Área Personal' => 'Tus Datos de Perfil'),
      'es_CL' => array('3 - Tu Área Personal' => 'Tus Datos de Perfil'),
      'es_CO' => array('3 - Tu Área Personal' => 'Tus Datos de Perfil'),
);
