<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VDeviceRealTimeData_Model extends Model
{
    protected $connection = 'mysql_cloud';
    protected $table = 'vdevice_realtimedata';
    protected $primaryKey = 'gprsID';
    public $timestamps = false;
}
