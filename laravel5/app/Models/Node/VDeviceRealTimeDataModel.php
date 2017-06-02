<?php

namespace App\Models\Node;

use Illuminate\Database\Eloquent\Model;

class VDeviceRealTimeDataModel extends Model
{
    protected $connection = 'mysql_cloud_node';

    protected $table = 'vdevice_realtimedata';
    public $timestamps = false;
    protected $fillable = ['*'];
}
