<?php

namespace App\Models\Node;

use Illuminate\Database\Eloquent\Model;

class VDeviceNodeInfoModel extends Model
{
    protected $connection = 'mysql_cloud_node';

    protected $table = 'vdevice_node_info';
    public $timestamps = false;
    protected $fillable = ['*'];
}
