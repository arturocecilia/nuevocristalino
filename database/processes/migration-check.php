<?php

require ABSPATH.'/wp-content/plugins/mu-plugins/eloquent.php';
require ABSPATH.'/wp-load.php';
//Voy a aprovechar que el capsule lo tengo apuntando a donde quiera mientras que el
//wp me viene de wp-config: wp config a la pre-migration capsule a la nueva.

global $wpdb;


//STEP 1 -> Carga de URLs INI.
$urlsAlreadyLoaded = true;

if (!$urlsAlreadyLoaded) {
    $sites  = get_sites();
    foreach ($sites as $site) {
        switch_to_blog($site->blog_id);

        if (!in_array($site->blog_id, [1,2,3,4,5,6,7,8,9])) {//
            continue;
        }

        $post_types = [
                   'lente-intraocular',
                   'clinica',
                   'proveedor',
                   'fabricante',
                   'opinion-doctor',
                   'post',
                   'page',
                   'intraocular-lens',
                   'intraokularlinse',
                   'implant-intraoculaire',
                   'manufacturer',
                   'hersteller',
                   'fabricant',
                   'doctor-review',
                   'meinung-arzt',
                   'opinion-medecin',
                   'supplier',
                   'anbieter',
                   'distributeur',
                   //me faltaban:
                   'question',
                   'forum',
                   'reply',
                   'topic'
                 ];

        $query = 'SELECT * from '.$wpdb->posts.'
              WHERE post_type in ("'.join('","', $post_types).'")
              AND post_status = "publish"';

        $results = $wpdb->get_results($query);


        foreach ($results as $post) {
            $check = [];
            $check['url'] = get_permalink($post->ID);
            $check['post_id'] = $post->ID;
            $check['blog_id'] = $site->blog_id;
            $check['post_type'] = $post->post_type;
            $status_code = shell_exec('curl -o -I -L -s -w "%{http_code}" '.$check["url"]);
            $check['status_code_ini'] = $status_code;
            $capsule->table('nc_migration_check')
                ->insert($check);

            echo 'ID: '.$post->ID.': '.$status_code.PHP_EOL;
        }
    }
}


//A continuación la parte del chequeo ya en la migrated.



  $posts_checks = $capsule->table('nc_migration_check')
                          ->whereIn('blog_id', [1,2,3,4,5,6,7,8,9])//1,2,3,4,5,6,7,8,9
                          ->get();

  foreach ($posts_checks as $post_check) {
      $status_code_target = shell_exec('curl -o -I -L -s -w "%{http_code}" '.$post_check->url);
      echo 'ID: '.$post_check->id.': '.$status_code_target.PHP_EOL;

      $capsule->table('nc_migration_check')
                ->where('id', $post_check->id)
                ->update(['status_code_target' => $status_code_target]);
  }
