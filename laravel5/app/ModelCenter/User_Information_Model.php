<?php

namespace App\ModelCenter;

use Illuminate\Database\Eloquent\Model;

class User_Information_Model extends Model
{
    protected $connection = 'mysql_cloud';
    protected $table = 'userinfo';
    protected $primaryKey = 'userName';
    public $timestamps = false;
}
