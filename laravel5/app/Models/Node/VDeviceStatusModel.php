<?php

namespace App\Models\Node;

use Illuminate\Database\Eloquent\Model;

class VDeviceStatusModel extends Model
{
    protected $connection = 'mysql_cloud_node';

    protected $table = 'vdevice_status';
    public $timestamps = false;
    protected $fillable = ['*'];
}
