<?php

namespace App\ModelCenter;

use Illuminate\Database\Eloquent\Model;

class RealEstate_Information_Model extends Model
{
    protected $connection = 'mysql_cloud';
    protected $table = 'realestateinfo';
    public $timestamps = false;
}
