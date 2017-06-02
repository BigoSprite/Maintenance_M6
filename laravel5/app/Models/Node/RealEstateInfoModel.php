<?php

namespace App\Models\Node;

use Illuminate\Database\Eloquent\Model;

class RealEstateInfoModel extends Model
{
    protected $connection = 'mysql_cloud_node';

    protected $table = 'realestateinfo';
    public $timestamps = false;
    protected $fillable = ['*'];
}
