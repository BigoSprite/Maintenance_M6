<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VDeviceInfo_Model extends Model
{
    protected $connection = 'mysql_cloud';// config/database.php/'connections'['mysql_cloud']
    protected $table = 'vdevice_info';
    protected $primaryKey = 'gprsID';
    public $timestamps = false;
}
