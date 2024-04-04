<?php


global $wpdb;

$pageToDeleteIds = array(
                  /*-- MOVED TO PROMS --*/

                  12628,//Información Preoperatoria
                  12629,//Información Postoperatoria
                  15231,//Seleccionar visualización de encuestas realizadas
                  14302,//Seleccionar visualización de mis resultados
                  15228,//Visualización de mis resultados
                  15206,//Visualización de resultados globales
                  15229,//Visualización encuestas realizadas

                  15364,//ENCUESTA DE SATISFACCIÓN TRAS LA OPERACIÓN DE CATARATAS (SIN REGISTRO)
                  15371,//ENCUESTA DE SATISFACCIÓN TRAS EXTRACCIÓN DE CRISTALINO SIN CATARATA (SIN REGISTRO)
                  15382,//ENCUESTA DE SATISFACCIÓN TRAS OPERACIÓN CON LENTE ICL (SIN REGISTRO)
                  15383,//ENCUESTA DE SATISFACCIÓN TRAS CIRUGÍA CON LÁSER CORNEAL: LASIK,PRK, RELEX.. (SIN REGISTRO


                  14667,//Satisfacción con la operación de cataratas Catquest-9sf
                  15223,//Satisfacción tras operación CLE- NAVQ-10
                  13725,//Área privada en NuevoCristalino
                  /*-- PERMANENTLY DELETED --*/
                  10832,//Mi Actividad en NuevoCristalino
                  13171,//Mis conocimientos
                  13168,//Mis contenidos de interés
                  13152,//Mi lente Intraocular
);

$sites = get_sites();


foreach ($sites as $site) {
    switch_to_blog($site->blog_id);

    //Borro primero los items de menus que apuntan a esas págians.

    $sql = 'SELECT post_id
        FROM '.$wpdb->postmeta.'
        where meta_key = "_menu_item_object_id"
            and meta_value IN ('.join(',', $pageToDeleteIds).')';

    $postMenuItemsIds = $wpdb->get_col($sql);

    $postsToDelete = array_merge($postMenuItemsIds, $pageToDeleteIds);


    $sql = 'DELETE a,b,c
                FROM '.$wpdb->posts.' a
                LEFT JOIN '.$wpdb->term_relationships.' b
                    ON (a.ID = b.object_id)
                LEFT JOIN '.$wpdb->postmeta.' c
                    ON (a.ID = c.post_id)
                WHERE a.ID IN ('.join(',', $postsToDelete).')';
    echo 'ejecutando: '.PHP_EOL.$sql.PHP_EOL;
    $wpdb->query($sql);
}
