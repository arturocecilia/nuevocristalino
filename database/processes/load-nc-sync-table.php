<?php

require '../wp-content/plugins/mu-plugins/eloquent.php';
require '../wp-load.php';

use App\Models\NcSync;
use \Illuminate\Database\Capsule\Manager as Capsule;

//

$cptTypesToSync = ['lente-intraocular','page','fabricante','post'];

$cptsToSync = Capsule::table('wp_posts')
                      ->whereIn('post_type', $cptTypesToSync)
                      ->get();

$site_keys = [
                //'es_ES',
                'es_MX',
                'es_CL',
                'es_CO',
                'en_GB',
                'en_US',
                'de_DE',
                'de_AT',
                'fr_FR'
              ];


foreach ($cptsToSync as $cpt) {
    $ncsync = new NcSync();

    $ncsync->post_type = $cpt->post_type;
    $ncsync->es_ES = $cpt->ID;
    $ncsync->es_ES_status = 1;

    foreach ($site_keys as $site_key) {
        $ncsync->{$site_key} = $cpt->ID;
        $ncsync->{$site_key.'_status'} = 1;
    }

    $ncsync->save();
}
