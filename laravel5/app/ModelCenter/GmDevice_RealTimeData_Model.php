<?php

namespace App\ModelCenter;

use Illuminate\Database\Eloquent\Model;

class GmDevice_RealTimeData_Model extends Model
{
    protected $connection = 'mysql_cloud';
    protected $table = 'gmdevice_realtimedata';
    protected $primaryKey = 'gprsID';
    public $timestamps = false;
}
