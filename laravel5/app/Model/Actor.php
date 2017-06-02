<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Actor extends Model
{
    protected $connection = 'mysql_cloud';
    protected $table = 'actor_info';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['id', 'name'];
}
