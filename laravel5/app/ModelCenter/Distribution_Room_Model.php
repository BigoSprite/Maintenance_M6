<?php

namespace App\ModelCenter;

use Illuminate\Database\Eloquent\Model;

class Distribution_Room_Model extends Model
{
    protected $connection = 'mysql';
    protected $table = 'distributionroom';
    protected $primaryKey = 'serialId';
    public $timestamps = false;
}
