<?php

namespace App\ModelCenter;

use Illuminate\Database\Eloquent\Model;

class GmDevice_Information_Model extends Model
{
    protected $connection = 'mysql_cloud';// config/database.php/'connections'['mysql_cloud']
    protected $table = 'gmdevice_info';
    protected $primaryKey = 'gprsID';
    public $timestamps = false;
}
