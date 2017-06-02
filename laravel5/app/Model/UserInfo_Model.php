<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserInfo_Model extends Model
{
    protected $connection = 'mysql_cloud';
    protected $table = 'userinfo';
    protected $primaryKey = 'userName';
    public $timestamps = false;
}
