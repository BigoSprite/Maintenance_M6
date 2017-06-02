<?php

namespace App\Models\Node;

use Illuminate\Database\Eloquent\Model;

class VDeviceInfoModel extends Model
{
    protected $connection = 'mysql_cloud_node';

    protected $table = 'vdevice_info';
    public $timestamps = false;
    protected $fillable = ['*'];
}
