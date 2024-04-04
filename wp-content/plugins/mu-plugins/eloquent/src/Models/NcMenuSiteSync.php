<?php // File location: /wp-content/themes/my-theme/src/Models/
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class NcMenuSiteSync extends Eloquent
{
    protected $table = 'nc_menu_site_sync';
    protected $primaryId = 'id';
}
