<?php

namespace App\ModelCenter;

use Illuminate\Database\Eloquent\Model;

class GmDevice_Status_Model extends Model
{
    protected $connection = 'mysql_cloud';
    protected $table = 'gmdevice_status';
    protected $primaryKey = 'gprsID';
    public $timestamps = false;
}
