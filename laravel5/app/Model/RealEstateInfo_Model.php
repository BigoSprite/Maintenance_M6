<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;

class RealEstateInfo_Model extends Model
{
    protected $connection = 'mysql_cloud';
    protected $table = 'realestateinfo';
    public $timestamps = false;
}
