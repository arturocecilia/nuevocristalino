<?php // File location: /wp-content/themes/my-theme/src/Models/
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class NcSiteGroup extends Eloquent
{
    protected $table = 'nc_sites_groups';
    protected $primaryId = 'id';
}
