<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VDeviceStatus_Model extends Model
{
    protected $connection = 'mysql_cloud';
    protected $table = 'vdevice_status';
    protected $primaryKey = 'gprsID';
    public $timestamps = false;
}
