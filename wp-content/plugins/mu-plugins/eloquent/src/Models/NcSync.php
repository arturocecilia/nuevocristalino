<?php // File location: /wp-content/themes/my-theme/src/Models/
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class NcSync extends Eloquent
{
    protected $table = 'nc_sync';
    protected $primaryId = 'id';
}
